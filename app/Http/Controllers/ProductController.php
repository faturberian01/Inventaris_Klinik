<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\History;
use App\Models\Product;
use App\Models\Stock;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index', [
            "title" => "Products",
            'products' => Product::orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create', [
            "title" => "Add New Product",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => ['required', 'max:15', Rule::unique(Product::class, 'code')],
            'name' => ['required', 'max:128'],
            'description' => ['required', 'max:1024'],
            'price' => ['required', 'numeric', 'min:0'],
            'type' => ['required', Rule::in(ProductType::values())],
            'photo' => ['required', 'image', 'max:1024'],
        ]);

        Product::create(array_merge($validatedData, [
            'photo' => $request->file('photo')->store('product-photos', [
                'disk' => 'public',
            ])
        ]));

        return redirect()->route('products.index')->with('success', 'Product added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', [
            "title" => "Detail Product",
            "product" => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        return view('products.edit', [
            "title" => "Edit Product",
            "product" => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            // 'code' => ['required', 'max:15', Rule::unique(Product::class, 'code')->ignore($product->id)],
            'name' => ['required', 'max:128'],
            'description' => ['required', 'max:1024'],
            'price' => ['required', 'numeric', 'min:0'],
            // 'type' => ['required', Rule::in(ProductType::values())],
            'photo' => ['sometimes', 'nullable', 'image', 'max:1024'],
        ]);

        $product->update(array_merge($validatedData, [
            'photo' => StorageService::public()
                ->uploadOrReturnDefault('photo', $product->photo, 'product-photos'),
        ]));

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted!');
    }

    public function transaction(Product $product)
    {
        return view('products.transaction', [
            "title" => "Product Transaction",
            "product" => $product,
        ]);

    }

    public function decrease(Product $product)
    {
        return view('products.decrease', [
            "title" => "Product Decrease",
            "product" => $product,
        ]);

    }

    public function transactionPost(Request $request, Product $product)
    {
        $totalStocks = $product->loadSum('productStocks', 'quantity')?->product_stocks_sum_quantity ?? 0;

        $validatedData = $request->validate([
            'total' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'numeric', 'min:1', 'max:' . intval($totalStocks ?? 0)],
            'date' => ['required', 'date'],
            'reason' => ['required','string'],
        ]);

        try {
            $quantity = intval($validatedData['quantity']) ?? 0;

            DB::beginTransaction();
            // $product->decrement('stocks', intval($validatedData['quantity'] ?? 0));
            $product->update([
                'last_new_stocks' => null
            ]);

            $productStocks = Stock::query()->where('product_id', $product->id)->where('quantity', '>', 0)->oldest()->get();

            foreach ($productStocks as $stock) {
                if ($quantity > 0) {
                    // jika quantity (10) > stock saat ini (9), maka kurangi stock saat ini sesuai jumlah stock saat ini (9)
                    if ($quantity > $stock->quantity) {
                        $stockQuantity = $stock->quantity;
                        $stock->update([
                            'quantity' => 0
                        ]);
                        $quantity = $quantity - $stockQuantity;
                        continue;
                    }
                    // jika quantity (8) <= stock saat ini (9), maka kurangi stock saat ini sebesar quantity (8), sisa 1 nya akan looping dan menjalankan sesaui algoritma pertama
                    if ($quantity > 0 && $quantity <= $stock->quantity) {
                        $stockQuantity = $stock->quantity;
                        $stock->decrement('quantity', $quantity);
                        $quantity = $quantity - $stockQuantity;
                    }
                } else {
                    break;
                }
            }

            History::create(array_merge($validatedData, [
                'product_id' => $product->id,
            ]));
            DB::commit();
            return redirect()->route('dashboard.index')->with('success', 'Product transaction success!');
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    public function decreasePost(Request $request, Product $product)
    {
        $totalStocks = $product->loadSum('productStocks', 'quantity')?->product_stocks_sum_quantity ?? 0;
    
        $validatedData = $request->validate([
            'quantity' => ['required', 'numeric', 'min:1', 'max:' . intval($totalStocks)],
            'date' => ['required', 'date'],
            'reason' => ['required', 'string', 'in:Destroy,Broken,Lost,Return'],
        ]);
    
        try {
            $quantity = intval($validatedData['quantity']);
            $price = $product->price;
            $reason = $validatedData['reason'];
            $total = 0;
    
            // Adjust total based on reason
            if ($reason != 'Return') {
                $total = $quantity * $price;
                $total = "-$total"; // Adding sign for negative total
            }
    
            DB::beginTransaction();
            
            // Reset last_new_stocks field
            $product->update([
                'last_new_stocks' => null
            ]);
    
            // Retrieve the oldest stocks first
            $productStocks = Stock::query()->where('product_id', $product->id)->where('quantity', '>', 0)->oldest()->get();
    
            foreach ($productStocks as $stock) {
                if ($quantity > 0) {
                    if ($quantity > $stock->quantity) {
                        $stockQuantity = $stock->quantity;
                        $stock->update([
                            'quantity' => 0
                        ]);
                        $quantity -= $stockQuantity;
                    } else {
                        $stock->decrement('quantity', $quantity);
                        $quantity = 0;
                    }
                } else {
                    break;
                }
            }
    
            History::create([
                'product_id' => $product->id,
                'total' => $total,
                'quantity' => $validatedData['quantity'],
                'date' => $validatedData['date'],
                'reason' => $validatedData['reason'],
            ]);
            
            DB::commit();
            return redirect()->route('dashboard.index')->with('success', 'Product decrease success!');
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Error during decrease operation: ' . $ex->getMessage()]);
        }
    }
    


    public function detail(Product $product)
    {
        $product->load('productStocks');

        return view('products.detail', [
            "title" => "Product Detail",
            "product" => $product,
        ]);
    }

    public function destroyStock(Request $request, Product $product, Stock $stock)
{
    $validatedData = $request->validate([
        'reason' => 'required|string|in:Destroy,Broken,Lost,Return',
    ]);

    try {
        DB::beginTransaction();

        $reason = $validatedData['reason'];
        $quantity = $stock->quantity;
        $price = $product->price;
        $total = 0;

        // // Adjust total based on reason
        // if ($reason == 'retur') {
        //     $total = "+$total"; // Adding sign for positive total
        // } else {
        //     $total = "-$total"; // Adding sign for negative total
        // }

        if ($reason != 'Return') {
            $total = $quantity * $price;
            $total = "-$total"; // Adding sign for negative total
        }

        $historyData = [
            'product_id' => $product->id,
            'reason' => $reason,
            'quantity' => $quantity,
            'date' => now(),
            'total' => $total,
        ];

        History::create($historyData);

        $stock->delete();

        DB::commit();

        return redirect()->route('products.detail', $product)->with('success', 'Stock deleted and history recorded!');
    } catch (\Exception $ex) {
        DB::rollBack();
        return redirect()->route('products.detail', $product)->with('error', 'Failed to delete stock.');
    }
}


}
