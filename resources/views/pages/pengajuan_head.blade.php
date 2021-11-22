    @extends('index')
    @section('content')
        <?php
            $head = 'Pengajuan Aset';
            $menus = [
                [ 'nama'=> 'Aset Barang' , 'href'=>'/pengajuan?mra=2&type=barang', 'color'=>'blue'],
                [ 'nama'=> 'Aset Jasa' , 'href'=>'/pengajuan?mra=2&type=jasa', 'color'=>'blue']
            ]
        ?>
            <div class="grid grid-cols-1 gap-5 px-20 md:grid-cols-{{sizeof($menus)}} h-screen">
                @foreach ($menus as $menu)
                    <div class="mt-20 relative h-52 bg-cover bg-center group rounded-lg overflow-hidden shadow-lg transition duration-300 ease-in-out"
                    style="background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/f868ecef-4b4a-4ddf-8239-83b2568b3a6b/de7hhu3-3eae646a-9b2e-4e42-84a4-532bff43f397.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2Y4NjhlY2VmLTRiNGEtNGRkZi04MjM5LTgzYjI1NjhiM2E2YlwvZGU3aGh1My0zZWFlNjQ2YS05YjJlLTRlNDItODRhNC01MzJiZmY0M2YzOTcuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.R0h-BS0osJSrsb1iws4-KE43bUXHMFvu5PvNfoaoi8o');">
                        <div class="absolute inset-0 bg-{{$menu['color']}}-600 bg-opacity-75 transition duration-300 ease-in-out"></div>
                        <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center justify-center">
                        <div>
                            {{-- <h3 class="text-center text-white text-3xl font-bold">
                                {{$head}}
                            </h3> --}}
                            <h3 class="text-center text-white text-3xl mt-2 font-bold">
                                {{$menu['nama']}}
                            </h3>
                            <div class="flex space-x-4 mt-4">
                            {{-- <button class="block uppercase mx-auto shadow bg-white text-indigo-600 focus:shadow-outline
                                focus:outline-none text-white text-xs py-3 px-4 rounded font-bold">
                                Transfer
                            </button> --}}
                            <a class="block uppercase mx-auto shadow bg-indigo-600 hover:bg-indigo-700 focus:shadow-outline
                                focus:outline-none text-white text-xs py-3 px-4 rounded font-bold" href="{{$menu['href']}}">
                                Buat Baru
                            </a>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
              </div>
    @endsection
