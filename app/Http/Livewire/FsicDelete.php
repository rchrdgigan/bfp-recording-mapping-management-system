<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FsicTransaction;

class FsicDelete extends Component
{
    protected $listeners = ['delete'];

    public $fsic_tran;

    public function deleteConfirm()
    {
        $fsic_trans = FsicTransaction::where('status', true)->where('id',$this->fsic_tran->id)->first();
        if($fsic_trans){
            $this->dispatchBrowserEvent('swal:confirm', [
                'id' => $this->fsic_tran->id,
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
        FsicTransaction::where('status', true)->where('id',$id)->delete();
        return redirect()->route('fsic.index');
    }

    public function render()
    {
        return view('livewire.fsic-delete');
    }
}
