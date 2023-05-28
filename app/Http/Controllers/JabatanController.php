<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    public function index()
    {
        return view('pages.jabatan.index', [
            'title' => 'Data Kategori'
        ]);
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = Jabatan::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $action = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    return $action;
                })
                ->addColumn('unit_kerja', function($model){
                    return $model->unit_kerja->name ?? '-';
                })
                ->filter(function ($instance) use ($request) {

                    if ($request->get('unit_kerja_select')) {
                       $instance->where('unit_kerja_id',$request->unit_kerja_select);
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'nama' => ['required'],
            'unit_kerja_id' => ['required','numeric']
        ]);

        DB::beginTransaction();
        try {
            Jabatan::updateOrCreate([
                'id'  => request('id')
            ], [
                'nama' => request('nama'),
                'unit_kerja_id' => request('unit_kerja_id')
            ]);

            if (request('id')) {
                $message = 'Jabatan updated successfully.';
            } else {
                $message = 'Jabatan created successfully.';
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message]);
        } catch (\Throwable $th) {
            Throw $th;
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

    public function show($id)
    {
        if(request()->ajax()){
            $unit_kerja = Jabatan::where('id',$id)->first();
            return response()->json($unit_kerja);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Jabatan::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Jabatan deleted successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

}
