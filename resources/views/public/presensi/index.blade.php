<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Mahasiswa - UDS</title>
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
        .expired {
            color: #e74c3c;
            font-weight: bold;
        }
        .waiting {
            color: #f39c12;
            font-weight: bold;
        }
        .loading {
            opacity: 0.7;
            pointer-events: none;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center mb-4">
                    <h1 class="text-white mb-2">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Sistem Presensi UDS
                    </h1>
                    <p class="text-white-50">Universitas Dr Soebandi</p>
                    
                    <!-- Tombol Login untuk Admin/Dosen -->
                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm btn-admin-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Admin/Dosen
                        </a>
                    </div>
                </div>

                <div class="presensi-card p-4">
                    @if(!$kode)
                        <!-- Form Input Kode Presensi -->
                        <div class="text-center mb-4">
                            <i class="fas fa-qrcode fa-3x text-primary mb-3"></i>
                            <h3>Masukkan Kode Presensi</h3>
                            <p class="text-muted">Dapatkan kode presensi dari dosen Anda</p>
                        </div>

                        <form action="{{ route('public.presensi.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Kode Presensi</label>
                                <input type="text" name="kode" class="form-control text-center text-uppercase" 
                                       placeholder="Masukkan 8 digit kode" maxlength="8" required
                                       style="letter-spacing: 2px; font-size: 1.2rem;">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-search me-2"></i>Cari Presensi
                            </button>
                        </form>
                    @else
                        @if($error)
                            <!-- Error Message -->
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h4 class="text-danger">{{ $error }}</h4>
                                <a href="{{ route('public.presensi.index') }}" class="btn btn-secondary mt-3">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        @else
                            <!-- Presensi Active -->
                            <div class="presensi-info text-center">
                                <h4><i class="fas fa-chalkboard-teacher me-2"></i>{{ $presensi->nama_kelas }}</h4>
                                <p class="mb-1"><strong>Dosen:</strong> {{ $presensi->dosen->name }}</p>
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
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                                <a href="{{ route('public.presensi.display', $presensi->kode_presensi) }}" 
                                   class="btn btn-outline-primary" target="_blank">
                                    <i class="fas fa-tv me-1"></i>Mode Display
                                </a>
                            </div>
                        @endif
                    @endif
                </div>

                <div class="text-center mt-4">
                    <p class="text-white-50 small mb-2">
                        © {{ date('Y') }} Universitas Dr Soebandi - Sistem Presensi Digital
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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