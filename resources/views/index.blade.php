<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="https://unpkg.com/vue"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <title>E-Budgeting PT. KBS</title>
</head>
<body>
    <section id="vue-app" class="body md:flex w-full max-h-screen">
        <section class="navigation md:w-1/6 w-full md:h-screen md:max-h-screen h-auto md:border-gray-200 md:border-r">
            <div class="md:block hidden top-0 left-0 bottom-0 right-0 md:py-10">
                <div class="avatar inline-flex md:block md:text-center">
                    <img src="{{url('/assets/avatars.svg')}}"
                        class="rounded-full md:h-3/5 md:w-3/5 mx-auto" alt="avatar">
                    <h6 class="font-semibold mt-2">Username Users</h6>
                </div>
                <div class="mt-4">
                    <a href="/">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/home.svg')}}" alt="home">
                            <p class="my-auto ml-3 text-sm font-semibold">Home</p>
                        </div>
                    </a>
                    <a href="/persetujuan">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_data.png')}}" alt="menu_data">
                            <p class="my-auto ml-3 text-sm font-semibold">Persetujuan</p>
                        </div>
                    </a>
                    <a href="/masterdata">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_data.png')}}" alt="menu_data">
                            <p class="my-auto ml-3 text-sm font-semibold">Master Data</p>
                        </div>
                    </a>
                    <a href="/pengajuan">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_data.png')}}" alt="menu_data">
                            <p class="my-auto ml-3 text-sm font-semibold">Pengajuan MRA</p>
                        </div>
                    </a>
                    <a href="/pengajuan_head">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_data.png')}}" alt="menu_data">
                            <p class="my-auto ml-3 text-sm font-semibold">Pengajuan MRA 2</p>
                        </div>
                    </a>
                    <a href="/overview">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_data.png')}}" alt="menu_data">
                            <p class="my-auto ml-3 text-sm font-semibold">Overview MRA</p>
                        </div>
                    </a>
                    <a href="/pengalihan_anggaran">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_data.png')}}" alt="menu_data">
                            <p class="my-auto ml-3 text-sm font-semibold">Pengalihan</p>
                        </div>
                    </a>
                    <a href="/login">
                        <div class="inline-flex w-full hover:bg-gray-100 md:px-3 py-3 cursor-pointer">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_logout.png')}}" alt="menu_logout">
                            <p class="my-auto ml-3 text-sm font-semibold">Logout</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="md:hidden block">
                <div class="flex justify-end py-2 px-2">
                    <img src="{{url('/assets/menu.svg')}}" alt="menu">
                </div>
            </div>
        </section>
        <section class="pages md:w-5/6 w-full h-screen max-h-screen bg-gray-200">
            <div class="overflow-y-auto max-h-screen">
                @yield('content')
            </div>
        </section>
    </section>
    @extends('vue');
</body>
<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    @yield('script')
</html>
