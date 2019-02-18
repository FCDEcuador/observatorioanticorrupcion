<?php
namespace BlaudCMS\Helpers;
  
class TimeFormat {

	public static function LongTimeFilter($date) {
        if ($date == null) {
            return "Sin fecha";
        }
 
        $start_date = $date;
        $since_start = $start_date->diff(new \DateTime(date("Y-m-d") . " " . date("H:i:s")));
 
        if ($since_start->y == 0) {
            if ($since_start->m == 0) {
                if ($since_start->d == 0) {
                    if ($since_start->h == 0) {
                        if ($since_start->i == 0) {
                            if ($since_start->s == 0) {
                                $result = $since_start->s . ' segundos';
                            } else {
                                if ($since_start->s == 1) {
                                    $result = $since_start->s . ' segundo';
                                } else {
                                    $result = $since_start->s . ' segundos';
                                }
                            }
                        } else {
                            if ($since_start->i == 1) {
                                $result = $since_start->i . ' minuto';
                            } else {
                                $result = $since_start->i . ' minutos';
                            }
                        }
                    } else {
                        if ($since_start->h == 1) {
                            $result = $since_start->h . ' hora';
                        } else {
                            $result = $since_start->h . ' horas';
                        }
                    }
                } else {
                    if ($since_start->d == 1) {
                        $result = $since_start->d . ' día';
                    } else {
                        $result = $since_start->d . ' días';
                    }
                }
            } else {
                if ($since_start->m == 1) {
                    $result = $since_start->m . ' mes';
                } else {
                    $result = $since_start->m . ' meses';
                }
            }
        } else {
            if ($since_start->y == 1) {
                $result = $since_start->y . ' año';
            } else {
                $result = $since_start->y . ' años';
            }
        }
 
        return "Hace " . $result;
    }


    /**
     * Metodo que devuelve el formato de fecha a utilizarce en el detalle de paquete para fechas de vigencia
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/04/28
     *
     * @param string date?
     * @return string
     */
    public static function dateShortFormat($date = ''){
        $aMonths = [
            '01' => 'ENE',
            '02' => 'FEB',
            '03' => 'MAR',
            '04' => 'ABR',
            '05' => 'MAY',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AGO',
            '09' => 'SEP',
            '10' => 'OCT',
            '11' => 'NOV',
            '12' => 'DIC',
        ];
        $aDaysNom = [
            'Mon' => 'LUN',
            'Tue' => 'MAR',
            'Wed' => 'MIE',
            'Thu' => 'JUE',
            'Fri' => 'VIE',
            'Sat' => 'SAB',
            'Sun' => 'DOM',
        ];
        if(!$date){
            $date = Date('Y-m-d');
        }
        $month = Date('m', strtotime($date));
        $day = Date('d', strtotime($date));
        $dayNom = Date('D', strtotime($date));
        $year = Date('Y', strtotime($date));
        $formatDate = $aDaysNom[$dayNom].', '.$aMonths[$month].' '.$day.', '.$year;
        return $formatDate;
    }


    /**
     * Metodo que devuelve el formato de fecha a utilizarce en el detalle de paquete para fechas de vigencia
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/04/28
     *
     * @param string date?
     * @return string
     */
    public static function dateLongFormat($date = ''){
        $aMonths = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        $aDaysNom = [
            'Mon' => 'Lunes',
            'Tue' => 'Martes',
            'Wed' => 'Miércoles',
            'Thu' => 'Jueves',
            'Fri' => 'Viernes',
            'Sat' => 'Sábado',
            'Sun' => 'Domingo',
        ];
        if(!$date){
            $date = Date('Y-m-d');
        }
        $month = Date('m', strtotime($date));
        $day = Date('d', strtotime($date));
        $dayNom = Date('D', strtotime($date));
        $year = Date('Y', strtotime($date));
        $formatDate = $aDaysNom[$dayNom].', '.$aMonths[$month].' '.$day.', '.$year.' '.Date('H:i:s', strtotime($date));
        return $formatDate;
    }
	
}