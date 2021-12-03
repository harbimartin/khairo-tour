<div class="px-6">
    <?php
        $query = $_GET;
        $id = $query[$idk];
        unset($query[$idk]);
        $back_query = (isset($burl) ? url('/'.$burl) : request()->url()).($query ? '?'.http_build_query($query):'');

        $columns = json_decode($column);
        foreach($columns as $k => $v){
            if (!isset($v->by))
                $v->by = $k;
            if (isset($v->if)){
                $final = true;
                for($i = 0; $i < sizeof($v->if); $i+=3){
                    if (($datas[$v->if[$i]] == $v->if[$i+1]) != $v->if[$i+2]){
                        $final = false;
                        break;
                    }
                }
                if (!$final){
                    $v->class="hidden";
                }else{
                    $v->class='';
                }
            }
        }
    ?>
    <br>
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
    <form class="container rounded-lg shadow my-8 py-4 px-6 bg-white" action="{{(isset($url) ? url('/').$url : request()->url()).'/'.$id.'?'.Request::getRequestUri()}}" method="POST">
        @csrf
        @method('PUT')
        @isset($url)
            <input hidden name="_last_" value="{{request()->fullUrl()}}">
        @else
            <input hidden name="_next" value="{{$back_query}}">
        @endisset
        @switch($title)
            @case('MRA')
                <h1 class="border-b text-2xl pb-2 border-gray-200">No. MRA : {{$datas['budget_code']}} ({{$datas['budget_status']}})</h1>
            @break
            @default
            <h1 class="border-b text-2xl pb-2 border-gray-200">{{$detail ? '':'Update :'}} {{$title}}</h1>
        @endswitch
        <div class="grid grid-cols-2 gap-4 p-5">
            @foreach ($columns as $key => $param)
                <div @isset($param->if)if="{{json_encode($param->if)}}"@endisset class="inline-flex grid @isset($param->class){{$param->class}}@endisset {{ isset($param->full) ? 'grid-cols-6 col-span-2':'grid-cols-3'}}">
                    @isset($param->name)
                        <label for="{{$key}}" class="my-auto">{{$param->name}}
                            {{-- ({{$key}}) --}}
                        </label>
                    @endisset
                    @switch($param->type)
                        @case('Reference')
                            <input
                                readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                value-from="{{$param->key}}"
                                based="{{$param->val}}"
                                @isset($param->def)
                                    value="{{$param->def}}"
                                @endisset
                                type="text"
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('Static')
                            <input
                                readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                type="text"
                                value="{{$param->def}}"
                            />
                        @break
                        @case('String')
                            <input
                                @if($detail)readonly @endif
                                id="{{$key}}"
                                name="{{$key}}"
                                value="{{$datas[$param->by]}}"
                                type="text"
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('SString')
                            <?php
                                $txt = '';
                                foreach($param->child as $on=>$child){
                                    $str = $datas[$param->by][$child];
                                    if ($on == 0)
                                        $txt = ($str=='' ? '(Blank)':$str);
                                    else
                                        $txt = $txt.' - '.$str;
                                }
                            ?>
                            <input
                                readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                value="{{$txt}}"
                                type="text"
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Number')
                            <input
                                @isset($param->count)
                                    v-on:input="onCount($event, '{{$param->count}}')"
                                @endisset
                                id="{{$key}}"
                                name="{{$key}}"
                                value="{{$datas[$param->by]}}"
                                @if($detail && !isset($param->force))readonly @endif
                                type="number"
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('Boolean')
                        <select
                            id="{{$key}}"
                            name="{{$key}}"
                            type="number"
                            class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            @isset($param->share)v-on:change="inputSetIf('{{$key}}',$event)"@endisset
                            >
                                @foreach ($param->val as $ikey=>$item)
                                    <option value={{$ikey}} {{$datas[$param->by] == $ikey ? 'selected': ''}}>
                                        {{$item}}
                                    </option>
                                @endforeach
                        </select>
                        @break
                        @case('Select')
                        {{-- {{$select[$param->api]}} --}}
                            <select
                                id="{{$key}}"
                                name="{{$key}}"
                                type="number"
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                @isset($param->share)v-on:change="inputSetIf('{{$key}}',$event)"@endisset
                                >
                                @isset($param->null)
                                    <option selected value="" class="text-gray-400">(Blank)</option>
                                @endisset
                                @foreach ($select[$param->api] as $item)
                                    <option value={{$item['id']}} {{$datas[$param->by]==$item['id'] ? 'selected': ''}}>
                                        @foreach($param->val as $on => $val)
                                            @if($on == 0)
                                                {{$item[$val] ? $item[$val] : '(Blank)'}}
                                            @else
                                                - {{$item[$val]}}
                                            @endif
                                        @endforeach
                                    </option>
                                @endforeach
                            </select>
                        @break
                        @case('TextSel')
                            <datalist id="datalist_{{$key}}">
                                <?php
                                    $base_value='';
                                ?>
                                @foreach ($select[$param->api] as $item)
                                    <?php
                                        $set = !$detail;
                                        $txt='';
                                        $same = $item->id == $datas[$param->by];
                                        if ($set || $same){
                                            foreach($param->val as $kk => $val){
                                                $str = $item[$val];
                                                if ($kk == 0)
                                                        $txt = $txt.($str == '' ? '(Blank)':$str);
                                                else
                                                    $txt = $txt.' - '.$str;
                                            }
                                            if ($same){
                                                $set = true;
                                                $base_value = $txt;
                                                if (isset($param->share)){
                                                    $vshare = (array) $param->share;
                                                    foreach($columns as $kk => $vv){
                                                        if ($vv->type == 'Reference' && $vv->key == $key){
                                                            $vkey = $vshare[$vv->val];
                                                            if ($vkey == 0){
                                                                $vv->def = $item[$vv->val];
                                                            }else{
                                                                $vv->def = '';
                                                                // echo json_encode($vkey);
                                                                foreach($vkey as $vkk => $vki){
                                                                    // return;
                                                                    $vv->def = $vv->def.($vkk == 0? '':' - ').$item[$vv->val][$vki];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                    @if($set)
                                        <option
                                            @isset($param->share)
                                                <?php
                                                    $otxt = '{';
                                                    $i = 0;
                                                    foreach($param->share as $column => $share){
                                                        if ($share){
                                                            $otxt = $otxt.($i>0?'","':'"').$column.'":"';
                                                            foreach($share as $k => $v){
                                                                $otxt = $otxt.($k==0?'':' - ').$item[$column][$v];
                                                            }
                                                        }else
                                                            $otxt = $otxt.($i>0?'","':'"').$column.'":"'.$item[$column];
                                                        $i++;
                                                    }
                                                    $otxt = $otxt.'"}';
                                                ?>
                                                data-item="{{$otxt}}"
                                            @endisset
                                            data-value="{{$item->id}}"
                                            <?php
                                            ?>
                                            value="{{$txt}}">
                                        </option>
                                    @endif
                                @endforeach
                            </datalist>
                            <input @if($detail)readonly @endif v-on:change="inputSetUp('{{$key}}',$event, {{isset($param->share)}})" type="text" value="{{$base_value}}" list="datalist_{{$key}}" placeholder="Pilih {{$param->name}}" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                            <input id="{{$key}}" name="{{$key}}" value="{{$datas[$param->by]}}" hidden>
                        @break
                        @case('Total')
                            <?php
                                $def = 1;
                                foreach($param->from as $xvar){
                                    $def = $def * $datas[$xvar];
                                }
                            ?>
                            <input
                                disabled
                                from="{{json_encode($param->from)}}"
                                id="{{$key}}"
                                name="{{$key}}"
                                value="{{$def}}"
                                class="bg-gray-100 rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('TextArea')
                            <textarea
                                id="{{$key}}"
                                name="{{$key}}"
                                type="textarea"
                                @if($detail)readonly @endif
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">{{$datas[$param->by]}}</textarea>
                        @break
                        @case('Upload')
                            <div class="inline-flex col-start-2 col-end-7">
                                <input
                                    class="hidden"
                                    type="file"
                                    id={{$key}} name="{{$key}}"
                                    accept="application/pdf"
                                    v-on:change="uploadChange($event, '{{$key}}')"
                                >
                                <label class="bg-blue-400 hover:bg-blue-600 text-white cursor-pointer rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition" for="{{$key}}">Upload</label>
                                <span claSS="my-auto ml-2" id="file-chosen-{{$key}}">No file chosen</span>
                            </div>
                        @break
                        @case('Date')
                            @if($detail)
                                <input
                                    value="{{date('j F, Y', strtotime($datas[$param->by]))}}"
                                    type="text"
                                    readonly
                                    class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                />
                            @else
                                <input
                                    id="{{$key}}"
                                    name="{{$key}}"
                                    value="{{$datas[$param->by]}}"
                                    type="date"
                                    @if($detail)readonly @endif
                                    v-on:change="onlyDate($event)"
                                    class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                />
                            @endif
                        @break
                        @case('DateTime')
                            <input id="{{$key}}" name="{{$key}}" value="{{date('Y-m-d\TH:i', strtotime($datas[$param->by]))}}" type="datetime-local" v-on:change="onlyDate($event)" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @default
                    @endswitch
                </div>
            @endforeach
        </div>
        <div class="flex">
            @if(!$detail)
                <button
                    class="rounded border px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
                    type="submit"
                    name="__type"
                    value="update"
                > Update
                </button>
            @endif
        {{ $slot }}
        </div>
    </form>
</div>
