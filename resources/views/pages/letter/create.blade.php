@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('letters.store') }}" method="post" class="d-inline" enctype="multipart/form-data">
                    <div class="card-body row">
                        <div class="col-12">
                            <h4 class="card-title mb-5">Kirim Surat</h4>
                        </div>
                        @csrf
                        <div class="col-md-6">
                            <div class='form-group mb-3'>
                                <label for='tanggal' class='mb-2'>Tanggal</label>
                                <input type='date' name='tanggal'
                                    class='form-control @error('tanggal') is-invalid @enderror'
                                    value='{{ old('tanggal') }}'>
                                @error('tanggal')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='to_user_id'>Tujuan</label>
                                <select name="to_user_id" id="to_user_id" class="form-control">
                                    <option value="" selected disabled>Pilih Tujuan</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('to_user_id')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='hal' class='mb-2'>Hal</label>
                                <textarea name='hal' id='hal' cols='30' rows='5'
                                    class='form-control @error('hal') is-invalid @enderror'>{{ old('hal') }}</textarea>
                                @error('hal')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class='form-group mb-3'>
                                <label for='deskripsi' class='mb-2'>Isi/Ringkasan</label>
                                <textarea name='deskripsi' id='deskripsi' cols='30' rows='3'
                                    class='form-control @error('deskripsi') is-invalid @enderror'>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='keterangan' class='mb-2'>Keterangan</label>
                                <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                    class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='lampiran' class='mb-2'>Lampiran</label>
                                <input type='file' name='lampiran[]'
                                    class='form-control @error('lampiran') is-invalid @enderror' multiple>
                                @error('lampiran.*')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class='form-group mb-3'>
                                <label for='body' class='mb-2'>Isi Surat</label>
                                <textarea name='body' id='body' cols='30' rows='3'
                                    class='form-control @error('body') is-invalid @enderror'>{{ old('body') }}</textarea>
                                @error('body')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('dashboard') }}" class="btn btn-warning">Kembali</a>
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/ckeditor/contents.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('body', {
                toolbar: 'Full'
            });
        });
    </script>
@endpush
