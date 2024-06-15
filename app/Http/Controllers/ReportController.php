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
            $validatedData = request()->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'type' => ['required', Rule::in(array_merge(['all'], ProductType::values()))],
            ]);
    
            if ($validatedData['type'] === 'all') {
                $histories = History::query()
                    ->with('product')
                    ->whereDate('date', '>=', $validatedData['start_date'])
                    ->whereDate('date', '<=', $validatedData['end_date'])
                    ->orderByDesc('date')
                    ->get();
            } else {
                $productIds = Product::query()
                    ->where('type', $validatedData['type'])
                    ->pluck('id');
    
                $histories = History::query()
                    ->with('product')
                    ->whereDate('date', '>=', $validatedData['start_date'])
                    ->whereDate('date', '<=', $validatedData['end_date'])
                    ->whereIn('product_id', $productIds)
                    ->orderByDesc('date')
                    ->get();
            }
        }
    
        return view('reports.index', [
            "title" => "Report",
            'histories' => $histories
        ]);
    }
    

    public function reportPost(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required', Rule::in(array_merge(['all'], ProductType::values()))],
        ]);
    
        $histories = [];
    
        if ($request->input('type') === 'all') {
            $histories = History::query()
                ->with('product')
                ->whereDate('date', '>=', $validatedData['start_date'])
                ->whereDate('date', '<=', $validatedData['end_date'])
                ->orderByDesc('date')
                ->get();
        } else {
            $productIds = Product::query()
                ->where('type', $validatedData['type'])
                ->pluck('id');
    
            $histories = History::query()
                ->with('product')
                ->whereDate('date', '>=', $validatedData['start_date'])
                ->whereDate('date', '<=', $validatedData['end_date'])
                ->whereIn('product_id', $productIds)
                ->orderByDesc('date')
                ->get();
        }
    
        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);
    
        return Excel::download(new HistoryExport($histories, $startDate, $endDate), 'REPORT.xlsx');
    }
}