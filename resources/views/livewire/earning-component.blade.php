<div>


    <!-- Main modal -->
    @if($toggleModal)
        <div id="defaultModal" tabindex="-1"
             class=" bg-gray-700/50 fixed justify-center top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full block items-center flex"
             aria-modal="true" role="dialog">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Earning
                        </h3>
                        <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                wire:click="toggleModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        @if($employeeId)
                            <form @if(!$earningId) wire:submit.prevent="store"
                                  @else wire:submit.prevent="update" @endif>
                                @if($earningId)
                                    <input type="hidden" name="earning_id" wire:model.lazy="earningId"
                                           value="{{$earningId}}">
                                @endif
                                <div class="my-3">
                                    <select class="p-2 rounded w-full border-slate-300"
                                            wire:model.lazy="earningTypeId" required>
                                        <option>Select earning type</option>
                                        @foreach($earningTypes as $earningType)
                                            <option
                                                value="{{$earningType->id}}">{{strtoupper($earningType->earning_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="my-3">
                                    <input type="number" class="p-2 rounded w-full border-slate-300"
                                           step="0.01" ;
                                           placeholder="Earning amount"
                                           required value="{{$earningAmount}}"
                                           wire:model.lazy="earningAmount">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-800 text-white p-2 rounded px-4">
                                        @if(!$earningId)
                                            Add
                                        @else
                                            Update
                                        @endif
                                    </button>
                                    &nbsp;
                                    <button type="button" wire:click="toggleModal"
                                            class="bg-red-800 text-white p-2 rounded px-4">Cancel
                                    </button>
                                </div>
                            </form>
                        @else
                            <div
                                class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <span class="font-medium font-bold">Error!</span> Please seleect employee first before
                                clicking add.
                            </div>
                            <div class="flex justify-end">
                                <button type="button" wire:click="toggleModal"
                                        class="bg-red-800 text-white p-2 rounded px-4">Close
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="flex">
        <div class="w-2/5 p-1">
            <div class="w-full">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Department
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $key => $department)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-white font-bold hover:bg-gray-700">
                                <td class="px-6 py-4 cursor-pointer" wire:click="employees({{$department->id}})">
                                    {{$department->department}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-2">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-40">
                                ID#
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Employee
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($employees)
                            @foreach($employees as $key => $employee)
                                <tr wire:click="getEmployeeEarningInfo({{$employee}})"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 cursor-pointer hover:text-white font-bold hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        {{$employee->employee_id}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$employee->lastname}}, {{$employee->firstname}}  {{$employee->middlename}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="w-3/5 m-1">
            <!-- Modal toggle -->
            <div class=" p-3 shadow rounded-lg bg-white">
                <div class="flex justify-between">
                    <label for="earning" class="font-bold">
                        Earning - ({{$employeeId}}) {{strtoupper($employeeName)}}
                    </label>

                    <button wire:click="add"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                        Add Earnings
                    </button>
                </div>
            </div>
            <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg  my-3">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Earning
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($employeeEarnings)
                        @foreach($employeeEarnings as $key => $earning)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    {{++$key}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$earning->earning_type->earning_name}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$earning->amount}}
                                </td>
                                <td class="px-6 py-4">
                                    <button class="bg-blue-700 text-white p-3 rounded" wire:click="edit({{$earning}})">
                                        Edit
                                    </button>
                                    <button class="bg-red-700 text-white p-3 rounded"
                                            wire:click="remove({{$earning->id}})">Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
