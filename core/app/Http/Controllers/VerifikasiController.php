<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetStatus;
use App\BudgetStatusRpt;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
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
            return redirect(url('/verifikasi/items').'?hid='.$request->id);
        }else{
            $data = Budget::latest('created')->where('budget_status','Verification')->with(['doc_types'])->withCount('items')->get();
            return view('pages.verifikasi_list', [ 'data' => $data, 'error'=>$error]);
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
        switch($request->__type){
            case 'reject':
                $budget = Budget::find($id);
                $budget->update([
                    'budget_status'=>'Rejected',
                    'note_reject'=>$request->reason
                ]);
                return redirect(request()->segment(count(request()->segments())-1));
            break;
            case 'verified':
                return redirect(url('/').'/verifikasi/proposes?hid='.$id);
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
}
