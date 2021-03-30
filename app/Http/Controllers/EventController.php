<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Event::with('kelas')->with('users')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event;
        $event->user_id = $request->user_id;
        $event->kelas_id = $request->kelas_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->save();

        return response()->json([
            'data' => $event,
            'message' => 'Data berhasil masuk'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Event::with('kelas')->with('users')->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOwner($id)
    {
        return Event::find($id)->users;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKelas($id)
    {
        return Event::find($id)->kelas;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $event->user_id = $request->user_id;
        $event->kelas_id = $request->kelas_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->save();

        return response()->json([
            'data' => $event,
            'message' => 'Data berhasil diubah'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
