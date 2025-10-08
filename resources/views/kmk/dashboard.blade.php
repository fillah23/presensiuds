@extends('layouts.main')

@section('contents')
<div id="app">
    <div id="main" class='layout-navbar navbar-fixed'>
        @include('layouts.navbar')
        <div id="main-content">
            <div class="page-heading mb-3">
                <h3>Dashboard KMK</h3>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                            <h6 class="text-muted font-semibold mb-1">Total Presensi</h6>
                                            <h5 class="font-extrabold mb-0">{{ $totalPresensi }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="stats-icon blue mb-2">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                            <h6 class="text-muted font-semibold mb-1">Presensi Aktif</h6>
                                            <h5 class="font-extrabold mb-0">{{ $presensiAktif }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="stats-icon green mb-2">
                                                <i class="iconly-boldAdd-User"></i>
                                            </div>
                                            <h6 class="text-muted font-semibold mb-1">Presensi Hari Ini</h6>
                                            <h5 class="font-extrabold mb-0">{{ $presensiHariIni }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header pb-2">
                                <h4 class="mb-0">Selamat Datang, {{ $user->name }}!</h4>
                            </div>
                            <div class="card-body pt-2">
                                <p class="mb-2">Anda login sebagai <strong>Koordinator Mata Kuliah (KMK)</strong> untuk dosen <strong>{{ $user->parentDosen->name ?? 'N/A' }}</strong>.</p>
                                <div class="row">
                                    <div class="col-md-7">
                                        <ul class="mb-3">
                                            <li>Mengelola presensi untuk mata kuliah yang diampu dosen</li>
                                            <li>Membuat presensi baru</li>
                                            <li>Memantau kehadiran mahasiswa</li>
                                            <li>Mengexport data presensi</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5 d-flex align-items-center justify-content-md-end justify-content-start gap-2">
                                        <a href="{{ route('presensi.index') }}" class="btn btn-primary">
                                            <i class="bi bi-clipboard-check"></i> Kelola Presensi
                                        </a>
                                        <a href="{{ route('presensi.create') }}" class="btn btn-success">
                                            <i class="bi bi-plus-circle"></i> Buat Presensi Baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        @include('layouts.footer')
        @include('layouts.sidebar')
    </div>
</div>
@endsection