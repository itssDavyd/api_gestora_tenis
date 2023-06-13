<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenis extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'marca',
        'color',
        'user_id',
        'fecha_alta',
        'fecha_modificacion'
    ];

    protected $table = 'tenis';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
