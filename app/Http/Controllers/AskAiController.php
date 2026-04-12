<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AskAiController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function ask(Request $request)
    {
        return response()->json(['error' => 'Feature removed.'], 404);
    }
}
