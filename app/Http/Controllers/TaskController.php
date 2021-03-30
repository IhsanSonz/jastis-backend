<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::with('kelas')->with('users')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date_start = \Carbon\Carbon::now()->toISOString();

        $date_end = \Carbon\Carbon::parse($request->date_end)->toISOString();

        $task = new Task;
        $task->user_id = $request->user_id;
        $task->kelas_id = $request->kelas_id;
        $task->title = $request->title;
        $task->desc = $request->desc;
        $task->date_start = $date_start;
        $task->date_end = $date_end;
        $task->save();

        return response()->json([
            'data' => $task,
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
        return Task::with('kelas')->with('users')->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOwner($id)
    {
        return Task::find($id)->users;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKelas($id)
    {
        return Task::find($id)->kelas;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $date_start = \Carbon\Carbon::now()->toISOString();

        $date_end = \Carbon\Carbon::parse($request->date_end)->toISOString();

        $task = Task::find($id);
        $task->user_id = $request->user_id;
        $task->kelas_id = $request->kelas_id;
        $task->title = $request->title;
        $task->desc = $request->desc;
        $task->date_start = $date_start;
        $task->date_end = $date_end;
        $task->save();

        return response()->json([
            'data' => $task,
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
        $task = Task::find($id);
        $task->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
