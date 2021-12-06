@extends('index')
@section('content')
    <?php
        $column_table = json_encode([
            'budget_date'=>[ 'name'=>"Date", 'type'=>"Date"],
            'budget_code'=>[ 'name'=>"Code", 'type'=>"String"],
            'doc_type_desc'=>[ 'name'=>"Document Type", 'type'=>"String"],
            'note_header'=>[ 'name'=>"Header", 'type'=>"String"],
            'name'=>[ 'name'=>"Divisi", 'type'=>"String"],
            'total'=>['name'=>'Total', 'type'=>'Money', 'align'=>'center'],
            // 'doc_types'=>[ 'name'=>"Document Type", 'type'=>"SString", 'child'=>'doc_type_desc'],
            // 'budget_versions'=>[ 'name'=>"Budget Version", 'type'=>'SString', 'child'=>'budget_version_code'],
            // 'items_count'=>['name'=>'Jumlah<br>Item', 'type'=>'String', 'align'=>'center'],
            'budget_status'=>['name'=>'Status', 'type'=>'State'],
            'act'=>[ 'name'=>"Action", 'type' => 'Edit' ],
        ]);
    ?>
    <x-table
        :datef="true"
        :column="$column_table"
        :datas="$data"
    ></x-table>
@endsection
