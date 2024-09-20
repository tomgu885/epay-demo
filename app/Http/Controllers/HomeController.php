<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    function dashboard(Request $request)
    {
        Log::info('controller dashboard');
        $deposits = Deposit::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('dashboard', [
            'deposits' => $deposits,
        ]);
    }
}
