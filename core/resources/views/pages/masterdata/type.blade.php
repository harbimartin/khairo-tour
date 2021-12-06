@extends('pages.masterdata', ['tab'=>'type'])
@section('md_content')
    <?php
        $title = "Master Budget Type";
        $column = json_encode([
            'version_type'=>[ 'name'=>"Tipe", 'type'=>'String', 'req'=> true ]
        ]);
        $column_table = json_encode([
            'id'=>[ 'name'=>"No", 'type'=>'String'],
            'version_type'=>[ 'name'=>"Tipe", 'type'=>'String'],
            'state'=>[ 'name'=>"Status", 'type'=>'State'],
            'status'=>[ 'name'=>"Aktifkan", 'type'=>'Toggle'],
            'act'=>[ 'name'=>"Action", 'type' => 'Edit' ]
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
