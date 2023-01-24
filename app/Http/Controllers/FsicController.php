<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsic;
use App\Models\FsicTransaction;
use Carbon\Carbon;
use Vonage;
class FsicController extends Controller
{
    public function index()
    {
        if(request('search')){
            $searchString = request('search');
            
            $fsic_trans = FsicTransaction::whereHas('fsic', function ($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            })
            ->with(['fsic' => function($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            }])->where('status', '=', 0)->latest('id')->paginate(5);

            if($fsic_trans->isEmpty()){
                $fsic_trans = FsicTransaction::query()->when(request('search'), function($query){
                    $search = request('search');
                    $query->where('or_no', '=', $search)
                    ->orWhere('fsic_no', $search);
                })->where('status', '=', 0)->latest('id')->paginate(5);
            }
            return view('fsic.index', compact('fsic_trans'));
        }elseif(request('status')){
            $fsic_trans = FsicTransaction::query()->when(request('status'), function($query){
                if(request('status') == 'Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->format('Y-m-d'));
                }else if(request('status') == 'Before Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->addDays(5)->format('Y-m-d'));
                }else if(request('status') == 'New'){
                    $query->where('valid_until', '>', Carbon::now()->format('Y-m-d'));
                }
            })->where('status', '=', 0)->latest('id')->paginate(5);
            return view('fsic.index', compact('fsic_trans'));
        }else{
            $fsic_trans = FsicTransaction::with('fsic')->where('status', '=', 0)->latest('id')->paginate(5);
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
            // 'fsic_no' => 'required|unique:fsic_transactions|numeric',
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
            'ops_no' => 'required|unique:fsic_transactions|numeric',
            'or_no' => 'required|unique:fsic_transactions|numeric',
        ]);
        $fsics = Fsic::create([
            'establishment' => $request->establishment,
            'owner' => $request->owner,
            'business_type' => $request->business_types,
            'contact' => $request->contact,
            'address' => $request->address,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
        ]);
        $fsics->fsic_transaction()->create([
            // 'fsic_no' => $request->fsic_no,
            'valid_for' => $request->valid_from,
            'valid_until' => $request->valid_to,
            'amount' => $request->amount,
            'ops_no' => $request->ops_no,
            'or_no' => $request->or_no,
        ]);
        return redirect()->back()->with('message','Successfully Saved!');
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
            $fsic_trans->fsic_no = $request->fsic_no;
            $fsic_trans->valid_for = $request->valid_from;
            $fsic_trans->valid_until = $request->valid_to;
            $fsic_trans->amount = $request->amount;
            $fsic_trans->ops_no = $request->ops_no;
            $fsic_trans->or_no = $request->or_no;
            $fsic_trans->update();
            $fsic_trans->fsic()->update([
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

    public function renewalShow($id)
    {
        $fsics = Fsic::findOrFail($id);
        return view('fsic.renewal', compact('fsics'));
    }

    public function renew(Request $request)
    {
        $validated = $request->validate([
            // 'fsic_no' => 'required|unique:fsic_transactions|numeric',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|numeric',
            'or_no' => 'required|numeric|unique:fsic_transactions',
        ]);
        $fsic = Fsic::findOrFail($request->fsic_id);
        if($fsic){
            $fsics = $fsic->fsic_transaction()->latest('created_at')->first();
            if($fsics){
                $fsics->status = 1;
                $fsics->update();
            }
            $fsic->fsic_transaction()->create([
                // 'fsic_no' => $request->fsic_no,
                'valid_for' => $request->valid_from,
                'valid_until' => $request->valid_to,
                'amount' => $request->amount,
                'ops_no' => $request->ops_no,
                'or_no' => $request->or_no,
            ]);
            return redirect()->back()->with('message','Successfully Renew!');
        }
        return redirect()->back()->with('error','No data found for this FSIC!');
    }

    public function history()
    {
        if(request('search')){
            $searchString = request('search');
            
            $fsic_trans = FsicTransaction::whereHas('fsic', function ($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            })
            ->with(['fsic' => function($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            }])->where('status', '=', 1)->latest('id')->paginate(5);

            if($fsic_trans->isEmpty()){
                $fsic_trans = FsicTransaction::query()->when(request('search'), function($query){
                    $search = request('search');
                    $query->where('or_no', '=', $search)
                    ->orWhere('fsic_no', $search);
                })->where('status', '=', 1)->latest('id')->paginate(5);
            }
            return view('fsic.history', compact('fsic_trans'));
        }else{
            $fsic_trans = FsicTransaction::with('fsic')->where('status', '=', 1)->latest('id')->paginate(5);
            return view('fsic.history', compact('fsic_trans'));
        }
    }

    public function notify()
    {
        $fsic_trans = FsicTransaction::with('fsic')->where('valid_until', '<=', Carbon::now()->addDays(5)->format('Y-m-d'))->where('status', '=', 0)->latest('id')->get();
        if(!$fsic_trans->isEmpty())
        {
            foreach($fsic_trans as $data){
                if($data->valid_until >= Carbon::now()->addDays(6)->format('Y-m-d')){
                }else{
                    if($data->remaining_days <= 5 && $data->status == 0){
                        if($data->remaining_days <= 5 && $data->remaining_days >= 2){
                            $status = $data->remaining_days . 'days nalang ang natitira bago ang duedate.'; //5 to 2 days left
                        }elseif($data->remaining_days == 1){
                            $status = $data->remaining_days . 'day nalang ang natitira bago ang duedate.'; // 1 day left
                        }elseif($data->remaining_days >= 0){ //due date
                            $status = 'due date ngayon.';
                        }else{ //expired
                            $status = 'expired na.';
                        }
                    }
                }
                
                $send = Vonage::message()->send([
                    'to'   => '63'.ltrim($data->fsic->contact, '0'),
                    'from' => 'BFP Irosin',
                    'text' => 'Ang iyong Fire Safety Inspection Certificate ay '.$status.' Pumunta sa Fire Station ng Irosin at mag renew ng iyong FSIC. Salamat!'
                ]);
            }
            return redirect()->back()->with('message','Successfully Notified!');
        }else{
            return redirect()->back()->with('error','No data found to be notify for this FSIC!');
        }
    }
}
