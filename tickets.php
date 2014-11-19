<?php include ('header.php'); ?>
<?php
$arrClientes = array();
$r = mysql_query("SELECT b.id AS id, b.nombre AS nombre FROM ventas a JOIN clientes b ON b.id = a.clienteID WHERE a.cerrada = 1 AND a.cancelada = 0 GROUP BY a.clienteID ORDER BY b.nombre ASC");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrClientes[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
	}
}
?>
<div id="body">
<h1>Tickets</h1>
<div id="forma">
	<h2>Reimpresion de Tickets</h2>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="34%">
       	<label>Buscar por Fecha</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" />&nbsp;
       	<input type="button" value="Buscar" onclick="ajaxGetTickets('Fecha')" />
        </td>
        <td width="33%"><label>Buscar por Cliente</label>
          <select name="cliente" id="cliente" onchange="ajaxGetTickets('Cliente')">
          	<option value="" selected>- Selecciona -</option>
<?php
	$r = mysql_query("SELECT id FROM ventas WHERE cerrada = 1 AND cancelada = 0 AND clienteID IS NULL");
	if (mysql_num_rows($r) > 0)
	{
?>
			<option value="0">VENTAS DE MOSTRADOR</option>
<?php
	}
	if (count($arrClientes) > 0)
	{
		foreach ($arrClientes as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
		}
	}
?>
          </select>
        </td>
        <td width="33%">
       	<label>Buscar por Numero de Ticket</label><input type="text" name="ticket" id="ticket" style="width:200px;">&nbsp;
       	<input type="submit" value="Buscar" onclick="ajaxGetTickets('Ticket')" />
        </td>
      </tr>
      </table>
    <div id="divTickets"></div>
</div>
</div>
<?php include ('footer.php'); ?>