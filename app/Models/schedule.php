<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedules';
    protected $primaryKey = 'schedule_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'schedule_time_id',
        'date',
        'status',
        'createdBy',
        'createdAt'
    ];
    public function scheduletime()
    {
        return $this->belongsTo(ScheduleTime::class, 'schedule_time_id', 'schedule_time_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
