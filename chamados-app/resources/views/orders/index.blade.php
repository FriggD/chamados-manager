
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left">Service Orders</h3>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary float-right">Create New</a>
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
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Created At</th>
                                <th>Actions</th>
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
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
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
