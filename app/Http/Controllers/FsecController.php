<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsec;
use App\Models\FsecTransaction;
use Carbon\Carbon;

class FsecController extends Controller
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
            }])->orderBy('created_at', 'desc')->paginate(5);

            if($fsec_trans->isEmpty()){
                $fsec_trans = FsecTransaction::query()->when(request('search'), function($query){
                    $search = request('search');
                    $query->where('or_no', '=', $search);
                })->latest('id')->paginate(5);
            }
            return view('fsec.index', compact('fsec_trans'));
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
            })->latest('id')->paginate(5);
            return view('fsec.index', compact('fsec_trans'));
        }else{
            $fsec_trans = FsecTransaction::with('fsec')->latest('id')->paginate(5);
            return view('fsec.index', compact('fsec_trans'));
        }
    }

    public function create()
    {
        $fsecs = Fsec::get();
        return view('fsec.create', compact('fsecs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fsec_no' => 'required|unique:fsecs|numeric',
            'project' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'address' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|numeric',
            'or_no' => 'required|unique:fsec_transactions|numeric',
        ]);
        $fsec = Fsec::where('fsec_no',$request->fsec_no)->first();
        if(!$fsec){
            $fsecs = Fsec::create([
                'fsec_no' => $request->fsec_no,
                'establishment' => $request->project,
                'owner' => $request->owner,
                'contact' => $request->contact,
                'address' => $request->address,
                'latitude' => $request->lat,
                'longitude' => $request->lng,
            ]);
            $fsecs->fsec_transaction()->create([
                'valid_for' => $request->valid_from,
                'valid_until' => $request->valid_to,
                'amount' => $request->amount,
                'ops_no' => $request->ops_no,
                'or_no' => $request->or_no,
            ]);
            return redirect()->back()->with('message','Successfully Saved!');
        }
        return redirect()->back()->with('error','Data already exist!');
    }

    public function show($id)
    {
        $fsec_trans = FsecTransaction::with('fsec')->findOrFail($id);
        return view('fsec.show', compact('fsec_trans'));
    }

    public function edit($id)
    {
        $fsec_trans = FsecTransaction::with('fsec')->findOrFail($id);
        return view('fsec.edit', compact('fsec_trans'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fsec_no' => 'required|numeric',
            'project' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'address' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|numeric',
            'or_no' => 'required|numeric',
        ]);
        $fsec_trans = FsecTransaction::findOrFail($id);
        if($fsec_trans){
            $fsec_trans->valid_for = $request->valid_from;
            $fsec_trans->valid_until = $request->valid_to;
            $fsec_trans->amount = $request->amount;
            $fsec_trans->ops_no = $request->ops_no;
            $fsec_trans->or_no = $request->or_no;
            $fsec_trans->update();
            $fsec_trans->fsec()->update([
                'fsec_no' => $request->fsec_no,
                'establishment' => $request->project,
                'owner' => $request->owner,
                'contact' => $request->contact,
                'address' => $request->address,
                'latitude' => $request->lat,
                'longitude' => $request->lng,
            ]);
            return redirect()->back()->with('message','Successfully Updated!');
        }
        return redirect()->back()->with('error','Transaction not found!');
    }

    public function renewalShow()
    {
        $fsec_no = request('fsec_no');
        $fsecs = Fsec::where('fsec_no',$fsec_no)->first();
        return view('fsec.renewal', compact('fsecs'));
    }

    public function renew(Request $request)
    {
        $validated = $request->validate([
            'fsec_no' => 'required|numeric',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|numeric',
            'or_no' => 'required|numeric|unique:fsec_transactions',
        ]);
        $fsec = Fsec::where('fsec_no',$request->fsec_no)->first();
        if($fsec){
            $fsecs = $fsec->fsec_transaction()->latest('created_at')->first();
            if($fsecs){
                $fsecs->status = 1;
                $fsecs->update();
            }
            $fsec->fsec_transaction()->create([
                'valid_for' => $request->valid_from,
                'valid_until' => $request->valid_to,
                'amount' => $request->amount,
                'ops_no' => $request->ops_no,
                'or_no' => $request->or_no,
            ]);
            return redirect()->back()->with('message','Successfully Renew!');
        }
        return redirect()->back()->with('error','No data found for this FSEC Number!');
    }
}
