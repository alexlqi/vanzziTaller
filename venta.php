<?php include ('header.php'); ?>
<div id="divAutorizar">
	<div id="login">
		<p>Se requiere la autorizacion de un Administrador para otorgar ese descuento</p>
        <form id="formLogin" name="form1" method="get" action="backend.php">
        <input type="hidden" name="mod" id="mod" value="Venta" />
        <input type="hidden" name="acc" id="acc" value="Cerrar" />
        <label>Usuario</label>
                <input type="text" name="username" id="username" />
            <label>Contrase&ntilde;a</label>
                <input type="password" name="password" id="password" />
                <br />
              <br />
                <br />
              <input type="submit" value="Autorizar" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="document.getElementById('divAutorizar').style.display = 'none'" />
        </form>
	</div>
</div>
<div style="background:url(imagenes/fondoBody.png) no-repeat center; min-height:645px;">
<h1>Venta<div class="btnCerrar" onclick="window.location = 'index.php';" title="Cerrar Ventana">&nbsp;</div><div class="clear"></div></h1>
<div id="forma">
<?php
$r = mysql_query("SELECT * FROM ventas WHERE cerrada = 0 AND usuarioID = ".$_SESSION['usuarioID']);
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$arrFormasPago = array();
	$r1 = mysql_query("SELECT id,nombre FROM ventas_formas_pago");
	if (mysql_num_rows($r1) > 0)
	{
		while ($reg1 = mysql_fetch_array($r1))
		{
			$arrFormasPago[] = array('id' => $reg1['id'], 'nombre' => $reg1['nombre']);
		}
	}
	$nombre = 'VENTA MOSTRADOR';
	$listaTelefonos = 'VENTA MOSTRADOR';
	$email = 'VENTA MOSTRADOR';
	if ($reg['clienteID'] > 0)
	{
		$r1 = mysql_query("SELECT nombre,email FROM clientes WHERE id = ".$reg['clienteID']);
		$reg1 = mysql_fetch_array($r1);
		$nombre = $reg1['nombre'];
		$listaTelefonos = '';
		$email = $reg1['email'];
		$r1 = mysql_query("SELECT a.razonSocial AS razonSocial, a.rfc AS rfc, a.direccion AS direccion, a.cp AS cp, b.nombre AS ciudad, c.nombre AS estado FROM clientes_datos_fiscales a JOIN config_ciudades b ON b.id = a.ciudadID JOIN config_estados c ON c.id = a.estadoID WHERE a.clienteID = ".$reg['clienteID']);
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$listaTelefonos .= $reg1['razonSocial']."\n".$reg1['rfc']."\n".$reg1['direccion']."\n".$reg1['cp'].', '.$reg1['ciudad'].', '.$reg1['estado']."\n-----------------------------------------------------\n";
			}
		}
	}
?>
<h2>Datos del Cliente</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="50%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $nombre?>" readonly="readonly"></td>
            <td width="50%" rowspan="2" valign="top"><label>Datos Fiscales</label>
            <textarea name="listaTelefonos" rows="4" id="listaTelefonos" readonly="readonly"><?php echo $listaTelefonos?></textarea></td>
        </tr>
      <tr>
        <td><label>Correo Electronico</label>
          <input type="text" name="email" id="email" readonly="readonly" value="<?php echo $email?>"></td>
      </tr>
      </table>
	<h2>Productos Vendidos</h2>
    <div id="divVenta">
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="40%" valign="top">
          <form id="form1" name="form1" method="post" action="backend.php?mod=Venta&acc=Add" autocomplete="off">
            <label>UPC</label><input type="text" name="upc" id="upc" style="width:200px;">&nbsp;
            <input type="submit" value="Agregar" />
            </form>
        </td>
        <td width="60%">
        <label>Buscar UPC por Nombre de Producto</label><input type="text" name="producto" id="producto" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('producto','Productos','divAutoBuscar');"><div id="divAutoBuscar" class="divAutoBuscar"></div>
        </td>
        </tr>
      </table>
