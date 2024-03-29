<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetRpt;
use App\BudgetStatusRpt;
use App\BudgetVersionRpt;
use App\File;
use App\GenSerial;
use App\SapDocType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PengajuanController extends Controller
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
        if ($request->hid)
            return redirect(url('/pengajuan/item').'?hid='.$request->hid);
        // if ($request->id)
        //     $data = BudgetVersion::where('id',$request->id)->with(['period', 'division', 'type'])->first();
        // else{
        //     $data = BudgetVersion::latest('id')->with(['period', 'division', 'type'])->get();//->paginate($length);
        //     foreach($data as $a){
        //         $a['state'] = $a['status'] ? 'AKTIF' : 'NON-AKTIF';
        //     }
        // }
        $select = [
            'pr_doc' => $request->mra ? SapDocType::find($request->mra) : SapDocType::where('status',1)->get(),
            'budget_version' => BudgetVersionRpt::where([
                'status_version'=>1,
                'status_period'=>1,
                'divisions_id'=>$_SESSION['ebudget_division_id']
            ])->get()
        ];
        return view('pages.pengajuan', [ 'data' => $data , 'select'=>$select, 'error'=>$error]);
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
    public function store(Request $request){
        if ($validate = $this->validing($request->all(), [
            'budget_date' => 'required',
            'document_type' => 'required',
            'note_header' => 'required',
            'budget_version' => 'required',
            'budget_file' => 'required',
        ]))
            return $this->index($request, $validate);
        try{
            $serial = GenSerial::where('SERIAL_ID','MRA')->first();
            $request['budget_code'] = $serial->PREFIX.date("y").str_pad($serial->NEXT_VALUE, $serial->LENGTH, '0', STR_PAD_LEFT);
            if ($request->budget_file){
                if ($request->hasFile('budget_file')) {
                    $file = $request->file('budget_file');
                    $filename = $request['budget_code'].'.'.$file->getClientOriginalExtension();
                    $this->unlink_files('file_budget', $filename);
                    $file->move(public_path('file_budget'), $filename);
                    $created_file = File::create([
                        'code' => $request['budget_code'],
                        'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        'ext' => $file->getClientOriginalExtension()
                    ]);
                    $request['budget_attachment'] = $created_file->id;
                }
                // else
                //     return $this->resFailed(404, $request->budget_file." file not emitted!");
            }
            $request['budget_status'] = "Draft";
            $request['created_by'] = $_SESSION['ebudget_id'];
            $serial->increment('NEXT_VALUE');
            $created_budget = Budget::create($request->toArray());
        }catch(Exception $th){
            return $this->index($request, $th->getMessage());
        }
        return redirect($request->url().'/item?hid='.$created_budget->id);
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
        switch($request->__type){
            case 'update':
                try{
                    if ($request->budget_status > 0){
                        Budget::where('budget_status',1)->update(['budget_status' => 0]);
                        Budget::find($id)->update(['budget_status'=>1]);
                    }else
                        Budget::find($id)->update($request->toArray());
                }catch(Exception $th){
                    return $this->index($request, $th->getMessage());
                }
                return redirect($request->_last_);
            case 'propose':
                return redirect(url('/').'/pengajuan/propose?id='.$id);
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

    public function download(Request $request){
        if ($request->id){
            $budget_file = Budget::find($request->id)->files;
            $file = public_path(). "/file_budget/".$budget_file->code.'.'.$budget_file->ext;
        }else{
            $file= public_path(). "/file_budget/".$request->name;
        }
        $headers = array(
                'Content-Type: application/pdf',
                );
        return Response::download($file, 'ebudget.pdf', $headers);
    }
    public function budget_rpt(Request $request){
        // return ['divisions_id'=> $request->division_id, 'created_by'=>$request->user_id];
        // return $request->toArray();
        $data = BudgetRpt::where(['divisions_id'=> $request->division_id, 'created_by'=>$request->user_id])->search($request)->get();
        return $data;
    }
    public function budget_status_rpt(Request $request){
        // return ['divisions_id'=> $request->division_id, 'created_by'=>$request->user_id];
        $data = BudgetStatusRpt::where('user_id',$request->user_id)->get();
        return $data;
    }
    public function budget_notif_rpt(Request $request){
        // return ['divisions_id'=> $request->division_id, 'created_by'=>$request->user_id];
        $data = BudgetStatusRpt::where(['user_id'=>$request->user_id, 'status_active'=>1])->whereNull('user_status')->get();
        return $data;
    }
    public function budget_notif_count(Request $request){
        $data = BudgetStatusRpt::where(['user_id'=>$request->user_id, 'status_active'=>1])->whereNull('user_status')->count();
        return $data;
    }
    public function budget_detail(Request $request, $api = true){
        $data = Budget::where('id',$request->id)->with(['items'=>function($q){
            $q->orderBy('seq_no')->with(['accounts','materials','purchase_groups','item_categories','currencies','uom','gl_accounts','internal_orders','cost_centers','service'=>function($q){
                $q->with(['uom','gl_accounts','internal_orders','cost_centers']);
            }]);
        }])->first()->makeVisible(['total_proposed','total_verified']);
        $data->items->each(function($q){
            return $q->makeVisible(['total_proposed','total_verified']);
        });
        // $total_proposed = 0;
        // $total_verified = 0;
        // foreach($data->items as $key => $item){
        //     $count_serv_propose = $item['price_proposed'];
        //     $count_serv_verif = $item['price_verified'];
        //     foreach($item['service'] as $iteme){
        //         $count_serv_propose += $iteme['price_proposed'];
        //         $count_serv_verif += $iteme['price_verified'];
        //     }
        //     $data->items[$key]['price_proposed'] = $count_serv_propose;
        //     $data->items[$key]['price_verified'] = $count_serv_verif;
        //     $total_proposed += $data->items[$key]['amount_proposed'] = $count_serv_propose * $iteme['qty_proposed'];
        //     $total_verified += $data->items[$key]['amount_verified'] = $count_serv_verif * $iteme['qty_proposed'];
        // }
        if ($api)
            return $this->resSuccess('Memo Realisasi Anggaran',$data);
        else
            return $data;
    }
}
