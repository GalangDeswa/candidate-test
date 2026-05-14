<?php

namespace App\Http\Controllers;

use App\Models\Layer;
use App\Models\Layup;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
       public function index()
    {
        $allSupliers = Supplier::count();
        $AllLayups = Layup::count();
        $allLayers = Layer::count();
       

        return view('dashboard.index', compact('allSupliers', 'AllLayups', 'allLayers'));
    }
}
