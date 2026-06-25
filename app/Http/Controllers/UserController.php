<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index',[
            'title'=> 'User',
            'users' => User::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create',[
            'title'=> 'Tambah User',
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255|unique:users',
    'password' => 'required|min:8',
    'passwordconfirm' => 'required|same:password',
    'avatar' => 'nullable|image|max:2048',
    'role' => 'required|in:Superadmin,Admin',
], [
    'required' => ':Attribute wajib diisi.',
    'email' => 'Format email tidak valid.',
    'unique' => 'Email sudah terdaftar.',
    'min' => ':Attribute minimal :min karakter.',
    'max' => ':Attribute maksimal :max karakter.',
    'image' => 'File harus berupa gambar.',
    'in' => 'Role tidak valid.',
]);

if($request->file('avatar')){
    $validated['avatar'] = $request->file('avatar')->store('avatar', 'public');
}

    try {
        DB::beginTransaction();
        User::create($validated);
        DB::commit();
        return to_route('user.index')->withSuccess('Data berhasil ditambahkan');

    }catch (\Exception $e) {
        DB::rollBack();
        return to_route('user.create')->withError('Data gagal ditambahkan');
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
