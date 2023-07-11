<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TTEController extends Controller
{
    public function tte_visum_umum($uuid)
    {
        $item = Document::where('uuid', $uuid)->firstOrFail();
        return view('pages.tte.document.visum-umum.index', [
            'title' => 'TTE Visum Umum',
            'item' => $item
        ]);
    }

    public function tte_visum_umum_create($uuid)
    {
        request()->validate([
            'tte_pin' => ['required']
        ]);

        $item = Document::where('uuid', $uuid)->firstOrFail();

        // cek pin TTE
        if (!Hash::check(request()->tte_pin, auth()->user()->tte_pin)) {
            return redirect()->back()->with('error', 'PIN TTE Invalid.');
        }

        $url_qrcode = route('cek-visum-umum', [
            'uuid' => $uuid
        ]);
        $image = QrCode::format('png')
            // ->merge('img/t.jpg', 0.1, true)
            ->size(200)->errorCorrection('H')
            ->generate($url_qrcode);
        $output_file = 'qr-code/visum-umum/' . $uuid . '.png';
        Storage::disk('public')->put($output_file, $image);

        $item->update([
            'tte_visum_umum_created_user_id' => auth()->id(),
            'tte_visum_umum_created' => Carbon::now(),
            'visum_umum_qrcode' => $output_file
        ]);

        return redirect()->back()->with('success', 'TTE Visum Umum created successfully');
    }

    public function tte_visum_umum_download($uuid)
    {
        $item = Document::where('uuid', $uuid)->firstOrFail();
        // $qrcode = QrCode::size(400)->generate($item->uuid);\
        $pdf = Pdf::loadView('pages.tte.document.visum-umum.download', [
            'item' => $item
        ]);
        return $pdf->download($item->uuid . '.pdf');
    }

    public function tte_spd($uuid)
    {
        $item = Document::where('uuid', $uuid)->firstOrFail();
        return view('pages.tte.document.spd.index', [
            'title' => 'TTE SPD',
            'item' => $item
        ]);
    }

    public function tte_spd_create($uuid)
    {
        request()->validate([
            'tte_pin' => ['required']
        ]);

        $item = Document::where('uuid', $uuid)->firstOrFail();

        // cek pin TTE
        if (!Hash::check(request()->tte_pin, auth()->user()->tte_pin)) {
            return redirect()->back()->with('error', 'PIN TTE Invalid.');
        }

        $url_qrcode = route('cek-spd', [
            'uuid' => $uuid
        ]);
        $image = QrCode::format('png')
            // ->merge('img/t.jpg', 0.1, true)
            ->size(200)->errorCorrection('H')
            ->generate($url_qrcode);
        $output_file = 'qr-code/spd/' . $uuid . '.png';
        Storage::disk('public')->put($output_file, $image);

        $item->update([
            'tte_spd_created_user_id' => auth()->id(),
            'tte_spd_created' => Carbon::now(),
            'spd_qrcode' => $output_file
        ]);

        return redirect()->back()->with('success', 'TTE SPD created successfully');
    }

    public function tte_spd_download($uuid)
    {
        $item = Document::where('uuid', $uuid)->firstOrFail();
        // dd($item);
        // $qrcode = QrCode::size(400)->generate($item->uuid);\
        $pdf = Pdf::loadView('pages.tte.document.spd.download', [
            'item' => $item
        ]);
        return $pdf->download($item->uuid . '.pdf');
    }
}
