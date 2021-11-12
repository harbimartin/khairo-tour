@extends('pages.pengajuan', ['tab'=>'item'])
@section('md_content')
    <?php
        $title = "Item";
        $column = json_encode([
            // '0'=>[ 'name'=>"Purchase Requisition Item", 'type'=>'String', 'full'=>true, 'req'=> true ],
            '1'=>[ 'name'=>"Purchasing Group", 'type'=>'Select', 'api'=>'pgroup', 'val'=>'name', 'req'=> true ],
            '2'=>[ 'name'=>"Material Number", 'type'=>'Select', 'api'=>'mnumber', 'val'=>'name', 'req'=> true ],
            '3'=>[ 'name'=>'Short Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
            '4'=>[ 'name'=>"Material Group", 'type'=>'Select', 'api'=>'mgroup', 'val'=>'name', 'req'=> true ],
            '5'=>[ 'name'=>"Quantity", 'type'=>'Number', 'req'=> true ],
            '6'=>[ 'name'=>"Unit of Measure", 'type'=>'Select', 'api'=>'umeasure', 'val'=>'name', 'req'=> true ],
            '7'=>[ 'name'=>"Delivery Date", 'type'=>'Date', 'req'=> false ],
            '8'=>[ 'name'=>"Unit Price", 'type'=>'Number', 'req'=> false ],
            // '9'=>[ 'name'=>"Valuation Price", 'type'=>'Number', 'req'=> false ],
            '10'=>[ 'name'=>"Price Unit", 'type'=>'Number', 'req'=> false ],
            '11'=>[ 'name'=>"Item Category", 'type'=>'Select', 'api'=>'icategory', 'val'=>'name', 'req'=> true ],
            '12'=>[ 'name'=>"Account Assignment", 'type'=>'Select', 'api'=>'assign', 'val'=>'name', 'req'=> true ],
            '13'=>[ 'name'=>"Package Number", 'type'=>'String', 'req'=> true ],
            '14'=>[ 'name'=>"Currency", 'type'=>'Select', 'api'=>'currency', 'val'=>'name', 'req'=> true ],
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
