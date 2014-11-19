<?php
session_start();
require_once ('include/config.php');
require_once ('include/libreria.php');

$arrPaises = array();
$r = mysql_query("SELECT id,nombre FROM config_paises");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrPaises[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
	}
}
$arrMarcas = array();
$r = mysql_query("SELECT id,nombre FROM config_vehiculos_marcas");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrMarcas[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
	}
}

switch ($_GET['divID'])
{
	case 'divDirecciones':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$arrDomicilios = array();
			if (isset($_SESSION['arrDomiciliosAmNetPV2012'])) { $arrDomicilios = $_SESSION['arrDomiciliosAmNetPV2012']; }
			if (isset($_GET['ID']))
			{
				unset ($arrDomicilios[$_GET['ID']]);
			}
			else
			{
				$arrDomicilios[] = array('domicilio' => $_GET['domicilio'], 'colonia' => $_GET['colonia'], 'cp' => $_GET['cp'], 'pais' => $_GET['pais'], 'estado' => $_GET['estado'], 'ciudad' => $_GET['ciudad']);
			}
			$_SESSION['arrDomiciliosAmNetPV2012'] = $arrDomicilios;
		}
		else
		{
			$arrDomicilios = array();
			if (isset($_GET['ID']))
			{
				mysql_query("DELETE FROM clientes_direcciones WHERE id = ".Limpia($_GET['ID']));
			}	
			else
			{	
				mysql_query("INSERT INTO clientes_direcciones (direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($_GET['domicilio']).",".Limpia($_GET['colonia']).",".Limpia($_GET['cp']).",".Limpia($_GET['pais']).",".Limpia($_GET['estado']).",".Limpia($_GET['ciudad']).",".Limpia($_GET['cliente']).")");
			}
			$r = mysql_query("SELECT * FROM clientes_direcciones WHERE clienteID = ".Limpia($_GET['cliente']));
			if (mysql_num_rows($r) > 0)
			{
				while ($reg = mysql_fetch_array($r))
				{
					$arrDomicilios[] = array('id' => $reg['id'], 'domicilio' => $reg['direccion'], 'colonia' => $reg['colonia'], 'cp' => $reg['cp'], 'pais' => $reg['paisID'], 'estado' => $reg['estadoID'], 'ciudad' => $reg['ciudadID']);
				}
			}
		}
?>
	<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="26%">Domicilio</td>
        <td width="15%">Colonia</td>
        <td width="10%">C.P.</td>
        <td width="15%">Pais</td>
        <td width="15%">Estado</td>
        <td width="15%">Ciudad</td>
        <td width="4%">&nbsp;</td>
      </tr>
<?php
		foreach($arrDomicilios as $k => $v)
		{
			$r = mysql_query("SELECT a.nombre AS pais, b.nombre AS estado, c.nombre AS ciudad FROM config_paises a, config_estados b, config_ciudades c WHERE a.id = ".$v['pais']." AND b.id = ".$v['estado']." AND c.id = ".$v['ciudad']);
			$reg = mysql_fetch_array($r);
?>
      <tr class="fila">
        <td><?php echo $v['domicilio']?></td>
        <td><?php echo $v['colonia']?></td>
        <td><?php echo $v['cp']?></td>
        <td><?php echo $reg['pais']?></td>
        <td><?php echo $reg['estado']?></td>
        <td><?php echo $reg['ciudad']?></td>
        <td align="center"><input type="button" value="-" title="Eliminar" onclick="ajaxSaveData('Editar','<?php echo $v['id']?>','divDirecciones');" /></td>
      </tr>
<?php
		}
?>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
	  <tr>
        <td><label>Domicilio</label><input type="text" name="domicilio" id="domicilio"></td>
        <td><label>Colonia</label><input type="text" name="colonia" id="colonia"></td>
      </tr>
      <tr>
        <td><label>Codigo Postal</label><input type="text" name="cp" id="cp"></td>
        <td><label>Pais</label>
          <select name="pais" id="pais" onChange="ajaxGetSelectValues(this.value,'divEstado')">
			<option value="" selected="selected"> - Selecciona -</option>
<?php
		if (count($arrPaises) > 0)
		{
			foreach ($arrPaises as $k => $v)
			{
?>
             <option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
			}
		}
