@extends('layouts.main')

@section('contents')
<div id="app">
    <div id="main">
        @include('layouts.navbar')
        
        <div id="main-content">
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Detail Presensi</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('presensi.index') }}">Presensi</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <section class="section">
                    <div class="row">
                        <!-- Info Presensi -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informasi Presensi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Kode Presensi</strong></td>
                                                    <td>: <span class="badge bg-primary fs-6">{{ $presensi->kode_presensi }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nama Kelas</strong></td>
                                                    <td>: {{ $presensi->nama_kelas }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Dosen</strong></td>
                                                    <td>: {{ $presensi->dosen->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Waktu Mulai</strong></td>
                                                    <td>: {{ $presensi->waktu_mulai->format('d/m/Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Waktu Selesai</strong></td>
                                                    <td>: {{ $presensi->waktu_selesai->format('d/m/Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Durasi</strong></td>
                                                    <td>: {{ $presensi->durasi_menit }} menit</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Program Studi</strong></td>
                                                    <td>: {{ $presensi->prodi }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Target Peserta</strong></td>
                                                    <td>: {{ $totalMahasiswa }} mahasiswa</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sudah Presensi</strong></td>
                                                    <td>: <span class="badge bg-success">{{ $presensi->getAbsentMahasiswas() }}</span> / {{ $totalMahasiswa }} mahasiswa</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Persentase Kehadiran</strong></td>
                                                    <td>: 
                                                        @php
                                                            $persentase = $totalMahasiswa > 0 ? round(($presensi->getAbsentMahasiswas() / $totalMahasiswa) * 100, 1) : 0;
                                                        @endphp
                                                        <span class="badge bg-{{ $persentase >= 75 ? 'success' : ($persentase >= 50 ? 'warning' : 'danger') }}">
                                                            {{ $persentase }}%
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td>: 
                                                        @if($presensi->isActive())
                                                            <span class="badge bg-success">Berlangsung</span>
                                                            <br><small>Sisa: {{ $presensi->getRemainingTime() }}</small>
                                                        @elseif(\Carbon\Carbon::now()->lt($presensi->waktu_mulai))
                                                            <span class="badge bg-warning">Menunggu</span>
                                                        @else
                                                            <span class="badge bg-danger">Berakhir</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <h6>Resume Kelas:</h6>
                                        <p class="text-muted">{{ $presensi->resume_kelas }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($presensi->isActive() || \Carbon\Carbon::now()->gt($presensi->waktu_mulai))
                                            <a href="{{ route('public.presensi.display', $presensi->kode_presensi) }}" 
                                               class="btn btn-primary" target="_blank">
                                                <i class="bi bi-display me-1"></i>Mode Display
                                            </a>
                                            
                                            <a href="{{ url('/presensi?kode=' . $presensi->kode_presensi) }}" 
                                               class="btn btn-info" target="_blank">
                                                <i class="bi bi-link-45deg me-1"></i>Link Presensi
                                            </a>
                                        @endif

                                        @if(\Carbon\Carbon::now()->lt($presensi->waktu_mulai))
                                            <a href="{{ route('presensi.edit', $presensi) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil me-1"></i>Edit Presensi
                                            </a>
                                        @endif

                                        <form action="{{ route('presensi.toggle-status', $presensi) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-{{ $presensi->is_active ? 'secondary' : 'success' }} w-100">
                                                <i class="bi bi-{{ $presensi->is_active ? 'pause' : 'play' }} me-1"></i>
                                                {{ $presensi->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <a href="{{ route('presensi.index') }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-left me-1"></i>Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Bagikan Kode</h6>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <div class="fs-2 fw-bold text-primary">{{ $presensi->kode_presensi }}</div>
                                        <small class="text-muted">Kode Presensi</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted small">Link Akses:</div>
                                        <div class="fw-bold">{{ url('/presensi') }}</div>
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm" onclick="copyCode()" id="copyBtn">
                                        <i class="bi bi-clipboard me-1" id="copyIcon"></i>
                                        <span id="copyText">Copy Kode</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Mahasiswa yang Sudah Presensi -->
                    @if($presensi->presensiMahasiswas->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Daftar Mahasiswa yang Sudah Presensi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>NIM</th>
                                                        <th>Nama</th>
                                                        <th>Prodi</th>
                                                        <th>Kelas</th>
                                                        <th>Waktu Presensi</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($presensi->presensiMahasiswas as $index => $presensiMhs)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $presensiMhs->nim }}</td>
                                                            <td>{{ $presensiMhs->nama_mahasiswa }}</td>
                                                            <td>{{ $presensiMhs->prodi }}</td>
                                                            <td>{{ $presensiMhs->kelas ?? '-' }}</td>
                                                            <td>{{ $presensiMhs->waktu_absen->format('H:i:s') }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $presensiMhs->status === 'hadir' ? 'success' : 'warning' }}">
                                                                    {{ ucfirst($presensiMhs->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
        
        @include('layouts.sidebar')
    </div>
</div>

<script>
    function copyCode() {
        const kodePresensi = '{{ $presensi->kode_presensi }}';
        const copyBtn = document.getElementById('copyBtn');
        const copyIcon = document.getElementById('copyIcon');
        const copyText = document.getElementById('copyText');
        
        // Ubah tampilan tombol sementara
        const originalClass = copyIcon.className;
        const originalText = copyText.textContent;
        
        copyIcon.className = 'bi bi-hourglass-split me-1';
        copyText.textContent = 'Menyalin...';
        copyBtn.disabled = true;
        
        // Menggunakan Clipboard API modern
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(kodePresensi).then(function() {
                // Berhasil disalin
                copyIcon.className = 'bi bi-check-circle me-1';
                copyText.textContent = 'Tersalin!';
                copyBtn.classList.remove('btn-outline-primary');
                copyBtn.classList.add('btn-success');
                
                // Kembalikan tampilan setelah 2 detik
                setTimeout(function() {
                    copyIcon.className = originalClass;
                    copyText.textContent = originalText;
                    copyBtn.classList.remove('btn-success');
                    copyBtn.classList.add('btn-outline-primary');
                    copyBtn.disabled = false;
                }, 2000);
                
                // Tampilkan notifikasi
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kode presensi telah disalin ke clipboard',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Kode presensi telah disalin ke clipboard!');
                }
            }).catch(function(err) {
                console.error('Gagal menyalin: ', err);
                fallbackCopyTextToClipboard(kodePresensi, copyBtn, copyIcon, copyText, originalClass, originalText);
            });
        } else {
            // Fallback untuk browser lama
            fallbackCopyTextToClipboard(kodePresensi, copyBtn, copyIcon, copyText, originalClass, originalText);
        }
    }

    function fallbackCopyTextToClipboard(text, copyBtn, copyIcon, copyText, originalClass, originalText) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        
        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                // Berhasil disalin
                copyIcon.className = 'bi bi-check-circle me-1';
                copyText.textContent = 'Tersalin!';
                copyBtn.classList.remove('btn-outline-primary');
                copyBtn.classList.add('btn-success');
                
                // Kembalikan tampilan setelah 2 detik
                setTimeout(function() {
                    copyIcon.className = originalClass;
                    copyText.textContent = originalText;
                    copyBtn.classList.remove('btn-success');
                    copyBtn.classList.add('btn-outline-primary');
                    copyBtn.disabled = false;
                }, 2000);
                
                // Tampilkan notifikasi
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kode presensi telah disalin ke clipboard',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Kode presensi telah disalin ke clipboard!');
                }
            } else {
                // Gagal menyalin
                copyIcon.className = 'bi bi-x-circle me-1';
                copyText.textContent = 'Gagal!';
                copyBtn.classList.remove('btn-outline-primary');
                copyBtn.classList.add('btn-danger');
                
                setTimeout(function() {
                    copyIcon.className = originalClass;
                    copyText.textContent = originalText;
                    copyBtn.classList.remove('btn-danger');
                    copyBtn.classList.add('btn-outline-primary');
                    copyBtn.disabled = false;
                }, 2000);
                
                alert('Gagal menyalin kode presensi');
            }
        } catch (err) {
            console.error('Fallback: Gagal menyalin', err);
            
            // Gagal menyalin
            copyIcon.className = 'bi bi-x-circle me-1';
            copyText.textContent = 'Gagal!';
            copyBtn.classList.remove('btn-outline-primary');
            copyBtn.classList.add('btn-danger');
            
            setTimeout(function() {
                copyIcon.className = originalClass;
                copyText.textContent = originalText;
                copyBtn.classList.remove('btn-danger');
                copyBtn.classList.add('btn-outline-primary');
                copyBtn.disabled = false;
            }, 2000);
            
            alert('Gagal menyalin kode presensi');
        }

        document.body.removeChild(textArea);
    }

    // Auto refresh untuk update real-time
    @if($presensi->isActive())
        setInterval(function() {
            location.reload();
        }, 30000);
    @endif
</script>
@endsection