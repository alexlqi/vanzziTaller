<?php
session_start();
require_once('include/config.php');
require_once('include/libreria.php');

$arrResultados = array();
switch ($_GET['mod'])
{
	case 'Proveedores':
	{
		$r = mysql_query("SELECT id,nombreComercial FROM productos_proveedores WHERE nombreComercial LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombreComercial']));
			}
		}
		break;
	}
	case 'Clientes':
	{
		$r = mysql_query("SELECT id,nombre FROM clientes WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'Ventas':
	{
		$r = mysql_query("SELECT id,nombre FROM clientes WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'Servicio':
	{
		$r = mysql_query("SELECT id,nombre FROM clientes WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'Sucursales':
	{
		$r = mysql_query("SELECT id,nombre FROM config_sucursales WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
			}
		}
		break;
	}
	case 'Productos':
	{
		$r = mysql_query("SELECT upc,nombre FROM productos WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['upc'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'Facturacion':
	{
		$r = mysql_query("SELECT id,nombre FROM clientes WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'Usuarios':
	{
		$r = mysql_query("SELECT id,nombre FROM config_usuarios WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'Marcas':
	{
		$r = mysql_query("SELECT id,nombre FROM config_vehiculos_marcas WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
	case 'ManoObra':
	{
		$r = mysql_query("SELECT id,nombre FROM config_mano_obra WHERE nombre LIKE '".$_GET['Search']."%'");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrResultados[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
		break;
	}
}
if (count($arrResultados) > 0)
{
	echo '<div class="divCerrar"><a href="javascript: CerrarAutoCompleta(\''.$_GET['divID'].'\');">[ Cerrar ]</a></div>';
	echo '<ul>';
	foreach ($arrResultados as $k => $v)
	{
		echo '<li><a href="javascript: AutoCompleta(\''.$v['id'].'\',\''.$_GET['mod'].'\');">'.$v['nombre'].'</a></li>';
	}
	echo '</ul>';
}
?>