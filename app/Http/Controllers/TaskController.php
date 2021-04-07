<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $task = Task::with('kelas')->with('users')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $task,
        ]);
    }

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
            'success' => true,
            'message' => 'post data success',
            'data' => $task,
        ]);
    }

    public function show($id)
    {
        $task = Task::with('kelas')->with('users')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $task,
        ]);
    }

    public function getOwner($id)
    {
        $users = Task::find($id)->users;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $users,
        ]);
    }

    public function getKelas($id)
    {
        $kelas = Task::find($id)->kelas;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $kelas,
        ]);
    }

    public function getSentTask($id)
    {
        $kelas = Task::find($id)->task_users;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $kelas,
        ]);
    }

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
            'success' => true,
            'message' => 'put/patch data success',
            'data' => $task,
        ]);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }
}
