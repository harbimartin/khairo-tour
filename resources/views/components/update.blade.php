<div class="px-6">
    <?php
        $query = $_GET;
        $id = $query['id'];
        unset($query['id']);
        $back_query = request()->url().($query ? '?'.http_build_query($query):'');
    ?>
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
    {{-- {{$datas}}<br>
    {{$column}} --}}
    {{-- {{request()->url()}}<br>
    {{$error}} --}}
    <form class="container rounded-lg shadow my-8 py-4 px-6 bg-white" action="{{request()->url().'/'.$id}}" method="POST">
        @csrf
        @method('PUT')
        <h1 class="border-b text-2xl pb-2 border-gray-200">Update : {{$title}}</h1>
        <div class="grid grid-cols-2 gap-4 p-5">
            @foreach (json_decode($column) as $key => $param)
                <div class="inline-flex grid {{ isset($param->full) ? 'grid-cols-6 col-span-2':'grid-cols-3'}}">
                    <label for="{{$key}}" class="my-auto">{{$param->name}}</label>
                    @switch($param->type)
                        @case('String')
                            <input id="{{$key}}" name="{{$key}}" value="{{$datas[$key]}}" type="text" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Number')
                            <input id="{{$key}}" name="{{$key}}" value="{{$datas[$key]}}" type="number" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Select')
                        {{-- {{$select[$param->api]}} --}}
                            <select id="{{$key}}" name="{{$key}}" type="number" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                                <option disabled selected class="text-gray-400"></option>
                                @foreach ($select[$param->api] as $item)
                                    <option value={{$item['id']}} {{$datas[$key]==$item['id'] ? 'selected': ''}}>{{$item[$param->val]}}</option>
                                @endforeach
                            </select>
                        @break
                        @default
                    @endswitch
                </div>
            @endforeach
        </div>
        <button
            class="flex rounded border px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
            type="submit"
        > Update
        </button>
    </form>
</div>
