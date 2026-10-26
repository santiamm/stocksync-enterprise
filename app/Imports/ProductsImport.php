<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements ToModel, WithHeadingRow, WithUpserts, WithUpsertColumns
{
    /**
     * Categoría que se asigna a los productos nuevos (la elige el usuario al importar).
     */
    public function __construct(private int $categoryId)
    {
    }

    /**
     * Define qué columna determina si el registro ya existe.
     */
    public function uniqueBy()
    {
        return 'sku';
    }

    /**
     * Columnas que se actualizan cuando el SKU ya existe.
     * La categoría no se toca, para no mover productos existentes.
     */
    public function upsertColumns()
    {
        return ['name', 'price', 'stock', 'min_stock_alert', 'updated_at'];
    }

    public function model(array $row)
    {
        // Si el archivo no trae las columnas esperadas se detiene la importación
        $missing = array_diff(['sku', 'nombre', 'precio', 'stock_actual', 'alerta_stock_minimo'], array_keys($row));
        if ($missing) {
            throw new \InvalidArgumentException('Faltan columnas: ' . implode(', ', $missing));
        }

        // Filas vacías al final del Excel
        if (empty($row['sku'])) {
            return null;
        }

        return new Product([
            'category_id'     => $this->categoryId,
            'sku'             => (string) $row['sku'],
            'name'            => $row['nombre'],
            'price'           => $row['precio'],
            'stock'           => $row['stock_actual'],
            'min_stock_alert' => $row['alerta_stock_minimo'],
        ]);
    }
}
