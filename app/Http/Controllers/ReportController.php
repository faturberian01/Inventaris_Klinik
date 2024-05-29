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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $histories = [];

        if (request('preview')) {
            $validatedData = request(['start_date', 'end_date', 'type']);

            if (!request()->filled(['start_date', 'end_date'])) {
                return back()->with('failed', 'Start date, end date and type should be filled to export!');
            }

            $productIds = Product::query()
                ->when($validatedData['type'] ?? false, fn ($q, $value) => $q->where('type', $value))
                ->pluck('id');

            $histories = History::query()
                ->with('product')
                ->whereDate('date', '>=', $validatedData['start_date'])
                ->whereDate('date', '<=', $validatedData['end_date'])
                ->whereIn('product_id', $productIds)
                ->orderByDesc('date')
                ->get();
        }

        return view('reports.index', [
            "title" => "Report",
            'histories' => $histories
        ]);
    }

    public function reportPost(Request $request)
    {
        $histories = [];
        $validatedData = [];

        if (request('all')) {
            $histories = History::query()
                ->with('product')
                ->orderByDesc('date')
                ->get();
        } else {
            $validatedData = $request->validate([
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                'type' => ['required', Rule::in(ProductType::values())]
            ]);

            $productIds = Product::query()
                ->when($validatedData['type'] ?? false, fn ($q, $value) => $q->where('type', $value))
                ->pluck('id');

            $histories = History::query()
                ->with('product')
                ->whereDate('date', '>=', $validatedData['start_date'])
                ->whereDate('date', '<=', $validatedData['end_date'])
                ->whereIn('product_id', $productIds)
                ->orderByDesc('date')
                ->get();
        }

        $startDate = ($validatedData['start_date'] ?? false) ? Carbon::parse($validatedData['start_date']) : null;
        $endDate = ($validatedData['end_date'] ?? false) ? Carbon::parse($validatedData['end_date']) : null;

        return Excel::download(new HistoryExport($histories, $startDate, $endDate), 'REPORT.xlsx');
    }
}
