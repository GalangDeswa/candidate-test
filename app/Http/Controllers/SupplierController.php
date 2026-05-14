<?php

namespace App\Http\Controllers;


use App\Exports\SupplierExport;
use App\Http\Requests\SupplierRequest;
use App\Imports\SupplierImport;
use App\Imports\SupplierImportReader;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SweetAlert2\Laravel\Swal;

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

    public function generateUniqueCode()
    {
        do {

            $code = 'SUP-' . now()->format('Ymd') . '-' . strtoupper(Str::random(1));
        } while (Supplier::where('uid', $code)->exists());

        return $code;
    }

    public function store(SupplierRequest $request)
    {


        $validated = $request->validated();
        $validated['uid'] = $this->generateUniqueCode();



        Supplier::create($validated);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier created successfully.');
    }



        public function export()
{

    
      return Excel::download(
        new SupplierExport,
        'suppliers.xlsx'
    );

}





public function import(Request $request)
{
    try{
        $request->validate([
        'file' => ['required', 'mimes:xlsx,xls,csv']
    ]);

    Excel::import(
        new SupplierImport,
        request()->file('file')
    );

    return back()->with(
        'success',
        'supplier imported successfully'
    );

    }catch(\Throwable $th){
    //    return back()->with(
    //     'error',$th->getMessage()
    //    );
    dd($th);
    }
    
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
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $validated = $request->validated();

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
