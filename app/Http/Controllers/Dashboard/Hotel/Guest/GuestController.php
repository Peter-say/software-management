<?php

namespace App\Http\Controllers\Dashboard\Hotel\Guest;

use App\Constants\AppConstants;
use App\Constants\StatusConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Guest;
use App\Models\User;
use App\Services\Dashboard\Hotel\Guest\GuestService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    protected $guest_service;
    public function __construct(GuestService $guest_service)
    {
        $this->guest_service = $guest_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('dashboard.hotel.guest.index', [
            'guests' => $this->guest_service->list($request->all())->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.guest.create', [
            'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
            'titleOptions' => AppConstants::TITLE_OPTIONS,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->guest_service->saveGuest($request);
            return redirect()->route('dashboard.hotel.guests.index')->with('success_message', 'Guest created successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        try {
            return view('dashboard.hotel.guest.details', [
                'guest' => Guest::where('uuid', $uuid)->first(),
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Guest not found');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.hotel.guest.create', [
            'guest' => $this->guest_service->getById($id),
            'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
            'titleOptions' => AppConstants::TITLE_OPTIONS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->guest_service->saveGuest($request, $id);
            return redirect()->route('dashboard.hotel.guests.index')->with('success_message', 'Guest updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Guest not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $this->guest_service->delete($id);
            return redirect()->route('dashboard.hotel.guests.index')->with('success_message', 'Guest deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Guest not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    public function getGuestInfo(Request $request)
    {
        $id = $request->id;
        $guest = Guest::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->find($id);
        return response()->json($guest);
    }
}
