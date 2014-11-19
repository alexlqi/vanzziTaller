<?php
session_start();
require_once ('include/config.php');
require_once ('include/libreria.php');

switch ($_GET['mod'])
{
	case 'Productos':
	{
		mysql_query("INSERT INTO productos_categorias (nombre) VALUE (".Limpia($_GET['nombre']).")");
		$IDCategoria = mysql_insert_id();
		
		$arrCategorias = array();
		$r = mysql_query("SELECT id,nombre FROM productos_categorias");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrCategorias[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'ManoObra':
	{
		mysql_query("INSERT INTO config_mano_obra_categorias (nombre) VALUE (".Limpia($_GET['nombre']).")");
		$IDCategoria = mysql_insert_id();
		
		$arrCategorias = array();
		$r = mysql_query("SELECT id,nombre FROM config_mano_obra_categorias");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrCategorias[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
}
?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" valign="top"><label>Categoria</label>
              <select name="categoria" id="categoria">
                <option value="" selected="selected"> - Selecciona -</option>
                <?php
if (count($arrCategorias) > 0)
{
	foreach ($arrCategorias as $k => $v)
	{
?>
                <option value="<?php echo $v['id']?>"<?php if ($IDCategoria == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
                <?php
	}
}
?>
              </select></td>
            <td width="50%"><label>Crear Nueva</label>
              <input type="text" name="nCategoria" id="nCategoria" style="width:70%;" />
              <input type="button" value="Crear" onclick="ajaxGetCategorias('<?php echo $_GET['mod']?>');" /></td>
          </tr>
      </table>