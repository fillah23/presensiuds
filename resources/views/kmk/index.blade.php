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
                            <h3>Kelola KMK</h3>
                            <p class="text-subtitle text-muted">Koordinator Mata Kuliah yang membantu Anda</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    @if(Auth::user()->role->name === 'superadmin')
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    @else
                                        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
                                    @endif
                                    <li class="breadcrumb-item active" aria-current="page">KMK</li>
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
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="card-title mb-0">Daftar KMK</h5>
                                </div>
                                <div class="col-auto">
                                    <a href="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.create') }}@else{{ route('kmk.create') }}@endif" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Tambah KMK
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if($kmkUsers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            @if(Auth::user()->role->name === 'superadmin')
                                                <th>Dosen</th>
                                            @endif
                                            <th>WhatsApp</th>
                                            <th>Status</th>
                                            <th>Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kmkUsers as $index => $kmk)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kmk->name }}</td>
                                            <td>{{ $kmk->email }}</td>
                                            @if(Auth::user()->role->name === 'superadmin')
                                                <td>{{ $kmk->parentDosen->name ?? '-' }}</td>
                                            @endif
                                            <td>{{ $kmk->nomor_whatsapp ?? '-' }}</td>
                                            <td>
                                                @if($kmk->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Non-Aktif</span>
                                                @endif
                                            </td>
                                            <td>{{ $kmk->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.show', $kmk) }}@else{{ route('kmk.show', $kmk) }}@endif" class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.edit', $kmk) }}@else{{ route('kmk.edit', $kmk) }}@endif" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="@if(Auth::user()->role->name === 'superadmin'){{ route('admin.kmk.destroy', $kmk) }}@else{{ route('kmk.destroy', $kmk) }}@endif" method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus KMK ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-people fs-1 text-muted"></i>
                                <h5 class="mt-3">Belum ada KMK</h5>
                                <p class="text-muted">Tambahkan KMK pertama untuk membantu mengelola presensi</p>
                                <a href="{{ route('kmk.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Tambah KMK
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
        @include('layouts.footer')
        @include('layouts.sidebar')
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
@endpush
@endsection