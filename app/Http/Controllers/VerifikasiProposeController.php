<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetStatus;
use Illuminate\Http\Request;

class VerifikasiProposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if ($length = $request->el)
            $length = 10;
        $data = [];
        if ($request->hid){
            $header = Budget::find($request->hid);
            // if ($header->budget_versions->division_id != $_SESSION['ebudget_division_id'])
            //     return "Maaf kamu tidak bisa mengakses Laman ini";
        }else
            return redirect(url('/verifikasi'));
        $all = $this->karyawanAll();
        $level = $header->getLevelVerify();
        $select = [
            'user_5'=>[],
            'user_6'=>[],
            'user_7'=>[],
            'user_8'=>[],
        ];
        foreach($all as $val){
            for($i = $val['position_level']; $i>=5; $i--){
                array_push($select['user_'. $i], $val);
            }
        }
        // return $select;
        return view('pages.verifikasi.vpropose', [ 'data' => $data , 'level'=>$level, 'total'=>$header->getTotalVerify(),'header'=>$header, 'select'=>$select, 'error'=>$error]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // return $request->toArray();
        $budget = Budget::find($request->hid);
        $level = $budget->getLevelVerify();
        if ($budget){
            if ($budget->budget_status == 'Verification'){
                for($i = $level; $i <= 8; $i++){
                    if ($i == $level){
                        $this->notifKFA(
                            96,//$request['uid'.$i]
                            $budget
                        );
                        // if (!isset($res->data))
                        //     return json_encode($res);
                        $body = array(
                            $request['uid'.$i],
                            $_SESSION['ebudget_id']
                        );
                        $user_detail = $this->getUser($body);
                        $data = [
                            "name"=>$user_detail[$request['uid'.$i]]['nama'],
                            "intro" => "Permohonan persutujuan verifikasi Memo Realisasi Anggaran dengan rincian sebagai berikut :",
                            "table" => [
                                "Kode" => $budget->budget_code,
                                "Tanggal" => $budget->budget_date,
                                "Tipe Dokumen" => $budget->doc_types->doc_type_desc,
                                "Catatan Header" => $budget->note_header,
                                "Versi" => $budget->budget_versions->budget_name,
                                "Status" => $budget->budget_status,
                            ],
                            "close" => "Dimohon untuk segera membuka web E-Budgeting untuk melakukan persetujuan.",
                            "link" => url('/persetujuan'),
                            "pemohon" => $user_detail[$_SESSION['ebudget_id']]['nama']
                        ];
                        $this->send_email($request['ue'.$i], $user_detail[$request['uid'.$i]]['nama'], "Usulan Verifikasi : Memo Realisasi Anggaran No.".$budget->budget_code, $data);
                    }
                    BudgetStatus::create([
                        't_budget_id' => $budget->id,
                        'budget_position_user_id' => $request['ttd'.$i],
                        'user_id' => $request['uid'.$i],
                        'user_email' => $request['ue'.$i],
                        'budget_status' => null,
                        'tgl_status' => null,
                        'status_ref' => $i,//$request['ttd'.$i],
                        'status_active' => $i == $level ? 1:0
                    ]);
                }
                $budget->update([
                    'budget_status'=>'Verification - Proposed',
                    'verified' => now(),
                    'verified_by' => $_SESSION['ebudget_id']
                ]);
            }
            return redirect(url('/').'/verifikasi');
            // }
            // return 'nacawc';
        }
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
