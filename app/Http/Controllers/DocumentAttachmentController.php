<?php

namespace App\Http\Controllers;

use App\Models\DocumentAttachment;
use Illuminate\Http\Request;

class DocumentAttachmentController extends Controller
{
    public function download($id_encrypt)
    {
        $id = decrypt($id_encrypt);
        $document_attachment = DocumentAttachment::findOrFail($id);
        // dd($document_attachment);
        if ($document_attachment->file) {
            $extentions = \Str::after($document_attachment->file,'.');
            if($extentions === 'pdf')
                $headers = ['Content-Type:', 'application/pdf'];
            else
                $headers = ['Content-Type:', 'image/'.$extentions];

            $filePath = public_path('storage/') . $document_attachment->file;

            $fileName = 'lampiran-' . $document_attachment->id . '.' . $extentions;

            // if (!file_exists($filePath)) {
            //     return redirect()->back()->with('error', 'Downloading Failed.');
            // }

            return response()->download($filePath, $fileName, $headers);
        } else {
            return redirect()->back()->with('error', 'File Tidak Ditemukan.');
        }
    }
}
