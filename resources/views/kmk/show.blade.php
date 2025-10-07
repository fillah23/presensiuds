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
                            <h3>Detail KMK</h3>
                            <p class="text-subtitle text-muted">Informasi Koordinator Mata Kuliah</p>
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
                                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
                            <h5 class="card-title">Informasi KMK</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%"><strong>Nama Lengkap</strong></td>
                                            <td>: {{ $kmk->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>: {{ $kmk->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>WhatsApp</strong></td>
                                            <td>: {{ $kmk->nomor_whatsapp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role</strong></td>
                                            <td>: {{ $kmk->role->display_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td>: 
                                                @if($kmk->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Non-Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%"><strong>Dosen Pembimbing</strong></td>
                                            <td>: {{ $kmk->parentDosen->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat Pada</strong></td>
                                            <td>: {{ $kmk->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Terakhir Diupdate</strong></td>
                                            <td>: {{ $kmk->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4 d-flex gap-2">
                                <a href="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.index') }}@else{{ route('kmk.index') }}@endif" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <a href="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.edit', $kmk) }}@else{{ route('kmk.edit', $kmk) }}@endif" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.destroy', $kmk) }}@else{{ route('kmk.destroy', $kmk) }}@endif" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus KMK ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
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