@extends('index')

@section('content')
    <div class="absolute left-0 w-full pr-6 pl-6 py-2">
        <ul class="list-reset flex border-b ml-auto w-5/6 px-2 bg-gray-200">
            <li class="mr-2">
                <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'period' ? 'bg-blue-400 text-white':''}}"
                    href="/masterdata/period">Period</a>
            </li>
            <li class="mr-2">
                <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'type' ? 'bg-blue-400 text-white':''}}"
                    href="/masterdata/type">Budget Type</a>
            </li>
            <li class="-mb-px mr-2">
                <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'index' ? 'bg-blue-400 text-white':''}}"
                    href="/masterdata">Budget Version</a>
            </li>
        </ul>
    </div>
    <br>
    @yield('md_content')
@endsection
