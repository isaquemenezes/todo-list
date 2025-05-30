<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
    ];

    public function tarefas()
    {
        return $this->belongsToMany(Tarefa::class, 'tarefa_user')->withTimestamps();
    }

    public function tarefasResponsaveis()
    {
        return $this->hasMany(Tarefa::class, 'responsavel_id');
    }

    public function tarefasVinculadas()
    {
        return $this->belongsToMany(Tarefa::class, 'tarefa_user', 'user_id', 'tarefa_id');
    }
}
