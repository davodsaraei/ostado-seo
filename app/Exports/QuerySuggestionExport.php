<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class QuerySuggestionExport implements FromCollection
{
    private $items;

    public function __construct($items)
    {
        $this->items = $items;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->items)->map(fn ($item) => [$item]);
    }
}
