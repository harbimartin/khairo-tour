<?php

namespace App\Http\Controllers;

use App\Imports\SapMaterialImport;
use App\SapMaterial;
use App\SapUnitMeasure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;

class MasterMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if (!$length = $request->el)
            $length = 10;
        if ($request->id)
            $data = SapMaterial::find($request->id);
        else{
            $paginate = SapMaterial::latest('id')->with('uoms')->paginate($length);
            // $data = $paginate->data;//paginate($length);
            $data = $paginate->getCollection();
            foreach($data as $a){
                $a['state'] = $a['status'] ? 'AKTIF' : 'NON-AKTIF';
            }
        }
        $select = [
            'umeasure' => SapUnitMeasure::where('status',1)->get(),
        ];
        return view('pages.masterdata.material', ['data' => $data, 'length' => $length, 'error' => $error, 'select'=>$select]);
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
        if ($request->mode == 'import'){
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
            $file = $request->file('file');
            $nama_file = rand().$file->getClientOriginalName();
            $file->move('file_material',$nama_file);
            Excel::import(new SapMaterialImport, public_path('/file_material/'.$nama_file));
            return redirect($request->url());
        }
        if ($validate = $this->validing($request->all(), [
            'material' => 'required',
            'material_type' => 'required',
            'plant' => 'required',
            'sloc' => 'required',
            'material_desc' => 'required',
            'uom' => 'required',
            'material_group' => 'required',
            'old_number' => 'required',
            'mrp_type' => 'required',
            'avail_check' => 'required',
            'profit_center' => 'required',
            'val_class' => 'required',
            'costing_lot_size' => 'required',
            'price_ctrl' => 'required',
            'per' => 'required',
            'moving_price' => 'required',
            'order_text' => 'required',
        ]))
            return $validate;
        $sap = 'fail';
        try{
            $request['last_change']=Date::now();
            $request['status']=0;
            $sap = SapMaterial::create($request->toArray());
        }catch(Exception $th){
            // return $this->index($request, $th->getMessage());q
            return $th->getMessage();
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
    public function update(Request $request, $id)
    {
        try{
            if ($request->status > 0){
                SapMaterial::where('status',1)->update(['status' => 0]);
                SapMaterial::find($id)->update(['status'=>1]);
            }else
                SapMaterial::find($id)->update($request->toArray());
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
