<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'customers';
    protected $fillable = ['customer_id', 'fullname','contact_number', 'email','date_of_birth'];
    protected $primaryKey = 'customer_id';
    public function histories()
    {
        return $this->hasMany(History::class, 'customer_id', 'customer_id');
    }
}
