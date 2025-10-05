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
                            <h3>Detail Unit</h3>
                            <p class="text-subtitle text-muted">Informasi Detail Unit</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('unit.index') }}">Data Unit</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Unit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Detail Informasi Unit</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">Tipe Unit</td>
                                                <td style="width: 5%;">:</td>
                                                <td>
                                                    @if($unit->type === 'fakultas')
                                                        <span class="badge bg-primary">Fakultas</span>
                                                    @else
                                                        <span class="badge bg-info">Program Studi</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Nama Unit</td>
                                                <td>:</td>
                                                <td>{{ $unit->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Kode Unit</td>
                                                <td>:</td>
                                                <td>{{ $unit->code ?? '-' }}</td>
                                            </tr>
                                            @if($unit->type === 'program_studi' && $unit->parent)
                                            <tr>
                                                <td class="fw-bold">Fakultas</td>
                                                <td>:</td>
                                                <td>{{ $unit->parent->name }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td class="fw-bold">Status</td>
                                                <td>:</td>
                                                <td>
                                                    @if($unit->is_active)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">Deskripsi</td>
                                                <td style="width: 5%;">:</td>
                                                <td>{{ $unit->description ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Dibuat Pada</td>
                                                <td>:</td>
                                                <td>{{ $unit->created_at->format('d M Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Diupdate Pada</td>
                                                <td>:</td>
                                                <td>{{ $unit->updated_at->format('d M Y H:i') }}</td>
                                            </tr>
                                            @if($unit->type === 'fakultas')
                                            <tr>
                                                <td class="fw-bold">Total Program Studi</td>
                                                <td>:</td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $unit->children->count() }}</span>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($unit->type === 'fakultas' && $unit->children->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="fw-bold">Program Studi</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Program Studi</th>
                                                    <th>Kode</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($unit->children as $prodi)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $prodi->name }}</td>
                                                    <td>{{ $prodi->code ?? '-' }}</td>
                                                    <td>
                                                        @if($prodi->is_active)
                                                            <span class="badge bg-success">Aktif</span>
                                                        @else
                                                            <span class="badge bg-danger">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('unit.show', $prodi->id) }}" class="btn btn-sm btn-info">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('unit.edit', $prodi->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="form-group mt-4">
                                <a href="{{ route('unit.edit', $unit->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit
                                </a>
                                <a href="{{ route('unit.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @include('layouts.sidebar')
</div>
@endsection