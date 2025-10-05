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
                            <h3>Kelola Presensi</h3>
                            <p class="text-subtitle text-muted">Daftar presensi yang telah dibuat</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Presensi</li>
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
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Daftar Presensi</h5>
                            <a href="{{ route('presensi.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Buat Presensi Baru
                            </a>
                        </div>
                        <div class="card-body">
                            @if($presensis->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped" id="presensiTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kelas</th>
                                                <th>Kode</th>
                                                <th>Waktu</th>
                                                <th>Durasi</th>
                                                <th>Peserta</th>
                                                <th>Status</th>
                                                <th>Jumlah Absen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($presensis as $index => $presensi)
                                                <tr>
                                                    <td>{{ $presensis->firstItem() + $index }}</td>
                                                    <td>
                                                        <strong>{{ $presensi->nama_kelas }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ Str::limit($presensi->resume_kelas, 50) }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $presensi->kode_presensi }}</span>
                                                    </td>
                                                    <td>
                                                        <i class="bi bi-calendar me-1"></i>{{ $presensi->waktu_mulai->format('d/m/Y') }}<br>
                                                        <i class="bi bi-clock me-1"></i>{{ $presensi->waktu_mulai->format('H:i') }} - {{ $presensi->waktu_selesai->format('H:i') }}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $presensi->durasi_menit }} menit</span>
                                                    </td>
                                                    <td>
                                                        <i class="bi bi-mortarboard me-1"></i>{{ $presensi->prodi }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $now = \Carbon\Carbon::now();
                                                            $isActive = $presensi->isActive();
                                                            $isUpcoming = $now->lt($presensi->waktu_mulai);
                                                            $isFinished = $now->gt($presensi->waktu_selesai);
                                                        @endphp
                                                        
                                                        @if(!$presensi->is_active)
                                                            <span class="badge bg-secondary">
                                                                <i class="bi bi-pause me-1"></i>Nonaktif
                                                            </span>
                                                        @elseif($isActive)
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-play me-1"></i>Berlangsung
                                                            </span>
                                                            <br><small class="text-success">{{ $presensi->getRemainingTime() }}</small>
                                                        @elseif($isUpcoming)
                                                            <span class="badge bg-warning">
                                                                <i class="bi bi-clock me-1"></i>Menunggu
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger">
                                                                <i class="bi bi-stop me-1"></i>Berakhir
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $presensi->getAbsentMahasiswas() }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('presensi.show', $presensi) }}" 
                                                               class="btn btn-sm btn-info" title="Detail">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            
                                                            @if($now->lt($presensi->waktu_mulai))
                                                                <a href="{{ route('presensi.edit', $presensi) }}" 
                                                                   class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                            @endif
                                                            
                                                            <form action="{{ route('presensi.toggle-status', $presensi) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="btn btn-sm {{ $presensi->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                                        title="{{ $presensi->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                                    <i class="bi bi-{{ $presensi->is_active ? 'pause' : 'play' }}"></i>
                                                                </button>
                                                            </form>
                                                            
                                                            @if($now->lt($presensi->waktu_mulai))
                                                                <form action="{{ route('presensi.destroy', $presensi) }}" 
                                                                      method="POST" class="d-inline"
                                                                      onsubmit="return confirm('Yakin ingin menghapus presensi ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                        
                                                        @if($isActive || $now->gt($presensi->waktu_mulai))
                                                            <div class="mt-1">
                                                                <a href="{{ route('public.presensi.display', $presensi->kode_presensi) }}" 
                                                                   class="btn btn-sm btn-outline-primary" target="_blank" title="Mode Display">
                                                                    <i class="bi bi-display"></i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-center mt-3">
                                    {{-- Pagination handled by DataTables --}}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-clipboard-x display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada presensi yang dibuat</h5>
                                    <p class="text-muted">Klik tombol "Buat Presensi Baru" untuk memulai</p>
                                    <a href="{{ route('presensi.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>Buat Presensi Pertama
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
        @include('layouts.sidebar')
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Auto refresh setiap 30 detik untuk update status real-time
    setInterval(function() {
        location.reload();
    }, 30000);

    // Inisialisasi DataTables
    $(document).ready(function() {
        $('#presensiTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[1, 'asc']]
        });
    });
</script>
@endsection