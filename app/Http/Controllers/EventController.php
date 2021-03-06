<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kelas;
use FCM;
use Illuminate\Http\Request;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('kelas')->with('users')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $events,
        ]);
    }

    public function store(Request $request)
    {
        $date_start = \Carbon\Carbon::now()->toISOString();
        $date_end = \Carbon\Carbon::parse($request->date_end)->toISOString();

        $event = new Event;
        $event->user_id = $request->user_id;
        $event->kelas_id = $request->kelas_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->date_start = $date_start;
        $event->date_end = $date_end;
        $event->save();

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle('New Event ' . $event->kelas->name)
            ->setBody($request->title);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $event]);

        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $members = UserKelas::with('users')->where('kelas_id', $request->kelas_id)->get();
        $tokens = [];

        foreach ($members as $member) {
            $token = $member->users->registration_id;
            array_push($tokens, $token);
        }

        $downstreamResponse = FCM::sendTo($tokens, null, $notification, $data);

        return response()->json([
            'success' => true,
            'message' => 'post data success',
            'data' => $event,
        ]);
    }

    public function show($id)
    {
        $event = Event::with('kelas')->with('users')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $event,
        ]);
    }

    public function getOwner($id)
    {
        $users = Event::find($id)->users;

        return response()->json([
            'success' => true,
            'message' => 'get data success',
            'data' => $users,
        ]);
    }

    public function getKelas($id)
    {
        $kelas = Event::find($id)->kelas;

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

        $event = Event::find($id);
        $event->user_id = $request->user_id;
        $event->kelas_id = $request->kelas_id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $task->date_start = $date_start;
        $task->date_end = $date_end;
        $event->save();

        return response()->json([
            'success' => true,
            'message' => 'put/patch data success',
            'data' => $event,
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete data success',
            'data' => null,
        ]);
    }
}
