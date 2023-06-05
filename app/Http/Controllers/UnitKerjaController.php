<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UnitKerjaController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Unit Kerja Index')->only(['index', 'data']);
        // $this->middleware('can:Unit Kerja Create')->only(['store']);
        // $this->middleware('can:Unit Kerja Update')->only(['store']);
        $this->middleware('can:Unit Kerja Delete')->only(['destroy']);
        $this->middleware('can:Unit Kerja Role Add')->only(['set_role']);
    }

    public function index()
    {
        return view('pages.unit-kerja.index', [
            'title' => 'Data Unit Kerja'
        ]);
    }

    public function data()
    {
        if (request()->ajax()) {
            $data = UnitKerja::with(['role_unit.role']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $role_unit_id = $model->role_unit->id ?? NULL;
                    $role_id = $model->role_unit->role_id ?? NULL;

                    if (cek_user_permission('Unit Kerja Role Add')) {
                        $set_role = "<button class='btn btn-sm py-2 btn-warning btnSetRole mx-1' data-id='$model->id' data-roleunitid='$role_unit_id' data-roleid='$role_id'><i class='fas fa fa-edit'></i> Set Role</button>";
                    } else {
                        $set_role = "";
                    }

                    if (cek_user_permission('Unit Kerja Update')) {
                        $edit = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button>";
                    } else {
                        $edit = "";
                    }

                    if (cek_user_permission('Unit Kerja Delete')) {
                        $hapus = "<button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    } else {
                        $hapus = "";
                    }
                    return $set_role . $edit . $hapus;
                })
                ->addColumn('child', function ($model) {
                    return $model->child->name ?? '-';
                })
                ->addColumn('role_category', function ($model) {
                    return $model->role_unit->role->name ?? '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function get()
    {
        if (request()->ajax()) {
            $category_detail = UnitKerja::get();
            return response()->json($category_detail);
        }
    }


    public function show($id)
    {
        if (request()->ajax()) {
            $unit_kerja = UnitKerja::where('id', $id)->first();
            return response()->json($unit_kerja);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => ['required']
        ]);

        DB::beginTransaction();
        try {
            UnitKerja::updateOrCreate([
                'id'  => request('id')
            ], [
                'name' => request('name'),
                'parent_id' => request('parent_id')
            ]);

            if (request('id')) {
                $message = 'Unit Kerja updated successfully.';
            } else {
                $message = 'Unit Kerja created successfully.';
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message]);
        } catch (\Throwable $th) {
            // Throw $th;
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            UnitKerja::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Unit Kerja deleted successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

    public function set_role()
    {
        request()->validate([
            'id' => ['required']
        ]);

        $id = request('id');
        $role_id = request('role_id');
        $role_unit_kerja_id = request('role_unit_kerja_id');

        // return response()->json(request()->all());

        $unit_kerja = UnitKerja::find($id);
        $unit_kerja->role_unit()->updateOrCreate(
            [
                'id' => $role_unit_kerja_id
            ],
            [
                'role_id' => $role_id
            ]
        );
        return response()->json(['status' => 'success', 'message' => 'Role set  to unit kerja successfully.']);
    }
}
