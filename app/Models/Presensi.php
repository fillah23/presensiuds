<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'resume_kelas',
        'waktu_mulai',
        'durasi_menit',
        'waktu_selesai',
        'prodi',
        'kelas', // Tambah field kelas (JSON untuk multiple)
        'dosen_id',
        'is_active',
        'kode_presensi'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'is_active' => 'boolean',
        'kelas' => 'array' // Cast ke array untuk multiple selection
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Generate kode presensi unik
            $model->kode_presensi = strtoupper(substr(md5(uniqid()), 0, 8));
            
            // Hitung waktu selesai berdasarkan waktu mulai + durasi
            if ($model->waktu_mulai && $model->durasi_menit) {
                $model->waktu_selesai = Carbon::parse($model->waktu_mulai)->addMinutes((int)$model->durasi_menit);
            }
        });
    }

    // Relasi ke User (Dosen)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // Relasi ke Presensi Mahasiswa
    public function presensiMahasiswas()
    {
        return $this->hasMany(PresensiMahasiswa::class);
    }

    // Method untuk cek apakah presensi sedang aktif
    public function isActive()
    {
        $now = Carbon::now();
        return $this->is_active && 
               $now->between($this->waktu_mulai, $this->waktu_selesai);
    }

    // Method untuk mendapatkan sisa waktu dalam menit
    public function getRemainingMinutes()
    {
        if (!$this->isActive()) {
            return 0;
        }
        
        return Carbon::now()->diffInMinutes($this->waktu_selesai, false);
    }

    // Method untuk mendapatkan sisa waktu dalam format jam:menit:detik
    public function getRemainingTime()
    {
        if (!$this->isActive()) {
            return '00:00:00';
        }
        
        $remaining = Carbon::now()->diffInSeconds($this->waktu_selesai, false);
        
        if ($remaining <= 0) {
            return '00:00:00';
        }
        
        $hours = floor($remaining / 3600);
        $minutes = floor(($remaining % 3600) / 60);
        $seconds = $remaining % 60;
        
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    // Method untuk mendapatkan mahasiswa yang sudah absen
    public function getAbsentMahasiswas()
    {
        return $this->presensiMahasiswas()->count();
    }

    // Scope untuk presensi aktif
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
                    ->where('waktu_mulai', '<=', $now)
                    ->where('waktu_selesai', '>=', $now);
    }

    // Scope untuk presensi hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('waktu_mulai', Carbon::today());
    }
}
