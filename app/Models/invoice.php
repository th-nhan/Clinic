<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'invoice_id';
     protected $fillable = [
        'history_id',
        'user_id',
        'total_price',
        'status',
        'method_payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function history()
    {
        return $this->belongsTo(History::class, 'history_id', 'history_id');
    }
}