<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_cars extends Model
{
    use HasFactory;
    protected $table = 'tbl_cars';
    protected $primaryKey = 'car_id'; 
    protected $fillable = ["car_name","description","price_daily", "image", "car_type_id","car_status","user_id"];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function carType()
    {
        return $this->belongsTo(tbl_cars_types::class, 'car_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class, 'car_id');
    }
}
