<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsic;
use App\Models\FsicTransaction;
use Carbon\Carbon;
class FsicController extends Controller
{
    public function index()
    {
        if(request('search')){
            $searchString = request('search');
            
            $fsic_trans = FsicTransaction::whereHas('fsic', function ($query) use ($searchString){
                $query->where('fsic_no', $searchString)
                ->orWhere('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            })
            ->with(['fsic' => function($query) use ($searchString){
                $query->where('fsic_no', $searchString)
                ->orWhere('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            }])->orderBy('created_at', 'desc')->paginate(5);

            if($fsic_trans->isEmpty()){
                $fsic_trans = FsicTransaction::query()->when(request('search'), function($query){
                    if(request('search') == 'Expired' || request('search') == 'expired'){
                        $search = array(Carbon::now()->format('Y-m-d'), 0); 
                    }else if(request('search') == 'Oldest' || request('search') == 'oldest'){
                        $search = array(Carbon::now()->format('Y-m-d'), 1); 
                    }else{
                        $search = request('search');
                    }
                    if(request('search') == 'Expired' || request('search') == 'expired' || request('search') == 'Oldest' || request('search') == 'oldest'){
                        $query->where('valid_until', '<', $search[0])
                        ->where('status', '=', $search[1]);
                    }else{
                        $query->where('or_no', '=', $search);
                    }
    
                })->orderBy('created_at', 'desc')->paginate(5);
            }
            return view('fsic.index', compact('fsic_trans'));
        }else{
            $fsic_trans = FsicTransaction::with('fsic')->orderBy('created_at', 'desc')->paginate(5);
            return view('fsic.index', compact('fsic_trans'));
        }
    }

    public function create()
    {
        $fsics = Fsic::get();
        return view('fsic.create', compact('fsics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fsic_no' => 'required|unique:fsics|numeric',
            'establishment' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'business_types' => 'required|string|max:255',
            'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'address' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|numeric',
            'or_no' => 'required|unique:fsic_transactions|numeric',
        ]);
        $fsic = Fsic::where('fsic_no',$request->fsic_no)->first();
        if(!$fsic){
            $fsics = Fsic::create([
                'fsic_no' => $request->fsic_no,
                'establishment' => $request->establishment,
                'owner' => $request->owner,
                'business_type' => $request->business_types,
                'contact' => $request->contact,
                'address' => $request->address,
                'latitude' => $request->lat,
                'longitude' => $request->lng,
            ]);
            $fsics->fsic_transaction()->create([
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
        $fsic_trans = FsicTransaction::with('fsic')->findOrFail($id);
        return view('fsic.show', compact('fsic_trans'));
    }

    public function edit($id)
    {
        $fsic_trans = FsicTransaction::with('fsic')->findOrFail($id);
        return view('fsic.edit', compact('fsic_trans'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fsic_no' => 'required|numeric',
            'establishment' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'business_types' => 'required|string|max:255',
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
        $fsic_trans = FsicTransaction::findOrFail($id);
        if($fsic_trans){
            $fsic_trans->valid_for = $request->valid_from;
            $fsic_trans->valid_until = $request->valid_to;
            $fsic_trans->amount = $request->amount;
            $fsic_trans->ops_no = $request->ops_no;
            $fsic_trans->or_no = $request->or_no;
            $fsic_trans->update();
            $fsic_trans->fsic()->update([
                'fsic_no' => $request->fsic_no,
                'establishment' => $request->establishment,
                'owner' => $request->owner,
                'business_type' => $request->business_types,
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
        $fsic_no = request('fsic_no');
        $fsics = Fsic::where('fsic_no',$fsic_no)->first();
        return view('fsic.renewal', compact('fsics'));
    }

    public function renew(Request $request)
    {
        $validated = $request->validate([
            'fsic_no' => 'required|numeric',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|numeric',
            'or_no' => 'required|numeric|unique:fsic_transactions',
        ]);
        $fsic = Fsic::where('fsic_no',$request->fsic_no)->first();
        if($fsic){
            $fsics = $fsic->fsic_transaction()->latest('created_at')->first();
            if($fsics){
                $fsics->status = 1;
                $fsics->update();
            }
            $fsic->fsic_transaction()->create([
                'valid_for' => $request->valid_from,
                'valid_until' => $request->valid_to,
                'amount' => $request->amount,
                'ops_no' => $request->ops_no,
                'or_no' => $request->or_no,
            ]);
            return redirect()->back()->with('message','Successfully Renew!');
        }
        return redirect()->back()->with('error','No data found for this FSIC Number!');
    }
}
