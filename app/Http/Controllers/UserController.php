<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LineService;

class UserController extends Controller
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
    public function index(Request $request)
    {
        $token = $request->session()->get('pid');
        $user_profile = json_decode($this->lineService->getUserProfile($token), true);
        $params = array(
            'displayName' => $user_profile['displayName'],
            'pictureUrl' => $user_profile['pictureUrl']
        );

        return view('line-login-success')->with($params);
    }
}
