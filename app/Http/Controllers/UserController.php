<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\UserKelas;
use Illuminate\Http\Request;

// use JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('user_kelas')->with('kelas')->latest()->get();

        // $token = JWTAuth::user();
        // return response()->json(compact('token'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('user_kelas')->with('kelas')->find($id);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOwned($id)
    {
        $user = User::find($id);
        return $user->kelas;
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKelas($id)
    {
        $user = User::find($id)->user_kelas;

        foreach ($user as $pivot) {
            $kelas = Kelas::find($pivot->kelas_id);
            $pivot->name = $kelas->name;
        }

        return $user;
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            'data' => $pivot,
            'message' => 'Data berhasil masuk',
        ], 200);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function disconnectKelas(Request $request, $id)
    {
        $pivot = UserKelas::where('user_id', $id)
            ->where('kelas_id', $request->kelas_id)
            ->where('role', 'murid')
            ->first();

        $pivot->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTask($id)
    {
        return User::find($id)->tasks;
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSentTask($id)
    {
        $user = User::find($id)->task_users;

        foreach ($user as $pivot) {
            $task = Task::find($pivot->task_id);
            $pivot->title = $task->title;
            $pivot->desc = $task->desc;
        }

        return $user;
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendTask(Request $request, $id)
    {
        // return $request;
        $pivot = new TaskUser;
        $pivot->user_id = $id;
        $pivot->task_id = $request->task_id;
        $pivot->data = $request->data;
        $pivot->save();

        return response()->json([
            'data' => $pivot,
            'message' => 'Data berhasil masuk',
        ], 200);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTask(Request $request, $id)
    {
        $pivot = TaskUser::where('user_id', $id)
            ->where('task_id', $request->task_id)
            ->first();

        $pivot->data = $request->data;
        $pivot->save();

        return response()->json([
            'data' => $pivot,
            'message' => 'Data berhasil diubah',
        ], 200);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEvent($id)
    {
        return User::find($id)->events;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->save();

        return response()->json([
            'data' => $user,
            'message' => 'Data berhasil masuk',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->user_kelas()->delete();
        $user->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
