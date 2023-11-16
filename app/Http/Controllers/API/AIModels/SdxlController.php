<?php

namespace App\Http\Controllers\API\AIModels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SdxlController extends Controller
{
    public function chat(Request $request){
        $validated = Validator::make($request->all(), [
            'prompt' => 'required',
        ]);

        if($validated->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validated->errors()
            ], 401);
        }

        try {
            $response = json_decode($this->getResponse($request['prompt']));
            return response()->json([
                'status' => true,
                'message' => 'response received from model',
                'data' => $response
            ], 200);

        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param $prompt
     * @return bool|string
     */
    private function getResponse($prompt): string|bool
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://162.55.238.34:8070/chatgpt/inference',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "prompt": "' . $prompt . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
