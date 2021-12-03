@extends('index')
@section('content')
<?php
    $title = "Header Pengajuan MRA";
    $column = [
        'budget_date'=>[ 'name'=>"MRA Date", 'type'=>'Date', 'def'=>0, 'req'=> false ],
        'doc_types'=>[ 'name'=>"MRA Document", 'type'=>'SString', 'child'=>['doc_type','doc_type_desc'], 'req'=> true ],
        'budget_versions'=>[ 'name'=>"Budget Version", 'type'=>'SString', 'child'=>['budget_version_code', 'budget_name'], 'full'=>true, 'req'=> true ],
        'note_header'=>[ 'name'=>'Header Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
        // 'budget_attachment'=>[ 'name'=>"Upload RAB", 'type'=>'Upload', 'val'=>'name', 'full'=>true, 'req'=> true , 'allow'=> ['pdf']],
    ];
    if (request()->mra){
        $column['prd']['type'] = 'Disable';
        // $column['prd']['state'] = request()->mra;
    }
    $column = json_encode($column);
    $url = '/verifikasi';
?>
    {{-- {{$data[0]}} --}}
    {{-- <x-table
        :datef="true"
        :column="$column_table"
        :datas="$data"
    ></x-table> --}}

    <?php
    $query = $_GET;
    $id = request()->hid;//$query['hid'];
    unset($query['hid']);
    $back_query = '/pengajuan/';//request()->url().($query ? '?'.http_build_query($query):'');
?>
@isset(request()->id)
    @yield('md_content')
@else
    <x-update
        idk="hid"
        title="MRA"
        :column="$column"
        :select="$select"
        :url="$url"
        :data="$header"
        :error="$error"
        burl="verifikasi"
        detail="true"
    >
    @if($tab!='propose')
        {{-- {{$header}} --}}
        <input
            v-on:click="downloadFile('{{$header['budget_attachment']}}')"
            class="flex rounded border px-4 py-2 bg-blue-500 hover:bg-blue-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
            type="button"
            value="Download Lampiran"
        />
        <input
            v-on:click="onReject = true"
            class="flex rounded border px-4 py-2 bg-red-500 hover:bg-red-600 mr-5 cursor-pointer text-white font-semibold"
            type="button"
            value="Reject"
        />
        <button type="submit" name="__type" value="verified"
            class="rounded border px-4 py-2 bg-indigo-500 hover:bg-indigo-600 mr-5 cursor-pointer text-white font-semibold"
        >
            Verify
        </button>
    @endif
        <div v-show="onReject" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                        Apa anda yakin ingin membatalkan Memo Realisasi Anggaran No. MRA: {{$header->budget_code}} ?
                      </p>
                    </div>
                    <div class="my-2 text-sm text-gray-500 font-semibold">Alasan Reject : </div>
                    <textarea id="reason" name="reason" class="border rounded shadow w-full text-sm px-2 py-1" placeholder="Tulis alasan anda menolak anggaran ini"></textarea>
                    </div>
                </div>
              </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button v-on:click="onReject = false" type="submit" name="__type" value="reject" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Reject
                    </button>
                    <button v-on:click="onReject = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
          </div>
        </div>
    </x-update>
    @if($tab!='propose')
        <ul class="list-reset flex border-b px-6 mt-2">
            <li class="mr-1">
                <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'item' ? 'bg-blue-400 text-white':''}}"
                    href="{{ url('/') }}/verifikasi/items?hid={{$id}}">Item</a>
            </li>
            <li class="mr-1">
                <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'service' ? 'bg-blue-400 text-white':''}}"
                    href="{{ url('/') }}/verifikasi/services?hid={{$id}}">Service</a>
            </li>
        </ul>
    @endif
    @yield('md_content');
    @endisset
@endsection
