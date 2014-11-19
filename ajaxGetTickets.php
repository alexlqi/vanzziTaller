<?php
session_start();
require_once('include/config.php');
require_once('include/libreria.php');
switch ($_GET['mod'])
{
	case 'Cliente':
	{
		if ($_GET['ID'] == 0)
		{
			$r = mysql_query("SELECT a.id AS id,a.fecha AS fecha,a.subtotal AS subtotal,a.descuento AS descuento,a.iva AS iva,a.clienteID AS clienteID,b.nombre AS formaPago FROM ventas a JOIN ventas_formas_pago b ON b.id = a.formaPagoID WHERE a.cerrada = 1 AND a.cancelada = 0 AND a.clienteID IS NULL");
		}
		else
		{
			$r = mysql_query("SELECT a.id AS id,a.fecha AS fecha,a.subtotal AS subtotal,a.descuento AS descuento,a.iva AS iva,a.clienteID AS clienteID,b.nombre AS formaPago FROM ventas a JOIN ventas_formas_pago b ON b.id = a.formaPagoID WHERE a.cerrada = 1 AND a.cancelada = 0 AND a.clienteID = ".Limpia($_GET['ID']));
		}
		break;
	}
	case 'Fecha':
	{
		$fechaInicio = $_GET['ID'].' 00:00:00';
		$fechaFin = $_GET['ID'].' 23:59:59';
		$r = mysql_query("SELECT a.id AS id,a.fecha AS fecha,a.subtotal AS subtotal,a.descuento AS descuento,a.iva AS iva,a.clienteID AS clienteID,b.nombre AS formaPago FROM ventas a JOIN ventas_formas_pago b ON b.id = a.formaPagoID WHERE a.cerrada = 1 AND a.cancelada = 0 a.fecha >= '".$fechaInicio."' AND a.fecha <= '".$fechaFin."'");
		break;
	}
	case 'Ticket':
	{
		$r = mysql_query("SELECT a.id AS id,a.fecha AS fecha,a.subtotal AS subtotal,a.descuento AS descuento,a.iva AS iva,a.clienteID AS clienteID,b.nombre AS formaPago FROM ventas a JOIN ventas_formas_pago b ON b.id = a.formaPagoID WHERE a.cerrada = 1 AND a.cancelada = 0 AND a.id = ".Limpia($_GET['ID']));
		break;
	}
}
if (mysql_num_rows($r) > 0)
{
?>
    <table width="98%" border="0" align="center" cellspacing="1" cellpadding="3" class="tabla1">
      <tr class="encabezado">
        <td width="10%">No. de Ticket</td>
        <td width="15%">Fecha</td>
        <td width="35%">Cliente</td>
        <td width="10%">Subtotal</td>
        <td width="10%">I.V.A.</td>
        <td width="10%">Total</td>
        <td width="10%">&nbsp;</td>
      </tr>
<?php
	while ($reg = mysql_fetch_array($r))
	{
		$cliente = 'VENTAS MOSTRADOR';
		if ($reg['clienteID'] <> NULL)
		{
			$r1 = mysql_query("SELECT nombre FROM clientes WHERE id = ".$reg['clienteID']);
			$reg1 = mysql_fetch_array($r1);
			$cliente = $reg1['nombre'];
		}
?>
      <tr class="fila">
        <td><?php echo sprintf('%05d',$reg['id'])?></td>
        <td align="center"><?php echo Fecha($reg['fecha'],'d/m/A')?></td>
        <td><?php echo $cliente?></td>
        <td align="right"><?php echo '$ '.number_format($reg['subtotal'],2)?></td>
        <td align="right"><?php echo '$ '.number_format($reg['iva'],2)?></td>
        <td align="right"><?php echo '$ '.number_format($reg['subtotal'] + $reg['iva'],2)?></td>
        <td align="center"><input type="button" value="Imprimir" onclick="window.location = 'ticket.php?ID=<?php echo $reg['id']?>'" /></td>
      </tr>
<?php
	}
?>
</table>
<?php
}
else
{
	echo '<div class="error">No se encontraron tickets</div>';
}
?>
<br />