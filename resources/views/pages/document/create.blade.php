@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('documents.store') }}" method="post" class="d-inline" enctype="multipart/form-data">
                    <div class="card-body row">
                        <div class="col-12">
                            <h4 class="card-title mb-5">Kirim Surat Khusus</h4>
                        </div>
                        @csrf
                        <div class="col-md-6">
                            <div class='form-group mb-3'>
                                <label for='kode_hal' class='mb-2'>Kode Hal</label>
                                <input type='text' name='kode_hal'
                                    class='form-control @error('kode_hal') is-invalid @enderror'>
                                @error('kode_hal')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='category_id'>Kategori</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id . '-' . $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='to_unit_kerja_id'>Kepada</label>
                                <select name="to_unit_kerja_id" id="to_unit_kerja_id" class="form-control">
                                    <option value="" selected disabled>Pilih Kepada</option>
                                    @foreach ($unit_kerjas as $unit_kerja)
                                        <option value="{{ $unit_kerja->id }}">{{ $unit_kerja->name }}</option>
                                    @endforeach
                                </select>
                                @error('to_unit_kerja_id')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='to_tembusan_unit_kerja_id'>Tembusan</label>
                                <select name="to_tembusan_unit_kerja_id" id="to_tembusan_unit_kerja_id"
                                    class="form-control">
                                    <option value="" selected disabled>Pilih Tembusan</option>
                                    @foreach ($unit_kerjas as $unit_kerja)
                                        <option value="{{ $unit_kerja->id }}">{{ $unit_kerja->name }}</option>
                                    @endforeach
                                </select>
                                @error('to_tembusan_unit_kerja_id')
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
                            <div class="d-cat-tugas d-none">
                                <div class='form-group mb-3'>
                                    <label for='visum_umum' class='mb-2'>File Visum Umum</label>
                                    <input type='file' name='visum_umum'
                                        class='form-control @error('visum_umum') is-invalid @enderror'
                                        value='{{ old('visum_umum') }}'>
                                    @error('visum_umum')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class='form-group mb-3'>
                                    <label for='spd' class='mb-2'>SPD</label>
                                    <input type='file' name='spd'
                                        class='form-control @error('spd') is-invalid @enderror'
                                        value='{{ old('spd') }}'>
                                    @error('spd')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class='form-group mb-3'>
                                        <label for='detail_item' class='mb-2'>Item</label>
                                        <input type='text' name='detail_item[]' required
                                            class='form-control @error('detail_item') is-invalid @enderror'
                                            value=''>
                                        @error('detail_item')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class='form-group mb-3'>
                                        <label for='detail_qty' class='mb-2'>Qty</label>
                                        <input type='number' required name='detail_qty[]'
                                            class='form-control @error('detail_qty') is-invalid @enderror' value=''>
                                        @error('detail_qty')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class='form-group mb-3'>
                                        <label for='detail_harga' class='mb-2'>Harga</label>
                                        <input type='number' name='detail_harga[]' required
                                            class='form-control @error('detail_harga') is-invalid @enderror'
                                            value=''>
                                        @error('detail_harga')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='form-group mb-3'>
                                        <label for="detail_keterangan" class="mb-2">Keterangan</label>
                                        <input type='text' name='detail_keterangan[]' required
                                            class='form-control @error('detail_keterangan') is-invalid @enderror'
                                            value=''>
                                        @error('detail_keterangan')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md align-self-center mt-2">
                                    <button type="button" class="btn py-2 rowAdd btn-success">Tambah Baris</button>
                                </div>
                            </div>
                            <div class="newInput"></div>
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
                                <a href="{{ route('users.index') }}" class="btn btn-warning">Kembali</a>
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
            $(".rowAdd").click(function() {
                let newRow = `
                <div class="row" id="row">
                    <div class="col-md-3">
                                    <div class='form-group mb-3'>
                                        <label for='detail_item' class='mb-2'>Item</label>
                                        <input type='text' name='detail_item[]' required
                                            class='form-control @error('detail_item') is-invalid @enderror' value=''>
                                        @error('detail_item')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class='form-group mb-3'>
                                        <label for='detail_qty' class='mb-2'>Qty</label>
                                        <input type='number' required name='detail_qty[]'
                                            class='form-control @error('detail_qty') is-invalid @enderror' value=''>
                                        @error('detail_qty')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class='form-group mb-3'>
                                        <label for='detail_harga' class='mb-2'>Harga</label>
                                        <input type='number' name='detail_harga[]' required
                                            class='form-control @error('detail_harga') is-invalid @enderror' value=''>
                                        @error('detail_harga')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='form-group mb-3'>
                                        <label for="detail_keterangan" class="mb-2">Keterangan</label>
                                        <input type='text' name='detail_keterangan[]' required
                                            class='form-control @error('detail_keterangan') is-invalid @enderror' value=''>
                                        @error('detail_keterangan')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                    <div class="col-md align-self-center mt-2">
                        <button type="button" class="btn py-2 rowDelete btn-danger">Hapus Baris</button>
                    </div>
                </div>
            `;
                $('.newInput').append(newRow);
            });

            $("body").on("click", ".rowDelete", function() {
                $(this).parents("#row").remove();
            })

            $('#category_id').on('change', function(){
                let category = $(this).val();
                let category_split = category.split('-');
                let category_name = category_split[1];

                if(category_name === 'surat tugas' || category_name === 'Surat Tugas')
                {
                    $('.d-cat-tugas').removeClass('d-none');
                }else{
                    $('.d-cat-tugas').addClass('d-none');
                }
            })
        });
    </script>
@endpush
