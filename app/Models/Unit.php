<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'code',
        'description',
        'parent_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relasi ke parent (fakultas untuk prodi)
    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    // Relasi ke children (prodi untuk fakultas)
    public function children()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }

    // Scope untuk fakultas
    public function scopeFakultas($query)
    {
        return $query->where('type', 'fakultas');
    }

    // Scope untuk program studi
    public function scopeProgramStudi($query)
    {
        return $query->where('type', 'program_studi');
    }

    // Scope untuk unit aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk nama lengkap (dengan fakultas jika prodi)
    public function getFullNameAttribute()
    {
        if ($this->type === 'program_studi' && $this->parent) {
            return $this->parent->name . ' - ' . $this->name;
        }
        return $this->name;
    }

    // Check apakah unit adalah fakultas
    public function isFakultas()
    {
        return $this->type === 'fakultas';
    }

    // Check apakah unit adalah program studi
    public function isProgramStudi()
    {
        return $this->type === 'program_studi';
    }
}
