<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService
{
    protected $reservation;
    protected $user;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }
}
