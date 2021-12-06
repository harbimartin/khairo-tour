@extends('index')

@section('content')
    <?php
        $column_table = json_encode([
            'period'=>[ 'name'=>"Periode", 'type'=>'String'],
            'desc'=>[ 'name'=>"Deskripsi", 'type'=>'String'],
            'divisi'=>[ 'name'=>"Divisi", 'type'=>'String'],
            'act'=>[ 'name'=>"View", 'type'=>'Direct', 'url'=>'pengalihan_anggaran'],
        ]);
        $data_table = json_encode([
            [
                'period' => 2021,
                'desc' => 'Anggaran Tahun 2021',
                'divisi' => "Accounting Division",
            ],
            [
                'period' => 2021,
                'desc' => 'Anggaran Tahun 2021',
                'divisi' => "Business Development Division"
            ]
        ]);
    ?>
    <x-table
        :column="$column_table"
        :datas="$data_table"
    ></x-table>
@endsection
