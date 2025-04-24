@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Service Order Details</h3>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">ID:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->id }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Title:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->title }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Category:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->category->name }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Status:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->status->name }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Due Date:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->due_date }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Solution Date:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->solution_date }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Created At:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Updated At:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                                Edit
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                Back to List
                            </a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection