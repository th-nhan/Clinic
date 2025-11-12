<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class History extends Model
{
    public $timestamps = false;

    use HasFactory;
    protected $primaryKey = 'history_id';
    protected $table = 'histories';
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'history_id', 'history_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function historyDetails()
    {
        return $this->hasMany(HistoryDetail::class, 'history_id', 'history_id');
    }
}
