<?php

namespace App;

enum RideStatus: string
{
    case ACCEPTED = 'accepted';
    case CANCELLED = 'cancelled';
    case STARTED = 'started';
    case COMPLETED = 'completed';
    case PENDING = 'pending';
}
