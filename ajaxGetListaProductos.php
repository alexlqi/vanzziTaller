<?php
session_start();
require_once('include/config.php');
require_once('include/libreria.php');

$arrProveedores = array();
$r = mysql_query("SELECT id,nombreComercial FROM productos_proveedores WHERE activo = 1 ORDER BY nombreComercial");
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
<table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="34%">
        <form id="form1" name="form1" method="post" onsubmit="ajaxGetListaProductos('UPC','divProductos','<?php echo $_GET['tipo']?>')" autocomplete="off">
        	<label>Buscar por UPC</label><input type="text" name="upc" id="upc" style="width:200px;"s>&nbsp;
        	<input type="submit" value="Buscar" />
        </form>
        </td>
        <td width="33%"><label>Buscar por Proveedor</label>
          <select name="proveedor" id="proveedor" onchange="ajaxGetListaProductos('Proveedor','divProductos','<?php echo $_GET['tipo']?>')">
          	<option value="" selected>- Selecciona -</option>
<?php
	if (count($arrProveedores) > 0)
	{
		foreach ($arrProveedores as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"<?php if($_GET['mod'] == 'Proveedor' and $_GET['ID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
		}
	}
?>
          </select>
        </td>
        <td width="33%"><label>Buscar por Categoria</label>
          <select name="categoria" id="categoria" onchange="ajaxGetListaProductos('Categoria','divProductos','<?php echo $_GET['tipo']?>')">
          	<option value="" selected>- Selecciona -</option>
<?php
	if (count($arrCategorias) > 0)
	{
		foreach ($arrCategorias as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"<?php if($_GET['mod'] == 'Categoria' and $_GET['ID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
		}
	}
?>
          </select>
        </td>
      </tr>
      </table>
