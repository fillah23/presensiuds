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
                            <h3>Tambah Mahasiswa</h3>
                            <p class="text-subtitle text-muted">Tambah Data Mahasiswa Baru</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    @if(Auth::user()->role->name === 'superadmin')
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    @else
                                        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
                                    @endif
                                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">Data Mahasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Mahasiswa</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

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

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Form Tambah Mahasiswa</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('mahasiswa.store') }}" method="POST" id="mahasiswaForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}" required placeholder="Contoh: 2023001001">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap mahasiswa">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fakultas_id" class="form-label">Fakultas <span class="text-danger">*</span></label>
                                            <select class="form-select" id="fakultas_id" name="fakultas_id" required>
                                                <option value="">Pilih Fakultas</option>
                                                @foreach($fakultas as $fak)
                                                    <option value="{{ $fak->id }}" {{ old('fakultas_id') == $fak->id ? 'selected' : '' }}>
                                                        {{ $fak->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="prodi_id" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                            <select class="form-select" id="prodi_id" name="prodi_id" required>
                                                <option value="">Pilih Program Studi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}" required placeholder="Contoh: TI-1A, SI-2B">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check mt-4">
                                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Status Aktif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i>
                                        Simpan
                                    </button>
                                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @include('layouts.sidebar')
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('#fakultas_id, #prodi_id').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Load prodis when fakultas is selected
    $('#fakultas_id').change(function() {
        const fakultasId = $(this).val();
        const prodiSelect = $('#prodi_id');
        
        prodiSelect.empty().append('<option value="">Pilih Program Studi</option>');
        
        if (fakultasId) {
            $.ajax({
                url: '{{ route("mahasiswa.ajax.prodis") }}',
                type: 'GET',
                data: { fakultas_id: fakultasId },
                success: function(data) {
                    $.each(data, function(index, prodi) {
                        prodiSelect.append($('<option>', {
                            value: prodi.id,
                            text: prodi.name
                        }));
                    });
                },
                error: function(xhr) {
                    console.error('Error loading prodis:', xhr);
                }
            });
        }
    });

    // Trigger change if old fakultas_id exists
    @if(old('fakultas_id'))
        $('#fakultas_id').trigger('change');
        
        // Set old prodi_id after ajax call
        setTimeout(function() {
            $('#prodi_id').val('{{ old("prodi_id") }}').trigger('change');
        }, 500);
    @endif
});
</script>
@endsection