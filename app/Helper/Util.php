<?php

namespace Muserpol\Helper;
use Carbon\Carbon;
use Muserpol\EconomicComplement;
use Auth;
class Util
{
	public static function getType1($affiliate)
    {
        $count = EconomicComplement::where('affiliate_id','=', rtrim($affiliate))->count();
		return $count;
    }
	public static function addcero($dato, $ceros)
	{	$numero_con_ceros='';
		if ($ceros == 13) { //carnet
			$diferencia = 13 - strlen($dato);
			for($i = 0 ; $i < $diferencia; $i++)
			{
			        $numero_con_ceros .= 0;
			}
			$numero_con_ceros .= $dato;
			return $numero_con_ceros;
		}
		elseif($ceros == 9) //cua
		{
			$diferencia = 9 - strlen($dato);
			for($i = 0 ; $i < $diferencia; $i++)
			{
			        $numero_con_ceros .= 0;
			}
			$numero_con_ceros .= $dato;
			return $numero_con_ceros;
		}

	}
	public static function FirstName($nom)
	{
		if ($nom) {
			$noms = explode(" ", $nom);
			if (count($noms) > 0) {
				return $noms[0];
			}
			else{
				return '';
			}
		}
	}

	public static function SecondName($nom)
	{
		if ($nom) {
			$noms = explode(" ", $nom);
			if (count($noms) > 1) {
				return $noms[1];
			}
			else{
				return '';
			}
		}
	}

	public static function RepeatedIdentityCard($identity_card)
	{
		if ($identity_card) {
			if (strpos($identity_card, '-') !== false) {
				$new_identity_card = explode("-", $identity_card);
				return $new_identity_card[0];
			}
		}
	}

	public static function CalcCategory($b_ant, $sue)
	{
		if ($b_ant == 0 || $sue == 0) {
			return 0;
		}
		else{
			return number_format($b_ant/$sue, 2, '.', ',');
		}
	}

	public static function CalcRegistration($nac, $pat, $mat, $nom, $sex)
	{
		if ($nac) {
			$newnac = explode("-", $nac);
			$nac_day = $newnac[2];
			$nac_month = $newnac[1];
			$nac_year = substr($newnac[0], -2);

			$month_first = substr($nac_month, 0, 1);
			$month_second = substr($nac_month, 1, 1);

			if($pat  <> ''){
				$pat_first = substr($pat, 0, 1);
			}
			else{
				$pat_first = '';
			}
			if($mat <> ''){
				$mat_first = substr($mat, 0, 1);
			}
			else{
				//preguntar
				$mat_first = substr($pat, 1, 1);
			}
			if($nom<> ''){
				$nom_first = substr($nom, 0, 1);
			}
			else{
				$nom_first = '';
			}

			if($sex == "M"){
				return $nac_year . $nac_month . $nac_day . $pat_first . $mat_first . $nom_first;
			}
			elseif ($sex == "F"){
				if($month_first = 0){
					$month_last = "5" .$month_second;
				}
				elseif ($month_first = 1) {
					$month_last = "6" . $month_second;
				}
				return $nac_year . $month_last . $nac_day . $pat_first . $mat_first . $nom_first;
			}
		}
	}

	public static function getAllDate($date)
    {
    	if ($date) {
			$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			return date("d", strtotime($date))." de ".$months[date("n", strtotime($date))-1]. " de ".date("Y", strtotime($date));
 		}
    }

	public static function replaceCharacter($string)
	{
		if ($string) {
			return str_replace("¥", "Ñ", $string);
		}
	}

	public static function separateCode($code)
	{
		if ($code) {
			$number = explode("/", $code);
			if ($number) {
				return $number[0];
			}
		}
	}













	public static function ucw($string)
	{
		if ($string) {
			return ucwords(strtolower($string));
		}
	}

	public static function decimal($number)
	{ if ($number) {
		$number = str_replace ( ',' , '' , $number );
		$sueMon = substr($number, 0, -2);
		$sueDeci = substr($number, -2);
		$sue = $sueMon . "." . $sueDeci;
		return $sue;
	  }
	}

	public static function date($date)
	{
		if ($date) {
			$nac_day = substr($date, 0, 2);
			$nac_month = substr($date, 2, 2);
			$nac_year = substr($date, 4, 4);

			return date($nac_year ."-". $nac_month ."-". $nac_day);
		}
	}

