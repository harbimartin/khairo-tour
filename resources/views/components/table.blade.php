<div class="px-6">
    <div class="container rounded-lg shadow my-8 py-4 px-6 bg-white">
        <div class="flex">
            <span>
                Show
                <input type="number" value="10" maxlength="2" size="2" class="w-16 rounded-lg border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                &nbsp;Entries
            </span>
            <span class="ml-auto">
                Search : <input type="search" class="rounded-lg border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
            </span>
        </div>
        <div class="flex flex-col mt-4">
            <div class="-my-2 overflow-x-auto sm:-mx-6">
              <div class="py-2 align-middle inline-block min-w-full lg:px-1">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        @foreach (json_decode($column) as $key => $param)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider {{$param->type=='State' ? 'text-center':''}}">
                                {{$param->name}}
                            </th>
                        @endforeach
                        <th scope="col" class="relative px-6 py-3">
                          <span class="sr-only">Edit</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach (json_decode($datas, true); as $item)
                        <tr>
                            @foreach (json_decode($column) as $key => $param)
                                <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($param->type)
                                            @case('Money')
                                                    <div class="text-sm text-gray-900">{{ "Rp " . number_format($item[$key],2,',','.')}}</div>
                                                @break
                                            @case('SString')
                                                    <div class="text-sm text-gray-900">{{$item[$key][$param->child]}}</div>
                                                @break
                                            @case('String')
                                                    <div class="text-sm text-gray-900">{{$item[$key]}}</div>
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
                                    @endswitch
                                </td>
                            @endforeach
                          </tr>
                        @endforeach
                        {{-- <td class="px-6 py-4 whitespace-nowrap">
                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                          </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          Admin
                        </td> --}}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
