@extends('index')
@section('content')
    <?php
        $column_table = json_encode([
            'budget_date'=>[ 'name'=>"Date", 'type'=>"Date"],
            'budget_code'=>[ 'name'=>"Code", 'type'=>"String"],
            'doc_types'=>[ 'name'=>"Document Type", 'type'=>"SString", 'child'=>'doc_type_desc'],
            'note_header'=>[ 'name'=>"Header", 'type'=>"String"],
            'items_count'=>['name'=>'Jumlah<br>Item', 'type'=>'String', 'align'=>'center'],
            'budget_status'=>['name'=>'Status', 'type'=>'State'],
            'act'=>['name'=>"Action", 'type' => 'Edit'],
        ]);
    ?>
    {{-- {{$data[0]}} --}}
    <x-table
        :datef="true"
        :column="$column_table"
        :datas="$data"
    ></x-table>
@endsection
