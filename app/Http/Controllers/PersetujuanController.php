<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if ($length = $request->el)
            $length = 10;
        $data = json_encode([
            [
                'id'=>1,
                'nama'=>'Anggaran 1',
                'budget'=>'1000000000',
                'status'=>'Proposed'
            ],
            [
                'id'=>2,
                'nama'=>'Anggaran 2',
                'budget'=>'2000000000',
                'status'=>'Proposed'
            ],
            [
                'id'=>3,
                'nama'=>'Anggaran 3',
                'budget'=>'3123123',
                'status'=>'Proposed'
            ],
        ]);
        $select = [];
        // if ($request->id)
        //     $data = BudgetVersion::where('id',$request->id)->with(['period', 'division', 'type'])->first();
        // else{
        //     $data = BudgetVersion::latest('id')->with(['period', 'division', 'type'])->get();//->paginate($length);
        //     foreach($data as $a){
        //         $a['state'] = $a['status'] ? 'AKTIF' : 'NON-AKTIF';
        //     }
        // }
        if ($request->id){
            $data = $this->pr_data();
            return view('pages.persetujuan.list', [ 'data' => $data , 'select'=>$select, 'error'=>$error]);
        }else
            return view('pages.persetujuan', [ 'data' => $data , 'select'=>$select, 'error'=>$error]);
    }
    public function pr_data(){
        $data = (object)[
            'no_mra'=>1150004008,
            'text_header'=>'RENCANA ANGGARAN BIAYA INTEGRASI eBUDDGETING # SAP PT KRAKATAU BANDAR SAMUDERA (UNPLANNED)',
            'items' => [
                [
                    'id'=>1,
                    'no_item'=>10,
                    'desc'=>'Integrasi Web e Budgetting SAP',
                    'spec'=>'RENCANA ANGGARAN BIAYA INTEGRASI eBUDDGETING # SAP PT KRAKATAU BANDAR SAMUDERA (UNPLANNED)',
                    'deliv'=>'2022-02-28',
                    'pgr'=>['id'=>1, 'code'=>'P10'],
                    'qty'=>1,
                    'uom'=>['id'=>1, 'code'=>'AU'],
                    'cur'=>['id'=>1, 'code'=>'IDR'],
                    'eprice'=>498950000,
                    'uprice'=>1,
                    'assign'=>[
                        'id'=>1,
                        'gla'=>['id'=>1, 'no'=>5101112, 'title'=>'Maintenance Expenses', 'point'=>'Others'],
                        'cc'=>['id'=>1, 'no'=>232100, 'division'=>'Div TI & SM'],
                        'io'=>null
                    ],
                    'service'=>[
                        [
                            'id'=>1,
                            'no'=>10,
                            'desc'=>'Jasa Develop di SAP System',
                            'qty'=>1,
                            'uom'=>['id'=>2, 'code'=>'PAC'],
                            'cur'=>['id'=>1, 'code'=>'IDR'],
                            'eprice'=>340600000,
                        ],
                        [
                            'id'=>2,
                            'no'=>20,
                            'desc'=>'Jasa Develop di iFace System',
                            'qty'=>1,
                            'uom'=>['id'=>2, 'code'=>'PAC'],
                            'cur'=>['id'=>1, 'code'=>'IDR'],
                            'eprice'=>158350000,
                        ],
                    ]
                ],
                [
                    'id'=>2 ,
                    'no_item'=>20,
                    'desc'=>'Integrasi KIP Single Window',
                    'spec'=>'RENCANA ANGGARAN BIAYA INTEGRASI KIP Single Window # SAP PT KRAKATAU BANDAR SAMUDERA (UNPLANNED)',
                    'deliv'=>'2022-03-28',
                    'pgr'=>['id'=>2, 'code'=>'P20'],
                    'qty'=>1,
                    'uom'=>['id'=>1, 'code'=>'AU'],
                    'cur'=>['id'=>1, 'code'=>'IDR'],
                    'eprice'=>250000000,
                    'uprice'=>1,
                    'assign'=>[
                        'id'=>1,
                        'gla'=>['id'=>1, 'no'=>5101112, 'title'=>'Maintenance Expenses', 'point'=>'Others'],
                        'cc'=>['id'=>1, 'no'=>232100, 'division'=>'Div TI & SM'],
                        'io'=>null
                    ],
                    'service'=>[
                        [
                            'id'=>1,
                            'no'=>10,
                            'desc'=>'Jasa Develop di Digital Cabinet',
                            'qty'=>1,
                            'uom'=>['id'=>2, 'code'=>'PAC'],
                            'cur'=>['id'=>1, 'code'=>'IDR'],
                            'eprice'=>120600000,
                        ],
                        [
                            'id'=>2,
                            'no'=>20,
                            'desc'=>'Jasa Develop di iFace System',
                            'qty'=>1,
                            'uom'=>['id'=>2, 'code'=>'PAC'],
                            'cur'=>['id'=>1, 'code'=>'IDR'],
                            'eprice'=>128350000,
                        ],
                    ]
                ]
            ]
        ];
        $total = 0;
        foreach($data->items as $key => $item){
            $data->items[$key]['amount'] = $count = $item['eprice'] * $item['uprice'];
            $total += $count;
            foreach($item['service'] as $keys => $iteme){
                $data->items[$key]['service'][$keys]['amount'] = $iteme['eprice'] * $item['uprice'];
            }
        }
        $data->total = $total;
        return $data;
    }
    public function purchase_requisitions(){
        return $this->resSuccess(
            'Purchase Requisitions',$this->pr_data()
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
