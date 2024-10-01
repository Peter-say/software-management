<?php

namespace App\Http\Controllers\Dashboard\Hotel\Invoices\Guest;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\RoomReservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class RoomReservationInvoiceController extends Controller
{

    public function printInvoicePDF($id)
    {
        $reservation = RoomReservation::find($id);  // Fetch your invoice data
        $pdf = Pdf::loadView('dashboard.hotel.room.reservation.print-invoice', compact('reservation'));
        return $pdf->download('invoice.pdf');
    }
}
