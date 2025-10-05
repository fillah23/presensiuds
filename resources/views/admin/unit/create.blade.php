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
                            <h3>Tambah Unit</h3>
                            <p class="text-subtitle text-muted">Tambah Fakultas atau Program Studi Baru</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('unit.index') }}">Data Unit</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Unit</li>
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
                            <h5 class="card-title">Form Tambah Unit</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('unit.store') }}" method="POST" id="unitForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type" class="form-label">Tipe Unit <span class="text-danger">*</span></label>
                                            <select class="form-select" id="type" name="type" required>
                                                <option value="">Pilih Tipe Unit</option>
                                                <option value="fakultas" {{ old('type') === 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                                                <option value="program_studi" {{ old('type') === 'program_studi' ? 'selected' : '' }}>Program Studi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="parent-group" style="display: none;">
                                            <label for="parent_id" class="form-label">Fakultas <span class="text-danger">*</span></label>
                                            <select class="form-select" id="parent_id" name="parent_id">
                                                <option value="">Pilih Fakultas</option>
                                                @foreach($fakultas as $fak)
                                                    <option value="{{ $fak->id }}" {{ old('parent_id') == $fak->id ? 'selected' : '' }}>
                                                        {{ $fak->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nama Unit <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama fakultas/program studi">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Kode Unit</label>
                                            <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" placeholder="Contoh: FT, FMIPA, TI, SI">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi optional tentang unit">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-check">
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
                                    <a href="{{ route('unit.index') }}" class="btn btn-secondary">
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
    $('#parent_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih Fakultas',
        allowClear: true
    });

    // Show/hide parent field based on type selection
    $('#type').change(function() {
        const type = $(this).val();
        const parentGroup = $('#parent-group');
        const parentField = $('#parent_id');

        if (type === 'program_studi') {
            parentGroup.show();
            parentField.attr('required', true);
        } else {
            parentGroup.hide();
            parentField.attr('required', false);
            parentField.val('').trigger('change');
        }
    });

    // Trigger change on page load if old value exists
    if ($('#type').val()) {
        $('#type').trigger('change');
    }
});
</script>
@endsection