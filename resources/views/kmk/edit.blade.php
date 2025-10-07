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
                            <h3>Edit KMK</h3>
                            <p class="text-subtitle text-muted">Edit data Koordinator Mata Kuliah</p>
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
                                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <h5 class="card-title">Form Edit KMK</h5>
                        </div>
                        <div class="card-body">
                            <form action="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.update', $kmk) }}@else{{ route('kmk.update', $kmk) }}@endif" method="POST">
                                @csrf
                                @method('PUT')
                                
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
                                                        <option value="{{ $dosen->id }}" 
                                                                {{ old('parent_dosen_id', $kmk->parent_dosen_id) == $dosen->id ? 'selected' : '' }}>
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
                                                   id="name" name="name" value="{{ old('name', $kmk->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', $kmk->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password <small>(kosongkan jika tidak ingin mengubah)</small></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp <small>(opsional)</small></label>
                                            <input type="text" class="form-control @error('nomor_whatsapp') is-invalid @enderror" 
                                                   id="nomor_whatsapp" name="nomor_whatsapp" value="{{ old('nomor_whatsapp', $kmk->nomor_whatsapp) }}"
                                                   placeholder="contoh: 081234567890">
                                            @error('nomor_whatsapp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Nomor WhatsApp untuk komunikasi (tanpa tanda +)</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_active" class="form-label">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                       {{ old('is_active', $kmk->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Aktif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-between">
                                    <a href="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.index') }}@else{{ route('kmk.index') }}@endif" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Update KMK
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