?>
          </select></td>
      </tr>
      <tr>
        <td>
        <div id="divEstado">
        <label>Estado</label>
        <select name="estado" id="estado" onChange="ajaxGetSelectValues(this.value,'divCiudad')">
        	<option value="" selected="selected">- Selecciona -</option>
        </select>
        </div>
		</td>
        <td>
        <div id="divCiudad">
        <label>Ciudad</label>
        <select name="ciudad" id="ciudad">
	        <option value="">- Selecciona -</option>
        </select>
        </div>
		</td>
      </tr>
  </table>
<?php
		break;
	}
	case 'divFiscales':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$arrFiscales = array();
			if (isset($_SESSION['arrFiscalesAmNetPV2012'])) { $arrFiscales = $_SESSION['arrFiscalesAmNetPV2012']; }
			if (isset($_GET['ID']))
			{
				unset ($arrDomicilios[$_GET['ID']]);
			}
			else
			{
				$arrFiscales[] = array('razonSocial' => $_GET['razonSocial'], 'rfc' => $_GET['rfc'], 'domicilio' => $_GET['domicilio'], 'colonia' => $_GET['colonia'], 'cp' => $_GET['cp'], 'pais' => $_GET['pais'], 'estado' => $_GET['estado'], 'ciudad' => $_GET['ciudad']);
			}
			$_SESSION['arrFiscalesAmNetPV2012'] = $arrFiscales;
		}
		else
		{
			$arrFiscales = array();
			if (isset($_GET['ID']))
			{
				mysql_query("DELETE FROM clientes_datos_fiscales WHERE id = ".Limpia($_GET['ID']));
			}	
			else
			{	
				mysql_query("INSERT INTO clientes_datos_fiscales (razonSocial,rfc,direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($_GET['razonSocial']).",".Limpia($_GET['rfc']).",".Limpia($_GET['domicilio']).",".Limpia($_GET['colonia']).",".Limpia($_GET['cp']).",".Limpia($_GET['pais']).",".Limpia($_GET['estado']).",".Limpia($_GET['ciudad']).",".Limpia($_GET['cliente']).")");
			}
			$r = mysql_query("SELECT * FROM clientes_datos_fiscales WHERE clienteID = ".Limpia($_GET['cliente']));
			if (mysql_num_rows($r) > 0)
			{
				while ($reg = mysql_fetch_array($r))
				{
					$arrFiscales[] = array('id' => $reg['id'], 'razonSocial' => $reg['razonSocial'], 'rfc' => $reg['rfc'], 'domicilio' => $reg['direccion'], 'colonia' => $reg['colonia'], 'cp' => $reg['cp'], 'pais' => $reg['paisID'], 'estado' => $reg['estadoID'], 'ciudad' => $reg['ciudadID']);
				}
			}
		}
?>
	<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="15%">Razon Social</td>
        <td width="10%">R.F.C.</td>
        <td width="15%">Domicilio</td>
        <td width="15%">Colonia</td>
        <td width="10%">C.P.</td>
        <td width="10%">Pais</td>
        <td width="10%">Estado</td>
        <td width="10%">Ciudad</td>
        <td width="5%">&nbsp;</td>
      </tr>
<?php
		foreach($arrFiscales as $k => $v)
		{
			$r = mysql_query("SELECT a.nombre AS pais, b.nombre AS estado, c.nombre AS ciudad FROM config_paises a, config_estados b, config_ciudades c WHERE a.id = ".$v['pais']." AND b.id = ".$v['estado']." AND c.id = ".$v['ciudad']);
			$reg = mysql_fetch_array($r);
?>
     <tr class="fila">
        <td><?php echo $v['razonSocial']?></td>
        <td><?php echo $v['rfc']?></td>
        <td><?php echo $v['domicilio']?></td>
        <td><?php echo $v['colonia']?></td>
        <td><?php echo $v['cp']?></td>
        <td><?php echo $reg['pais']?></td>
        <td><?php echo $reg['estado']?></td>
        <td><?php echo $reg['ciudad']?></td>
        <td align="center"><input type="button" value="-" title="Eliminar" onclick="ajaxSaveData('Editar','<?php echo $v['id']?>','divFiscales');" /></td>
      </tr>
<?php
		}
?>
	</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
	  <tr>
        <td width="50%"><label>Razon Social</label><input type="text" name="razonSocial" id="razonSocial"></td>
        <td width="50%"><label>R.F.C.</label><input type="text" name="rfc" id="rfc"></td>
      </tr>
      <tr>
        <td width="50%"><label>Domicilio</label><input type="text" name="domicilioFiscal" id="domicilioFiscal"></td>
        <td width="50%"><label>Colonia</label><input type="text" name="coloniaFiscal" id="coloniaFiscal"></td>
      </tr>
      <tr>
        <td><label>Codigo Postal</label><input type="text" name="cpFiscal" id="cpFiscal"></td>
        <td><label>Pais</label>
          <select name="paisFiscal" id="paisFiscal" onChange="ajaxGetSelectValues(this.value,'divEstadoFiscal')">
			<option value="" selected="selected"> - Selecciona -</option>
