<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);

        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('supplier');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'uid' => 'required|string|max:255|unique:suppliers,uid',
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'material_certificate' => 'nullable|string|max:255',
            'last_audit' => 'nullable|date',
            'status' => 'required|string|max:100',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'uid' => 'required|string|max:255|unique:suppliers,uid,' . $supplier->id,
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'material_certificate' => 'nullable|string|max:255',
            'last_audit' => 'nullable|date',
            'status' => 'required|string|max:100',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete($supplier->id);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
