<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskComment::with('users')->with('tasks')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new TaskComment;
        $comment->user_id = $request->user_id;
        $comment->task_id = $request->task_id;
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
        return TaskComment::with('users')->with('tasks')->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser($id)
    {
        return TaskComment::find($id)->users;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTask($id)
    {
        return TaskComment::find($id)->tasks;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = TaskComment::find($id);
        $comment->user_id = $request->user_id;
        $comment->task_id = $request->task_id;
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
        $comment = TaskComment::find($id);
        $comment->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
