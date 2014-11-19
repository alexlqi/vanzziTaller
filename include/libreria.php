<?php
function Moneda($cantidad,$divisa='MXN')
{
	switch ($divisa)
	{
		case 'MXN': { $simbolo = '$'; break; }
		case 'USD': { $simbolo = 'USD $'; break; }
	}
	$resultado = $simbolo.' '.number_format($cantidad,2);
	return $resultado;
}

function Mes($mes)
{
	$temp = explode('-',$mes);
	switch ($temp[1])
	{
		case "01": { $m = "ENE"; break; }
		case "02": { $m = "FEB"; break; }
		case "03": { $m = "MAR"; break; }
		case "04": { $m = "ABR"; break; }
		case "05": { $m = "MAY"; break; }
		case "06": { $m = "JUN"; break; }
		case "07": { $m = "JUL"; break; }
		case "08": { $m = "AGO"; break; }
		case "09": { $m = "SEP"; break; }
		case "10": { $m = "OCT"; break; }
		case "11": { $m = "NOV"; break; }
		case "12": { $m = "DIC"; break; }
	}
	return $m.' '.$temp[0];
}

function Limpia($val)
{
	if (get_magic_quotes_gpc())
	{
		$val = stripslashes($val);
	}
	$f = (function_exists('mysql_real_escape_string')) ? "mysql_real_escape_string" : ((function_exists('mysql_escape_string')) ? "mysql_escape_string" : "addslashes");
	return (!is_numeric($val)) ? "'".$f($val)."'" : $val;
}

function Fecha($fecha,$formato)
{
	$arrDiasSemana = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
	if (strlen($fecha) > 10) { $hora = substr($fecha,11); $fecha = substr($fecha,0,10); }
	$arrFecha = explode('-',$fecha);
	switch ($formato)
	{
		case 'd/m/A':
		{
			switch ($arrFecha[1])
			{
				case '01': { $mes = 'Ene';	break; }
				case '02': { $mes = 'Feb';	break; }
				case '03': { $mes = 'Mar';	break; }
				case '04': { $mes = 'Abr';	break; }
				case '05': { $mes = 'May';	break; }
				case '06': { $mes = 'Jun';	break; }
				case '07': { $mes = 'Jul';	break; }
				case '08': { $mes = 'Ago';	break; }
				case '09': { $mes = 'Sep';	break; }
				case '10': { $mes = 'Oct';	break; }
				case '11': { $mes = 'Nov';	break; }
				case '12': { $mes = 'Dic';	break; }
			}
			$resultado = $arrFecha[2].' / '.$mes.' / '.$arrFecha[0];
			break;
		}
		case 'd de M de A':
		{
			switch ($arrFecha[1])
			{
				case "01": {$mes = "Enero";	break; }
				case "02": {$mes = "Febrero"; break; }
				case "03": {$mes = "Marzo";	break; }
				case "04": {$mes = "Abril";	break; }
				case "05": {$mes = "Mayo"; break; }
				case "06": {$mes = "Junio";	break; }
				case "07": {$mes = "Julio";	break; }
				case "08": {$mes = "Agosto"; break; }
				case "09": {$mes = "Septiembre"; break; }
				case "10": {$mes = "Octubre"; break; }
				case "11": {$mes = "Noviembre";	break; }
				case "12": {$mes = "Diciembre";	break; }
			}
			$resultado = $arrFecha[2].' de '.$mes.' de '.$arrFecha[0];
			break;
		}
		case 'w d de M de Y':
		{
			$w = date('w',mktime(0,0,0,$arrFecha[1],$arrFecha[2],$arrFecha[0]));
			switch ($arrFecha[1])
			{
				case "01": {$mes = "Enero";	break; }
				case "02": {$mes = "Febrero"; break; }
				case "03": {$mes = "Marzo";	break; }
				case "04": {$mes = "Abril";	break; }
				case "05": {$mes = "Mayo"; break; }
				case "06": {$mes = "Junio";	break; }
				case "07": {$mes = "Julio";	break; }
				case "08": {$mes = "Agosto"; break; }
				case "09": {$mes = "Septiembre"; break; }
				case "10": {$mes = "Octubre"; break; }
				case "11": {$mes = "Noviembre";	break; }
				case "12": {$mes = "Diciembre";	break; }
			}
			$resultado = $arrDiasSemana[$w].', '.$arrFecha[2].' de '.$mes.' de '.$arrFecha[0];
			break;
		}
		case 'w d de M de Y H:m:s':
		{
			$w = date('w',mktime(0,0,0,$arrFecha[1],$arrFecha[2],$arrFecha[0]));
			switch ($arrFecha[1])
			{
				case "01": {$mes = "Enero";	break; }
				case "02": {$mes = "Febrero"; break; }
				case "03": {$mes = "Marzo";	break; }
				case "04": {$mes = "Abril";	break; }
				case "05": {$mes = "Mayo"; break; }
				case "06": {$mes = "Junio";	break; }
				case "07": {$mes = "Julio";	break; }
				case "08": {$mes = "Agosto"; break; }
				case "09": {$mes = "Septiembre"; break; }
				case "10": {$mes = "Octubre"; break; }
				case "11": {$mes = "Noviembre";	break; }
				case "12": {$mes = "Diciembre";	break; }
			}
			$resultado = $arrDiasSemana[$w].', '.$arrFecha[2].' de '.$mes.' de '.$arrFecha[0].' '.$hora;
			break;
		}
	}
	return $resultado;
}

