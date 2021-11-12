<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function validing($request,$items){
        $validate = Validator::make($request,$items);
        if ($validate->fails()) {
            return $this->resFailed(400, $validate->errors()->all());
        }else
            return null;
    }
    public function resSuccess($message, $data = null){
        return response()->json([
            'message' => $message,
            'data' => $data
        ],200);
    }
    /**
     * Undocumented function
     *
     * @param [number] $error
     * @category 400 => Bad Request, 401 => Unauthorized,
     * 402 => Payment Required, 403 => No Access, 404 => No Data, 405 => Method not Allowed,
     * 406 => No Accepted Header, 407 => Proxy Auth Req, 408 => Server Timed Out,
     * 409 => Conflict, 410 => Never Data,
     * @param [string|array] $code
     */
    public function resFailed($code, $error){
        if (is_array($error))
            $error = implode(",",$error);
        return response()->json($error,$code);
    }
    public function unlink_files($folder, $name){
        if ($name==null)
            return;
        $file_loc = public_path("files\\".$folder."\\") . $name;
        if (file_exists($file_loc)){
            unlink($file_loc);
        }
    }

    public function fileUpload(Request $request){
        // if ($validate = $this->validing($request->all(), [
        //     'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        // ]))
        //     return $validate;
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);
        $file = new File();

        if($request->file()) {
            $request->number = File::where(['code'=>$request->code, 'key'=>$request->key])->max('number');
            // $fileName = $request->code.'-'.$request->key.->getClientOriginalName();
            // $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            // $file->name = time().'_'.$request->file->getClientOriginalName();
            // $file->file_path = '/storage/' . $filePath;
            // $file->save();

            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
}
}
