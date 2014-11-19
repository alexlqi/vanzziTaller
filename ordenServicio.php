<?php include ('header.php'); ?>
<div id="body">
<?php
if (!isset($_GET['mod']))
{
?>
<h1>Ordenes de Servicio</h1>
<div id="divBotones"><input type="button" value="Cliente Nuevo" onclick="window.location = 'clientes.php?OT=3'" /><input type="button" value="Lista de Clientes" onclick="window.location = 'clientes.php?mod=Lista&OT=3'" /></div>
<div id="forma">
<form id="form1" name="form1" method="post" action="backend.php?mod=OrdenServicio&acc=Crear" autocomplete="off">
  <h2>Datos del Cliente</h2>
<?php
	if (isset($_GET['ID']))
	{
		$r = mysql_query("SELECT id,nombre,email,listaTelefonos FROM clientes WHERE id = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r) > 0)
		{
			$reg = mysql_fetch_array($r);
			$datosFiscales = '';
			$r1 = mysql_query("SELECT a.razonSocial AS razonSocial, a.rfc AS rfc, a.direccion AS direccion, a.cp AS cp, b.nombre AS ciudad, c.nombre AS estado FROM clientes_datos_fiscales a JOIN config_ciudades b ON b.id = a.ciudadID JOIN config_estados c ON c.id = a.estadoID WHERE a.clienteID = ".$reg['id']);
			if (mysql_num_rows($r1) > 0)
			{
				while ($reg1 = mysql_fetch_array($r1))
				{
					$datosFiscales .= utf8_encode($reg1['razonSocial']."\n".$reg1['rfc']."\n".$reg1['direccion']."\n".$reg1['cp'].', '.$reg1['ciudad'].', '.$reg1['estado']);
				}
			}
?>
	<input type="hidden" name="clienteID" id="clienteID" value="<?php echo $reg['id']?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" disabled="disabled" /></td>
            <td width="50%" valign="top"><input type="button" value="Ver Historial de Ordenes de Servicio" onclick="window.location = 'ordenServicio.php?mod=Historial&ID=<?php echo $reg['id']?>'" /></td>
          </tr>
          <tr>
        <td width="50%"><label>Correo Electronico</label>
          <input type="text" name="email" id="email" disabled="disabled" value="<?php echo $reg['email']?>"></td>
        <td width="50%" rowspan="2" valign="top"><label>Datos Fiscales</label>
            <textarea name="listaTelefonos" rows="4" id="listaTelefonos" readonly="readonly"><?php echo $datosFiscales?></textarea></td>
        </tr>
      <tr>
        <td><label>Seleccionar Automovil</label>
<?php
			$r1 = mysql_query("SELECT a.id AS id,a.placa AS placa,a.noSerie AS noSerie,a.year AS year,b.nombre AS marca,c.nombre AS modelo FROM clientes_vehiculos a JOIN config_vehiculos_marcas b ON b.id = a.marcaID JOIN config_vehiculos_modelos c ON c.id = a.modeloID WHERE a.clienteID = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r1) > 0)
			{
?>
          <select name="automovil" id="automovil">
<?php
				while ($reg1 = mysql_fetch_array($r1))
				{
?>
            <option value="<?php echo $reg1['id']?>"><?php echo $reg1['placa'].' | '.$reg1['noSerie'].' | '.$reg1['marca'].' '.$reg1['modelo'].' '.$reg1['year']?></option>
<?php
				}
?>
          </select>
<?php
			}
?>
        </td>
      </tr>
      </table>
<?php
		}
	}
	else
	{
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Nombre</label><input type="text" name="nombre" id="nombre" value="Buscar Cliente..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Servicio','divAutoBuscar');" /><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
        </tr>
      <tr>
    </table>
<?php
	}
?>
  <h2>Servicios de la Orden</h2>
    <div id="ajaxDivPartidas">
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?php
	$arrPartidas = array();
	if (isset($_SESSION['ajaxCestaServicio'])) { $arrPartidas = $_SESSION['ajaxCestaServicio']; }
	$total = 0;
	$r = mysql_query("SELECT id,nombre FROM productos_paquetes ORDER BY nombre ASC");
	if (mysql_num_rows($r) > 0)
	{
?>
      <tr>
        <td><label>Paquetes</label>
<?php
		$numCols = 2;
		$i == 1;
		while ($reg = mysql_fetch_array($r))
		{
			$inArray = false;
			foreach ($arrPartidas as $k => $v)
			{
				if ($v['paqueteID'] == $reg['id']) { $inArray = true; }
			}
			echo '<div class="divPaquete';
			if ($inArray) { echo ' divAgregado"'; }
			else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'Paquete\',\''.$reg['id'].'\',\'NULL\',\'NULL\');"'; }
			echo '>'.$reg['nombre'];
			$r1 = mysql_query("SELECT recursoID,tipo FROM productos_paquetes_partidas WHERE paqueteID = ".$reg['id']);
			if (mysql_num_rows($r1) > 0)
			{
				echo '<br /><small>Incluye: ';
				while ($reg1 = mysql_fetch_array($r1))
				{
					if ($reg1['tipo'] == 1) { $r2 = mysql_query("SELECT nombre FROM config_mano_obra WHERE id = ".$reg1['recursoID']); }
					else { $r2 = mysql_query("SELECT nombre FROM productos WHERE id = ".$reg1['recursoID']); }
					$reg2 = mysql_fetch_array($r2);
					echo $reg2['nombre'].', ';
				}
				echo '</small>';
			}
			echo '</div>';
			if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
			else { $i++; }
		}
?>
          </td>
        </tr>
<?php
	}
	$r = mysql_query("SELECT id,nombre FROM config_mano_obra_categorias ORDER BY nombre ASC");
	if (mysql_num_rows($r) > 0)
	{
?>
      <tr>
        <td><label>Mano de Obra</label>
<?php
		while ($reg = mysql_fetch_array($r))
		{
			echo '<div class="divCategoria" onclick="ajaxPartidas(\'Servicio\',\'Show\',\'ManoObra\',\'NULL\',\''.$reg['id'].'\',\'NULL\');">'.$reg['nombre'].'</div>';
		}
?>
          </td>
        </tr>
<?php
	}
	$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY nombre ASC");
	if (mysql_num_rows($r) > 0)
	{
?>
      <tr>
        <td><label>Refacciones</label>
<?php
		while ($reg = mysql_fetch_array($r))
		{
			echo '<div class="divCategoria" onclick="ajaxPartidas(\'Servicio\',\'Show\',\'Productos\',\'NULL\',\''.$reg['id'].'\',\'NULL\');">'.$reg['nombre'].'</div>';
		}
?>
          </td>
        </tr>
<?php
	}
	$arrPaquetes = array();
	$inManoObra = false;
	$inProductos = false;
	if (count($arrPartidas) > 0)
	{
		foreach ($arrPartidas as $k => $v)
		{
			if ($v['paqueteID'] <> 0 and !array_key_exists($v['paqueteID'],$arrPaquetes))
			{
				$r = mysql_query("SELECT nombre,precio FROM productos_paquetes WHERE id = ".$v['paqueteID']);
				$reg = mysql_fetch_array($r);
				$arrPaquetes[$v['paqueteID']] = array('id' => $v['paqueteID'], 'nombre' => $reg['nombre']);
				$total += $reg['precio'];
			}
			else
			{
				if ($v['tipo'] == 1 and $v['paqueteID'] == 0) { $inManoObra = true; }
				elseif ($v['tipo'] == 2 and $v['paqueteID'] == 0) { $inProductos = true; }				
				$total += ($v['cantidad'] * $v['precio']);
			}
		}
	}
?>
    </table>
    <h2>Partidas Agregadas</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
	  <td align="right" class="labelTotal">Monto a Pagar&nbsp;&nbsp;&nbsp;$ <?php echo $total?></td>
  </tr>
      <tr>
        <td>
<?php
	if (count($arrPaquetes) > 0)
	{
?>
        	<h3>Paquetes</h3>
            <ul class="listaPartidas">
<?php
		foreach ($arrPaquetes as $k => $v)
		{
			
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','Paquete','<?php echo $v['id']?>','NULL','NULL');" /></div><div class="clear"></div></li>
<?php
		}
?>
            </ul>
<?php
	}
	if ($inManoObra)
	{
?>
            <h3>Mano de Obra</h3>
            <ul class="listaPartidas">
<?php
		foreach ($arrPartidas as $k => $v)
		{
			if ($v['tipo'] == 1 and $v['paqueteID'] == 0)
			{
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','ManoObra','<?php echo $k?>','<?php echo $v['categoriaID']?>','NULL');" /></div><div class="clear"></div></li>
<?php
			}
		}
?>
            </ul>
<?php
	}
	if ($inProductos)
	{
?>
            <h3>Refacciones</h3>
            <ul class="listaPartidas">
<?php
		foreach ($arrPartidas as $k => $v)
		{
			if ($v['tipo'] == 2 and $v['paqueteID'] == 0)
			{
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="text" value="<?php echo $v['cantidad']?>" id="cantidad<?php echo $k?>" style="width:10%;" /> <input type="button" value="Actualizar Cantidad" onclick="ajaxPartidas('Servicio','Edit','Productos','<?php echo $k?>','<?php echo $v['categoriaID']?>','NULL');" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','Productos','<?php echo $k?>','<?php echo $v['categoriaID']?>','NULL');" /></div><div class="clear"></div></li>
<?php
			}
		}
?>
            </ul>
<?php
	}
?>
        </td>
        </tr>
    </table>
    </div>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />
        </td>
      </tr>
  </table>
  </form>
</div>
<?php
}
elseif ($_GET['mod'] == 'Historial')
{
	$r = mysql_query("SELECT nombre FROM clientes WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<h1>Ordenes de Servicio de <?php echo $reg['nombre']?></h1>
<?php
		$r1 = mysql_query("SELECT a.id AS id,a.fecha AS fecha,a.precio AS precio,a.duracion AS duracion,b.placa AS placa,b.noSerie AS noSerie,b.year AS year,c.nombre AS marca,d.nombre AS modelo,e.nombre AS estatus FROM servicios a JOIN clientes_vehiculos b ON b.id = a.vehiculoID JOIN config_vehiculos_marcas c ON c.id = b.marcaID JOIN config_vehiculos_modelos d ON d.id = b.modeloID JOIN servicios_estatus e ON e.id = a.estatusID WHERE a.clienteID = ".Limpia($_GET['ID'])." ORDER BY a.fecha DESC");
		if (mysql_num_rows($r1) > 0)
		{
?>
<table width="90%" border="0" align="center" cellspacing="1" cellpadding="3" class="tabla1">
      <tr class="encabezado">
        <td width="8%">Folio</td>
        <td width="8%">Fecha de elaboracion</td>
        <td width="8%">Duracion</td>
        <td width="30%">Automovil</td>
        <td width="8%">Estatus</td>
        <td width="22%">Ultimo Seguimiento</td>
        <td width="8%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
      </tr>
<?php
				while ($reg1 = mysql_fetch_array($r1))
				{
?>
      <tr class="fila">
        <td class="divFolio"><?php echo sprintf('%06d',$reg1['id'])?></td>
        <td><?php echo Fecha($reg1['fecha'],'d/m/A')?></td>
        <td><?php echo $reg1['duracion'].' Min.'?></td>
        <td><?php echo $reg1['placa'].' | '.$reg1['noSerie'].' | '.$reg1['marca'].' '.$reg1['modelo'].' '.$reg1['year']?></td>
        <td><strong><?php echo $reg1['estatus']?></strong></td>
        <td>
<?php
					$r2 = mysql_query("SELECT a.seguimiento AS seguimiento, b.nombre AS usuario FROM servicios_seguimientos a JOIN config_usuarios b ON b.id = a.usuarioID WHERE a.servicioID = ".$reg1['id']." ORDER BY a.fecha DESC LIMIT 1");
					if (mysql_num_rows($r2) > 0)
					{
						$reg2 = mysql_fetch_array($r2);
						echo nl2br($reg2['seguimiento']);
					}
					else
					{
						echo 'Sin seguimientos';
					}
?>
		</td>
        <td align="center"><input type="button" value="Editar" onclick="window.location = 'ordenServicio.php?mod=Editar&ID=<?php echo $reg1['id']?>';" /></td>
        <td align="center"><input type="button" value="Cancelar" onclick="" /></td>
      </tr>
<?php
				}
?>
</table>
<?php
		}
		else
		{
			echo '<div class="alertaMsg">El cliente no tiene ordenes de servicio registradas</div>';
		}
	}
	else
	{
		echo '<div class="errorMsg">El cliente que intentas ver no existe</div>';
	}
}
elseif ($_GET['mod'] == 'Editar')
{
	$r = mysql_query("SELECT a.precio AS precio,a.estatusID AS estatusID,b.nombre AS cliente,c.placa AS placa,c.noSerie AS noSerie,c.year AS year,d.nombre AS marca,e.nombre AS modelo FROM servicios a JOIN clientes b ON b.id = a.clienteID JOIN clientes_vehiculos c ON c.id = a.vehiculoID JOIN config_vehiculos_marcas d ON d.id = c.marcaID JOIN config_vehiculos_modelos e ON e.id = c.modeloID WHERE a.id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		$arrEstatus = array();
		$r1 = mysql_query("SELECT id,nombre FROM servicios_estatus WHERE id != 4");
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$arrEstatus[] = array('id' => $reg1['id'], 'nombre' => $reg1['nombre']);
			}
		}
		$arrPartidas = array();
		$arrPaquetes = array();
		$inManoObra = false;
		$inProductos = false;
		$r1 = mysql_query("SELECT id,cantidad,tipo,recursoID,paqueteID FROM servicios_partidas WHERE servicioID = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$arrPartidas[$reg1['id']] = array('id' => $reg1['recursoID'], 'tipo' => $reg1['tipo'], 'cantidad' => $reg1['cantidad'], 'paqueteID' => $reg1['paqueteID'], 'nombre' => '');
				if ($reg1['paqueteID'] <> 0 and !array_key_exists($reg1['paqueteID'],$arrPaquetes))
				{
					$r2 = mysql_query("SELECT nombre FROM productos_paquetes WHERE id = ".$reg1['paqueteID']);
					$reg2 = mysql_fetch_array($r2);
					$arrPaquetes[$reg1['paqueteID']] = array('id' => $reg1['paqueteID'], 'nombre' => $reg2['nombre']);
				}
				elseif ($reg1['tipo'] == 1 and $reg1['paqueteID'] == 0)
				{
					$inManoObra = true;
					$r2 = mysql_query("SELECT nombre FROM config_mano_obra WHERE id = ".$reg1['recursoID']);
					$reg2 = mysql_fetch_array($r2);
					$arrPartidas[$reg1['id']]['nombre'] = $reg2['nombre'];
				}
				elseif ($reg1['tipo'] == 2 and $reg1['paqueteID'] == 0)
				{
					$inProductos = true;
					$r2 = mysql_query("SELECT clave,nombre FROM productos WHERE id = ".$reg1['recursoID']);
					$reg2 = mysql_fetch_array($r2);
					$arrPartidas[$reg1['id']]['nombre'] = '<strong>'.$reg2['clave'].'</strong> '.$reg2['nombre'];
				}
			}
		}
