@extends('pages.pengajuan', ['tab'=>'item'])
@section('md_content')
    <?php
        $title = "Item";
        $column = json_encode([
            // '0'=>[ 'name'=>"Purchase Requisition Item", 'type'=>'String', 'full'=>true, 'req'=> true ],
            '1'=>[ 'name'=>"Purchasing Group", 'type'=>'Select', 'api'=>'pgroup', 'val'=>['purchase_group','purchase_group_desc'], 'req'=> true ],
            'mat_number'=>[ 'name'=>"Material Number", 'type'=>'TextSel', 'api'=>'mnumber', 'full'=>true, 'val'=>['material_group','material_desc'], 'share'=>['material_desc'=>0,'material_group'=>0,'uoms'=>['unit_measurement','unit_measurement_desc']],'req'=> true ],
            'short_text'=>[ 'name'=>'Short Text', 'type'=>'Reference', 'full'=>true, 'key'=>'mat_number', 'val'=>'material_desc'],
            'mat_group'=>[ 'name'=>"Material Group", 'type'=>'Reference', 'key'=>'mat_number', 'val'=>'material_group'],
            '6'=>[ 'name'=>"Unit of Measure", 'type'=>'Reference', 'key'=>'mat_number', 'val'=>'uoms'],
            '7'=>[ 'name'=>"Delivery Date", 'type'=>'Date', 'def'=>0, 'req'=> false ],
            '5'=>[ 'name'=>"Quantity", 'type'=>'Number', 'req'=> true ],
            '8'=>[ 'name'=>"Unit Price", 'type'=>'Number', 'req'=> false ],
            'total'=>[ 'name'=>"Total", 'type'=>'Number', 'req'=> false ],
            'itext'=>[ 'name'=>"Item Text", 'type'=>'TextArea', 'req'=> false , 'full'=> true],
            // '9'=>[ 'name'=>"Valuation Price", 'type'=>'Number', 'req'=> false ],
            // '10'=>[ 'name'=>"Price Unit", 'type'=>'Number', 'req'=> false ],
            'item_category'=>[ 'name'=>"Item Category", 'type'=>'Select', 'api'=>'icategory', 'share'=>'item_category', 'val'=>['item_category','item_category_desc'], 'req'=> true ],
            '12'=>[ 'name'=>"Account Assignment", 'type'=>'Select', 'api'=>'assign', 'share'=>'account', 'val'=>['account','account_desc'], 'req'=> true ],
            '13'=>[ 'name'=>"Package Number", 'type'=>'String', 'req'=> true ],
            '14'=>[ 'name'=>"Currency", 'type'=>'TextSel', 'api'=>'currency', 'val'=>['currency','currency_desc'], 'req'=> true ],
            'reqdate'=>[ 'name'=>"Request Date", 'type'=>'Date', 'def'=>0, 'full'=>true, 'req'=> false ],


            'budget_version_code'=>[ 'if'=>['item_category',3,false], 'name'=>"GL Account", 'type'=>'Select', 'api'=>'glaccount', 'val'=>['account','account_desc'], 'req'=> true],
            'budget'=>[ 'if'=>['item_category',3,false], 'name'=>"Cost Center", 'type'=>'Select', 'api'=>'costcenter', 'val'=>['name','name'], 'req'=> true],
            'budget_name'=>[ 'if'=>['item_category',3,false], 'name'=>'Internal Order', 'type'=>'Select', 'full'=>true, 'api'=>'internal', 'val'=>['name','name'], 'req'=> false],
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
            :column="$column"
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
