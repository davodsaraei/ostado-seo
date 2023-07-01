<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuerySuggestionExport;
use App\Models\QuerySuggestionHistory;

class HistorySuggestion extends Component
{

    public function render(): View
    {
        return view('suggestion.partials.history-list', [
            'histories' => QuerySuggestionHistory::query()->whereOwn()->orderBy('id', 'desc')->paginate()
        ]);
    }

    public function export($id)
    {
        $export = new QuerySuggestionExport(QuerySuggestionHistory::find($id)->items);

        return Excel::download($export, Str::random(10).'.xlsx');
    }
}