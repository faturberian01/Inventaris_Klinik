<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Exports\HistoryExport;
use App\Models\History;
use App\Models\Product;
use App\Models\Stock;
use App\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $histories = [];
        if ($request->has('preview')) {
            $validatedData = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'type' => ['required', Rule::in(array_merge(['all'], ProductType::values()))],
            ]);

            $histories = $this->getHistories($validatedData['start_date'], $validatedData['end_date'], $validatedData['type']);
        }

        return view('reports.index', [
            "title" => "Report",
            'histories' => $histories
        ]);
    }

    public function reportPost(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required', Rule::in(array_merge(['all'], ProductType::values()))],
        ]);

        $histories = $this->getHistories($request->start_date, $request->end_date, $request->type);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        return Excel::download(new HistoryExport($histories, $startDate, $endDate), 'REPORT.xlsx');
    }

    public function exportAll()
    {
        $histories = History::with('product')->orderByDesc('date')->get();
        $startDate = Carbon::minValue();
        $endDate = Carbon::now();

        return Excel::download(new HistoryExport($histories, $startDate, $endDate), 'REPORT_ALL.xlsx');
    }

    private function getHistories($startDate, $endDate, $type)
    {
        if ($type === 'all') {
            return History::with('product')
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->orderByDesc('date')
                ->get();
        } else {
            $productIds = Product::where('type', $type)->pluck('id');
            return History::with('product')
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->whereIn('product_id', $productIds)
                ->orderByDesc('date')
                ->get();
        }
    }
}
