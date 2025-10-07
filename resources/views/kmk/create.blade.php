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
                            <h3>Tambah KMK</h3>
                            <p class="text-subtitle text-muted">Tambah Koordinator Mata Kuliah baru</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    @if(Auth::user()->role->name === 'superadmin')
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.kmk.index') }}">KMK</a></li>
                                    @else
                                        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('kmk.index') }}">KMK</a></li>
                                    @endif
                                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-content">
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Form Tambah KMK</h5>
                        </div>
                        <div class="card-body">
                            <form action="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.store') }}@else{{ route('kmk.store') }}@endif" method="POST">
                                @csrf
                                
                                {{-- Dropdown pilihan dosen untuk superadmin --}}
                                @if(isset($dosens) && $dosens->count() > 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="parent_dosen_id" class="form-label">Pilih Dosen</label>
                                                <select class="form-control @error('parent_dosen_id') is-invalid @enderror" 
                                                        id="parent_dosen_id" name="parent_dosen_id" required>
                                                    <option value="">-- Pilih Dosen --</option>
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}" {{ old('parent_dosen_id') == $dosen->id ? 'selected' : '' }}>
                                                            {{ $dosen->name }} ({{ $dosen->email }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('parent_dosen_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">KMK akan menjadi koordinator untuk dosen yang dipilih</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp <small>(opsional)</small></label>
                                            <input type="text" class="form-control @error('nomor_whatsapp') is-invalid @enderror" 
                                                   id="nomor_whatsapp" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}"
                                                   placeholder="contoh: 081234567890">
                                            @error('nomor_whatsapp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Nomor WhatsApp untuk komunikasi (tanpa tanda +)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" id="terms" class="form-check-input" required>
                                            <label for="terms" class="check-label">Saya memahami bahwa KMK ini akan memiliki akses untuk mengelola presensi atas nama saya</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-between">
                                    <a href="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.index') }}@else{{ route('kmk.index') }}@endif" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Simpan KMK
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        @include('layouts.footer')
        @include('layouts.sidebar')
    </div>
</div>
@endsection