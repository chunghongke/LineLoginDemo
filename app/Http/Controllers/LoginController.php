<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Services\LineService;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $lineService;

    public function __construct(LineService $lineService)
    {
        $this->lineService = $lineService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = $this->lineService->getLoginBaseUrl();
        return view('line')->with('url', $url);
    }

    /**
     * 使用者登入Line，LINE Platform會呼叫的callback
     * (通常需驗證web app傳送過去的state才接受回傳的資料)
     */
    public function lineLoginCallBack(Request $request)
    {
        try {
            $error = $request->input('error', false);
            if ($error) {
                throw new Exception($error);
            }
            $code = $request->input('code', '');
            $response = $this->lineService->getToken($code);
            $request->session()->put('pid', $response['access_token']);

            return redirect()->route('user');
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }
}
