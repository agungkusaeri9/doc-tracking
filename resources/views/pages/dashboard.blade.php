@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Selamat Datang, {{ auth()->user()->name }}</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin transparent">
        <div class="row">
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Surat</p>
                        <p class="fs-30 mb-2">{{ $count['surat'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Kategori Surat</p>
                        <p class="fs-30 mb-2">{{ $count['category'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Unit Kerja</p>
                        <p class="fs-30 mb-2">{{ $count['unit_kerja'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">User</p>
                        <p class="fs-30 mb-2">{{ $count['user'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<x-Admin.Sweetalert />
