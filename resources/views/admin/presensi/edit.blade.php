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
                                                    </select>
                                                    @error('durasi_menit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="prodi" class="form-label">Program Studi</label>
                                                    <select class="form-select @error('prodi') is-invalid @enderror" 
                                                            id="prodi" name="prodi" required>
                                                        <option value="{{ old('prodi', $presensi->prodi) }}" selected>
                                                            {{ old('prodi', $presensi->prodi) }}
                                                        </option>
                                                    </select>
                                                    @error('prodi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
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
    });

    function loadProdiOptions() {
        fetch('{{ route("admin.presensi.get-prodi") }}')
            .then(response => response.json())
            .then(data => {
                const prodiSelect = document.getElementById('prodi');
                const currentProdi = '{{ old("prodi", $presensi->prodi) }}';
                
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
                    const selected = prodi.id == currentProdi ? 'selected' : '';
                    options += `<option value="${prodi.id}" ${selected}>${prodi.nama}</option>`;
                });
                
                prodiSelect.innerHTML = options;
                
                // Initialize Select2 after options loaded
                $('#prodi').select2({
                    placeholder: 'Pilih Program Studi',
                    allowClear: true,
                    width: '100%'
                });
                
                // Set current value if exists
                if (currentProdi) {
                    $('#prodi').val(currentProdi).trigger('change');
                }
            })
            .catch(error => {
                console.error('Error loading prodi:', error);
                alert('Gagal memuat data program studi');
            });
    }
</script>
@endsection