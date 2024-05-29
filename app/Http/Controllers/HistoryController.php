<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\History;
use App\Models\Product;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('histories.index', [
            "title" => "Histories",
            'histories' => History::with('product')->latest()->get()
        ]);
    }
}
