<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * Recorre todas las pantallas y flujos con los datos de ejemplo para comprobar que nada falla.
 */
class SmokeTest extends TestCase
{
    use RefreshDatabase;

    private User $demo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->demo = User::where('email', 'demo@stocksync.test')->first();
    }

    public function test_guest_pages_load(): void
    {
        foreach (['/login', '/register', '/forgot-password'] as $url) {
            $this->get($url)->assertOk()->assertSee('StockSync');
        }
    }

    public function test_every_page_loads_with_demo_data(): void
    {
        $product = Product::first();

        foreach ([
            '/dashboard', '/products', '/products/create', '/products/' . $product->id . '/edit',
            '/categories', '/categories/create', '/movements', '/movements/create', '/profile', '/confirm-password',
        ] as $url) {
            $this->actingAs($this->demo)->get($url)->assertOk();
        }
    }

    public function test_dashboard_shows_demo_figures(): void
    {
        $this->actingAs($this->demo)->get('/dashboard')
            ->assertSee('Resumen de bodega')
            ->assertSee('Por reponer')
            ->assertSee('Teclado USB');
    }

    public function test_login_with_demo_user(): void
    {
        $this->post('/login', ['email' => 'demo@stocksync.test', 'password' => 'password'])
            ->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->demo);
    }

    public function test_wrong_password_shows_spanish_message(): void
    {
        $this->from('/login')->post('/login', ['email' => 'demo@stocksync.test', 'password' => 'mala'])
            ->assertSessionHasErrors(['email' => 'El correo o la contraseña no son correctos.']);
    }

    public function test_forgot_password_does_not_fail(): void
    {
        config(['mail.default' => 'array']);

        $this->post('/forgot-password', ['email' => 'demo@stocksync.test'])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('status');
    }

    public function test_export_downloads_excel(): void
    {
        $response = $this->actingAs($this->demo)->get('/products/export');

        $response->assertOk();
        $this->assertStringContainsString('inventario_productos.xlsx', $response->headers->get('content-disposition'));
    }

    public function test_create_product_and_category(): void
    {
        $this->actingAs($this->demo)->post('/categories', ['name' => 'Aseo', 'description' => 'Productos de limpieza'])
            ->assertRedirect('/categories');
        $category = Category::where('name', 'Aseo')->first();

        $this->actingAs($this->demo)->post('/products', [
            'name' => 'Escoba', 'category_id' => $category->id, 'sku' => 'ASE-001',
            'price' => 9000, 'stock' => 4, 'min_stock_alert' => 2,
        ])->assertRedirect('/products');

        $this->assertDatabaseHas('products', ['sku' => 'ASE-001', 'stock' => 4]);
    }

    public function test_missing_field_shows_spanish_message(): void
    {
        $this->actingAs($this->demo)->from('/products/create')->post('/products', [])
            ->assertSessionHasErrors(['name' => 'Falta nombre.']);
    }

    public function test_category_rules(): void
    {
        $withProducts = Category::has('products')->first();
        $this->actingAs($this->demo)->delete('/categories/' . $withProducts->id)->assertSessionHasErrors();
        $this->assertNotNull($withProducts->fresh());

        $empty = Category::create(['name' => 'Vacía']);
        $this->actingAs($this->demo)->delete('/categories/' . $empty->id)->assertSessionHasNoErrors();
        $this->assertNull($empty->fresh());
    }

    public function test_out_movement_can_leave_stock_at_zero(): void
    {
        $product = Product::where('sku', 'FER-003')->first();

        $this->actingAs($this->demo)->post('/movements', [
            'product_id' => $product->id, 'type' => 'out', 'quantity' => $product->stock, 'reference_note' => '',
        ])->assertSessionHasNoErrors();

        $this->assertSame(0, $product->fresh()->stock);
    }

    public function test_import_with_bad_numbers_saves_nothing(): void
    {
        $file = UploadedFile::fake()->createWithContent('malo.csv',
            "SKU,Nombre,Precio,Stock Actual,Alerta Stock Minimo\nNUE-001,Nuevo,100,5,1\nNUE-002,Otro,abc,5,1\n");

        $this->actingAs($this->demo)
            ->post('/products/import', ['category_id' => Category::first()->id, 'file' => $file])
            ->assertSessionHasErrors();

        $this->assertDatabaseMissing('products', ['sku' => 'NUE-001']);
    }

    public function test_account_with_movements_cannot_be_deleted(): void
    {
        $this->actingAs($this->demo)->delete('/profile', ['password' => 'password'])
            ->assertSessionHasErrorsIn('userDeletion', 'password');

        $this->assertNotNull($this->demo->fresh());
        $this->assertSame(6, StockMovement::count());
    }

    public function test_account_without_movements_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->delete('/profile', ['password' => 'password'])->assertRedirect('/');
        $this->assertNull($user->fresh());
    }
}
