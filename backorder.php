<?php include ('header.php'); ?>
<?php
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
<div id="body">
<h1>Backorder</h1>
<div id="forma">
	<h2>Activacion de Backorder</h2>
    <div id="divBackorder">
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
			<option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
	}
}
?>
          </select>
        </td>
      </tr>
      </table>
    </div>
</div>
</div>
<?php include ('footer.php'); ?>