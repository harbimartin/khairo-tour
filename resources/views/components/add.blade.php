<div class="px-6">
    <form class="container rounded-lg shadow my-8 py-4 px-6 bg-white" action="{{request()->url()}}" method="POST">
        <h1 class="border-b text-2xl pb-2 border-gray-200">{{$title}}</h1>
        {{-- {{request()->url()}}<br>
        {{$error}} --}}
        <div class="grid grid-cols-2 gap-4 p-5">
            @csrf
            @foreach (json_decode($column) as $key => $param)
                <div class="inline-flex grid {{ isset($param->full) ? 'grid-cols-6 col-span-2':'grid-cols-3'}}">
                    <label for="{{$key}}" class="mt-1">{{$param->name}}</label>
                    @switch($param->type)
                        @case('String')
                            <input id="{{$key}}" name="{{$key}}" type="text" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Number')
                            <input id="{{$key}}" name="{{$key}}" type="number" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Select')
                            <select id="{{$key}}" name="{{$key}}" type="number" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                                @foreach ($select[$param->api] as $item)
                                    <option value={{$item['id']}}>{{$item[$param->val]}}</option>
                                @endforeach
                            </select>
                        @break
                        @case('TextArea')
                            <textarea id="{{$key}}" name="{{$key}}" type="textarea" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                            </textarea>
                        @break
                        @case('Upload')
                            <input
                                class="hidden"
                                type="file"
                                id={{$key}} name="{{$key}}"
                                accept="application/pdf"
                            >
                            <div class="inline-flex flex">
                                <label class="bg-blue-400 hover:bg-blue-600 text-white cursor-pointer rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition" for="{{$key}}">Upload</label>
                                <span id="file-chosen">No file chosen</span>
                            </div>
                            <script>
                                const actualBtn = document.getElementById({!! json_encode($key) !!});
                                const fileChosen = document.getElementById('file-chosen');
                                actualBtn.addEventListener('change', function(){
                                    fileChosen.textContent = this.files[0].name
                                })
                            </script>
                        @break
                        @case('Date')
                            <input id="{{$key}}" name="{{$key}}" type="date" class="rounded border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @default
                    @endswitch
                </div>
            @endforeach
        </div>
        <button
            class="flex rounded border px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
            type="submit"
        >Add {{$title}}</button>
    </form>
</div>
