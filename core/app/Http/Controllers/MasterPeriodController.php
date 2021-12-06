<?php

namespace App\Http\Controllers;

use App\BudgetPeriod;
use Exception;
use Illuminate\Http\Request;

class MasterPeriodController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if ($length = $request->el)
            $length = 10;
        if ($request->id)
            $data = BudgetPeriod::find($request->id);
        else{
            $data = BudgetPeriod::all();//paginate($length);
            foreach($data as $a){
                $a['state'] = $a['status'] ? 'AKTIF' : 'NON-AKTIF';
            }
        }
        return view('pages.masterdata.period', ['data' => $data, 'length' => $length, 'error' => $error]);
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
            'budget_period' => 'required',
            'budget_period_desc' => 'required',
        ]))
            return $this->index($request, $validate);
        try{
            $request['status']=0;
            BudgetPeriod::create($request->toArray());
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
            if ($request->status > 0){
                BudgetPeriod::where('status',1)->update(['status' => 0]);
                BudgetPeriod::find($id)->update(['status'=>1]);
            }else
                BudgetPeriod::find($id)->update($request->toArray());
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
