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

        // Cada fila debe traer nombre y números válidos; si no, se avisa qué SKU revisar
        $sku = (string) $row['sku'];
        if (blank($row['nombre'])) {
            throw new \InvalidArgumentException("El SKU {$sku} no tiene nombre.");
        }
        if (! is_numeric($row['precio']) || $row['precio'] < 0) {
            throw new \InvalidArgumentException("El precio del SKU {$sku} debe ser un número mayor o igual a 0.");
        }
        foreach (['stock_actual' => 'stock actual', 'alerta_stock_minimo' => 'stock mínimo'] as $key => $label) {
            if (! is_numeric($row[$key]) || $row[$key] < 0 || floor($row[$key]) != $row[$key]) {
                throw new \InvalidArgumentException("El {$label} del SKU {$sku} debe ser un número entero mayor o igual a 0.");
            }
        }

        return new Product([
            'category_id'     => $this->categoryId,
            'sku'             => $sku,
            'name'            => $row['nombre'],
            'price'           => $row['precio'],
            'stock'           => $row['stock_actual'],
            'min_stock_alert' => $row['alerta_stock_minimo'],
        ]);
    }
}
