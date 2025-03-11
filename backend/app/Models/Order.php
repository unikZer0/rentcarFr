<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [
        'book_id',
        'total',
        'days',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'book_id');
    }
}
