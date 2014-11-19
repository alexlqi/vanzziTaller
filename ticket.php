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
$r = mysql_query("SELECT nombreCampo,valorCampo FROM configuracion WHERE nombreCampo = 'Nombre Comercial' OR nombreCampo = 'Direccion' OR nombreCampo = 'CP' OR nombreCampo = 'Telefonos' OR nombreCampo = 'Logotipo' OR nombreCampo = 'Pagina Web' OR nombreCampo = 'RFC'");
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
<title>Ticket de Compra<?php echo ' - '.$arrInformacion['Nombre Comercial']?></title>
<link href="css/estilosTicket.css" type="text/css" rel="stylesheet" media="screen" />
<link href="css/estilosTicket.css" type="text/css" rel="stylesheet" media="print" />
</head>
<body>
<center><img src="imagenes/<?php echo $arrInformacion['Logotipo']?>" width="75" /></center>
<h1><?php echo $arrInformacion['Nombre Comercial']?></h1>
<h2><?php echo nl2br($arrInformacion['Direccion']).'<br>'.nl2br($arrInformacion['Telefonos'])?></h2>
<h2><?php echo $arrInformacion['RFC']?></h2>
<h2><?php echo nl2br($arrInformacion['Pagina Web'])?></h2>
<?php
$r = mysql_query("SELECT a.id AS id, a.fecha AS fecha, a.subtotal AS subtotal, a.descuento AS descuento, a.iva AS iva, a.montoPago AS montoPago, a.porcentajeDescuento AS porcentajeDescuento, a.porcentajeIva AS porcentajeIva, a.clienteID AS clienteID, b.nombre AS usuario, c.nombre AS sucursal, d.nombre AS formaPago FROM ventas a JOIN config_usuarios b ON b.id = a.usuarioID JOIN config_sucursales c ON c.id = a.sucursalID JOIN ventas_formas_pago d ON d.id = a.formaPagoID WHERE a.id = ".Limpia($_GET['ID'])." AND a.cerrada = 1 AND a.cancelada = 0");
if (mysql_num_rows($r) > 0)
{
?>
<div id="cuerpoTicket">
<?php
	$reg = mysql_fetch_array($r);
	$subtotalDesc = $reg['subtotal'] - $reg['descuento'];
	$total = $subtotalDesc + $reg['iva'];
	$cliente = 'VENTA DE MOSTRADOR';
	if ($reg['clienteID'] <> NULL)
	{
		$r1 = mysql_query("SELECT nombre FROM clientes WHERE id = ".$reg['clienteID']);
		if (mysql_num_rows($r) > 0)
		{
			$reg1 = mysql_fetch_array($r1);
			$cliente = $reg1['nombre'];
		}
	}
?>
	<center><?php echo Fecha($reg['fecha'],'w d de M de Y H:m:s')?></center>
	<div id="divID"><?php echo 'TICKET: '.sprintf('%05d',$reg['id'])?></div>
	<div id="divCliente"><?php echo 'CLIENTE: '.strtoupper($cliente)?></div>
    <div class="clear"></div>
<?php
	$r1 = mysql_query("SELECT a.cantidad AS cantidad, a.precio AS precio, a.estatus AS estatus, b.clave AS clave, b.nombre AS producto, c.nombre AS unidadSalida FROM ventas_partidas a JOIN productos b ON b.id = a.productoID JOIN productos_unidades c ON c.id = b.unidadSalidaID WHERE a.estatus < 2 AND a.ventaID = ".Limpia($_GET['ID'])." ORDER BY a.id ASC");
	if (mysql_num_rows($r1) > 0)
	{
?>
	<ul>
    	<li><div class="divProducto top">Producto</div><div class="divCantidad top">Cant</div><div class="divMonto top">Monto</div><div class="clear"></div></li>
<?php
		while ($reg1 = mysql_fetch_array($r1))
		{
?>
		<li><div class="divProducto"><?php if ($reg1['estatus'] == 0) { echo '- '; } if($reg1['clave'] <> '') { echo $reg1['clave'].'<br>'; } echo utf8_decode($reg1['producto'])?></div><div class="divCantidad"><?php echo $reg1['cantidad']?></div><div class="divMonto"><?php if ($reg1['estatus'] == 0) { echo '- '; } echo Moneda($reg1['cantidad'] * $reg1['precio'])?></div><div class="clear"></div></li>
<?php
		}
?>
    </ul>
<?php
	}
?>
	<br />
	<div class="labelImporte">DESCUENTO (<?php echo $reg['porcentajeDescuento'].' %'?>)</div><div class="cantidadImporte"><?php echo Moneda($reg['descuento'])?></div>
    <div class="labelImporte">SUBTOTAL</div><div class="cantidadImporte"><?php echo Moneda($reg['subtotal'])?></div>
    <div class="labelImporte">I.V.A.</div><div class="cantidadImporte"><?php echo Moneda($reg['iva'])?></div>
    <div class="labelImporte">TOTAL</div><div class="cantidadImporte"><?php echo Moneda($reg['subtotal'] + $reg['iva'])?></div>
    <div class="labelImporte">MONTO DEL PAGO</div><div class="cantidadImporte"><?php echo Moneda($reg['montoPago'])?></div>
    <div class="labelImporte">CAMBIO</div><div class="cantidadImporte"><?php echo Moneda($reg['montoPago'] - ($reg['subtotal'] + $reg['iva']))?></div>
    <div class="labelImporte">FORMA DE PAGO</div><div class="cantidadImporte"><?php echo $reg['formaPago']?></div>
    <div class="clear"></div>
    <br />
    Gracias Por su Compra!!!<br />LE ATENDIO <?php echo strtoupper($reg['usuario'])?><br />VENTA DE SUCURSAL <?php echo strtoupper($reg['sucursal'])?>
</div>
<?php
	mysql_query("UPDATE ventas SET impresa = 1 WHERE id = ".Limpia($_GET['ID']));
?>
<script type="text/javascript">
	print();
	window.location = 'venta.php';
</script>
<?php
}
else
{
	echo '<script type="text/javascript">';
	echo 'window.location = "index.php"';
	echo '</script>';
}
?>
</body>
</html>