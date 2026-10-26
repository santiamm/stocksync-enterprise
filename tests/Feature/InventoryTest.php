<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::create(['name' => 'Ferretería']);
    }

    private function product(array $data = []): Product
    {
        return Product::create($data + [
            'category_id' => $this->category->id,
            'name' => 'Martillo',
            'sku' => 'FER-001',
            'price' => 1000,
            'stock' => 2,
            'min_stock_alert' => 1,
        ]);
    }

    private function csv(string $rows): UploadedFile
    {
        return UploadedFile::fake()->createWithContent('inventario.csv', "SKU,Nombre,Precio,Stock Actual,Alerta Stock Minimo\n" . $rows);
    }

    public function test_main_pages_load(): void
    {
        $product = $this->product();

        foreach (['/dashboard', '/products', '/products/create', '/products/' . $product->id . '/edit', '/categories', '/categories/create', '/movements', '/movements/create'] as $url) {
            $this->actingAs($this->user)->get($url)->assertOk();
        }
    }

    public function test_out_movement_cannot_leave_negative_stock(): void
    {
        $product = $this->product();

        $this->actingAs($this->user)
            ->post('/movements', ['product_id' => $product->id, 'type' => 'out', 'quantity' => 10])
            ->assertSessionHasErrors('quantity');

        $this->assertSame(2, $product->fresh()->stock);
        $this->assertSame(0, StockMovement::count());
    }

    public function test_movements_update_stock(): void
    {
        $product = $this->product();

        $this->actingAs($this->user)->post('/movements', ['product_id' => $product->id, 'type' => 'in', 'quantity' => 5]);
        $this->assertSame(7, $product->fresh()->stock);

        $this->actingAs($this->user)->post('/movements', ['product_id' => $product->id, 'type' => 'out', 'quantity' => 3]);
        $this->assertSame(4, $product->fresh()->stock);

        // Ajuste por conteo físico: la cantidad es lo que se contó, incluso 0
        $this->actingAs($this->user)->post('/movements', ['product_id' => $product->id, 'type' => 'adjustment', 'quantity' => 0]);
        $this->assertSame(0, $product->fresh()->stock);
    }

    public function test_import_uses_selected_category_and_keeps_existing_category(): void
    {
        $other = Category::create(['name' => 'Textiles']);
        $this->product(['category_id' => $other->id]);

        $this->actingAs($this->user)->post('/products/import', [
            'category_id' => $this->category->id,
            'file' => $this->csv("FER-001,Martillo,1000,9,1\nFER-002,Tornillos,50,100,20\n"),
        ])->assertSessionHasNoErrors();

        $existing = Product::where('sku', 'FER-001')->first();
        $this->assertSame($other->id, $existing->category_id);
        $this->assertSame(9, $existing->stock);
        $this->assertSame($this->category->id, Product::where('sku', 'FER-002')->value('category_id'));
    }

    public function test_import_with_wrong_columns_shows_error(): void
    {
        $file = UploadedFile::fake()->createWithContent('malo.csv', "Codigo,Descripcion\nA,B\n");

        $this->actingAs($this->user)
            ->post('/products/import', ['category_id' => $this->category->id, 'file' => $file])
            ->assertSessionHasErrors();
    }

    public function test_product_can_be_edited_without_changing_stock(): void
    {
        $product = $this->product();

        $this->actingAs($this->user)->put('/products/' . $product->id, [
            'name' => 'Martillo 16 oz',
            'category_id' => $this->category->id,
            'sku' => 'FER-001',
            'price' => 1200,
            'min_stock_alert' => 3,
            'stock' => 999,
        ])->assertRedirect('/products');

        $product->refresh();
        $this->assertSame('Martillo 16 oz', $product->name);
        $this->assertSame(2, $product->stock);
    }

    public function test_product_with_movements_cannot_be_deleted(): void
    {
        $product = $this->product();
        $this->actingAs($this->user)->post('/movements', ['product_id' => $product->id, 'type' => 'in', 'quantity' => 1]);

        $this->actingAs($this->user)->delete('/products/' . $product->id)->assertSessionHasErrors();
        $this->assertNotNull($product->fresh());

        $empty = $this->product(['sku' => 'FER-002']);
        $this->actingAs($this->user)->delete('/products/' . $empty->id)->assertSessionHasNoErrors();
        $this->assertNull($empty->fresh());
    }

    public function test_demo_seeder_runs(): void
    {
        $this->seed();

        $this->assertSame(15, Product::count());
        $this->assertSame(6, StockMovement::count());
        $this->assertDatabaseHas('users', ['email' => 'demo@stocksync.test']);
    }
}
