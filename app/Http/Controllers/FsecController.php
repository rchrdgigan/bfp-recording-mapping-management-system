<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsec;
use App\Models\FsecTransaction;
use Carbon\Carbon;
use Vonage;

class FsecController extends Controller
{
    public function index()
    {
        if(request('search')){
            $searchString = request('search');
            
            $fsec_trans = FsecTransaction::whereHas('fsec', function ($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            })
            ->with(['fsec' => function($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            }])->where('status', '=', 0)->latest('id')->paginate(5);

            if($fsec_trans->isEmpty()){
                $fsec_trans = FsecTransaction::query()->when(request('search'), function($query){
                    $search = request('search');
                    $query->where('or_no', '=', $search)
                    ->orWhere('fsec_no', $search);
                })->where('status', '=', 0)->latest('id')->paginate(5);
            }
            return view('fsec.index', compact('fsec_trans'));
        }elseif(request('status')){
            $fsec_trans = FsecTransaction::query()->when(request('status'), function($query){
                if(request('status') == 'Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->format('Y-m-d'));
                }else if(request('status') == 'Before Expired'){
                    $query->where('valid_until', '<=', Carbon::now()->addDays(5)->format('Y-m-d'));
                }else if(request('status') == 'New'){
                    $query->where('valid_until', '>', Carbon::now()->format('Y-m-d'));
                }
            })->where('status', '=', 0)->latest('id')->paginate(5);
            return view('fsec.index', compact('fsec_trans'));
        }else{
            $fsec_trans = FsecTransaction::with('fsec')->where('status', '=', 0)->latest('id')->paginate(5);
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
            // 'fsec_no' => 'required|unique:fsec_transactions|numeric',
            'project' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'address' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|unique:fsec_transactions|numeric',
            'or_no' => 'required|unique:fsec_transactions|numeric',
        ]);
        $fsecs = Fsec::create([
            'establishment' => $request->project,
            'owner' => $request->owner,
            'contact' => $request->contact,
            'address' => $request->address,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
        ]);
        $fsecs->fsec_transaction()->create([
            // 'fsec_no' => $request->fsec_no,
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
            // 'fsec_no' => 'required|numeric',
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
            // $fsec_trans->fsec_no = $request->fsec_no;
            $fsec_trans->valid_for = $request->valid_from;
            $fsec_trans->valid_until = $request->valid_to;
            $fsec_trans->amount = $request->amount;
            $fsec_trans->ops_no = $request->ops_no;
            $fsec_trans->or_no = $request->or_no;
            $fsec_trans->update();
            $fsec_trans->fsec()->update([
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

    public function renewalShow($id)
    {
        $fsecs = Fsec::findOrFail($id);
        return view('fsec.renewal', compact('fsecs'));
    }

    public function renew(Request $request)
    {
        $validated = $request->validate([
            // 'fsec_no' => 'required|unique:fsec_transactions|numeric',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required|numeric',
            'ops_no' => 'required|numeric',
            'or_no' => 'required|numeric|unique:fsec_transactions',
        ]);
        $fsec = Fsec::findOrFail($request->fsec_id);
        if($fsec){
            $fsecs = $fsec->fsec_transaction()->latest('created_at')->first();
            if($fsecs){
                $fsecs->status = 1;
                $fsecs->update();
            }
            $fsec->fsec_transaction()->create([
                // 'fsec_no' => $request->fsec_no,
                'valid_for' => $request->valid_from,
                'valid_until' => $request->valid_to,
                'amount' => $request->amount,
                'ops_no' => $request->ops_no,
                'or_no' => $request->or_no,
            ]);
            return redirect()->back()->with('message','Successfully Renew!');
        }
        return redirect()->back()->with('error','No data found for this FSEC!');
    }

    public function history()
    {
        if(request('search')){
            $searchString = request('search');
            
            $fsec_trans = FsecTransaction::whereHas('fsec', function ($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            })
            ->with(['fsec' => function($query) use ($searchString){
                $query->where('establishment', 'like', '%'.$searchString.'%')
                ->orWhere('owner', 'like', '%'.$searchString.'%');
            }])->where('status', '=', 1)->latest('id')->paginate(5);

            if($fsec_trans->isEmpty()){
                $fsec_trans = FsecTransaction::query()->when(request('search'), function($query){
                    $search = request('search');
                    $query->where('or_no', '=', $search)
                    ->orWhere('fsec_no', $search);
                })->where('status', '=', 1)->latest('id')->paginate(5);
            }
            return view('fsec.history', compact('fsec_trans'));
        }else{
            $fsec_trans = FsecTransaction::with('fsec')->where('status', '=', 1)->latest('id')->paginate(5);
            return view('fsec.history', compact('fsec_trans'));
        }
    }

    public function notify()
    {
        $fsec_trans = FsecTransaction::with('fsec')->where('valid_until', '<=', Carbon::now()->addDays(5)->format('Y-m-d'))->where('status', '=', 0)->latest('id')->get();
        if(!$fsec_trans->isEmpty())
        {
            foreach($fsec_trans as $data){
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
                    'to'   => '63'.ltrim($data->fsec->contact, '0'),
                    'from' => 'BFP Irosin',
                    'text' => 'Ang iyong Fire Safety Evaluation Clearance ay '.$status.' Pumunta sa Fire Station ng Irosin at mag renew ng iyong FSEC. Salamat!'
                ]);
            }
            return redirect()->back()->with('message','Successfully Notified!');
        }else{
            return redirect()->back()->with('error','No data found to be notify for this FSEC!');
        }
    }
}
