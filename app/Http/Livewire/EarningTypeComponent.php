<?php

namespace App\Http\Livewire;

use App\Models\EarningType;
use Livewire\Component;

class EarningTypeComponent extends Component
{
    public $isAdd = false, $isEdit = false;

    public $earningId, $earningName;

    public $earnings;


    public function store()
    {
        $earning = new EarningType();
        $earning->earning_name = $this->earningName;
        $earning->save() ? session()->flash("store-success") : session()->flash("store-failed");
        $this->resetInput();
    }

    public function edit($earning)
    {
        $this->earningId = $earning['id'];
        $this->earningName = $earning['earning_name'];
        $this->editEarningToggle();
    }

    public function update()
    {
        $earning = EarningType::findOrFail($this->earningId);
        $earning->earning_name = $this->earningName;
        $earning->save() ? session()->flash("update-success") : session()->flash("update-failed");
        $this->editEarningToggle();
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->earningId = "";
        $this->earningName = "";
    }

    public function addEarningToggle()
    {
        $this->isAdd = !$this->isAdd;
        if ($this->isEdit)
            $this->isEdit = false;
    }

    public function editEarningToggle()
    {
        $this->isEdit = !$this->isEdit;
        if ($this->isAdd)
            $this->isAdd = false;
    }

    public function remove($earningId)
    {
        $earning = EarningType::findOrFail($earningId)->delete();
    }

    public function render()
    {
        $this->earnings = EarningType::orderBy("earning_name")->get();

        return view('livewire.earning-type-component');
    }
}
