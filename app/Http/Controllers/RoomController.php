<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller {

    public function index() {
        $rooms = Room::all();
        return view('admin-ruangan', compact('rooms'));
    }

    public function getRoomsApi() {
        $rooms = Room::all();
        // Datanya dikirim bentuk JSON (format standar aplikasi mobile)
        return response()->json($rooms);
    }
}