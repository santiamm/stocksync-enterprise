<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Datos de ejemplo para probar el sistema: productos y movimientos de una bodega ficticia.
     */
    public function run(): void
    {
        $user = User::where('email', 'demo@stocksync.test')->first();
        $cat = Category::pluck('id', 'name');

        // [categoría, SKU, nombre, precio, stock, alerta mínima]
        $products = [
            ['Electrónica', 'ELE-001', 'Cable HDMI 2 m', 18000, 45, 10],
            ['Electrónica', 'ELE-002', 'Mouse inalámbrico', 35000, 12, 8],
            ['Electrónica', 'ELE-003', 'Teclado USB', 42000, 6, 8],
            ['Electrónica', 'ELE-004', 'Cargador USB-C 20 W', 29000, 20, 5],
            ['Ferretería', 'FER-001', 'Martillo de uña 16 oz', 27000, 15, 5],
            ['Ferretería', 'FER-002', 'Caja de tornillos 1" x100', 9500, 60, 20],
            ['Ferretería', 'FER-003', 'Cinta métrica 5 m', 14000, 3, 5],
            ['Ferretería', 'FER-004', 'Destornillador de estrella', 8000, 25, 10],
            ['Textiles', 'TEX-001', 'Guantes de carnaza (par)', 12000, 40, 15],
            ['Textiles', 'TEX-002', 'Chaleco reflectivo', 22000, 9, 10],
            ['Textiles', 'TEX-003', 'Overol talla M', 65000, 14, 4],
            ['Insumos Médicos', 'MED-001', 'Caja de guantes de nitrilo x100', 28000, 18, 6],
            ['Insumos Médicos', 'MED-002', 'Tapabocas x50', 15000, 4, 10],
            ['Insumos Médicos', 'MED-003', 'Alcohol antiséptico 1 L', 11000, 30, 8],
            ['Insumos Médicos', 'MED-004', 'Botiquín básico', 48000, 7, 3],
        ];

        foreach ($products as [$category, $sku, $name, $price, $stock, $min]) {
            Product::create([
                'category_id' => $cat[$category],
                'sku' => $sku,
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
                'min_stock_alert' => $min,
            ]);
        }

        // Historial de ejemplo. El stock de arriba ya es el resultado de estos movimientos.
        $movements = [
            ['FER-002', 'in', 50, 'Llegada proveedor - Factura #1042', 6],
            ['ELE-002', 'out', 3, 'Despacho a oficina principal', 5],
            ['TEX-001', 'in', 20, 'Compra de dotación', 4],
            ['MED-002', 'out', 6, 'Entrega a enfermería', 3],
            ['FER-003', 'adjustment', 3, 'Conteo físico: faltaban 2 unidades', 2],
            ['ELE-003', 'out', 2, 'Despacho a sede norte', 1],
        ];

        foreach ($movements as [$sku, $type, $quantity, $note, $daysAgo]) {
            $movement = StockMovement::create([
                'product_id' => Product::where('sku', $sku)->value('id'),
                'user_id' => $user->id,
                'type' => $type,
                'quantity' => $quantity,
                'reference_note' => $note,
            ]);
            $movement->created_at = now()->subDays($daysAgo);
            $movement->save();
        }
    }
}
