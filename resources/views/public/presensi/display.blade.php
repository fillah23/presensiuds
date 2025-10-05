<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Presensi - {{ $presensi->nama_kelas }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Remove overflow hidden to allow scrolling */
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .countdown-main {
                font-size: 3rem !important;
            }
            .countdown-number {
                font-size: 3rem !important;
                padding: 15px 8px !important;
            }
            .kode-presensi {
                font-size: 3rem !important;
                letter-spacing: 6px !important;
            }
        }
        
        @media (max-width: 768px) {
            .countdown-main {
                font-size: 2.5rem !important;
            }
            .countdown-number {
                font-size: 2.5rem !important;
                padding: 12px 6px !important;
            }
            .countdown-unit-label {
                font-size: 0.7rem !important;
            }
            .kode-presensi {
                font-size: 2.5rem !important;
                letter-spacing: 4px !important;
            }
            .stats-display {
                font-size: 1.2rem !important;
            }
            .info-card {
                padding: 20px !important;
                margin: 15px 0 !important;
            }
            .display-header {
                padding: 10px 0 !important;
            }
            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }
        
        @media (max-width: 576px) {
            .countdown-main {
                font-size: 2rem !important;
            }
            .countdown-number {
                font-size: 1.5rem !important;
                padding: 8px 4px !important;
            }
            .countdown-unit-label {
                font-size: 0.5rem !important;
            }
            .countdown-unit {
                margin: 0 2px !important;
            }
            .kode-presensi {
                font-size: 2rem !important;
                letter-spacing: 2px !important;
            }
            .stats-display {
                font-size: 1rem !important;
            }
            .info-card {
                padding: 15px !important;
                margin: 10px 0 !important;
            }
            .qr-display {
                padding: 20px !important;
            }
        }
        .display-header {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            margin-bottom: 20px;
        }
        .countdown-main {
            font-size: 4rem;
            font-weight: bold;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            line-height: 1;
        }
        .countdown-unit {
            text-align: center;
            margin: 0 10px;
        }
        .countdown-number {
            font-size: 4rem;
            font-weight: bold;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            line-height: 1;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px 10px;
            margin-bottom: 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .countdown-unit-label {
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            opacity: 0.9;
            color: #ecf0f1;
        }
        .countdown-label {
            font-size: 1.2rem;
            margin-top: 10px;
            opacity: 0.9;
        }
        .info-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .qr-display {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .kode-presensi {
            font-size: 4rem;
            font-weight: bold;
            color: #2c3e50;
            letter-spacing: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .stats-display {
            font-size: 1.5rem;
        }
        .live-indicator {
            animation: blink 1.5s infinite;
        }
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }
    </style>
</head>
<body>
    <div class="container-fluid h-100">
        <!-- Header -->
        <div class="display-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8 col-12 mb-2 mb-md-0">
                        <h1 class="mb-1 fs-3 fs-md-1">
                            <i class="fas fa-graduation-cap me-2 me-md-3"></i>
                            {{ $presensi->nama_kelas }}
                        </h1>
                        <p class="mb-1 fs-5 fs-md-4 opacity-75">
                            <i class="fas fa-user-tie me-2"></i>
                            {{ $presensi->dosen->name }}
                        </p>
                        <p class="mb-0 fs-6 fs-md-5 opacity-75">
                            <i class="fas fa-university me-2"></i>
                            {{ $presensi->prodi }}
                            @if(!empty($presensi->kelas) && is_array($presensi->kelas))
                                | <i class="fas fa-users me-1"></i>
                                @foreach($presensi->kelas as $index => $kelas)
                                    {{ $kelas }}@if($index < count($presensi->kelas) - 1), @endif
                                @endforeach
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 col-12 text-center text-md-end">
                        <div class="live-indicator">
                            <i class="fas fa-circle text-danger me-2"></i>
                            <span class="fs-6 fs-md-5">LIVE</span>
                        </div>
                        <div class="stats-display">
                            <i class="fas fa-users me-2"></i>
                            <span id="total-absen">0</span> Mahasiswa
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <div class="row">
                <!-- Countdown -->
                <div class="col-lg-8 col-md-7 mb-4 mb-md-0">
                    <div class="text-center">
                        <div class="countdown-main" id="countdown-display">
                            <div class="row justify-content-center">
                                <div class="col-3 col-md-2">
                                    <div class="countdown-unit">
                                        <div class="countdown-number" id="days">00</div>
                                        <div class="countdown-unit-label">DAYS</div>
                                    </div>
                                </div>
                                <div class="col-3 col-md-2">
                                    <div class="countdown-unit">
                                        <div class="countdown-number" id="hours">00</div>
                                        <div class="countdown-unit-label">HOURS</div>
                                    </div>
                                </div>
                                <div class="col-3 col-md-2">
                                    <div class="countdown-unit">
                                        <div class="countdown-number" id="minutes">00</div>
                                        <div class="countdown-unit-label">MINUTES</div>
                                    </div>
                                </div>
                                <div class="col-3 col-md-2">
                                    <div class="countdown-unit">
                                        <div class="countdown-number" id="seconds">00</div>
                                        <div class="countdown-unit-label">SECONDS</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="countdown-label">
                            <i class="fas fa-clock me-2"></i>
                            SISA WAKTU PRESENSI
                        </div>
                    </div>

                    <!-- Jadwal Info -->
                    <div class="info-card mt-4 mt-lg-5">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="fas fa-play-circle fa-2x text-success mb-2 d-none d-md-block"></i>
                                <i class="fas fa-play-circle fa-lg text-success mb-2 d-md-none"></i>
                                <h6 class="h6 d-md-none">Mulai</h6>
                                <h5 class="d-none d-md-block">Waktu Mulai</h5>
                                <p class="fs-5 fs-md-4">{{ $presensi->waktu_mulai->format('H:i') }}</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-hourglass-half fa-2x text-warning mb-2 d-none d-md-block"></i>
                                <i class="fas fa-hourglass-half fa-lg text-warning mb-2 d-md-none"></i>
                                <h6 class="h6 d-md-none">Durasi</h6>
                                <h5 class="d-none d-md-block">Durasi</h5>
                                <p class="fs-5 fs-md-4">{{ $presensi->durasi_menit }} menit</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-stop-circle fa-2x text-danger mb-2 d-none d-md-block"></i>
                                <i class="fas fa-stop-circle fa-lg text-danger mb-2 d-md-none"></i>
                                <h6 class="h6 d-md-none">Selesai</h6>
                                <h5 class="d-none d-md-block">Waktu Selesai</h5>
                                <p class="fs-5 fs-md-4">{{ $presensi->waktu_selesai->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code & Instructions -->
                <div class="col-lg-4 col-md-5">
                    <div class="qr-display">
                        <h5 class="h5 h-md-4 text-dark mb-3">
                            <i class="fas fa-qrcode text-primary me-2"></i>
                            Kode Presensi
                        </h5>
                        <div class="kode-presensi">
                            {{ $presensi->kode_presensi }}
                        </div>
                        <p class="text-muted mt-3 mb-0 small">
                            Scan atau masukkan kode di atas
                        </p>
                    </div>

                    <div class="info-card">
                        <h6 class="h6">
                            <i class="fas fa-mobile-alt me-2"></i>
                            Cara Presensi:
                        </h6>
                        <ol class="small mb-0">
                            <li>Buka browser di HP</li>
                            <li>Kunjungi: <br><strong class="text-break">{{ url('/presensi') }}</strong></li>
                            <li>Masukkan kode presensi</li>
                            <li>Input NIM Anda</li>
                            <li>Klik Submit Presensi</li>
                        </ol>
                    </div>

                    <!-- Program Studi Info -->
                    <div class="info-card">
                        <h6>
                            <i class="fas fa-university me-2"></i>
                            Program Studi:
                        </h6>
                        <p class="mb-2 fs-6 fs-md-5">
                            <strong>{{ $presensi->prodi }}</strong>
                        </p>
                        @if(!empty($presensi->kelas) && is_array($presensi->kelas))
                            <h6 class="mt-3">
                                <i class="fas fa-users me-2"></i>
                                Kelas:
                            </h6>
                            <div class="mb-2">
                                @foreach($presensi->kelas as $kelas)
                                    <span class="badge bg-primary me-1 mb-1">{{ $kelas }}</span>
                                @endforeach
                            </div>
                        @endif
                        <small class="text-muted">Target: {{ $totalMahasiswa }} mahasiswa</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resume Kelas -->
        <div class="container mt-3 mt-md-4">
            <div class="info-card">
                <h6 class="h6">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Resume Kelas:
                </h6>
                <p class="mb-0 small">{{ $presensi->resume_kelas }}</p>
            </div>
        </div>

        <!-- Daftar Mahasiswa yang Sudah Presensi -->
        @if($presensi->presensiMahasiswas->count() > 0)
        <div class="container mt-3">
            <div class="info-card">
                <h6 class="h6">
                    <i class="fas fa-users me-2"></i>
                    Mahasiswa yang Sudah Presensi ({{ $presensi->presensiMahasiswas->count() }}/{{ $totalMahasiswa }})
                </h6>
                <div class="row" id="mahasiswa-list">
                    @foreach($presensi->presensiMahasiswas as $presensiMhs)
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-2">
                        <div class="p-2 bg-success bg-opacity-20 border border-success rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1 me-2">
                                    <div class="fw-bold small text-truncate">{{ $presensiMhs->nama_mahasiswa }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $presensiMhs->nim }}</div>
                                </div>
                                <div class="text-end flex-shrink-0">
                                    <div style="font-size: 0.7rem;">{{ $presensiMhs->waktu_absen->format('H:i') }}</div>
                                    <span class="badge bg-success" style="font-size: 0.55rem;">{{ ucfirst($presensiMhs->status) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let countdownInterval;
        let syncInterval;
        let presensiCode = '{{ $presensi->kode_presensi }}';
        let targetEndTime = null;
        let isPresensiActive = true;
        
        // Function to update countdown display
        function updateCountdownDisplay(days, hours, minutes, seconds = 0) {
            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }
        
        // Function to calculate and display real-time countdown
        function updateRealTimeCountdown() {
            console.log('updateRealTimeCountdown called - targetEndTime:', targetEndTime, 'isPresensiActive:', isPresensiActive);
            
            if (!targetEndTime || !isPresensiActive) {
                console.log('No target time or presensi not active - showing 00:00:00:00');
                updateCountdownDisplay(0, 0, 0, 0);
                return;
            }
            
            const now = new Date().getTime();
            const distance = targetEndTime - now;
            
            console.log('Current time:', now, 'Distance:', distance);
            
            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                console.log('Calculated time - Days:', days, 'Hours:', hours, 'Minutes:', minutes, 'Seconds:', seconds);
                updateCountdownDisplay(days, hours, minutes, seconds);
            } else {
                console.log('Time expired - showing 00:00:00:00');
                updateCountdownDisplay(0, 0, 0, 0);
                isPresensiActive = false;
            }
        }
        
        // Function to sync with server
        function syncWithServer() {
            console.log('Syncing with server...');
            fetch(`{{ route('public.presensi.info') }}?kode=${presensiCode}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Full API Response:', JSON.stringify(data, null, 2));
                    if (data.success) {
                        // Update total absen
                        document.getElementById('total-absen').textContent = data.data.total_absen;
                        
                        // Parse remaining time to set target end time
                        const remainingTime = data.data.remaining_time;
                        const status = data.data.status;
                        
                        console.log('Remaining time:', remainingTime);
                        console.log('Status:', status);
                        console.log('Is Active:', data.data.is_active);
                        
                        // Check if presensi is active - bisa berlangsung atau belum_mulai
                        if ((status === 'berlangsung' || status === 'belum_mulai') && remainingTime && 
                            remainingTime !== '00:00:00' && 
                            remainingTime !== 'Presensi telah berakhir') {
                            
                            isPresensiActive = true;
                            console.log('Presensi is active, parsing time...');
                            
                            // Parse HH:MM:SS format
                            if (remainingTime.includes(':') && remainingTime.split(':').length === 3) {
                                const parts = remainingTime.split(':');
                                const hours = parseInt(parts[0]) || 0;
                                const minutes = parseInt(parts[1]) || 0;
                                const seconds = parseInt(parts[2]) || 0;
                                const totalSeconds = hours * 3600 + minutes * 60 + seconds;
                                
                                console.log('Parsed HH:MM:SS - Hours:', hours, 'Minutes:', minutes, 'Seconds:', seconds);
                                console.log('Total seconds:', totalSeconds);
                                
                                if (totalSeconds > 0) {
                                    // Set target end time
                                    targetEndTime = new Date().getTime() + (totalSeconds * 1000);
                                    console.log('Target end time set to:', new Date(targetEndTime));
                                } else {
                                    console.log('Total seconds is 0 or negative');
                                    isPresensiActive = false;
                                }
                            }
                            // Parse text format like "Mulai dalam X hari, Y jam, Z menit"
                            else if (remainingTime.includes('hari') || remainingTime.includes('jam') || remainingTime.includes('menit') || remainingTime.includes('Mulai dalam')) {
                                let totalSeconds = 0;
                                
                                const dayMatch = remainingTime.match(/(\d+)\s*hari/);
                                if (dayMatch) totalSeconds += parseInt(dayMatch[1]) * 24 * 3600;
                                
                                const hourMatch = remainingTime.match(/(\d+)\s*jam/);
                                if (hourMatch) totalSeconds += parseInt(hourMatch[1]) * 3600;
                                
                                const minuteMatch = remainingTime.match(/(\d+)\s*menit/);
                                if (minuteMatch) totalSeconds += parseInt(minuteMatch[1]) * 60;
                                
                                console.log('Parsed text format - Total seconds:', totalSeconds);
                                
                                if (totalSeconds > 0) {
                                    targetEndTime = new Date().getTime() + (totalSeconds * 1000);
                                    console.log('Target end time set to:', new Date(targetEndTime));
                                } else {
                                    console.log('No valid time found in text format');
                                    isPresensiActive = false;
                                }
                            }
                            // Fallback: try to parse any number as minutes
                            else {
                                const numberMatch = remainingTime.match(/(\d+)/);
                                if (numberMatch) {
                                    const minutes = parseInt(numberMatch[1]);
                                    const totalSeconds = minutes * 60;
                                    console.log('Fallback parsing - assuming', minutes, 'minutes');
                                    
                                    if (totalSeconds > 0) {
                                        targetEndTime = new Date().getTime() + (totalSeconds * 1000);
                                        console.log('Target end time set to:', new Date(targetEndTime));
                                    }
                                }
                            }
                        } else {
                            console.log('Presensi not active or ended. Status:', status, 'Remaining time:', remainingTime);
                            isPresensiActive = false;
                            targetEndTime = null;
                        }
                    } else {
                        console.log('API response not successful:', data);
                        isPresensiActive = false;
                        targetEndTime = null;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    isPresensiActive = false;
                    targetEndTime = null;
                });
        }
        
        // Initialize countdown
        function initCountdown() {
            // Initial sync with server
            syncWithServer();
            
            // Start real-time countdown (updates every second)
            countdownInterval = setInterval(updateRealTimeCountdown, 1000);
            
            // Sync with server every 30 seconds
            syncInterval = setInterval(syncWithServer, 30000);
        }
        
        // Start everything when page loads
        initCountdown();
        
        // Auto refresh halaman setiap 5 menit untuk update daftar mahasiswa
        setInterval(() => {
            location.reload();
        }, 300000); // 5 menit
    </script>
</body>
</html>