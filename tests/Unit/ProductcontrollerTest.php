<?php

namespace Tests\Feature\Http\Controllers\API;

use App\Models\Product;
use App\Models\RamSpec;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    /**
     * Test updating a product with valid data.
     */
    public function test_update_product_with_valid_data()
    {
        $product = Product::factory()->create([
            'category' => 'ram',
        ]);

        $ramSpec = RamSpec::factory()->create([
            'product_id' => $product->id,
        ]);

        $payload = [
            'name' => 'Updated Product Name',
            'description' => 'Updated description',
            'category' => 'ram',
            'model' => 'Updated Model',
            'brand' => 'Updated Brand',
            'price' => 199.99,
            'quantity' => 10,
            'on_offer' => true,
            'discount' => 10,
            'featured' => true,
            'speed' => 3200,
            'latency' => 16,
            'memory' => 16,
            'memory_type' => 'DDR4',
        ];

        $response = $this->putJson(route('products.update', $product->id), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Product updated successfully.',
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
        ]);

        $this->assertDatabaseHas('ram_specs', [
            'product_id' => $product->id,
            'speed' => 3200,
            'latency' => 16,
        ]);
    }
}