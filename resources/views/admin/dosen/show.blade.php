@extends('layouts.main')

@section('contents')
<div id="app">
    <div id="main" class='layout-navbar navbar-fixed'>
        @include('layouts.navbar')
        <div id="main-content">
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Detail Dosen</h3>
                            <p class="text-subtitle text-muted">Informasi Detail Dosen</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('dosen.index') }}">Data Dosen</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Dosen</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Informasi Dosen</h5>
                                <div>
                                    <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil me-1"></i>
                                        Edit
                                    </a>
                                    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%"><strong>Nama Lengkap</strong></td>
                                            <td width="5%">:</td>
                                            <td>{{ $dosen->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NUPTK</strong></td>
                                            <td>:</td>
                                            <td>{{ $dosen->nuptk }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>:</td>
                                            <td>{{ $dosen->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nomor WhatsApp</strong></td>
                                            <td>:</td>
                                            <td>{{ $dosen->nomor_whatsapp }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td>:</td>
                                            <td>
                                                @if($dosen->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Non Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role</strong></td>
                                            <td>:</td>
                                            <td>{{ $dosen->role->display_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Terdaftar</strong></td>
                                            <td>:</td>
                                            <td>{{ $dosen->created_at->format('d F Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Terakhir Update</strong></td>
                                            <td>:</td>
                                            <td>{{ $dosen->updated_at->format('d F Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Statistik Absensi</h6>
                                            <p class="card-text">
                                                <small class="text-muted">Fitur ini akan tersedia setelah sistem absensi diimplementasikan.</small>
                                            </p>
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <h4 class="text-success">0</h4>
                                                    <small>Hadir</small>
                                                </div>
                                                <div class="col-4">
                                                    <h4 class="text-warning">0</h4>
                                                    <small>Terlambat</small>
                                                </div>
                                                <div class="col-4">
                                                    <h4 class="text-danger">0</h4>
                                                    <small>Absent</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @include('layouts.sidebar')
</div>
@endsection