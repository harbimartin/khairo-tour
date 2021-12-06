@extends('index')
@section('content')
    <?php
        $title = 'MEMO REALISASI ANGGARAN';
        $code = 'MRA';
        $isVerify = $purpose != "Approve";
        $column['seq_no'] = [ 'name'=>'Item<br>No.', 'align'=>'center', 'type'=>'Number'];
        $column['short_text'] = [ 'name'=>'Description Barang / Jasa' ];
        $column['delivery_date_exp'] = [ 'name'=>'Deliv. Date', 'align'=>'center', 'type'=>'Date'];
        $column['purchase_groups'] = [ 'name'=>'PGr.', 'align'=>'center', 'type'=>'SString', 'child'=>'purchase_group'];
        $column['qty_proposed'] = [ 'name'=>'Qty', 'align'=>'center', 'type'=>'Float'];
        $column['uom'] = [ 'name'=>'UoM', 'align'=>'center', 'type'=>'SString', 'child'=>'unit_measurement'];
        $column['currencies'] = [ 'name'=>'Cur', 'align'=>'center', 'type'=>'SString', 'child'=>'currency'];
        $column['total_proposed'] = [ 'name'=>'Price'.($isVerify ? '<br>Proposed':''), 'align'=>'right', 'type'=>'Float', 'bolder'=>$isVerify];
        if ($isVerify)
            $column['total_verified'] = [ 'name'=>'Price<br>Verified', 'align'=>'right', 'type'=>'Float', 'bolder'=>true];
        $column['price_unit'] = [ 'name'=>'Unit<br>Price', 'align'=>'center', 'type'=>'Number'];
        $column['total_proposed'] = [ 'name'=>'Amount'.($isVerify ? '<br>Proposed':''), 'align'=>'center', 'type'=>'Float','bolder'=> $isVerify];
        if ($isVerify)
            $column['total_verified'] = [ 'name'=>'Amount<br>Verified', 'align'=>'center', 'type'=>'Float','bolder'=>true];
        $column['gl_accounts'] = [ 'name'=>'G/L. Account'];
        $column['cost_centers'] = [ 'name'=>'Cost Center'];
        $column['internal_orders'] = [ 'name'=>'IO / WO'];
        // foreach($data->items as $item){
        //     $item['amount'] = $item['eprice'] * $item['uprice'];
        // }
    ?>
    <a
        class="inline-flex rounded-3xl border px-3 py-1 bg-red-900 hover:bg-red-400 transition ml-5 cursor-pointer text-white"
        href="{{url('/api/purchase_requisitions')}}"
        target="_blank"
    >
        Click Here to Open Old Return
    </a>
    <a
        class="inline-flex rounded-3xl border px-3 py-1 bg-blue-900 hover:bg-blue-400 transition mr-5 cursor-pointer text-white"
        target="_blank"
        href="{{url('/api/budget_detail?id='.request()->id)}}"
    >
        Click Here to Open New Ways
    </a>
    <form action="{{request()->url().'/'.request()->id}}" method="POST"  class="px-3">
        @csrf
        @method('PUT')
        <input class="hidden" name="status_id" value="{{$status_id}}"/>
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
            <p class="text-center text-sm">No. {{$code}}: {{$data->budget_code}}</p>

            <div class="flex flex-col mt-6">
                <div class="-my-2 overflow-x-auto sm:-mx-3">
                <div class="py-2 align-middle inline-block min-w-full lg:px-1">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            @foreach ($column as $key => $param)
                                <th class="px-2 py-3 text-xs text-gray-500 uppercase tracking-wider {{ isset($param['align']) ? "text-".$param['align'] : ''}} {{ isset($param['class']) ? $param['class'] : ''}} {{ isset($param['bolder']) ? 'font-semibold' : 'font-medium'}}">
                                    {!! $param['name'] !!}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data->items as $item)
                                <tr>
                                    @foreach ($column as $key => $param)
                                        <td class="px-2 pt-4 whitespace-nowrap {{ isset($param['align']) ? "text-".$param['align'] : ''}} {{isset($param['class']) ? $param['class'] : ''}} {{isset($param['bolder']) ? 'font-semibold' : ''}}">
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
                                                    @default
                                                            <div class="text-gray-900 text-red-500">{{$item[$key]}}</div>
                                                            <small>{{$param['type']}}</small>
                                                        @break
                                                @endswitch
                                            @else
                                                @switch($key)   {{-- $item[$key] --}}
                                                    @case('short_text')
                                                        @isset($item["short_text"])
                                                            <div class="text-sm text-gray-900">{{ $item[$key] }}</div>
                                                        @endisset
                                                        @break
                                                    @case('gl_accounts')
                                                        {{-- @isset($item["gl_accounts"]["gl_account"]) --}}
                                                            <div class="text-sm text-gray-900">{{$item["gl_accounts"]['gl_account']}}</div>
                                                            <div class="text-xs text-gray-900">
                                                                {{-- {{$item["assign"]['gla']['title']}}<br>
                                                                - {{$item["assign"]['gla']['point']}} --}}
                                                                {{$item["gl_accounts"]["gl_account_desc"]}}
                                                            </div>
                                                        {{-- @endisset --}}
                                                        @break
                                                    @case('cost_centers')
                                                        @isset($item["cost_centers"])
                                                            <div class="text-sm text-gray-900">{{$item["cost_centers"]['cost_center']}}</div>
                                                            <div class="text-xs text-gray-900">
                                                                {{$item["cost_centers"]['cost_center_desc']}}
                                                            </div>
                                                        @endisset
                                                        @break
                                                    @case('internal_orders')
                                                        @isset($item["internal_orders"])
                                                            <div class="text-sm text-gray-900">{{$item["internal_orders"]['io_code']}}</div>
                                                            {{-- <div class="text-xs text-gray-900">
                                                                {{$item["assign"]['cc']['division']}}
                                                            </div> --}}
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
                                            <td class="px-2 whitespace-nowrap text-xs text-gray-500 {{$loop->parent->last?'pb-4 ':''}} {{ isset($param['align']) ? "text-".$param['align'] : ''}}">
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
                                                                    <a href="{{$param['url'].'/view'}}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                                @break
                                                            @default
                                                                    <div class="text-red-500">{{$serv[$key]}}</div>
                                                                    <small>{{$param['type']}}</small>
                                                                @break
                                                        @endswitch
                                                    @endisset
                                                @endisset
                                                @switch($key)   {{-- $item[$key] --}}
                                                    @case('short_text')
                                                        @isset($item["short_text"])
                                                            <div class="text-sm">[{{$serv['seq_no']}}] {{ $serv[$key] }}</div>
                                                        @endisset
                                                        @break
                                                    @case('gl_accounts')
                                                        {{-- @isset($item["gl_accounts"]["gl_account"]) --}}
                                                            <div class="text-sm text-gray-900">{{$serv["gl_accounts"]['gl_account']}}</div>
                                                            <div class="text-xs text-gray-900">
                                                                {{-- {{$serv["assign"]['gla']['title']}}<br>
                                                                - {{$serv["assign"]['gla']['point']}} --}}
                                                                {{$serv["gl_accounts"]["gl_account_desc"]}}
                                                            </div>
                                                        {{-- @endisset --}}
                                                        @break
                                                    @case('cost_centers')
                                                        {{-- @isset($serv["cost_centers"]) --}}
                                                            <div class="text-sm text-gray-900">{{$serv["cost_centers"]['cost_center']}}</div>
                                                            <div class="text-xs text-gray-900">
                                                                {{$serv["cost_centers"]['cost_center_desc']}}
                                                            </div>
                                                        {{-- @endisset --}}
                                                        @break
                                                    @case('internal_orders')
                                                        {{-- @isset($item["internal_orders"]) --}}
                                                            <div class="text-sm text-gray-900">{{$serv["internal_orders"]['io_code']}}</div>
                                                            {{-- <div class="text-xs text-gray-900">
                                                                {{$item["assign"]['cc']['division']}}
                                                            </div> --}}
                                                        {{-- @endisset --}}
                                                        @break
                                                    @default
                                                @endswitch
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                            <th colspan="{{$isVerify ? 7:7}}" class="text-xs font-medium text-gray-500 uppercase tracking-wider {{ isset($param['align']) ? "text-".$param['align'] : ''}}">
                                Total
                            </th>
                            <th class="py-3 px-2 text-xs font-medium text-gray-900 text-center">
                                {{ number_format($data->total_proposed,2,',','.')}}
                            </th>
                            @if($isVerify)
                                <th class="py-3 px-2 text-xs font-medium text-gray-900 text-center">
                                    {{ number_format($data->total_verified,2,',','.')}}
                                </th>
                            @endif
                            {{-- @foreach ($column as $key => $param)
                                <th class="px-2 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ isset($param['align']) ? "text-".$param['align'] : ''}}">
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
                <div class="text-sm text-gray-800">{{$data->note_header}}</div>
            </div>
            <div class="mt-6 w-1/3 text-sm ml-10">
                @foreach ($data->items as $item)
                    <div class="ml-10 inline-flex text-gray-600">
                        <span class="mr-1 font-semibold">{{$item['seq_no']}}.</span>
                        <div class="mr-2">Specification&nbsp;:&nbsp;</div>
                        <div class="text-gray-800">{{$item['note_item']}}</div>
                    </div><br>
                @endforeach
            </div>
            <div class="flex">
                <div class="inline-flex mx-auto mt-10">
                    <input
                        v-on:click="downloadFile('{{$data['id']}}')"
                        class="flex rounded border px-4 py-2 bg-blue-500 hover:bg-blue-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
                        type="button"
                        value="Download Lampiran"
                    />
                    <input
                        v-on:click="onReject = true"
                        class="flex rounded border px-4 py-2 bg-red-500 hover:bg-red-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
                        type="button"
                        value="Reject"
                    />
                    <button
                        class="flex rounded border px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
                        type="submit"
                        name="type"
                        value="verifikasi"
                    >
                    {{-- {{$purpose}} --}}
                    Approve
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <form action="{{request()->url().'/'.request()->id}}" method="POST" v-show="onReject" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        @csrf
        @method('PUT')
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!--
        coba nanti
          Masuk: "ease-out duration-300"
            dari: "opacity-0"
            jadi: "opacity-100"
          Keluar: "ease-in duration-200"
            dari: "opacity-100"
            jadi: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <!-- Heroicon name: outline/exclamation -->
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                  Reject Anggaran
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-600">
                    Apa anda yakin ingin membatalkan Memo Realisasi Anggaran No. {{$code}}: {{$data->budget_code}} ?
                  </p>
                </div>
                <div class="my-2 text-sm text-gray-500 font-semibold">Alasan Reject : </div>
                <textarea id="reason" name="reason" class="border rounded shadow w-full text-sm px-2 py-1" placeholder="Tulis alasan anda menolak anggaran ini"></textarea>
              <input class="hidden" name="status_id" value="{{$status_id}}"/>
                </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button v-on:click="onReject = false" type="submit" name="type" value="reject" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
              Reject
            </button>
            <button v-on:click="onReject = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </form>
@endsection
