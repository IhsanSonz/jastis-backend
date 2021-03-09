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
        $user->kelas_users;
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
    public function getSentEvent($id)
    {
        return User::find($id)->event_users;
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
