<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Schedule extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function scheduletime() {
        return $this->belongsTo(ScheduleTime::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
