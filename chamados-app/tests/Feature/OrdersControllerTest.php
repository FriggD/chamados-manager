<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Orders;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrdersControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test orders index page.
     */
    public function test_orders_index_page(): void
    {
        $response = $this->get(route('orders.index'));
        $response->assertStatus(200);
        $response->assertViewIs('orders.index');
    }

    /**
     * Test orders create page.
     */
    public function test_orders_create_page(): void
    {
        $response = $this->get(route('orders.create'));
        $response->assertStatus(200);
        $response->assertViewIs('orders.create');
    }

    /**
     * Test store order.
     */
    public function test_store_order(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();

        $orderData = [
            'title' => $this->faker->sentence,
            'category_id' => $category->id,
            'status_id' => $status->id,
            'due_date' => now()->addDays(3)->format('Y-m-d'),
            'solution_date' => now()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->post(route('orders.store'), $orderData);
        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', ['title' => $orderData['title']]);
    }

    /**
     * Test show order.
     */
    public function test_show_order(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();
        $order = Orders::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);

        $response = $this->get(route('orders.show', $order->id));
        $response->assertStatus(200);
        $response->assertViewIs('orders.show');
        $response->assertViewHas('order', $order);
    }

    /**
     * Test edit order page.
     */
    public function test_edit_order_page(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();
        $order = Orders::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);

        $response = $this->get(route('orders.edit', $order->id));
        $response->assertStatus(200);
        $response->assertViewIs('orders.edit');
        $response->assertViewHas('order', $order);
    }

    /**
     * Test update order.
     */
    public function test_update_order(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();
        $order = Orders::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);

        $updatedData = [
            'title' => 'Updated Title',
            'category_id' => $category->id,
            'status_id' => $status->id,
            'due_date' => now()->addDays(4)->format('Y-m-d'),
            'solution_date' => now()->addDays(6)->format('Y-m-d'),
        ];

        $response = $this->put(route('orders.update', $order->id), $updatedData);
        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'title' => 'Updated Title']);
    }

    /**
     * Test delete order.
     */
    public function test_delete_order(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();
        $order = Orders::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);

        $response = $this->delete(route('orders.destroy', $order->id));
        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}