<?php include ('header.php'); ?>
<?php
if (isset($_GET['mod']) and $_GET['mod'] == 'Entrada')
{
	$arrProveedores = array();
	$r = mysql_query("SELECT id,nombreComercial FROM productos_proveedores ORDER BY nombreComercial");
	if (mysql_num_rows($r) > 0)
	{
		while ($reg = mysql_fetch_array($r))
		{
			$arrProveedores[] = array('id' => $reg['id'], 'nombre' => $reg['nombreComercial']);
		}
	}
	$arrCategorias = array();
	$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY nombre");
	if (mysql_num_rows($r) > 0)
	{
		while ($reg = mysql_fetch_array($r))
		{
			$arrCategorias[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
		}
	}
?>
<div id="body">
<h1>Inventario</h1>
<div id="forma">
	<h2>Entrada al Almacen</h2>
    <div id="divProductos">
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="34%">
        <form id="form1" name="form1" method="post" onsubmit="ajaxGetListaProductos('UPC','divProductos','Entrada')" autocomplete="off">
        	<label>Buscar por UPC</label><input type="text" name="upc" id="upc" style="width:200px;"s>&nbsp;
        	<input type="submit" value="Buscar" />
        </form>
        </td>
        <td width="33%"><label>Buscar por Proveedor</label>
          <select name="proveedor" id="proveedor" onchange="ajaxGetListaProductos('Proveedor','divProductos','Entrada')">
          	<option value="" selected>- Selecciona -</option>
<?php
	if (count($arrProveedores) > 0)
	{
		foreach ($arrProveedores as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
		}
	}
?>
          </select>
        </td>
        <td width="33%"><label>Buscar por Categoria</label>
          <select name="categoria" id="categoria" onchange="ajaxGetListaProductos('Categoria','divProductos','Entrada')">
          	<option value="" selected>- Selecciona -</option>
<?php
	if (count($arrCategorias) > 0)
	{
		foreach ($arrCategorias as $k => $v)
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
<?php
}
elseif (isset($_GET['mod']) and $_GET['mod'] == 'Ajuste')
{
	$arrProveedores = array();
	$r = mysql_query("SELECT id,nombreComercial FROM productos_proveedores ORDER BY nombreComercial");
	if (mysql_num_rows($r) > 0)
	{
		while ($reg = mysql_fetch_array($r))
		{
			$arrProveedores[] = array('id' => $reg['id'], 'nombre' => $reg['nombreComercial']);
		}
	}
	$arrCategorias = array();
	$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY nombre");
	if (mysql_num_rows($r) > 0)
	{
		while ($reg = mysql_fetch_array($r))
		{
			$arrCategorias[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
		}
	}
?>
<div id="body">
<h1>Inventario</h1>
<div id="forma">
	<h2>Ajuste de Inventario</h2>
    <div id="divProductos">
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="34%">
        <form id="form1" name="form1" method="post" onsubmit="ajaxGetListaProductos('UPC','divProductos','Ajuste')" autocomplete="off">
        	<label>Buscar por UPC</label><input type="text" name="upc" id="upc" style="width:200px;"s>&nbsp;
        	<input type="submit" value="Buscar" />
        </form>
        </td>
        <td width="33%"><label>Buscar por Proveedor</label>
          <select name="proveedor" id="proveedor" onchange="ajaxGetListaProductos('Proveedor','divProductos','Ajuste')">
          	<option value="" selected>- Selecciona -</option>
<?php
	if (count($arrProveedores) > 0)
	{
		foreach ($arrProveedores as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
		}
	}
?>
          </select>
        </td>
        <td width="33%"><label>Buscar por Categoria</label>
          <select name="categoria" id="categoria" onchange="ajaxGetListaProductos('Categoria','divProductos','Ajuste')">
          	<option value="" selected>- Selecciona -</option>
<?php
	if (count($arrCategorias) > 0)
	{
		foreach ($arrCategorias as $k => $v)
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
<?php
}
?>
<?php include ('footer.php'); ?>