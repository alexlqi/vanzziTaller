<?php
/*session_start();
$SID = session_id();
if (!isset($_SESSION['sesionID']) or $_SESSION['sesionID'] <> $SID or !isset($_SESSION['sesionNAME']) or $_SESSION['sesionNAME'] <> 'AnetPV2012')
{
	header ('Location: index.php');
}*/

require_once ('include/config.php');
require_once ('include/libreria.php');
require_once ('include/fpdf/fpdf.php');

$arrDatosFactura = array();
$r = mysql_query("SELECT nombreCampo,valorCampo FROM configuracion");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrDatosFactura[$reg['nombreCampo']] = $reg['valorCampo'];
	}
}
$partidasXhoja = 10;
$arrMeses = array('01' => 'Ene','02' => 'Feb','03' => 'Mar','04' => 'Abr','05' => 'May','06' => 'Jun','07' => 'Jul','08' => 'Ago','09' => 'Sep','10' => 'Oct','11' => 'Nov','12' => 'Dic');

$r = mysql_query("SELECT a.fecha AS fecha,a.concepto AS concepto,a.subtotal AS subtotal,a.descuento AS descuento,a.iva AS iva,a.digitosCuenta AS digitosCuenta,a.clienteID AS clienteID,a.datosFiscalesID AS datosFiscalesID,b.nombre AS metodoPago FROM facturas a JOIN facturas_metodos_pago b ON b.id = a.metodoPagoID WHERE a.id = ".Limpia($_GET['ID']));
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$cliente = 'Factura Global del Dia';
	$direccion = '----------------------------------------------------------------------';
	$ciudad = '-------------------------';
	$estado = '-------------------------';
	$cp = '--------------';
	$rfc = '----------------';
	if ($reg['datosFiscalesID'] <> NULL)
	{
		$r1 = mysql_query("SELECT a.razonSocial AS razonSocial, a.rfc AS rfc, a.telefono AS telefono, a.direccion AS direccion, a.colonia AS colonia, a.cp AS cp, b.nombre AS estado, c.nombre AS ciudad FROM clientes_datos_fiscales a JOIN config_estados b ON b.id = a.estadoID JOIN config_ciudades c ON c.id = a.ciudadID WHERE a.id = ".$reg['datosFiscalesID']);
		if (mysql_num_rows($r1) > 0)
		{
			$reg1 = mysql_fetch_array($r1);
			$cliente = $reg1['razonSocial'];
			$direccion = $reg1['direccion'].', Col. '.$reg1['colonia'];
			$ciudad = $reg1['ciudad'];
			$estado = $reg1['estado'];
			$cp = $reg1['cp'];
			$rfc = $reg1['rfc'];
		}
	}
	$r1 = mysql_query("SELECT fechaAprobacion,noSicofi,cbb FROM facturas_folios WHERE ".$_GET['ID']." >= folioInicial AND ".$_GET['ID']." <= folioFinal");
	$reg1 = mysql_fetch_array($r1);
	$fechaTemp = explode('-',$reg1['fechaAprobacion']);
	$fechaVigencia = date('Y-m-d',mktime(0,0,0,intval($fechaTemp[1]),intval($fechaTemp[2]),$fechaTemp[0] + 2));
	$noSicofi = $reg1['noSicofi'];
	$codigoBarras = $reg1['cbb'];
	$vigencia = explode('-',$fechaVigencia);
	
	$arrPartidas = array();
	if ($reg['concepto'] <> NULL)
	{
		$arrPartidas[] = array('cantidad' => '1', 'uMedida' => 'No Aplica', 'concepto' => $reg['concepto'], 'precio' => $reg['subtotal']);
	}
	else
	{
		$r1 = mysql_query("SELECT id FROM ventas WHERE facturaID = ".Limpia($_GET['ID'])." AND cerrada = 1 AND cancelada = 0");
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$r2 = mysql_query("SELECT a.cantidad AS cantidad, a.precio AS precio, b.clave AS clave, b.nombre AS nombre, c.nombre AS uMedida FROM ventas_partidas a JOIN productos b ON b.id = a.productoID JOIN productos_unidades c ON c.id = b.unidadSalidaID WHERE a.estatus = 1 AND a.ventaID = ".$reg1['id']);
				if (mysql_num_rows($r2) > 0)
				{
					while ($reg2 = mysql_fetch_array($r2))
					{
						$arrPartidas[] = array('cantidad' => $reg2['cantidad'], 'uMedida' => $reg2['uMedida'], 'concepto' => $reg2['clave'].' '.$reg2['nombre'], 'precio' => $reg2['precio']);
					}
				}
			}
		}
		else
		{
			$arrPaquetes = array();
			$r2 = mysql_query("SELECT id FROM servicios WHERE facturaID = ".Limpia($_GET['ID'])." AND estatusID = 4");
			if (mysql_num_rows($r2) > 0)
			{
				$reg2 = mysql_fetch_array($r2);
				$r3 = mysql_query("SELECT cantidad,precio,tipo,recursoID,paqueteID FROM servicios_partidas WHERE servicioID = ".$reg2['id']);
				if (mysql_num_rows($r3) > 0)
				{
					while ($reg3 = mysql_fetch_array($r3))
					{
						if ($reg3['paqueteID'] > 0 and !in_array($reg3['paqueteID'],$arrPaquetes))
						{
							$r4 = mysql_query("SELECT nombre FROM productos_paquetes WHERE id = ".$reg3['paqueteID']);
							$reg4 = mysql_fetch_array($r4);
							$arrPaquetes[] = $reg3['paqueteID'];
							$arrPartidas[] = array('cantidad' => '1', 'uMedida' => 'No Aplica', 'concepto' => 'Paquete '.$reg4['nombre'], 'precio' => $reg3['precio']);
						}
						elseif ($reg3['paqueteID'] == 0 and $reg3['tipo'] == 1)
						{
							$r4 = mysql_query("SELECT nombre FROM config_mano_obra WHERE id = ".$reg3['recursoID']);
							$reg4 = mysql_fetch_array($r4);
							$arrPartidas[] = array('cantidad' => '1', 'uMedida' => 'No Aplica', 'concepto' => $reg4['nombre'], 'precio' => $reg3['precio']);
						}
						elseif ($reg3['paqueteID'] == 0 and $reg3['tipo'] == 2)
						{
							$r4 = mysql_query("SELECT a.clave AS clave, a.nombre AS nombre, b.nombre AS uMedida FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.id = ".$reg3['recursoID']);
							$reg4 = mysql_fetch_array($r4);
							$arrPartidas[] = array('cantidad' => $reg3['cantidad'], 'uMedida' => $reg4['uMedida'], 'concepto' => $reg4['clave'].' '.$reg4['nombre'], 'precio' => $reg3['precio']);
						}
					}
				}
			}
		}
	}
	
	$paginas = 1;
	$pagina = 1;
	if (count($arrPartidas) > $partidasXhoja)
	{
		$paginas = ceil(count($arrPartidas) / $partidasXhoja);
	}
	
	$pdf = new FPDF('P','mm','Letter');
	$pdf -> AliasNbPages();
	$pdf -> SetAutoPageBreak(1,1.5);
	
	while ($pagina <= $paginas)
	{
		$pdf -> AddPage();
		$pdf -> Line(10,60,10,200);
		$pdf -> Line(25,60,25,200);
		$pdf -> Line(50,60,50,200);
		$pdf -> Line(155,60,155,200);
		$pdf -> Line(180,60,180,200);
		$pdf -> Line(205,60,205,200);
		$pdf -> Line(10,200,205,200);
		$pdf -> Image('imagenes/'.$arrDatosFactura['Logotipo'],165,10,40);
		$pdf -> Image('imagenes/codigos/'.$codigoBarras,10,225,30);
		$pdf -> SetFont('Arial','',9);
		$pdf -> SetXY(65,10);
		$pdf -> Cell(110,4,$arrDatosFactura['Razon Social'],0,2,'C');
		$pdf -> Cell(110,4,$arrDatosFactura['Domicilio'].'. Col. '.$arrDatosFactura['Colonia'],0,2,'C');
		$pdf -> Cell(110,4,'C.P. '.$arrDatosFactura['CP'].'. '.$arrDatosFactura['Ciudad'].', '.$arrDatosFactura['Estado'],0,2,'C');
		$pdf -> Cell(110,4,'T. '.$arrDatosFactura['Telefonos'],0,2,'C');
		$pdf -> Cell(110,4,$arrDatosFactura['Pagina Web'],0,2,'C');
		$pdf -> SetFont('Arial','B',9);
		$pdf -> SetFillColor(38,92,129);
		$pdf -> SetTextColor(255,255,255);
		$pdf -> SetXY(10,10);
		$pdf -> Cell(23,4,'Folio',1,0,'C',1);
		$pdf -> SetX(34);
		$pdf -> Cell(23,4,'Fecha',1,1,'C',1);
		$pdf -> SetY(19);
		$pdf -> Cell(47,4,'Lugar de expedición',1,1,'C',1);
		$pdf -> SetY(33);
		$pdf -> Cell(23,5,'Cliente',1,0,'L',1);
		$pdf -> SetX(160);
		$pdf -> Cell(15,5,'R.F.C.',1,1,'L',1);
		$pdf -> SetY(39);
		$pdf -> Cell(23,5,'Domicilio',1,1,'L',1);
		$pdf -> SetY(45);
		$pdf -> Cell(23,5,'Ciudad',1,0,'L',1);
		$pdf -> SetX(120);
		$pdf -> Cell(15,5,'Estado',1,0,'L',1);
		$pdf -> SetX(180);
		$pdf -> Cell(10,5,'C.P.',1,1,'L',1);
		$pdf -> Ln();
		$pdf -> Cell(15,5,'Cant',1,0,'C',1);
		$pdf -> SetX(25);
		$pdf -> Cell(25,5,'U Medida',1,0,'C',1);
		$pdf -> SetX(50);
		$pdf -> Cell(110,5,'Concepto',1,0,'C',1);
		$pdf -> SetX(155);
		$pdf -> Cell(25,5,'P Unitario',1,0,'C',1);
		$pdf -> SetX(180);
		$pdf -> Cell(25,5,'Monto',1,1,'C',1);
		$pdf -> SetXY(155,200);
		$pdf -> Cell(25,5,'Subtotal',1,1,'R',1);
		$pdf -> SetXY(155,205);
		$pdf -> Cell(25,5,'Descuento',1,1,'R',1);
		$pdf -> SetXY(155,210);
		$pdf -> Cell(25,5,'I.V.A.',1,1,'R',1);
		$pdf -> SetXY(155,215);
		$pdf -> Cell(25,5,'Total',1,1,'R',1);
		$pdf -> SetXY(10,210);
		$pdf -> Cell(144,5,'Importe con letra',1,1,'C',1);
		$pdf -> SetXY(50,225);
		$pdf -> Cell(63,5,'Numero de aprobacion SICOFI',1,0,'C',1);
		$pdf -> SetX(114);
		$pdf -> Cell(45,5,'Método de pago',1,0,'C',1);
		if ($reg['digitosCuenta'] <> NULL)
		{
			$pdf -> SetX(160);
			$pdf -> Cell(45,5,'No. de cuenta',1,1,'C',1);
		}
		$pdf -> SetXY(15,258);
		$pdf -> Cell(80,5,'PAGO EN UNA SOLA EXHIBICION',0,0,'C',1);
		$pdf -> SetX(120);
		$pdf -> Cell(80,5,'EFECTOS FISCALES AL PAGO',0,0,'C',1);
		$pdf -> SetFont('Times','B',8);
		$pdf -> SetTextColor(149,39,34);
		$pdf -> SetXY(10,14);
		$pdf -> Cell(23,4,sprintf('%06d',$_GET['ID']),1,0,'C');
		$pdf -> SetFont('Times','',9);
		$pdf -> SetTextColor(0,0,0);
		$pdf -> SetX(34);
		$pdf -> Cell(23,4,substr($reg['fecha'],8,2).' / '.$arrMeses[substr($reg['fecha'],5,2)].' / '.substr($reg['fecha'],0,4),1,1,'C');
		$pdf -> SetY(23);
		$pdf -> Cell(47,4,$arrDatosFactura['Emision de Factura'],1,1,'C');
		$pdf -> SetXY(33,33);
		$pdf -> Cell(127,5,$cliente,1);
		$pdf -> SetXY(175,33);
		$pdf -> Cell(30,5,$rfc,1);
		$pdf -> SetXY(33,39);
		$pdf -> Cell(172,5,$direccion,1);
		$pdf -> SetXY(33,45);
		$pdf -> Cell(87,5,$ciudad,1);
		$pdf -> SetXY(135,45);
		$pdf -> Cell(45,5,$estado,1);
		$pdf -> SetXY(190,45);
		$pdf -> Cell(15,5,$cp,1);
		$partidaFinal = $pagina * $partidasXhoja;
		if ($pagina == $paginas) { $partidaFinal = count($arrPartidas); }
		$pdf -> SetXY(10,60);
		for ($i = ($pagina - 1) * $partidasXhoja; $i < $partidaFinal; $i++)
		{
			$pdf -> Cell(15,5,$arrPartidas[$i]['cantidad'],0,0,'C');
			$pdf -> SetX(25);
			$pdf -> Cell(25,5,$arrPartidas[$i]['uMedida'],0,0,'C');
			$pdf -> SetX(155);
			$pdf -> Cell(25,5,'$ '.number_format($arrPartidas[$i]['precio'],2),0,0,'R');
			$pdf -> SetX(180);
			$pdf -> Cell(25,5,'$ '.number_format($arrPartidas[$i]['precio'] * $arrPartidas[$i]['cantidad'],2),0,0,'R');
			$pdf -> SetX(50);
			$pdf -> MultiCell(105,5,$arrPartidas[$i]['concepto']);
		}
		$arrTotal = explode('.',number_format($reg['subtotal'] + $reg['iva'],2));
		$pdf -> SetXY(10,215);
		$pdf -> MultiCell(144,5,strtoupper(Num2Letra(floor($reg['subtotal'] + $reg['iva']))).' PESOS '.$arrTotal[1].'/100 M.N.',1);
		$pdf -> SetXY(180,200);
		$pdf -> Cell(25,5,'$ '.number_format($reg['subtotal'],2),1,0,'R');
		$pdf -> SetXY(180,205);
		$pdf -> Cell(25,5,'$ '.number_format($reg['descuento'],2),1,0,'R');
		$pdf -> SetXY(180,210);
		$pdf -> Cell(25,5,'$ '.number_format($reg['iva'],2),1,0,'R');
		$pdf -> SetXY(180,215);
		$pdf -> Cell(25,5,'$ '.number_format($reg['subtotal'] - $reg['descuento'] + $reg['iva'],2),1,0,'R');
		$pdf -> SetXY(50,230);
		$pdf -> Cell(63,5,$noSicofi,1,0,'C');
		$pdf -> SetX(114);
		$pdf -> Cell(45,5,$reg['metodoPago'],1,0,'C');
		if ($reg['digitosCuenta'] <> NULL)
		{
			$pdf -> SetX(160);
			$pdf -> Cell(45,5,$reg['digitosCuenta'],1,1,'C');
		}
		$pdf -> SetFont('Arial','B',9);
		$pdf -> SetXY(50,237);
		$pdf -> Cell(155,5,'CONTRIBUYENTE DEL REGIMEN '.strtoupper($arrDatosFactura['Regimen']).' DE '.strtoupper($arrDatosFactura['Actividad']).'.',0,0,'C');
		$pdf -> SetXY(50,244);
		$pdf -> MultiCell(155,5,'"La reproducción apócrifa de este comprobante constituye un delito en los términos de las disposiciones fiscales"',0,'C');
		$pdf -> SetFont('Arial','',7);
		$pdf -> SetXY(10,265);
		$pdf -> Cell(195,4,'"Este comprobante tendrá una vigencia de dos años contados a partir de la fecha de aprobación de la asignación de folios, la cual es: '.$vigencia[2].'/'.$arrMeses[$vigencia[1]].'/'.$vigencia[0].'"',0,0,'C');
		$pagina++;
	}
	$pdf -> Output();
}
else
{
	echo '<div align="center">La factura que intentas imprimir no existe</div>';
}
?>