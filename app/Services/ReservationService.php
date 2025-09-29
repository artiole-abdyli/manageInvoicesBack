<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Make sure to import
use Carbon\Carbon;

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
        $today = Carbon::today();
        $reservations = Reservation::with('contact')->get();
        $overdueReservations = Reservation::where('status', 'overdue')->count();

        $activeReservations = Reservation::count();


        $reservationsNumber = Reservation::count();
        $reservationsOfToday = Reservation::whereDate('date', $today)->get();
        $reservationsOfTodayCount = Reservation::whereDate('date', $today)->count();
        $reservationsReturningToday = Reservation::whereDate('returning_date', $today)->get();



        return response()->json([
            'data' => $reservations,
            'overdueReservations' => $overdueReservations,
            'numberOfReservations' => $reservationsNumber,
            'reservationsOfToday' => $reservationsOfToday,
            'reservationsTodayCount' => $reservationsOfTodayCount,
            'activeReservations' => $activeReservations,
            'onTimeReservations' => $activeReservations,
            'reservationsReturningToday' => $reservationsReturningToday
        ]);
    }



    public function singleReservation($id)
    {
        $reservation = Reservation::with(['contact', 'product'])->find($id);
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
    public function updateReservation(Request $request, $id)
    {
        try {
            $reservation = Reservation::where('id', $id)->first();
            $reservation->date = $request->input('date');
            $reservation->returning_date = $request->input('returning_date');
            $reservation->price = $request->input('price');
            $reservation->deposit = $request->input('deposit');
            $reservation->status = $request->input('status');
            $reservation->remaining_payment = $request->input('remaining_payment');
            $reservation->extra_requirement = $request->input('extra_requirement');
            $reservation->save();
            return response()->json([
                'message' => 'reservation updated succesfully',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function downloadReservationsPdf()
    {
        $reservations = Reservation::all();
        $pdf = Pdf::loadView('reservations.pdf', ['reservations' => $reservations]);
        return $pdf->download('reservations-list.pdf');
    }
}
