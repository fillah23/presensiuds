<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'presensi_id',
        'nim',
        'nama_mahasiswa',
        'prodi',
        'kelas',
        'waktu_absen',
        'ip_address',
        'user_agent',
        'status'
    ];

    protected $casts = [
        'waktu_absen' => 'datetime'
    ];

    // Relasi ke Presensi
    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }

    // Method untuk mendapatkan mahasiswa dari NIM
    public function getMahasiswa()
    {
        return Mahasiswa::where('nim', $this->nim)->first();
    }

    // Scope untuk status tertentu
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('waktu_absen', today());
    }
}
