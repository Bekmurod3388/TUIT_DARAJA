<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'chairman',
        'deputy',
        'secretary',
        'members',
        'specalization_id',
    ];

    public function specalization()
    {
        return $this->belongsTo(\App\Models\Specalization::class);
    }
} 