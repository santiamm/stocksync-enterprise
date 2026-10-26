<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/');

        // La raíz lleva al dashboard y, sin sesión, al login
        $response->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }
}
