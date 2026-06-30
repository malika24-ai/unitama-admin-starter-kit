<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.index',[
            'title'=> 'Dashboard'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('dashboard.show',[
            'title'=> 'Detail User',
            'user' => Auth::user(),
            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('dashboard.edit',[
            'title'=> 'Edit User',
            'user' => Auth::user(),
            
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user =Auth::user();

    $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
    'password' => 'nullable|string:8',
    'passwordconfirm' => 'nullable|same:password',
    'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:1048',
    
], [
    'name.required' => 'Nama wajib diisi.',
    'name.string' => 'Nama harus berupa teks.',
    'name.max' => 'Nama maksimal 255 karakter.',

    'email.required' => 'Email wajib diisi.',
    'email.email' => 'Format email tidak valid.',
    'email.max' => 'Email maksimal 255 karakter.',
    'email.unique' => 'Email sudah terdaftar.',

    'password.required' => 'Password wajib diisi.',
    'password.min' => 'Password minimal harus 8 karakter.',

    'passwordconfirm.required' => 'Konfirmasi password wajib diisi.',
    'passwordconfirm.same' => 'Konfirmasi password tidak sama dengan password.',

    'avatar.image' => 'File avatar harus berupa gambar.',
    'avatar.max' => 'Ukuran avatar maksimal 2MB.',

   
]);

 DB::beginTransaction();
    try {

    if($request->file('avatar')){
    $validated['avatar'] = $request->file('avatar')->store('avatar', 'public');
    if($user->avatar){
        Storage::disk('public')->delete($user->avatar);
    }
}
if($request->pasword){

    $validated['password']=bcrypt($request->pasword);
}else{
    unset($validated['password']);
}


        
        $user->update($validated);
        DB::commit();
        return to_route('dashboard.show')->withSuccess('Data berhasil diubah');

    }catch (\Exception $e) {
        DB::rollBack();
        return to_route('user.edit',)->withError('Data gagal diubah');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
