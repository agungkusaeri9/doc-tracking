@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('outbox.index') . '?jenis=document' }}"
                        class="btn btn-sm text-white btn-warning mb-3">Kembali</a>
                    <h5 class="mb-3 mr-5">Detail Surat</h5>
                    <ul class="list-unstyled">
                        <li class="list-item mb-2">
                            <b>NO. Surat</b>
                            <br>
                            <span>{{ $item->no_surat }}</span>
                        </li>
                        <li class="list-item mb-2">
                            <b>Kode Hal</b>
                            <br>
                            <span>{{ $item->kode_hal }}</span>
                        </li>


                        <li class="list-item mb-2">
                            <b>Deskripsi</b>
                            <br>
                            <span>{{ $item->deskripsi }}</span>
                        </li>
                        <li class="list-item mb-2">
                            <b>Keterangan</b>
                            <br>
                            <span>{{ $item->keterangan }}</span>
                        </li>

                        <li class="list-item mb-2">
                            <b>Tanggal Submit</b>
                            <br>
                            <span>{{ $item->created_at->translatedFormat('H:i:s d-m-Y') }}</span>
                        </li>

                        @if ($item->category->name === 'surat tugas' || $item->category->name === 'Surat Tugas')
                            <li class="list-item mb-2">
                                <b>Visum Umum</b>
                                <br>
                                <a href="{{ route('documents.tte.visum-umum.index', $item->uuid) }}"
                                    class="btn text-white btn-sm @if ($item->tte_visum_umum_created) btn-success @else btn-secondary @endif">TTE</a>
                            </li>
                            <li class="list-item mb-2">
                                <b>SPD</b>
                                <br>
                                <a href="{{ route('documents.tte.spd.index', $item->uuid) }}"
                                    class="btn text-white btn-sm @if ($item->tte_spd_created) btn-success @else btn-secondary @endif">TTE</a>
                            </li>
                        @endif
                        @foreach ($item->attachments as $key => $lampiran)
                            <li class="list-item mb-2">
                                <b>Lampiran {{ $key + 1 }}</b>
                                <br>
                                <a href="{{ route('document-attachments.download', [
                                    'id' => encrypt($lampiran->id),
                                ]) }}"
                                    class="btn btn-success btn-sm">Download</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
