<?php

namespace BlaudCMS\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;

use BlaudCMS\User;
use Utility;

use Auth;
use Flashy;

/**
* Clase para manejo de login de usuarios de backend
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Authentication/Authorization
*/

class LoginController extends Controller
{

    /**
     * Constructor del Controller
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     */
    public function __construct(){
        // Si el usuario tiene su sesion iniciada lo llevo directo al home sin pasar por el formulario de login
        if(Auth::check() || Auth::viaRemember()){
            return redirect()->intended('backend/dashboard');
        }
    }

    /**
     * Metodo para mostrar el formulario de login del backend del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @route /backend/login
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function login(){
        return view('backend.auth.login');
    }

    /**
     * Metodo para validar a un usuario y permitirle o no el acceso al backend del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/23
     *
     * @route /backend/login
     * @method POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginValidate(Request $request){
        $this->validate($request, [
            'email' => 'required|email|exists:users,email,status,1',
            'password' => 'required',
        ],[
            'email.required' => 'Su cuenta de email es obligatoria.',
            'email.email' => 'Por favor ingrese un email válido.',
            'email.exists' => 'La cuenta de email ingresada no existe.',
            'password.required' => 'Por favor ingrese su clave de acceso.',
        ]);

        $credentials = array(
            'email' => $request->email,
            'password' => $request->password,
        );
        $remember = $request->remember ? TRUE : FALSE;

        if (Auth::attempt( $credentials, $remember )) {
            if(Auth::user()->status == 1){
                if($request->ajax()){
                    return response()->json(['status' => true , 'message' => 'Usuario '.Auth::user()->name.' '.Auth::user()->lastname.' validado exitosamente',], 200);
                }
                return redirect()->intended('backend/dashboard');
            }else{
                Auth::logout();
                if($request->ajax()){
                    return response()->json(['status' => false , 'message' => 'Su cuenta de usuario se encuentra deshabilitada',], 200);
                }
                $request->session()->flash('errorMsg', 'Su cuenta de usuario se encuentra deshabilitada.');
                return redirect()->route('backend.login');
            }
        }else{
        	if($request->ajax()){
                return response()->json(['status' => false , 'message' => 'Su email o password son incorrectos o su cuenta de usuario no existe.',], 200);
            }
            $request->session()->flash('errorMsg', 'Su email o password son incorrectos o su cuenta de usuario no existe.');
            return redirect()->route('backend.login');
        }
    }

    /**
     * Metodo para cerrar la sesión del usuario y llevarlo a la pantalla de login
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/23
     *
     * @route /backend/logout
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('backend.login');
    }

    /**
     * Metodo para cambio de clave de usuario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/24
     *
     * @route /backend/reset-password
     * @method POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request){
    	$oUser = User::byEmail($request->email);
    	if($oUser){
    		$newPassword = Utility::passwordGenerate();
    		$oUser->password = $newPassword;
    		$oUser->temporary_password = $newPassword;
    		if($oUser->save()){
    			/***********************************************************************
					Aqui se envia el correo al usuario con su nueva clave
    			************************************************************************/
    			
    				///  

    			/***********************************************************************
					Fin de envio de nueva clave
    			************************************************************************/
    			if($request->ajax()){
                    return response()->json(['status' => true , 'message' => 'Su clave de acceso ha sido actualizada exitosamente y su nueva clave ha sido enviada a su email.',], 200);
                }
                Flashy::success('Su clave de acceso ha sido actualizada exitosamente y su nueva clave ha sido enviada a su email.');
        		return redirect()->route('backend.login');
    		}
    	}
        if($request->ajax()){
            return response()->json(['status' => true , 'message' => 'Lo sentimos, no existe una cuenta de usuario con esa dirección de Email.',], 200);
        }
    	Flashy::error('Lo sentimos, no existe una cuenta de usuario con esa dirección de Email.');
        return redirect()->route('backend.login');
    }
}
