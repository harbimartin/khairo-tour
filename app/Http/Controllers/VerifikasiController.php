<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetStatus;
use App\BudgetStatusRpt;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
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
            if ($data->budget_status=='Verification')
                return view('pages.persetujuan.list', [ 'data' => $data, 'error'=>$error, 'status_id'=>0 , 'purpose'=>'Verifikasi']);
            else
                return redirect($request->url());
        }else{
            $data = Budget::latest('created')->where('budget_status','Verification')->with(['doc_types'])->withCount('items')->get();
            return view('pages.verifikasi', [ 'data' => $data, 'error'=>$error]);
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
    public function update(Request $request, $id)
    {
        switch($request->type){
            case 'reject':
                $budget = Budget::find($id);
                $budget->update([
                    'budget_status'=>'Rejected',
                    'note_reject'=>$request->reason
                ]);
                $budget_status = BudgetStatus::where('t_budget_status_id',$request->status_id)->first();
                $budget_status->update([
                    'budget_status' => "Rejected",
                    'tgl_status' => now()
                ]);
            break;
            case 'verifikasi':
                $budget_status = BudgetStatus::where('t_budget_status_id',$request->status_id)->first();
                $budget = Budget::find($id);
                if ($budget_status->status_ref < 4){
                    $next_status = BudgetStatus::where('t_budget_status_id',$request->status_id + 1)->first();
                    $res = $this->notifKFA(
                        $next_status->user_id
                    , $budget);
                    if (!isset($res->data))
                        return json_encode($res);
                    $body = array(
                        $next_status->user_id,
                        $budget->proposed_by,
                        $_SESSION['ebudget_id']
                    );
                    $user_detail = $this->getUser($body);
                    $data = [
                        "name"=>$user_detail[$next_status->user_id]['nama'],
                        "intro" => "Permohonan persetujuan Memo Realisasi Anggaran dengan rincian sebagai berikut :",
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
                        "pemohon" => $user_detail[$budget->proposed_by]['nama']
                    ];
                    $this->send_email($next_status->user_email, $user_detail[$next_status->user_id]['nama'], "Persetujuan : Memo Realisasi Anggaran No.".$budget->budget_code, $data);
                    $budget_status->update([
                        'budget_status' => "Approved",
                        'tgl_status' => now(),
                        'status_active' => 0,
                    ]);
                    $next_status->update([
                        'status_active' => 1,
                    ]);
                }else{
                    $budget->update([
                        'budget_status'=>'Verification',
                    ]);
                    $budget_status->update([
                        'budget_status' => "Approved",
                        'tgl_status' => now(),
                        'status_active' => 0,
                    ]);
                    // BUAT ADMIN
                    $admin_id = 96;
                    $res = $this->notifKFA(
                        $admin_id
                    , $budget);
                    if (!isset($res->data))
                        return json_encode($res);
                    $body = array(
                        $admin_id,
                        $budget->proposed_by,
                        $_SESSION['ebudget_id']
                    );
                    $user_detail = $this->getUser($body);
                    $data = [
                        "name"=>$user_detail[$admin_id]['nama'],
                        "intro" => "Permohonan verifikasi Memo Realisasi Anggaran dengan rincian sebagai berikut :",
                        "table" => [
                            "Kode" => $budget->budget_code,
                            "Tanggal" => $budget->budget_date,
                            "Tipe Dokumen" => $budget->doc_types->doc_type_desc,
                            "Catatan Header" => $budget->note_header,
                            "Versi" => $budget->budget_versions->budget_name,
                            "Status" => $budget->budget_status,
                        ],
                        "close" => "Dimohon untuk segera membuka web E-Budgeting untuk melakukan verifikasi.",
                        "link" => url('/persetujuan'),
                        "pemohon" => $user_detail[$budget->proposed_by]['nama']
                    ];
                    $this->send_email($user_detail[$admin_id]['email'], $user_detail[$admin_id]['nama'], "Verifikasi : Memo Realisasi Anggaran No.".$budget->budget_code, $data);
                }
                break;
        }
        return redirect(request()->segment(count(request()->segments())-1));
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
