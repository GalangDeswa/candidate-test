<?php

namespace App\Http\Controllers;

use App\Imports\SupplierImportReader;
use App\Models\PendingImport;
use App\Services\ImportAnalyzerService;
use Illuminate\Http\Request;

use App\Services\ImportCommitService;
use Maatwebsite\Excel\Facades\Excel;

class PendingImportController extends Controller
{
 
    public function check(Request $request)
    {
        $import = new SupplierImportReader();

        Excel::import($import, $request->file('file'));

        $data = [
            'suppliers' => $import->suppliers->rows,
            'layups' => $import->layups->rows,
            'layers' => $import->layers->rows,
        ];

     

        $analyzer = new ImportAnalyzerService();

        $analysis = $analyzer->analyze($data);


        $session = PendingImport::create([
            'type' => 'supplier_import',
            'result' => $analysis,
        ]);

        return response()->json([
            'session_id' => $session->id,
            'analysis' => $analysis,
        ]);
    }



 public function commit(Request $request)
{
    $session =
        PendingImport::findOrFail(
            $request->session_id
        );

   $analysis =
    $session->result;



    app(ImportCommitService::class)
        ->commit(
            $analysis,
            $request->resolutions ?? []
        );

    //  $session->delete();

    return response()->json([
        'message' => 'Import committed successfully'
    ]);
}


}
