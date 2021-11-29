<?php

namespace App\Http\Controllers;

use App\EmailSend;
use App\File;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
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
        $file_loc = public_path($folder) . $name;
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
    public function getUser($array){
        $field = ['user_id' => $array];
        $params = http_build_query($field);
        $params = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '[]=', $params);
        $result = $this->karyawanAll('getPosisiKaryawan?'. $params);
        $output = array();
        // return $result->data;
        foreach($result as $user){
            $output[$user['user_id']] = [
                'nama' => $user['NAME'],
                'email' => $user['email'],
                'nik' => $user['nik']
            ];
        }
        return $output;
    }

    public function karyawanAll($param = 'getPosisiKaryawanAll?approval=Y'){
        $client = curl_init();
        $authorization = "Authorization: Bearer ".$_SESSION['ebudget_token'];
        curl_setopt_array($client, array(
            CURLOPT_URL => 'http://103.126.30.250:8086/sikar_api/api/'.$param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Access-Control-Allow-Headers' => '*',
                'Content-Type: application/json',
                $authorization
            ),
        ));
        $response = curl_exec($client);
        curl_close($client);
        return json_decode($response,true)['data'];
    }

    public function notifKFA($user_id, $budget){
        $client = curl_init();
        // $authorization = "Authorization: Bearer ".$_SESSION['ebudget_token'];
        curl_setopt_array($client, array(
            CURLOPT_URL => 'http://172.16.11.178:8000/api/kfa/notif/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => json_encode([
                'app_id' => 1,
                'user_id' => $user_id,
                'item' => $budget,
            ]),
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Access-Control-Allow-Headers' => '*',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($client);
        curl_close($client);
        return json_decode($response);
    }

    public function send_email($email, $name, $subject, $data){
        $to_name = $name;
        $to_email = 'cappuccino45team@gmail.com';
        $view = "mails";
        try{
            Mail::send($view, $data, function($message) use ($to_name, $to_email, $subject) {
                $message->to($to_email, $to_name)->subject($subject);
                $message->from("kirimemail.ptkbs@gmail.com","E-Budgeting System");
            });
            EmailSend::create([
                'name' => $to_name,
                'receiver' => $to_email,
                'title' => $subject,
                'body' => json_encode($data),
                'view' => $view,
                'error' => '',
                'status' => '1'
            ]);
        }catch(Exception $th){
            // try{
                EmailSend::create([
                    'name' => $to_name,
                    'receiver' => $to_email,
                    'title' => $subject,
                    'body' => json_encode($data),
                    'view' => $view,
                    'error' => $th->getMessage(),
                    'status' => '0'
                ]);
            // }catch(Exception $th){}
        }
    }
}
