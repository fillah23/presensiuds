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
                            <h3>Edit Presensi</h3>
                            <p class="text-subtitle text-muted">{{ $presensi->nama_kelas }}</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('presensi.index') }}">Presensi</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('presensi.show', $presensi) }}">Detail</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Form Edit Presensi</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('presensi.update', $presensi) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="form-group mb-3">
                                            <label for="nama_kelas" class="form-label">Nama Kelas/Mata Kuliah</label>
                                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" 
                                                   id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $presensi->nama_kelas) }}" 
                                                   placeholder="Contoh: Pemrograman Web - Kelas A" required>
                                            @error('nama_kelas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="resume_kelas" class="form-label">Resume/Topik Kelas</label>
                                            <textarea class="form-control @error('resume_kelas') is-invalid @enderror" 
                                                      id="resume_kelas" name="resume_kelas" rows="3" 
                                                      placeholder="Masukkan topik atau materi yang akan dibahas..." required>{{ old('resume_kelas', $presensi->resume_kelas) }}</textarea>
                                            @error('resume_kelas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                    <input type="datetime-local" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                                           id="waktu_mulai" name="waktu_mulai" 
                                                           value="{{ old('waktu_mulai', $presensi->waktu_mulai->format('Y-m-d\TH:i')) }}" required>
                                                    @error('waktu_mulai')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="durasi_menit" class="form-label">Durasi (Menit)</label>
                                                    <select class="form-select @error('durasi_menit') is-invalid @enderror" 
                                                            id="durasi_menit" name="durasi_menit" required>
                                                        <option value="">Pilih Durasi</option>
                                                        <option value="15" {{ old('durasi_menit', $presensi->durasi_menit) == '15' ? 'selected' : '' }}>15 menit</option>
                                                        <option value="30" {{ old('durasi_menit', $presensi->durasi_menit) == '30' ? 'selected' : '' }}>30 menit</option>
                                                        <option value="45" {{ old('durasi_menit', $presensi->durasi_menit) == '45' ? 'selected' : '' }}>45 menit</option>
                                                        <option value="60" {{ old('durasi_menit', $presensi->durasi_menit) == '60' ? 'selected' : '' }}>60 menit</option>
                                                        <option value="90" {{ old('durasi_menit', $presensi->durasi_menit) == '90' ? 'selected' : '' }}>90 menit</option>
                                                        <option value="120" {{ old('durasi_menit', $presensi->durasi_menit) == '120' ? 'selected' : '' }}>120 menit</option>
                                                        <option value="180" {{ old('durasi_menit', $presensi->durasi_menit) == '180' ? 'selected' : '' }}>180 menit</option>
                                                    </select>
                                                    @error('durasi_menit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="batas_terlambat" class="form-label">Batas Keterlambatan (Menit)</label>
                                                    <select class="form-select @error('batas_terlambat') is-invalid @enderror" 
                                                            id="batas_terlambat" name="batas_terlambat" required>
                                                        <option value="">Pilih Batas Terlambat</option>
                                                        <option value="5" {{ old('batas_terlambat', $presensi->batas_terlambat) == '5' ? 'selected' : '' }}>5 menit</option>
                                                        <option value="10" {{ old('batas_terlambat', $presensi->batas_terlambat) == '10' ? 'selected' : '' }}>10 menit</option>
                                                        <option value="15" {{ old('batas_terlambat', $presensi->batas_terlambat) == '15' ? 'selected' : '' }}>15 menit</option>
                                                        <option value="20" {{ old('batas_terlambat', $presensi->batas_terlambat) == '20' ? 'selected' : '' }}>20 menit</option>
                                                        <option value="30" {{ old('batas_terlambat', $presensi->batas_terlambat) == '30' ? 'selected' : '' }}>30 menit</option>
                                                        <option value="45" {{ old('batas_terlambat', $presensi->batas_terlambat) == '45' ? 'selected' : '' }}>45 menit</option>
                                                        <option value="60" {{ old('batas_terlambat', $presensi->batas_terlambat) == '60' ? 'selected' : '' }}>60 menit</option>
                                                    </select>
                                                    @error('batas_terlambat')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">Waktu toleransi sebelum mahasiswa dianggap terlambat</div>
                                                </div>
                                            </div>
                                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="prodi" class="form-label">Program Studi</label>
                                    <select class="form-select @error('prodi') is-invalid @enderror" 
                                            id="prodi" name="prodi[]" multiple required>
                                        <option value="">Loading...</option>
                                    </select>
                                    @error('prodi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pilih satu atau lebih program studi. Tekan Ctrl/Cmd untuk memilih multiple.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select class="form-select @error('kelas') is-invalid @enderror" 
                                            id="kelas" name="kelas[]" multiple required>
                                        <option value="">Loading...</option>
                                    </select>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pilih satu atau lebih kelas. Tekan Ctrl/Cmd untuk memilih multiple.</small>
                                </div>
                            </div>
                        </div>                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle me-1"></i>Update Presensi
                                            </button>
                                            <a href="{{ route('presensi.show', $presensi) }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-left me-1"></i>Kembali
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="card-title">Info Presensi</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td><strong>Kode:</strong></td>
                                            <td>{{ $presensi->kode_presensi }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($presensi->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Nonaktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat:</strong></td>
                                            <td>{{ $presensi->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="card-title">Panduan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <small>Presensi hanya bisa diedit sebelum waktu mulai.</small>
                                    </div>
                                    
                                    <h6>Tips Edit Presensi:</h6>
                                    <ul class="small">
                                        <li>Pastikan waktu mulai tidak kurang dari 5 menit dari sekarang</li>
                                        <li>Perubahan akan mempengaruhi waktu selesai otomatis</li>
                                        <li>Kode presensi tidak akan berubah</li>
                                        <li>Mahasiswa yang sudah presensi tidak terpengaruh</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Waktu Server</h6>
                                </div>
                                <div class="card-body text-center">
                                    <div class="fs-4" id="current-time">{{ now()->format('H:i:s') }}</div>
                                    <div class="text-muted">{{ now()->format('d F Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
        @include('layouts.sidebar')
    </div>
</div>

<script>
    // Update current time
    setInterval(function() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        document.getElementById('current-time').textContent = timeString;
    }, 1000);

    // Set minimum datetime to 5 minutes from now
    const now = new Date();
    now.setMinutes(now.getMinutes() + 5);
    const minDateTime = now.toISOString().slice(0, 16);
    document.getElementById('waktu_mulai').setAttribute('min', minDateTime);

    // Initialize Select2 for Program Studi
    $(document).ready(function() {
        // Load program studi options first
        loadProdiOptions();
        
        // Initialize Select2 for Kelas (empty initially)
        $('#kelas').select2({
            placeholder: 'Loading...',
            allowClear: true,
            width: '100%'
        });
    });

    function loadProdiOptions() {
        fetch('{{ route("admin.presensi.get-prodi") }}')
            .then(response => response.json())
            .then(data => {
                const prodiSelect = document.getElementById('prodi');
                const currentProdis = @json(old('prodi', $presensi->prodi ?? []));
                
                // Check if response has error
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }
                
                // Check if data is array
                if (!Array.isArray(data)) {
                    alert('Invalid data format received');
                    return;
                }
                
                let options = '<option value="">Pilih Program Studi</option>';
                data.forEach(function(prodi) {
                    const selected = currentProdis.includes(prodi.id) ? 'selected' : '';
                    options += `<option value="${prodi.id}" ${selected}>${prodi.nama}</option>`;
                });
                
                prodiSelect.innerHTML = options;
                
                // Initialize Select2 after options loaded
                $('#prodi').select2({
                    placeholder: 'Pilih Program Studi (bisa lebih dari 1)',
                    allowClear: true,
                    width: '100%'
                });
                
                // Set current values if exists
                if (currentProdis && currentProdis.length > 0) {
                    $('#prodi').val(currentProdis).trigger('change');
                    // Load kelas for current prodi
                    loadKelasByMultipleProdis(currentProdis);
                }
                
                // Add event listener for prodi change
                $('#prodi').on('change', function() {
                    const selectedProdis = $(this).val();
                    if (selectedProdis && selectedProdis.length > 0) {
                        loadKelasByMultipleProdis(selectedProdis);
                    } else {
                        // Clear kelas options
                        $('#kelas').empty().append('<option value="">Pilih Prodi terlebih dahulu</option>');
                        $('#kelas').select2({
                            placeholder: 'Pilih Prodi terlebih dahulu',
                            allowClear: true,
                            width: '100%'
                        });
                    }
                });
            })
            .catch(error => {
                console.error('Error loading prodi:', error);
                alert('Gagal memuat data program studi');
            });
    }
    
    function loadKelasByMultipleProdis(prodiNames) {
        // Create query string for multiple prodis
        const prodiQuery = prodiNames.map(prodi => `prodi[]=${encodeURIComponent(prodi)}`).join('&');
        
        fetch(`{{ route("admin.presensi.get-kelas") }}?${prodiQuery}`)
            .then(response => response.json())
            .then(data => {
                const kelasSelect = document.getElementById('kelas');
                const currentKelas = @json(old('kelas', $presensi->kelas ?? []));
                
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }
                
                let options = '<option value="">Pilih Kelas</option>';
                
                if (Array.isArray(data) && data.length > 0) {
                    // Remove duplicates and sort
                    const uniqueKelas = [...new Set(data)].sort();
                    uniqueKelas.forEach(function(kelas) {
                        const selected = currentKelas.includes(kelas) ? 'selected' : '';
                        options += `<option value="${kelas}" ${selected}>${kelas}</option>`;
                    });
                } else {
                    options = '<option value="">Tidak ada kelas tersedia</option>';
                }
                
                kelasSelect.innerHTML = options;
                
                // Reinitialize Select2 for Kelas
                $('#kelas').select2({
                    placeholder: 'Pilih Kelas (bisa lebih dari 1)',
                    allowClear: true,
                    width: '100%'
                });
                
                // Set current values if exists
                if (currentKelas && currentKelas.length > 0) {
                    $('#kelas').val(currentKelas).trigger('change');
                }
            })
            .catch(error => {
                console.error('Error loading kelas:', error);
                alert('Gagal memuat data kelas');
            });
    }
</script>
@endsection