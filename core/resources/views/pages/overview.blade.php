@extends('index')
@section('content')
    <?php
        $column_table = json_encode([
            'budget_date'=>[ 'name'=>"Date", 'type'=>"Date"],
            'budget_code'=>[ 'name'=>"Code", 'type'=>"String"],
            'doc_types'=>[ 'name'=>"Document Type", 'type'=>"SString", 'child'=>'doc_type_desc'],
            'budget_versions'=>[ 'name'=>"Budget Version", 'type'=>'SString', 'child'=>'budget_version_code'],
            'items_count'=>['name'=>'Jumlah<br>Item', 'type'=>'String', 'align'=>'center'],
            'budget_status'=>['name'=>'Status', 'type'=>'State'],
            'act'=>[ 'name'=>"Action", 'type' => 'Edit', 'header'=>['pengajuan','hid'], 'if'=>['budget_status', 'Draft', true]]
        ]);
    ?>
    {{-- {{$data[0]}} --}}
    <x-table
        :datef="true"
        :column="$column_table"
        :datas="$data"
    >
    </x-table>
@endsection
