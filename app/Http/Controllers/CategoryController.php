<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Traemos las categorías y contamos cuántos productos tiene cada una
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function destroy(Category $category)
    {
        // Regla de negocio: No podemos borrar una categoría si tiene productos adentro.
        // Si lo hacemos, los productos quedarían "huérfanos" y causarían errores.
        $productsCount = Product::where('category_id', $category->id)->count();

        if ($productsCount > 0) {
            return redirect()->route('categories.index')
                ->withErrors(['No puedes eliminar esta categoría porque tiene ' . $productsCount . ' producto(s) asignado(s). Reasigna los productos primero.']);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada correctamente.');
    }
}