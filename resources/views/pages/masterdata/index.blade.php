@extends('pages.masterdata', ['tab'=>'index'])
@section('md_content')
    <?php
        $title = "Master Budget Version";
        $column = json_encode([
            'budget_version_code'=>[ 'name'=>"Name", 'type'=>'String', 'req'=> true ],
            'divisions_id'=>[ 'name'=>"Divisi", 'type'=>'Select', 'api'=>'division', 'val'=>['name'] , 'req'=> true ],
            'budget_period_id'=>[ 'name'=>"Budget Period", 'type'=>'Select', 'api'=>'budget_period', 'val'=>['budget_period','budget_period_desc'],  'req'=> true ],
            'budget_version_type'=>[ 'name'=>"Budget Type", 'type'=>'Select', 'api'=>'budget_type', 'val'=>['version_type'], 'req'=> true ],
            'budget_name'=>[ 'name'=>'Deskripsi Budget', 'type'=>'String', 'full'=>true, 'req'=> false ],
            'budget'=>[ 'name'=>"Amount Budget", 'type'=>'Number', 'full'=>true, 'req'=> false ],
        ]);
        $column_table = json_encode([
            'period'=>[ 'name'=>"Periode", 'type'=>'SString', 'child'=>'budget_period'],
            'division'=>[ 'name'=>"Divisi", 'type'=>'SString', 'child'=>'name'],
            'type'=>[ 'name'=>"Tipe Budget", 'type'=>'SString', 'child'=>'version_type'],
            'budget_version_code'=>[ 'name'=>"Kode", 'type'=>'String'],
            'budget_name'=>[ 'name'=>'Nama Budget', 'type'=>'String'],
            'budget'=>[ 'name'=>"Amount", 'type'=>'Money'],
            'state'=>[ 'name'=>"Status", 'type'=>'State'],
            'status'=>[ 'name'=>"Aktifkan", 'type'=>'Toggle'],
            'act'=>[ 'name'=>"Edit", 'type'=>'Edit'],
        ]);
        $url = 'jejeje';
    ?>
    @isset(request()->id)
        <x-update
            :id="request()->id"
            :title="$title"
            :column="$column"
            url="awdawd"
            :data="$data"
            :error="$error"
            :select="$select"
        ></x-update>
    @else
        <x-add-record
            :title="$title"
            :column="$column"
            :select="$select"
            :error="$error"
            url="/masterdata/add"
        ></x-add-record>
        <x-table
            :column="$column_table"
            :datas="$data"
        ></x-table>
    @endisset
@endsection
