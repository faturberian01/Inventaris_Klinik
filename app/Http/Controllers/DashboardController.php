<?php

namespace App\Http\Controllers;

use App\Charts\NotaInternChart;
use App\Charts\SuratKeluarChart;
use App\Charts\SuratMasukChart;
use App\Charts\UserChart;
use App\Models\NotaIntern;
use App\Models\Product;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Flowframe\Trend\Trend;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::query()->withSum('productStocks', 'quantity')->latest()->filters(request(['q']))->paginate()->withQueryString();

        return view('dashboard.index', [
            'title' => 'Dashboard Admin Panel',
            'products' => $products,
        ]);
    }
}
