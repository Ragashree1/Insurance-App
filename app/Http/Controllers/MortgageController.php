<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MortgageController extends Controller
{
    public function calculate(Request $request)
    {
        $price = $request->input('price');
        $years = $request->input('years');
        $percentage = $request->input('percentage');


        $interest = $percentage / 100 / 12;
        $num_payments = $years * 12;

        $monthlyPayment = ($price * $interest) / (1 - pow(1 + $interest, -$num_payments));

        // Render the view with the result
        return response()->json(['monthlyPayment' => $monthlyPayment]);    }
    
}