<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\AppConstants;
use App\Constants\StatusConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelPaymentPlatform;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\User;
use App\Services\Dashboard\Hotel\Chart\DashboardReservationService;
use App\Services\Dashboard\Hotel\Reservation\ReservationDashboardService;
use App\Services\Dashboard\Hotel\Room\ReservationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RoomReservationController extends Controller
{
    protected $reservation_service;
    protected $reservation_dashboard_service;
    protected $chart_reservation_service;
    public function __construct(ReservationService $reservation_service)
    {
        $this->reservation_service = $reservation_service;
        $this->chart_reservation_service = new DashboardReservationService();
        $this->reservation_dashboard_service = new ReservationDashboardService();
    }

    public function overview(Request $request)
    {
        $period = $request->get('period', 'day');
        $booking_period = $request->get('booking_period', 'week');
        $analytic_period = $request->get('analytic_period', 'week');

        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'month';
        }
        if (!in_array($analytic_period, ['day', 'week', 'month', 'year'])) {
            $analytic_period = 'month';
        }
        if (!in_array($booking_period, ['week', 'year'])) {
            $booking_period = 'week';
        }
        return view('dashboard.hotel.room.reservation.dashbaord', [
            'room_reservation_stats' => $this->reservation_dashboard_service->stats(['period' => $period]),
            'occupiedRooms' => $this->reservation_dashboard_service->countOccupiedRoomsToday(),
            'available_rooms' => $this->reservation_dashboard_service->countAvailableRoomsToday(),
            'total_transaction' => $this->reservation_dashboard_service->calculateTotalTransaction(),
            'reservation_analytic_data' => $this->chart_reservation_service->analytics(['analytic_period' => $analytic_period]),
            'reservation_data' => $this->chart_reservation_service->stats(['booking_period' => $booking_period]),
            'recent_room_reservations' => $this->reservation_dashboard_service->recentBookingSchedule(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.hotel.room.reservation.list', [
            'reservations' => RoomReservation::with('guest.payments')->where('hotel_id', User::getAuthenticatedUser()->hotel->id)->latest()->paginate(30),
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
        try {
            $message = $this->reservation_service->save($request);
            if ($message === 'Reservation created successfully') {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'redirectUrl' => route('dashboard.hotel.reservations.index')
                ]);
            }
            // Handle other cases where the message indicates a problem
            return response()->json(['success' => false, 'message' => $message], 400);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            throw $e;
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the reservation.',
            ]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $reservation_code)
    {
        if (!empty($reservation_code)) {
            $reservation = RoomReservation::where('reservation_code', $reservation_code)->first();
        } else {
            return  redirect()->route('dashboard.hotel.reservations.index')->with('error_messag', 'Reservation not found');
        }
        return view('dashboard.hotel.room.reservation.single', [
            'reservation' => $reservation,
            // 'payment_platform' => HotelPaymentPlatform::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->first(),
        ]);
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
            $message = $this->reservation_service->save($request, $data);
            if ($message === 'Reservation updated successfully') {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'redirectUrl' => route('dashboard.hotel.reservations.index')
                ]);
            }
            // Handle other cases where the message indicates a problem
            return response()->json(['success' => false, 'message' => $message], 400);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // throw $e;
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the reservation.',
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
            return redirect()->route('dashboard.hotel.reservations.index')->with('success_message', 'reservation deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Reservation not found.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            // throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while deleting the reservation.');
        }
    }

    public function checkInGuest(string $id)
    {
        try {
            // Call the service method and get the result message
            $message = $this->reservation_service->checkInGuest($id);
            // Determine if the message indicates success
            if ($message === 'Guest checked in successfully') {
                return response()->json(['success' => true, 'message' => $message]);
            }
            // Handle other cases where the message indicates a problem
            return response()->json(['success' => false, 'message' => $message], 400);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while checking in the guest.'], 500);
        }
    }

    public function checkOutGuest(string $id)
    {
        try {
            // Call the service method and get the result message
            $message = $this->reservation_service->checkOutGuest($id);
            // Determine if the message indicates success
            if ($message === 'Guest checked out successfully') {
                return response()->json(['success' => true, 'message' => $message]);
            }
            // Handle other cases where the message indicates a problem
            return response()->json(['success' => false, 'message' => $message], 400);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while checking in the guest.'], 500);
        }
    }


    public function getRoomAvailability(Request $request)
    {
        try {
            // Call the service method to check room availability
            $response = $this->reservation_service->checkRoomAvailability($request);
            // Return the response from the checkRoomAvailability method
            return response()->json(['success' => true, 'available' => $response]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'error_message' => $e->errors()]);
        } catch (\Exception $e) {
            Log::error('Error in getRoomAvailability: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error_message' => 'An error occurred while checking room availability.',
            ]);
        }
    }

    public function loadRecentReservation(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $recent_room_reservations_ids = $this->reservation_dashboard_service->recentBookingSchedule()->pluck('id')->toArray();

        // Fetch the next set of reservations, excluding already loaded ones
        $new_reservations = RoomReservation::where('hotel_id', User::getAuthenticatedUser()->hotel->id)
            ->whereNotIn('id', $recent_room_reservations_ids)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest('created_at')->skip(($page - 1) * 2)
            ->take(2)
            ->get();
        // Check if there are more items to load
        $hasMore = RoomReservation::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->whereNotIn('id', $recent_room_reservations_ids)
            ->count() > $page * 2;

        if ($new_reservations->isEmpty()) {
            return response()->json(['html' => '', 'hasMore' => false]);
        }
        $html = view('dashboard.fragments.dashboard.load-more-booking-schedule', ['recent_room_reservations' => $new_reservations])->render();
        return response()->json(['html' => $html, 'hasMore' => $hasMore]);
    }
}
