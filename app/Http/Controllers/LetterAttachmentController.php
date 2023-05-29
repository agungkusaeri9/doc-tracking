<?php

namespace App\Http\Controllers;

use App\Models\LetterAttachments;
use Illuminate\Http\Request;

class LetterAttachmentController extends Controller
{
    public function download($id_encrypt)
    {
        $id = decrypt($id_encrypt);
        $letter_attachment = LetterAttachments::findOrFail($id);
        // dd($letter_attachment);
        if ($letter_attachment->file) {
            $extentions = \Str::after($letter_attachment->file,'.');
            if($extentions === 'pdf')
                $headers = ['Content-Type:', 'application/pdf'];
            else
                $headers = ['Content-Type:', 'image/'.$extentions];

            $filePath = public_path('storage/') . $letter_attachment->file;

            $fileName = 'lampiran-' . $letter_attachment->id . '.' . $extentions;

            // if (!file_exists($filePath)) {
            //     return redirect()->back()->with('error', 'Downloading Failed.');
            // }

            return response()->download($filePath, $fileName, $headers);
        } else {
            return redirect()->back()->with('error', 'File Tidak Ditemukan.');
        }
    }
}
