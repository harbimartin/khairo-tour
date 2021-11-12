@extends('index')
@section('content')
    <?php
        $title = 'MEMO REALISASI ANGGARAN';
        $code = 'MRA';
        $column = [
            'no_item'=> [ 'name'=>'Item<br>No.', 'align'=>'center', 'type'=>'Number'],
            'desc'=> [ 'name'=>'Description Barang / Jasa' ],
            'deliv'=> [ 'name'=>'Deliv. Date', 'align'=>'center', 'type'=>'Date'],
            'pgr'=> [ 'name'=>'PGr.', 'align'=>'center', 'type'=>'SString', 'child'=>'code'],
            'qty'=> [ 'name'=>'Qty', 'align'=>'center', 'type'=>'Float'],
            'uom'=> [ 'name'=>'UoM', 'align'=>'center', 'type'=>'SString', 'child'=>'code'],
            'cur'=> [ 'name'=>'Cur', 'align'=>'center', 'type'=>'SString', 'child'=>'code'],
            'eprice'=> [ 'name'=>'Price', 'align'=>'right', 'type'=>'Float', 'child'=>'code'],
            'uprice'=> [ 'name'=>'Unit<br>Price', 'align'=>'center', 'type'=>'Number'],
            'amount'=> [ 'name'=>'Amount', 'align'=>'center', 'type'=>'Float'],
            'gl_acc'=> [ 'name'=>'G/L. Account'],
            'costc'=> [ 'name'=>'Cost Center', 'align'=>'center'],
            'iowo'=> [ 'name'=>'IO / WO', 'align'=>'center'],
        ]
        // foreach($data->items as $item){
        //     $item['amount'] = $item['eprice'] * $item['uprice'];
        // }
    ?>
    <div class="px-3">
        <div class="absolute m-4">
            <a
            class="inline-flex rounded-3xl border px-3 bg-gray-500 hover:bg-blue-400 transition mr-5 cursor-pointer text-white"
            type="button"
            href="persetujuan">
                <svg class="my-auto mr-2" xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
                    <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-7.08z"/>
                </svg>
              <span class="my-2 font-semibold"> Kembali</span>
            </a>
        </div>
        <div class="container rounded-lg shadow my-3 py-7 px-3 bg-white">
            <img src="{{url('/assets/logo.png')}}" width="200px" class="mx-auto">
            <h1 class="border-gray-200 mt-5 underline font-bold text-center">{{$title}}</h1>
            <p class="text-center text-sm">No. {{$code}}: {{$data->no_mra}}</p>

            <div class="flex flex-col mt-6">
                <div class="-my-2 overflow-x-auto sm:-mx-3">
                <div class="py-2 align-middle inline-block min-w-full lg:px-1">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            @foreach ($column as $key => $param)
                                <th class="px-2 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ isset($param->align) ? "text-".$param->align : ''}}">
                                    {!! $param['name'] !!}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data->items as $item)
                                <tr>
                                    @foreach ($column as $key => $param)
                                        <td class="px-2 pt-4 whitespace-nowrap {{ isset($param->align) ? "text-".$param->align : ''}}">
                                            @isset($param['type'])
                                                @switch($param['type'])
                                                    @case('Number')@case('String')
                                                            <div class="text-sm text-gray-900">{{ $item[$key] }}</div>
                                                        @break
                                                    @case('Float')
                                                            <div class="text-sm text-gray-900">{{ number_format($item[$key],2,',','.')}}</div>
                                                        @break
                                                    @case('SString')
                                                            <div class="text-sm text-gray-900">{{$item[$key][$param['child']]}}</div>
                                                        @break
                                                    @case('Date')
                                                            <div class="text-sm text-gray-900">{{date('j M Y', strtotime($item[$key]))}}</div>
                                                        @break
                                                    @case('State')
                                                        <div class="flex">
                                                            @if($item[$key]=='AKTIF')
                                                                <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{$item[$key]}}
                                                                </div>
                                                            @else
                                                                <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    {{$item[$key]}}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @break
                                                    @case('Edit')
                                                            <a href="{{Request::url().'?id='.$item['id']}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                        @break
                                                    @case('Direct')
                                                            <a href="{{$param->url.'/view'}}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                        @break
                                                    @case('Toggle')
                                                        <form action="{{Request::url().'/'.$item['id']}}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input id="{{$key}}" name="{{$key}}" value="{{$item[$key]?0:1}}" hidden>
                                                            <button type="submit" class="text-indigo-600 hover:text-indigo-900">{{$item[$key] ? 'Nonaktifkan' : 'Aktifkan'}}</button>
                                                        </form>
                                                        @break
                                                    @case('Post')
                                                        <form action="{{Request::url().$param->url}}" method="POST">
                                                            <button type="submit" class="text-indigo-600 hover:text-indigo-900">{{$param->name}}</button>
                                                        </form>
                                                        @break
                                                    @default
                                                            <div class="text-gray-900 text-red-500">{{$item[$key]}}</div>
                                                            <small>{{$param['type']}}</small>
                                                        @break
                                                @endswitch
                                            @else
                                                @switch($key)   {{-- $item[$key] --}}
                                                    @case('desc')
                                                        @isset($item["desc"])
                                                            <div class="text-sm text-gray-900">{{ $item[$key] }}</div>
                                                        @endisset
                                                        @break
                                                    @case('gl_acc')
                                                        @isset($item["assign"]["gla"])
                                                            <div class="text-sm text-gray-900">{{$item["assign"]['gla']['no']}}</div>
                                                            <div class="text-xs text-gray-900">
                                                                {{$item["assign"]['gla']['title']}}<br>
                                                                - {{$item["assign"]['gla']['point']}}
                                                            </div>
                                                        @endisset
                                                        @break
                                                    @case('costc')
                                                        @isset($item["assign"]["cc"])
                                                            <div class="text-sm text-gray-900">{{$item["assign"]['cc']['no']}}</div>
                                                            <div class="text-xs text-gray-900">
                                                                {{$item["assign"]['cc']['division']}}
                                                            </div>
                                                        @endisset
                                                        @break
                                                    @case('iowo')
                                                        @isset($item["assign"]["io"])
                                                            <div class="text-sm text-gray-900">{{$item["assign"]['cc']['no']}}</div>
                                                            <div class="text-xs text-gray-900">
                                                                {{$item["assign"]['cc']['division']}}
                                                            </div>
                                                        @endisset
                                                        @break
                                                    @default
                                                    SLOT[{{$key}}]
                                                @endswitch
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($item['service'] as $serv)
                                    <tr style="border-top-width: 0px;">
                                        @foreach ($column as $key => $param)
                                            <td class="px-2 whitespace-nowrap text-xs text-gray-500 {{$loop->parent->last?'pb-4 ':''}} {{ isset($param->align) ? "text-".$param->align : ''}}">
                                                @isset($serv[$key])
                                                    @isset($param['type'])
                                                        @switch($param['type'])
                                                            @case('Number')@case('String')
                                                                    <div>{{ $serv[$key] }}</div>
                                                                @break
                                                            @case('Float')
                                                                    <div>{{ number_format($serv[$key],2,',','.')}}</div>
                                                                @break
                                                            @case('SString')
                                                                    <div>{{$serv[$key][$param['child']]}}</div>
                                                                @break
                                                            @case('Date')
                                                                    <div>{{date('j M Y', strtotime($serv[$key]))}}</div>
                                                                @break
                                                            @case('State')
                                                                <div class="flex">
                                                                    @if($serv[$key]=='AKTIF')
                                                                        <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                            {{$serv[$key]}}
                                                                        </div>
                                                                    @else
                                                                        <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                            {{$serv[$key]}}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                @break
                                                            @case('Edit')
                                                                    <a href="{{Request::url().'?id='.$serv['id']}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                                @break
                                                            @case('Direct')
                                                                    <a href="{{$param->url.'/view'}}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                                @break
                                                            @case('Toggle')
                                                                <form action="{{Request::url().'/'.$serv['id']}}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input id="{{$key}}" name="{{$key}}" value="{{$serv[$key]?0:1}}" hidden>
                                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">{{$serv[$key] ? 'Nonaktifkan' : 'Aktifkan'}}</button>
                                                                </form>
                                                                @break
                                                            @case('Post')
                                                                <form action="{{Request::url().$param->url}}" method="POST">
                                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">{{$param->name}}</button>
                                                                </form>
                                                                @break
                                                            @default
                                                                    <div class="text-red-500">{{$serv[$key]}}</div>
                                                                    <small>{{$param['type']}}</small>
                                                                @break
                                                        @endswitch
                                                    @endisset
                                                @endisset
                                                @switch($key)   {{-- $item[$key] --}}
                                                    @case('desc')
                                                        @isset($item["desc"])
                                                            <div class="text-sm">[{{$serv['no']}}] {{ $serv[$key] }}</div>
                                                        @endisset
                                                        @break
                                                    @default
                                                @endswitch
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                            <th colspan="9" class="text-xs font-medium text-gray-500 uppercase tracking-wider {{ isset($param->align) ? "text-".$param->align : ''}}">
                                Total
                            </th>
                            <th class="py-3 px-2 text-xs font-medium text-gray-900 text-left">
                                {{ number_format($data->total,2,',','.')}}
                            </th>
                            {{-- @foreach ($column as $key => $param)
                                <th class="px-2 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ isset($param->align) ? "text-".$param->align : ''}}">
                                    {!! $param['name'] !!}
                                </th>
                            @endforeach --}}
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
            <div class="mt-6 ml-6 w-1/3">
                <span class="text-gray-500 font-semibold">Keterangan :</span><br>
                <div class="text-sm text-gray-800">{{$data->text_header}}</div>
            </div>
            <div class="mt-6 w-1/3 text-sm ml-10">
                @foreach ($data->items as $item)
                    <div class="ml-10 inline-flex text-gray-600">
                        <span class="mr-1 font-semibold">{{$item['no_item']}}.</span>
                        <div class="mr-2">Specification&nbsp;:&nbsp;</div>
                        <div class="text-gray-800">{{$item['spec']}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
