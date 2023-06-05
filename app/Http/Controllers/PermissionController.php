<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Permission Index')->only(['index', 'data']);
        // $this->middleware('can:Permission Create')->only(['store']);
        // $this->middleware('can:Permission Update')->only(['store']);
        $this->middleware('can:Permission Delete')->only(['destroy']);
    }


    public function index()
    {
        return view('pages.permission.index', [
            'title' => 'Data Permission'
        ]);
    }

    public function data()
    {
        if (request()->ajax()) {
            $data = Permission::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    if(cek_user_permission('Permission Update'))
                    {
                        $edit = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button>";
                    }else{
                        $edit = "";
                    }

                    if(cek_user_permission('Permission Delete'))
                    {
                        $hapus = "<button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    }else{
                        $hapus = "";
                    }

                    return $edit . $hapus;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => ['required', Rule::unique('permissions')->ignore(request('id'))]
        ]);

        DB::beginTransaction();
        try {
            Permission::updateOrCreate([
                'id'  => request('id')
            ], [
                'name' => request('name'),
            ]);

            if (request('id')) {
                $message = 'Permission updated successfully.';
            } else {
                $message = 'Permission created successfully.';
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
            Permission::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Permission created successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }
}
