<?php

namespace App\Http\Controllers;

use App\Models\RoleUnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.role.index', [
            'title' => 'Data Role'
        ]);
    }

    public function data()
    {
        if (request()->ajax()) {
            $data = Role::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $action = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => ['required', Rule::unique('roles')->ignore(request('id'))]
        ]);

        DB::beginTransaction();
        try {
            Role::updateOrCreate([
                'id'  => request('id')
            ], [
                'name' => request('name'),
            ]);

            if (request('id')) {
                $message = 'Role updated successfully.';
            } else {
                $message = 'Role created successfully.';
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Role::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Role created successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

    public function get_by_unitkerja()
    {
        if(request()->ajax()){
            if(request('unit_kerja_id'))
            {
                $role = RoleUnitKerja::with('role')->where('unit_kerja_id',request('unit_kerja_id'))->first();
            }else{
                // $roles = RoleUnitKerja::get()->pluck('role_id');
                // dd($role)
                $role = Role::get();
            }
            return response()->json($role);
        }
    }

    public function get()
    {
        if(request()->ajax()){
            $roles = Role::get();
            return response()->json($roles);
        }
    }
}