function Alerta($texto,$destino)
{
	echo '<script type="text/javascript">';
	echo 'alert("'.$texto.'");';
	if ($destino <> "")
	{
		echo 'window.location = "'.$destino.'";';
	}
	else
	{
		echo 'history.go(-1);';
	}
	echo '</script>';
}

function ReDimensionaImagen($imgOriginal,$imgRedimensionada,$alto,$ancho,$directorio)
{
	$infoImagen = getimagesize($directorio.$imgOriginal);
	$altoOr = $infoImagen[1];
	$anchoOr = $infoImagen[0];
	$tipoImagenOr = $infoImagen[2];
 
	if($anchoOr > $ancho or $altoOr > $alto)
	{
		if(($altoOr - $alto) > ($anchoOr - $ancho))
		{
			$ancho = round($anchoOr * $alto / $altoOr,0) ;    
		}
		else
		{
			$alto = round($altoOr * $ancho / $anchoOr,0);  
		}
	}
	else
	{
		$alto = $altoOr;
		$ancho = $anchoOr;
	}
 
	switch ($tipoImagenOr)
	{
		case 1:
		{
			$imgNueva = imagecreatetruecolor($ancho,$alto);
			$imgVieja = imagecreatefromgif($directorio.$imgOriginal);
			imagecopyresampled($imgNueva, $imgVieja, 0, 0, 0, 0, $ancho, $alto, $anchoOr, $altoOr);
			if (!imagegif($imgNueva, $directorio.$imgRedimensionada)) return false;
			break;
		}
		case 2:
		{
			$imgNueva = imagecreatetruecolor($ancho, $alto);
			$imgVieja = imagecreatefromjpeg($directorio.$imgOriginal);
			imagecopyresampled($imgNueva, $imgVieja, 0, 0, 0, 0, $ancho, $alto, $anchoOr, $altoOr);
			if (!imagejpeg($imgNueva, $directorio.$imgRedimensionada)) return false;
			break;
		}
		case 3:
		{
			$imgNueva = imagecreatetruecolor($ancho, $alto);
			$imgVieja = imagecreatefrompng($directorio.$imgOriginal);
			imagecopyresampled($imgNueva, $imgVieja, 0, 0, 0, 0, $ancho, $alto, $anchoOr, $altoOr);
			if (!imagepng($imgNueva, $directorio.$imgRedimensionada)) return false;
			break;
		}
	}
	return true;
}

