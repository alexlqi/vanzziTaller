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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket de Servicios<?php echo ' - '.$arrInformacion['Nombre Comercial']?></title>
<link href="css/estilosTicket.css" type="text/css" rel="stylesheet" media="screen" />
<link href="css/estilosTicket.css" type="text/css" rel="stylesheet" media="print" />
</head>
<body>
<center><img src="imagenes/<?php echo $arrInformacion['Logotipo']?>" width="75" /></center>
<h1><?php echo $arrInformacion['Nombre Comercial']?></h1>
<h2><?php echo nl2br($arrInformacion['Direccion']).'<br>'.nl2br($arrInformacion['Telefonos'])?></h2>
<h2><?php echo nl2br($arrInformacion['Pagina Web'])?></h2>
<?php
$r = mysql_query("SELECT a.id AS id, a.fecha AS fecha, b.nombre AS usuario, c.nombre AS sucursal FROM servicios a JOIN config_usuarios b ON b.id = a.usuarioID JOIN config_sucursales c ON c.id = a.sucursalID WHERE a.id = ".Limpia($_GET['ID'])." AND a.cerrado = 1 AND a.cancelado = 0");
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
?>
<div id="cuerpoTicket">
	<center><?php echo Fecha($reg['fecha'],'w d de M de Y H:m:s')?></center>
	<div id="divID"><?php echo 'TICKET: '.sprintf('%05d',$reg['id'])?></div>
	<div id="divCliente"><?php echo 'USUARIO: '.strtoupper($reg['usuario'])?></div>
    <div class="clear"></div>
<?php
	$r1 = mysql_query("SELECT a.cantidad AS cantidad, b.clave AS clave, b.nombre AS producto, c.nombre AS unidadSalida FROM servicios_partidas a JOIN productos b ON b.id = a.productoID JOIN productos_unidades c ON c.id = b.unidadSalidaID WHERE a.servicioID = ".Limpia($_GET['ID'])." ORDER BY a.id ASC");
	if (mysql_num_rows($r1) > 0)
	{
?>
	<ul>
    	<li><div class="divProductoServicio top">Producto</div><div class="divCantidadServicio top">Cant</div><div class="clear"></div></li>
<?php
		while ($reg1 = mysql_fetch_array($r1))
		{
?>
		<li><div class="divProductoServicio"><?php if($reg1['clave'] <> '') { echo $reg1['clave'].'<br>'; } echo utf8_decode($reg1['producto'])?></div><div class="divCantidadServicio"><?php echo $reg1['cantidad']?></div><div class="clear"></div></li>
<?php
		}
?>
    </ul>
<?php
	}
?>
    <div class="clear"></div>
    <br />
    Este ticket corresponde a una salida de mercancia para servicio, no es valido como comprobante de compra.
</div>
<script type="text/javascript">
	//print();
	//window.location = 'venta.php';
</script>
<?php
}
/*else
{
	echo '<script type="text/javascript">';
	echo 'window.location = "index.php"';
	echo '</script>';
}*/
?>
</body>
</html>