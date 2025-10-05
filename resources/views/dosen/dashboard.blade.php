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
                            <h3>Dashboard Dosen</h3>
                            <p class="text-subtitle text-muted">Sistem Absensi Universitas Darussalam</p>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <section class="section">
                    <!-- Welcome Message -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Selamat Datang, {{ $user->name }}!</h5>
                                    <p class="card-text">
                                        Anda login sebagai <strong>Dosen</strong> di Sistem Absensi Universitas Darussalam.
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>NUPTK:</strong> {{ $user->nuptk }}</p>
                                            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                                            <p class="mb-1"><strong>WhatsApp:</strong> {{ $user->nomor_whatsapp }}</p>
                                        </div>
                                    </div>
                                    <p class="text-muted mt-3">
                                        <small>
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ date('l, d F Y') }}
                                            <i class="bi bi-clock ms-3 me-1"></i>
                                            <span id="current-time"></span>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Menu Absensi</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="#" class="btn btn-primary btn-block mb-3">
                                                <i class="bi bi-calendar-check me-2"></i>
                                                Absensi Masuk
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="btn btn-danger btn-block mb-3">
                                                <i class="bi bi-calendar-x me-2"></i>
                                                Absensi Keluar
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="btn btn-info btn-block mb-3">
                                                <i class="bi bi-clock-history me-2"></i>
                                                Riwayat Absensi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Absensi Hari Ini -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Status Absensi Hari Ini</h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Anda belum melakukan absensi hari ini.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Rekap Bulanan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6 class="text-muted">Hadir</h6>
                                            <h4 class="text-success">0 hari</h4>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="text-muted">Tidak Hadir</h6>
                                            <h4 class="text-danger">0 hari</h4>
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

<script>
    // Update waktu real-time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        document.getElementById('current-time').textContent = timeString;
    }
    
    // Update setiap detik
    setInterval(updateTime, 1000);
    updateTime(); // Initial call
</script>
@endsection