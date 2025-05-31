<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    protected $reservationService;
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }
    public function index()
    {
        return $this->reservationService->listOfReservations();
    }
    public function totalNumberOfReservations()
    {
        return $this->reservationService->totalNumberOfReservations();
    }


    public function create()
    { }


    public function store(Request $request)
    {
        return $this->reservationService->createReservation($request);
    }


    public function show(string $id)
    {
        return $this->reservationService->singleReservation($id);
    }

    public function edit(string $id)
    { }


    public function update(Request $request, string $id)
    {
        return $this->reservationService->updateReservation($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->reservationService->deleteReservation($id);
    }
    public function downloadReservations()
    {
        return $this->reservationService->downloadReservationsPdf();
    }
    public function overdue()
    {
        $reservations = Reservation::overdue()->get();



        return response()->json([
            'data' => $reservations,
            'count' => $reservations->count(),
        ]);
    }
}
