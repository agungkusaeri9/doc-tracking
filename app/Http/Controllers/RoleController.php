<?php

namespace App\Http\Controllers;

use App\Models\RoleUnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
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
                    $link_permission = route('role-permissions.edit') . '?role_name=' . $model->name;
                    $action = "<a href='$link_permission' class='btn btn-sm py-2 text-white btn-warning mx-1' ><i class='fas fa fa-eye'></i> Permission</a><button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
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

    public function edit_role_permission()
    {
        $item = Role::with('permissions')->where('name', request('role_name'))->firstOrFail();
        $role_permission = $item->permissions()->pluck('id');
        return view('pages.role.role-permissions', [
            'title' => 'Edit Role Permission',
            'item' => $item,
            'permissions' => Permission::whereNotIn('id',$role_permission)->orderBy('name','ASC')->get()
        ]);
    }

    public function update_role_permission()
    {
        request()->validate([
            'role_name' => ['required'],
            'permission' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['role_name', 'permission']);
            $role = Role::where('name', $data['role_name'])->firstOrFail();
            $role->syncPermissions($data['permission']);

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Permisison updated in role successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->route('roles.index')->with('error', 'System Error!.');
        }
    }
}
