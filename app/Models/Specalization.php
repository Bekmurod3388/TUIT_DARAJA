<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specalization extends Model
{
    use HasFactory;
    protected $table = 'specalizations';
    protected $fillable = ['code', 'name', 'description', 'is_visible', 'price', 'program_name_id'];

    public function programName()
    {
        return $this->belongsTo(\App\Models\ProgramName::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(
            \App\Models\Subject::class,
            'specalization_subject',
            'specalization_id',
            'subject_id'
        );
    }
}
