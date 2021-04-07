<?php

namespace App\Http\Controllers;

use App\Models\EventComment;
use Illuminate\Http\Request;

class EventCommentController extends Controller
{
    public function index()
    {
        $comment = EventComment::with('users')->with('events')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $comment,
        ]);
    }

    public function store(Request $request)
    {
        $comment = new EventComment;
        $comment->user_id = $request->user_id;
        $comment->event_id = $request->event_id;
        $comment->data = $request->data;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $comment,
        ]);
    }

    public function show($id)
    {
        $comment = EventComment::with('users')->with('events')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $comment,
        ]);
    }

    public function getUser($id)
    {
        $users = EventComment::find($id)->users;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $users,
        ]);
    }

    public function getEvent($id)
    {
        $event = EventComment::find($id)->events;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $event,
        ]);
    }

    public function update(Request $request, $id)
    {
        $comment = EventComment::find($id);
        $comment->user_id = $request->user_id;
        $comment->event_id = $request->event_id;
        $comment->data = $request->data;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'put/patch data success',
            'data' => $comment,
        ]);
    }

    public function destroy($id)
    {
        $comment = EventComment::find($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }
}
