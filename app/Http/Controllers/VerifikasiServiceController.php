<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetItem;
use App\BudgetService;
use App\BudgetVersion;
use App\InternalOrderRpt;
use App\SapCostCenter;
use App\SapCurrency;
use App\SapDocType;
use App\SapGlAccount;
use App\SapUnitMeasure;
use Exception;
use Illuminate\Http\Request;

class VerifikasiServiceController extends Controller
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
        }else{
            if ($request->hid)
                $header = Budget::find($request->hid);
            else
                return redirect(url('/verifikasi'));
            $item = BudgetItem::where(['t_budget_id'=>$request->hid, 'item_category'=>3])->whereHas('service')->get();
            if (sizeof($item) == 0)
                return redirect(url('/verifikasi/items').'?hid='.$request->hid);
            elseif ($request->iid){
                $data = BudgetService::orderBy('seq_no')->where('t_budget_item_id',$request->iid)->with(['gl_accounts','cost_centers','internal_orders'])->get();
                $iselect = $item->where('id',$request->iid)->first();
            }else{
                $request['iid'] = $item[0]->id;
                $data = BudgetService::orderBy('seq_no')->where('t_budget_item_id',$item[0]->id)->with(['gl_accounts','cost_centers','internal_orders'])->get();
                $iselect = $item[0];
            }
        }
        $select = [
            'umeasure' => SapUnitMeasure::where('status', 1)->get(),
            'pr_doc' => SapDocType::where('status', 1)->get(),
            'currency' => SapCurrency::where('status',1)->get(),
            'budget_version' => BudgetVersion::where('status', 1)->get(),
            'items' => $item,
            'glaccount' => SapGlAccount::where('status', 1)->get(),
            'costcenter' => SapCostCenter::where('status',1)->get(),
            'internal' => InternalOrderRpt::whereNull('t_budget_id')->orWhere('t_budget_id',$request->hid)->get()
        ];
        return view('pages.verifikasi.vservice', [ 'data' => $data , 'header'=>$header, 'select'=>$select, 'iselect'=>$iselect, 'error'=>$error]);
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
            'currency'=>'required',
            'gl_account'=>'required',
            'cost_center'=>'required',
        ]))
            return $this->index($request, $validate);
        try{
            $request['t_budget_item_id'] = $request->iid;
            $request['item_status'] = "Draft";
            $request['price_unit'] = 1;
            // if ($request->item_category == 3){
                // $request['short_text'] = $request->_short_text;
            //     $request['material_group'] = $request->_material_group;
            //     $request['uom'] = $request->_uom;
            // }
            // if ($request->account_assignment != 1){
            //     $request['internal_order'] = null;
            // }
            BudgetService::create($request->toArray());
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
            $up = [
                'gl_account' => $request->gl_account,
                'cost_center' => $request->cost_center,
                'internal_order' => $request->internal_order,
                'price_verified' => $request->price_verified
            ];
            $service = BudgetService::find($id);
            $service->update($up);
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