function Num2Letra($num, $fem = false, $dec = false)
{ 
	$matuni[2]  = "dos"; 
	$matuni[3]  = "tres"; 
	$matuni[4]  = "cuatro"; 
	$matuni[5]  = "cinco"; 
	$matuni[6]  = "seis"; 
	$matuni[7]  = "siete"; 
	$matuni[8]  = "ocho"; 
	$matuni[9]  = "nueve"; 
	$matuni[10] = "diez"; 
	$matuni[11] = "once"; 
	$matuni[12] = "doce"; 
	$matuni[13] = "trece"; 
	$matuni[14] = "catorce"; 
	$matuni[15] = "quince"; 
	$matuni[16] = "dieciseis"; 
	$matuni[17] = "diecisiete"; 
	$matuni[18] = "dieciocho"; 
	$matuni[19] = "diecinueve"; 
	$matuni[20] = "veinte"; 
	$matunisub[2] = "dos"; 
	$matunisub[3] = "tres"; 
	$matunisub[4] = "cuatro"; 
	$matunisub[5] = "quin"; 
	$matunisub[6] = "seis"; 
	$matunisub[7] = "sete"; 
	$matunisub[8] = "ocho"; 
	$matunisub[9] = "nove"; 

	$matdec[2] = "veint"; 
	$matdec[3] = "treinta"; 
	$matdec[4] = "cuarenta"; 
	$matdec[5] = "cincuenta"; 
	$matdec[6] = "sesenta"; 
	$matdec[7] = "setenta"; 
	$matdec[8] = "ochenta"; 
	$matdec[9] = "noventa"; 
	$matsub[3]  = 'mill'; 
	$matsub[5]  = 'bill'; 
	$matsub[7]  = 'mill'; 
	$matsub[9]  = 'trill'; 
	$matsub[11] = 'mill'; 
	$matsub[13] = 'bill'; 
	$matsub[15] = 'mill'; 
	$matmil[4]  = 'millones'; 
	$matmil[6]  = 'billones'; 
	$matmil[7]  = 'de billones'; 
	$matmil[8]  = 'millones de billones'; 
	$matmil[10] = 'trillones'; 
	$matmil[11] = 'de trillones'; 
	$matmil[12] = 'millones de trillones'; 
	$matmil[13] = 'de trillones'; 
	$matmil[14] = 'billones de trillones'; 
	$matmil[15] = 'de billones de trillones'; 
	$matmil[16] = 'millones de billones de trillones'; 

	$num = trim((string)@$num); 
	if ($num[0] == '-')
	{ 
		$neg = 'menos '; 
		$num = substr($num, 1); 
	}
	else
	{ 
		$neg = ''; 
	}
	while ($num[0] == '0') $num = substr($num, 1); 
	if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
	$zeros = true; 
	$punt = false; 
	$ent = ''; 
	$fra = ''; 
	for ($c = 0; $c < strlen($num); $c++)
	{ 
		$n = $num[$c]; 
		if (! (strpos(".,'''", $n) === false))
		{ 
			if ($punt)
			{
				break;
			}
			else
			{ 
				$punt = true; 
				continue; 
			}
		}
		elseif (! (strpos('0123456789', $n) === false))
		{ 
			if ($punt)
			{ 
				if ($n != '0') $zeros = false; 
				$fra .= $n; 
			}
			else
			{
				$ent .= $n;
			}
		}
		else
		{ 
			break;
		}
	} 
	$ent = '     ' . $ent; 
	if ($dec and $fra and ! $zeros)
	{ 
		$fin = ' coma'; 
		for ($n = 0; $n < strlen($fra); $n++)
		{ 
			if (($s = $fra[$n]) == '0') { $fin .= ' cero'; }
			elseif ($s == '1') { $fin .= $fem ? ' una' : ' un'; }
			else { $fin .= ' ' . $matuni[$s]; }
		}
	}
	else
	{ 
		$fin = '';
	}
	if ((int)$ent === 0) return 'Cero ' . $fin; 
	$tex = ''; 
	$sub = 0; 
	$mils = 0; 
	$neutro = false; 
	while ( ($num = substr($ent, -3)) != '   ')
	{ 
		$ent = substr($ent, 0, -3); 
		if (++$sub < 3 and $fem)
		{ 
			$matuni[1] = 'una'; 
			$subcent = 'as'; 
		}
		else
		{ 
			$matuni[1] = $neutro ? 'un' : 'uno'; 
			$subcent = 'os'; 
		}
		$t = ''; 
		$n2 = substr($num, 1); 
		if ($n2 == '00')
		{ 
		}
		elseif ($n2 < 21)
		{ 
			$t = ' ' . $matuni[(int)$n2];
		}
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 


      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
}

function OrdenaArreglo ($arreglo, $campo, $descendente = false)
{
	$position = array();
	$newRow = array();
	foreach ($arreglo as $key => $row)
	{
		$position[$key]  = $row[$campo];
		$newRow[$key] = $row;
	}  
	if ($descendente) { arsort($position); }
	else { asort($position); }  
	$returnArray = array();
	foreach ($position as $key => $pos)
	{
		$returnArray[] = $newRow[$key];  
	}  
	return $returnArray;  
}
?>