@php
use Illuminate\Support\Facades\Auth;
@endphp

<div id="sidebar" class="">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo px-2 mt-1 w-100">
                {{-- Logo with theme switching --}}
                <link rel="stylesheet" href="{{ asset('assets/css/logo-theme.css') }}">
                <link rel="stylesheet" href="{{ asset('assets/css/logo-size.css') }}">
                <img src="{{ asset('images/logo-presensi-kodekoding-alt.png') }}" 
                    alt="Logo Presensi" 
                    height="56" 
                    class="me-2 logo-light">
                <img src="{{ asset('images/logo-presensi-kodekoding-alt-white.png') }}" 
                    alt="Logo Presensi" 
                    height="56" 
                    class="me-2 logo-dark">
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img"
                        class="iconify iconify--system-uicons" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img"
                        class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                {{-- User Info --}}
                {{-- <li class="sidebar-item">
                    <div class="px-3 py-2">
                        <small class="text-muted">Selamat datang,</small>
                        <p class="mb-0 fw-bold">{{ Auth::user()->name ?? 'Guest' }}</p>
                        <small class="text-muted">
                            @if(Auth::check() && Auth::user()->role)
                                {{ Auth::user()->role->display_name }}
                            @endif
                        </small>
                    </div>
                </li> --}}

                {{-- Divider --}}
                {{-- <li class="sidebar-item">
                    <hr class="my-2 mx-3">
                </li> --}}

                {{-- Dashboard --}}
                <li class="sidebar-item {{ Request::is('dashboard*') || Request::is('dosen/dashboard*') || Request::is('kmk/dashboard*') ? 'active' : '' }}">
                    @if(Auth::check() && Auth::user()->hasRole('superadmin'))
                        <a href="{{ route('dashboard') }}" class="sidebar-link">
                    @elseif(Auth::check() && Auth::user()->hasRole('dosen'))
                        <a href="{{ route('dosen.dashboard') }}" class="sidebar-link">
                    @elseif(Auth::check() && Auth::user()->hasRole('kmk'))
                        <a href="{{ route('kmk.dashboard') }}" class="sidebar-link">
                    @else
                        <a href="{{ route('dashboard') }}" class="sidebar-link">
                    @endif
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Super Admin Menu --}}
                @if(Auth::check() && Auth::user()->hasRole('superadmin'))
                    {{-- Master Data --}}
                    <li class="sidebar-item has-sub {{ Request::is('dosen*') || Request::is('unit*') || Request::is('mahasiswa*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-folder"></i>
                            <span>Master Data</span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item {{ Request::is('unit*') ? 'active' : '' }}">
                                <a href="{{ route('unit.index') }}">Data Unit</a>
                            </li>
                            <li class="submenu-item {{ Request::is('dosen*') ? 'active' : '' }}">
                                <a href="{{ route('dosen.index') }}">Data Dosen</a>
                            </li>
                            <li class="submenu-item {{ Request::is('mahasiswa*') ? 'active' : '' }}">
                                <a href="{{ route('mahasiswa.index') }}">Data Mahasiswa</a>
                            </li>
                        </ul>
                    </li>

                    {{-- KMK Management for Superadmin --}}
                    <li class="sidebar-item {{ Request::is('admin/kmk*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kmk.index') }}" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            <span>Kelola KMK</span>
                        </a>
                    </li>

                    
                @endif

                {{-- Dosen Menu --}}
                @if(Auth::check() && Auth::user()->hasRole('dosen'))
                    {{-- Profile --}}
                    <li class="sidebar-item {{ Request::is('dosen/profile*') ? 'active' : '' }}">
                        <a href="{{ route('dosen.profile.show') }}" class="sidebar-link">
                            <i class="bi bi-person"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>

                    {{-- KMK Management --}}
                    <li class="sidebar-item {{ Request::is('dosen/kmk*') ? 'active' : '' }}">
                        <a href="{{ route('kmk.index') }}" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Kelola KMK</span>
                        </a>
                    </li>

                    {{-- Presensi --}}
                    <li class="sidebar-item {{ Request::is('admin/presensi*') ? 'active' : '' }}">
                        <a href="{{ route('presensi.index') }}" class="sidebar-link">
                            <i class="bi bi-calendar-check"></i>
                            <span>Kelola Presensi</span>
                        </a>
                    </li>
                @endif

                {{-- KMK Menu --}}
                @if(Auth::check() && Auth::user()->hasRole('kmk'))
                    {{-- Presensi --}}
                    <li class="sidebar-item {{ Request::is('admin/presensi*') ? 'active' : '' }}">
                        <a href="{{ route('presensi.index') }}" class="sidebar-link">
                            <i class="bi bi-calendar-check"></i>
                            <span>Kelola Presensi</span>
                        </a>
                    </li>
                @endif

                {{-- Shared Menu for Both Roles --}}
                {{-- @if(Auth::check() && (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('dosen')))
                    @if(Auth::user()->hasRole('superadmin'))
                        <li class="sidebar-item {{ Request::is('admin/presensi*') ? 'active' : '' }}">
                            <a href="{{ route('presensi.index') }}" class="sidebar-link">
                                <i class="bi bi-calendar-check"></i>
                                <span>Kelola Presensi</span>
                            </a>
                        </li>
                    @endif
                @endif --}}

                {{-- Logout --}}
                <li class="sidebar-item">
                    <form action="{{ route('logout.post') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="sidebar-link border-0 bg-transparent text-start w-100" style="color: inherit;">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>