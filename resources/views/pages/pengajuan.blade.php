    @extends('index')
    @section('content')
        <?php
            $title = "Header Pengajuan MRA";
            $column = json_encode([
                'tujuan'=>[ 'name'=>"MRA Date", 'type'=>'Date', 'req'=> false ],
                'prd'=>[ 'name'=>"MRA Document", 'type'=>'Select', 'api'=>'pr_doc', 'val'=>['doc_type','doc_type_desc'], 'req'=> true ],
                'bt'=>[ 'name'=>"Budget Version", 'type'=>'Select', 'api'=>'budget_version', 'val'=>['budget_name'], 'req'=> true ],
                'ht'=>[ 'name'=>'Header Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
                'rab'=>[ 'name'=>"Upload RAB", 'type'=>'Upload', 'val'=>'name', 'full'=>true, 'req'=> true , 'allow'=> ['pdf']],
            ]);
            $url = 'jejeje';
        ?>
        @isset($tab)
            <?php
                $query = $_GET;
                $id = $query['hid'];
                unset($query['hid']);
                $back_query = '/pengajuan/';//request()->url().($query ? '?'.http_build_query($query):'');
            ?>
            <div class="px-6">
                <a
                class="inline-flex rounded border px-3 mt-4 bg-gray-500 hover:bg-gray-600 mr-5 cursor-pointer text-white"
                type="button"
                href="{{$back_query}}">
                    <svg class="my-auto mr-2" xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
                        <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-7.08z"/>
                    </svg>
                <span class="my-2 font-semibold"> Kembali</span>
                </a>
            </div>
            <x-add
                idk="hid"
                :title="$title"
                :column="$column"
                :select="$select"
                :url="$url"
                :data="$data"
                :error="$error"
            ></x-add>
            <ul class="list-reset flex border-b px-6 mt-2">
                <li class="mr-1">
                    <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'item' ? 'bg-blue-400 text-white':''}}"
                        href="/pengajuan/item?hid={{$id}}">Item</a>
                </li>
                <li class="mr-1">
                    <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'service' ? 'bg-blue-400 text-white':''}}"
                        href="/pengajuan/service?hid={{$id}}">Service</a>
                </li>
                <li class="-mb-px mr-1">
                    <a class="rounded-md bg-white inline-block py-2 px-4 font-semibold {{$tab == 'assignment' ? 'bg-blue-400 text-white':''}}"
                        href="/pengajuan/assignment?hid={{$id}}">Account Assignment</a>
                </li>
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
    @endsection
