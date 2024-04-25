<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MortgageController extends Controller
{
    public function calculate(Request $request)
    {
        // Validate the input
        $request->validate([
            'price' => 'required|numeric|min:1', 
            'years' => 'required|numeric|min:1', 
            'percentage' => 'required|numeric|min:1',
        ]);

        $price = $request->input('price');
        $years = $request->input('years');
        $percentage = $request->input('percentage');


        $interest = $percentage / 100 / 12;
        $num_payments = $years * 12;

        $monthly_payment = ($price * $interest) / (1 - pow(1 + $interest, -$num_payments));

        return view('CalculateMortgage', [
            'price' => $price,
            'years' => $years,
            'percentage' => $percentage,
            'monthly_payment' => $monthly_payment
        ]);
    }
}

