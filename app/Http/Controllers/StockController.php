<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\History;
use App\Models\Product;
use App\Models\Stock;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stocks.index', [
            "title" => "Input Stocks",
            'products' => Product::query()->orderByDesc('updated_at')->withSum('productStocks', 'quantity')->filters(request(['q']))->paginate()->withQueryString()
        ]);
    }

    public function add(Product $product)
    {
        return view('stocks.add', [
            "title" => "Product Add Stock",
            "product" => $product,
        ]);
    }

    public function addPost(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'quantity' => ['required', 'numeric', 'min:1'],
            'expired_date' => [Rule::when($product->type == ProductType::MEDICINE, ['required', 'date'])],
        ]);

        try {
            DB::beginTransaction();
            // $product->increment('stocks', intval($validatedData['quantity'] ?? 0));
            $product->update([
                'last_new_stocks' => $validatedData['quantity'] ?? null
            ]);

            Stock::create([
                'product_id' => $product->id,
                'expired_date' => $validatedData['expired_date'] ?? null,
                'quantity' => $validatedData['quantity']
            ]);

            DB::commit();
            return redirect()->route('stocks.index')->with('success', 'Product stocks added!');
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}
