<?php
session_start();
include ('include/config.php');
switch ($_GET['div'])
{
	case 'divEstadoFiscal':
	{
		$r = mysql_query("SELECT id,nombre FROM config_estados WHERE paisID = ".$_GET['ID']);
		echo '<label>Estado</label>';
		echo '<select name="estadoFiscal" id="estadoFiscal" onchange="ajaxGetSelectValues(this.value,\'divCiudadFiscal\')">';
		echo '<option value="" selected="selected">- Selecciona -</option>';
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				echo '<option value="'.$reg['id'].'">'.utf8_encode($reg['nombre']).'</option>';
			}
		}
		echo '</select>';
		break;
	}
	case 'divCiudadFiscal':
	{
		$r = mysql_query("SELECT id,nombre FROM config_ciudades WHERE estadoID = ".$_GET['ID']);
		echo '<label>Ciudad</label>';
		echo '<select name="ciudadFiscal" id="ciudadFiscal">';
		echo '<option value="" selected="selected">- Selecciona -</option>';
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				echo '<option value="'.$reg['id'].'">'.utf8_encode($reg['nombre']).'</option>';
			}
		}
		echo '</select>';
		break;
	}
	case 'divEstado':
	{
		$r = mysql_query("SELECT id,nombre FROM config_estados WHERE paisID = ".$_GET['ID']." ORDER BY nombre ASC");
		echo '<label>Estado</label>';
		echo '<select name="estado" id="estado" onchange="ajaxGetSelectValues(this.value,\'divCiudad\')">';
		echo '<option value="" selected="selected">- Selecciona -</option>';
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				echo '<option value="'.$reg['id'].'">'.utf8_encode($reg['nombre']).'</option>';
			}
		}
		echo '</select>';
		break;
	}
	case 'divCiudad':
	{
		$r = mysql_query("SELECT id,nombre FROM config_ciudades WHERE estadoID = ".$_GET['ID']." ORDER BY nombre ASC");
		echo '<label>Ciudad</label>';
		echo '<select name="ciudad" id="ciudad">';
		echo '<option value="" selected="selected">- Selecciona -</option>';
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				echo '<option value="'.$reg['id'].'">'.utf8_encode($reg['nombre']).'</option>';
			}
		}
		echo '</select>';
		break;
	}
	case 'divModelo':
	{
		$r = mysql_query("SELECT id,nombre FROM config_vehiculos_modelos WHERE marcaID = ".$_GET['ID']." ORDER BY nombre ASC");
		echo '<label>Modelo</label>';
		echo '<select name="modelo" id="modelo">';
		echo '<option value="" selected="selected">- Selecciona -</option>';
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				echo '<option value="'.$reg['id'].'">'.utf8_encode($reg['nombre']).'</option>';
			}
		}
		echo '</select>';
		break;
	}
}
?>