<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventComment;
use App\Models\Kelas;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\UserKelas;
use Illuminate\Http\Request;

// use JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        User::truncate();
        Kelas::truncate();
        Task::truncate();
        Event::truncate();
        UserKelas::truncate();
        TaskUser::truncate();
        EventComment::truncate();
        TaskComment::truncate();
        $user = User::with('user_kelas')->with('kelas')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $user,
        ]);

        // $token = JWTAuth::user();
        // return response()->json(compact('token'));
    }

    public function show($id)
    {
        $user = User::with('user_kelas')->with('kelas')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $user,
        ]);
    }

    public function getOwned($id)
    {
        $user = User::find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $user->kelas,
        ]);
    }

    public function getKelas($id)
    {
        $user = User::find($id)->user_kelas;

        foreach ($user as $pivot) {
            $kelas = Kelas::find($pivot->kelas_id);
            $pivot->name = $kelas->name;
        }

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $user,
        ]);
    }

    public function connectKelas(Request $request, $id)
    {
        $pivot = new UserKelas;
        $pivot->user_id = $id;
        $pivot->kelas_id = $request->kelas_id;
        $pivot->role = 'murid';
        $pivot->save();

        $pivot->users;
        $pivot->kelas;

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $pivot,
        ]);
    }

    public function disconnectKelas(Request $request, $id)
    {
        $pivot = UserKelas::where('user_id', $id)
            ->where('kelas_id', $request->kelas_id)
            ->where('role', 'murid')
            ->first();

        $pivot->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }

    public function getTask($id)
    {
        $task = User::find($id)->tasks;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $task,
        ]);
    }

    public function getSentTask($id)
    {
        $user = User::find($id)->task_users;

        foreach ($user as $pivot) {
            $task = Task::find($pivot->task_id);
            $pivot->title = $task->title;
            $pivot->desc = $task->desc;
        }

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $user,
        ]);
    }

    public function sendTask(Request $request, $id)
    {
        $pivot = new TaskUser;
        $pivot->user_id = $id;
        $pivot->task_id = $request->task_id;
        $pivot->data = $request->data;
        $pivot->save();

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $pivot,
        ]);
    }

    public function updateTask(Request $request, $id)
    {
        $pivot = TaskUser::where('user_id', $id)
            ->where('task_id', $request->task_id)
            ->first();

        $pivot->data = $request->data;
        $pivot->save();

        return response()->json([
            'success' => true,
            'message' => 'put/patch data success',
            'data' => $pivot,
        ]);
    }

    public function getEvent($id)
    {
        $events = User::find($id)->events;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $events,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'put/patch data success',
            'data' => $user,
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->user_kelas()->delete();
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }
}
