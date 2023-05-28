<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user.index', [
            'title' => 'Data User'
        ]);
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = User::with('unit_kerja');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $link_edit = route('users.edit',$model->id);
                    $action = "<a href='$link_edit' class='btn btn-sm py-2 btn-info  mx-1' ><i class='fas fa fa-edit'></i> Edit</a><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    return $action;
                })
                ->filter(function ($instance) use ($request) {

                    if ($request->get('unit_kerja_select')) {
                        $instance->where('unit_kerja_id', $request->unit_kerja_select);
                    }
                    if ($request->get('role_select')) {
                        $instance->whereHas('unit_kerja', function ($q) use ($request) {
                            $q->whereHas('role_unit', function ($role_unit) use ($request) {
                                $role_unit->whereHas('role', function ($role) use ($request) {
                                    $role->where('id', $request->role_select);
                                });
                            });
                        });
                    }
                })
                ->editColumn('username', function ($model) {
                    return $model->username ?? '-';
                })
                ->addColumn('unit_kerja', function ($model) {
                    return $model->unit_kerja->name ?? '-';
                })
                ->addColumn('jabatan', function ($model) {
                    return $model->jabatan->nama ?? '-';
                })
                ->addColumn('role', function ($model) {
                    return $model->unit_kerja->role_unit->role->name ?? '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $unit_kerjas = UnitKerja::get();
        return view('pages.user.create', [
            'title' => 'Buat User',
            'unit_kerjas' => $unit_kerjas
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'username' => ['required', 'unique:users,username', 'alpha_dash'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required', 'min:8']
        ]);


        DB::beginTransaction();

        try {
            // insert user
            $user = User::create([
                'name' => request('name'),
                'username' => request('username'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'nip' => request('nip'),
                'jenis_kelamin' => request('jenis_kelamin'),
                'status' => request('status') ? 1 : 0,
                'pns' => request('pns') ? 1 : 0,
                'alamat' => request('alamat'),
                'unit_kerja_id' => request('unit_kerja_id'),
                'jabatan_id' => request('jabatan_id'),
                'foto' => request()->file('foto') ? request()->file('foto')->store('user', 'public') : NULL
            ]);

            request('role') ? $user->assignRole(request('role')) : NULL;
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'System Error!');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $unit_kerjas = UnitKerja::get();
        return view('pages.user.edit', [
            'title' => 'Edit User',
            'unit_kerjas' => $unit_kerjas,
            'user' => $user
        ]);
    }

    public function update($id)
    {

        request()->validate([
            'name' => ['required'],
            'username' => ['required', Rule::unique('users','username')->ignore($id), 'alpha_dash'],
            'email' => ['required', Rule::unique('users','email')->ignore($id), 'email']
        ]);

        $user = User::findOrFail($id);

        // jika ada password
        if(request('password'))
        {
            request()->validate([
                'password' => ['required','min:8']
            ]);

            $password = bcrypt(request('password'));
        }else{
            $password = $user->password;
        }


        DB::beginTransaction();

        try {

            // jika ada foto yg diupload
            if(request()->file('foto'))
            {
                $user->foto ? Storage::disk('public')->delete($user->foto) : NULL;
                $foto = request()->file('foto')->store('user', 'public');
            }else{
                $foto = $user->foto;
            }

            // insert user
            $user->update([
                'name' => request('name'),
                'username' => request('username'),
                'email' => request('email'),
                'password' => $password,
                'nip' => request('nip'),
                'jenis_kelamin' => request('jenis_kelamin'),
                'status' => request('status') ? 1 : 0,
                'pns' => request('pns') ? 1 : 0,
                'alamat' => request('alamat'),
                'unit_kerja_id' => request('unit_kerja_id'),
                'jabatan_id' => request('jabatan_id'),
                'foto' => $foto
            ]);

            request('role') !== 'Tidak Mempunyai Role' ? $user->syncRoles(request('role')) : NULL;
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            throw $th;
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'System Error!');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            User::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'User created successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }
}