<?php
		if (count($arrPaises) > 0)
		{
			foreach ($arrPaises as $k => $v)
			{
?>
             <option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
			}
		}
?>
          </select></td>
      </tr>
      <tr>
        <td>
        <div id="divEstadoFiscal">
        <label>Estado</label>
        <select name="estadoFiscal" id="estadoFiscal" onChange="ajaxGetSelectValues(this.value,'divCiudadFiscal')">
        	<option value="" selected="selected">- Selecciona -</option>
        </select>
        </div>
		</td>
        <td>
        <div id="divCiudadFiscal">
        <label>Ciudad</label>
        <select name="ciudadFiscal" id="ciudadFiscal">
	        <option value="">- Selecciona -</option>
        </select>
        </div>
        </td>
      </tr>
  </table>
<?php
		break;
	}
	case 'divVehiculos':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$arrVehiculos = array();
			if (isset($_SESSION['arrVehiculosAmNetPV2012'])) { $arrVehiculos = $_SESSION['arrVehiculosAmNetPV2012']; }
			if (isset($_GET['ID']))
			{
				unset ($arrVehiculos[$_GET['ID']]);
			}
			else
			{
				$arrVehiculos[] = array('placa' => $_GET['placa'], 'noSerie' => $_GET['noSerie'], 'marca' => $_GET['marca'], 'modelo' => $_GET['modelo'], 'year' => $_GET['year'], 'noEconomico' => $_GET['noEconomico']);
			}
			$_SESSION['arrVehiculosAmNetPV2012'] = $arrVehiculos;
		}
		else
		{
			$arrVehiculos = array();
			if (isset($_GET['ID']))
			{
				mysql_query("DELETE FROM clientes_vehiculos WHERE id = ".Limpia($_GET['ID']));
			}	
			else
			{	
				mysql_query("INSERT INTO clientes_vehiculos (placa,noSerie,noEconomico,year,marcaID,modeloID,clienteID) VALUES (".Limpia($_GET['placa']).",".Limpia($_GET['noSerie']).",".Limpia($_GET['noEconomico']).",".Limpia($_GET['year']).",".Limpia($_GET['marca']).",".Limpia($_GET['modelo']).",".Limpia($_GET['cliente']).")");
			}
			$r = mysql_query("SELECT * FROM clientes_vehiculos WHERE clienteID = ".Limpia($_GET['cliente']));
			if (mysql_num_rows($r) > 0)
			{
				while ($reg = mysql_fetch_array($r))
				{
					$arrVehiculos[] = array('id' => $reg['id'], 'placa' => $reg['placa'], 'noSerie' => $reg['noSerie'], 'noEconomico' => $reg['noEconomico'], 'year' => $reg['year'], 'marca' => $reg['marcaID'], 'modelo' => $reg['modeloID']);
				}
			}
		}
?>
	<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="15%">Marca</td>
        <td width="10%">Modelo</td>
        <td width="15%">Año</td>
        <td width="15%">No. de Placa</td>
        <td width="10%">No. de Serie</td>
        <td width="10%">No. Económico</td>
        <td width="5%">&nbsp;</td>
      </tr>
<?php
		foreach($arrVehiculos as $k => $v)
		{
			$r = mysql_query("SELECT a.nombre AS marca, b.nombre AS modelo FROM config_vehiculos_marcas a, config_vehiculos_modelos b WHERE a.id = ".$v['marca']." AND b.id = ".$v['modelo']);
			$reg = mysql_fetch_array($r);
?>
     <tr class="fila">
        <td><?php echo $reg['marca']?></td>
        <td><?php echo $reg['modelo']?></td>
        <td><?php echo $v['year']?></td>
        <td><?php echo $v['placa']?></td>
        <td><?php echo $v['noSerie']?></td>
        <td><?php echo $reg['noEconomico']?></td>
        <td align="center"><input type="button" value="-" title="Eliminar" onclick="ajaxSaveData('Editar','<?php echo $v['id']?>','divVehiculos');" /></td>
      </tr>
<?php
		}
