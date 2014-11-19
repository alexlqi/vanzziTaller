<?php session_start(); ?>
<?php require_once ('include/config.php'); ?>
<?php require_once ('include/libreria.php'); ?>
<?php
$SID = session_id();
if (!isset($_SESSION['sesionID']) or $_SESSION['sesionID'] <> $SID or !isset($_SESSION['sesionNAME']) or $_SESSION['sesionNAME'] <> 'AnetPV2012')
{
	header ('Location: index.php');
}
$arrInformacion = array();
$r = mysql_query("SELECT nombreCampo,valorCampo FROM configuracion WHERE nombreCampo = 'Nombre Comercial' OR nombreCampo = 'Direccion' OR nombreCampo = 'CP' OR nombreCampo = 'Telefonos' OR nombreCampo = 'Logotipo' OR nombreCampo = 'Pagina Web'");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrInformacion[$reg['nombreCampo']] = $reg['valorCampo'];
	}
}
$nombreUsuario = '';
$r = mysql_query("SELECT nombre FROM config_usuarios WHERE id = ".$_SESSION['PVAmNetUserCC']);
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$nombreUsuario = $reg['nombre'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Corte de Caja<?php echo ' - '.$arrInformacion['Nombre Comercial']?></title>
<link href="css/estilosTicket.css" type="text/css" rel="stylesheet" media="screen" />
<link href="css/estilosTicket.css" type="text/css" rel="stylesheet" media="print" />
</head>
<body>
<center><img src="imagenes/<?php echo $arrInformacion['Logotipo']?>" width="75" /></center>
<h1><?php echo $arrInformacion['Nombre Comercial']?></h1>
<h2><?php echo nl2br($arrInformacion['Direccion']).'<br>'.nl2br($arrInformacion['Telefonos'])?></h2>
<h2><?php echo nl2br($arrInformacion['Pagina Web'])?></h2>
<h1>CORTE DE CAJA</h1>
<h2><?php echo utf8_decode($nombreUsuario)?></h2>
<h2><?php echo Fecha(date('Y-m-d'),'w d de M de Y')?></h2>
<div id="cuerpoTicket">
<?php
$arrFormasPago = array();
$r = mysql_query("SELECT id,nombre FROM ventas_formas_pago");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrFormasPago[$reg['id']] = array('nombre' => $reg['nombre'], 'monto' => 0);
	}
}
$r = mysql_query("SELECT a.id AS id, a.subtotal AS subtotal, a.iva AS iva, b.id AS formaPagoID, b.nombre AS formaPago FROM ventas a JOIN ventas_formas_pago b ON b.id = a.formaPagoID WHERE a.usuarioID = ".$_SESSION['PVAmNetUserCC']." AND a.fecha >= '".date('Y-m-d')." 00:00:00' AND a.fecha <= '".date('Y-m-d')." 23:59:59' AND a.cerrada = 1 AND a.cancelada = 0");
if (mysql_num_rows($r) > 0)
{
?>
	<ul>
    	<li><div class="divNoTicket top">No. de Ticket</div><div class="divFormaPago top">F. de Pago</div><div class="divMonto top">Monto</div><div class="clear"></div></li>
<?php
	while ($reg = mysql_fetch_array($r))
	{
		$arrFormasPago[$reg['formaPagoID']]['monto'] += $reg['subtotal'] + $reg['iva'];
?>
		<li><div class="divNoTicket"><?php echo sprintf('%05d',$reg['id'])?></div><div class="divFormaPago"><?php echo $reg['formaPago']?></div><div class="divMonto"><?php echo Moneda($reg['subtotal'] + $reg['iva'])?></div><div class="clear"></div></li>
<?php
	}
?>
    </ul>
<?php
}
?>
	<br />
<?php
if (count($arrFormasPago) > 0)
{
	foreach ($arrFormasPago as $k => $v)
	{
?>
	<div class="labelImporte"><?php echo 'TOTAL EN '.$v['nombre']?></div><div class="cantidadImporte"><?php echo Moneda($v['monto'])?></div>
<?php
	}
}
unset ($_SESSION['PVAmNetUserCC']);
?>
    <div class="clear"></div>
<script type="text/javascript">
	print();
	window.close();
</script>
</div>
</body>
</html>