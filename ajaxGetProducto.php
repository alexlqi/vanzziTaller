<?php
session_start();
require_once('include/config.php');
require_once('include/libreria.php');

$clave = $_GET['clave'];
$producto = 'PRODUCTO NO ENCONTRADO';
$uSalida = '----------';
$precio = '----------';
$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,a.precio1 AS precio,b.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.clave = ".Limpia($_GET['clave']));
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$clave = $reg['clave'];
	$producto = $reg['nombre'];
	$uSalida = $reg['uSalida'];
	$precio = '$ '.number_format($reg['precio'],2);
}
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="15%"><label>Clave</label>
          <input type="text" name="clave" id="clave" onblur="ajaxGetProducto()" value="<?php echo $clave?>"></td>
        <td width="35%"><label>Producto</label><input type="text" name="producto" id="producto" value="<?php echo $producto?>" readonly></td>
        <td width="15%"><label>Cantidad</label>
          <input type="text" name="cantidad" id="cantidad" value="1"></td>
        <td width="15%"><label>Unidad de Salida</label>
          <input type="text" name="uSalida" id="uSalida" value="<?php echo $uSalida?>" readonly></td>
        <td width="15%" valign="bottom"><label>Precio Unitario</label>
          <input type="text" name="precio" id="precio" value="<?php echo $precio?>" readonly></td>
        <td width="5%" align="center" valign="bottom"><input type="button" value="+"<?php if ($producto == 'PRODUCTO NO ENCONTRADO') { echo ' disabled="disabled"'; } else { echo ' onClick="ajaxSaveProducto(\'Add\',\''.$reg['id'].'\');"'; }?>></td>
      </tr>
      </table>