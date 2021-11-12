@extends('index')
@section('content')
    <?php
        $column_table = json_encode([
            'nama'=> [ 'name'=>"Name", 'type'=>'String'],
            'budget'=>[ 'name'=>"Amount", 'type'=>'Money'],
            'status'=>[ 'name'=>"Status", 'type'=>'State'],
            'act'=>[ 'name'=>"Action", 'type' => 'Edit' ]
        ]);
    ?>
    <x-table
        :datef="true"
        :column="$column_table"
        :datas="$data"
    ></x-table>
@endsection
