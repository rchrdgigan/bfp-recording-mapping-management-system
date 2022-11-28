<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsic;
use App\Models\FsicTransaction;

class FsicController extends Controller
{
    public function index()
    {
        $fsic_trans = FsicTransaction::with('fsic')->get();

        return view('fsic.index', compact('fsic_trans'));
    }

    public function create()
    {
        $fsics = Fsic::get();
        return view('fsic.create', compact('fsics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fsic_no' => 'required|unique:fsics',
            'establishment' => 'required',
            'owner' => 'required',
            'business_types' => 'required',
            'contact' => 'required | regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'amount' => 'required',
            'ops_no' => 'required',
            'or_no' => 'required',
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
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
