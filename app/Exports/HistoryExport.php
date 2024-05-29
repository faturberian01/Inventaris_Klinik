<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class HistoryExport implements FromView
{
    public function __construct(private $histories, private ?Carbon $startDate, private ?Carbon $endDate)
    {
    }


    public function view(): View
    {
        return view('exports.histories', [
            'histories' => $this->histories,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
