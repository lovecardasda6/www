<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentComponent extends Component
{

    public $departmentId, $departmentName;


    public function add()
    {
        $department = new Department();
        $department->department = strtoupper(trim($this->departmentName));
        if ($department->save()) {
            $this->resetInput();
            return session()->flash(
                "success",
                '<label class="font-bold text-white">Success!</label> &nbsp;<label class="text-white">Department successfully save.</label>'
            );
        }
        session()->flash(
            "failed",
            '<label class="font-bold text-white">Failed!</label> &nbsp;<label class="text-white">Department failed to save.</label>'
        );
    }

    public function edit($department)
    {
        $this->departmentId = $department['id'];
        $this->departmentName = $department['department'];
    }

    public function update(){

        $department = Department::findOrFail($this->departmentId);
        $department->department = $this->departmentName;
        $department->save();
        $this->resetInput();

    }

    public function resetInput()
    {
        $this->departmentName = "";
    }

    public function render()
    {

        $departments = Department::orderBy("department")->get();
        return view('livewire.department-component', ['departments' => $departments]);
    }
}
