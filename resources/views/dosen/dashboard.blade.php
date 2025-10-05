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
                            <p class="text-subtitle text-muted">Sistem Absensi Kode Koding</p>
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
                                        Anda login sebagai <strong>Dosen</strong> di Sistem Absensi Kode Koding.
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