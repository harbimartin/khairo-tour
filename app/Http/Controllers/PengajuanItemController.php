<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetItem;
use App\BudgetPeriod;
use App\BudgetVersion;
use App\InternalOrder;
use App\InternalOrderRpt;
use App\SapAccount;
use App\SapCostCenter;
use App\SapCurrency;
use App\SapDocType;
use App\SapGlAccount;
use App\SapItemCategory;
use App\SapMaterial;
use App\SapMaterialGroup;
use App\SapPurchaseGroup;
use App\SapUnitMeasure;
use Exception;
use Illuminate\Http\Request;

class PengajuanItemController extends Controller
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
            $data = BudgetItem::where('id',$request->id)->first();
            $header = (object)['id'=>$data->t_budget_id];
            $request['hid'] = $data->t_budget_id;
        }else{
            $data = BudgetItem::latest('id')->where('t_budget_id',$request->hid)->with(['purchase_groups', 'item_categories'])->get();
            if ($request->hid){
                $header = Budget::find($request->hid);
                // if ($header->budget_versions->division_id != $_SESSION['ebudget_division_id'])
                //     return "Maaf kamu tidak bisa mengakses Laman ini";
            }else
                return redirect(url('/pengajuan'));
        }
        $select = [
            'pr_doc' => SapDocType::where('status',1)->get(),
            'budget_version' => BudgetVersion::where('status', 1)->get(),
            'pgroup' => SapPurchaseGroup::where('status',1)->get(),
            'mnumber' => SapMaterial::where('status',1)->get(),
            'umeasure' => SapUnitMeasure::where('status',1)->get(),
            'icategory' => SapItemCategory::where('status',1)->get(),
            'assign' => SapAccount::where('status',1)->get(),
            'currency' => SapCurrency::where('status',1)->get(),
            'mgroup' => SapMaterialGroup::where('status', 1)->get(),

            'pr_doc' => SapDocType::where('status', 1)->get(),
            'budget_version' => BudgetVersion::where('status', 1)->get(),
            'glaccount' => SapGlAccount::where('status', 1)->get(),
            'costcenter' => SapCostCenter::where('status',1)->get(),//[['id'=>1,'name'=>'Cost Center 1'],['id'=>2, 'name'=>'Cost Center 2']],
            'internal' => InternalOrderRpt::whereNull('t_budget_id')->orWhere('t_budget_id',$request->hid)->get()//[['id'=>1,'name'=>'Internal 1'],['id'=>2, 'name'=>'Internal 2']],
        ];
        return view('pages.pengajuan.item', [ 'data' => $data , 'header' => $header,'select'=>$select, 'error'=>$error]);
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
        $request['hid'] = $request->t_budget_id;
        if ($validate = $this->validing($request->all(), [
            'hid'=>'required',
            'seq_no'=>'required',
            'purchase_group'=>'required',
            'item_category'=>'required',
            'account_assignment'=>'required',
            'request_date'=>'required',
            'package_no'=>'required',
            // 'short_text'=>'required',
            // 'unit_qty'=>'required',
            'qty_proposed'=>'required',
            'price_proposed'=>'required',
            'currency'=>'required',
            'delivery_date_exp'=>'required',
            'note_item'=>'required',
        ]))
            return $this->index($request, $validate);
        try{
            $request['t_budget_id'] = $request->hid;
            $request['plant'] = "KBS1";
            $request['item_status'] = "Draft";
            $request['price_unit'] = "1";
            if ($request->item_category == 3){
                $request['short_text'] = $request->_short_text;
                $request['material_group'] = $request->_material_group;
                $request['unit_qty'] = $request->_unit_qty;
            }
            if ($request->account_assignment != 1){
                $request['internal_order'] = null;
            }
            BudgetItem::create($request->toArray());
        }catch(Exception $th){
            return $this->index($request, $th->getMessage());
        }
        return redirect($request->url().'?hid='.$request->hid);
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
            BudgetItem::find($id)->update($request->toArray());
        } catch(Exception $th){
            return $this->index($request, $th->getMessage());
        }
        return redirect(dirname($request->url()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        BudgetItem::destroy($id);
        return redirect($request->url);
    }
}
