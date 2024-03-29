<?php

namespace App\Http\Controllers;

use App\BudgetPeriod;
use App\BudgetVersion;
use App\BudgetVType;
use App\Division;
use Exception;
use Illuminate\Http\Request;

class MasterController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if ($length = $request->el)
            $length = 10;
        if ($request->id)
            $data = BudgetVersion::where('id',$request->id)->with(['period', 'division', 'type'])->first();
        else{
            $data = BudgetVersion::latest('id')->with(['period', 'division', 'type'])->get();//->paginate($length);
            foreach($data as $a){
                $a['state'] = $a['status'] ? 'AKTIF' : 'NON-AKTIF';
            }
        }
        $select = [
            'division' => Division::where('div_status', 1)->get(),
            'budget_period' => BudgetPeriod::where('status', 1)->get(),
            'budget_type' => BudgetVType::where('status', 1)->get()
        ];
        return view('pages.masterdata.index', [ 'data' => $data , 'select'=>$select, 'error'=>$error]);
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
            'budget_version_code' => 'required',
            'budget_period_id' => 'required',
            'divisions_id' => 'required',
            'budget_version_type' => 'required',
            'budget_name' => 'required',
            'budget' => 'required'
        ]))
            return $this->index($request, $validate);
        try{
            $request['status']=0;
            BudgetVersion::create($request->toArray());
        }catch(Exception $th){
            return $this->index($request, $th->getMessage());
        }
        return redirect($request->url());
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
            BudgetVersion::find($id)->update($request->toArray());
        }catch(Exception $th){
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
    public function destroy($id)
    {
        //
    }
}