<?php
switch ($_GET['tipo'])
{
	case 'Entrada':
	{
		switch ($_GET['mod'])
		{
			case 'Proveedor':
			{
				$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,a.costoActual AS costo,a.precio1 AS precio,a.factorConversion AS factor,b.nombre AS uEntrada,c.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadEntradaID JOIN productos_unidades c ON c.id = a.unidadSalidaID WHERE a.activo = 1 AND a.proveedorID = ".Limpia($_GET['ID']));
				break;
			}
			case 'Categoria':
			{
				$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,a.costoActual AS costo,a.precio1 AS precio,a.factorConversion AS factor,b.nombre AS uEntrada,c.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadEntradaID JOIN productos_unidades c ON c.id = a.unidadSalidaID WHERE a.activo = 1 AND a.categoriaID = ".Limpia($_GET['ID']));
				break;
			}
			case 'UPC':
			{
				$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,a.costoActual AS costo,a.precio1 AS precio,a.factorConversion AS factor,b.nombre AS uEntrada,c.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadEntradaID JOIN productos_unidades c ON c.id = a.unidadSalidaID WHERE a.activo = 1 AND a.upc = '".$_GET['ID']."'");
				break;
			}
		}
		if (mysql_num_rows($r) > 0)
		{
?>
<form id="form1" name="form1" method="post" action="backend.php?mod=Inventario&acc=Entrada" onsubmit="return ValidaForm(this,'Entrada');" autocomplete="off">
    <table width="98%" border="0" align="center" cellspacing="1" cellpadding="3" class="tabla1">
      <tr class="encabezado">
        <td width="28%">Producto</td>
        <td width="8%">Cantidad Recibida</td>
        <td width="8%">Unidad Entrada</td>
        <td width="8%">Costo Unitario</td>
        <td width="8%">Factor Conversion</td>
        <td width="8%">Unidades Ingresadas</td>
        <td width="8%">Unidad Salida</td>
        <td width="8%">Precio de Venta</td>
        <td width="8%">Existencia Actual</td>
      </tr>
<?php
			while ($reg = mysql_fetch_array($r))
			{
				$existencia = 0;
				$r1 = mysql_query("SELECT SUM(cantidad) AS existencia FROM productos_existencias WHERE productoID = ".$reg['id']);
				$reg1 = mysql_fetch_array($r1);
				$existencia += $reg1['existencia'];
?>
      <tr class="fila" id="fila<?php echo $reg['id']?>">
        <td><?php echo '<strong>'.$reg['clave'].'</strong><br>'.$reg['nombre']?></td>
        <td align="center"><input type="text" name="cantidad_<?php echo $reg['id']?>" id="cantidad_<?php echo $reg['id']?>" style="width:96%;" onkeyup="setEntrada(this.value,'<?php echo $reg['id']?>','<?php echo $reg['factor']?>');" /></td>
        <td align="center"><?php echo $reg['uEntrada']?></td>
        <td align="right"><?php echo '$ '.number_format($reg['costo'],2)?></td>
        <td align="center"><?php echo $reg['factor'].' x 1.00'?></td>
        <td align="center"><div id="cantidad<?php echo $reg['id']?>">0</div></td>
        <td align="center"><?php echo $reg['uSalida']?></td>
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
            <td width="50%" align="right"><input type="submit" value="Guardar Movimientos" /></td>
         </tr>
      </table>
</form>
<?php
		}
		else
		{
			echo '<div class="error">No se encontraron productos</div>';
		}
		break;
	}
	case 'Ajuste':
	{
		switch ($_GET['mod'])
		{
			case 'Proveedor':
			{
				$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,b.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.activo = 1 AND a.proveedorID = ".Limpia($_GET['ID']));
				break;
			}
			case 'Categoria':
			{
				$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,b.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.activo = 1 AND a.categoriaID = ".Limpia($_GET['ID']));
				break;
			}
			case 'UPC':
			{
				$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,b.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.activo = 1 AND a.upc = '".$_GET['ID']."'");
				break;
			}
		}
		if (mysql_num_rows($r) > 0)
		{
?>
<form id="form1" name="form1" method="post" action="backend.php?mod=Inventario&acc=Ajuste" onsubmit="return ValidaForm(this,'Ajuste');" autocomplete="off">
    <table width="98%" border="0" align="center" cellspacing="1" cellpadding="3" class="tabla1">
      <tr class="encabezado">
        <td width="30%">Producto</td>
        <td width="10%">Unidad Salida</td>
        <td width="10%">Existencia Actual en Bodega</td>
        <td width="12%">Existencia Fisica</td>
        <td width="38%">Motivo del Ajuste</td>
      </tr>
<?php
			while ($reg = mysql_fetch_array($r))
			{
				$existencia = 0;
				$r1 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r1) > 0)
				{
					$reg1 = mysql_fetch_array($r1);
					$existencia += $reg1['cantidad'];
				}
?>
      <tr class="fila" id="fila<?php echo $reg['id']?>">
        <td><?php echo '<strong>'.$reg['clave'].'</strong><br>'.$reg['nombre']?></td>
        <td align="center"><?php echo $reg['uSalida']?></td>
        <td align="center"><?php echo $existencia?></td>
        <td align="center"><input type="text" name="cantidad_<?php echo $reg['id']?>" id="cantidad_<?php echo $reg['id']?>" style="width:96%;" onkeyup="setAjuste(this.value,'<?php echo $reg['id']?>','<?php echo $existencia?>');" /></td>
        <td align="center"><textarea name="motivo_<?php echo $reg['id']?>" id="motivo_<?php echo $reg['id']?>" rows="3" style="width:96%;"></textarea></td>
      </tr>
<?php
			}
?>
      </table>
      <br />
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
         <tr>
            <td width="50%" align="right"><input type="submit" value="Guardar Movimientos" /></td>
         </tr>
      </table>
</form>
<?php
		}
		else
		{
			echo '<div class="error">No se encontraron productos</div>';
		}
		break;
	}
}
?>
<br />