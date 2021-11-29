@extends('pages.masterdata', ['tab'=>'io'])
@section('md_content')
    <?php
        $title = "Master Internal Order";
        $column = json_encode([
            'io_code'=>[ 'name'=>"Code", 'type'=>'String', 'req'=> true ],
            'io_date'=>[ 'name'=>"Date", 'type'=>'Date', 'req'=> true ]
        ]);
        $column_table = json_encode([
            'io_code'=>[ 'name'=>"Code", 'type'=>'String'],
            'io_date'=>[ 'name'=>"Date", 'type'=>'Date'],
        ]);
        $url = 'jejeje';
    ?>
    @isset(request()->id)
        <x-update
            :id="request()->id"
            :title="$title"
            :column="$column"
            :url="$url"
            :data="$data"
            :error="$error"
        ></x-update>
    @else
        <x-add-record
            :title="$title"
            :column="$column"
            :url="$url"
        ></x-add-record>
        <x-table
            :column="$column_table"
            :datas="$data"
        ></x-table>
    @endisset
@endsection