	public static function dateAADDMM($date)
	{
		if ($date) {
			$nac_year = substr($date, 0, 2);
			$nac_day = substr($date, 2, 2);
			$nac_month = substr($date, 4, 2);

	        $anios = array('2' => '19', '3' => '19', '4' => '19', '5' => '19', '6' => '19','7' => '19', '8' => '19', '9' => '19','0' => '20','1' => '20','2' => '20','3' => '20');
	        $a = substr($nac_year, 0, 1);

			return date($anios[$a] . $nac_year ."-". $nac_month ."-". $nac_day);
		}
	}

	public static function dateAAMMDD($date)
	{
		if ($date) {
			$nac_year = substr($date, 0, 2);
			$nac_month = substr($date, 2, 2);
			$nac_day = substr($date, 4, 2);

	        $anios = array('2' => '19', '3' => '19', '4' => '19', '5' => '19', '6' => '19','7' => '19', '8' => '19', '9' => '19','0' => '20','1' => '20','2' => '20','3' => '20');
	        $a = substr($nac_year, 0, 1);

			return date($anios[$a] . $nac_year ."-". $nac_month ."-". $nac_day);
		}
	}

	public static function dateDDMMAA($date)
	{
		if ($date) {
			$nac_day = substr($date, 0, 2);
			$nac_month = substr($date, 2, 2);
			$nac_year = substr($date, 4, 2);

	        $anios = array('2' => '19', '3' => '19', '4' => '19', '5' => '19', '6' => '19','7' => '19', '8' => '19', '9' => '19','0' => '20','1' => '20','2' => '20','3' => '20');
	        $a = substr($nac_year, 0, 1);

			return date($anios[$a] . $nac_year ."-". $nac_month ."-". $nac_day);
		}
	}

	public static function datePick($date)
	{
		if ($date) {
			$newdate = explode("/", $date);
			return date($newdate[2] ."-". $newdate[1] ."-". $newdate[0]);
		}
	}

	public static function DateUnion($date)
	{
		if ($date) {
			$newdate = explode("-", $date);
			return date($newdate[0] . $newdate[1] . $newdate[2]);
		}
	}

	public static function datePickPeriod($date)
	{
		if ($date) {
			$newdate = explode("/", $date);
			return date($newdate[1] ."-". $newdate[0] ."-1");
		}
	}

	public static function datePickYear($year)
	{
		if ($year) {
			return date($year ."-1-1");
		}
	}

	public static function zero($string)
	{
		if ($string) {
			return preg_replace('/^0+/', '', $string);
		}
	}

	public static function formatMoney($value)
	{
		if ($value) {
	    	$value = number_format($value, 2, '.', ',');
        	return $value;
		}
    }

	public static function formatPercentage($value)
	{
		if ($value) {
	    	$value = number_format($value, 2, '.', ',');
        	return $value . "%";
		}
    }

	public static function formatYear($year)
	{
		if ($year) {
			$first = substr($year, 0, 1);

			if ($first == '9') {
				return "19" . $year;
			}
			else{
				return "20" . $year;
			}
		}
	}

	public static function getAfp($afp)
	{
	    if ($afp == 'V') {
	        return true;
	    }
	    else if ($afp == 'F'){
	        return false;
	    }
	}

	public static function getMes($mes)
	{
	    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return $meses[$mes-1];
	}

