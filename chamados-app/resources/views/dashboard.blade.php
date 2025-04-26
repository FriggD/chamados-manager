@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Dashboard</h1>
        </div>
    </div>

    <!-- Monthly Metrics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-month"></i> Métricas Mensais</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $totalMonthly }}</h3>
                                    <p class="card-text">Total de Chamados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $completionRateMonthly }}%</h3>
                                    <p class="card-text">Taxa de Conclusão</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-warning">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $openMonthly }}</h3>
                                    <p class="card-text">Chamados Abertos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-danger">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $lateMonthly }}</h3>
                                    <p class="card-text">Chamados Atrasados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Metrics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-day"></i> Métricas Diárias</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $totalDaily }}</h3>
                                    <p class="card-text">Total de Chamados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $completionRateDaily }}%</h3>
                                    <p class="card-text">Taxa de Conclusão</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-warning">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $openDaily }}</h3>
                                    <p class="card-text">Chamados Abertos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-danger">
                                <div class="card-body text-center">
                                    <h3 class="card-title">{{ $lateDaily }}</h3>
                                    <p class="card-text">Chamados Atrasados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Chamados por Categoria</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Chamados por Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Chamados Recentemente atualizados</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Categoria</th>
                                    <th>Status</th>
                                    <th>Prazo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->title }}</td>
                                        <td>{{ $order->category->name }}</td>
                                        <td>{{ $order->status->name }}</td>
                                        <td>{{ $order->due_date }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm"><i class="bi bi-search"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhum chamado encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart for Categories
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($ordersByCategory);

    new Chart(categoryCtx, {
        type: 'pie',
        data: {
            labels: categoryData.map(item => item.name),
            datasets: [{
                data: categoryData.map(item => item.total),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });

    // Chart for Status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($ordersByStatus);

    new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: statusData.map(item => item.name),
            datasets: [{
                label: 'Número de Chamados',
                data: statusData.map(item => item.total),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>
@endsection