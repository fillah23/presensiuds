@extends('layouts.main')

@section('contents')
<div id="app">
    <div id="main" class='layout-navbar navbar-fixed'>
        @include('layouts.navbar')
        <div id="main-content">
            <div class="page-heading">
                <h3>Dashboard KMK</h3>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon purple mb-2">
                                                    <i class="iconly-boldShow"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Total Presensi</h6>
                                                <h6 class="font-extrabold mb-0">{{ $totalPresensi }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon blue mb-2">
                                                    <i class="iconly-boldProfile"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Presensi Aktif</h6>
                                                <h6 class="font-extrabold mb-0">{{ $presensiAktif }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon green mb-2">
                                                    <i class="iconly-boldAdd-User"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Presensi Hari Ini</h6>
                                                <h6 class="font-extrabold mb-0">{{ $presensiHariIni }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Selamat Datang, {{ $user->name }}!</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>Anda login sebagai <strong>Koordinator Mata Kuliah (KMK)</strong> untuk dosen <strong>{{ $user->parentDosen->name ?? 'N/A' }}</strong>.</p>
                                        <p>Sebagai KMK, Anda dapat:</p>
                                        <ul>
                                            <li>Mengelola presensi untuk mata kuliah yang diampu dosen</li>
                                            <li>Membuat presensi baru</li>
                                            <li>Memantau kehadiran mahasiswa</li>
                                            <li>Mengexport data presensi</li>
                                        </ul>
                                        
                                        <div class="mt-4">
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
                    </div>
                    
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Face 1">
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold">{{ $user->name }}</h5>
                                        <h6 class="text-muted mb-0">{{ $user->email }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Akun</h4>
                            </div>
                            <div class="card-content pb-4">
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="name ms-4">
                                        <h5 class="mb-1">Role</h5>
                                        <h6 class="text-muted mb-0">{{ $user->role->display_name ?? 'N/A' }}</h6>
                                    </div>
                                </div>
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="name ms-4">
                                        <h5 class="mb-1">Dosen Pembimbing</h5>
                                        <h6 class="text-muted mb-0">{{ $user->parentDosen->name ?? 'N/A' }}</h6>
                                    </div>
                                </div>
                                @if($user->nomor_whatsapp)
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="name ms-4">
                                        <h5 class="mb-1">WhatsApp</h5>
                                        <h6 class="text-muted mb-0">{{ $user->nomor_whatsapp }}</h6>
                                    </div>
                                </div>
                                @endif
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