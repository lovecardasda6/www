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
            <h1 class="font-semibold text-lg">Add Department</h1>
            <button class="bg-red-700 text-white p-2 text-sm rounded px-4"> Cancel</button>
        </div>
        <div class="p-3">
            <form wire:submit.prevent="add">
                <div class="my-3">
                    <input type="text" class="p-2 rounded w-full" placeholder="Enter department name" required
                           wire:model.lazy="departmentName">
                </div>
                <div class="flex justify-end">
                    <button class="bg-blue-800 text-white p-2 rounded px-4">Add</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white p-3 rounded my-2">
        <div class="flex justify-between border-solid border-slate-800 p-2 rounded ">
            <h1 class="font-semibold text-lg">Edit Department</h1>
            <button class="bg-red-700 text-white p-2 text-sm rounded px-4"> Cancel</button>
        </div>
        <div class="p-3">
            <form wire:submit.prevent="update">
                <input type="hidden" name="departmentId" wire:model.lazy="departmentId" value="{{$departmentId}}">
                <div class="my-3">
                    <input type="text" class="p-2 rounded w-full" placeholder="Enter department name" required value="{{$departmentName}}"
                           wire:model.lazy="departmentName">
                </div>
                <div class="flex justify-end">
                    <button class="bg-blue-800 text-white p-2 rounded  px-4">Update</button>
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
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $key => $department)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{++$key}}
                            </td>
                            <td class="px-6 py-4">
                                {{$department->department}}
                            </td>
                            <td class="px-6 py-4">
                                <button class="bg-green-700 text-white p-3 rounded">View</button>
                                <button class="bg-blue-700 text-white p-3 rounded" wire:click="edit({{$department}})">Edit</button>
                                <button class="bg-red-700 text-white p-3 rounded">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>

</div>


