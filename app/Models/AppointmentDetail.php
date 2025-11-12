<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AppointmentDetail extends Model
{
    use HasFactory;
    public function appointment() {
        return $this->belongsTo(Appointment::class);
    }
    public function service() {
        return $this->belongsTo(Service::class);
    }
}
