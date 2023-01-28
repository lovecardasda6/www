<div>
    @if(session()->has("success"))
        <div class="bg-green-600 p-3 rounded">
            {!! session("success") !!}
        </div>
    @endif

    @if(session()->has("failed"))
        <div class="bg-red-600 p-3 rounded">
            {!! session("failed") !!}
        </div>
    @endif

    <div class="bg-white p-3 rounded my-2">
        <div class="flex justify-between border-solid border-slate-800 p-2 rounded ">
            <h1 class="font-semibold text-lg">Add Employee</h1>
            <button class="bg-red-500 text-white p-2 text-sm rounded">Cancel</button>
        </div>
        <div class="p-3">
            <form wire:submit.prevent="add">
                <div class="my-3">
                    <label>Status</label> &nbsp;
                    <input type="checkbox" class="p-2 rounded" wire:model.lazy="status" value="1" checked>
                </div>
                <div class="my-3">
                    <label for="Employee ID" class="text-sm text-slate-600 ">Employee ID</label>
                    <input type="text" class="p-2 rounded w-full" placeholder="Employee ID" required
                           wire:model.lazy="employeeId">
                </div>
                <div class="my-3">
                    <label for="Lastname" class="text-sm text-slate-600 ">Lastname</label>
                    <input type="text" class="p-2 rounded w-full" placeholder="Lastname" required
                           wire:model.lazy="lastname">
                </div>
                <div class="my-3">
                    <label for="Firstname" class="text-sm text-slate-600 ">Firstname</label>
                    <input type="text" class="p-2 rounded w-full" placeholder="Firstname" required
                           wire:model.lazy="firstname">
                </div>
                <div class="my-3">
                    <label for="Middlename" class="text-sm text-slate-600 ">Middlename</label>
                    <input type="text" class="p-2 rounded w-full" placeholder="Middlename"
                           wire:model.lazy="middlename">
                </div>
                <div class="my-3">
                    <label for="Department" class="text-sm text-slate-600 ">Department</label>
                    <select type="text" class="p-2 rounded w-full" placeholder="Enter department name" required
                            wire:model.lazy="departmentId">
                        <option value="0">Please select department</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->department}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button class="bg-blue-800 text-white p-2 rounded px-4"">Add Employee</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white p-3 rounded my-2">
        <div class="flex justify-between border-solid border-slate-800 p-2 rounded ">
            <h1 class="font-semibold text-lg">Department List</h1>
        </div>
        <div class="p-3">

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Employee ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $key => $employee)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{++$key}}
                            </td>
                            <td class="px-6 py-4">
                                {{$employee->employee_id}}
                            </td>
                            <td class="px-6 py-4">
                                {{$employee->lastname}}, &nbsp; {{$employee->firstname}} &nbsp; {{$employee->middlename}}
                            </td>
                            <td class="px-6 py-4">
                                {{$employee->department->department}}
                            </td>
                            <td class="px-6 py-4">
                                <button class="bg-green-700 text-white p-3 rounded">View
                                </button>
                                <button class="bg-blue-700 text-white p-3 rounded">Edit</button>
                                <button class="bg-red-700 text-white p-3 rounded">Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>

</div>


