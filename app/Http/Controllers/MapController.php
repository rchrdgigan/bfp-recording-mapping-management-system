<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsec;
use App\Models\FsecTransaction;
use App\Models\Fsic;
use App\Models\FsicTransaction;
use Carbon\Carbon;

class MapController extends Controller
{
    public function index()
    {
        if(request('search')){
            $searchString = request('search');
            
            $fsec_trans = FsecTransaction::whereHas('fsec', function ($query) use ($searchString){
                $query->where('fsec_no', $searchString)
                ->orWhere('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            })
            ->with(['fsec' => function($query) use ($searchString){
                $query->where('fsec_no', $searchString)
                ->orWhere('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            }])->get();

            if($fsec_trans->isEmpty()){
                $fsec_trans = FsecTransaction::query()->when(request('search'), function($query){
                    $search = request('search');
                    $query->where('or_no', '=', $search);
                })->get();
            }

            $fsic_trans = FsicTransaction::whereHas('fsic', function ($query) use ($searchString){
                $query->where('fsic_no', $searchString)
                ->orWhere('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            })
            ->with(['fsic' => function($query) use ($searchString){
                $query->where('fsic_no', $searchString)
                ->orWhere('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            }])->get();

            if($fsic_trans->isEmpty()){
                $fsic_trans = FsicTransaction::query()->when(request('search'), function($query){
                    $search = request('search');
                    $query->where('or_no', '=', $search);
                })->get();
            }
            
            return view('mapping.index', compact('fsic_trans','fsec_trans'));

        }elseif(request('status')){

            $fsec_trans = FsecTransaction::query()->when(request('status'), function($query){
                if(request('status') == 'Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->format('Y-m-d'))->where('status', '=', 0);
                }else if(request('status') == 'Before Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->addDays(6)->format('Y-m-d'))->where('status', '=', 0);
                }else if(request('status') == 'Oldest'){
                    $query->where('status', '=', 1);
                }else if(request('status') == 'New'){
                    $query->where('valid_until', '>', Carbon::now()->format('Y-m-d'))->where('status', '=', 0);
                }
            })->get();

            $fsic_trans = FsicTransaction::query()->when(request('status'), function($query){
                if(request('status') == 'Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->format('Y-m-d'))->where('status', '=', 0);
                }else if(request('status') == 'Before Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->addDays(6)->format('Y-m-d'))->where('status', '=', 0);
                }else if(request('status') == 'Oldest'){
                    $query->where('status', '=', 1);
                }else if(request('status') == 'New'){
                    $query->where('valid_until', '>', Carbon::now()->format('Y-m-d'))->where('status', '=', 0);
                }
            })->get();

            return view('mapping.index', compact('fsic_trans','fsec_trans'));

        }elseif(request('location')){
            $searchString = request('location');
            $fsec_trans = FsecTransaction::whereHas('fsec', function ($query) use ($searchString){
                $query->where('address', $searchString);
            })
            ->with(['fsec' => function($query) use ($searchString){
                $query->where('address', $searchString);
            }])->get();

            $fsic_trans = FsicTransaction::whereHas('fsic', function ($query) use ($searchString){
                $query->where('address', $searchString);
            })
            ->with(['fsic' => function($query) use ($searchString){
                $query->where('address', $searchString);
            }])->get();

            return view('mapping.index', compact('fsic_trans','fsec_trans'));
        }else{
            $fsec_trans = FsecTransaction::with('fsec')->get();
            $fsic_trans = FsicTransaction::with('fsic')->get();
            return view('mapping.index', compact('fsic_trans','fsec_trans'));
        }
    }
}
