<?php
namespace BlaudCMS\Helpers;
  
class Utility {

	/**
    * Método para generar password
    *
    * @param int iLength
    * @return string sPassword
    */
    public static function passwordGenerate($iLength = 12){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%&*()-_/=!.?;:';
        $charactersLength = strlen($characters);
        $randstring = '';
        for ($i = 0; $i < $iLength; $i++) {
            $randstring .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randstring;
    }
}