<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\UserKelas;
use Faker\Factory as Faker;
use FCMGroup;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::with('user_kelas')->with('users')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $kelas,
        ]);
    }

    public function store(Request $request)
    {
        $faker = Faker::create();
        $code = \Str::random(5);

        $user_token = User::find($request->user_id)->registration_id;

        $tokens = [$user_token];
        $groupName = $code;

        // Save notification key in your database you must use it to send messages or for managing this group
        $notification_key = FCMGroup::createGroup($groupName, $tokens);

        $kelas = new Kelas;
        $kelas->user_id = $request->user_id;
        $kelas->name = $request->name;
        $kelas->subject = $request->subject;
        $kelas->desc = $request->desc;
        $kelas->code = $code;
        $kelas->color = ltrim($faker->hexcolor, '#');
        $kelas->notification_key = $notification_key;
        $kelas->save();

        $pivot = new UserKelas;
        $pivot->user_id = $request->user_id;
        $pivot->kelas_id = $kelas->_id;
        $pivot->role = 'guru';
        $pivot->save();

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $kelas,
            'extra' => $pivot,
        ]);
    }

    public function show($id)
    {
        $kelas = Kelas::with('user_kelas')->with('users')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $kelas,
        ]);
    }

    public function getOwner($id)
    {
        $users = Kelas::find($id)->users;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $users,
        ]);
    }

    public function getTask($id)
    {
        $tasks = Kelas::find($id)->tasks;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $tasks,
        ]);
    }

    public function getEvent($id)
    {
        $events = Kelas::find($id)->events;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $events,
        ]);
    }

    public function getAnggota($id)
    {
        $kelas = Kelas::find($id)->user_kelas;

        foreach ($kelas as $anggota) {
            $user = User::find($anggota->user_id);
            $anggota->name = $user->name;
            $anggota->email = $user->email;
        }

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $kelas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);
        $kelas->user_id = $request->user_id;
        $kelas->name = $request->name;
        $kelas->subject = $request->subject;
        $kelas->desc = $request->desc;
        $kelas->save();

        return response()->json([
            'success' => true,
            'message' => 'put/patch data success',
            'data' => $kelas,
        ]);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $kelas->user_kelas()->delete();
        $kelas->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }
}