?>
	</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>No. de Placa</label><input type="text" name="placa" id="placa"></td>
        <td width="50%"><label>No. de Serie</label><input type="text" name="noSerie" id="noSerie"></td>
      </tr>
      <tr>
        <td><label>Marca</label>
          <select name="marca" id="marca" onChange="ajaxGetSelectValues(this.value,'divModelo')">
			<option value="" selected="selected"> - Selecciona -</option>
<?php
	if (count($arrMarcas) > 0)
	{
		foreach ($arrMarcas as $k => $v)
		{
?>
             <option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
		}
	}
?>
          </select></td>
        <td><div id="divModelo">
        <label>Modelo</label>
        <select name="modelo" id="modelo">
        	<option value="" selected="selected">- Selecciona -</option>
        </select>
        </div></td>
      </tr>
      <tr>
        <td width="50%"><label>Año</label><input type="text" name="year" id="year"></td>
        <td width="50%"><label>No. Económico</label><input type="text" name="noEconomico" id="noEconomico"></td>
      </tr>
  </table>
<?php
		break;
	}
	case 'divEntrada':
	{
		$arrProductos = array();
		if (isset($_SESSION['arrProductosAmNetPV2012'])) { $arrProductos = $_SESSION['arrProductosAmNetPV2012']; }
		if ($_GET['acc'] == 'Add')
		{
			$r = mysql_query("SELECT a.id AS id,a.clave AS clave,a.nombre AS nombre,a.costoActual AS costoActual,a.precio1 AS precio,b.nombre AS uEntrada,c.nombre AS uSalida FROM productos a JOIN productos_unidades b ON b.id = a.unidadEntradaID WHERE a.clave = ".Limpia($_GET['clave']));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				$arrProductos[] = array('id' => $reg['id'], 'clave' => $reg['clave'], 'producto' => $reg['nombre'], 'precio' => $reg['precio'], 'uEntrada' => $reg['uEntrada'], 'cantidad' => $_GET['cantidad']);
			}
			else
			{
				
			}
		}
		else
		{
			unset ($arrProductos[$_GET['ID']]);
		}
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td width="15%">&nbsp;</td>
        <td width="15%"><label>Clave</label>
          <input type="text" name="clave" id="clave" onchange="ajaxSaveProducto('Entrada','Add','');"></td>
        <td width="35%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
      </tr>
</table>
<?php
		$_SESSION['arrProductosAmNetPV2012'] = $arrProductos;
		if (count($arrProductos) > 0)
		{
			$subtotal = 0;
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezadoVenta">
        <td width="55%">Producto</td>
        <td width="10%">Cantidad</td>
        <td width="10%">Unidad Entrada</td>
        <td width="10%">Costo Unitario</td>
        <td width="10%">Unidades Ingresadas</td>
        <td width="10%">Unidad Salida</td>
        <td width="15%">Precio Unitario</td>
        <td width="15%">Existencia Actual</td>
        <td width="10%">Apartados</td>
        <td width="5%">&nbsp;</td>
      </tr>
<?php
			foreach ($arrProductos as $k => $v)
			{
				$subtotal += $v['precio'] * $v['cantidad'];
				$descuento = $subtotal * ($_SESSION['DescuentoAmNetPV2012'] / 100);
				$subtotalDesc = $subtotal - $descuento;
				$iva = $subtotalDesc * ($_SESSION['IVASucursalAmNetPV2012'] / 100);
				$total = $subtotalDesc + $iva;
?>
      <tr class="filaVenta">
        <td align="center"><?php echo $v['cantidad']?></td>
        <td align="center"><?php echo $v['cantidad']?></td>
        <td align="center"><?php echo $v['cantidad']?></td>
        <td align="center"><?php echo $v['cantidad']?></td>
        <td align="center"><?php echo $v['cantidad']?></td>
        <td align="center"><?php echo $v['cantidad']?></td>
        <td><?php echo $v['clave'].' - '.$v['producto'].'<br>Unidad de Salida: '.$v['uSalida']?></td>
        <td align="right"><?php echo '$ '.number_format($v['precio'],2)?></td>
        <td align="right"><?php echo '$ '.number_format($v['precio'] * $v['cantidad'],2)?></td>
        <td align="center"><input type="button" value="-" title="Eliminar" onclick="ajaxSaveProducto('Del','<?php echo $v['id']?>');" /></td>
      </tr>
<?php
			}
?>
    </table>
<?php
		}
		else
		{
			echo '<div class="error">No se han agregado Productos a esta venta</div>';
		}
		break;
	}
}
?>
