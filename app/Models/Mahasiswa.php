<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nim',
        'nama_lengkap',
        'fakultas_id',
        'prodi_id',
        'kelas',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the fakultas that owns the Mahasiswa
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'fakultas_id');
    }

    /**
     * Get the prodi that owns the Mahasiswa
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'prodi_id');
    }

    /**
     * Scope a query to only include active mahasiswa.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by fakultas.
     */
    public function scopeByFakultas($query, $fakultasId)
    {
        return $query->where('fakultas_id', $fakultasId);
    }

    /**
     * Scope a query to filter by prodi.
     */
    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }

    /**
     * Scope a query to filter by kelas.
     */
    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }
}
