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
                            <h3>Detail Mahasiswa</h3>
                            <p class="text-subtitle text-muted">Informasi Detail Mahasiswa</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">Data Mahasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Mahasiswa</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Detail Informasi Mahasiswa</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">NIM</td>
                                                <td style="width: 5%;">:</td>
                                                <td>{{ $mahasiswa->nim }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Nama Lengkap</td>
                                                <td>:</td>
                                                <td>{{ $mahasiswa->nama_lengkap }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Fakultas</td>
                                                <td>:</td>
                                                <td>{{ $mahasiswa->fakultas->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Program Studi</td>
                                                <td>:</td>
                                                <td>{{ $mahasiswa->prodi->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Kelas</td>
                                                <td>:</td>
                                                <td>{{ $mahasiswa->kelas }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">Status</td>
                                                <td style="width: 5%;">:</td>
                                                <td>
                                                    @if($mahasiswa->is_active)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Dibuat Pada</td>
                                                <td>:</td>
                                                <td>{{ $mahasiswa->created_at->format('d M Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Diupdate Pada</td>
                                                <td>:</td>
                                                <td>{{ $mahasiswa->updated_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit
                                </a>
                                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Kembali
                                </a>
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