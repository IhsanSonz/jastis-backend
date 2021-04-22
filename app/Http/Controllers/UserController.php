<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\UserKelas;
use FCM;
use Illuminate\Http\Request;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

// use JWTAuth;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('user_kelas')->with('kelas')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $users,
        ]);
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
        $user = User::findOrFail($id)->user_kelas;
        $kelass = [];

        foreach ($user as $pivot) {
            $kelas = Kelas::with('users')->find($pivot->kelas_id);
            $kelas->role = $pivot->role;
            array_push($kelass, $kelas);
        }

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $kelass,
        ]);
    }

    public function connectKelas(Request $request, $id)
    {
        $code = $request->code;
        $kelas_id = Kelas::where('code', $code)->firstOrFail()->_id;

        if (UserKelas::where('user_id', $id)->where('kelas_id', $kelas_id)->first()) {
            return response()->json([
                'success' => false,
                'message' => 'data already exist',
                'data' => null,
            ]);
        }

        $pivot = new UserKelas;
        $pivot->user_id = $id;
        $pivot->kelas_id = $kelas_id;
        $pivot->role = 'murid';
        $pivot->save();

        $pivot->users;
        $pivot->kelas;

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle('Student Activity')
            ->setBody('A Student joined your class ' . $pivot->kelas->name);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $pivot->users]);

        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $gurus = UserKelas::with('users')->where('kelas_id', $kelas_id)->where('role', 'guru')->get();
        $tokens = [];

        foreach ($gurus as $guru) {
            $token = $guru->users->registration_id;
            array_push($tokens, $token);
        }

        $downstreamResponse = FCM::sendTo($tokens, null, $notification, $data);

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $pivot,
        ]);
    }

    public function disconnectKelas(Request $request, $id)
    {
        $code = $request->code;
        $kelas_id = Kelas::where('code', $code)->firstOrFail()->_id;

        $pivot = UserKelas::where('user_id', $id)
            ->where('kelas_id', $kelas_id)
            ->first();

        $kelasName = $pivot->kelas->name;

        $pivot->delete();

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle('Student Activity')
            ->setBody('A Student left your class ' . $kelasName);

        $notification = $notificationBuilder->build();

        $gurus = UserKelas::with('users')->where('kelas_id', $request->kelas_id)->where('role', 'guru')->get();
        $tokens = [];

        foreach ($gurus as $guru) {
            $token = $guru->users->registration_id;
            array_push($tokens, $token);
        }

        $downstreamResponse = FCM::sendTo($tokens, null, $notification, null);

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }

    public function getTaskAct($id)
    {
        $user = User::findOrFail($id)->user_kelas;
        $tasks = [];

        foreach ($user as $pivot) {
            $task = Task::with('kelas')->where('kelas_id', $pivot->kelas_id)->get();
            array_push($tasks, ...$task);
        }

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $tasks,
        ]);

    }

    public function getTask($id)
    {
        $user = User::findOrFail($id)->tasks;
        $tasks = [];

        foreach ($user as $pivot) {
            $task = Task::with('kelas')->find($pivot->id);
            array_push($tasks, $task);
        }

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $tasks,
        ]);

    }

    public function getSentTask(Request $request, $id)
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

    public function findSentTask(Request $request, $id)
    {
        $tu = TaskUser::where('task_id', $request->task_id)
            ->where('user_id', $id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $tu,
        ]);
    }

    public function sendTask(Request $request, $id)
    {
        $pivot = new TaskUser;
        $pivot->user_id = $id;
        $pivot->task_id = $request->task_id;
        $pivot->data = $request->data;
        $pivot->score = null;
        $pivot->save();

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle('Assignment')
            ->setBody('A Student Sends an Assignment');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $pivot]);

        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $gurus = UserKelas::with('users')
            ->where('kelas_id', Task::find($request->task_id)->kelas->_id)
            ->where('role', 'guru')
            ->get();
        $tokens = [];

        foreach ($gurus as $guru) {
            $token = $guru->users->registration_id;
            array_push($tokens, $token);
        }

        $downstreamResponse = FCM::sendTo($tokens, null, $notification, $data);

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $pivot,
        ]);
    }

    public function updateTask(Request $request, $id)
    {
        $pivot = TaskUser::find($id);

        $pivot->data = $request->data;
        $pivot->save();

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle('Assignment')
            ->setBody('A Student Sends an Assignment');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $pivot]);

        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $gurus = UserKelas::with('users')
            ->where('kelas_id', Task::find($request->task_id)->kelas->_id)
            ->where('role', 'guru')
            ->get();
        $tokens = [];

        foreach ($gurus as $guru) {
            $token = $guru->users->registration_id;
            array_push($tokens, $token);
        }

        $downstreamResponse = FCM::sendTo($tokens, null, $notification, $data);

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

    public function setRegistration(Request $request, $id)
    {
        $user = User::find($id);

        $user->registration_id = $request->registration_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $user,
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
