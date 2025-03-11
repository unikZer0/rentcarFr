<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    
    protected $table = 'booking';
    protected $primaryKey = 'book_id';
    public $timestamps = true;

    protected $fillable = [
        'Location',
        'Pickup',
        'dropoof',
        'start',
        'end',
        'car_id',
        'cus_id',
    ];

    public function customer()
{
    return $this->belongsTo(Cus::class, 'cus_id'); 
}


    public function order()
    {
        return $this->hasOne(Order::class, 'book_id');
    }

    public function car()
    {
        return $this->belongsTo(tbl_cars::class, 'car_id');
    }
}
