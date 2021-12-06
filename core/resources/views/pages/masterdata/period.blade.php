@extends('pages.masterdata', ['tab'=>'period'])
@section('md_content')
    <?php
        $title = "Master Budget Period";
        $column = json_encode([
            'budget_period'=>[ 'name'=>"Tahun", 'type'=>'Number', 'req'=> true ],
            'budget_period_desc'=>[ 'name'=>"Deskripsi", 'type'=>'String', 'req'=> true ],
        ]);
        $column_table = json_encode([
            'id'=>[ 'name'=>"No", 'type'=>'String'],
            'budget_period'=>[ 'name'=>"Tahun", 'type'=>'String'],
            'budget_period_desc'=>[ 'name'=>"Deskripsi", 'type'=>'String'],
            'state'=>[ 'name'=>"Status", 'type'=>'State'],
            'act'=>[ 'name'=>"Edit", 'type'=>'Edit'],
            'status'=>[ 'name'=>"Aktifkan", 'type'=>'Toggle']
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
