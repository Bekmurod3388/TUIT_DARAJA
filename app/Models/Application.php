<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'specalization_id',
        'organization',
        'subject',
        'status',
        'last_name',
        'first_name',
        'middle_name',
        'phone',
        'education_type',
        'oac_file',
        'direction_file',
        'receipt_file',
        'work_order_file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specalization()
    {
        return $this->belongsTo(Specalization::class);
    }
}
