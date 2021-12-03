@extends('pages.pengajuan', ['tab'=>'item'])
@section('md_content')
    <?php
        $title = "Item";
        // echo json_encode($select['costcenter']);return;
        $column = json_encode([
            'item_category'=>[ 'name'=>"Item Category", 'type'=>'Select', 'api'=>'icategory', 'share'=>'item_category', 'val'=>['item_category','item_category_desc'], 'full'=> true ],
            // '0'=>[ 'name'=>"Purchase Requisition Item", 'type'=>'String', 'full'=>true, 'req'=> true ],
            'purchase_group'=>[ 'name'=>"Purchasing Group", 'type'=>'Select', 'api'=>'pgroup', 'val'=>['purchase_group','purchase_group_desc'], 'req'=> true ],
                'material_no'=>[ 'if'=>['item_category',3,false], 'name'=>"Material Number", 'type'=>'TextSel', 'api'=>'mnumber', 'full'=>true, 'val'=>['material','material_desc'], 'share'=>['material_desc'=>0,'material_group'=>0,'mgroups'=>['material_group'],'uom'=>0,'uoms'=>['unit_measurement','unit_measurement_desc']],'req'=> true ],
                'short_text'=>[ 'if'=>['item_category',3,false], 'name'=>'Short Text', 'type'=>'Reference', 'full'=>true, 'key'=>'material_no', 'val'=>'material_desc'],
                '__mgroup'=>[ 'if'=>[ 'item_category',3,false], 'name'=>"Material Group", 'type'=>'Reference', 'key'=>'material_no', 'val'=>'mgroups'],
                'material_group'=>[ 'type'=>'Reference', 'key'=>'material_no', 'val'=>'material_group', 'class'=>'hidden'],
                '__unit_qty'=>[ 'if'=>[ 'item_category',3,false], 'name'=>"Unit of Measure", 'type'=>'Reference', 'key'=>'material_no', 'val'=>'uoms'],
                'unit_qty'=>[ 'type'=>'Reference', 'key'=>'material_no', 'val'=>'uom', 'class'=>'hidden'],

                '_short_text'=>[ 'by'=> 'short_text', 'if'=>['item_category',3,true], 'name'=> 'Short Text', 'type'=>'String', 'full'=>true ,'class'=>'hidden'],
                '_material_group'=>[ 'by'=> 'material_group', 'if'=>['item_category',3,true], 'name'=>"Material Group", 'type'=>'Select', 'api'=>'mgroup', 'val'=>['material_group'] ,'class'=>'hidden'],
                '_unit_qty'=>[ 'by'=> 'unit_qty', 'if'=>[ 'item_category',3,true], 'name'=>"Unit of Measure", 'type'=>'TextSel', 'api'=>'umeasure', 'val'=>['unit_measurement','unit_measurement_desc'] ,'class'=>'hidden', 'def'=>17],

            'delivery_date_exp'=>[ 'name'=>"Delivery Date", 'type'=>'Date', 'def'=>7, 'full'=>true, 'req'=> false ],
            'price_proposed'=>[ 'if'=>[ 'item_category',3,false], 'name'=>"Unit Price", 'type'=>'Number', 'count'=>'total', 'req'=> false , 'def'=>0],
            'currency'=>[ 'name'=>"Currency", 'type'=>'TextSel', 'api'=>'currency', 'val'=>['currency','currency_desc'], 'req'=> true, 'def'=>84],
            'qty_proposed'=>[ 'name'=>"Quantity", 'type'=>'Number', 'count'=>'total', 'req'=> true, 'def'=>1],
            'total'=>[ 'if'=>[ 'item_category',3,false], 'name'=>"Total", 'type'=>'Total', 'money'=>true , 'from'=>['price_proposed', 'qty_proposed']],
            'note_item'=>[ 'name'=>"Item Text", 'type'=>'TextArea', 'req'=> false , 'full'=> true],
            'account_assignment'=>[ 'name'=>"Account Assignment", 'type'=>'Select', 'api'=>'assign', 'share'=>'account', 'val'=>['account','account_desc'], 'req'=> true ],
            'request_date'=>[ 'name'=>"Request Date", 'type'=>'Date', 'def'=>0, 'full'=>true, 'req'=> false ],
            'gl_account'=>[ 'if'=>['item_category',3,false], 'name'=>"GL Account", 'type'=>'Select', 'api'=>'glaccount', 'val'=>['gl_account','gl_account_desc'], 'req'=> true],
            'cost_center'=>[ 'if'=>['item_category',3,false], 'name'=>"Cost Center", 'type'=>'Select', 'api'=>'costcenter', 'val'=>['cost_center','cost_center_desc'], 'req'=> true, 'null'=>true],
            'internal_order'=>[ 'if'=>['item_category',3,false, 'account_assignment', 1, true], 'name'=>'Internal Order', 'type'=>'Select', 'full'=>true, 'api'=>'internal', 'val'=>['io_code','io_date'], 'req'=> false, 'null'=>true],
            'seq_no'=>[ 'type'=>'Static', 'def'=> $next_seq, 'class'=>'hidden'],
            'package_no'=>[ 'type'=>'Static', 'def'=> $next_package, 'class'=>'hidden'],
            't_budget_id'=>[ 'type'=>'Static', 'def'=> request()->hid, 'class'=>'hidden'],
        ]);
        $column_table = json_encode([
            'seq_no'=> [ 'name'=>"Service<br>Line", 'type'=>'String'],
            'purchase_groups'=>[ 'name'=>"Purchase Group", 'type'=>'SString', 'child'=>'purchase_group_desc'],
            'item_categories'=>[ 'name'=>"Item Category", 'type'=>'SString', 'child'=>'item_category_desc'],
            'short_text'=>[ 'name'=>"Short Text", 'type'=>'String'],
            'qty_proposed'=>[ 'name'=>"Quantity", 'type'=>'String'],
            'total_proposed'=>[ 'name'=>"Price", 'type'=>'Money'],
            'request_date'=>[ 'name'=>"Request Date", 'type'=>'Date'],
            // 'package_no'=>[ 'name'=>"Package Number", 'type'=>'String'],
            'item_status'=>[ 'name'=>"Status", 'type'=>'State'],
            'edit'=>[ 'name'=>"Edit", 'type'=>'Edit', 'header'=> [Request::url(), 'id', '&hid='.request()->hid]],
            'delete'=>[ 'name'=>"Delete", 'type'=>'Delete'],
        ]);
        $url = 'jejeje';
    ?>
    @isset(request()->id)
        <x-update
            :column="$column"
            :title="$title"
            :select="$select"
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
