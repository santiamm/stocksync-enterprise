<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function index()
    {
        // Traemos los movimientos con su producto y el usuario que lo hizo
        $movements = StockMovement::with(['product', 'user'])->latest()->get();
        return view('movements.index', compact('movements'));
    }

    public function create()
    {
        // Necesitamos la lista de productos para poder seleccionarlos en el formulario
        $products = Product::all();
        return view('movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'reference_note' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Usamos una transacción de base de datos para asegurar que ambos pasos 
        // (crear movimiento y actualizar stock) se ejecuten correctamente o ninguno lo haga.
        DB::transaction(function () use ($validated, $product) {
            
            // 1. Registrar el movimiento en el historial
            StockMovement::create([
                'product_id' => $validated['product_id'],
                'user_id' => Auth::id(), // Registra qué operario está haciendo esto
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'reference_note' => $validated['reference_note'],
            ]);

            // 2. Actualizar el inventario general del producto
            if ($validated['type'] === 'in') {
                $product->increment('stock', $validated['quantity']);
            } elseif ($validated['type'] === 'out') {
                $product->decrement('stock', $validated['quantity']);
            } elseif ($validated['type'] === 'adjustment') {
                 // En un ajuste (ej. después de un conteo físico), decidimos que "quantity" es la cantidad real
                $product->update(['stock' => $validated['quantity']]);
            }
        });

        return redirect()->route('movements.index')->with('success', 'Movimiento registrado y stock actualizado.');
    }
}