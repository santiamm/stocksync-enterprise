<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        // Traemos los productos junto con su categoría para optimizar consultas
        $products = Product::with('category')->get();
        $categories = Category::orderBy('name')->get();
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock_alert' => 'required|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        // Se reutiliza el mismo formulario de creación
        $categories = Category::all();
        return view('products.create', compact('categories', 'product'));
    }

    public function update(Request $request, Product $product)
    {
        // El stock no se edita aquí: se cambia con movimientos para que quede en el historial
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => ['required', 'string', Rule::unique('products')->ignore($product->id)],
            'price' => 'required|numeric|min:0',
            'min_stock_alert' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        // Regla de negocio: si el producto ya tiene movimientos, borrarlo eliminaría su historial.
        $movementsCount = $product->movements()->count();

        if ($movementsCount > 0) {
            return redirect()->route('products.index')
                ->withErrors(['No puedes eliminar este producto porque tiene ' . $movementsCount . ' movimiento(s) registrado(s).']);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'inventario_productos.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'category_id' => 'required|exists:categories,id',
        ], [
            'category_id.required' => 'Selecciona la categoría para los productos nuevos antes de importar.',
        ]);

        try {
            Excel::import(new ProductsImport((int) $request->category_id), $request->file('file'));
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('products.index')
                ->withErrors(['No se pudo importar el archivo. Revisa que tenga las columnas: SKU, Nombre, Precio, Stock Actual, Alerta Stock Mínimo.']);
        }

        return redirect()->route('products.index')->with('success', 'Inventario importado exitosamente.');
    }
}
