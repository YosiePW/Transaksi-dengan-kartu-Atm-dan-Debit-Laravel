<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SaldoController extends Controller
{
    public function Saldo() {
        $data = "Data All Saldo";
        return response()->json($data, 200);
    }

    public function saldoAuth() {
        $data = "Welcome " . Auth::user()->username;
        return response()->json($data, 200);
    }
}
