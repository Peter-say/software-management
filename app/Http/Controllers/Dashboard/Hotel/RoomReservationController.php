<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\AppConstants;
use App\Constants\StatusConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\User;
use App\Services\Dashboard\Hotel\Room\ReservationService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoomReservationController extends Controller
{
    protected $reservation_service;
    public function __construct(ReservationService $reservation_service)
    {
        $this->reservation_service = $reservation_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.hotel.room.reservation.list', [
            'reservations' => RoomReservation::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.room.reservation.create', [
            'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
            'titleOptions' => AppConstants::TITLE_OPTIONS,
            'reservation' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $reservation = $this->reservation_service->save($request, $data);
            return response()->json([
                'success' => true,
                'redirectUrl' => route('dashboard.hotel.reservations.index'),
                'success_message' => 'Reservation created successfully.',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'error_message' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error_message' => 'An error occurred while creating the reservation.',
            ]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.hotel.room.reservation.create', [
            'reservation' => $this->reservation_service->getById($id),
            'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
            'titleOptions' => AppConstants::TITLE_OPTIONS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        try {
            $reservation = $this->reservation_service->save($request, $data);
            return response()->json([
                'success' => true,
                'redirectUrl' => route('dashboard.hotel.reservations.index'),
                'success_message' => 'Reservation updated successfully.',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'error_message' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error_message' => 'An error occurred while creating the reservation.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->reservation_service->delete($id);
            return redirect()->route('dashboard.hotel.reservations.index')->with('success_message', 'reservation deleted successfully and login details sent.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Reservation not found.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            // throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while deleting the reservation.');
        }
    }

    public function getRoomAvailability(Request $request)
    {
        dd($request->all());
        $checkinDate = $request->input('checkin_date');
        $checkoutDate = $request->input('checkout_date');
    
        try {
            $isAvailable = $this->reservation_service->checkRoomAvailability($checkinDate, $checkoutDate);
            return response()->json(['success' => true, 'available' => $isAvailable]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'error_message' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error_message' => 'An error occurred while checking room availability.',
            ]);
        }
    }
    
}
