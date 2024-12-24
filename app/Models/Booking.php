<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['client_id', 'labour_id', 'start_date', 'end_date', 'status', 'price', 'description'];
}
