<?php

namespace App\Http\Controllers;

use App\BudgetPeriod;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if ($length = $request->el)
            $length = 10;
        $data = json_encode(
            [
                'name'=>'Anggaran 1',
                'amount'=>'1000000000',
                'status'=>'Proposed'
            ]
        );
        // if ($request->id)
        //     $data = BudgetVersion::where('id',$request->id)->with(['period', 'division', 'type'])->first();
        // else{
        //     $data = BudgetVersion::latest('id')->with(['period', 'division', 'type'])->get();//->paginate($length);
        //     foreach($data as $a){
        //         $a['state'] = $a['status'] ? 'AKTIF' : 'NON-AKTIF';
        //     }
        // }
        $select = [
            'budget_period' => BudgetPeriod::where('status', 1)->get(),
        ];
        return view('pages.overview', [ 'data' => $data , 'select'=>$select, 'error'=>$error]);
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
