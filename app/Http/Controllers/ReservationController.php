<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        return $this->reservationService->createReservation($request);
    }


    public function show(string $id)
    {
        return $this->reservationService->singleReservation($id);
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->reservationService->deleteReservation($id);
    }
}
