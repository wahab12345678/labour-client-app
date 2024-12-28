<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingLabour extends Model
{
    protected $fillable = ['booking_id', 'labour_id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function labour()
    {
        return $this->belongsTo(User::class);
    }
}
