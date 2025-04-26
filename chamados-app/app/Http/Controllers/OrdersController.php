<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::with(['category', 'status'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $statuses = Status::all();
        return view('orders.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status_novo = Status::where('name', 'Novo')->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'nullable|exists:status,id',
            'due_date' => 'nullable|date'
        ]);

        $data = $request->all();
        $data['status_id'] = $data['status_id'] ?? $status_novo->id;
        $data['due_date'] = $data['due_date'] ?? now()->addDays(3);

        Orders::create($data);

        return redirect()->route('orders.index')
            ->with('success', 'Chamado criado!');
    }

    /**
     * Set the state to "Resolvido" and set the solved date
     */
    public function complete(Request $request, Orders $order)
    {
        $status_resolvido = Status::where('name', 'Resolvido')->firstOrFail();

        $order->update([
            'status_id' => $status_resolvido->id,
            'solution_date' => now()
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Chamado solucionado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $order)
    {
        $categories = Category::all();
        $statuses = Status::all();
        return view('orders.edit', compact('order', 'categories', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $order)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:status,id',
            'due_date' => 'nullable|date',
            'solution_date' => 'nullable|date',
        ]);

        $data = $request->all();
        $order_data = Orders::find($order->id);

        if ($order->solution_date) {
            return redirect()->route('orders.index')->with('error', 'Chamado solucionados não podem ser editados!');
        }

        $status = Status::find($request->status_id);
        if ($status->name  == 'Resolvido' && !$order->solution_date) {
            $data['solution_date'] = now();
        }

        $order->update($data);

        return redirect()->route('orders.index')
            ->with('success', 'Chamado atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Service order deleted successfully.');
    }
}