<?php
	$r1 = mysql_query("SELECT a.id AS id, a.cantidad AS cantidad, a.precio AS precio, a.estatus AS estatus, b.id AS productoID, b.clave AS clave, b.nombre AS producto, c.nombre AS uSalida FROM ventas_partidas a JOIN productos b ON b.id = a.productoID JOIN productos_unidades c ON c.id = b.unidadSalidaID WHERE a.ventaID = ".$reg['id']." ORDER BY id ASC");
	if (mysql_num_rows($r1) > 0)
	{
?>
    <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezadoVenta">
        <td width="6%">Cantidad</td>
        <td width="10%">U. de Salida</td>
        <td width="44%">Producto</td>
        <td width="5%">Img</td>
        <td width="10%">Estatus</td>
        <td width="10%">Precio Unitario</td>
        <td width="10%">Monto</td>
        <td width="5%">&nbsp;</td>
      </tr>
<?php
		while ($reg1 = mysql_fetch_array($r1))
		{
			$subtotalDesc = $reg['subtotal'] - $reg['descuento'];
			$total = $subtotalDesc + $reg['iva'];
			$arrClases = array('filaVentaCancel','filaVenta','filaVentaBO');
			$arrEstatus = array('Cancelado','En Stock','Back Order');
?>
      <tr class="<?php echo $arrClases[$reg1['estatus']]?>">
        <td align="right"><?php if ($reg1['estatus'] == 1) {?><input name="cantidad_<?php echo $reg1['id']?>" type="text" id="cantidad_<?php echo $reg1['id']?>" value="<?php echo $reg1['cantidad']?>" style="width:50px;" onblur="saveProducto('Edita','<?php echo $reg1['id']?>');"><?php } else { echo $reg1['cantidad']; }?></td>
        <td align="center"><?php echo $reg1['uSalida']?></td>
        <td><?php echo $reg1['clave'].' - '.$reg1['producto']?></td>
        <td align="center">
<?php
			$r2 = mysql_query("SELECT archivo FROM productos_imagenes WHERE productoID = ".$reg1['productoID']." ORDER BY id ASC");
			if (mysql_num_rows($r2) > 0)
			{
				$arrImagenes = array();
				while ($reg2 = mysql_fetch_array($r2))
				{
					$arrImagenes[] = $reg2['archivo'];
				}
?>
		<div class="highslide-gallery">
		<a id="thumb<?php echo $reg1['productoID']?>" href="imagenes/productos/<?php echo $arrImagenes[0]?>" class="highslide" onclick="return hs.expand(this, { slideshowGroup: <?php echo $reg1['productoID']?> } )"><img src="imagenes/iconGaleria.png" border="0"></a>
			<div class="hidden-container">
<?php
				for ($i = 1; $i < count($arrImagenes); $i++)
				{
?>
			<a href="imagenes/productos/<?php echo $arrImagenes[$i]?>" class="highslide" onclick="return hs.expand(this, { thumbnailId: 'thumb<?php echo $reg1['productoID']?>', slideshowGroup: <?php echo $reg1['productoID']?> })"></a>
<?php
				}
?>
			</div>
		</div>
<?php
			}
			else
			{
				echo 'N / A';
			}
?>
        </td>
        <td align="center"><?php echo $arrEstatus[$reg1['estatus']]?></td>
        <td align="right"><?php echo '$ '.number_format($reg1['precio'],2)?></td>
        <td align="right"><?php echo '$ '.number_format($reg1['precio'] * $reg1['cantidad'],2)?></td>
        <td align="center"><?php if ($reg1['estatus'] == 1) {?><input type="button" value="-" title="Cancelar Partida" onclick="saveProducto('Cancela','<?php echo $reg1['id']?>');" /><?php 	} else { echo '&nbsp;'; }?></td>
      </tr>
<?php
		}
?>
    </table>
    <table width="35%" border="0" align="right" cellpadding="3" cellspacing="1" class="tabla2">
      <tr class="fila">
        <td>Descuento (%)</td>
        <td><input type="text" name="descuento" id="descuento" value="<?php echo $reg['porcentajeDescuento']?>" style="width:98%; text-align:right; background:#FF8; color:#A60000; border:1px #CCC solid;" onblur="saveProducto('Descuento','');" /></td>
      </tr>
      <tr class="fila">
        <td>Descuento ($)</td>
        <td align="right"><?php echo '$ '.number_format($reg['descuento'],2)?></td>
      </tr>
      <tr class="fila">
        <td width="50%">Subtotal</td>
        <td width="50%" align="right"><?php echo '$ '.number_format($reg['subtotal'],2)?></td>
      </tr>
      <tr class="fila">
        <td>I.V.A. (<?php echo $_SESSION['IVASucursalAmNetPV2012'].' %'?>)</td>
        <td align="right"><?php echo '$ '.number_format($reg['iva'],2)?></td>
      </tr>
      <tr class="fila">
        <td>Total a pagar</td>
        <td align="right"><?php echo '$ '.number_format($reg['subtotal'] + $reg['iva'],2)?></td>
      </tr>
      <tr class="fila">
        <td>Monto del Pago</td>
        <td>$ <input type="text" name="montoPago" id="montoPago" value="<?php if ($reg['montoPago'] == 0) { echo number_format($reg['subtotal'] + $reg['iva'],2); } else { echo number_format($reg['montoPago'],2); }?>" style="width:90%; text-align:right; background:#FF8; color:#A60000; border:1px #CCC solid;" onblur="saveProducto('MontoPago','');" /></td>
      </tr>
      <tr class="fila">
        <td>Forma de Pago</td>
        <td>
        <select name="formaPago" id="formaPago" onchange="saveProducto('FormaPago','');">
<?php
		if (count($arrFormasPago) > 0)
		{
			foreach ($arrFormasPago as $k => $v)
			{
?>
			<option value="<?php echo $v['id']?>"<?php if ($reg['formaPagoID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
			}
		}
?>
        </select>
        </td>
      </tr>
    </table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No se han agregado Productos a esta venta</div>';
	}
?>
    </div>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right"><input type="button" value="Cerrar Venta" onclick="finVenta('Cerrar')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Venta" onclick="finVenta('Cancelar')" /></td>
      </tr>
  </table>
<?php
}
else
{
?>
  <h2>Datos del Cliente</h2>
  <form id="form1" name="form1" method="post" action="backend.php?mod=Venta&acc=AddFirst" autocomplete="off">
  <div id="divClienteVenta">
  <input type="hidden" name="clienteID" id="clienteID" value="0" />
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td><input name="mostrador" type="checkbox" id="mostrador" value="1" checked onclick="if (!this.checked) { document.getElementById('nombre').value = 'Buscar Cliente...'; document.getElementById('nombre').disabled = false; document.getElementById('listaTelefonos').value = ''; document.getElementById('email').value = ''; } else { document.getElementById('nombre').value = 'VENTA DE MOSTRADOR'; document.getElementById('nombre').disabled = true; document.getElementById('listaTelefonos').value = 'VENTA DE MOSTRADOR'; document.getElementById('email').value = 'VENTA DE MOSTRADOR'; }">
              Venta de Mostrador</td>
            <td width="50%" rowspan="3" valign="top"><label>Datos Fiscales</label>
            <textarea name="listaTelefonos" rows="4" id="listaTelefonos" readonly="readonly">VENTA DE MOSTRADOR</textarea></td>
          </tr>
          <tr>
        <td width="50%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="VENTA DE MOSTRADOR" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Ventas','divAutoBuscar');" disabled="disabled"><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
        </tr>
      <tr>
        <td><label>Correo Electronico</label>
          <input type="text" name="email" id="email" disabled="disabled" value="VENTA DE MOSTRADOR"></td>
      </tr>
      </table>
    </div>
	<h2>Productos Vendidos</h2>
    <div id="divVenta">
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="40%" valign="top"><label>UPC</label><input type="text" name="upc" id="upc" style="width:200px;">&nbsp;<input type="submit" value="Agregar" /></td>
        <td width="60%"><label>Buscar UPC por Nombre de Producto</label><input type="text" name="producto" id="producto" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('producto','Productos','divAutoBuscar2');"><div id="divAutoBuscar2" class="divAutoBuscar"></div>&nbsp;</td>
        </tr>
      </table>
<?php
echo '<div class="alertaMsg">No se han agregado Productos a esta venta</div>';
?>
    </div>
    </form>
<?php
}
?>
</div>
</div>
<?php include ('footer.php'); ?>