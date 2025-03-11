<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cus extends Model
{
    use HasFactory;
    protected $table = 'customer';
        protected $primaryKey = 'cus_id'; 
    
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'phone_number',
        'email',
        'zipcode',
        'address',
        'city',
        'country',
        'image',
    ];

    // กำหนดค่า default ให้กับ role_id
    protected $attributes = [
        'role_id' => 3,
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function bookings()
{
    return $this->hasMany(Booking::class, 'cus_id');
}
}
