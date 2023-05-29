@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('users.store') }}" method="post" class="d-inline" enctype="multipart/form-data">
                    <div class="card-body row">
                        <div class="col-12">
                            <h4 class="card-title mb-5">Buat User</h4>
                        </div>
                        @csrf
                        <div class="col-md-6">
                            <div class='form-group mb-3'>
                                <label for='name' class='mb-2'>Name</label>
                                <input type='text' name='name'
                                    class='form-control @error('name') is-invalid @enderror' value='{{ old('name') }}'>
                                @error('name')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='username' class='mb-2'>Username</label>
                                <input type='text' name='username'
                                    class='form-control @error('username') is-invalid @enderror'
                                    value='{{ old('username') }}'>
                                @error('username')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='email' class='mb-2'>Email</label>
                                <input type='text' name='email'
                                    class='form-control @error('email') is-invalid @enderror' value='{{ old('email') }}'>
                                @error('email')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='password' class='mb-2'>Password</label>
                                <input type='password' name='password'
                                    class='form-control @error('password') is-invalid @enderror'
                                    value='{{ old('password') }}'>
                                @error('password')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='nip' class='mb-2'>NIP</label>
                                <input type='text' name='nip' class='form-control @error('nip') is-invalid @enderror'
                                    value='{{ old('nip') }}'>
                                @error('nip')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='jenis_kelamin'>Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                    <option @selected(old('jenis_kelamin') == 'laki-laki') value="laki-laki">Laki-laki</option>
                                    <option @selected(old('jenis_kelamin') == 'perempuan')value="perempuan">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='foto' class='mb-2'>Foto</label>
                                <input type='file' name='foto'
                                    class='form-control @error('foto') is-invalid @enderror' value='{{ old('foto') }}'>
                                @error('foto')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class='form-group mb-3'>
                                <label class='mb-2' for='pns'>PNS</label>
                                <select name="pns" id="pns" class="form-control">
                                    <option value="" selected disabled>Pilih</option>
                                    <option @selected(old('pns') == 1) value="1">Ya</option>
                                    <option @selected(old('pns') == 0)value="0">Tidak</option>
                                </select>
                                @error('pns')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='status'>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option @selected(old('status') == 1) value="1">Aktif</option>
                                    <option @selected(old('status') == 0)value="0">Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='alamat' class='mb-2'>Alamat</label>
                                <textarea name='alamat' id='alamat' cols='30' rows='8'
                                    class='form-control @error('alamat') is-invalid @enderror'>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='unit_kerja_id'>Unit Kerja</label>
                                <select name="unit_kerja_id" id="unit_kerja_id" class="form-control">
                                    <option value="" selected disabled>Pilih Unit Kerja</option>
                                    @foreach ($unit_kerjas as $unit_kerja)
                                        <option value="{{ $unit_kerja->id }}">{{ $unit_kerja->name }}</option>
                                    @endforeach
                                </select>
                                @error('unit_kerja_id')
                                    <div class='invalid-feedback d-inline'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='role' class='mb-2'>Role</label>
                                <input type='text' name='role' id="role"
                                    class='form-control @error('role') is-invalid @enderror' value='{{ old('role') }}'
                                    readonly>
                                @error('role')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label class='mb-2' for='jabatan_id'>Jabatan</label>
                                <select name="jabatan_id" id="jabatan_id" class="form-control">
                                    <option value="" selected disabled>Pilih Jabatan</option>
                                </select>
                                @error('jabatan_id')
                                    <div class='invalid-feedback d-inline'>
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
@push('scripts')
    <script>
        $(function() {
            $('#unit_kerja_id').on('change', function() {
                let unit_kerja_id = $(this).val();


                // get role by unit kerja
                let role = getRole(unit_kerja_id);
                let role_name = role.role ? role.role.name : 'Tidak Mempunya Role';
                let data_jabatan = getJabatan(unit_kerja_id);

                // looping jabatan
                $('#jabatan_id').empty();
                $('#jabatan_id').append(
                    `<option value="">Pilih Jabatan</option>`
                );
                if (data_jabatan) {
                    data_jabatan.forEach(jabatan => {
                        $('#jabatan_id').append(
                            `<option value="${jabatan.id}">${jabatan.nama}</option>`);
                    });
                }

                $('#role').val(role_name);
            })

            // get jabatans by unit_kerja id
            let getJabatan = function(unit_kerja_id) {
                let data;
                $.ajax({
                    url: '{{ route('jabatans.get-byunitkerja') }}',
                    type: 'JSON',
                    method: 'GET',
                    data: {
                        unit_kerja_id: unit_kerja_id
                    },
                    async: false,
                    success: function(response) {
                        data = response;
                    }
                })

                return data;
            }

            // get role by unit_kerja id
            let getRole = function(unit_kerja_id) {
                let data;
                $.ajax({
                    url: '{{ route('roles.get-byunitkerja') }}',
                    type: 'JSON',
                    method: 'GET',
                    data: {
                        unit_kerja_id: unit_kerja_id
                    },
                    async: false,
                    success: function(response) {
                        data = response;
                    }
                })

                return data;
            }
        })
    </script>
@endpush