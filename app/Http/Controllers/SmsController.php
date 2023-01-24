<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fsic;
use App\Models\Fsec;
use App\Models\Sms;
use Vonage;

class SmsController extends Controller
{
    public function index()
    {
        if(request('search')){
            $sms = Sms::query()->when(request('search'), function($query){
                $search = request('search');
                $query->where('owner', 'like', '%'.$search.'%')
                ->orWhere('message', 'like', '%'.$search.'%')
                ->orWhere('contact', 'like', '%'.$search.'%');
            })->latest('id')->paginate(5);
            return view('sms.index', compact('sms'));
        }else{
            $sms = Sms::latest('id')->paginate(5);
            return view('sms.index', compact('sms'));
        }
        
    }

    public function create()
    {
        $fsic = Fsic::get();
        $fsec = Fsec::get();
        return view('sms.create', compact('fsic','fsec'));
    }

    public function store(Request $request)
    {
        $validated = $request->all();
        $pcs = explode(" | ",$request->recipient);
        $sms = Sms::create([
            'owner' => $pcs[0],
            'contact' => $pcs[1],
            'status' => $pcs[2],
            'message'=> $request->message,
        ]);
        Vonage::message()->send([
            'to'   =>  '63'.ltrim($pcs[1], '0'),
            'from' => 'BFP Irosin',
            'text' => $request->message
        ]);
        if($sms){
            return redirect()->route('sms.index')->with('message', 'Successfully notified!');
        }else{
            return back()->with('message', 'Notification not send!');
        }
    }
    public function destroy(Request $request)
    {
        $del = SmsNotification::findOrFail($request->_id);
        if($del){
            $del->delete();
        }
        return back()->with('message','Sms has been deleted!');
    }
}
