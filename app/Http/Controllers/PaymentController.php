<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Ad;
class PaymentController extends Controller
{
    public function index()
    {
        $data = Payment::paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
        return view('dashboard.payments.index',compact('data'));
    } 

    public function details($id)
    {
        $data = Payment::findOrFail($id);

        return view('dashboard.payments.details',compact('data'));
    }
}
