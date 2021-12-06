@extends('pages.masterdata', ['tab'=>'material'])
@section('md_content')
    <?php
        $title = "Master Material";
        $column = json_encode([
            'material'=>[ 'name'=>"Kode", 'type'=>'String', 'req'=> true ],
            'material_type'=>[ 'name'=>"Tipe", 'type'=>'String', 'req'=> true ],
            'plant'=>[ 'name'=>"Plant", 'type'=>'String', 'req'=> true ],
            'sloc'=>[ 'name'=>"Sloc", 'type'=>'String', 'req'=> true ],
            'material_desc'=>[ 'name'=>"Desc", 'type'=>'String', 'full'=>true, 'req'=> true ],
            'uom'=>[ 'name'=>"Unit of Measure", 'type'=>'Select', 'api'=>'umeasure', 'val'=>['unit_measurement','unit_measurement_desc'], 'req'=> true ],
            'material_group'=>[ 'name'=>"Material Group", 'type'=>'String', 'req'=> true ],
            'old_number'=>[ 'name'=>"Old Number", 'type'=>'String', 'req'=> true ],
            'mrp_type'=>[ 'name'=>"MRP Type", 'type'=>'String', 'req'=> true ],
            'avail_check'=>[ 'name'=>"Avail Check", 'type'=>'String', 'req'=> true ],
            'profit_center'=>[ 'name'=>"Profit Center", 'type'=>'String', 'req'=> true ],
            'val_class'=>[ 'name'=>"Val Class", 'type'=>'String', 'req'=> true ],
            'costing_lot_size'=>[ 'name'=>"Costing Lot Size", 'type'=>'Number', 'req'=> true ],
            'price_ctrl' => [ 'name'=>"Price Control", 'type'=>'String', 'req'=>true],
            'per' => [ 'name'=>"Per", 'type'=>'Number', 'req'=>true],
            'moving_price' => [ 'name'=>"Moving Price", 'type'=>'Number', 'req'=>true],
            'order_text' => [ 'name'=>"Order Text", 'type'=>'String', 'full'=>true, 'req'=>true],

        ]);
        $column_table = json_encode([
            'material'=>[ 'name'=>"Kode", 'type'=>'String'],
            'material_type'=>[ 'name'=>"Tipe", 'type'=>'String'],
            'plant'=>[ 'name'=>"Plant", 'type'=>'String'],
            'sloc'=>[ 'name'=>"Sloc", 'type'=>'String'],
            'material_desc'=>[ 'name'=>"Desc", 'type'=>'String'],
            'uoms'=>[ 'name'=>"UoM", 'type'=>'SString', 'child'=>'unit_measurement','full'=>true],
            'material_group'=>[ 'name'=>"Material Group", 'type'=>'String'],
            'old_number'=>[ 'name'=>"Old Number", 'type'=>'String'],
            'mrp_type'=>[ 'name'=>"MRP Type", 'type'=>'String', 'req'=> true ],
            'avail_check'=>[ 'name'=>"Avail Check", 'type'=>'String'],
            'profit_center'=>[ 'name'=>"Profit Center", 'type'=>'String'],
            'val_class'=>[ 'name'=>"Val Class", 'type'=>'String'],
            'costing_lot_size'=>[ 'name'=>"Costing Lot Size", 'type'=>'Number'],
            'price_ctrl' => [ 'name'=>"Price Control", 'type'=>'String'],
            'per' => [ 'name'=>"Per", 'type'=>'Number'],
            'moving_price' => [ 'name'=>"Moving Price", 'type'=>'Number'],
            'order_text' => [ 'name'=>"Order Text", 'type'=>'String', 'full'=>true],
            'state'=>[ 'name'=>"Status", 'type'=>'State'],
            'status'=>[ 'name'=>"Aktifkan", 'type'=>'Toggle'],
            'act'=>[ 'name'=>"Action", 'type' => 'Edit' ]
        ]);
        $url = 'jejeje';
    ?>
    @isset(request()->id)
        <x-update
            :id="request()->id"
            :title="$title"
            :column="$column"
            :select="$select"
            :url="$url"
            :data="$data"
            :error="$error"
        ></x-update>
    @else
        <x-add-record
            :title="$title"
            :column="$column"
            :select="$select"
            :url="$url"
        ></x-add-record>
        <x-table
            :column="$column_table"
            :datas="$data"
            :import="true"
        ></x-table>
    @endisset
@endsection
