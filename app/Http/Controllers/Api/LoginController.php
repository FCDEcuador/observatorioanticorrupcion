<?php

namespace BlaudCMS\Http\Controllers\Api;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;

use BlaudCMS\User;

use BlaudCMS\Helpers\JwtAuth;

use Auth;

class LoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function jwtLogin(Request $request)
    {
        $oJwtAuth = new JwtAuth;
        
        $sEmail = $request->input('email', null);
        $sPassword = $request->input('password', null);
        $getToken = $request->input('getToken', null);

        return response()->json($oJwtAuth->signup($sEmail, $sPassword, $getToken, $_SERVER['REMOTE_ADDR']), 200);

    }
}
