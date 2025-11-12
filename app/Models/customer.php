<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'customer_id';
    public function history() {
        return $this->hasMany(history::class);
    }
}
