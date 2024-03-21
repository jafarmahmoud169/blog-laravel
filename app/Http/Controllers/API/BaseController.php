<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    public function sendResponse($result ,$message){
        $response=[
            'success'=>true,
            'data'=>$result,
            'message'=>$message
        ];
        return response()->json($response,200);
    }

    public function sendError($error ,$eroorMessage=[],$code=404){
        $response=[
            'success'=>false,
            'data'=>$error,
        ];
        if (!empty($eroorMessage)) {
            $response['data']=$eroorMessage;
        }
        return response()->json($response,$code);
    }


}
