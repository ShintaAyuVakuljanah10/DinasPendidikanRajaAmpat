<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackEnd\App;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    public function index()
    {
        $setting = App::first();
        return view('backend.settings.aplikasi', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nama_aplikasi' => 'nullable|string',
            'judul_aplikasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email',
            'hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'salam' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $setting = App::first();

        if (!$setting) {
            $setting = App::create([]);
        }

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('logo');
        }

        $setting->update($data);

        return back()->with('success', 'Pengaturan berhasil diperbarui');
    }

}
