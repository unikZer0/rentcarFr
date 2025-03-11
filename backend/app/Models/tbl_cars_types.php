<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_cars_types extends Model
{
    use HasFactory;
    protected $table = 'tbl_cars_types';
    protected $primaryKey = 'car_type_id'; 
    protected $fillable = ['car_type_name'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