	public static function getArrayMonths()
	{
		return array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril','5' => 'Mayo','6' => 'Junio','7' => 'Julio','8' => 'Agosto','9' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');
	}

	public static function getDateShort($date)
	{
		if ($date) {
        	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
			return date("d", strtotime($date))." ".$meses[date("n", strtotime($date))-1]. " ".date("Y", strtotime($date));
        }
	}

	public static function getDateAbrePeriod($date)
	{
		if ($date) {
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			return $meses[date("n", strtotime($date))-1]. " ".date("Y", strtotime($date));
        }
	}

	public static function getYear($date)
	{
		if ($date) {
			return date("Y", strtotime($date));
        }
	}

	public static function getfulldate($date)
	{
		if ($date) {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			return date("d", strtotime($date))." ".$meses[date("n", strtotime($date))-1]. " ".date("Y", strtotime($date));
        }
	}
	public static function getSemester($date)
	{
		if ($date) {
			if (date("n", strtotime($date))-1 < 7) {
				return "Primer";
			}else{
				return "Segundo";
			}
        }
	}

	public static function getfullmonthYear($date)
	{
		if ($date) {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			return $meses[date("n", strtotime($date))-1]. " ".date("Y", strtotime($date));
        }
	}

	public static function getYearsAndMonths($fech_ini, $fech_fin)
    {
    	if (!$fech_ini) {
    		return "";
    	}
    	else{
	        $fech_ini_ap = Carbon::create(date("Y", strtotime($fech_ini)), date("m", strtotime($fech_ini)), 1);
	        $fech_fin_apor = Carbon::create(date("Y", strtotime($fech_fin)), date("m", strtotime($fech_fin)), 1)->addMonth();
	        $years = $fech_ini_ap->diffInYears($fech_fin_apor);
	        $totalmonths = $years*12;
	        $months = $fech_ini_ap->diffInMonths($fech_fin_apor) - $totalmonths;

	        if($years || $months){
	        	$m = $months ? $months . " Meses" : '';
	        	$y = $years ? $years . " Años " : '';
	        	return $y . $m;
	        }
	        else{
	        		return "";
	        }
	    }
    }

    public static function getMonths2($fech_ini, $fech_fin)
    {
    	if (!$fech_ini) {
    		return "";
    	}
    	else{
	        $fech_ini_ap = Carbon::create(date("Y", strtotime($fech_ini)), date("m", strtotime($fech_ini)), 1);
	        $fech_fin_apor = Carbon::create(date("Y", strtotime($fech_fin)), date("m", strtotime($fech_fin)), 1)->addMonth();

	        $months = $fech_ini_ap->diffInMonths($fech_fin_apor);

	        if($months){
	        	return $months ? $months . " Meses" : '';
	        }
	        else{
	        		return "";
	        }
	    }
    }

    public static function getHowOldF($fech_ini, $fech_fin)
    {

        $fech_ini_f = Carbon::create(date("Y", strtotime($fech_ini)), date("m", strtotime($fech_ini)), 1);
        $fech_fin_f = Carbon::create(date("Y", strtotime($fech_fin)), date("m", strtotime($fech_fin)), 1);
        $years = $fech_ini_f->diffInYears($fech_fin_f);
        return $years;
    }

	public static function getDateEdit($date)
    {
        if ($date) {
		  return date("d", strtotime($date))."/".date("m", strtotime($date)). "/".date("Y", strtotime($date));
        }
    }

    public static function getdateforEditPeriod($date)
    {
        if ($date) {
		  return date("m", strtotime($date)). "/".date("Y", strtotime($date));
        }
    }

	public static function getMonthMM($month)
	{
        $months = array('1' => '01', '2' => '02', '3' => '03', '4' => '04', '5' => '05','6' => '06', '7' => '07', '8' => '08', '9' => '09', '10' => '10', '11' => '11', '12' => '12');
		return date($months[$month]);
	}

 	public static function encodeActivity($person = null, $action, $entity = null)
	{
		$person = $person->getFullName();
		$entity = $entity->getFullName();
		return trim("$person $action $entity");
	}

	public static function encodeNote($type, $person = null)
	{
		$person = $person->getFullName();
		$entity = $entity->getFullName();
		return trim("$person $action $entity");
	}


	private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
    ];
    private static $DECENAS = [
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
    ];
    private static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
    ];
    public static function convertir($number, $moneda = '', $centimos = '')
    {
        $converted = '';
        $decimales = '';
        if (($number < 0) || ($number > 999999999)) {
            return 'No es posible convertir el numero a letras';
        }
        $div_decimales = explode('.',$number);
        if(count($div_decimales) > 1){
            $number = $div_decimales[0];
            $decNumberStr = (string) $div_decimales[1];
            if(strlen($decNumberStr) == 2){
                $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
                $decCientos = substr($decNumberStrFill, 6);
                $decimales = self::convertGroup($decCientos);
            }
        }
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
            }
        }
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', self::convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertGroup($cientos));
            }
        }
        if(empty($decimales)){
            $valor_convertido = $converted . strtoupper($moneda);
        } else {
            $valor_convertido = $converted . strtoupper($moneda) . ' CON ' . $decimales . ' ' . strtoupper($centimos);
        }
        return $valor_convertido;
    }
    private static function convertGroup($n)
    {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }
        $k = intval(substr($n,1));
        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if(($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }
        return $output;
    }
    public static function getGender($gender)
    {
    	return $gender=='M'?'F':'M';
    }

    public static function getCurrentSemester()
    {
    	$current_date = Carbon::now();
    	$current_month = $current_date->format('m');
    	return $current_month<=8 ? "Primer" : "Segundo";

    }
    public static function getFullNameUser()
    {
    	return Auth::user()->first_name." ".Auth::user()->last_name; 
    }
    public static function wfStateName($wf_state_id)
    {
    	switch ($wf_state_id) {
    			case 1:
    				return 'Recepcionó';
    				break;
    			case 2:
    				return 'Revisó';
    				break;
    			case 3:
    				return 'Calificó';
    				break;
    			default:
    				return 'Edito';
    				break;
    		}	
    }
}
