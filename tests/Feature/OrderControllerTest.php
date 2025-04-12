<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreOrderSuccessfully(): void
    {
        // Buat user dan login
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'AD',
        ]);

        $this->actingAs($user);

        // Data order yang akan dikirim
        $data = [
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => 150000.50,
        ];

        // Lakukan request ke route order store
        $response = $this->post(route('transaksi.store'), $data);

        // Cek redirect berhasil
        $response->assertStatus(302);

        // Cek apakah data tersimpan di database
        $this->assertDatabaseHas('order', [
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => 150000.50,
        ]);
    }
}
