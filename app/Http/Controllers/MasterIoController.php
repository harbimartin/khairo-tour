<?php

namespace App\Http\Controllers;

use App\InternalOrder;
use Exception;
use Illuminate\Http\Request;

class MasterIoController extends Controller
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
            $data = InternalOrder::find($request->id);
        else{
            $paginate = InternalOrder::latest('id')->paginate($length);
            // $data = $paginate->data;//paginate($length);
            $data = $paginate->getCollection();
        }
        return view('pages.masterdata.io', ['data' => $data, 'length' => $length, 'error' => $error]);
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
        if ($validate = $this->validing($request->all(), [
            'io_code' => 'required',
            'io_date' => 'required',
        ]))
            return $this->index($request, $validate);
        try{
            $request['status']=0;
            InternalOrder::create($request->toArray());
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
