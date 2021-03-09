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
        return Event::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date_start = new \DateTime($request->date_start);
        $date_start->setTimeZone(new \DateTimeZone(config('app.timezone')));
        $date_start->format('YYYY-MM-DD hh:mm:ss');

        $date_end = new \DateTime($request->date_end);
        $date_end->setTimeZone(new \DateTimeZone(config('app.timezone')));
        $date_end->format('YYYY-MM-DD hh:mm:ss');

        $event = new Event;
        $event->user_id = $request->user_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->date_start = $date_start;
        $event->date_end = $date_end;
        $event->save();

        $kelasId = collect($request->kelas_id);
        $event->event_kelas()->attach($kelasId);

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
        return Event::find($id);
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
        return Event::find($id)->event_kelas;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $date_start = new \DateTime($request->date_start);
        $date_start->setTimeZone(new \DateTimeZone(config('app.timezone')));
        $date_start->format('YYYY-MM-DD hh:mm:ss');

        $date_end = new \DateTime($request->date_end);
        $date_end->setTimeZone(new \DateTimeZone(config('app.timezone')));
        $date_end->format('YYYY-MM-DD hh:mm:ss');

        $event = Event::find($id);
        $event->user_id = $request->user_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->date_start = $date_start;
        $event->date_end = $date_end;
        $event->save();

        $kelasId = collect($request->kelas_id);
        $event->event_kelas()->sync($kelasId);

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
