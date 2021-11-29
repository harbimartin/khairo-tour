<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetStatus;
use App\BudgetStatusRpt;
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
        if ($request->id){
            $controller = new PengajuanController();
            $data = $controller->budget_detail($request, false);
            $budget_rpt = BudgetStatusRpt::where(['id'=>$request->id,'user_id' => $_SESSION['ebudget_id'], 'status_active'=>1])->first();
            if ($budget_rpt)
                return view('pages.persetujuan.list', [ 'data' => $data, 'error'=>$error, 'status_id'=>$budget_rpt->t_budget_status_id, 'purpose'=>'Propose']);
            else
                return redirect($request->url());
        }else{
            $data = BudgetStatusRpt::where('user_id',$_SESSION['ebudget_id'])->where('status_active', 1)->get();
            // return $data;
            // $data = Budget::latest('created')->where('budget_status', 'Proposed')->with(['doc_types','budget_versions'])->withCount('items')->get();
            return view('pages.persetujuan', [ 'data' => $data, 'error'=>$error]);
        }
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
    public function update(Request $request, $id){
        switch($request->type){
            case 'reject':
                $budget = Budget::find($id);
                $budget->update([
                    'budget_status'=>'Rejected',
                    'note_reject'=>$request->reason
                ]);
            break;
            case 'verifikasi':
                $budget = Budget::find($id);
                $budget->update([
                    'budget_status'=>'Verified',
                ]);

                // $admin_id = $budget->proposed_by;
                // $res = $this->notifKFA(
                //     $admin_id
                // , $budget);
                // if (!isset($res->data))
                //     return json_encode($res);
                // $body = array(
                //     $admin_id,
                //     $budget->proposed_by,
                //     $_SESSION['ebudget_id']
                // );
                // $user_detail = $this->getUser($body);
                // $data = [
                //     "name"=>$user_detail[$admin_id]['nama'],
                //     "intro" => "Permohonan verifikasi Memo Realisasi Anggaran dengan rincian sebagai berikut :",
                //     "table" => [
                //         "Kode" => $budget->budget_code,
                //         "Tanggal" => $budget->budget_date,
                //         "Tipe Dokumen" => $budget->doc_types->doc_type_desc,
                //         "Catatan Header" => $budget->note_header,
                //         "Versi" => $budget->budget_versions->budget_name,
                //         "Status" => $budget->budget_status,
                //     ],
                //     "close" => "Dimohon untuk segera membuka web E-Budgeting untuk melakukan verifikasi.",
                //     "link" => url('/persetujuan'),
                //     "pemohon" => $user_detail[$budget->proposed_by]['nama']
                // ];
                // $this->send_email($user_detail[$admin_id]['email'], $user_detail[$admin_id]['nama'], "Verifikasi : Memo Realisasi Anggaran No.".$budget->budget_code, $data);
            break;
        }
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
