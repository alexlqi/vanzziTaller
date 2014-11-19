<?php
session_start();
require_once ('include/config.php');
require_once ('include/libreria.php');
$arrReportes = array(1 => 'Ventas por Vendedor', 2 => 'Existencias Totales', 3 => 'Movimientos de Articulo', 4 => 'Corte de Caja');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo 'CHINOCELLS :: '.$arrReportes[$_SESSION['PVAmNetReporte']]?></title>
</head>

<body>
<?php
switch ($_SESSION['PVAmNetReporte'])
{
	case 1:
	{
		$columnas = 7;
		echo '<table border="0" cellpadding="5" cellspacing="0" style="font-family:Arial; font-size:12pt;">';
		echo '<tr><td colspan="'.$columnas.'" align="center">VENTAS POR VENDEDOR</td></tr>';
		switch ($_SESSION['PVAmNetTipoReporte'])
		{
			case 1:
			{
				$fechaInicio = $_SESSION['PVAmNetReporteFecha'].' 00:00:00';
				$fechaFin = $_SESSION['PVAmNetReporteFecha'].' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas el dia '.Fecha($_SESSION['PVAmNetReporteFecha'],'d de M de A').'</td></tr>';
				$r1 = mysql_query("SELECT b.id AS id, b.fecha AS fecha, b.subtotal AS subtotal, b.descuento AS descuento, b.iva AS iva, c.nombre AS formaPago FROM ventas b JOIN ventas_formas_pago c ON c.id = b.formaPagoID WHERE b.fecha >= '".$fechaInicio."' AND b.fecha <= '".$fechaFin."' AND b.usuarioID = ".$_SESSION['PVAmNetVendedor']." AND b.cerrada = 1 AND b.cancelada = 0 ORDER BY b.fecha ASC");
				break;
			}
			case 2:
			{
				$fechaInicio = date('Y-m-d',mktime(0,0,0,date('n'),date('j') - 7,date('Y'))).' 00:00:00';
				$fechaFin = date('Y-m-d').' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				$r1 = mysql_query("SELECT b.id AS id, b.fecha AS fecha, b.subtotal AS subtotal, b.descuento AS descuento, b.iva AS iva, c.nombre AS formaPago FROM ventas b JOIN ventas_formas_pago c ON c.id = b.formaPagoID WHERE b.fecha >= '".$fechaInicio."' AND b.fecha <= '".$fechaFin."' AND b.usuarioID = ".$_SESSION['PVAmNetVendedor']." AND b.cerrada = 1 AND b.cancelada = 0 ORDER BY b.fecha ASC");
				break;
			}
			case 3:
			{
				$fechaInicio = date('Y-m-d',mktime(0,0,0,date('n'),date('j') - 15,date('Y'))).' 00:00:00';
				$fechaFin = date('Y-m-d').' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				$r1 = mysql_query("SELECT b.id AS id, b.fecha AS fecha, b.subtotal AS subtotal, b.descuento AS descuento, b.iva AS iva, c.nombre AS formaPago FROM ventas b JOIN ventas_formas_pago c ON c.id = b.formaPagoID WHERE b.fecha >= '".$fechaInicio."' AND b.fecha <= '".$fechaFin."' AND b.usuarioID = ".$_SESSION['PVAmNetVendedor']." AND b.cerrada = 1 AND b.cancelada = 0 ORDER BY b.fecha ASC");
				break;
			}
			case 4:
			{
				$fechaInicio = date('Y-m-d',mktime(0,0,0,date('n'),date('j') - 30,date('Y'))).' 00:00:00';
				$fechaFin = date('Y-m-d').' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				$r1 = mysql_query("SELECT b.id AS id, b.fecha AS fecha, b.subtotal AS subtotal, b.descuento AS descuento, b.iva AS iva, c.nombre AS formaPago FROM ventas b JOIN ventas_formas_pago c ON c.id = b.formaPagoID WHERE b.fecha >= '".$fechaInicio."' AND b.fecha <= '".$fechaFin."' AND b.usuarioID = ".$_SESSION['PVAmNetVendedor']." AND b.cerrada = 1 AND b.cancelada = 0 ORDER BY b.fecha ASC");
				break;
			}
			case 5:
			{
				$fechaInicio = $_SESSION['PVAmNetReporteFecha1'].' 00:00:00';
				$fechaFin = $_SESSION['PVAmNetReporteFecha2'].' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				$r1 = mysql_query("SELECT b.id AS id, b.fecha AS fecha, b.subtotal AS subtotal, b.descuento AS descuento, b.iva AS iva, c.nombre AS formaPago FROM ventas b JOIN ventas_formas_pago c ON c.id = b.formaPagoID WHERE b.fecha >= '".$fechaInicio."' AND b.fecha <= '".$fechaFin."' AND b.usuarioID = ".$_SESSION['PVAmNetVendedor']." AND b.cerrada = 1 AND b.cancelada = 0 ORDER BY b.fecha ASC");
				break;
			}
			case 6:
			{
				$nombreProducto = 'Producto no encontrado';
				$ID = 0;
				$r = mysql_query("SELECT id,clave,nombre FROM productos WHERE upc = '".$_SESSION['PVAmNetReporteProducto']."'");
				if (mysql_num_rows($r) > 0)
				{
					$reg = mysql_fetch_array($r);
					$nombreProducto = $reg['nombre'];
					if ($reg['clave'] <> '') { $nombreProducto .= ' ('.$reg['clave'].')'; }
					$ID = $reg['id'];
				}
				echo '<tr><td colspan="'.$columnas.'" align="center">Ventas del Producto '.$nombreProducto.'</td></tr>';
				$r1 = mysql_query("SELECT (a.cantidad * a.precio) AS subtotal, ((a.cantidad * a.precio) * (b.porcentajeDescuento / 100)) AS descuento, ((a.cantidad * a.precio) * (b.porcentajeIva / 100)) AS iva, b.id AS id, b.fecha AS fecha, c.nombre AS formaPago FROM ventas_partidas a JOIN ventas b ON b.id = a.ventaID JOIN ventas_formas_pago c ON c.id = b.formaPagoID WHERE a.productoID = ".$ID." AND b.usuarioID = ".$_SESSION['PVAmNetVendedor']." AND b.cerrada = 1 AND b.cancelada = 0 ORDER BY b.fecha ASC");
				break;
			}
		}
		echo '<tr style="font-size:10pt;"><td colspan="'.$columnas.'" align="right">Reporte elaborado el '.Fecha(date('Y-m-d H:i:s'),'w d de M de Y H:m:s').'</td></tr>';
		$r = mysql_query("SELECT a.nombre AS nombre, b.nombre AS sucursal FROM config_usuarios a JOIN config_sucursales b ON b.id = a.sucursalID WHERE a.id = ".$_SESSION['PVAmNetVendedor']);
		if (mysql_num_rows($r) > 0)
		{
			$reg = mysql_fetch_array($r);
			echo '<tr><td colspan="'.$columnas.'">&nbsp;</td></tr>';
			echo '<tr><td colspan="'.$columnas.'" style="border-bottom:1px #000000 groove; border-top:1px #000000 solid;"><strong>'.$reg['nombre'].' (Suc. '.$reg['sucursal'].')</strong></td></tr>';
			if (mysql_num_rows($r1) > 0)
			{
				$subtotal = 0;
				$descuento = 0;
				$iva = 0;
				echo '<tr><td style="border-bottom:1px #000000 dotted;"><strong>No. de Ticket</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Fecha</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Subtotal</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Descuento</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>I.V.A.</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Total</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Forma de Pago</strong></td></tr>';
				while ($reg1 = mysql_fetch_array($r1))
				{
					$subtotal += $reg1['subtotal'];
					$descuento += $reg1['descuento'];
					$iva += $reg1['iva'];
					echo '<tr><td>'.sprintf('%05d',$reg1['id']).'</td><td>'.Fecha($reg1['fecha'],'d/m/A').'</td><td align="right">'.Moneda($reg1['subtotal']).'</td><td align="right">'.Moneda($reg1['descuento']).'</td><td align="right">'.Moneda($reg1['iva']).'</td><td align="right">'.Moneda($reg1['subtotal'] + $reg1['iva']).'</td><td>'.$reg1['formaPago'].'</td></tr>';
				}
				echo '<tr style="font-weight:bold; text-style:italic;"><td colspan="2" align="right" style="border-bottom:1px #000000 solid; border-top:1px #000000 solid;">TOTALES</td><td align="right" style="border-bottom:1px #000000 solid; border-top:1px #000000 solid;">'.Moneda($subtotal).'</td><td align="right" style="border-bottom:1px #000000 solid; border-top:1px #000000 solid;">'.Moneda($descuento).'</td><td align="right" style="border-bottom:1px #000000 solid; border-top:1px #000000 solid;">'.Moneda($iva).'</td><td align="right" style="border-bottom:1px #000000 solid; border-top:1px #000000 solid;">'.Moneda($subtotal + $iva).'</td><td style="border-bottom:1px #000000 solid; border-top:1px #000000 solid;">&nbsp;</td></tr>';
			}
			else
			{
				echo '<tr><td colspan="'.$columnas.'">No se encontraron registros</td></tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="'.$columnas.'">No se encontraron registros</td></tr>';
		}
		echo '</table>';
		break;
	}
	case 2:
	{
		$arrBodegas = array();
		if ($_SESSION['PVAmNetReporteSucursal'] == 0) { $r = mysql_query("SELECT id,nombre FROM config_sucursales ORDER BY nombre ASC"); }
		else { $r = mysql_query("SELECT id,nombre FROM config_sucursales WHERE id = ".$_SESSION['PVAmNetReporteSucursal']); }
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrBodegas[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
			}
		}
		$columnas = count($arrBodegas) + 3;
		echo '<table border="0" cellpadding="5" cellspacing="0" style="font-family:Arial; font-size:12pt;">';
		echo '<tr><td colspan="'.$columnas.'" align="center">EXISTENCIAS POR PRODUCTO</td></tr>';
		switch ($_SESSION['PVAmNetTipoReporte'])
		{
			case 1:
			{
				$r = mysql_query("SELECT a.id AS id, a.clave AS clave, a.nombre AS nombre, b.nombre AS unidad FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.upc = ".Limpia($_SESSION['PVAmNetReporteProducto']));
				break;
			}
			case 2:
			{
				$r = mysql_query("SELECT a.id AS id, a.clave AS clave, a.nombre AS nombre, b.nombre AS unidad FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.proveedorID = ".Limpia($_SESSION['PVAmNetReporteProveedor']));
				break;
			}
			case 3:
			{
				$r = mysql_query("SELECT a.id AS id, a.clave AS clave, a.nombre AS nombre, b.nombre AS unidad FROM productos a JOIN productos_unidades b ON b.id = a.unidadSalidaID WHERE a.categoriaID = ".Limpia($_SESSION['PVAmNetReporteCategoria'])." AND a.proveedorID = ".Limpia($_SESSION['PVAmNetReporteProveedor']));
				break;
			}
		}
		echo '<tr style="font-size:10pt;"><td colspan="'.$columnas.'" align="right">Reporte elaborado el '.Fecha(date('Y-m-d H:i:s'),'w d de M de Y H:m:s').'</td></tr>';
		if (mysql_num_rows($r) > 0)
		{
			echo '<tr><td style="border-bottom:1px #000000 dotted;"><strong>Producto</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>U. Venta</strong></td>';
			foreach ($arrBodegas as $k => $v)
			{
				echo '<td style="border-bottom:1px #000000 dotted;"><strong>Suc. '.$v['nombre'].'</strong></td>';
			}
			echo '<td style="border-bottom:1px #000000 dotted;"><strong>Total</strong></td></tr>';
			while ($reg = mysql_fetch_array($r))
			{
				$total = 0;
				echo '<tr><td style="border-bottom:1px #000000 dotted;">'.$reg['nombre'];
				if ($reg['clave'] <> '') { echo ' ('.$reg['clave'].')'; }
				echo '</td><td style="border-bottom:1px #000000 dotted;">'.$reg['unidad'].'</td>';
				foreach ($arrBodegas as $k => $v)
				{
					$existencia = 0;
					$r1 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg['id']." AND sucursalID = ".$v['id']);
					if (mysql_num_rows($r1) > 0) { $reg1 = mysql_fetch_array($r1); $existencia = $reg1['cantidad']; }
					$total += $existencia;
					echo '<td style="border-bottom:1px #000000 dotted;" align="center">'.$existencia.'</td>';
				}
				echo '<td style="border-bottom:1px #000000 dotted;" align="center"><strong>'.$total.'</strong></td></tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="'.$columnas.'">No se encontraron registros</td></tr>';
		}
		echo '</table>';
		break;
	}
	case 3:
	{
		$columnas = 4;
		echo '<table border="0" cellpadding="5" cellspacing="0" style="font-family:Arial; font-size:12pt;">';
		echo '<tr><td colspan="'.$columnas.'" align="center">MOVIMIENTOS DE PRODUCTO</td></tr>';
		switch ($_SESSION['PVAmNetTipoReporte'])
		{
			case 1:
			{
				$fechaInicio = $_SESSION['PVAmNetReporteFecha'].' 00:00:00';
				$fechaFin = $_SESSION['PVAmNetReporteFecha'].' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas el dia '.Fecha($_SESSION['PVAmNetReporteFecha'],'d de M de A').'</td></tr>';
				break;
			}
			case 2:
			{
				$fechaInicio = date('Y-m-d',mktime(0,0,0,date('n'),date('j') - 7,date('Y'))).' 00:00:00';
				$fechaFin = date('Y-m-d').' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				break;
			}
			case 3:
			{
				$fechaInicio = date('Y-m-d',mktime(0,0,0,date('n'),date('j') - 15,date('Y'))).' 00:00:00';
				$fechaFin = date('Y-m-d').' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				break;
			}
			case 4:
			{
				$fechaInicio = date('Y-m-d',mktime(0,0,0,date('n'),date('j') - 30,date('Y'))).' 00:00:00';
				$fechaFin = date('Y-m-d').' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				break;
			}
			case 5:
			{
				$fechaInicio = $_SESSION['PVAmNetReporteFecha1'].' 00:00:00';
				$fechaFin = $_SESSION['PVAmNetReporteFecha2'].' 23:59:59';
				echo '<tr><td colspan="'.$columnas.'" align="center">Realizadas entre el dia '.Fecha($fechaInicio,'d de M de A').' y el dia '.Fecha($fechaFin,'d de M de A').'</td></tr>';
				break;
			}
		}
		echo '<tr style="font-size:10pt;"><td colspan="'.$columnas.'" align="right">Reporte elaborado el '.Fecha(date('Y-m-d H:i:s'),'w d de M de Y H:m:s').'</td></tr>';
		$r = mysql_query("SELECT id,clave,nombre FROM productos WHERE upc = ".Limpia($_SESSION['PVAmNetReporteProducto']));
		if (mysql_num_rows($r) > 0)
		{
			$reg = mysql_fetch_array($r);
			$r1 = mysql_query("SELECT a.fecha AS fecha, a.cantidad AS cantidad, a.descripcion AS descripcion, b.nombre AS usuario FROM productos_movimientos_inventario a JOIN config_usuarios b ON b.id = a.usuarioID WHERE a.fecha >= '".$fechaInicio."' AND a.fecha <= '".$fechaFin."' AND a.productoID = ".$reg['id']);
			if (mysql_num_rows($r1) > 0)
			{
				while ($reg1 = mysql_fetch_array($r1))
				{
					$arrMovimientos[] = array('fecha' => $reg1['fecha'], 'cantidad' => $reg1['cantidad'], 'descripcion' => $reg1['descripcion'], 'usuario' => $reg1['usuario']);
				}
			}
			$r1 = mysql_query("SELECT a.cantidad AS cantidad, b.id AS id, b.fecha AS fecha, c.nombre AS usuario FROM ventas_partidas a JOIN ventas b ON b.id = a.ventaID JOIN config_usuarios c ON c.id = b.usuarioID WHERE b.fecha >= '".$fechaInicio."' AND b.fecha <= '".$fechaFin."' AND a.estatus = 1 AND a.productoID = ".$reg['id']);
			if (mysql_num_rows($r1) > 0)
			{
				while ($reg1 = mysql_fetch_array($r1))
				{
					$arrMovimientos[] = array('fecha' => $reg1['fecha'], 'cantidad' => $reg1['cantidad'], 'descripcion' => 'Venta (Ticket No. '.sprintf('%05d',$reg1['id']).')', 'usuario' => $reg1['usuario']);
				}
			}
			$arrMovimientos = OrdenaArreglo ($arrMovimientos,'fecha');
			echo '<tr><td colspan="'.$columnas.'" style="border-bottom:1px #000000 groove; border-top:1px #000000 solid;"><strong>'.$reg['nombre'];
			if ($reg['clave'] <> '') { echo ' ('.$reg['clave'].')'; }
			echo '</strong></td></tr>';
			if (count($arrMovimientos) > 0)
			{
				echo '<tr><td style="border-bottom:1px #000000 dotted;"><strong>Fecha</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Unidades</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Movimiento</strong></td><td style="border-bottom:1px #000000 dotted;"><strong>Usuario</strong></td></tr>';
				foreach ($arrMovimientos as $k => $v)
				{
					echo '<tr><td>'.Fecha($v['fecha'],'d/m/A').'</td><td align="right">'.$v['cantidad'].'</td><td>'.nl2br($v['descripcion']).'</td><td>'.$v['usuario'].'</td></tr>';
				}
			}
			else
			{
				echo '<tr><td colspan="'.$columnas.'">No se encontraron registros</td></tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="'.$columnas.'">No se encontraron registros</td></tr>';
		}
		echo '</table>';
		break;
	}
}
?>
</body>
</html>