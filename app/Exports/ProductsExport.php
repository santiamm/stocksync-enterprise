<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select('sku', 'name', 'price', 'stock', 'min_stock_alert')->get();
    }

    public function headings(): array
    {
        return ['SKU', 'Nombre', 'Precio', 'Stock Actual', 'Alerta Stock Mínimo'];
    }
}