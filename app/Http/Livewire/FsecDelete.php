<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FsecTransaction;

class FsecDelete extends Component
{
    protected $listeners = ['delete'];

    public $fsec_tran;

    public function deleteConfirm()
    {
        $fsec_trans = FsecTransaction::where('status', true)->where('id',$this->fsec_tran->id)->first();
        if($fsec_trans){
            $this->dispatchBrowserEvent('swal:confirm', [
                'id' => $this->fsec_tran->id,
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
        FsecTransaction::where('status', true)->where('id',$id)->delete();
        return redirect()->route('fsec.index');
    }

    public function render()
    {
        return view('livewire.fsec-delete');
    }
}