?>
<h1>Orden de Servicio <?php echo sprintf('%06d',$_GET['ID'])?></h1>
<div id="forma">
  <h2>Datos de la Orden</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Cliente</label><input type="text" value="<?php echo $reg['cliente']?>" readonly="readonly" /></td>
        </tr>
        <tr>
        <td><label>Automovil</label><input type="text" value="<?php echo $reg['placa'].' | '.$reg['noSerie'].' | '.$reg['marca'].' '.$reg['modelo'].' '.$reg['year']?>" readonly="readonly" /></td>
        </tr>
        <tr>
        <td><label>Estatus</label><select name="estatus" onchange="window.location = 'backend.php?mod=OrdenServicio&acc=Editar&estatus=' + this.value + '&ID=<?php echo $_GET['ID']?>'">
<?php
		foreach ($arrEstatus as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"<?php if ($reg['estatusID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
		}
?>
        </select>
        </td>
        </tr>
    </table>
    <h2>Servicios de la Orden</h2>
    <div id="ajaxDivPartidas">
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
    	<tr>
        <td><label>Precio</label><input type="text" value="<?php echo Moneda($reg['precio'])?>" readonly="readonly" /></td>
        </tr>
      <tr>
        <td>
<?php
		if (count($arrPaquetes) > 0)
		{
?>
        	<h3>Paquetes</h3>
            <ul class="listaPartidas">
<?php
			foreach ($arrPaquetes as $k => $v)
			{
			
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','Paquete','<?php echo $v['id']?>','NULL','<?php echo $_GET['ID']?>');" /></div><div class="clear"></div></li>
<?php
			}
?>
            </ul>
<?php
		}
		if ($inManoObra)
		{
?>
            <h3>Mano de Obra</h3>
            <ul class="listaPartidas">
<?php
			foreach ($arrPartidas as $k => $v)
			{
				if ($v['tipo'] == 1 and $v['paqueteID'] == 0)
				{
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','ManoObra','<?php echo $k?>','NULL','<?php echo $_GET['ID']?>');" /></div><div class="clear"></div></li>
<?php
				}
			}
?>
            </ul>
<?php
		}
		if ($inProductos)
		{
?>
            <h3>Refacciones</h3>
            <ul class="listaPartidas">
<?php
			foreach ($arrPartidas as $k => $v)
			{
				if ($v['tipo'] == 2 and $v['paqueteID'] == 0)
				{
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="text" value="<?php echo $v['cantidad']?>" id="cantidad<?php echo $k?>" style="width:10%;" /> <input type="button" value="Actualizar Cantidad" onclick="ajaxPartidas('Servicio','Edit','Productos','<?php echo $k?>','NULL','<?php echo $_GET['ID']?>');" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','Productos','<?php echo $k?>','NULL','<?php echo $_GET['ID']?>');" /></div><div class="clear"></div></li>
<?php
				}
			}
?>
            </ul>
<?php
		}
