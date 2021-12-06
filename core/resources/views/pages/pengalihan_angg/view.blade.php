@extends('index')
@section('content')
    <?php
        $column_table = json_encode([
            'no'=>[ 'name'=>"No", 'type'=>'String'],
            'kode'=>[ 'name'=>"Kode", 'type'=>'String'],
            'tipe'=>[ 'name'=>"Tipe", 'type'=>'String'],
            'nama'=>[ 'name'=>"Nama", 'type'=>'String'],
            'anggaran'=>[ 'name'=>"Anggaran", 'type'=>'String'],
            'available'=>[ 'name'=>"Available", 'type'=>'String'],
            'act'=>[ 'name'=>"Alihkan", 'type'=>"Post"],
        ]);
        $data_table = json_encode([
            [
                'no' => 1,
                'kode' => 'R-NP-115-15-001',
                'tipe' => "MRA Services",
                'nama' => "Biaya Labour Supply",
                'anggaran' => "1,862,796,981.00",
                'available' => "1,862,796,981.00",
            ]
        ]);
    ?>
    <x-table
        :column="$column_table"
        :datas="$data_table"
    ></x-table>
@endsection
