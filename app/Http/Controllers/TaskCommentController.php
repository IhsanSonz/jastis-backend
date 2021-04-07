<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    public function index()
    {
        $comment = TaskComment::with('users')->with('tasks')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $comment,
        ]);
    }

    public function store(Request $request)
    {
        $comment = new TaskComment;
        $comment->user_id = $request->user_id;
        $comment->task_id = $request->task_id;
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
        $comment = TaskComment::with('users')->with('tasks')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $comment,
        ]);
    }

    public function getUser($id)
    {
        $users = TaskComment::find($id)->users;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $users,
        ]);
    }

    public function getTask($id)
    {
        $task = TaskComment::find($id)->tasks;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $task,
        ]);
    }

    public function update(Request $request, $id)
    {
        $comment = TaskComment::find($id);
        $comment->user_id = $request->user_id;
        $comment->task_id = $request->task_id;
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
        $comment = TaskComment::find($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }
}
