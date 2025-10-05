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
                            <h3>Edit Profil</h3>
                            <p class="text-subtitle text-muted">Edit Informasi Profil Dosen</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('dosen.profile.show') }}">Profil Saya</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
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
                            <h5 class="card-title">Form Edit Profil</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dosen.profile.update') }}" method="POST" id="profileForm">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Masukkan nama lengkap">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Masukkan email">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nuptk" class="form-label">NUPTK</label>
                                            <input type="text" class="form-control" id="nuptk" name="nuptk" value="{{ old('nuptk', $user->nuptk) }}" placeholder="Masukkan NUPTK">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp</label>
                                            <input type="text" class="form-control" id="nomor_whatsapp" name="nomor_whatsapp" value="{{ old('nomor_whatsapp', $user->nomor_whatsapp) }}" placeholder="Contoh: 08123456789">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h6 class="mb-3">Ubah Password (Opsional)</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="current_password" class="form-label">Password Saat Ini</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan password saat ini">
                                            <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="new_password" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi password baru">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i>
                                        Update Profil
                                    </button>
                                    <a href="{{ route('dosen.profile.show') }}" class="btn btn-secondary">
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

<script>
$(document).ready(function() {
    // Show/hide password confirmation based on new_password input
    $('#new_password').on('input', function() {
        const newPassword = $(this).val();
        const currentPasswordField = $('#current_password');
        
        if (newPassword.length > 0) {
            currentPasswordField.attr('required', true);
        } else {
            currentPasswordField.attr('required', false);
        }
    });

    // Form validation
    $('#profileForm').on('submit', function(e) {
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#new_password_confirmation').val();
        const currentPassword = $('#current_password').val();

        if (newPassword && newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok!');
            return false;
        }

        if (newPassword && !currentPassword) {
            e.preventDefault();
            alert('Silakan masukkan password saat ini untuk mengubah password!');
            return false;
        }
    });
});
</script>
@endsection