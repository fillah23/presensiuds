<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Mahasiswa - UDS</title>
    <link rel="shortcut icon" href="{{ asset('images/kodekoding-logo-icon-152.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .presensi-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .presensi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .class-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }
        .countdown-display {
            font-size: 3rem;
            font-weight: bold;
            color: #2c3e50;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .presensi-info {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e3f2fd;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-presensi {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-presensi:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
        }
        .btn-presensi:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
        }
        .btn-admin-login {
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .btn-admin-login:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }
        .status-active {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            color: white;
        }
        .status-waiting {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            color: white;
        }
        .glass-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .pagination .page-link {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #667eea;
            border-radius: 8px;
            margin: 0 2px;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
        }
        .pagination .page-link:hover {
            background: rgba(255, 255, 255, 1);
            color: #764ba2;
            border-color: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .pagination .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.5);
            color: rgba(102, 126, 234, 0.5);
            border-color: rgba(255, 255, 255, 0.2);
        }
        .countdown-card {
            animation: pulse 2s infinite;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        .countdown-time {
            font-family: 'Courier New', monospace;
            font-size: 1.1em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="text-white mb-2">
                <img src="{{ asset('images/logo-presensi-kodekoding-alt-white.png') }}" 
                     alt="Logo Presensi" 
                     height="40" 
                     class="me-2">
                
            </h1>
            <p class="text-white-50">Kode Koding</p>
            
            <!-- Tombol Search dan Login -->
            <div class="mt-3">
                <button type="button" class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="fas fa-search me-2"></i>Cari dengan Kode
                </button>
                {{-- <a href="{{ route('login') }}" class="btn btn-outline-light btn-admin-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Admin/Dosen
                </a> --}}
            </div>
        </div>

        @if(!$kode && !$presensi)
            <!-- Daftar Presensi Aktif -->
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    @if($presensiList && $presensiList->count() > 0)
                        <div class="text-center mb-4">
                            <h3 class="text-white mb-3">
                                <i class="fas fa-calendar-check me-2"></i>
                                Presensi Tersedia
                            </h3>
                            <p class="text-white-50">Klik card untuk mengikuti presensi</p>
                        </div>

                        <div class="row">
                            @foreach($presensiList as $item)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $isActive = $item->isActive();
                                    $isWaiting = $now->lt($item->waktu_mulai);
                                    $statusClass = $isActive ? 'status-active' : ($isWaiting ? 'status-waiting' : 'status-expired');
                                    $statusText = $isActive ? 'Berlangsung' : ($isWaiting ? 'Belum Mulai' : 'Berakhir');
                                    $statusIcon = $isActive ? 'fas fa-play-circle' : ($isWaiting ? 'fas fa-clock' : 'fas fa-stop-circle');
                                @endphp
                                
                                <div class="col-lg-6 col-xl-4 mb-4">
                                    <a href="{{ route('public.presensi.index', ['kode' => $item->kode_presensi]) }}" class="class-card d-block p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="flex-grow-1">
                                                <h5 class="fw-bold mb-1">{{ $item->nama_kelas }}</h5>
                                                <p class="text-muted mb-1">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ $item->dosen->name }}
                                                </p>
                                                <!-- Tampilkan Program Studi dan Kelas -->
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-university me-1"></i>
                                                        {{ $item->prodi }}
                                                    </small>
                                                    @if(!empty($item->kelas) && is_array($item->kelas))
                                                        <div class="mt-1">
                                                            <small class="text-muted me-1">
                                                                <i class="fas fa-users me-1"></i>Kelas:
                                                            </small>
                                                            @foreach($item->kelas as $kelas)
                                                                <span class="badge bg-light text-dark me-1" style="font-size: 0.65rem;">{{ $kelas }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="badge {{ $statusClass }} px-3 py-2">
                                                <i class="{{ $statusIcon }} me-1"></i>
                                                {{ $statusText }}
                                            </span>
                                        </div>

                                        @if($isWaiting)
                                            <!-- Countdown untuk presensi yang belum mulai -->
                                            <div class="text-center mb-3">
                                                <div class="countdown-card" 
                                                     data-target="{{ $item->waktu_mulai->format('Y-m-d H:i:s') }}"
                                                     style="background: linear-gradient(45deg, #f39c12, #e67e22); 
                                                            color: white; 
                                                            padding: 10px; 
                                                            border-radius: 10px; 
                                                            font-weight: bold;">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Dimulai dalam: <span class="countdown-time">Loading...</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="text-center p-2 bg-light rounded">
                                                    <i class="fas fa-play text-success mb-1"></i>
                                                    <div class="small text-muted">Mulai</div>
                                                    <div class="fw-bold">{{ $item->waktu_mulai->format('H:i') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center p-2 bg-light rounded">
                                                    <i class="fas fa-stop text-danger mb-1"></i>
                                                    <div class="small text-muted">Selesai</div>
                                                    <div class="fw-bold">{{ $item->waktu_selesai->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 pt-3 border-top">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <small class="text-muted">
                                                        <i class="fas fa-university me-1"></i>
                                                        {{ $item->prodi }}
                                                    </small>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="badge bg-primary">
                                                        {{ $item->kode_presensi }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($presensiList->hasPages())
                            <div class="d-flex justify-content-center mt-5">
                                {{ $presensiList->links('custom.pagination') }}
                            </div>
                        @endif

                    @else
                        <div class="text-center">
                            <div class="glass-card rounded-4 p-5 mx-auto" style="max-width: 500px;">
                                <i class="fas fa-calendar-times fa-4x text-white mb-3 opacity-50"></i>
                                <h4 class="text-white mb-3">Tidak Ada Presensi Aktif</h4>
                                <p class="text-white-50 mb-4">Saat ini tidak ada presensi yang sedang berlangsung atau menunggu dimulai</p>
                                <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <i class="fas fa-search me-2"></i>Cari dengan Kode
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Halaman Presensi Spesifik -->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="presensi-card p-4">
                        @if($error)
                            <!-- Error Message -->
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h4 class="text-danger">{{ $error }}</h4>
                                <a href="{{ route('public.presensi.index') }}" class="btn btn-secondary mt-3">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        @else
                            <!-- Presensi Active -->
                            <div class="presensi-info text-center">
                                <h4><i class="fas fa-chalkboard-teacher me-2"></i>{{ $presensi->nama_kelas }}</h4>
                                <p class="mb-1"><strong>Dosen:</strong> {{ $presensi->dosen->name }}</p>
                                <p class="mb-1"><strong>Program Studi:</strong> {{ $presensi->prodi }}</p>
                                @if(!empty($presensi->kelas) && is_array($presensi->kelas))
                                    <p class="mb-1">
                                        <strong>Kelas:</strong> 
                                        @foreach($presensi->kelas as $index => $kelas)
                                            <span class="badge bg-light text-dark me-1">{{ $kelas }}</span>@if($index < count($presensi->kelas) - 1),@endif
                                        @endforeach
                                    </p>
                                @endif
                                <p class="mb-1"><strong>Waktu:</strong> {{ $presensi->waktu_mulai->format('H:i') }} - {{ $presensi->waktu_selesai->format('H:i') }}</p>
                                <p class="mb-0"><strong>Kode:</strong> <span class="badge bg-light text-dark">{{ $presensi->kode_presensi }}</span></p>
                            </div>

                            <!-- Countdown Timer -->
                            <div class="text-center mb-4">
                                <div class="countdown-display" id="countdown">
                                    <i class="fas fa-clock text-primary"></i>
                                    <span id="time-remaining">Loading...</span>
                                </div>
                                <p class="text-muted">Sisa waktu presensi</p>
                                <div class="status-badge bg-success text-white" id="status-badge">
                                    <i class="fas fa-circle-check me-1"></i>
                                    <span id="total-absen">0</span> mahasiswa telah presensi
                                </div>
                            </div>

                            <!-- Form Presensi -->
                            <div id="presensi-form">
                                <form id="form-submit-presensi">
                                    @csrf
                                    <input type="hidden" name="kode_presensi" value="{{ $presensi->kode_presensi }}">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-id-card me-2"></i>NIM Anda
                                        </label>
                                        <input type="text" name="nim" id="nim" class="form-control text-center" 
                                               placeholder="Contoh: 12345678" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-presensi w-100 py-3" id="btn-submit">
                                        <i class="fas fa-user-check me-2"></i>Submit Presensi
                                    </button>
                                </form>
                            </div>

                            <!-- Result Message -->
                            <div id="result-message" class="mt-3" style="display: none;"></div>

                            <!-- Links -->
                            <div class="text-center mt-4">
                                <a href="{{ route('public.presensi.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-home me-1"></i>Beranda
                                </a>
                                <a href="{{ route('public.presensi.display', $presensi->kode_presensi) }}" 
                                   class="btn btn-outline-primary" target="_blank">
                                    <i class="fas fa-tv me-1"></i>Mode Display
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal Search -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="searchModalLabel">
                            <i class="fas fa-search me-2"></i>Cari Presensi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('public.presensi.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Kode Presensi</label>
                                <input type="text" name="kode" class="form-control text-center text-uppercase" 
                                       placeholder="Masukkan 8 digit kode" maxlength="8" required
                                       style="letter-spacing: 2px; font-size: 1.2rem;">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-search me-2"></i>Cari Presensi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-5 pb-4">
            <p class="text-white-50 small mb-2">
                © {{ date('Y') }} Made with ❤️ by Kode Koding
            </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Script untuk interaksi homepage dan modal -->
    <script>
        $(document).ready(function() {
            // Handle hover effect pada kartu
            $('.class-card').hover(
                function() {
                    $(this).css('transform', 'translateY(-10px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
            
            // Handle search modal
            $('#searchModal input[name="kode"]').on('input', function() {
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            });
            
            // Auto focus ketika modal dibuka
            $('#searchModal').on('shown.bs.modal', function() {
                $('#searchModal input[name="kode"]').focus();
            });
            
            // Countdown untuk cards yang belum mulai
            function updateCardCountdowns() {
                $('.countdown-card').each(function() {
                    const target = new Date($(this).data('target')).getTime();
                    const now = new Date().getTime();
                    const distance = target - now;
                    
                    if (distance > 0) {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        
                        let countdownText = '';
                        if (days > 0) {
                            countdownText = days + 'h ' + hours + 'j ' + minutes + 'm ' + seconds + 'd';
                        } else if (hours > 0) {
                            countdownText = hours + 'j ' + minutes + 'm ' + seconds + 'd';
                        } else if (minutes > 0) {
                            countdownText = minutes + 'm ' + seconds + 'd';
                        } else {
                            countdownText = seconds + 'd';
                        }
                        
                        $(this).find('.countdown-time').text(countdownText);
                    } else {
                        // Countdown selesai, refresh halaman untuk update status
                        location.reload();
                    }
                });
            }
            
            // Update countdown setiap detik jika ada cards countdown
            if ($('.countdown-card').length > 0) {
                updateCardCountdowns(); // Update pertama kali
                setInterval(updateCardCountdowns, 1000); // Update setiap detik
            }
        });
    </script>
    
    @if($presensi && !$error)
    <script>
        let countdownInterval;
        let presensiCode = '{{ $presensi->kode_presensi }}';
        
        // Update countdown dan info presensi
        function updatePresensiInfo() {
            fetch(`{{ route('public.presensi.info') }}?kode=${presensiCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('time-remaining').textContent = data.data.remaining_time;
                        document.getElementById('total-absen').textContent = data.data.total_absen;
                        
                        const nimInput = document.getElementById('nim');
                        const submitBtn = document.getElementById('btn-submit');
                        
                        if (data.data.status === 'belum_mulai') {
                            // Presensi belum mulai - tampilkan countdown, disable form
                            document.getElementById('countdown').innerHTML = data.data.remaining_time;
                            nimInput.disabled = true;
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<i class="fas fa-clock me-2"></i>Belum Dimulai';
                            document.getElementById('status-badge').className = 'status-badge bg-warning text-white';
                            document.getElementById('status-badge').innerHTML = '<i class="fas fa-clock me-1"></i>MENUNGGU DIMULAI';
                        } else if (data.data.status === 'berakhir') {
                            // Presensi sudah berakhir - tampilkan info, disable form
                            document.getElementById('countdown').innerHTML = 'Waktu Habis';
                            nimInput.disabled = true;
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Presensi Ditutup';
                            document.getElementById('status-badge').className = 'status-badge bg-secondary text-white';
                            document.getElementById('status-badge').innerHTML = '<i class="fas fa-times-circle me-1"></i>SELESAI';
                            clearInterval(countdownInterval);
                        } else {
                            // Presensi sedang berlangsung - enable form
                            document.getElementById('countdown').innerHTML = data.data.remaining_time;
                            nimInput.disabled = false;
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Submit Presensi';
                            document.getElementById('status-badge').className = 'status-badge bg-success text-white';
                            document.getElementById('status-badge').innerHTML = '<i class="fas fa-circle-check me-1"></i><span id="total-absen">' + data.data.total_absen + '</span> mahasiswa telah presensi';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        
        // Mulai countdown
        updatePresensiInfo();
        countdownInterval = setInterval(updatePresensiInfo, 1000);
        
        // Handle form submit
        document.getElementById('form-submit-presensi').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('btn-submit');
            const nimInput = document.getElementById('nim');
            
            // Cek jika form disabled (presensi belum mulai atau sudah berakhir)
            if (submitBtn.disabled || nimInput.disabled) {
                return false;
            }
            
            const originalText = submitBtn.innerHTML;
            
            // Disable form
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            
            const formData = new FormData(this);
            
            fetch('{{ route('public.presensi.submit') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Berhasil!',
                        html: `
                            <div class="text-start">
                                <p><strong>Nama:</strong> ${data.data.nama}</p>
                                <p><strong>NIM:</strong> ${data.data.nim}</p>
                                <p><strong>Prodi:</strong> ${data.data.prodi}</p>
                                <p><strong>Kelas:</strong> ${data.data.kelas}</p>
                                <p><strong>Status:</strong> <span class="badge bg-${data.data.status === 'hadir' ? 'success' : 'warning'}">${data.data.status.toUpperCase()}</span></p>
                                <p><strong>Waktu:</strong> ${data.data.waktu}</p>
                            </div>
                        `,
                        confirmButtonText: 'OK'
                    });
                    
                    // Hide form
                    document.getElementById('presensi-form').style.display = 'none';
                    
                    // Show success message
                    document.getElementById('result-message').innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Presensi Anda telah tercatat! Terima kasih.
                        </div>
                    `;
                    document.getElementById('result-message').style.display = 'block';
                    
                } else {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Presensi Gagal',
                        text: data.message,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Silakan coba lagi',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                // Re-enable form hanya jika presensi masih berlangsung
                updatePresensiInfo(); // Update status terbaru
            });
        });
    </script>
    @endif
</body>
</html>