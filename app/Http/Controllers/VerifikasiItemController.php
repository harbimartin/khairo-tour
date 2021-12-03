<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetItem;
use App\BudgetVersion;
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

class VerifikasiItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if ($length = $request->el)
            $length = 10;
        $next_seq = 0;
        $next_package = 0;
        if ($request->id){
            $data = BudgetItem::where('id',$request->id)->first();
            $header = (object)['id'=>$data->t_budget_id];
            $request['hid'] = $data->t_budget_id;
            $next_seq = (sizeof($data)>0) ? $data[sizeof($data)-1]['seq_no']+10 : 10;
            $next_package = (sizeof($data)>0) ? $data[sizeof($data)-1]['package_no']+1 : 1;
        }else{
            $data = BudgetItem::latest('id')->where('t_budget_id',$request->hid)->with(['purchase_groups', 'item_categories'])->get();
            if ($request->hid){
                $header = Budget::find($request->hid);
                $header->doc_types;
                $header->budget_versions;
                // if ($header->budget_versions->division_id != $_SESSION['ebudget_division_id'])
                //     return "Maaf kamu tidak bisa mengakses Laman ini";
            }else
                return redirect(url('/verifikasi'));
        }
        $select = [
            'pr_doc' => SapDocType::where('status',1)->get(),
            'budget_version' => BudgetVersion::where('status', 1)->get(),
            'pgroup' => SapPurchaseGroup::where('status',1)->get(),
            'mnumber' => SapMaterial::where('status',1)->with('uoms','mgroups')->get(),
            'umeasure' => SapUnitMeasure::where('status',1)->get(),
            'icategory' => SapItemCategory::where('status',1)->get(),
            'assign' => SapAccount::where('status',1)->get(),
            'currency' => SapCurrency::where('status',1)->get(),
            'mgroup' => SapMaterialGroup::where('status', 1)->get(),
            'glaccount' => SapGlAccount::where('status', 1)->get(),
            'costcenter' => SapCostCenter::where('status',1)->get(),//[['id'=>1,'name'=>'Cost Center 1'],['id'=>2, 'name'=>'Cost Center 2']],
            'internal' => InternalOrderRpt::whereNull('t_budget_id')->orWhere('t_budget_id',$request->hid)->get()//[['id'=>1,'name'=>'Internal 1'],['id'=>2, 'name'=>'Internal 2']],
        ];
        return view('pages.verifikasi.vitem', [ 'data' => $data , 'header' => $header,'select'=>$select, 'next_seq'=>$next_seq, 'next_package'=>$next_package, 'error'=>$error]);
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
    public function update(Request $request, $id){
        try{
            // return $request->toArray();
            $up = [
                'material group' => $request->material_group,
                'gl_account' => $request->gl_account,
                'cost_center' => $request->cost_center,
                'internal_order' => $request->internal_order,
                'price_verified' => $request->price_verified
            ];
            $budget = BudgetItem::find($id);
            if ($budget->item_category == 3)
                $up['price_verified'] = 0;
            $budget->update($up);
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
        BudgetItem::destroy($id);
        return redirect($request->url);
    }
}
