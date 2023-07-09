<?php

namespace App\Http\Controllers;

use App\Models\DocumentDisposisiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentDisposisiUnitController extends Controller
{
    public function store()
    {
        request()->validate([
            'unit_kerja_id' => ['required'],
            'document_disposisi_id' => ['required']
        ]);

        DB::beginTransaction();

        try {
            DocumentDisposisiUnit::updateOrCreate(
                ['id'  => request('id')],
                [
                    'unit_kerja_id' => request('unit_kerja_id'),
                    'document_disposisi_id' => request('document_disposisi_id')
                ]
            );

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Unit berhasil disimpan.']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DocumentDisposisiUnit::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Penerima berhasil dihapus.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
