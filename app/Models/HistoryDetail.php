<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class HistoryDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['history_id', 'service_id','price'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function history()
    {
        return $this->belongsTo(History::class, 'history_id', 'history_id');
    }
}
