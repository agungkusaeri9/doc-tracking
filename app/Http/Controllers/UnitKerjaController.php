<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UnitKerjaController extends Controller
{
    public function index()
    {
        return view('pages.unit-kerja.index', [
            'title' => 'Data Kategori'
        ]);
    }

    public function data()
    {
        if (request()->ajax()) {
            $data = UnitKerja::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $action = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    return $action;
                })
                ->addColumn('child', function($model){
                    return $model->child->name ?? '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function get()
    {
        if(request()->ajax()){
            $category_detail = UnitKerja::get();
            return response()->json($category_detail);
        }
    }


    public function show($id)
    {
        if(request()->ajax()){
            $unit_kerja = UnitKerja::where('id',$id)->first();
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
            Throw $th;
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
}