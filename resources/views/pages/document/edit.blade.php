@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form
                    action="{{ route('documents.update', [
                        'uuid' => $item->uuid,
                    ]) }}"
                    method="post" class="d-inline" enctype="multipart/form-data">
                    <div class="card-body row">
                        <div class="col-12">
                            <h4 class="card-title mb-5">Edit Surat Khusus</h4>
                        </div>
                        @csrf
                        @method('patch')
                        <div class="col-md-6">
                            <div class='form-group mb-3'>
                                <label for='kode_hal' class='mb-2'>Kode Hal</label>
                                <input type='text' name='kode_hal'
                                    class='form-control @error('kode_hal') is-invalid @enderror'
                                    value="{{ $item->kode_hal }}">
                                @error('kode_hal')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='category_name' class='mb-2'>Kategori</label>
                                <input type='text' name=''
                                    class='form-control @error('category_name') is-invalid @enderror'
                                    value="{{ $item->category->name }}" readonly>
                                @error('category_name')
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
                                        <option @selected($unit_kerja->id == $item->to_unit_kerja_id) value="{{ $unit_kerja->id }}">
                                            {{ $unit_kerja->name }}</option>
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
                                        <option @selected($unit_kerja->id == $item->to_tembusan_unit_kerja_id) value="{{ $unit_kerja->id }}">
                                            {{ $unit_kerja->name }}</option>
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
                                    class='form-control @error('hal') is-invalid @enderror'>{{ $item->hal ?? old('hal') }}</textarea>
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
                                    class='form-control @error('deskripsi') is-invalid @enderror'>{{ $item->deskripsi ?? old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='keterangan' class='mb-2'>Keterangan</label>
                                <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                    class='form-control @error('keterangan') is-invalid @enderror'>{{ $item->keterangan ?? old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class='form-group mb-3'>
                                <label for='visum_umum' class='mb-2'>Visum Umum</label>
                                <textarea name='visum_umum' id='visum_umum' cols='30' rows='3'
                                    class='form-control @error('visum_umum') is-invalid @enderror'>{{ $item->visum_umum ?? old('visum_umum') }}</textarea>
                                @error('visum_umum')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class='form-group mb-3'>
                                <label for='spd' class='mb-2'>SPD</label>
                                <textarea name='spd' id='spd' cols='30' rows='3'
                                    class='form-control @error('spd') is-invalid @enderror'>{{ $item->spd ?? old('spd') }}</textarea>
                                @error('spd')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class='form-group mb-3'>
                                <label for='body' class='mb-2'>Isi Surat</label>
                                <textarea name='body' id='body' cols='30' rows='3'
                                    class='form-control @error('body') is-invalid @enderror'>{{ $item->body ?? old('body') }}</textarea>
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
            CKEDITOR.replace('visum_umum', {
                toolbar: 'Full'
            });

            CKEDITOR.replace('spd', {
                toolbar: 'Full'
            });
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

            $('#category_id').on('change', function() {
                let category = $(this).val();
                let category_split = category.split('-');
                let category_name = category_split[1];

                if (category_name === 'surat tugas' || category_name === 'Surat Tugas') {
                    $('.d-cat-tugas').removeClass('d-none');
                } else {
                    $('.d-cat-tugas').addClass('d-none');
                }
            })

            let category_name = '{{ $item->category->name }}';

            if (category_name === 'surat tugas' || category_name === 'Surat Tugas') {
                $('.d-cat-tugas').removeClass('d-none');
            } else {
                $('.d-cat-tugas').addClass('d-none');
            }
        });
    </script>
@endpush
