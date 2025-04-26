
@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex;  justify-content: space-between;">
                    <h3 class="float-left"> <i class="bi bi-list-check"></i> Chamados</h3>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary float-right">+ Novo</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th>Prazo</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->title }}</td>
                                    <td>{{ $order->category->name }}</td>
                                    <td>{{ $order->status->name }}</td>
                                    <td>{{ $order->due_date }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm"><i class="bi bi-search"></i></a>
                                        @if ($order->status->name !== "Resolvido")
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pen-fill"></i></a>
                                        @endif
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No service orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
