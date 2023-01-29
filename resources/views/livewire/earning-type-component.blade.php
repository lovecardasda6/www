<div>
    @if(session()->has("store-success"))
        <div class="bg-green-600 p-3 rounded">
            <label class="font-bold text-white">Success!</label> &nbsp;<label class="text-white">Earning type
                successfully added.</label>
        </div>
    @endif

    @if(session()->has("store-failed"))
        <div class="bg-red-600 p-3 rounded">
            <label class="font-bold text-white">Failed!</label> &nbsp;<label class="text-white">Earning type failed to
                add.</label>
        </div>
    @endif

    @if(session()->has("update-success"))
        <div class="bg-green-600 p-3 rounded">
            <label class="font-bold text-white">Success!</label> &nbsp;<label class="text-white">Earning type
                successfully updated.
                <updated></updated>
                .</label>
        </div>
    @endif

    @if(session()->has("update-failed"))
        <div class="bg-red-600 p-3 rounded">
            <label class="font-bold text-white">Failed!</label> &nbsp;<label class="text-white">Earning type failed to
                update.</label>
        </div>
    @endif


    @if($isAdd)
        <div class="bg-white p-3 rounded my-2">
            <div class="flex justify-between border-solid border-slate-800 p-2 rounded ">
                <h1 class="font-semibold text-lg">Add Earning</h1>
                <button class="bg-red-700 text-white p-2 text-sm rounded px-4" wire:click="addEarningToggle"> Cancel</button>
            </div>
            <div class="p-3">
                <form wire:submit.prevent="store">
                    <div class="my-3">
                        <input type="text" class="p-2 rounded w-full" placeholder="Enter department name" required
                               wire:model.lazy="earningName">
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-blue-800 text-white p-2 rounded px-4">Add</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($isEdit)
        <div class="bg-white p-3 rounded my-2">
            <div class="flex justify-between border-solid border-slate-800 p-2 rounded ">
                <h1 class="font-semibold text-lg">Edit Earning</h1>
                <button class="bg-red-700 text-white p-2 text-sm rounded px-4" wire:click="editEarningToggle"> Cancel</button>
            </div>
            <div class="p-3">
                <form wire:submit.prevent="update">
                    <input type="hidden" name="departmentId" wire:model.lazy="earningId" value="{{$earningId}}">
                    <div class="my-3">
                        <input type="text" class="p-2 rounded w-full" placeholder="Enter department name" required
                               value="{{$earningName}}"
                               wire:model.lazy="earningName">
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-blue-800 text-white p-2 rounded  px-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="bg-white p-3 rounded my-2">
        <div class="flex justify-between border-solid border-slate-800 p-2 rounded ">
            <h1 class="font-semibold text-lg">Earning List</h1>
            <button class="bg-blue-700 text-white p-2 px-3 rounded" wire:click="addEarningToggle">Add Earning</button>
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
                            Earning Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($earnings as $key => $earning)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{++$key}}
                            </td>
                            <td class="px-6 py-4">
                                {{$earning->earning_name}}
                            </td>
                            <td class="px-6 py-4">
                                <button class="bg-blue-700 text-white p-3 rounded" wire:click="edit({{$earning}})">
                                    Edit
                                </button>
                                <button class="bg-red-700 text-white p-3 rounded" wire:click="remove({{$earning->id}})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>

</div>


