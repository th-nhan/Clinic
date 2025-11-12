<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Service extends Model
{
  
    protected $primaryKey = 'service_id';
    protected $table = 'services';
    public function history_detail()
    {
        return $this->hasMany(HistoryDetail::class);
    }
    public function category() {
        return $this->belongsTo(category::class);
    }
    public function appointmentdetail()
    {
        return $this->hasMany(AppointmentDetail::class);
    }
}
