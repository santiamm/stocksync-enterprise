<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Models\Product;
use App\Models\StockMovement;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::middleware(['auth'])->group(function () {

    // Rutas para importación/exportación masiva
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('movements', StockMovementController::class);
    

});

Route::get('/', function () {
    // Si el usuario no ha iniciado sesión, Laravel (gracias al middleware auth) 
    // lo mandará al Login automáticamente. Si ya inició, entrará directo.
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    // 1. Cálculos generales
    $totalProducts = Product::count();
    $totalStock = Product::sum('stock');
    
    // 2. Valor total del inventario (Stock * Precio)
    $totalValue = Product::selectRaw('SUM(stock * price) as total')->value('total') ?? 0;

    // 3. Productos en alerta crítica (Stock <= Alerta mínima)
    $criticalProducts = Product::whereColumn('stock', '<=', 'min_stock_alert')->get();
    
    // 4. Últimos movimientos (para el historial rápido)
    $recentMovements = StockMovement::with(['product', 'user'])
                        ->latest()
                        ->take(5)
                        ->get();

    return view('dashboard', compact(
        'totalProducts', 
        'totalStock', 
        'totalValue', 
        'criticalProducts',
        'recentMovements'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
