<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'column_extra',
        'responsavel_id'


    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'tarefa_user')->withTimestamps();
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

}
