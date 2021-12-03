@extends('pages.verifikasi', ['tab'=>'item'])
@section('md_content')
        <?php
        $title = "Item";
        // echo json_encode($select['costcenter']);return;
        $column = json_encode([
            'item_category'=>[ 'name'=>"Item Category", 'type'=>'SString', 'share'=>'item_category', 'by'=>'item_categories' , 'child'=>['item_category','item_category_desc'], 'full'=> true ],
            'purchase_group'=>[ 'name'=>"Purchasing Group", 'type'=>'SString', 'by'=>'purchase_groups', 'child'=>['purchase_group','purchase_group_desc'], 'req'=> true ],
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
            'price_proposed'=>[ 'name'=>"Unit Price", 'type'=>'Number', 'count'=>'total', 'req'=> false ],
            'currency'=>[ 'name'=>"Currency", 'type'=>'TextSel', 'api'=>'currency', 'val'=>['currency','currency_desc'], 'req'=> true, 'def'=>84],
            'qty_proposed'=>[ 'name'=>"Quantity", 'type'=>'Number', 'count'=>'total', 'req'=> true, 'def'=>1],
            'total'=>[ 'name'=>"Total", 'type'=>'Total', 'money'=>true , 'from'=>['price_proposed', 'qty_proposed']],
            'note_item'=>[ 'name'=>"Item Text", 'type'=>'TextArea', 'req'=> false , 'full'=> true],
            'account_assignment'=>[ 'name'=>"Account Assignment", 'type'=>'SString', 'share'=>'account', 'by'=>'accounts', 'child'=>['account','account_desc'], 'req'=> true ],
            'package_no'=>[ 'name'=>"Package Number", 'type'=>'String', 'req'=> true ],
            'request_date'=>[ 'name'=>"Request Date", 'type'=>'Date', 'def'=>0, 'full'=>true, 'req'=> false ],
            'gl_account'=>[ 'if'=>['item_category',3,false], 'name'=>"GL Account", 'type'=>'Select', 'api'=>'glaccount', 'val'=>['gl_account','gl_account_desc'], 'req'=> true],
            'cost_center'=>[ 'if'=>['item_category',3,false], 'name'=>"Cost Center", 'type'=>'Select', 'api'=>'costcenter', 'val'=>['cost_center','cost_center_desc'], 'req'=> true],
            'internal_order'=>[ 'if'=>['item_category',3,false, 'account_assignment', 1, true], 'name'=>'Internal Order', 'type'=>'Select', 'full'=>true, 'api'=>'internal', 'val'=>['io_code','io_date'], 'req'=> false],
            'seq_no'=>[ 'type'=>'Static', 'def'=> $next_seq, 'class'=>'hidden'],
            'package_no'=>[ 'type'=>'Static', 'def'=> $next_package, 'class'=>'hidden'],
            't_budget_id'=>[ 'type'=>'Static', 'def'=> request()->hid, 'class'=>'hidden'],
            'price_verified'=>[ 'if'=>[ 'item_category',3,false], 'name'=>"Verified Price", 'type'=>'Number', 'force'=>true, 'req'=> false, 'full'=>true],
        ]);
        $column_table = json_encode([
            'seq_no'=> [ 'name'=>"Service<br>Line", 'type'=>'String'],
            // 'purchase_groups'=>[ 'name'=>"Purchase Group", 'type'=>'SString', 'child'=>'purchase_group_desc'],
            'item_categories'=>[ 'name'=>"Item Category", 'type'=>'SString', 'child'=>'item_category_desc'],
            // 'material_groups'=>[ 'name'=>"Material Group", 'type'=>'SString', 'child'=>'material_group'],
            'short_text'=>[ 'name'=>"Short Text", 'type'=>'String'],
            'request_date'=>[ 'name'=>"Request Date", 'type'=>'Date'],
            // 'package_no'=>[ 'name'=>"Package Number", 'type'=>'String'],
            'price_proposed'=>[ 'name'=>"Price Proposed", 'type'=>'Money'],
            'price_verified'=>[ 'name'=>"Price Verified", 'type'=>'Money'],
            'item_status'=>[ 'name'=>"Status", 'type'=>'State'],
            'edit'=>[ 'name'=>"Edit", 'type'=>'Edit', 'header'=> [Request::url(), 'id', '&hid='.request()->hid]],
            // 'delete'=>[ 'name'=>"Delete", 'type'=>'Delete'],
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
            :detail="true"
        >
            <button
                class="rounded border px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto mr-5 cursor-pointer text-white font-semibold"
                type="submit"
                name="__type"
                value="revised"
            > Update
            </button>
        </x-update>
        @else
        <x-table
            :column="$column_table"
            :datas="$data"
            :sort="false"
        ></x-table>
        @endisset
@endsection
