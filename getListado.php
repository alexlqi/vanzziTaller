<?php session_start(); ?>
<?php require_once ('include/config.php'); ?>
<?php require_once ('include/libreria.php'); ?>
<?php
$r = mysql_query("SELECT nombreCampo,valorCampo FROM configuracion WHERE nombreCampo = 'Razon Social'");
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$nombreNegocio = $reg['valorCampo'];
}

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=".$_GET['mod']."_".date('d-m-Y').".xls");
header("Pragma: no-cache");
header("Expires: 0");

switch ($_GET['mod'])
{
	case 'Productos':
	{
		$mas = 1;
		if ($_SESSION['usuarioPERFIL'] == 1)
		{
			$r2 = mysql_query("SELECT id,nombre FROM config_sucursales");
			$mas = mysql_num_rows($r2);
		}
		$colSpan = 12 + $mas;
		echo '<table border="0" cellpadding="5">';
		echo '<tr><td colspan="'.$colSpan.'" align="center">'.$nombreNegocio.'</td></tr>';
		echo '<tr><td colspan="'.$colSpan.'" align="center"><strong>LISTADO DE PRODUCTOS</strong></td></tr>';
		echo '<tr><td colspan="'.$colSpan.'" align="center">Fecha de Elaboracion: '.date('d / m / Y  H:i:s').'</td></tr>';
		$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY nombre");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				echo '<tr><td colspan="'.$colSpan.'" style="border-top:1px #000000 dashed; border-bottom:1px #000000 dashed;"><strong>Categoria: '.$reg['nombre'].'</strong></td></tr>';
				$r1 = mysql_query("SELECT a.id AS id, a.upc AS upc, a.clave AS clave, a.nombre AS nombre, a.descripcion AS descripcion, a.precio1 AS precio1, a.precio2 AS precio2, a.precio3 AS precio3, a.precio4 AS precio4, a.precio5 AS precio5, b.nombreComercial AS proveedor, c.nombre AS uSalida FROM productos a JOIN productos_proveedores b ON b.id = a.proveedorID JOIN productos_unidades c ON c.id = a.unidadSalidaID WHERE a.categoriaID = ".$reg['id']." AND a.activo = 1 ORDER BY a.nombre ASC");
				if (mysql_num_rows($r1) > 0)
				{
					echo '<tr><td align="center"><strong>UPC</strong></td><td align="center"><strong>Clave</strong></td><td align="center"><strong>Nombre</strong></td><td align="center"><strong>Descripcion</strong></td><td align="center"><strong>Precio 1</strong></td><td align="center"><strong>Precio 2</strong></td><td align="center"><strong>Precio 3</strong></td><td align="center"><strong>Precio 4</strong></td><td align="center"><strong>Precio 5</strong></td><td align="center"><strong>Proveedor</strong></td><td align="center"><strong>Unidad de Salida</strong></td>';
					if ($_SESSION['usuarioPERFIL'] == 1)
					{
						$r2 = mysql_query("SELECT id,nombre FROM config_sucursales");
						while ($reg2 = mysql_fetch_array($r2))
						{
							echo '<td align="center"><strong>Ex. Suc. '.$reg2['nombre'].'</strong></td>';
						}
					}
					else
					{
						echo '<td align="center"><strong>Existencia</strong></td>';
					}
					echo '</tr>';
					while ($reg1 = mysql_fetch_array($r1))
					{
						echo '<tr><td>'.$reg1['upc'].'</td><td>'.$reg1['clave'].'</td><td>'.$reg1['nombre'].'</td><td>'.$reg1['descripcion'].'</td><td>$ '.number_format($reg1['precio1'],2).'</td><td>$ '.number_format($reg1['precio2'],2).'</td><td>$ '.number_format($reg1['precio3'],2).'</td><td>$ '.number_format($reg1['precio4'],2).'</td><td>$ '.number_format($reg1['precio5'],2).'</td><td>'.$reg1['proveedor'].'</td><td>'.$reg1['uSalida'].'</td>';
						if ($_SESSION['usuarioPERFIL'] == 1)
						{
							$r2 = mysql_query("SELECT id FROM config_sucursales");
							while ($reg2 = mysql_fetch_array($r2))
							{
								$existencia = 0;
								$r3 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg1['id']." AND sucursalID = ".$reg2['id']);
								if (mysql_num_rows($r3) > 0) { $reg3 = mysql_fetch_array($r3); $existencia = $reg3['cantidad']; }
								echo '<td>'.$existencia.'</td>';
							}
						}
						else
						{
							$existencia = 0;
							$r3 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg1['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
							if (mysql_num_rows($r3) > 0) { $reg3 = mysql_fetch_array($r3); $existencia = $reg3['cantidad']; }
							echo '<td>'.$existencia.'</td>';
						}
						echo '</tr>';
					}
				}
				else
				{
					
				}
			}
		}
		echo '</table>';
		break;
	}
	case 'ProductosBD':
	{
		echo '<table border="1" cellpadding="5">';
		$r = mysql_query("SELECT a.upc AS upc, a.clave AS clave, a.nombre AS nombre, a.descripcion AS descripcion, a.precio1 AS precio1, a.precio2 AS precio2, a.precio3 AS precio3, a.precio4 AS precio4, a.precio5 AS precio5, a.factorConversion AS factorConversion, a.activo AS activo, b.nombreComercial AS proveedor, c.nombre AS categoria, d.nombre AS uSalida, e.nombre AS uEntrada FROM productos a JOIN productos_proveedores b ON b.id = a.proveedorID JOIN productos_categorias c ON c.id = a.categoriaID JOIN productos_unidades d ON d.id = a.unidadSalidaID JOIN productos_unidades e ON e.id = a.unidadEntradaID ORDER BY c.nombre ASC, a.nombre ASC");
		if (mysql_num_rows($r) > 0)
		{
			echo '<tr><td align="center"><strong>Categoria</strong></td><td align="center"><strong>UPC</strong></td><td align="center"><strong>Clave</strong></td><td align="center"><strong>Nombre</strong></td><td align="center"><strong>Descripcion</strong></td><td align="center"><strong>Precio Menudeo</strong></td><td align="center"><strong>Precio Mayoreo</strong></td><td align="center"><strong>Precio Especial</strong></td><td align="center"><strong>Precio 4</strong></td><td align="center"><strong>Precio 5</strong></td><td align="center"><strong>Factor de Conversion</strong></td><td align="center"><strong>Proveedor (Nombre Comercial)</strong></td><td align="center"><strong>Unidad de Salida</strong></td><td align="center"><strong>Unidad de Entrada</strong></td><td><strong>Producto Activo (1 = Si, 0 = No)</strong></td></tr>';
			while ($reg = mysql_fetch_array($r))
			{
				echo '<tr';
				if ($reg['activo'] == 0) { echo ' bgcolor="#999999"'; }
				echo '><td>'.$reg['categoria'].'</td><td>'.$reg['upc'].'</td><td>'.$reg['clave'].'</td><td>'.$reg['nombre'].'</td><td>'.$reg['descripcion'].'</td><td>'.$reg['precio1'].'</td><td>'.$reg['precio2'].'</td><td>'.$reg['precio3'].'</td><td>'.$reg['precio4'].'</td><td>'.$reg['precio5'].'</td><td>'.$reg['factorConversion'].'</td><td>'.$reg['proveedor'].'</td><td>'.$reg['uSalida'].'</td><td>'.$reg['uEntrada'].'</td><td>'.$reg['activo'].'</td></tr>';
			}
		}
		echo '</table>';
		break;
	}
	case 'Clientes':
	{
		$colSpan = 5;
		echo '<table border="0" cellpadding="5">';
		echo '<tr><td colspan="'.$colSpan.'" align="center">'.$nombreNegocio.'</td></tr>';
		echo '<tr><td colspan="'.$colSpan.'" align="center"><strong>LISTADO DE CLIENTES</strong></td></tr>';
		echo '<tr><td colspan="'.$colSpan.'" align="center">Fecha de Elaboracion: '.date('d / m / Y  H:i:s').'</td></tr>';
		$r = mysql_query("SELECT nombre,contacto,email,observaciones,listaTelefonos FROM clientes ORDER BY nombre");
		if (mysql_num_rows($r) > 0)
		{
			echo '<tr><td align="center" style="border-bottom:1px #000000 dashed;"><strong>Nombre</strong></td><td align="center" style="border-bottom:1px #000000 dashed;"><strong>Contacto</strong></td><td align="center" style="border-bottom:1px #000000 dashed;"><strong>E-mail</strong></td><td align="center" style="border-bottom:1px #000000 dashed;"><strong>Observaciones</strong></td><td align="center" style="border-bottom:1px #000000 dashed;"><strong>Telefonos</strong></td></tr>';
			while ($reg = mysql_fetch_array($r))
			{
				echo '<tr><td>'.$reg['nombre'].'</td><td>'.$reg['contacto'].'</td><td>'.$reg['email'].'</td><td>'.$reg['observaciones'].'</td><td>'.$reg['listaTelefonos'].'</td></tr>';
			}
		}
		else
		{
			
		}
		echo '</table>';
		break;
	}
	default:
	{
		
	}
}
?>