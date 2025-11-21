<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ScheduleTime extends Model
{
    use HasFactory;
    public function schedule() {
        return $this->hasMany(Schedule::class);
    }

    protected $casts = [
        'start_time' => 'datetime', // Sẽ tự động chuyển '08:00:00' thành đối tượng Carbon
        'end_time' => 'datetime',
    ];
}
