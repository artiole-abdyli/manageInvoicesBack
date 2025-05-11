<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationService
{
    protected $reservation;
    protected $user;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }
    public function listOfReservations()
    {
        $reservations = Reservation::all();
        return response()->json([
            'data' => $reservations
        ]);
    }
    public function singleReservation($id)
    {
        $reservation = Reservation::where('id', $id)->first();
        return response()->json([
            'data' => $reservation
        ]);
    }
    public function deleteReservation($id)
    {
        $reservation = Reservation::where('id', $id);
        $reservation->delete();
        return response()->json([
            'message' => 'reservation deleted succesfully'
        ]);
    }
    public function createReservation(Request $request)
    {
        $reservation = new Reservation();
        $reservation->date = $request->input('date');
        $reservation->returning_date = $request->input('returning_date');
        $reservation->price = $request->input('price');
        $reservation->deposit = $request->input('deposit');
        $reservation->remaining_payment = $request->input('remaining_payment');
        $reservation->extra_requirement = $request->input('extra_requirement');
        $reservation->contact_id = $request->input('contact_id');
        $reservation->product_id = $request->input('product_id');
        $reservation->save();
        return response()->json([
            'message' => 'reservation created successfully',
            'data' => $reservation
        ]);
    }
}
