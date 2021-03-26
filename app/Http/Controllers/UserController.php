<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->get();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKelas($id)
    {
        $user = User::find($id);
        $user->kelas;
        return $user;
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
        return User::find($id)->task_users;
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendTask(Request $request, $id)
    {
        $task_id = $request->task_id;
        $data = collect($request->data);
        $user = User::find($id);

        foreach ($data as $link) {
            $user->task_users()->attach([$task_id => ['data'=> $link]]);
        }

        return response()->json([
            'data' => $user->task_users()->wherePivot('task_id', $task_id)->get(),
            'message' => 'Data berhasil masuk'
        ], 200);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTask(Request $request, $id)
    {
        $task_id = $request->task_id;
        $data = collect($request->data);
        $user = User::find($id);

        $user->task_users()->wherePivot('task_id', $task_id)->wherePivotIn('data', $data, 'and', true)->detach();

        foreach ($data as $link) {
            if ($user->task_users()->wherePivot('task_id', $task_id)->wherePivot('data', $link)->get()->isEmpty()) {
                $user->task_users()->attach([$task_id => ['data'=> $link]]);
            }
        }

        return response()->json([
            'data' => $user->task_users()->wherePivot('task_id', $task_id)->get(),
            'message' => 'Data berhasil dihapus'
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
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSentEvent($id)
    {
        return User::find($id)->event_users;
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEvent(Request $request, $id)
    {
        $event_id = $request->event_id;
        $data = collect($request->data);
        $user = User::find($id);

        foreach ($data as $link) {
            $user->event_users()->attach([$event_id => ['data'=> $link]]);
        }

        return response()->json([
            'data' => $user->event_users()->wherePivot('event_id', $event_id)->get(),
            'message' => 'Data berhasil masuk'
        ], 200);
    }

    /**
     * Display the related resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateEvent(Request $request, $id)
    {
        $event_id = $request->event_id;
        $data = collect($request->data);
        $user = User::find($id);

        $user->event_users()->wherePivot('event_id', $event_id)->wherePivotIn('data', $data, 'and', true)->detach();

        foreach ($data as $link) {
            if ($user->event_users()->wherePivot('event_id', $event_id)->wherePivot('data', $link)->get()->isEmpty()) {
                $user->event_users()->attach([$event_id => ['data'=> $link]]);
            }
        }

        return response()->json([
            'data' => $user->event_users()->wherePivot('event_id', $event_id)->get(),
            'message' => 'Data berhasil dihapus'
        ], 200);
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
            'message' => 'Data berhasil masuk'
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
        $user->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
