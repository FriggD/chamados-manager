<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Orders;
use App\Models\Category;
use App\Models\Status;
use Carbon\Carbon;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the dashboard page loads correctly.
     */
    public function test_dashboard_page_loads(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Test if the dashboard contains the required metrics.
     */
    public function test_dashboard_contains_metrics(): void
    {
        // Create test data
        $category = Category::create(['name' => 'Test Category']);
        $status = Status::create(['name' => 'Test Status']);
        
        // Create an order
        Orders::create([
            'title' => 'Test Order',
            'category_id' => $category->id,
            'status_id' => $status->id,
            'due_date' => Carbon::now()->addDays(3),
            'created_at' => Carbon::now(),
        ]);

        $response = $this->get(route('dashboard'));
        
        // Assert that the response contains the metrics
        $response->assertSee('Métricas Mensais');
        $response->assertSee('Métricas Diárias');
        $response->assertSee('Chamados por Categoria');
        $response->assertSee('Chamados por Status');
        $response->assertSee('Chamados Recentes');
    }
}