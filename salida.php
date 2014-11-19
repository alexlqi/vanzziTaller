<?php include ('header.php'); ?>
<div id="body">
<h1>Salida de Productos para Taller</h1>
<div id="forma">
<?php
$r = mysql_query("SELECT * FROM servicios WHERE cerrado = 0 AND usuarioID = ".$_SESSION['usuarioID']);
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
?>
	<h2>Productos Solicitados</h2>
    <div id="divVenta">
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="40%" valign="top">
          <form id="form1" name="form1" method="post" action="backend.php?mod=Servicio&acc=Add" autocomplete="off">
            <label>UPC</label><input type="text" name="upc" id="upc" style="width:200px;">&nbsp;
            <input type="submit" value="Agregar" />
            </form>
        </td>
        <td width="60%">
        <label>Buscar UPC por Nombre de Producto</label><input type="text" name="producto" id="producto" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('producto','Productos','divAutoBuscar');"><div id="divAutoBuscar"></div>
        </td>
        </tr>
      </table>
<?php
	$r1 = mysql_query("SELECT a.id AS id, a.cantidad AS cantidad, b.id AS productoID, b.clave AS clave, b.nombre AS producto, c.nombre AS uSalida FROM servicios_partidas a JOIN productos b ON b.id = a.productoID JOIN productos_unidades c ON c.id = b.unidadSalidaID WHERE a.servicioID = ".$reg['id']." ORDER BY id ASC");
	if (mysql_num_rows($r1) > 0)
	{
?>
    <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezadoVenta">
        <td width="6%">Cantidad</td>
        <td width="10%">U. de Salida</td>
        <td width="44%">Producto</td>
        <td width="5%">&nbsp;</td>
      </tr>
<?php
		while ($reg1 = mysql_fetch_array($r1))
		{
?>
      <tr class="filaVenta">
        <td align="right"><input name="cantidad_<?php echo $reg1['id']?>" type="text" id="cantidad_<?php echo $reg1['id']?>" value="<?php echo $reg1['cantidad']?>" style="width:50px;" onblur="saveServicio('Edita','<?php echo $reg1['id']?>');"></td>
        <td align="center"><?php echo $reg1['uSalida']?></td>
        <td><?php echo $reg1['clave'].' - '.$reg1['producto']?></td>
        <td align="center"><input type="button" value="-" title="Cancelar Partida" onclick="saveServicio('Cancela','<?php echo $reg1['id']?>');" /></td>
      </tr>
<?php
		}
?>
    </table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No se han agregado Productos a esta salida</div>';
	}
?>
    </div>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right"><input type="button" value="Cerrar Salida" onclick="finServicio('Cerrar')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Salida" onclick="finServicio('Cancelar')" /></td>
      </tr>
  </table>
<?php
}
else
{
?>
	<form id="form1" name="form1" method="post" action="backend.php?mod=Servicio&acc=AddFirst" autocomplete="off">
	<h2>Productos Solicitados</h2>
    <div id="divVenta">
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="40%" valign="top"><label>UPC</label><input type="text" name="upc" id="upc" style="width:200px;">&nbsp;<input type="submit" value="Agregar" /></td>
        <td width="60%"><label>Buscar UPC por Nombre de Producto</label><input type="text" name="producto" id="producto" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('producto','Productos','divAutoBuscar');"><div id="divAutoBuscar"></div>&nbsp;</td>
        </tr>
      </table>
<?php
echo '<div class="alertaMsg">No se han agregado Productos a esta salida</div>';
?>
    </div>
    </form>
<?php
}
?>
</div>
</div>
<?php include ('footer.php'); ?>