@extends('pages.pengajuan', ['tab'=>'assignment'])
@section('md_content')
    <?php
        $title = "Account Assignment";
        $column = json_encode([
            'budget_version_code'=>[ 'name'=>"GL Account", 'type'=>'Select', 'api'=>'glaccount', 'val'=>['account','account_desc'], 'req'=> true ],
            'budget'=>[ 'name'=>"Cost Center", 'type'=>'Select', 'api'=>'costcenter', 'val'=>['name','name'], 'req'=> false ],
            'budget_name'=>[ 'name'=>'Internal Order', 'type'=>'Select', 'full'=>true, 'api'=>'internal', 'val'=>['name','name'], 'req'=> false ],
        ]);
        $column_table = json_encode([
            'nama'=> [ 'name'=>"Name", 'type'=>'String'],
            'budget'=>[ 'name'=>"Amount", 'type'=>'Money'],
            'state'=>[ 'name'=>"Status", 'type'=>'State'],
            'act'=>[ 'name'=>"Edit", 'type'=>'Edit'],
        ]);
        $url = 'jejeje';
    ?>
    @isset(request()->id)
        <x-update
            :title="$title"
            :data="$data"
            :error="$error"
        ></x-update>
    @else
        <x-add-record
            :title="$title"
            :column="$column"
            :select="$select"
            :error="$error"
        ></x-add-record>
        <x-table
            :column="$column_table"
            :datas="$data"
        ></x-table>
    @endisset
@endsection
