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
                        <hr>
                        @if ($item->tte_visum_umum_created)
                        <h6 class="mb-3">TTE Visum Umum</h6>
                            <li class="list-item mb-2">
                                <b>Pembuat TTE</b>
                                <br>
                                <span>{{ $item->tte_visum_umum_created_user->name ?? '-' }}</span>
                            </li>
                            <li class="list-item mb-2">
                                <b>Tanggal TTE</b>
                                <br>
                                <span>{{ $item->tte_visum_umum_created->translatedFormat('H:i:s d-m-Y') ?? '-' }}</span>
                            </li>
                            <li class="list-item mb-2">
                                <b>Download File TTE</b>
                                <br>
                                <a href="{{ route('documents.tte.visum-umum.download',[
                                    'uuid' => $item->uuid
                                ]) }}" class="btn btn-success btn-sm">Download</a>
                            </li>
                        @endif
                    </ul>

                    @if ($item->tte_visum_umum_created == null)
                        <form
                            action="{{ route('documents.tte.visum-umum.create', [
                                'uuid' => $item->uuid,
                            ]) }}"
                            method="post">
                            @csrf
                            <div class='form-group mb-3'>
                                <label for='pembuat_tte' class='mb-2'>Pembuat TTE</label>
                                <input type='text' class='form-control @error('pembuat_tte') is-invalid @enderror'
                                    value='{{ auth()->user()->name }}' readonly>
                                @error('pembuat_tte')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class='form-group mb-3'>
                                <label for='tanggal_dibuar' class='mb-2'>Tanggal Dibuat</label>
                                <input type='text' class='form-control @error('tanggal_dibuar') is-invalid @enderror'
                                    value='{{ Carbon\Carbon::now()->translatedFormat('H:i:s d-m-Y') }}' readonly>
                                @error('tanggal_dibuar')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='tte_pin' class='mb-2'>PIN TTE</label>
                                <input type='password' name='tte_pin'
                                    class='form-control @error('tte_pin') is-invalid @enderror'
                                    value='{{ old('tte_pin') }}'>
                                @error('tte_pin')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group float-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
