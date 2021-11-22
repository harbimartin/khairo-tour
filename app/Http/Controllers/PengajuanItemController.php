<?php

namespace App\Http\Controllers;

use App\BudgetPeriod;
use App\BudgetVersion;
use App\SapAccount;
use App\SapCurrency;
use App\SapDocType;
use App\SapItemCategory;
use App\SapMaterial;
use App\SapPurchaseGroup;
use App\SapUnitMeasure;
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
        $data = '[]';
        // if ($request->id)
        //     $data = BudgetVersion::where('id',$request->id)->with(['period', 'division', 'type'])->first();
        // else{
        //     $data = BudgetVersion::latest('id')->with(['period', 'division', 'type'])->get();//->paginate($length);
        //     foreach($data as $a){
        //         $a['state'] = $a['status'] ? 'AKTIF' : 'NON-AKTIF';
        //     }
        // }
        $select = [
            'pr_doc' => SapDocType::where('status',1)->get(),
            'budget_version' => BudgetVersion::where('status', 1)->get(),
            'pgroup' => SapPurchaseGroup::where('status',1)->get(),
            'mnumber' => SapMaterial::where('status',1)->get(),
            'umeasure' => SapUnitMeasure::where('status',1)->get(),
            'icategory' => SapItemCategory::where('status',1)->get(),
            'assign' => SapAccount::where('status',1)->get(),
            'currency' => SapCurrency::where('status',1)->get(),


            'pr_doc' => SapDocType::where('status', 1)->get(),
            'budget_version' => BudgetVersion::where('status', 1)->get(),
            'glaccount' => SapAccount::where('status', 1)->get(),
            'costcenter' => [['id'=>1,'name'=>'Cost Center 1'],['id'=>2, 'name'=>'Cost Center 2']],
            'internal' => [['id'=>1,'name'=>'Internal 1'],['id'=>2, 'name'=>'Internal 2']],
        ];
        return view('pages.pengajuan.item', [ 'data' => $data , 'select'=>$select, 'error'=>$error]);
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
        // if ($validate = $this->validing($request->all(), [
        //     'budget_version_code' => 'required',
        //     'budget_period_id' => 'required',
        //     'divisions_id' => 'required',
        //     'budget_version_type' => 'required',
        //     'budget_name' => 'required',
        //     'budget' => 'required'
        // ]))
        //     return $this->index($request, $validate);
        // try{
        //     $request['status']=0;
        //     BudgetVersion::create($request->toArray());
        // }catch(Exception $th){
        //     return $this->index($request, $th->getMessage());
        // }
        return redirect($request->url().'/item?hid='.'0');
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
