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
                            <h3>Profil Saya</h3>
                            <p class="text-subtitle text-muted">Informasi Profil Dosen</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
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

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Profil</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">Nama Lengkap</td>
                                                <td style="width: 5%;">:</td>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Email</td>
                                                <td>:</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">NUPTK</td>
                                                <td>:</td>
                                                <td>{{ $user->nuptk ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Nomor WhatsApp</td>
                                                <td>:</td>
                                                <td>{{ $user->nomor_whatsapp ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">Role</td>
                                                <td style="width: 5%;">:</td>
                                                <td>
                                                    <span class="badge bg-info">{{ $user->role->display_name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status</td>
                                                <td>:</td>
                                                <td>
                                                    <span class="badge bg-success">Aktif</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Bergabung Pada</td>
                                                <td>:</td>
                                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Terakhir Update</td>
                                                <td>:</td>
                                                <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <a href="{{ route('dosen.profile.edit') }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit Profil
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