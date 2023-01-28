<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Earning;
use App\Models\Employee;
use Livewire\Component;

class PayrollComponent extends Component
{
    public $toggleModal = false;

    public $employees;

    public $empId, $employeeName, $employeeId;

    public $earningId, $earningName, $earningAmount;

    public $employeeEarnings;

    public function employees($deparmentId)
    {
        $this->employees = Employee::where("department_id", $deparmentId)->get();
    }

    public function getEmployeeEarningInfo($employee)
    {
        $this->empId = $employee['id'];
        $this->employeeId = $employee['employee_id'];
        $this->employeeName = "{$employee['lastname']}, {$employee['firstname']} {$employee['middlename']}";
        $this->employeeEarnings();

    }

    public function add()
    {
        $this->toggleModal();
        $this->earningId = "";
        $this->earningName = "";
        $this->earningAmount = "";
    }

    public function store()
    {
        $earning = new Earning();
        $earning->employee_id = $this->empId;
        $earning->earning_name = $this->earningName;
        $earning->amount = $this->earningAmount;
        $earning->save();
        $this->resetInput();
    }

    public function edit($earning)
    {

        $this->toggleModal();
        $this->earningId = $earning['id'];
        $this->earningName = $earning['earning_name'];
        $this->earningAmount = $earning['amount'];
    }

    public function update(){
        $earning = Earning::findOrFail($this->earningId);
        $earning->earning_name = $this->earningName;
        $earning->amount = $this->earningAmount;
        $earning->save();
        $this->resetInput();
    }


    public function remove($earningId){
        $earning = Earning::findOrFail($earningId);
        $earning->delete();
    }

    public function toggleModal()
    {
        $this->toggleModal = !$this->toggleModal;
    }

    public function employeeEarnings()
    {
        $this->employeeEarnings = Earning::where("employee_id", $this->empId)->orderBy("earning_name")->get();
    }

    public function resetInput()
    {
        $this->earningId = "";
        $this->earningName = "";
        $this->earningAmount = "";
        $this->toggleModal();
    }

    public function render()
    {
        $departments = Department::orderBy("department")->get();
        $this->employeeEarnings();
        return view('livewire.payroll-component', [
            'departments' => $departments,
        ]);
    }
}
