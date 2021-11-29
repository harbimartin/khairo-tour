<?php

namespace App\Http\Controllers;

use App\EmailSend;
use Illuminate\Http\Request;

class EmailSendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($length = $request->el)
            $length = 10;
        if ($request->id){
            $data = EmailSend::where('id',$request->id)->first();
        }else{
            $data = EmailSend::latest()->get();
        }
        return view('pages.emails', [ 'data' => $data ]);
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
     * @param  \App\EmailSend  $emailSend
     * @return \Illuminate\Http\Response
     */
    public function show(EmailSend $emailSend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailSend  $emailSend
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailSend $emailSend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmailSend  $emailSend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailSend $emailSend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailSend  $emailSend
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailSend $emailSend)
    {
        //
    }
}
