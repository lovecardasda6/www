<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns:livewire="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- tailwindcss -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- flowbitecss -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet"/>


    <livewire:styles/>
</head>
<body class="bg-slate-300">
<div class="bg-white p-3 shadow  flex justify-between font-sans text-sm">
    <div>
        dasd
    </div>
    <ul>
        <li class="inline-block"><a class="font-semibold text-slate-700" href="department">Department</a></li> &nbsp;
        <li class="inline-block"><a class="font-semibold text-slate-700" href="employee">Employee</a></li> &nbsp;
        <li class="inline-block"><a class="font-semibold text-slate-700" href="payroll">Payroll</a></li> &nbsp;
    </ul>
</div>
@yield("sidebar")
<div class=" p-3">
    @yield('content')
</div>
<livewire:scripts/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

</body>
</html>
