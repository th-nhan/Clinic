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
}
