<?php
session_start();
require_once ('include/config.php');
require_once ('include/libreria.php');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?php
$arrPartidas = array();
if ($_GET['secc'] == 'Paquete')
{
	if ($_GET['paqID'] <> 'NULL')
	{
		if (isset($_SESSION['ajaxCestaPartidas'])) { $arrPartidas = $_SESSION['ajaxCestaPartidas']; }
		if ($_GET['acc'] == 'Add' and $_GET['mod'] == 'ManoObra')
		{
			$r = mysql_query("SELECT nombre,costo,categoriaID FROM config_mano_obra WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			$arrPartidas[] = array('id' => $_GET['ID'], 'cantidad' => 1, 'nombre' => $reg['nombre'], 'precio' => $reg['costo'], 'tipo' => 1);
		}
		elseif ($_GET['acc'] == 'Add' and $_GET['mod'] == 'Productos')
		{
			$r = mysql_query("SELECT clave,nombre,precio1,categoriaID FROM productos WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			$arrPartidas[] = array('id' => $_GET['ID'], 'cantidad' => 1, 'nombre' => '<strong>'.$reg['clave'].'</strong> '.$reg['nombre'], 'precio' => $reg['precio1'], 'tipo' => 2);
		}
		elseif ($_GET['acc'] == 'Delete')
		{
			unset($arrPartidas[$_GET['ID']]);
		}
		elseif ($_GET['acc'] == 'Edit')
		{
			$arrPartidas[$_GET['ID']]['cantidad'] = $_GET['cantidad'];
		}
		$_SESSION['ajaxCestaPartidas'] = $arrPartidas;
	}
	else
	{
		
	}
	
	$numCols = 5;
	$total = 0;
	$r = mysql_query("SELECT id,nombre FROM config_mano_obra_categorias ORDER BY nombre ASC");
	if (mysql_num_rows($r) > 0)
	{
?>
      <tr>
        <td><label>Mano de Obra</label>
<?php
		while ($reg = mysql_fetch_array($r))
		{
			echo '<div class="divCategoria" onclick="ajaxPartidas(\'Paquete\',\'Show\',\'ManoObra\',\'NULL\',\''.$reg['id'].'\',\'NULL\');">'.$reg['nombre'].'</div>';
			if ($reg['id'] == $_GET['catID'] and $_GET['mod'] == 'ManoObra')
			{
				$r1 = mysql_query("SELECT id,nombre FROM config_mano_obra WHERE categoriaID = ".$reg['id']);
				if (mysql_num_rows($r1) > 0)
				{
					$i = 1;
					while ($reg1 = mysql_fetch_array($r1))
					{
						$inArray = false;
						foreach ($arrPartidas as $k => $v)
						{
							if ($v['id'] == $reg1['id'] and $v['tipo'] == 1) { $inArray = true; }
						}
						echo '<div class="divRecurso';
						if ($inArray) { echo ' divAgregado"'; }
						else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Paquete\',\'Add\',\'ManoObra\',\''.$reg1['id'].'\',\''.$reg['id'].'\',\'NULL\');"'; }
						echo '>'.$reg1['nombre'].'</div>';
						if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
						else { $i++; }
					}
					echo '<div class="clear"></div>';
				}
			}
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
			echo '<div class="divCategoria" onclick="ajaxPartidas(\'Paquete\',\'Show\',\'Productos\',\'NULL\',\''.$reg['id'].'\',\'NULL\');">'.$reg['nombre'].'</div>';
			if ($reg['id'] == $_GET['catID'] and $_GET['mod'] == 'Productos')
			{
				$r1 = mysql_query("SELECT id,clave,nombre FROM productos WHERE categoriaID = ".$reg['id']);
				if (mysql_num_rows($r1) > 0)
				{
					$i = 1;
					while ($reg1 = mysql_fetch_array($r1))
					{
						$inArray = false;
						foreach ($arrPartidas as $k => $v)
						{
							if ($v['id'] == $reg1['id'] and $v['tipo'] == 2) { $inArray = true; }
						}
						echo '<div class="divRecurso';
						if ($inArray) { echo ' divAgregado"'; }
						else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Paquete\',\'Add\',\'Productos\',\''.$reg1['id'].'\',\''.$reg['id'].'\',\'NULL\');"'; }
						echo '>'.$reg1['nombre'].'</div>';
						if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
						else { $i++; }
					}
					echo '<div class="clear"></div>';
				}
			}
		}
?>
          </td>
        </tr>
<?php
	}
	if (count($arrPartidas) > 0)
	{
		foreach ($arrPartidas as $k => $v)
		{
			$total += ($v['cantidad'] * $v['precio']);
		}
	}
?>
</table>
<h2>Partidas Agregadas</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
	  <td align="right"><label style="display:inline;">Precio del Paquete</label>&nbsp;&nbsp;&nbsp;$ <input type="text" name="precio" id="precio" value="<?php echo $total?>" style="width:15%" /></td>
  </tr>
	<tr>
    	<td>
<?php
	if (count($arrPartidas) > 0)
	{
?>
        	<h3>Mano de Obra</h3>
            <ul class="listaPartidas">
<?php
		foreach ($arrPartidas as $k => $v)
		{
			if ($v['tipo'] == 1)
			{
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="button" value="Eliminar" onclick="ajaxPartidas('Paquete','Delete','ManoObra','<?php echo $k?>','<?php echo $v['categoriaID']?>','NULL');" /></div><div class="clear"></div></li>
<?php
			}
		}
?>
            </ul>
            <h3>Refacciones</h3>
            <ul class="listaPartidas">
<?php
		foreach ($arrPartidas as $k => $v)
		{
			if ($v['tipo'] == 2)
			{
?>
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="text" value="<?php echo $v['cantidad']?>" id="cantidad<?php echo $k?>" style="width:10%;" /> <input type="button" value="Actualizar Cantidad" onclick="ajaxPartidas('Paquete','Edit','Productos','<?php echo $k?>','<?php echo $v['categoriaID']?>','NULL');" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Eliminar" onclick="ajaxPartidas('Paquete','Delete','Productos','<?php echo $k?>','<?php echo $v['categoriaID']?>','NULL');" /></div><div class="clear"></div></li>
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
<?php
}
else
{
	if (!isset($_GET['paqID']))
	{
		if (isset($_SESSION['ajaxCestaServicio'])) { $arrPartidas = $_SESSION['ajaxCestaServicio']; }
		$total = 0;
		if ($_GET['acc'] == 'Add' and $_GET['mod'] == 'ManoObra')
		{
			$r = mysql_query("SELECT nombre,duracion,costo,categoriaID FROM config_mano_obra WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			$arrPartidas[] = array('id' => $_GET['ID'], 'cantidad' => 1, 'nombre' => $reg['nombre'], 'duracion' => $reg['duracion'], 'precio' => $reg['costo'], 'tipo' => 1, 'paqueteID' => 0);
		}
		elseif ($_GET['acc'] == 'Add' and $_GET['mod'] == 'Productos')
		{
			$r = mysql_query("SELECT clave,nombre,precio1,categoriaID FROM productos WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			$arrPartidas[] = array('id' => $_GET['ID'], 'cantidad' => 1, 'nombre' => '<strong>'.$reg['clave'].'</strong> '.$reg['nombre'], 'duracion' => 0, 'precio' => $reg['precio1'], 'tipo' => 2, 'paqueteID' => 0);
		}
		elseif ($_GET['acc'] == 'Add' and $_GET['mod'] == 'Paquete')
		{
			$r = mysql_query("SELECT precio FROM productos_paquetes WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			$precio = $reg['precio'];
			$r = mysql_query("SELECT cantidad,recursoID,tipo FROM productos_paquetes_partidas WHERE paqueteID = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				while ($reg = mysql_fetch_array($r))
				{
					$duracion = 0;
					if ($reg['tipo'] == 1)
					{
						$r1 = mysql_query("SELECT duracion FROM config_mano_obra WHERE id = ".$reg['recursoID']);
						$reg1 = mysql_fetch_array($r1);
						$duracion = $reg1['duracion'];
					}
					$arrPartidas[] = array('id' => $reg['recursoID'], 'cantidad' => $reg['cantidad'], 'nombre' => '', 'duracion' => $duracion, 'precio' => $precio, 'tipo' => $reg['tipo'], 'paqueteID' => $_GET['ID']);
				}
			}		
		}
		elseif ($_GET['acc'] == 'Delete' and $_GET['mod'] == 'Paquete')
		{
			foreach ($arrPartidas as $k => $v)
			{
				if ($v['paqueteID'] == $_GET['ID']) { unset($arrPartidas[$k]); }
			}
		}
		elseif ($_GET['acc'] == 'Delete')
		{
			unset($arrPartidas[$_GET['ID']]);
		}
		elseif ($_GET['acc'] == 'Edit')
		{
			$arrPartidas[$_GET['ID']]['cantidad'] = $_GET['cantidad'];
		}
		$_SESSION['ajaxCestaServicio'] = $arrPartidas;
?>
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
			$i = 1;
			while ($reg = mysql_fetch_array($r))
			{
				$inArray = false;
				foreach ($arrPartidas as $k => $v)
				{
					if ($v['paqueteID'] == $reg['id']) { $inArray = true; }
				}
				echo '<div class="divPaquete';
				if ($inArray) { echo ' divAgregado"'; }
				else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'Paquete\',\'NULL\',\''.$reg['id'].'\',\'NULL\');"'; }
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
		$numCols = 5;
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
				if ($reg['id'] == $_GET['catID'] and $_GET['mod'] == 'ManoObra')
				{
					$r1 = mysql_query("SELECT id,nombre FROM config_mano_obra WHERE categoriaID = ".$reg['id']);
					if (mysql_num_rows($r1) > 0)
					{
						$i = 1;
						while ($reg1 = mysql_fetch_array($r1))
						{
							$inArray = false;
							foreach ($arrPartidas as $k => $v)
							{
								if ($v['id'] == $reg1['id'] and $v['tipo'] == 1) { $inArray = true; }
							}
							echo '<div class="divRecurso';
							if ($inArray) { echo ' divAgregado"'; }
							else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'ManoObra\',\''.$reg1['id'].'\',\''.$reg['id'].'\',\'NULL\');"'; }
							echo '>'.$reg1['nombre'].'</div>';
							if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
							else { $i++; }
						}
						echo '<div class="clear"></div>';
					}
				}
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
				if ($reg['id'] == $_GET['catID'] and $_GET['mod'] == 'Productos')
				{
					$r1 = mysql_query("SELECT id,clave,nombre FROM productos WHERE categoriaID = ".$reg['id']);
					if (mysql_num_rows($r1) > 0)
					{
						$i = 1;
						while ($reg1 = mysql_fetch_array($r1))
						{
							$inArray = false;
							foreach ($arrPartidas as $k => $v)
							{
								if ($v['id'] == $reg1['id'] and $v['tipo'] == 2) { $inArray = true; }
							}
							echo '<div class="divRecurso';
							if ($inArray) { echo ' divAgregado"'; }
							else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'Productos\',\''.$reg1['id'].'\',\''.$reg['id'].'\',\'NULL\');"'; }
							echo '>'.$reg1['nombre'].'</div>';
							if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
							else { $i++; }
						}
						echo '<div class="clear"></div>';
					}
				}
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
					$r = mysql_query("SELECT nombre FROM productos_paquetes WHERE id = ".$v['paqueteID']);
					$reg = mysql_fetch_array($r);
					$arrPaquetes[$v['paqueteID']] = array('id' => $v['paqueteID'], 'nombre' => $reg['nombre']);
					$total += $v['precio'];
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
<?php
	}
	else
	{
		if ($_GET['acc'] == 'Add' and $_GET['mod'] == 'ManoObra')
		{
			$r = mysql_query("SELECT duracion,costo FROM config_mano_obra WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			mysql_query("INSERT INTO servicios_partidas (cantidad,precio,tipo,recursoID,paqueteID,servicioID) VALUES (1,".$reg['costo'].",1,".Limpia($_GET['ID']).",0,".Limpia($_GET['paqID']).")");
			mysql_query("UPDATE servicios SET precio = precio + ".$reg['costo'].", duracion = duracion + ".$reg['duracion']." WHERE id = ".Limpia($_GET['paqID']));
		}
		elseif ($_GET['acc'] == 'Add' and $_GET['mod'] == 'Productos')
		{
			$r = mysql_query("SELECT precio1 FROM productos WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			mysql_query("INSERT INTO servicios_partidas (cantidad,precio,tipo,recursoID,paqueteID,servicioID) VALUES (1,".$reg['precio1'].",2,".Limpia($_GET['ID']).",0,".Limpia($_GET['paqID']).")");
			mysql_query("UPDATE servicios SET precio = precio + ".$reg['precio1']." WHERE id = ".Limpia($_GET['paqID']));
		}
		elseif ($_GET['acc'] == 'Add' and $_GET['mod'] == 'Paquete')
		{
			$r = mysql_query("SELECT precio FROM productos_paquetes WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			$precio = $reg['precio'];
			$r = mysql_query("SELECT cantidad,recursoID,tipo FROM productos_paquetes_partidas WHERE paqueteID = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				while ($reg = mysql_fetch_array($r))
				{
					$duracion = 0;
					if ($reg['tipo'] == 1)
					{
						$r1 = mysql_query("SELECT duracion FROM config_mano_obra WHERE id = ".$reg['recursoID']);
						$reg1 = mysql_fetch_array($r1);
						$duracion = $reg1['duracion'];
					}
					mysql_query("INSERT INTO servicios_partidas (cantidad,precio,tipo,recursoID,paqueteID,servicioID) VALUES (".$reg['cantidad'].",".$precio.",".$reg['tipo'].",".$reg['recursoID'].",".Limpia($_GET['ID']).",".Limpia($_GET['paqID']).")");
					mysql_query("UPDATE servicios SET duracion = duracion + ".$duracion." WHERE id = ".Limpia($_GET['paqID']));
				}
				mysql_query("UPDATE servicios SET precio = precio + ".$precio." WHERE id = ".Limpia($_GET['paqID']));
			}		
		}
		elseif ($_GET['acc'] == 'Delete' and $_GET['mod'] == 'Paquete')
		{
			mysql_query("DELETE FROM servicios_partidas WHERE servicioID = ".Limpia($_GET['paqID'])." AND paqueteID = ".Limpia($_GET['ID']));
		}
		elseif ($_GET['acc'] == 'Delete')
		{
			mysql_query("DELETE FROM servicios_partidas WHERE id = ".Limpia($_GET['ID']));
		}
		elseif ($_GET['acc'] == 'Edit')
		{
			$r = mysql_query("SELECT a.cantidad AS cantidad,b.precio1 AS precio FROM servicios_partidas a JOIN productos b ON b.id = a.recursoID WHERE a.id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			mysql_query("UPDATE servicios_partidas SET cantidad = ".Limpia($_GET['cantidad'])." WHERE id = ".Limpia($_GET['ID']));
			mysql_query("UPDATE servicios SET precio = precio + ".($reg['precio'] * ($_GET['cantidad'] - $reg['cantidad']))." WHERE id = ".Limpia($_GET['paqID']));
		}
		
		$arrPartidas = array();
		$arrPaquetes = array();
		$inManoObra = false;
		$inProductos = false;
		$r1 = mysql_query("SELECT id,cantidad,tipo,recursoID,paqueteID FROM servicios_partidas WHERE servicioID = ".Limpia($_GET['paqID']));
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
		$r1 = mysql_query("SELECT precio FROM servicios WHERE id = ".Limpia($_GET['paqID']));
		$reg1 = mysql_fetch_array($r1);
?>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Precio</label><input type="text" value="<?php echo Moneda($reg1['precio'])?>" readonly="readonly" /></td>
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
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','Paquete','<?php echo $v['id']?>','NULL','<?php echo $_GET['paqID']?>');" /></div><div class="clear"></div></li>
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
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','ManoObra','<?php echo $k?>','NULL','<?php echo $_GET['paqID']?>');" /></div><div class="clear"></div></li>
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
            	<li><?php echo $v['nombre']?><div style="float:right; text-align:right;"><input type="text" value="<?php echo $v['cantidad']?>" id="cantidad<?php echo $k?>" style="width:10%;" /> <input type="button" value="Actualizar Cantidad" onclick="ajaxPartidas('Servicio','Edit','Productos','<?php echo $k?>','NULL','<?php echo $_GET['ID']?>');" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Eliminar" onclick="ajaxPartidas('Servicio','Delete','Productos','<?php echo $k?>','NULL','<?php echo $_GET['paqID']?>');" /></div><div class="clear"></div></li>
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
			$i = 1;
			while ($reg = mysql_fetch_array($r))
			{
				$inArray = false;
				foreach ($arrPartidas as $k => $v)
				{
					if ($v['paqueteID'] == $reg['id']) { $inArray = true; }
				}
				echo '<div class="divPaquete';
				if ($inArray) { echo ' divAgregado"'; }
				else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'Paquete\',\'NULL\',\''.$reg['id'].'\',\''.$_GET['paqID'].'\');"'; }
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
		$numCols = 5;
		$r = mysql_query("SELECT id,nombre FROM config_mano_obra_categorias ORDER BY nombre ASC");
		if (mysql_num_rows($r) > 0)
		{
?>
      <tr>
        <td><label>Mano de Obra</label>
<?php
			while ($reg = mysql_fetch_array($r))
			{
				echo '<div class="divCategoria" onclick="ajaxPartidas(\'Servicio\',\'Show\',\'ManoObra\',\'NULL\',\''.$reg['id'].'\',\''.$_GET['paqID'].'\');">'.$reg['nombre'].'</div>';
				if ($reg['id'] == $_GET['catID'] and $_GET['mod'] == 'ManoObra')
				{
					$r1 = mysql_query("SELECT id,nombre FROM config_mano_obra WHERE categoriaID = ".$reg['id']);
					if (mysql_num_rows($r1) > 0)
					{
						$i = 1;
						while ($reg1 = mysql_fetch_array($r1))
						{
							$inArray = false;
							foreach ($arrPartidas as $k => $v)
							{
								if ($v['id'] == $reg1['id'] and $v['tipo'] == 1) { $inArray = true; }
							}
							echo '<div class="divRecurso';
							if ($inArray) { echo ' divAgregado"'; }
							else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'ManoObra\',\''.$reg1['id'].'\',\''.$reg['id'].'\',\''.$_GET['paqID'].'\');"'; }
							echo '>'.$reg1['nombre'].'</div>';
							if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
							else { $i++; }
						}
						echo '<div class="clear"></div>';
					}
				}
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
				echo '<div class="divCategoria" onclick="ajaxPartidas(\'Servicio\',\'Show\',\'Productos\',\'NULL\',\''.$reg['id'].'\',\''.$_GET['paqID'].'\');">'.$reg['nombre'].'</div>';
				if ($reg['id'] == $_GET['catID'] and $_GET['mod'] == 'Productos')
				{
					$r1 = mysql_query("SELECT id,clave,nombre FROM productos WHERE categoriaID = ".$reg['id']);
					if (mysql_num_rows($r1) > 0)
					{
						$i = 1;
						while ($reg1 = mysql_fetch_array($r1))
						{
							$inArray = false;
							foreach ($arrPartidas as $k => $v)
							{
								if ($v['id'] == $reg1['id'] and $v['tipo'] == 2) { $inArray = true; }
							}
							echo '<div class="divRecurso';
							if ($inArray) { echo ' divAgregado"'; }
							else { echo ' divNoAgregado" onclick="ajaxPartidas(\'Servicio\',\'Add\',\'Productos\',\''.$reg1['id'].'\',\''.$reg['id'].'\',\''.$_GET['paqID'].'\');"'; }
							echo '>'.$reg1['nombre'].'</div>';
							if ($i == $numCols) { $i = 1; echo '<div class="clear"></div>'; }
							else { $i++; }
						}
						echo '<div class="clear"></div>';
					}
				}
			}
?>
          </td>
        </tr>
<?php
		}
?>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />
        </td>
      </tr>
  </table>
  </form>
<?php
	}
}
?>