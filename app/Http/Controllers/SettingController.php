<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setting.index',[
            'title'=> 'Setting',
            'setting' => Setting::first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {

    $validated = $request->validate([
    'app_name' => 'required|string|max:255',
    'copyright' => 'required|string|max:255',
    'login_title' => 'required|string|max:255',
    'keyword' => 'nullable|string|max:255',
    'description' => 'nullable|string|max:1000', 
    'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', 
], [
    'app_name.required' => 'Nama aplikasi wajib diisi.',
    'app_name.string' => 'Nama aplikasi harus berupa teks.',
    'app_name.max' => 'Nama aplikasi maksimal 255 karakter.',

    'copyright.required' => 'Hak cipta (copyright) wajib diisi.',
    'copyright.string' => 'Hak cipta harus berupa teks.',
    'copyright.max' => 'Hak cipta maksimal 255 karakter.',

    'login_title.required' => 'Judul halaman login wajib diisi.',
    'login_title.string' => 'Judul halaman login harus berupa teks.',
    'login_title.max' => 'Judul halaman login maksimal 255 karakter.',

    'keyword.string' => 'Keyword harus berupa teks.',
    'keyword.max' => 'Keyword maksimal 255 karakter.',

    'description.string' => 'Deskripsi harus berupa teks.',
    'description.max' => 'Deskripsi maksimal 1000 karakter.',

    'logo.image' => 'File logo harus berupa gambar.',
    'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau svg.',
    'logo.max' => 'Ukuran logo maksimal 2MB.',

]);

    DB::beginTransaction();
    try {

    if($request->file('logo')){
    $validated['logo'] = $request->file('logo')->store('logo', 'public');
    if( $setting->logo){
        Storage::disk('public')->delete( $setting->logo);
    }
    }
       $setting->update($validated);
        DB::commit();
        return to_route('setting.index')->withSuccess('Data berhasil disimpan');

    }catch (\Exception $e) {
        DB::rollBack();
        return to_route('setting.index',)->withError('Data gagal disimpan');
    }
    }

}
