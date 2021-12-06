@extends('index')
@section('content')
    @isset(request()->id)
        <?php
            $column = json_encode([
                'name'=>[ 'name'=>"Receiver", 'type'=>'String', 'full'=>true],
                'receiver'=>[ 'name'=>"Email", 'type'=>'String', 'full'=>true],
                'title'=>[ 'name'=>"Title", 'type'=>'String', 'full'=>true],
                'error'=>[ 'name'=>"Error", 'type'=>'String', 'full'=>true],
                'view'=>[ 'name'=>"View", 'type'=>'String'],
                'status'=>[ 'name'=>"Status", 'type'=>'Boolean', 'val'=>['Gagal', 'Berhasil']],
                'created_at'=>[ 'name'=>"Created", 'type'=>'DateTime'],
                'updated_at'=>[ 'name'=>"Update", 'type'=>'DateTime']
            ]);
            foreach(json_decode($data['body']) as $object){
                $arrays[] =  (array) $object;
            }
        ?>
        <x-update
            title="Email Detail"
            :column="$column"
            :data="$data"
            :detail="true"
        >
        </x-update>
        {{-- @extends($data['view'], $arrays); --}}
    @else
        <?php
            $column_table = json_encode([
                'created_at'=>[ 'name'=>"Date", 'type'=>'DateTime'],
                'name'=>[ 'name'=>"Receiver", 'type'=>'String'],
                'receiver'=>[ 'name'=>"Email", 'type'=>'String'],
                'title'=>[ 'name'=>"Title", 'type'=>'String'],
                'error'=>[ 'name'=>"Error", 'type'=>'String'],
                'status'=>[ 'name'=>"Status", 'type'=>'Boolean', 'val'=>['Gagal', 'Berhasil']],
                'act'=>[ 'name'=>"Action", 'type'=>'Edit']
            ]);
        ?>
        <x-table
            :column="$column_table"
            :datas="$data"
        ></x-table>
    @endisset
@endsection
