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
                                        <option value="{{ $category->id . '-' . $category->name }}">{{ $category->name }}
                                        </option>
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
                        </div>
                        <div class="col-12 d-cat-tugas d-none">
                            <div class='form-group mb-3'>
                                <label for='visum_umum' class='mb-2'>Visum Umum</label>
                                <textarea name='visum_umum' id='visum_umum' cols='30' rows='3'
                                    class='form-control @error('visum_umum') is-invalid @enderror'>
                                    <table cellpadding="0" class="tb-format" style="width: 100%">
                                        <tbody>
                                          <tr>
                                            <td style="width: 50%; border: 1px solid black;
        padding: 8px;">&nbsp;</td>
                                            <td class="td-format" style=" border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td>I.</td>
                                                    <td>Berangkat Dari</td>
                                                    <td>: Indramayu (tempat kedudukan)</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Pada Tanggal</td>
                                                    <td>:25 Mei 2023</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Ke</td>
                                                    <td>: Bogor</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Kepala</td>
                                                    <td>: <b> Pejabat Pembuat Komitmen</b></td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <b
                                                          >Bobi Khoerun, M.T.<br />
                                                          NIP 198806032018031001</b
                                                        >
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="td-format" style=" border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td>II.</td>
                                                    <td>Tiba di</td>
                                                    <td>
                                                      : Hotel Ibis Styles Bogor Pajajaran - Bogor Jawa Barat
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Pada Tanggal</td>
                                                    <td>:25 Mei 2023</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Kepala</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <br />
                                                        NIP
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                            <td style="width: 50%; border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                    <td>Berangkat Dari</td>
                                                    <td>
                                                      : Hotel Ibis Styles Bogor Pajajaran - Bogor Jawa Barat
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Pada Tanggal</td>
                                                    <td>:27 Mei 2023</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Ke</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Kepala</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <br />
                                                        NIP
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="td-format" style=" border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td>III.</td>
                                                    <td>Tiba di</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Pada Tanggal</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Kepala</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <br />
                                                        NIP
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                            <td style="width: 50%; border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                    <td>Ke</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Kepala</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <br />
                                                        NIP
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="td-format" style=" border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td>IV.</td>
                                                    <td>Tiba di</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Pada Tanggal</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Kepala</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <br />
                                                        NIP
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                            <td style="width: 50%; border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                    <td>Berangkat Dari</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Pada Tanggal</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Ke</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Kepala</td>
                                                    <td>:</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <br />
                                                        NIP
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="td-format" style=" border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td>V.</td>
                                                    <td>Tiba di</td>
                                                    <td>: Indramayu</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>Pada Tanggal</td>
                                                    <td>:27 Mei 2023</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                      <b> Pejabat Pembuat Komitmen</b>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <b
                                                          >Bobi Khoerun, M.T.<br />
                                                          NIP 198806032018031001</b
                                                        >
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                            <td style="width: 50%; border: 1px solid black;
        padding: 8px;">
                                              <table cellspacing="0" class="border-none" style="width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td colspan="3">
                                                      Telah diperiksa dengan keterangan bahwa perjalanan tersebut
                                                      perintahnya dan semata-mata untuk kepentingan jabatan dalam
                                                      waktu yang sesingkat-singkatnya
                                                    </td>
                                                  </tr>

                                                  <tr>
                                                    <td></td>
                                                    <td>
                                                      <b> Pejabat Pembuat Komitmen</b>
                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>&nbsp;</p>

                                                      <p>
                                                        <b
                                                          >Bobi Khoerun, M.T.<br />
                                                          NIP 198806032018031001</b
                                                        >
                                                        <br />
                                                      </p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </textarea>
                                @error('visum_umum')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 d-cat-tugas d-none">
                            <div class='form-group mb-3'>
                                <label for='spd' class='mb-2'>SPD</label>
                                <textarea name='spd' id='spd' cols='30' rows='3'
                                    class='form-control @error('spd') is-invalid @enderror'>
                                    <table border="1" cellpadding="0" class="tb-format" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center">1</td>
                                                <td>Pejabat Pembuat Komitmen</td>
                                                <td colspan="2"><strong>Bobi Khoerun, M.T./198806032018031001</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">2</td>
                                                <td>Nama/NIP Pegawai yang melaksanakan perjalanan dinas</td>
                                                <td colspan="2"><strong>Madirah, S.H./198601102021211001</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">3</td>
                                                <td>
                                                <p>a. Pangkat dan Golongan<br />
                                                b.&nbsp;Jabatan dan Instansi<br />
                                                c.&nbsp;Tingkat biaya perjalanan dinas</p>
                                                </td>
                                                <td colspan="2">
                                                <p>a. IX<br />
                                                b.&nbsp;Analisis SDM Aparatur Ahli Pertama<br />
                                                c.&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">4</td>
                                                <td>Maksud perjalanan dinas</td>
                                                <td colspan="2">untuk menghadiri undangan Revisi Peta Jabatan PTN</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">5</td>
                                                <td>Alat angkutan yang dipergunakan</td>
                                                <td>Kendaraan Umum</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">6</td>
                                                <td>
                                                <p>a. Tempat Berangkat<br />
                                                b.&nbsp;Kota Tujuan/Provinsi</p>
                                                </td>
                                                <td>
                                                <p>a. Indramayu, Jawa Barat<br />
                                                b.&nbsp;Bogor, Jawa Barat</p>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">7</td>
                                                <td>
                                                <p>a. Lama perjalanan dinas<br />
                                                b.&nbsp;Tanggal Berangkat<br />
                                                c.&nbsp;Tanggal harus kembali</p>
                                                </td>
                                                <td>
                                                <p>a. 3 (tiga) hari<br />
                                                b.&nbsp;Kamis, 25 Mei 2023<br />
                                                c.&nbsp;Sabtu, 27 Mei 2023</p>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">8</td>
                                                <td>Nama Pengikut/NIP.</td>
                                                <td style="text-align:center">Golongan/Ruang</td>
                                                <td style="text-align:center">Keterangan</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">9</td>
                                                <td>
                                                <p>a. Instansi<br />
                                                b.&nbsp;Akun</p>
                                                </td>
                                                <td>
                                                <p>a. Politeknin Negeri Indramayu<br />
                                                b.&nbsp;524111</p>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">10</td>
                                                <td>Keterampilan lain-lain</td>
                                                <td>
                                                <p>No. Surat Tugas<br />
                                                Tanggal</p>
                                                </td>
                                                <td>
                                                <p>1321/PL42/KP.10.00/2023<br />
                                                23 Mei 2023</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td colspan="2">Dikeluarkan di&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Indramayu<br />
                                                Tanggal&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 23 Mei 2023<br />
                                                <br />
                                                <strong>Pejabat Pembuat Komitmen</strong><br />
                                                <br />
                                                <br />
                                                <strong>Bobi Khoerun, M.T.</strong><br />
                                                NIP 198806032018031001</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </textarea>
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
            CKEDITOR.replace('visum_umum', {
                toolbar: 'Full'
            });
            CKEDITOR.replace('spd', {
                toolbar: 'Full'
            });
            CKEDITOR.replace('body', {
                toolbar: 'Full'
            });
            CKEDITOR.allowedContent = true;
            CKEDITOR.extraAllowedContent = 'td(*)';
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
        });
    </script>
@endpush

{{-- @push('styles')
    <style>
        table.tb-format {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
        }

        table.tb-format {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        table.tb-format td,
        table.tb-format td {
            border: 1px solid black;
            padding: 8px;
        }

        table.tb-format ul.abc {
            list-style-type: lower-alpha;
            text-align: left;
            padding-left: 10px;
        }

        table.tb-format .text-right {
            float: right;
            margin-right: 100px;
        }
    </style>
@endpush --}}
