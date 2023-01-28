<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;

class EmployeeComponent extends Component
{

    public $status = 1, $employeeId, $lastname, $firstname, $middlename, $departmentId;

    public function add()
    {
//        try {

//            if($this->departmentId == 0)
//                throw
            $employee = new Employee();
            $employee->is_active = $this->status;
            $employee->employee_id = $this->employeeId;
            $employee->lastname = $this->lastname;
            $employee->firstname = $this->firstname;
            $employee->middlename = $this->middlename;
            $employee->department_id = $this->departmentId;
            if ($employee->save()):
                $this->resetInput();
                return session()->flash(
                    "success",
                    '<label class="font-bold text-white">Success!</label> &nbsp;<label class="text-white">Employee successfully save.</label>');
            endif;

            session()->flash(
                "failed",
                '<label class="font-bold text-white">Failed!</label> &nbsp;<label class="text-white">Employee failed to save.</label>');
//        } catch (\Exception $e) {
//            session()->flash(
//                "failed",
//                '<label class="font-bold text-white">Failed!</label> &nbsp;<label class="text-white">'.$e->getMessage().'</label>');
//        }

    }

    public function resetInput()
    {
        $status = 1;
        $employeeId = "";
        $lastname = "";
        $firstname = "";
        $middlename = "";
        $departmentId = "";
    }

    public function render()
    {
        $departments = Department::orderBy("department")->get();
        $employees = Employee::with('department')->orderBy("lastname")->get();

//        dd($employees);
        return view('livewire.employee-component', [
            'departments' => $departments,
            'employees' => $employees
        ]);
    }
}
