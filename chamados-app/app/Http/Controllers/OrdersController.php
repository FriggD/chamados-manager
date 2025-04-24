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
        $status_pendente = Status::where('name', 'Pendente')->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'due_date' => 'nullable|date',
            'solution_date' => 'nullable|date',
        ]);

        Orders::create($request->all(), [
            'status_id' => $status_pendente->id,
            'solution_date' => null
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Service order created successfully.');
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
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')
            ->with('success', 'Service order updated successfully.');
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