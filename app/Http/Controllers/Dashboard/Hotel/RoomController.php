<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\StatusConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Room;
use App\Services\Dashboard\Hotel\Room\RoomService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    public $room_service;
    protected function __construct(RoomService $room_service) {
        $this->room_service = $room_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.hotel.room.index', [
            'rooms' => Room::where('hotel_id', auth()->user->hotel_id)->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.room.create', [
            'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
          $this->room_service->save($request, $data);
            return redirect()->route('dashboard.hotel.room.index')->with('success_message', 'Room created successfully and login details sent.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred while creating the room.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
