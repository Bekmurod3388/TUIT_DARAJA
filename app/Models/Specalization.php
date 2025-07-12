<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specalization extends Model
{
    protected $table = 'specalizations';
    protected $fillable = ['name','number'];
}
