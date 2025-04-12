<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class KategoriControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreSuccesfully(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'AD',
        ]);

        $this->actingAs($user);

        $data = [
            'name' => 'Test Kategori',
        ];
        $response = $this->post(route('kategori.store'), $data);


        $response->assertStatus(302);

        $this->assertDatabaseHas('kategori', $data);
    }
}
