<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\UserKelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Kelas::with('user_kelas')->with('users')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kelas = new Kelas;
        $kelas->user_id = $request->user_id;
        $kelas->name = $request->name;
        $kelas->save();

        $pivot = new UserKelas;
        $pivot->user_id = $request->user_id;
        $pivot->kelas_id = $kelas->_id;
        $pivot->role = 'guru';
        $pivot->save();

        return response()->json([
            'data' => $kelas,
            'extra' => $pivot,
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
        return Kelas::with('user_kelas')->with('users')->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOwner($id)
    {
        return Kelas::find($id)->users;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAnggota($id)
    {
        $kelas = Kelas::find($id)->user_kelas;

        foreach ($kelas as $anggota) {
            $user = User::find($anggota->user_id);
            $anggota->name = $user->name;
            $anggota->email = $user->email;
        }
        
        return $kelas;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);
        $kelas->user_id = $request->user_id;
        $kelas->name = $request->name;
        $kelas->save();

        return response()->json([
            'data' => $kelas,
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
        $kelas = Kelas::find($id);
        $kelas->user_kelas()->delete();
        $kelas->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
