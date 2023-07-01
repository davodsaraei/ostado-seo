<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuerySuggestionExport;
use App\Models\QuerySuggestionHistory;
use App\Foundation\GoogleAPIs\QuerySuggestion as GoogleQuerySuggestion;

class QuerySuggestion extends Component
{
    private $querySuggestion;

    public $q;
    public $items = [];
    public $error;
    public $wait = false;

    public function __construct()
    {
        $this->querySuggestion = new GoogleQuerySuggestion;
    }

    public function render(): View
    {
        return view('suggestion.partials.query-suggestion');
    }

    public function updatingQ()
    {
        $this->wait = true;
    }

    public function updatedQ()
    {
        if (!is_string($this->q)) {
            return;
        }

        $result = $this->querySuggestion->fetch($this->q);
        if ($result->status !== 200) {
            $this->error = $result->message;
        } else {
            $this->items = $result->items;
        }

        $this->wait = false;
    }

    public function saveInHistory()
    {
        QuerySuggestionHistory::create([
            'key' => $this->q,
            'items' => $this->items,
            'user_id' => auth()->user()->id,
        ]);

        return true;
    }

    public function export()
    {
        $export = new QuerySuggestionExport($this->items);

        return Excel::download($export, Str::random(10).'.xlsx');
    }
}