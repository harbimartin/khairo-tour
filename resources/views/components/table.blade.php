<div class="px-6">
    <div class="container rounded-lg shadow my-8 py-4 px-6 bg-white">
        <div class="flex">
            <span>
                Show
                <input type="number" value="10" maxlength="2" size="2" class="w-16 rounded-lg border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                &nbsp;Entries
            </span>
            @if($datef)
                <span class="ml-auto">
                    From <input type="date" class="rounded-lg border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                </span>
                <span class="ml-auto">
                    To <input type="date" class="rounded-lg border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                </span>
                {{-- @if ($errors->has('file'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('file') }}</strong>
                </span>
                @endif
                @if ($sukses = Session::get('sukses'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $sukses }}</strong>
                </div>
                @endif --}}
            @endif
            @if($import)
            <div v-if="onImport" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <form method="post" action="?mode=import" enctype="multipart/form-data" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            {{-- <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            </div> --}}
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Import Data
                                </h3>
                                <div class="mt-2">
                                    <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">

                                                        {{ csrf_field() }}

                                                        <label>Pilih file excel</label>
                                                        <div class="form-group">
                                                            <input type="file" name="file" required="required">
                                                        </div>

                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button v-on:click="onImport = false" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Upload
                    </button>
                    <button v-on:click="onImport = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                    </div>
                </form>
                </div>
            </div>
            @endif
            <span class="ml-auto inline-flex">
                @if($import)
                    <input
                        v-on:click="onImport = true"
                        class="flex rounded border px-4 py-2 mx-2 bg-green-500 hover:bg-green-600 cursor-pointer text-white font-semibold"
                        type="button"
                        value="Import Excel"
                    />
                @endif
                <span class="mx-2 my-auto">Search :</span>
                <input type="search" class="rounded-lg border col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
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
