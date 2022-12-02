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
        $this->dispatchBrowserEvent('swal:confirm', [
            'id' => $this->fsic_tran->id,
            'title' => 'Are you sure?',
            'text' => "You won't be able to revert this!"
        ]);
    }

    public function delete($id)
    {
        FsicTransaction::where('status', true)->where('id',$id)->delete();
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.fsic-delete');
    }
}
