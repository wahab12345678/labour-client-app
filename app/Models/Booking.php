<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['client_id', 'start_date', 'end_date', 'status', 'price', 'description'];
    /**
     * The client that the booking belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    /**
     * The labour that the booking belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function labours()
    {
        return $this->belongsToMany(User::class, 'booking_labours', 'booking_id', 'labour_id');
    }
}
