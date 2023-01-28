@extends('index')


@section('sidebar')
    <div class="bg-white p-3 shadow  font-sans text-sm">
        <ul>
            <li class="inline-block"><a class="font-semibold text-slate-700" href="earning">Earning</a></li> &nbsp;
            <li class="inline-block"><a class="font-semibold text-slate-700" href="deduction">Deduction</a></li> &nbsp;
            <li class="inline-block"><a class="font-semibold text-slate-700" href="loan">Loan</a></li> &nbsp;
        </ul>
    </div>
@endsection

@section('content')

    <livewire:earning-component/>
@endsection
