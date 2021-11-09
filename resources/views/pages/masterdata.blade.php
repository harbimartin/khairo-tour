@extends('index')

@section('content')
    <ul class="list-reset flex border-b px-2 mt-2">
        <li class="mr-1">
            <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'period' ? 'bg-blue-400 text-white':''}}"
                href="/masterdata/period">Period</a>
        </li>
        <li class="mr-1">
            <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'type' ? 'bg-blue-400 text-white':''}}"
                href="/masterdata/type">Budget Type</a>
        </li>
        <li class="-mb-px mr-1">
            <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'index' ? 'bg-blue-400 text-white':''}}"
                href="/masterdata">Budget Version</a>
        </li>
    </ul>
    @yield('md_content')
@endsection
