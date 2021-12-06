@extends('pages.pengajuan', ['tab'=>'item'])
@section('md_content')
    <?php
        $title = "Item";
        // echo json_encode($select['costcenter']);return;
        $column = json_encode([
            'item_category'=>[ 'name'=>"Item Category", 'type'=>'Select', 'api'=>'icategory', 'share'=>'item_category', 'val'=>['item_category','item_category_desc'], 'full'=> true ],
            // '0'=>[ 'name'=>"Purchase Requisition Item", 'type'=>'String', 'full'=>true, 'req'=> true ],
            'purchase_group'=>[ 'name'=>"Purchasing Group", 'type'=>'Select', 'api'=>'pgroup', 'val'=>['purchase_group','purchase_group_desc'], 'req'=> true ],

                'mat_number'=>[ 'if'=>['item_category',3,false], 'name'=>"Material Number", 'type'=>'TextSel', 'api'=>'mnumber', 'full'=>true, 'val'=>['material_group','material_desc'], 'share'=>['material_desc'=>0,'material_group'=>0,'uom'=>0,'uoms'=>['unit_measurement','unit_measurement_desc']],'req'=> true ],
                'short_text'=>[ 'if'=>['item_category',3,false], 'name'=>'Short Text', 'type'=>'Reference', 'full'=>true, 'key'=>'mat_number', 'val'=>'material_desc'],
                'material_group'=>[ 'if'=>['item_category',3,false], 'name'=>"Material Group", 'type'=>'Reference', 'key'=>'mat_number', 'val'=>'material_group'],
                '__uom'=>[ 'if'=>[ 'item_category',3,false], 'name'=>"Unit of Measure", 'type'=>'Reference', 'key'=>'mat_number', 'val'=>'uoms'],
                'uom'=>['type'=>'Reference', 'key'=>'mat_number', 'val'=>'mat_number', 'val'=>'uom', 'class'=>'hidden'],

                '_short_text'=>[ 'if'=>['item_category',3,true], 'name'=> 'Short Text', 'type'=>'String', 'full'=>true ,'class'=>'hidden'],
                '_material_group'=>[ 'if'=>['item_category',3,true], 'name'=>"Material Group", 'type'=>'Select', 'api'=>'mgroup', 'val'=>['material_group'] ,'class'=>'hidden'],
                '_uom'=>[ 'if'=>[ 'item_category',3,true], 'name'=>"Unit of Measure", 'type'=>'TextSel', 'api'=>'umeasure', 'val'=>['unit_measurement','unit_measurement_desc'] ,'class'=>'hidden', 'def'=>17],

            'delivery_date_exp'=>[ 'name'=>"Delivery Date", 'type'=>'Date', 'def'=>7, 'full'=>true, 'req'=> false ],
            'price_unit'=>[ 'name'=>"Unit Price", 'type'=>'Number', 'count'=>'total', 'req'=> false ],
            'currency'=>[ 'name'=>"Currency", 'type'=>'TextSel', 'api'=>'currency', 'val'=>['currency','currency_desc'], 'req'=> true, 'def'=>84],
            'unit_qty'=>[ 'name'=>"Quantity", 'type'=>'Number', 'count'=>'total', 'req'=> true, 'def'=>1],
            'total'=>[ 'name'=>"Total", 'type'=>'Total', 'money'=>true , 'from'=>['price_unit', 'unit_qty']],
            'note_item'=>[ 'name'=>"Item Text", 'type'=>'TextArea', 'req'=> false , 'full'=> true],
            'account_assignment'=>[ 'name'=>"Account Assignment", 'type'=>'Select', 'api'=>'assign', 'share'=>'account', 'val'=>['account','account_desc'], 'req'=> true ],
            'package_no'=>[ 'name'=>"Package Number", 'type'=>'String', 'req'=> true ],
            'request_date'=>[ 'name'=>"Request Date", 'type'=>'Date', 'def'=>0, 'full'=>true, 'req'=> false ],
            'gl_account'=>[ 'if'=>['item_category',3,false], 'name'=>"GL Account", 'type'=>'Select', 'api'=>'glaccount', 'val'=>['gl_account','gl_account_desc'], 'req'=> true],
            'cost_center'=>[ 'if'=>['item_category',3,false], 'name'=>"Cost Center", 'type'=>'Select', 'api'=>'costcenter', 'val'=>['cost_center','cost_center_desc'], 'req'=> true],
            'internal_order'=>[ 'if'=>['item_category',3,false, 'account_assignment', 1, true], 'name'=>'Internal Order', 'type'=>'Select', 'full'=>true, 'api'=>'internal', 'val'=>['io_code','io_date'], 'req'=> false],
            'seq_no'=>[ 'type'=>'Static', 'def'=> 10+sizeof($data)*10, 'class'=>'hidden'],
            't_budget_id'=>[ 'type'=>'Static', 'def'=> request()->hid, 'class'=>'hidden'],
        ]);
        $column_table = json_encode([
            'seq_no'=> [ 'name'=>"Service<br>Line", 'type'=>'String'],
            'purchase_groups'=>[ 'name'=>"Purchase Group", 'type'=>'SString', 'child'=>'purchase_group_desc'],
            'item_categories'=>[ 'name'=>"Item Category", 'type'=>'SString', 'child'=>'item_category_desc'],
            'material_group'=>[ 'name'=>"Material Group", 'type'=>'String'],
            'short_text'=>[ 'name'=>"Short Text", 'type'=>'String'],
            'request_date'=>[ 'name'=>"Request Date", 'type'=>'Date'],
            'package_no'=>[ 'name'=>"Package Number", 'type'=>'String'],
            'item_status'=>[ 'name'=>"Status", 'type'=>'State']
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
