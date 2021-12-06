<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetStatus;
use App\BudgetStatusRpt;
use App\XmlBudgetHeader;
use App\XmlBudgetItem;
use App\XmlBudgetService;
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
                return view('pages.persetujuan.list', [ 'data' => $data, 'error'=>$error, 'status_id'=>$budget_rpt->t_budget_status_id, 'purpose'=> ($budget_rpt->budget_status == 'Proposed' ? 'Approve' : 'Verifikasi')]);
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
        $request['id'] = $id;
        $this->update_exec($request, $_SESSION['ebudget_id'], false);
        return redirect(request()->segment(count(request()->segments())-1));
    }
    public function update_exec(Request $request, $user_id = null, $useNotif = false){
        if (!$user_id){
            if (!$user_id = $request->user_id){
                return $this->resFailed('404', 'Akun anda tidak ditemukan!');
            }
        }
        switch($request->type){
            case 'reject':
                $budget_status = BudgetStatus::where('t_budget_status_id',$request->status_id)->first();
                if (!$budget_status->status_active)
                    return $this->resFailed(400, 'Budget gagal di reject karena tidak aktif');
                $budget = Budget::find($request->id);
                $budget->update([
                    'budget_status'=>'Rejected',
                    'note_reject'=>$request->reason
                ]);
                $budget_status->update([
                    'budget_status' => "Rejected",
                    'tgl_status' => now()
                ]);
                return $this->resSuccess('Budget berhasil di '.$request->type, null);
            break;
            case 'verifikasi':
                $budget_status = BudgetStatus::where('t_budget_status_id',$request->status_id)->first();
                $budget = Budget::find($request->id);
                if (!$budget_status->status_active)
                    return $this->resFailed(400, 'Budget gagal di verifikasi karena tidak aktif');
                if ($request->api_token){
                    session_start();
                    $_SESSION['ebudget_token'] = $request->api_token;
                }
                if ($budget->budget_status == 'Proposed'){
                    if ($budget_status->status_ref < 4){
                        $next_status = BudgetStatus::where('t_budget_status_id',$request->status_id + 1)->first();
                        if ($useNotif){
                                $res = $this->notifKFA(
                                    $next_status->user_id
                                , $budget);
                            // if (!isset($res->data))
                            //     return json_encode($res);
                        }
                        $body = array(
                            $next_status->user_id,
                            $budget->proposed_by,
                            $user_id
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
                        return $this->resSuccess('Budget berhasil di '.$request->type, ['user_id'=>$next_status->user_id, 'budget'=>$budget]);
                    }else{
                        $budget->update([
                            'budget_status'=>'Verification',
                        ]);
                        $budget_status->update([
                            'budget_status' => "Approved",
                            'tgl_status' => now(),
                            'status_active' => 0,
                        ]);
                        $admin_id = 96;
                        if ($useNotif){
                            $res = $this->notifKFA(
                                $admin_id
                            , $budget);
                            // if (!isset($res->data))
                            //     return json_encode($res);
                        }
                        $body = array(
                            $admin_id,
                            $budget->proposed_by,
                            $user_id
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
                        return $this->resSuccess('Budget berhasil di '.$request->type, ['user_id'=>$admin_id, 'budget'=>$budget]);
                    }
                }else
                if ($budget->budget_status == 'Verification - Proposed'){
                    if ($budget_status->status_ref < 8){
                        $next_status = BudgetStatus::where('t_budget_status_id',$request->status_id + 1)->first();
                        if ($useNotif){
                            $res = $this->notifKFA(
                                $next_status->user_id
                            , $budget);
                            // if (!isset($res->data))
                            //     return json_encode($res);
                        }
                        $body = array(
                            $next_status->user_id,
                            $budget->proposed_by,
                            $user_id
                        );
                        $user_detail = $this->getUser($body);
                        $data = [
                            "name"=>$user_detail[$next_status->user_id]['nama'],
                            "intro" => "Permohonan persetujuan verifikasi Memo Realisasi Anggaran dengan rincian sebagai berikut :",
                            "table" => [
                                "Kode" => $budget->budget_code,
                                "Tanggal" => $budget->budget_date,
                                "Tipe Dokumen" => $budget->doc_types->doc_type_desc,
                                "Catatan Header" => $budget->note_header,
                                "Versi" => $budget->budget_versions->budget_name,
                                "Status" => $budget->budget_status,
                            ],
                            "close" => "Dimohon untuk segera membuka web E-Budgeting untuk melakukan persetujuan.",
                            "link" => url('/verifikasi'),
                            "pemohon" => $user_detail[$budget->proposed_by]['nama']
                        ];
                        $this->send_email($next_status->user_email, $user_detail[$next_status->user_id]['nama'], "Usulan Verifikasi : Memo Realisasi Anggaran No.".$budget->budget_code, $data);
                        $budget_status->update([
                            'budget_status' => "Approved",
                            'tgl_status' => now(),
                            'status_active' => 0,
                        ]);
                        $next_status->update([
                            'status_active' => 1,
                        ]);
                        return $this->resSuccess('Budget berhasil di '.$request->type, ['user_id'=>$next_status->user_id, 'budget'=>$budget]);
                    }else{
                        $admin_id = 96;
                        if ($useNotif){
                                $res = $this->notifKFA(
                                    $admin_id
                                , $budget);
                            // if (!isset($res->data))
                            //     return json_encode($res);
                        }
                        foreach($budget->services as $serve){
                            $serve->item_status = 'Approved';
                        }
                        foreach($budget->items as $item){
                            $item->item_status = 'Approved';
                        }
                        $budget->budget_status = 'Approved';
                        $budget->push();
                        $budget_status->update([
                            'budget_status' => "Approved",
                            'tgl_status' => now(),
                            'status_active' => 0,
                        ]);
                        $body = array(
                            $admin_id,
                            $budget->proposed_by,
                            $user_id
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
                        $this->send_email($user_detail[$admin_id]['email'], $user_detail[$admin_id]['nama'], "Usulan Verifikasi : Memo Realisasi Anggaran No.".$budget->budget_code, $data);
                        $now = gmdate("YmdHis", time()+25200);
                        $xmlobj = XmlBudgetHeader::where('id',$request->id)->first();
                        $xmls = '
                        <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <ZfmifPrReceive xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                                    <ImInput>
                                        <InformationIdentification>PR0001_'.$now.'</InformationIdentification>
                                        <DestinationCompanyCode>SAP</DestinationCompanyCode>
                                        <SenderCompanyCode>eBud</SenderCompanyCode>
                                        <CreatedDateAndTime>'.$now.'</CreatedDateAndTime>
                                        <Bsart>'.$xmlobj->doc_type.'</Bsart>
                                        <Txtsart>'.$xmlobj->note_header.'</Txtsart>
                                        <Freeuse1>-</Freeuse1>
                                        <Freeuse2>-</Freeuse2>
                                        <Freeuse3>-</Freeuse3>
                                        <PRItem>';
                                        foreach(XmlBudgetItem::where('t_budget_id',$request->id)->get() as $item){
                                        $xmls = $xmls.'
                                            <item>
                                            <Bnfpo>'.$item->BNFPO.'</Bnfpo>
                                            <Txtline>'.$item->note_item.'</Txtline>
                                            <Ekgrp>'.$item->purchase_group.'</Ekgrp>
                                            <Afnam>'.$xmlobj->name.'</Afnam>
                                            <Txz01>'.$item->short_text.'</Txz01>
                                            <Matnr>'.$item->material.'</Matnr>
                                            <Werks>KBS1</Werks>
                                            <Bednr>'.$xmlobj->budget_code.'</Bednr>
                                            <Matkl>'.$item->material_group.'</Matkl>
                                            <Menge>'.$item->qty_proposed.'</Menge>
                                            <Meins>'.$item->unit_measurement_comm.'</Meins>
                                            <Badat>'.date("d.m.Y", strtotime($xmlobj->created)).'</Badat>
                                            <Lfdat>'.date("d.m.Y", strtotime($item->delivery_date_exp)).'</Lfdat>
                                            <Preis>'.$item->price_verified.'</Preis>
                                            <Peinh>'.$item->price_unit.'</Peinh>
                                            <Pstyp>'.$item->item_category.'</Pstyp>
                                            <Knttp>'.$item->account.'</Knttp>
                                            <Infnr></Infnr>
                                            <Packno>'.$item->PACKNO.'</Packno>
                                            <Waers>'.$item->currency.'</Waers>
                                            <AccountAsign>
                                                 <item>
                                                     <Bnfpo>'.$item->BNFPO.'</Bnfpo>
                                                     <Sakto>'.$item->gl_account.'</Sakto>
                                                     <Kostl>'.$item->cost_center.'</Kostl>
                                                     <Aufnr>'.$item->io_code.'</Aufnr>
                                                 </item>
                                            </AccountAsign>';
                                            foreach(XmlBudgetService::where('t_budget_item_id',$item->id)->get() as $serv){
                                                $xmls = $xmls.'
                                                <ReqServices>
                                                    <item>
                                                        <Banfpo>'.$serv->BNFPO.'</Banfpo>
                                                        <Packno>'.$serv->PACKNO.'</Packno>
                                                        <Extrow>'.$serv->EXTROW.'</Extrow>
                                                        <Ktext1>'.$serv->short_text.'</Ktext1>
                                                        <Menge>'.$serv->qty_proposed.'</Menge>
                                                        <Meins>'.$serv->unit_measurement_comm.'</Meins>
                                                        <Brtwr>'.$serv->price_verified.'</Brtwr>
                                                        <Peinh>'.$serv->price_unit.'</Peinh>
                                                    </item>
                                                </ReqServices>
                                                ';
                                            }
                                            $xmls = $xmls.'</item>';
                                        }
                        $xmls = $xmls.'
                                        </PRItem>
                                    </ImInput>
                                </ZfmifPrReceive>
                            </Body>
                        </Envelope>';
                        $ress = $this->callSAP($xmls,'EBUDGETReceive_Services?wsdl');

                        $sap = '<?xml version="1.0" encoding="UTF-8"?>
                        <FeedBackPR xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                          <InformationIdentification>PR0011_20211202070000</InformationIdentification>
                          <DestinationCompanyCode>eBud</DestinationCompanyCode>
                          <SenderCompanyCode>SAP</SenderCompanyCode>
                          <CreatedDateAndTime>20211202062915</CreatedDateAndTime>
                          <Freeuse1>-</Freeuse1>
                          <Freeuse2>-</Freeuse2>
                          <FBItems>
                            <item>
                              <Fb_type>CR</Fb_type>
                              <Banfn>372282922</Banfn>
                              <Bnfpo>00010</Bnfpo>
                              <Bednr>-</Bednr>
                              <Matnr>372727</Matnr>
                              <Txz01>Test-1</Txz01>
                              <Result>F1</Result>
                            </item>
                          </FBItems>
                        </FeedBackPR>';

                        return $this->resSuccess('Budget berhasil di '.$request->type, ['user_id'=>$admin_id, 'budget'=>$xmlobj, 'xml'=>$xmls, 'ress'=>$ress, 'endpoint'=>'http://192.168.0.20:1101/axis2/services/'.'EBUDGETReceive_Services?wsdl']);
                    }
                }
                break;
        }
        return $this->resSuccess('Hah? kamu dari mana?', $request->toArray());
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