?>
        </td>
        </tr>
    </table>
    <h2>Agregar Servicios a la Orden</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?php
		$r = mysql_query("SELECT id,nombre FROM productos_paquetes ORDER BY nombre ASC");
		if (mysql_num_rows($r) > 0)
		{
?>
      <tr>
        <td><label>Paquetes</label>
<?php
			$numCols = 2;
			$i == 1;
			while ($reg = mysql_fetch_array($r))
			{
				$inArray = false;
				foreach ($arrPartidas as $k => $v)
				{
					if ($v['paqueteID'] == $reg['id']) { $inArray = true; }
				}
				echo '<div class="divPaquete';
				if ($inArray) { echo ' divAgregado"'; }
				else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'Paquete\',\''.$reg['id'].'\',\'NULL\',\''.$_GET['ID'].'\');"'; }
				echo '>'.$reg['nombre'];
				$r1 = mysql_query("SELECT recursoID,tipo FROM productos_paquetes_partidas WHERE paqueteID = ".$reg['id']);
				if (mysql_num_rows($r1) > 0)
				{
					echo '<br /><small>Incluye: ';
					while ($reg1 = mysql_fetch_array($r1))
					{
						if ($reg1['tipo'] == 1) { $r2 = mysql_query("SELECT nombre FROM config_mano_obra WHERE id = ".$reg1['recursoID']); }
						else { $r2 = mysql_query("SELECT nombre FROM productos WHERE id = ".$reg1['recursoID']); }
						$reg2 = mysql_fetch_array($r2);
						echo $reg2['nombre'].', ';
					}
					echo '</small>';
				}
				echo '</div>';
				if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
				else { $i++; }
			}
