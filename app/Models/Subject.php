<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'fan_id';
    public $timestamps = false;
    protected $fillable = ['fan'];

    public function specalizations()
    {
        return $this->belongsToMany(
            \App\Models\Specalization::class,
            'specalization_subject',
            'subject_id',
            'specalization_id'
        );
    }
}
