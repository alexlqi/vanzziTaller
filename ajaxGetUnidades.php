<?php
session_start();
require_once ('include/config.php');
require_once ('include/libreria.php');

$IDUnidad = 0;
if (isset($_GET['nombre']))
{
	mysql_query("INSERT INTO productos_unidades (nombre) VALUE (".Limpia($_GET['nombre']).")");
	$IDUnidad = mysql_insert_id();
}

$arrUnidades = array();
$r = mysql_query("SELECT id,nombre FROM productos_unidades");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrUnidades[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
	}
}
if ($_GET['divID'] == 'divUEntrada')
{
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" valign="top"><label>Unidad de Entrada</label>
                <select name="uEntrada" id="uEntrada">
                  <option value="" selected="selected">- Selecciona -</option>
                  <?php
if (count($arrUnidades) > 0)
{
	foreach ($arrUnidades as $k => $v)
	{
?>
                  <option value="<?php echo $v['id']?>"<?php if ($IDUnidad == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
                  <?php
	}
}
?>
                </select></td>
              <td width="50%"><label>Crear Nueva</label>
                <input type="text" name="nUEntrada" id="nUEntrada" />
                <input type="button" value="Crear" onclick="ajaxGetUnidades('nUEntrada','divUEntrada');" /></td>
            </tr>
          </table>
<?php	
}
else
{
?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" valign="top"><label>Unidad de Salida</label>
                <select name="uSalida" id="uSalida">
                  <option value="" selected="selected">- Selecciona -</option>
                  <?php
if (count($arrUnidades) > 0)
{
	foreach ($arrUnidades as $k => $v)
	{
?>
                  <option value="<?php echo $v['id']?>"<?php if ($IDUnidad == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
                  <?php
	}
}
?>
                </select></td>
              <td width="50%"><label>Crear Nueva</label>
                <input type="text" name="nUSalida" id="nUSalida" />
                <input type="button" value="Crear" onclick="ajaxGetUnidades('nUSalida','divUSalida');" /></td>
            </tr>
          </table>
<?php
}
?>