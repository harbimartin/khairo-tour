@extends('pages.pengajuan', ['tab'=>'service'])
@section('md_content')
    <?php
        $title = "Service";
        // echo request()->iid;return;
        $column = [
            // 'budget_version_code'=>[ 'name'=>"Service Line", 'type'=>'Number', 'req'=> true ],
            'price_proposed'=>[ 'name'=>"Unit Price", 'type'=>'Number', 'count'=>'total', 'req'=> false ],
            'currency'=>[ 'name'=>"Currency", 'type'=>'TextSel', 'api'=>'currency', 'val'=>['currency','currency_desc'], 'req'=> true, 'def'=>84],
            'qty_proposed'=>[ 'name'=>"Quantity", 'type'=>'Number', 'count'=>'total', 'req'=> true, 'def'=>1],
            'total'=>[ 'name'=>"Total", 'type'=>'Total', 'money'=>true , 'from'=>['price_proposed', 'qty_proposed']],

            'short_text'=>[ 'name'=>'Short Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
            'unit_qty'=>[ 'name'=>"Unit of Measure", 'type'=>'TextSel', 'api'=>'umeasure', 'val'=>['unit_measurement','unit_measurement_desc'], 'def'=>17],

            'gl_account'=>[ 'name'=>"GL Account", 'type'=>'Select', 'api'=>'glaccount', 'val'=>['gl_account','gl_account_desc'], 'req'=> true ],
            'cost_center'=>[ 'name'=>"Cost Center", 'type'=>'Select', 'api'=>'costcenter', 'val'=>['cost_center','cost_center_desc'], 'req'=> false ],
            'internal_order'=>[ 'name'=>'Internal Order', 'type'=>'Select', 'api'=>'internal', 'val'=>['io_code','io_date'], 'req'=> false, 'class' => ($iselect['account_assignment'] !=1 ? 'hidden':'')],
            'seq_no'=>[ 'type'=>'Static', 'def'=> (is_array($data) ? 10+sizeof($data)*10 : 0), 'class'=>'hidden'],
            't_budget_item_id'=>[ 'type'=>'Static', 'def'=> request()->iid, 'class'=>'hidden'],
            'hid'=>[ 'type'=>'Static', 'def'=> request()->hid, 'class'=>'hidden'],
        ];
        if (!request()->id)
            $column['item'] = [ 'name'=>"Item", 'type'=>'Select', 'api'=>'items', 'val'=>['material_group','short_text'], 'direct'=>'hid='.request()->hid.'&iid', 'full'=>true, 'req'=> true, 'def'=>request()->iid];
        $column = json_encode($column);
        $column_table = [
            'seq_no'=> [ 'name'=>"Service<br>Line", 'type'=>'String', 'align'=>'center'],
            'qty_proposed'=>[ 'name'=>"Quantity", 'type'=>'String'],
            'short_text'=>[ 'name'=>"Short Text", 'type'=>'String'],
            'gl_accounts'=>[ 'name'=>"GL Account", 'type'=>'SString', 'child'=>'gl_account_desc'],
            'cost_centers'=>[ 'name'=>"Cost Center", 'type'=>'SString', 'child'=>'cost_center_desc'],
            'edit'=>[ 'name'=>"Edit", 'type'=>'Edit', 'header'=> [Request::url(), 'id', '&hid='.request()->hid]],
            'delete'=>[ 'name'=>"Delete", 'type'=>'Delete'],
        ];
        if ($iselect['account_assignment'] ==1)
            $column_table['internal_orders'] = [ 'name'=>"IO", 'type'=>'SString', 'child'=>'io_code'];

        $column_table = json_encode($column_table);
        $url = 'jejeje';
    ?>
    @isset(request()->id)
        <x-update
            :column="$column"
            :title="$title"
            :data="$data"
            :select="$select"
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
