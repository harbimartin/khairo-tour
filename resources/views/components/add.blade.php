<div class="px-6">
    <form class="container rounded-lg shadow my-8 py-4 px-6 bg-white" action="{{request()->fullUrl()}}" method="POST">
        <h1 class="border-b text-2xl pb-2 border-gray-200">
            @if($title!="Verifikasi")
                {{$title}}
            @endif
        </h1>
        {{-- {{request()->url()}}<br> --}}
        {{$error}}
        <div class="grid grid-cols-2 gap-4 p-5">
            @csrf
            @foreach (json_decode($column) as $key => $param)
                <div @isset($param->if)if="{{json_encode($param->if)}}"@endisset class="inline-flex grid @isset($param->class){{$param->class}}@endisset {{ isset($param->full) ? 'grid-cols-6 col-span-2':'grid-cols-3'}}">
                    @isset($param->name)
                        <label for="{{$key}}" class="mt-1">{{$param->name}}</label>
                    @endisset
                    @switch($param->type)
                        @case('Info')
                            <div class="col-start-2 col-end-7 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                                <span>:</span>
                                <span class="ml-2">
                                    @isset($param->format)
                                        @switch($param->format)
                                            @case('Money')
                                                {{"Rp " . number_format($param->val,2,',','.')}}
                                            @break
                                        @endswitch
                                    @else
                                        {{$param->val}}
                                    @endisset
                                </span>
                            </div>
                        @break
                        @case('Reference')
                            <input readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                value-from="{{$param->key}}"
                                based="{{$param->val}}"
                                type="text"
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                            {{-- <div v-html="document.getElementById('2').value"></div> --}}
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
                            <input id="{{$key}}" name="{{$key}}" type="text" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Number')
                            <input
                                @isset($param->count)
                                    v-on:input="onCount($event, '{{$param->count}}')"
                                @endisset
                                id="{{$key}}"
                                name="{{$key}}"
                                @isset($param->def)
                                    value="{{$param->def}}"
                                @endisset
                                type="number"
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('Total')
                            <input
                                disabled
                                from="{{json_encode($param->from)}}"
                                id="{{$key}}"
                                name="{{$key}}"
                                class="bg-gray-100 rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break

                        @case('TextSel')
                            <datalist id="datalist_{{$key}}">
                                <?php
                                    $base_value='';
                                ?>
                                @foreach ($select[$param->api] as $item)
                                    <option
                                        @isset($param->share)
                                            <?php
                                                $txt = '{';
                                                $i = 0;
                                                foreach($param->share as $column => $share){
                                                    if ($share){
                                                        $txt = $txt.($i>0?'","':'"').$column.'":"';
                                                        foreach($share as $k => $v){
                                                            $txt = $txt.($k==0?'':' - ').$item[$column][$v];
                                                        }
                                                    }else
                                                        $txt = $txt.($i>0?'","':'"').$column.'":"'.$item[$column];
                                                    $i++;
                                                }
                                                $txt = $txt.'"}';
                                            ?>
                                            data-item="{{$txt}}"
                                        @endisset
                                        data-value="{{$item['id']}}"
                                        <?php
                                            $txt='';
                                            if (isset($param->format)){
                                                foreach($param->val as $kk => $val){
                                                    $txt = $txt.$param->format[$kk*2].$item[$val].$param->format[$kk*2+1];
                                                }
                                            }else{
                                                foreach($param->val as $kk => $val){
                                                    $str = $item[$val];
                                                    if ($kk == 0)
                                                        $txt = $txt.($str == '' ? '(Blank)':$str);
                                                    else
                                                        $txt = $txt.' - '.$str;
                                                }
                                            }
                                            if (isset($param->def) && $item->id == $param->def)
                                                $base_value = $txt;
                                        ?>
                                        value="{{$txt}}">
                                    </option>
                                @endforeach
                            </datalist>
                            <input v-on:change="inputSetUp('{{$key}}',$event, {{isset($param->share)}})" type="text" value="{{$base_value}}" list="datalist_{{$key}}" placeholder="Pilih {{$param->name}}" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                            <input id="{{$key}}" name="{{$key}}" @isset($param->def)value="{{$param->def}}"@endisset hidden>
                        @break

                        @case('Disable')
                            <?php
                                $txt = '';
                                foreach($param->val as $kk => $val){
                                    $txt = $txt.($kk?' - ':'').$select[$param->api][$val];
                                }
                            ?>
                            <input disabled id="{{$key}}" name="{{$key}}" value="{{$txt}}" type="text" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Select')
                            <select
                                id="{{$key}}"
                                name="{{$key}}"
                                @isset($param->direct)
                                    onchange="location = '?{{$param->direct}}='+this.options[this.selectedIndex].value;"
                                @endisset
                                {{-- @isset($param->direct)v-on:change="inputDirect('{{$param->direct}}')"@endisset --}}
                                @isset($param->def)value="{{$param->def}}"@endisset
                                @isset($param->share)v-on:change="inputSetIf('{{$key}}',$event)"@endisset
                                class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                                @isset($param->null)
                                    <option selected value="" class="text-gray-400">(Blank)</option>
                                @endisset
                                @foreach ($select[$param->api] as $item)
                                    <option
                                        @isset($param->def)@if($param->def == $item['id'])selected @endif @endisset
                                        @isset($param->share)
                                            share="{{$item[$param->share]}}"
                                        @endisset
                                        value={{$item['id']}}
                                        >
                                            @foreach($param->val as $key => $val)
                                                @if($key == 0)
                                                    {{$item[$val] ? $item[$val] : '(Blank)'}}
                                                @else
                                                    - {{$item[$val]}}
                                                @endif
                                            @endforeach
                                    </option>
                                @endforeach
                            </select>
                        @break
                        @case('TextArea')
                            <textarea id="{{$key}}" name="{{$key}}" type="textarea" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                            </textarea>
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
                            @isset($param->def)
                                <?php
                                    $date = new DateTime();
                                    $date->modify("+".$param->def." day");
                                    $default = $date->format("Y-m-d");
                                ?>
                                <input id="{{$key}}" name="{{$key}}" type="date" value="{{$default}}" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                            @else
                                <input id="{{$key}}" name="{{$key}}" type="date" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                            @endisset
                        @break
                        @default
                    @endswitch
                </div>
            @endforeach
        </div>
        <button
            class="flex rounded border px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
            type="submit"
        >
            @switch($title)
                @case('Propose')
                    Propose
                    @break
                @case('Verification - Proposed')
                    Verification - Proposed
                    @break
                @default
                Add {{$title}}
            @endswitch
        </button>
    </form>
</div>
