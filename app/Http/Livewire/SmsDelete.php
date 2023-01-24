<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sms;

class SmsDelete extends Component
{
    protected $listeners = ['delete'];

    public $sms_del;

    public function deleteConfirm()
    {
        $sms_dels = Sms::findOrFail($this->sms_del->id);
        if($sms_dels){
            $this->dispatchBrowserEvent('swal:confirm', [
                'id' => $this->sms_del->id,
                'title' => 'Are you sure?',
                'text' => "You won't be able to revert this!",
                'showCancelButton' => true,
                'confirmButtonText' => 'Yes, Delete it!',
                'denyButtonText' => 'Cancel',
            ]);
        }else{
            $this->dispatchBrowserEvent('swal:confirm', [
                'title' => 'This status is new!',
                'text' => "You won't be able to delete this!",
                'showCancelButton' => false,
                'confirmButtonText' => 'Ok',
            ]);
        }
       
    }

    public function delete($id)
    {
        Sms::where('id',$id)->delete();
        return redirect()->route('sms.index');
    }

    public function render()
    {
        return view('livewire.sms-delete');
    }
}
