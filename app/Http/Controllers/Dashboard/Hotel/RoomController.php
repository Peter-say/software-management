<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\StatusConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\RoomType;
use App\Models\User;
use App\Services\Dashboard\Hotel\Room\RoomService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    protected $room_service;
    public function __construct(RoomService $room_service)
    {
        $this->room_service = $room_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.hotel.room.index', [
            'rooms' => Room::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->latest()->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.room.create', [
            'room_types' => RoomType::all(),
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
            return redirect()->route('dashboard.hotel.rooms.index')->with('success_message', 'Room created successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while creating the room.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.hotel.room.create', [
            'room_types' => RoomType::all(),
            'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
            'room' => Room::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        try {
            $this->room_service->save($request, $data);
            return redirect()->route('dashboard.hotel.rooms.index')->with('success_message', 'Room updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while creating the room.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);
        $room->delete();
        return redirect()->route('dashboard.hotel.rooms.index')->with('success_message', 'Room deleted successfully');
    }

    public function filterRoom(Request $request)
    {
        dd($request->all());
        $selection = $request->input('select_room', 'Newest');
        $search = $request->input('search_term');

        $rooms = Room::with('roomType')->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
        if ($search) {
            $rooms = $rooms->searchRooms($search);
        }
        if ($selection === 'Newest') {
            $rooms = $rooms->latest();
        } elseif ($selection === 'Oldest') {
            $rooms = $rooms->orderBy('created_at', 'asc');
        } elseif ($selection === 'Available') {
            $rooms = $this->room_service->availableRooms();
        } elseif ($selection === 'Occupied') {
            $rooms = $this->room_service->occupiedRooms();
        }
        // dd($rooms->paginate(30));
        $rooms = $rooms->paginate(30);
        return response()->json([
            'html' => view('dashboard.hotel.search.room-filter', compact('rooms'))->render()
        ]);
    }
}
