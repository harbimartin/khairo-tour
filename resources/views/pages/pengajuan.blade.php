    @extends('index')
    @section('content')
        <?php
            $title = "Header Pengajuan MRA";
            $column = [
                'budget_date'=>[ 'name'=>"MRA Date", 'type'=>'Date', 'def'=>0, 'req'=> false ],
                'document_type'=>[ 'name'=>"MRA Document", 'type'=>'TextSel', 'api'=>'pr_doc', 'val'=>['doc_type','doc_type_desc'], 'req'=> true ],
                'budget_version'=>[ 'name'=>"Budget Version", 'type'=>'Select', 'api'=>'budget_version', 'val'=>['budget_version_code', 'budget_name'], 'full'=>true, 'req'=> true ],
                'note_header'=>[ 'name'=>'Header Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
                'budget_attachment'=>[ 'name'=>"Upload RAB", 'type'=>'Upload', 'val'=>'name', 'full'=>true, 'req'=> true , 'allow'=> ['pdf']],
            ];
            if (request()->mra){
                $column['prd']['type'] = 'Disable';
                // $column['prd']['state'] = request()->mra;
            }
            $column = json_encode($column);
            $url = '/pengajuan';
        ?>
        @isset(request()->id)
            @yield('md_content')
        @else
            @isset($tab)
                <?php
                    $query = $_GET;
                    $id = request()->hid;//$query['hid'];
                    unset($query['hid']);
                    $back_query = '/pengajuan/';//request()->url().($query ? '?'.http_build_query($query):'');
                ?>
                <x-update
                    idk="hid"
                    title="MRA"
                    :column="$column"
                    :select="$select"
                    :url="$url"
                    :data="$header"
                    :error="$error"
                    burl="overview"
                >
                    <input
                        v-on:click="downloadFile('{{$header['budget_attachment']}}')"
                        class="flex rounded border px-4 py-2 bg-blue-500 hover:bg-blue-600 mr-5 cursor-pointer text-white font-semibold"
                        type="button"
                        value="Download Lampiran"
                    />
                    <button type="submit" name="__type" value="propose"
                        class="rounded border px-4 py-2 bg-indigo-500 hover:bg-indigo-600 mr-5 cursor-pointer text-white font-semibold"
                    >
                        Propose
                    </button>
                </x-update>
                <ul class="list-reset flex border-b px-6 mt-2">
                    <li class="mr-1">
                        <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'item' ? 'bg-blue-400 text-white':''}}"
                            href="{{ url('/') }}/pengajuan/item?hid={{$id}}">Item</a>
                    </li>
                    <li class="mr-1">
                        <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'service' ? 'bg-blue-400 text-white':''}}"
                            href="{{ url('/') }}/pengajuan/service?hid={{$id}}">Service</a>
                    </li>
                    {{-- <li class="-mb-px mr-1">
                        <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'assignment' ? 'bg-blue-400 text-white':''}}"
                            href="/pengajuan/assignment?hid={{$id}}">Account Assignment</a>
                    </li> --}}
                </ul>
                @yield('md_content')
            @else
                <x-add-record
                    :title="$title"
                    :column="$column"
                    :error="$error"
                    :select="$select"
                    url="/pengajuan/add"
                ></x-add-record>
            @endisset
        @endisset
    @endsection
