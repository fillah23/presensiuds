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
                            <h3>Data Mahasiswa</h3>
                            <p class="text-subtitle text-muted">Kelola Data Mahasiswa Universitas</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    @if(Auth::user()->role->name === 'superadmin')
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    @else
                                        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
                                    @endif
                                    <li class="breadcrumb-item active" aria-current="page">Data Mahasiswa</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('import_errors'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error Import:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach (session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Daftar Mahasiswa</h5>
                                <div class="d-flex gap-2">
                                    @if(Auth::user()->role->name === 'superadmin')
                                        <a href="{{ route('mahasiswa.import.form') }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-upload me-1"></i>
                                            Import Excel
                                        </a>
                                    @endif
                                    <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus me-1"></i>
                                        Tambah Mahasiswa
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="mahasiswaTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIM</th>
                                            <th>Nama Lengkap</th>
                                            <th>Fakultas</th>
                                            <th>Program Studi</th>
                                            <th>Kelas</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mahasiswas as $mahasiswa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $mahasiswa->nim }}</td>
                                            <td>{{ $mahasiswa->nama_lengkap }}</td>
                                            <td>{{ $mahasiswa->fakultas->name }}</td>
                                            <td>{{ $mahasiswa->prodi->name }}</td>
                                            <td>{{ $mahasiswa->kelas }}</td>
                                            <td>
                                                @if($mahasiswa->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Aksi
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('mahasiswa.show', $mahasiswa->id) }}">
                                                                <i class="bi bi-eye me-2"></i>
                                                                Detail
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('mahasiswa.edit', $mahasiswa->id) }}">
                                                                <i class="bi bi-pencil me-2"></i>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button class="dropdown-item text-danger" onclick="deleteMahasiswa({{ $mahasiswa->id }}, '{{ $mahasiswa->nama_lengkap }}')">
                                                                <i class="bi bi-trash me-2"></i>
                                                                Hapus
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @include('layouts.sidebar')
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#mahasiswaTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        responsive: true,
        pageLength: 25,
        order: [[2, 'asc']] // Sort by nama_lengkap
    });
});

function deleteMahasiswa(id, nama) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus mahasiswa "${nama}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/mahasiswa/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Terhapus!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat menghapus data.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endsection