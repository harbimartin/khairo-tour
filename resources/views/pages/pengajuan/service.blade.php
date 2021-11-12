@extends('pages.pengajuan', ['tab'=>'service'])
@section('md_content')
    <?php
        $title = "Service";
        $column = json_encode([
            'budget_version_code'=>[ 'name'=>"Service Line", 'type'=>'Number', 'req'=> true ],
            'quantity'=>[ 'name'=>"Quantity", 'type'=>'Number', 'req'=> true ],
            'budget_name'=>[ 'name'=>'Short Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
            'prd'=>[ 'name'=>"Unit of Measure", 'type'=>'Select', 'api'=>'umeasure', 'val'=>'name', 'req'=> true ],
            'budget'=>[ 'name'=>"Price Unit", 'type'=>'Number', 'req'=> false ],
        ]);
        $column_table = json_encode([
            'service'=> [ 'name'=>"Service Line", 'type'=>'String'],
            'stext'=>[ 'name'=>"Short Text", 'type'=>'String'],
            'quantity'=>[ 'name'=>"Quantity", 'type'=>'String'],
            'umeasure'=>[ 'name'=>"Unit of Measure", 'type'=>'String'],
            'uprice'=>[ 'name'=>"Unit Price", 'type'=>'String'],
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