?>
          </td>
        </tr>
<?php
		}
		$r = mysql_query("SELECT id,nombre FROM config_mano_obra_categorias ORDER BY nombre ASC");
		if (mysql_num_rows($r) > 0)
		{
?>
      <tr>
        <td><label>Mano de Obra</label>
<?php
			while ($reg = mysql_fetch_array($r))
			{
				echo '<div class="divCategoria" onclick="ajaxPartidas(\'Servicio\',\'Show\',\'ManoObra\',\'NULL\',\''.$reg['id'].'\',\''.$_GET['ID'].'\');">'.$reg['nombre'].'</div>';
			}
?>
          </td>
        </tr>
<?php
		}
		$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY nombre ASC");
		if (mysql_num_rows($r) > 0)
		{
?>
      <tr>
        <td><label>Refacciones</label>
<?php
			while ($reg = mysql_fetch_array($r))
			{
				echo '<div class="divCategoria" onclick="ajaxPartidas(\'Servicio\',\'Show\',\'Productos\',\'NULL\',\''.$reg['id'].'\',\''.$_GET['ID'].'\');">'.$reg['nombre'].'</div>';
			}
?>
          </td>
        </tr>
<?php
		}
?>
    </table>
</div>
<h2>Seguimientos de la Orden</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?php
		$r = mysql_query("SELECT a.fecha AS fecha,a.seguimiento AS seguimiento,b.nombre AS usuario FROM servicios_seguimientos a JOIN config_usuarios b ON b.id = a.usuarioID WHERE a.servicioID = ".Limpia($_GET['ID'])." ORDER BY fecha DESC");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
?>
      <tr>
        <td><?php echo nl2br($reg['seguimiento']).'<br /><small>'.$reg['usuario'].'</small>';?></td>
      </tr>
<?php
			}
		}
?>
		<form action="backend.php?mod=Seguimiento" method="post">
        <input type="hidden" name="ID" value="<?php echo $_GET['ID']?>" />
      <tr>
        <td><label>Agregar Seguimiento</label>
        	<textarea name="seguimiento" rows="5"></textarea>
          </td>
        </tr>
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar" />
        </td>
      </tr>
      </form>
  </table>
<?php
	}
	else
	{
		echo '<div class="errorMsg">La orden que intentas ver no existe</div>';
	}
}
?>
</div>
<?php include ('footer.php'); ?>