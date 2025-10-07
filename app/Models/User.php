<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'nuptk',
        'nomor_whatsapp',
        'is_active',
        'parent_dosen_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function parentDosen()
    {
        return $this->belongsTo(User::class, 'parent_dosen_id');
    }

    public function kmkUsers()
    {
        return $this->hasMany(User::class, 'parent_dosen_id');
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function canManagePresensi()
    {
        return $this->hasRole('superadmin') || $this->hasRole('dosen') || $this->hasRole('kmk');
    }

    public function getPresensiDosenId()
    {
        if ($this->hasRole('kmk')) {
            return $this->parent_dosen_id;
        }
        
        return $this->id;
    }
}
