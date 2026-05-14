<?php

namespace App\Http\Controllers;

use App\Http\Requests\LayupRequest;
use App\Models\Layup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\LayupExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LayupImport;

class LayupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


        public function generateUniqueCode()
    {
        do {

            $code = 'LAY-' . now()->format('Ymd') . '-' . strtoupper(Str::random(1));
        } while (Layup::where('uid', $code)->exists());

        return $code;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LayupRequest $request)
    {
         $validated = $request->validated();
         $validated['uid'] = $this->generateUniqueCode();
      
       $layup = Layup::create($validated);

        foreach ($validated['layers'] as $layer) {
           $layup->layers()->create([
               'layer_order' => $layer['layer_order'],
               'thickness' => $layer['thickness'],
               'width' => $layer['width'],
               'angle' => $layer['angle'],
               'grade' => $layer['grade'],
           ]);
        }

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier created successfully.');
    }


    public function export()
{

    
    return Excel::download(
        new LayupExport,
        'layups.xlsx'
    );

}


public function import(Request $request)
{
    $request->validate([
        'file' => ['required', 'mimes:xlsx,xls,csv']
    ]);

    Excel::import(
        new LayupImport,
        $request->file('file')
    );

    return back()->with(
        'success',
        'Layup imported successfully'
    );
}

    /**
     * Display the specified resource.
     */
    public function show( Layup $layup)
    {
         return view('layup.show', compact('layup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LayupRequest $request, Layup $layup)
    {
         $validated = $request->validated();
         $layup->update($validated);

       
        $layup->layers()->delete();


        foreach ($validated['layers'] as $layer) {
        $layup->layers()->create([
            'layer_order' => $layer['layer_order'], 
            'thickness'   => $layer['thickness'],
            'width'       => $layer['width'],
            'angle'       => $layer['angle'],
            'grade'       => $layer['grade'],
        ]);
    }


         return redirect()
            ->route('layup.index')
            ->with('success', 'layup created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layup $layup)
    {
         $layup->delete($layup->id);

        return back()
            ->with('success', 'Supplier deleted successfully.');
    }
}
