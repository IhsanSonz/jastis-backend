<?php

namespace App\Http\Controllers;

use App\Models\EventComment;
use Illuminate\Http\Request;

class EventCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EventComment::with('users')->with('events')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new EventComment;
        $comment->user_id = $request->user_id;
        $comment->event_id = $request->event_id;
        $comment->data = $request->data;
        $comment->save();

        return response()->json([
            'data' => $comment,
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
        return EventComment::with('users')->with('events')->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser($id)
    {
        return EventComment::find($id)->users;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEvent($id)
    {
        return EventComment::find($id)->events;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = EventComment::find($id);
        $comment->user_id = $request->user_id;
        $comment->event_id = $request->event_id;
        $comment->data = $request->data;
        $comment->save();

        return response()->json([
            'data' => $comment,
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
        $comment = EventComment::find($id);
        $comment->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
