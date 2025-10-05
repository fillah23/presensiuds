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
            margin-top: 0;
        }
        .countdown-main .row {
            align-items: flex-start;
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
        /* Samakan margin atas info-card kanan dengan countdown */
        @media (min-width: 992px) {
            .countdown-main {
                margin-top: 32px;
            }
            .info-card.mt-4.mt-lg-5 {
                margin-top: 32px !important;
            }
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
        
        /* Table styling for mahasiswa list */
        .table-dark {
            background-color: rgba(0, 0, 0, 0.3);
        }
        .table-dark th {
            background-color: rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.2);
            color: #ecf0f1;
            font-weight: 600;
        }
        .table-dark td {
            border-color: rgba(255, 255, 255, 0.1);
            color: #ecf0f1;
        }
        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(255, 255, 255, 0.05);
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
                            @if(!empty($presensi->prodi) && is_array($presensi->prodi))
                                @foreach($presensi->prodi as $index => $prodi)
                                    {{ $prodi }}@if($index < count($presensi->prodi) - 1), @endif
                                @endforeach
                            @else
                                {{ $presensi->prodi }}
                            @endif
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
                        <div class="stats-display">
                            <i class="fas fa-qrcode text-primary me-2"></i>
                            <span>Kode Presensi: </span> {{ $presensi->kode_presensi }}
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
                </div>

                <div class="col-lg-4 col-md-5">

                    <div class="info-card">
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
                <h6 class="h6 mb-3">
                    <i class="fas fa-users me-2"></i>
                    Mahasiswa yang Sudah Presensi ({{ $presensi->presensiMahasiswas->count() }}/{{ $totalMahasiswa }})
                </h6>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-sm">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">NIM</th>
                                <th style="width: 40%;">Nama Mahasiswa</th>
                                <th style="width: 20%;">Kelas</th>
                                <th style="width: 10%;">Waktu</th>
                                <th style="width: 10%;">Status</th>
                            </tr>
                        </thead>
                        <tbody id="mahasiswa-list">
                            @foreach($presensi->presensiMahasiswas as $index => $presensiMhs)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><small>{{ $presensiMhs->nim }}</small></td>
                                <td><small>{{ $presensiMhs->nama_mahasiswa }}</small></td>
                                <td><small>{{ $presensiMhs->kelas }}</small></td>
                                <td><small>{{ $presensiMhs->waktu_absen->format('H:i') }}</small></td>
                                <td>
                                    <span class="badge {{ $presensiMhs->status === 'hadir' ? 'bg-success' : 'bg-warning' }}" 
                                          style="font-size: 0.6rem;">
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