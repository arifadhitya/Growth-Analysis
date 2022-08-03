<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $datauser = User::all();
        return view('dashboard/staf/index', ['datauser' => $datauser]);
    }

    public function create()
    {
        return view('dashboard/staf/tambah');
    }

    public function store(Request $request)
    {
        //print_r($request->inputKodeProduk);
        $validatedData = $request->validate([
            'kodepegawai' => 'required|unique:users',
            'namapegawai' => 'required|max:255',
            'username' => 'required|max:255',
            'profil' => 'image|file|max:2048',
        ]);

        $validatedData['password']=Hash::make($request->password);

        if($request->file('profil')){
            $validatedData['profil'] = $request->file('profil')->store('user-profiles');
        }

        User::create($validatedData);
        return redirect('/staf')->with('success', 'Data staf telah ditambahkan');
    }

    public function edit(User $staf)
    {
        return view('dashboard/staf/ubah', [
            'staf' => $staf,

        ]);
    }

    public function update(Request $request, User $staf)
    {
        $rules = [
            'namapegawai' => 'required|max:255',
            'username' => 'required|max:255',
            'profil' => 'image|file|max:2048',
        ];

        $validatedData['password']=Hash::make($request->password);

        if($request->kodepegawai != $staf->kodepegawai){
            $rules['kodepegawai'] = 'required|max:255';
        };

        if($request->file('profil')){
            $validatedData['profil'] = $request->file('profil')->store('user-profiles');
        }

        $validatedData = $request->validate($rules);


        User::where('id', $request->id)->update($validatedData);

        return redirect('/staf')->with('success', 'Data staf telah diubah');
    }

    public function destroy(User $staf)
    {
        User::destroy($staf->id);
        return redirect('/staf')->with('success', 'Data staf dihapus');
    }
}
