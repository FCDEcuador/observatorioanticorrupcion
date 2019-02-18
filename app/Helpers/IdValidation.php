<?php
namespace BlaudCMS\Helpers;

class IdValidation {
	/**
     * Error
     *
     * Contiene errores globales de la clase
     *
     * @var string
     * @access protected
     */
    protected $error = '';

    /**
     * identificationNumber
     *
     * Contiene el numero de identificacion
     *
     * @var string
     * @access protected
     */
    protected $identificationNumber = '';

    /**
     * 
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/09/21
     *
     * @return void
     */
    public function __construct($idNumber = null)
    {
        $this->identificationNumber = $idNumber;
    }

    /**
     * Validar cédula
     *
     * @param  string  $number  Número de cédula
     *
     * @return Boolean
     */
    public function validateID()
    {
        // fuerzo parametro de entrada a string
        $number = (string)$this->identificationNumber;

        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');

        // validaciones
        try {
            if(
                $this->initValidation($number, '10') &&
                $this->validateStateCode(substr($number, 0, 2)) &&
                $this->validateThirdDigit($number[2], 'ID') &&
                $this->module10Algorithm(substr($number, 0, 9), $number[9])
            ){
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }

        return false;
    }

    /**
     * Validar RUC persona natural
     *
     * @param  string  $number  Número de RUC persona natural
     *
     * @return Boolean
     */
    public function validateRucNaturalPerson()
    {
        // fuerzo parametro de entrada a string
        $number = (string)$this->identificationNumber;

        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');

        // validaciones
        try {
            if(
                $this->initValidation($number, '13') && 
                $this->validateStateCode(substr($number, 0, 2)) && 
                $this->validateThirdDigit($number[2], 'natural_ruc') && 
                $this->validateEstablishmentCode(substr($number, 10, 3)) && 
                $this->module10Algorithm(substr($number, 0, 9), $number[9])
            ){
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }

        return false;
    }


    /**
     * Validar RUC sociedad privada
     *
     * @param  string  $number  Número de RUC sociedad privada
     *
     * @return Boolean
     */
    public function validateRucPrivateSociety()
    {
        // fuerzo parametro de entrada a string
        $number = (string)$this->identificationNumber;

        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');

        // validaciones
        try {
            if(
                $this->initValidation($number, '13') && 
                $this->validateStateCode(substr($number, 0, 2)) && 
                $this->validateThirdDigit($number[2], 'private_ruc') && 
                $this->validateEstablishmentCode(substr($number, 10, 3)) && 
                $this->module11Algorithm(substr($number, 0, 9), $number[9], 'private_ruc')
            ){
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }

        return false;
    }

    /**
     * Validar RUC sociedad publica
     *
     * @param  string  $number  Número de RUC sociedad publica
     *
     * @return Boolean
     */
    public function validateRucPublicSociety()
    {
        // fuerzo parametro de entrada a string
        $number = (string)$this->identificationNumber;

        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');

        // validaciones
        try {
            if(
                $this->initValidation($number, '13') && 
                $this->validateStateCode(substr($number, 0, 2)) && 
                $this->validateThirdDigit($number[2], 'public_ruc') && 
                $this->validateEstablishmentCode(substr($number, 9, 4)) && 
                $this->module11Algorithm(substr($number, 0, 8), $number[8], 'public_ruc')
            ){
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }

        return false;
    }

    /**
     * Validaciones iniciales para CI y RUC
     *
     * @param  string  $number      CI o RUC
     * @param  integer $caracteres  Cantidad de caracteres requeridos
     *
     * @return Boolean
     *
     * @throws exception Cuando valor esta vacio, cuando no es dígito y
     * cuando no tiene cantidad requerida de caracteres
     */
    protected function initValidation($number, $caracteres)
    {
        if (empty($number)) {
            $this->setError('Ingrese un número de RUC o Cédula para validarlo');
            return false;
        }

        if (!ctype_digit($number)) {
            $this->setError('Únicamente se aceptan dígitos');
            return false;
        }

        if (strlen($number) != $caracteres) {
            $this->setError('El número de cédula o RUC ingresado debe tener '.$caracteres.' caracteres');
            return false;
        }

        return true;
    }

    /**
     * Validación de código de provincia (dos primeros dígitos de CI/RUC)
     *
     * @param  string  $number  Dos primeros dígitos de CI/RUC
     *
     * @return boolean
     *
     * @throws exception Cuando el código de provincia no esta entre 00 y 24
     */
    protected function validateStateCode($number)
    {
        if ($number < 0 OR $number > 24) {
            $this->setError('Codigo de Provincia (dos primeros dígitos) no debe ser mayor a 24 ni menor a 0');
            return false;
        }

        return true;
    }

    /**
     * Validación de tercer dígito
     *
     * Permite validad el tercer dígito del documento. Dependiendo
     * del campo tipo (tipo de identificación) se realizan las validaciones.
     * Los posibles valores del campo tipo son: ID, natural_ruc, private_ruc
     *
     * Para Cédulas y RUC de personas naturales el terder dígito debe
     * estar entre 0 y 5 (0,1,2,3,4,5)
     *
     * Para RUC de sociedades privadas el terder dígito debe ser
     * igual a 9.
     *
     * Para RUC de sociedades públicas el terder dígito debe ser 
     * igual a 6.
     *
     * @param  string $number  tercer dígito de CI/RUC
     * @param  string $type  tipo de identificador
     *
     * @return boolean
     *
     * @throws exception Cuando el tercer digito no es válido. El mensaje
     * de error depende del tipo de Idenficiación.
     */
    protected function validateThirdDigit($number, $type)
    {
        switch ($type) {
            case 'ID':
            case 'natural_ruc':
                if ($number < 0 OR $number > 5) {
                    $this->setError('Tercer dígito debe ser mayor o igual a 0 y menor a 6 para cédulas y RUC de persona natural');
                    return false;
                }
                break;
            case 'private_ruc':
                if ($number != 9) {
                    $this->setError('Tercer dígito debe ser igual a 9 para sociedades privadas');
                    return false;
                }
                break;

            case 'public_ruc':
                if ($number != 6) {
                    $this->setError('Tercer dígito debe ser igual a 6 para sociedades públicas');
                    return false;
                }
                break;
            default:
                $this->setError('Tipo de Identificación no existe.');
                return false;
                break;
        }

        return true;
    }

    /**
     * Validación de código de establecimiento
     *
     * @param  string $number  tercer dígito de CI/RUC
     *
     * @return boolean
     *
     * @throws exception Cuando el establecimiento es menor a 1
     */
    protected function validateEstablishmentCode($number)
    {
        if ($number < 1) {
            $this->setError('Código de establecimiento no puede ser 0');
            return false;
        }

        return true;
    }

    /**
     * Algoritmo Modulo10 para validar si CI y RUC de persona natural son válidos.
     *
     * Los coeficientes usados para verificar el décimo dígito de la cédula,
     * mediante el algoritmo “Módulo 10” son:  2. 1. 2. 1. 2. 1. 2. 1. 2
     *
     * Paso 1: Multiplicar cada dígito de los initDigits por su respectivo
     * coeficiente.
     *
     *  Ejemplo
     *  initDigits posicion 1  x 2
     *  initDigits posicion 2  x 1
     *  initDigits posicion 3  x 2
     *  initDigits posicion 4  x 1
     *  initDigits posicion 5  x 2
     *  initDigits posicion 6  x 1
     *  initDigits posicion 7  x 2
     *  initDigits posicion 8  x 1
     *  initDigits posicion 9  x 2
     *
     * Paso 2: Sí alguno de los results de cada multiplicación es mayor a o igual a 10,
     * se suma entre ambos dígitos de dicho result. Ex. 12->1+2->3
     *
     * Paso 3: Se suman los results y se obtiene total
     *
     * Paso 4: Divido total para 10, se guarda residue. Se resta 10 menos el residue.
     * El valor obtenido debe concordar con el checkDigit
     *
     * Nota: Cuando el residue es cero(0) el dígito verificador debe ser 0.
     *
     * @param  string $initDigits   Nueve primeros dígitos de CI/RUC
     * @param  string $checkDigit  Décimo dígito de CI/RUC
     *
     * @return boolean
     *
     * @throws exception Cuando los initDigits no concuerdan contra
     * el código verificador.
     */
    protected function module10Algorithm($initDigits, $checkDigit)
    {
        $arrayCoeficientes = array(2,1,2,1,2,1,2,1,2);

        $checkDigit = (int)$checkDigit;
        $initDigits = str_split($initDigits);

        $total = 0;
        foreach ($initDigits as $key => $value) {

            $positionValue = ( (int)$value * $arrayCoeficientes[$key] );

            if ($positionValue >= 10) {
                $positionValue = str_split($positionValue);
                $positionValue = array_sum($positionValue);
                $positionValue = (int)$positionValue;
            }

            $total = $total + $positionValue;
        }

        $residue =  $total % 10;

        if ($residue == 0) {
            $result = 0;
        } else {
            $result = 10 - $residue;
        }

        if ($result != $checkDigit) {
            $this->setError('Dígitos iniciales no validan contra Dígito Idenficador');
            return false;
        }

        return true;
    }

    /**
     * Algoritmo Modulo11 para validar RUC de sociedades privadas y públicas
     *
     * El código verificador es el decimo digito para RUC de empresas privadas
     * y el noveno dígito para RUC de empresas públicas
     *
     * Paso 1: Multiplicar cada dígito de los initDigits por su respectivo
     * coeficiente.
     *
     * Para RUC privadas el coeficiente esta definido y se multiplica con las siguientes
     * posiciones del RUC:
     *
     *  Ejemplo
     *  initDigits posicion 1  x 4
     *  initDigits posicion 2  x 3
     *  initDigits posicion 3  x 2
     *  initDigits posicion 4  x 7
     *  initDigits posicion 5  x 6
     *  initDigits posicion 6  x 5
     *  initDigits posicion 7  x 4
     *  initDigits posicion 8  x 3
     *  initDigits posicion 9  x 2
     *
     * Para RUC privadas el coeficiente esta definido y se multiplica con las siguientes
     * posiciones del RUC:
     *
     *  initDigits posicion 1  x 3
     *  initDigits posicion 2  x 2
     *  initDigits posicion 3  x 7
     *  initDigits posicion 4  x 6
     *  initDigits posicion 5  x 5
     *  initDigits posicion 6  x 4
     *  initDigits posicion 7  x 3
     *  initDigits posicion 8  x 2
     *
     * Paso 2: Se suman los results y se obtiene total
     *
     * Paso 3: Divido total para 11, se guarda residue. Se resta 11 menos el residue.
     * El valor obtenido debe concordar con el checkDigit
     *
     * Nota: Cuando el residue es cero(0) el dígito verificador debe ser 0.
     *
     * @param  string $initDigits   Nueve primeros dígitos de RUC
     * @param  string $checkDigit  Décimo dígito de RUC
     * @param  string $type Tipo de identificador
     *
     * @return boolean
     *
     * @throws exception Cuando los initDigits no concuerdan contra
     * el código verificador.
     */
    protected function module11Algorithm($initDigits, $checkDigit, $type)
    {
        switch ($type) {
            case 'private_ruc':
                $arrayCoefficients = array(4, 3, 2, 7, 6, 5, 4, 3, 2);
                break;
            case 'public_ruc':
                $arrayCoefficients = array(3, 2, 7, 6, 5, 4, 3, 2);
                break;
            default:
                $this->setError('Tipo de Identificación no existe.');
                return false;
                break;
        }

        $checkDigit = (int)$checkDigit;
        $initDigits = str_split($initDigits);

        $total = 0;
        foreach ($initDigits as $key => $value) {
            $positionValue = ( (int)$value * $arrayCoefficients[$key] );
            $total = $total + $positionValue;
        }

        $residue =  $total % 11;

        if ($residue == 0) {
            $result = 0;
        } else {
            $result = 11 - $residue;
        }

        if ($result != $checkDigit) {
            $this->setError('Dígitos iniciales no validan contra Dígito Idenficador');
            return false;
        }

        return true;
    }

    /**
     * Get error
     *
     * @return string Mensaje de error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set error
     *
     * @param  string $newError
     * @return object $this
     */
    public function setError($newError)
    {
        $this->error = $newError;
        return $this;
    }
}