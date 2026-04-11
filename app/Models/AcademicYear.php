<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    public const SEMESTER_SPRING = 'bahorgi';
    public const SEMESTER_FALL = 'kuzgi';

    public const SEMESTERS = [
        self::SEMESTER_SPRING,
        self::SEMESTER_FALL,
    ];

    protected $fillable = [
        'name',
        'semester',
        'is_active',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function specalizations()
    {
        return $this->hasMany(Specalization::class);
    }
}
