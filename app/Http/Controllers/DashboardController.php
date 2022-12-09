<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsic;
use App\Models\FsicTransaction;
use App\Models\Fsec;
use App\Models\FsecTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $fsic = Fsic::get();
        $fsec = Fsec::get();
        return view('dashboard', compact('fsic','fsec'));
    }
}
