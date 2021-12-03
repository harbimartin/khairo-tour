<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetItem;
use App\BudgetPeriod;
use App\BudgetService;
use App\BudgetVersion;
use App\InternalOrder;
use App\InternalOrderRpt;
use App\SapAccount;
use App\SapCostCenter;
use App\SapCurrency;
use App\SapDocType;
use App\SapGlAccount;
use App\SapUnitMeasure;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class PengajuanServiceController extends Controller
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
            $data = BudgetService::where('id',$request->id)->first();
            $header = (object)['id'=>$data->t_budget_id];
            $item = [];
            $iselect = null;
            $next_seq = $data['seq_no'];
        }else{
            if ($request->hid)
                $header = Budget::find($request->hid);
            else
                return redirect(url('/pengajuan'));
            $item = BudgetItem::where(['t_budget_id'=>$request->hid, 'item_category'=>3])->get();
            if (sizeof($item) == 0)
                return redirect(url('/pengajuan/item').'?hid='.$request->hid);
            elseif ($request->iid){
                $data = BudgetService::orderBy('seq_no')->where('t_budget_item_id',$request->iid)->with(['gl_accounts','cost_centers','internal_orders'])->get();
                $iselect = $item->where('id',$request->iid)->first();
            }else{
                $request['iid'] = $item[0]->id;
                $data = BudgetService::orderBy('seq_no')->where('t_budget_item_id',$item[0]->id)->with(['gl_accounts','cost_centers','internal_orders'])->get();
                $iselect = $item[0];
            }
            $next_seq = (sizeof($data)>0) ? $data[sizeof($data)-1]['seq_no']+10 : 10;
        }
        $select = [
            'umeasure' => SapUnitMeasure::where('status', 1)->get(),
            'pr_doc' => SapDocType::where('status', 1)->get(),
            'currency' => SapCurrency::where('status',1)->get(),
            'budget_version' => BudgetVersion::where('status', 1)->get(),

            'items' => $item,
            'glaccount' => SapGlAccount::where('status', 1)->get(),
            'costcenter' => SapCostCenter::where('status',1)->get(),//[['id'=>1,'name'=>'Cost Center 1'],['id'=>2, 'name'=>'Cost Center 2']],
            'internal' => InternalOrderRpt::whereNull('t_budget_id')->orWhere('t_budget_id',$request->hid)->get()//[['id'=>1,'name'=>'Internal 1'],['id'=>2, 'name'=>'Internal 2']],

        ];
        return view('pages.pengajuan.pservice', [ 'data' => $data , 'header'=>$header, 'select'=>$select, 'iselect'=>$iselect, 'next_seq'=>$next_seq, 'error'=>$error]);
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
        $request['iid'] = $request->t_budget_item_id;
        if ($validate = $this->validing($request->all(), [
            'iid'=>'required',
            'seq_no'=>'required',
            'short_text'=>'required',
            // 'unit_qty'=>'required',
            'qty_proposed'=>'required',
            'price_proposed'=>'required',
            // 'currency'=>'required',
            'gl_account'=>'required',
            'cost_center'=>'required',
        ]))
            return $this->index($request, $validate);
        try{
            $budget = BudgetItem::find($request->t_budget_item_id);
            if ($budget->budget->account_assignment !=1 ){
                $request['internal_order'] = null;
            }
            $request['t_budget_item_id'] = $request->iid;
            $request['item_status'] = "Draft";
            $request['price_unit'] = 1;
            // if ($request->item_category == 3){
                //    $request['short_text'] = $request->_short_text;
            //     $request['material_group'] = $request->_material_group;
            //     $request['uom'] = $request->_uom;
            // }
            // if ($request->account_assignment != 1){
            //     $request['internal_order'] = null;
            // }
            $item = BudgetItem::find($request->t_budget_item_id);
            $item->service()->create($request->toArray());
            // $item->update([
            //     'price_proposed' => $item->getTotalProposed(),
            //     'price_verified' => $item->getTotalVerified()
            // ]);
        }catch(Exception $th){
            return $this->index($request, $th->getMessage());
        }
        return redirect($request->url().'?hid='.$request->hid.'&iid='.$request->iid);
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
        try{
            $budget = BudgetItem::find($request->t_budget_item_id);
            if ($budget->budget->account_assignment !=1 ){
                $request['internal_order'] = null;
            }
            BudgetService::find($id)->update($request->toArray());
        } catch(Exception $th){
            return $this->index($request, $th->getMessage());
        }
        return redirect($request->_next);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        BudgetService::destroy($id);
        return redirect($request->url);
    }
}
