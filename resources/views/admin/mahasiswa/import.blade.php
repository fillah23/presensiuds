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
                            <h3>Import Data Mahasiswa</h3>
                            <p class="text-subtitle text-muted">Import Data Mahasiswa dari Excel</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">Data Mahasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Import Excel</li>
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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <section class="section">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Upload File Excel</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file" class="form-label">File Excel <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls" required>
                                            <div class="form-text">
                                                Format yang didukung: .xlsx, .xls (Maksimal 2MB)
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="importBtn">
                                                <i class="bi bi-upload me-1"></i>
                                                Import Data
                                            </button>
                                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-left me-1"></i>
                                                Kembali
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Template Excel</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-3">Download template Excel untuk format yang benar:</p>
                                    <a href="{{ route('mahasiswa.template.download') }}" class="btn btn-success w-100">
                                        <i class="bi bi-download me-1"></i>
                                        Download Template
                                    </a>
                                    
                                    <div class="mt-4">
                                        <h6>Format Template:</h6>
                                        <ul class="list-unstyled">
                                            <li><strong>Kolom 1:</strong> NIM</li>
                                            <li><strong>Kolom 2:</strong> NAMA LENGKAP</li>
                                            <li><strong>Kolom 3:</strong> FAKULTAS</li>
                                            <li><strong>Kolom 4:</strong> PRODI</li>
                                            <li><strong>Kolom 5:</strong> KELAS</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title">Petunjuk Import</h5>
                                </div>
                                <div class="card-body">
                                    <ol class="mb-0">
                                        <li>Download template Excel terlebih dahulu</li>
                                        <li>Isi data mahasiswa sesuai format template</li>
                                        <li>Pastikan nama fakultas dan prodi sesuai dengan data yang ada di sistem</li>
                                        <li>Upload file Excel yang sudah diisi</li>
                                        <li>Sistem akan memvalidasi dan mengimport data</li>
                                    </ol>
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
$(document).ready(function() {
    $('#importForm').on('submit', function() {
        const btn = $('#importBtn');
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Mengimport...');
    });
});
</script>
@endsection