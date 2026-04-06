<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymeTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payme_transaction_id',
        'application_id',
        'amount',
        'state',
        'reason',
        'payme_time',
        'create_time',
        'perform_time',
        'cancel_time',
    ];

    protected function casts(): array
    {
        return [
            'create_time' => 'datetime',
            'perform_time' => 'datetime',
            'cancel_time' => 'datetime',
        ];
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
