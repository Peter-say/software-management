<?php

namespace App\Services\Dashboard\Hotel\Room;

use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\User;
use App\Services\Dashboard\Hotel\Guest\GuestService;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ReservationService
{
    protected $guest_service;

    public function __construct(GuestService $guest_service)
    {
        $this->guest_service = $guest_service;
    }

    public function getById($id)
    {
        $reservation = RoomReservation::find($id);
        if (empty($reservation)) {
            throw new ModelNotFoundException("Reservation not found");
        }
        return $reservation;
    }

    public function validatedData($data)
    {
        $validator = Validator::make($data, [
            'room_id' => 'required|exists:rooms,id',
            'rate' => 'required|numeric|min:0',
            'checkin_date' => 'required|before_or_equal:checkout_date',
            'checkout_date' => 'required|after_or_equal:checkin_date',
            'status' => 'nullable|string|in:Active,Inactive',
            'reservation_code' => 'nullable|string|max:255|unique:reservations,reservation_code,' . ($data['reservation_id'] ?? 'null'),
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        return $validated;
    }

    public function save(Request $request, $reservation_id = null)
    {
        return DB::transaction(function () use ($request, $reservation_id) {
            $validatedData = $this->validatedData($request->all(), $reservation_id);

            // Calculate the total price
            $checkinDate = new DateTime($validatedData['checkin_date']);
            $checkoutDate = new DateTime($validatedData['checkout_date']);
            $duration = $checkoutDate->diff($checkinDate)->days; // Ensures that even if the check-in and check-out dates are the same, the duration will be at least 1 day.
            $rate = $validatedData['rate'];
            $validatedData['total_amount'] = $rate * $duration;

            $user = User::getAuthenticatedUser();
            $validatedData['hotel_id'] = $user->hotel->id;
            $validatedData['user_id'] = $user->id;
            $validatedData['reservation_code'] = $this->generateReservationCode();
            // Check if a guest ID is provided, otherwise save the guest
            if ($request->guest_id) {
                $validatedData['guest_id'] = $request->guest_id;
            } else {
                $guest = $this->guest_service->saveGuest($request);
                $validatedData['guest_id'] = $guest->id;
            }

            // Check if updating an existing reservation or creating a new one
            if ($reservation_id = $request->reservation_id) {
                $room_reservation = $this->getById($reservation_id);
                if ($room_reservation->checked_out_at) {
                    throw ValidationException::withMessages([
                        'reservation' => 'Cannot update this reservation because guest has already checked out'
                    ]);
                }
                $room_reservation->update($validatedData);
                return 'Reservation updated successfully';
            } else {
                $room_reservation = RoomReservation::create($validatedData);
                return 'Reservation created successfully';
            }
            return $room_reservation;
        });
    }

    public function checkInGuest($reservation_id)
    {
        $reservation = $this->getById($reservation_id);
        $reservation_payment = ($reservation->payments() ?? collect())->sum('amount');

        // Ensure that at least 90% of the payment is completed before checking in
        if ($reservation_payment < $reservation->total_amount * 0.9) {
            throw ValidationException::withMessages([
                'payment_status' => 'Cannot check guest in because their payment has not reached 90% of the total amount.'
            ]);
        }
        if ($reservation->checked_in_at) {
            throw ValidationException::withMessages([
                'checked_in_at' => 'Already checked in'
            ]);
        }
        $reservation->update([
            'checked_in_at' => now(),
            'status' => 'occupied',
        ]);
        $reservation->refresh();
        return 'Guest checked in successfully';
    }

    public function checkOutGuest($reservation_id)
    {
        $reservation = $this->getById($reservation_id);
        $reservation_payment = ($reservation->payments() ?? collect())->sum('amount');
        if (!$reservation->checked_in_at) {
            throw ValidationException::withMessages([
                'checked_in_at' => 'Cannot checkout guest when you have not checked them in'
            ]);
        }
        // Ensure that payment is completed before checking out
        if ($reservation->total_amount > $reservation_payment) {
            throw ValidationException::withMessages([
                'payment_status' => 'Cannot check guest out because their payment has not been completed'
            ]);
        }

        // Update the reservation status and checkout time
        $reservation->update([
            'checked_out_at' => now(),
            'status' => 'confirmed',
        ]);
        $reservation->refresh();
        return 'Guest checked out successfully';
    }


    private function generateReservationCode()
    {
        $prefix = 'RES';
        $randomString = strtoupper(mt_rand(0, 999999999)); // Generates a 10 digit
        do {
            $code = $prefix . '_' . $randomString;
        } while (RoomReservation::where('reservation_code', $code)->exists());

        return $code;
    }

    public function delete($id)
    {
        $reservation = $this->getById($id);
        $reservation->delete();
    }

    public function checkRoomAvailability(Request $request)
    {
        try {
            $checkinDate = $request->checkin_date ? Carbon::parse($request->checkin_date)->format('Y-m-d') : null;
            $checkoutDate = $request->checkin_date ? Carbon::parse($request->checkout_date)->format('Y-m-d') : null;

            if ($checkinDate && $checkoutDate) {
                // Filter rooms that are not reserved within the given date range
                $availableRooms = Room::with('roomType')->where('hotel_id', User::getAuthenticatedUser()->hotel->id)->whereDoesntHave('reservations', function ($query) use ($checkinDate, $checkoutDate) {
                    $query->whereNull('checked_out_at')->where(function ($subQuery) use ($checkinDate, $checkoutDate) {
                        $subQuery->where('checkin_date', '<', $checkoutDate)
                            ->where('checkout_date', '>', $checkinDate);
                    });
                })->get();
            } else {
                // Return all rooms if no check-in and check-out dates are provided
                $availableRooms = Room::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get();;
            }
            return response()->json(['rooms' => $availableRooms]);
        } catch (\Exception $e) {
            Log::error('Error in room availability check: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while checking room availability.'
            ], 500);
        }
    }
}
