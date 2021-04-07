<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('kelas')->with('users')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $events,
        ]);
    }

    public function store(Request $request)
    {
        $event = new Event;
        $event->user_id = $request->user_id;
        $event->kelas_id = $request->kelas_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->save();

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $event,
        ]);
    }

    public function show($id)
    {
        $event = Event::with('kelas')->with('users')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $event,
        ]);
    }

    public function getOwner($id)
    {
        $users Event::find($id)->users;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $users,
        ]);
    }

    public function getKelas($id)
    {
        $kelas Event::find($id)->kelas;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $kelas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $event->user_id = $request->user_id;
        $event->kelas_id = $request->kelas_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->save();

        return response()->json([
            'success' => true,
            'message' => 'put/patch data success',
            'data' => $event,
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }
}
