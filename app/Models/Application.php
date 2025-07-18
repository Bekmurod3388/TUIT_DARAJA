<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

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
        'payment_status',
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
