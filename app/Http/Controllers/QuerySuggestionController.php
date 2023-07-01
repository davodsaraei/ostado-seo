<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class QuerySuggestionController extends Controller
{
    public function fetch(Request $request): View
    {
        return view('suggestion.fetch');
    }

    public function history()
    {
        return view('suggestion.history');
    }
}