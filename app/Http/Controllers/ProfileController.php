<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile', [
            'title' => 'Profile'
        ]);
    }

    public function update()
    {
        $user = auth()->user();
        request()->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'unique:users,email,' . $user->id . ''],
            'role' => ['required'],
            'username' => ['required', Rule::unique('users','username')->ignore($user->id), 'alpha_dash'],
            'avatar' => ['image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);

        if (request('password')) {
            request()->validate([
                'password' => ['min:5', 'confirmed'],
            ]);
        }

        // jika ada tte_pin
        if (request('tte_pin')) {
            request()->validate([
                'tte_pin' => ['required', 'min:5']
            ]);

            $tte_pin = bcrypt(request('tte_pin'));
        } else {
            $tte_pin = $user->tte_pin;
        }

        DB::beginTransaction();
        try {


            $data = request()->only(['name', 'email','username','tte_pin','foto']);
            if(request()->file('avatar'))
            {
                // cek apakah punya gambar
                if(auth()->user()->foto)
                {
                    Storage::disk('public')->delete(auth()->user()->foto);
                }
                $data['foto'] = request()->file('avatar')->store('user','public');
            }else{
                $data['foto'] = auth()->user()->fotor;
            }
            request('password') ? $data['password'] = bcrypt(request('password')) : NULL;
            request()->file('avatar') ? $data['avatar'] = request()->file('avatar')->store('users', 'public') : NULL;
            $data['tte_pin'] = $tte_pin;
            $user->update($data);

            DB::commit();
            return redirect()->route('profile.index')->with('success', 'Profile berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
