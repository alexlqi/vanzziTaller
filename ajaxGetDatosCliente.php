<?php
session_start();
require_once ('include/config.php');
require_once ('include/libreria.php');

if ($_GET['ID'] == 0)
{
	if (!isset($_GET['fecha'])) { $_GET['fecha'] = date('Y-m-d'); }
	$r = mysql_query("SELECT id,fecha,subtotal,descuento,iva FROM ventas WHERE fecha >= '".$_GET['fecha']." 00:00:00' AND fecha <= '".$_GET['fecha']." 23:59:59' AND clienteID IS NULL  AND facturaID IS NULL AND sucursalID = ".$_SESSION['usuarioSUCURSAL']." ORDER BY fecha ASC");
	$arrFecha = explode ('-',$_GET['fecha']);
	$arrMeses = array('01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');
?>
<h2>Ventas sin facturar</h2>
<div class="calendario">Ventas del dia&nbsp;&nbsp;
	<select name="day" id="day">
<?php
	for ($i = 1; $i <= 31; $i++)
	{
?>
		<option value="<?php echo sprintf('%02d',$i)?>"<?php if (intval($arrFecha[2]) == $i) { echo ' selected="selected"'; }?>><?php echo $i?></option>
<?php
	}
?>
    </select> / 
    <select name="month" id="month">
<?php
	foreach ($arrMeses as $k => $v)
	{
?>
		<option value="<?php echo $k?>"<?php if ($arrFecha[1] == $k) { echo ' selected="selected"'; }?>><?php echo $v?></option>
<?php
	}
?>
    </select> / 
    <select name="year" id="year">
<?php
	for ($i = date('Y') - 2; $i <= date('Y'); $i++)
	{
?>
		<option value="<?php echo $i?>"<?php if ($arrFecha[0] == $i) { echo ' selected="selected"'; }?>><?php echo $i?></option>
<?php
	}
?>
    </select>&nbsp;&nbsp;&nbsp;<input type="button" value="Ir" onclick="ajaxGetVentas();" />
</div>
<?php
	if (mysql_num_rows($r) > 0)
	{
?>
    <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="15%">No. de Ticket</td>
        <td width="17%">Fecha de Venta</td>
        <td width="17%">Subtotal</td>
        <td width="17%">Descuento</td>
        <td width="17%">I.V.A.</td>
        <td width="17%">Total</td>
      </tr>
<?php
			while ($reg = mysql_fetch_array($r))
			{
?>
      <tr class="fila">
        <td><?php echo sprintf('%05d',$reg['id'])?></td>
        <td><?php echo $reg['fecha']?></td>
        <td align="right"><?php echo '$ '.number_format($reg['subtotal'],2)?></td>
        <td align="right"><?php echo '$ '.number_format($reg['descuento'],2)?></td>
        <td align="right"><?php echo '$ '.number_format($reg['iva'],2)?></td>
        <td align="right"><?php echo '$ '.number_format($reg['subtotal'] - $reg['descuento'] + $reg['iva'],2)?></td>
      </tr>
<?php
			}
?>
    </table>
<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Facturar Ventas" />
        </td>
      </tr>
  </table>
<?php
	}
	else
	{
		echo '<div class="errorMsg">No se encontraron ventas sin facturar en el dia seleccionado</div>';
	}
}
else
{
	$r = mysql_query("SELECT a.id AS id, a.razonSocial AS razonSocial, a.rfc AS rfc, a.direccion AS direccion, a.colonia AS colonia, a.cp AS cp, b.nombre AS pais, c.nombre AS estado, d.nombre AS ciudad FROM clientes_datos_fiscales a JOIN config_paises b ON b.id = a.paisID JOIN config_estados c ON c.id = a.estadoID JOIN config_ciudades d ON d.id = a.ciudadID WHERE a.clienteID = ".$_GET['ID']);
	if (mysql_num_rows($r) > 0)
	{
		$cols = 3;
		$i = 1;
?>
<h2>Datos Fiscales</h2>
<?php
		echo '<table width="90%" align="center" cellpadding="5" cellspacing="10" border="0">';
		while ($reg = mysql_fetch_array($r))
		{
			if ($i == 1) { echo '<tr>'; }
			echo '<td class="datosFactura" onclick="selectThis(\''.$reg['id'].'\')"><div style="width:5%; float:right; margin-right:5px;"><input type="radio" name="datosFactura" id="datosFactura_'.$reg['id'].'" value="'.$reg['id'].'" checked="checked"></div>'.$reg['razonSocial'].'<br>'.$reg['rfc'].'<br>'.$reg['direccion'].'<br>Col. '.$reg['colonia'].', '.$reg['cp'].'<br>'.$reg['ciudad'].', '.$reg['estado'].', '.$reg['pais'].'</td>';
			if ($i == $cols) { echo '</tr>'; $i = 1; }
			else { $i++; }
		}
		for ($j = $i; $j <= $cols; $j++)
		{
			echo '<td>&nbsp;</td>';
			if ($j == $cols) { echo '</tr>'; }
		}
		echo '</table>';
		$r1 = mysql_query("SELECT id,fecha,subtotal,descuento,iva FROM ventas WHERE clienteID = ".$_GET['ID']." AND facturaID IS NULL ORDER BY fecha ASC");
		if (mysql_num_rows($r1) > 0)
		{
?>
<h2>Selecciona el concepto a facturar</h2>
<?php
			if ($_SESSION['usuarioFACTURACION'] == 1)
			{
?>
	<label>Personalizar Concepto de la factura</label>
    <textarea name="Alternativo" ></textarea>
<?php
			}
?>
	<label>Ventas</label>
    <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="5%">&nbsp;</td>
        <td width="15%">No. de Ticket</td>
        <td width="20%">Fecha de Venta</td>
        <td width="15%">Subtotal</td>
        <td width="15%">Descuento</td>
        <td width="15%">I.V.A.</td>
        <td width="15%">Total</td>
      </tr>
<?php
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
      <tr class="fila">
        <td align="center"><input type="radio" name="Concepto" value="Venta_<?php echo $reg1['id']?>" /></td>
        <td class="divFolio"><?php echo sprintf('%05d',$reg1['id'])?></td>
        <td><?php echo Fecha($reg1['fecha'],'d de M de A')?></td>
        <td align="right"><?php echo Moneda($reg1['subtotal'])?></td>
        <td align="right"><?php echo Moneda($reg1['descuento'])?></td>
        <td align="right"><?php echo Moneda($reg1['iva'])?></td>
        <td align="right"><?php echo Moneda($reg1['subtotal'] - $reg1['descuento'] + $reg1['iva'])?></td>
      </tr>
<?php
			}
?>
    </table>
    <br />
<?php
		}
		else
		{
			echo '<div class="errorMsg">No se encontraron ventas sin facturar de este cliente</div>';
		}
		$r1 = mysql_query("SELECT a.id AS id,a.fecha AS fecha,a.precio AS precio,b.placa AS placa,b.noSerie AS noSerie,b.year AS year,c.nombre AS marca,d.nombre AS modelo FROM servicios a JOIN clientes_vehiculos b ON b.id = a.vehiculoID JOIN config_vehiculos_marcas c ON c.id = b.marcaID JOIN config_vehiculos_modelos d ON d.id = b.modeloID WHERE a.clienteID = ".$_GET['ID']." AND a.estatusID = 3 ORDER BY a.fecha ASC");
?>
<label>Servicios</label>
<?php
		if (mysql_num_rows($r1) > 0)
		{
?>
    <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="5%">&nbsp;</td>
        <td width="15%">No. de Orden</td>
        <td width="15%">Fecha</td>
        <td width="35%">Automovil</td>
        <td width="10%">Subtotal</td>
        <td width="10%">I.V.A.</td>
        <td width="10%">Total</td>
      </tr>
<?php
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
      <tr class="fila">
        <td align="center"><input type="radio" name="Concepto" value="Servicio_<?php echo $reg1['id']?>" /></td>
        <td class="divFolio"><?php echo sprintf('%05d',$reg1['id'])?></td>
        <td><?php echo Fecha($reg1['fecha'],'d de M de A')?></td>
        <td><?php echo $reg1['placa'].' | '.$reg1['noSerie'].' | '.$reg1['marca'].' '.$reg1['modelo'].' '.$reg1['year']?></td>
        <td align="right"><?php echo Moneda($reg1['precio'])?></td>
        <td align="right"><?php echo Moneda($reg1['precio'] * (IVA / 100))?></td>
        <td align="right"><?php echo Moneda($reg1['precio'] + ($reg1['precio'] * (IVA / 100)))?></td>
      </tr>
<?php
			}
?>
    </table>
<?php
		}
		else
		{
			echo '<div class="errorMsg">No se encontraron servicios sin facturar de este cliente</div>';
		}
?>
    <br />
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="50%" align="right"><input type="submit" value="Facturar" /></td>
  </tr>
</table>
<?php
	}
	else
	{
		echo '<div class="errorMsg">Para poder facturar es necesario que el cliente cuente con datos fiscales</div>';
	}
}
?>
