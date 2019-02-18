<?php
namespace BlaudCMS\Helpers;

use \Firebase\JWT\JWT;
use BlaudCMS\User;

use Auth;

class JwtAuth {

	private $sAppKey;

	public function __construct(){
		$this->sAppKey = config('app.key');
	}

	public function signup($sEmail = '', $sPassword = '', $getToken = null, $sRemoteHost = null){
		$aResponse = [
			'status' => false,
			'code' => 400,
			'message' => 'Por favor ingrese su email y clave de acceso.',
			'token' => null,
			'token_decoded' => null,
		];
		if($sEmail && $sPassword){
			$aResponse['message'] = 'Su nombre de usuario o clave de acceso son incorrectos o su cuenta de usuario no existe.';
			
			$credentials = [
				'email' => $sEmail,
	            'password' => $sPassword,
			];
			
			if(Auth::attempt($credentials, false)){
				
				$oUser = Auth::user();
				Auth::logout();
				
				$aToken = [
					'iss' => config('app.url'),
					'sub' => 'Authentication',
					'aud' => 'http://'.$sRemoteHost,
					'typ' => 'json',
					'uuid' => $oUser->id,
					'name' => $oUser->name,
					'surname' => $oUser->lastname,
					'email' => $oUser->email,
					'iat' => time(),
					'exp' => time() + (7*24*60*60), // Expira en Time + 1 semana
				];

				$jwt = JWT::encode($aToken, $this->sAppKey, 'HS256');
				
				if($getToken){
					$decoded = JWT::decode($jwt, $this->sAppKey, array('HS256'));
					$aResponse = [
						'status' => true,
						'code' => 200,
						'message' => 'Usuario autenticado exitosamente.',
						'token' => $jwt,
						'identity' => $decoded,
					];

				}else{
					
					$aResponse = [
						'status' => true,
						'code' => 200,
						'message' => 'Usuario autenticado exitosamente.',
						'token' => $jwt,
						'identity' => null,
					];
				}
			}
		}
		return $aResponse;
	}


	public function checkToken($jwt = null, $getIdentity = false){
		$aResponse = [
			'auth' => false,
			'identity' => null,
		];
		if($jwt){
			try{
				$decoded = JWT::decode($jwt, $this->sAppKey, array('HS256'));
				if(is_object($decoded) && isset($decoded->uuid)){
					$aResponse['auth'] = true;
				}
				if( ! is_null($getIdentity) && $getIdentity != false){
					$aResponse['identity'] = $decoded;
				}
			}catch(\UnexpectedValueException $e){
				$aResponse['auth'] = false;
			}catch(\DomainException $e){
				$aResponse['auth'] = false;
			}
		}
		return $aResponse;
	}
}