<?php

namespace App\Http\Controllers;

use App\Models\LetterDisposisiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LetterDisposisiUserController extends Controller
{
    public function store()
    {
        request()->validate([
            'user_id' => ['required'],
            'letter_disposisi_id' => ['required']
        ]);

        DB::beginTransaction();

        try {
            LetterDisposisiUser::updateOrCreate(
                ['id'  => request('id')],
                [
                    'user_id' => request('user_id'),
                    'letter_disposisi_id' => request('letter_disposisi_id')
                ]
            );

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Penerima berhasil disimpan.']);
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
            LetterDisposisiUser::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Penerima berhasil dihapus.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
