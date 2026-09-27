<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
     * Define qué columna determina si el registro ya existe.
     */
    public function uniqueBy()
    {
        return 'sku';
    }

    public function model(array $row)
    {
        return new Product([
            'category_id'     => 1, // ID por defecto
            'sku'             => (string) $row['sku'],
            'name'            => $row['nombre'],
            'price'           => $row['precio'],
            'stock'           => $row['stock_actual'],
            'min_stock_alert' => $row['alerta_stock_minimo'],
        ]);
    }
}