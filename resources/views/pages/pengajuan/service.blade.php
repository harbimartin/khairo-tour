@extends('pages.pengajuan', ['tab'=>'service'])
@section('md_content')
    <?php
        $title = "Service";
        $column = json_encode([
            'item'=>[ 'name'=>"Item", 'type'=>'Select', 'api'=>'items', 'val'=>['account','account_desc'], 'full'=>true, 'req'=> true ],
            // 'budget_version_code'=>[ 'name'=>"Service Line", 'type'=>'Number', 'req'=> true ],
            '8'=>[ 'name'=>"Unit Price", 'type'=>'Number', 'req'=> false ],
            '14'=>[ 'name'=>"Currency", 'type'=>'TextSel', 'api'=>'currency', 'val'=>['currency','currency_desc'], 'req'=> true ],
            'quantity'=>[ 'name'=>"Quantity", 'type'=>'Number', 'req'=> true ],
            'total'=>[ 'name'=>"Total", 'type'=>'Number', 'req'=> false ],

            'budget_name'=>[ 'name'=>'Short Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
            'prd'=>[ 'name'=>"Unit of Measure", 'type'=>'TextSel', 'api'=>'umeasure', 'val'=>['unit_measurement','unit_measurement_desc'], 'req'=> true ],
            // 'awd'=>[ 'name'=>"Unit Price", 'type'=>'Number', 'req'=> false ],

            'gl_account'=>[ 'name'=>"GL Account", 'type'=>'Select', 'api'=>'glaccount', 'val'=>['account','account_desc'], 'req'=> true ],
            'budget'=>[ 'name'=>"Cost Center", 'type'=>'Select', 'api'=>'costcenter', 'val'=>['name','name'], 'req'=> false ],
            'io'=>[ 'name'=>'Internal Order', 'type'=>'Select', 'full'=>true, 'api'=>'internal', 'val'=>['name','name'], 'req'=> false ],
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
