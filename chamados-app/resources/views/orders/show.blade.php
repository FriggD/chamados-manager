@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left text-xl">Detalhes do chamado</h3>
                </div>

                <div class="card-body">
                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">ID:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->id }}</p>
                        </div>
                    </div>

                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Título:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->title }}</p>
                        </div>
                    </div>

                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Categoria:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->category->name }}</p>
                        </div>
                    </div>

                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Status:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->status->name }}</p>
                        </div>
                    </div>

                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">prazo:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->due_date }}</p>
                        </div>
                    </div>

                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Solucionado em:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->solution_date ?? "Não solucionado." }}</p>
                        </div>
                    </div>

                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Criado em:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="form-group row m-1">
                        <label class="col-md-4 col-form-label text-md-right font-weight-bold">Última atualização:</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ $order->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0 mt-5">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                                Editar
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                Voltar
                            </a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Remover</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection