<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Accepted = 'accepted';
}
