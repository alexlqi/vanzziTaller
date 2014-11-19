<?php
session_start();
require_once('include/config.php');
require_once('include/libreria.php');

$arrClientes = array();
$r = mysql_query("SELECT c.id AS id, c.nombre AS nombre FROM ventas_partidas a JOIN ventas b ON b.id = a.ventaID JOIN clientes c ON c.id = b.clienteID WHERE a.estatus = 2 AND b.cerrada = 1 AND b.cancelada = 0");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrClientes[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
	}
}
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Ver Backorders del Cliente</label>
          <select name="cliente" id="cliente" onchange="ajaxGetBackorder()">
          	<option value="" selected>- Selecciona -</option>
<?php
if (count($arrClientes) > 0)
{
	foreach ($arrClientes as $k => $v)
	{
?>
			<option value="<?php echo $v['id']?>"<?php if ($_GET['ID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
	}
}
?>
          </select>
        </td>
      </tr>
      </table>
<?php
$r = mysql_query("SELECT a.id AS id, a.cantidad AS cantidad, a.precio AS precio, b.id AS ventaID, b.fecha AS fecha, c.id AS productoID, c.clave AS clave, c.nombre AS producto FROM ventas_partidas a JOIN ventas b ON b.id = a.ventaID JOIN productos c ON c.id = a.productoID WHERE a.estatus = 2 AND b.sucursalID = ".$_SESSION['usuarioSUCURSAL']." AND b.cerrada = 1 AND b.cancelada = 0 AND b.clienteID = ".Limpia($_GET['ID'])." ORDER BY b.fecha DESC");
if (mysql_num_rows($r) > 0)
{
?>
<form id="form1" name="form1" method="post" action="backend.php?mod=Venta&acc=Activar" onsubmit="return ValidaForm(this,'Entrada');" autocomplete="off">
    <table width="98%" border="0" align="center" cellspacing="1" cellpadding="3" class="tabla1">
      <tr class="encabezado">
        <td width="5%">&nbsp;</td>
        <td width="10%">Folio de Venta</td>
        <td width="15%">Fecha</td>
        <td width="35%">Producto</td>
        <td width="10%">Cantidad</td>
        <td width="15%">Precio de Venta</td>
        <td width="10%">Existencia Actual</td>
      </tr>
<?php
	while ($reg = mysql_fetch_array($r))
	{
		$existencia = 0;
		$r1 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
		if (mysql_num_rows($r1) > 0)
		{
			$reg1 = mysql_fetch_array($r1);
			$existencia = $reg1['cantidad'];
		}
?>
      <tr class="fila">
        <td><?php if ($existencia >= $reg['cantidad']) {?><input type="checkbox" name="checkbox" id="checkbox" /><?php } else { echo '&nbsp;'; }?></td>
        <td align="center"><?php echo sprintf('%05d',$reg['ventaID'])?></td>
        <td align="center"><?php echo Fecha($reg['fecha'],'d de M de A')?></td>
        <td><?php echo $reg['clave'].' - '.$reg['producto']?></td>
        <td align="center"><?php echo $reg['cantidad']?></td>
        <td align="right"><?php echo '$ '.number_format($reg['precio'],2)?></td>
        <td align="center"><?php echo $existencia?></td>
      </tr>
<?php
	}
?>
</table>
      <br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
         <tr>
            <td width="50%" align="right"><input type="submit" value="Activar" /></td>
         </tr>
  </table>
</form>
<?php
}
else
{
	echo '<div class="error">No se encontraron productos</div>';
}
?>
<br />