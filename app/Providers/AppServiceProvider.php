<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();

        if (!app()->runningInConsole()) {
            $notifications = [];

            $notifProducts = Product::query()->latest()->select(['id', 'name'])->withSum('productStocks', 'quantity')->get()->where('product_stocks_sum_quantity', '<', 10);

            foreach ($notifProducts as $product) {
                $notifications[] = sprintf("[Almost Empty] %s stock is less than 10", $product->name);
            }

            $notifStocks = Stock::query()
                ->whereNotNull('expired_date')
                ->whereDate('expired_date', '<=', today()->addDays(5))
                ->orderBy('expired_date')
                ->with('product')->get();

            foreach ($notifStocks as $stock) {
                $notifications[] = sprintf("[Almost Expired] %s stock is almost expired at %s", $stock->product->name, $stock->expired_date->format('d F Y'));
            }

            View::share('notifications', $notifications);
        }
    }
}
