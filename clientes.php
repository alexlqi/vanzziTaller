<?php include ('header.php'); ?>
<?php
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
$arrListasPrecios = array(1 => 'Precio Menudeo', 2 => 'Precio Mayoreo', 3 => 'Precio Especial', 4 => 'Precio 4', 5 => 'Precio 5');
?>
<div id="body">
<h1>Clientes</h1>
<div id="divBotones"><input type="button" value="Lista de Clientes" onclick="window.location = 'clientes.php?mod=Lista&OT=3'" /></div>
<div class="btnDescarga" style="width:115px;" onclick="window.location = 'getListado.php?mod=Clientes';">Listado de Clientes</div>
<?php
if (!isset($_GET['mod']))
{
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Cliente&acc=Crear" onsubmit="return ValidaForm(this,'Cliente');" autocomplete="off">
  <h2>Datos Personales</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="Buscar Cliente..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Clientes','divAutoBuscar');"><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
        <td width="50%"><label>Contacto</label><input type="text" name="contacto" id="contacto"></td>
      </tr>
      <tr>
        <td><label>Lista de Telefonos</label><textarea name="listaTelefonos" rows="3" id="listaTelefonos"></textarea></td>
        <td><label>Observaciones</label><textarea name="observaciones" rows="3" id="observaciones"></textarea></td>
      </tr>
      <tr>
        <td><label>Correo Electronico</label><input type="text" name="email" id="email"></td>
        <td><label>Lista de Precios</label>
          <select name="listaPrecios" id="listaPrecios">
<?php
	for ($i = 1; $i <= 5; $i++)
	{
?>
             <option value="<?php echo $i?>"><?php echo $arrListasPrecios[$i]?></option>
<?php
	}
?>
          </select></td>
      </tr>
    </table>
	<h2>Domicilio&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Agregar Otro" onclick="ajaxSaveData('Crear','','divDirecciones');" /></h2>
    <div id="divDirecciones">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Domicilio</label><input type="text" name="domicilio" id="domicilio"></td>
        <td width="50%"><label>Colonia</label><input type="text" name="colonia" id="colonia"></td>
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
  </div>
  	<h2>Datos del Vehiculo&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Agregar Otro" onclick="ajaxSaveData('Crear','','divVehiculos');" /></h2>
    <div id="divVehiculos">
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
  </div>
  <br />
    <h2>Datos Fiscales&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Agregar Otro" onclick="ajaxSaveData('Crear','','divFiscales');" /></h2>
    <div id="divFiscales">
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
elseif ($_GET['mod'] == 'Editar')
{
	$r = mysql_query("SELECT * FROM clientes WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Cliente&acc=Editar" onsubmit="return ValidaForm(this,'Cliente');">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
  <h2>Datos Personales</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>"></td>
        <td width="50%"><label>Contacto</label><input type="text" name="contacto" id="contacto" value="<?php echo $reg['contacto']?>"></td>
      </tr>
      <tr>
        <td><label>Lista de Telefonos</label><textarea name="listaTelefonos" rows="3" id="listaTelefonos"><?php echo $reg['listaTelefonos']?></textarea></td>
        <td><label>Observaciones</label><textarea name="observaciones" rows="3" id="observaciones"><?php echo $reg['observaciones']?></textarea></td>
      </tr>
      <tr>
        <td><label>Correo Electronico</label><input type="text" name="email" id="email" value="<?php echo $reg['email']?>"></td>
        <td><label>Lista de Precios</label>
          <select name="listaPrecios" id="listaPrecios">
<?php
	for ($i = 1; $i <= 5; $i++)
	{
?>
             <option value="<?php echo $i?>"<?php if ($reg['listaPrecios'] == $i) { echo ' selected="selected"'; }?>><?php echo $arrListasPrecios[$i]?></option>
<?php
	}
?>
          </select></td>
      </tr>
    </table>
	<h2>Domicilio&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Agregar Otro" onclick="ajaxSaveData('Editar','','divDirecciones');" /></h2>
    <div id="divDirecciones">
<?php
		$r1 = mysql_query("SELECT a.id AS id, a.direccion AS direccion, a.colonia AS colonia, a.cp AS cp, b.nombre AS pais, c.nombre AS estado, d.nombre AS ciudad FROM clientes_direcciones a JOIN config_paises b ON b.id = a.paisID JOIN config_estados c ON c.id = a.estadoID JOIN config_ciudades d ON d.id = a.ciudadID WHERE a.clienteID = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r1) > 0)
		{
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
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
      <tr class="fila">
        <td><?php echo $reg1['direccion']?></td>
        <td><?php echo $reg1['colonia']?></td>
        <td><?php echo $reg1['cp']?></td>
        <td><?php echo $reg1['pais']?></td>
        <td><?php echo $reg1['estado']?></td>
        <td><?php echo $reg1['ciudad']?></td>
        <td align="center"><input type="button" value="-" title="Eliminar" onclick="ajaxSaveData('Editar','<?php echo $reg1['id']?>','divDirecciones');" /></td>
      </tr>
<?php
			}
?>
    </table>
<?php
		}
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Domicilio</label><input type="text" name="domicilio" id="domicilio"></td>
        <td width="50%"><label>Colonia</label><input type="text" name="colonia" id="colonia"></td>
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
  </div>
  <h2>Datos del Vehiculo&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Agregar Otro" onclick="ajaxSaveData('Crear','','divVehiculos');" /></h2>
    <div id="divVehiculos">
<?php
		$r1 = mysql_query("SELECT a.id AS id, a.placa AS placa, a.noSerie AS noSerie, a.noEconomico AS noEconomico, a.year AS year, b.nombre AS marca, c.nombre AS modelo FROM clientes_vehiculos a JOIN config_vehiculos_marcas b ON b.id = a.marcaID JOIN config_vehiculos_modelos c ON c.id = a.modeloID WHERE a.clienteID = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r1) > 0)
		{
?>
    <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="15%">Marca</td>
        <td width="25%">Modelo</td>
        <td width="10%">Año</td>
        <td width="15%">No. de Placa</td>
        <td width="15%">No. de Serie</td>
        <td width="15%">No. Económico</td>
        <td width="5%">&nbsp;</td>
      </tr>
<?php
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
     <tr class="fila">
        <td><?php echo $reg1['marca']?></td>
        <td><?php echo $reg1['modelo']?></td>
        <td><?php echo $reg1['year']?></td>
        <td><?php echo $reg1['placa']?></td>
        <td><?php echo $reg1['noSerie']?></td>
        <td><?php echo $reg1['noEconomico']?></td>
        <td align="center"><input type="button" value="-" title="Eliminar" onclick="ajaxSaveData('Editar','<?php echo $reg1['id']?>','divVehiculos');" /></td>
      </tr>
<?php
			}
?>
	</table>
<?php
		}
?>
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
  </div>
    <h2>Datos Fiscales&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Agregar Otro" onclick="ajaxSaveData('Editar','','divFiscales');" /></h2>
    <div id="divFiscales">
<?php
		$r1 = mysql_query("SELECT a.id AS id, a.razonSocial AS razonSocial, a.rfc AS rfc, a.direccion AS direccion, a.colonia AS colonia, a.cp AS cp, b.nombre AS pais, c.nombre AS estado, d.nombre AS ciudad FROM clientes_datos_fiscales a JOIN config_paises b ON b.id = a.paisID JOIN config_estados c ON c.id = a.estadoID JOIN config_ciudades d ON d.id = a.ciudadID WHERE a.clienteID = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r1) > 0)
		{
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
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
      <tr class="fila">
        <td><?php echo $reg1['razonSocial']?></td>
        <td><?php echo $reg1['rfc']?></td>
        <td><?php echo $reg1['direccion']?></td>
        <td><?php echo $reg1['colonia']?></td>
        <td><?php echo $reg1['cp']?></td>
        <td><?php echo $reg1['pais']?></td>
        <td><?php echo $reg1['estado']?></td>
        <td><?php echo $reg1['ciudad']?></td>
        <td align="center"><input type="button" value="-" title="Eliminar" onclick="ajaxSaveData('Editar','<?php echo $reg1['id']?>','divFiscales');" /></td>
      </tr>
<?php
			}
?>
    </table>
<?php
		}
?>
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
  </div>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Edicion" onclick="window.location = 'clientes.php?OT=3';" /></td>
      </tr>
        </td>
      </tr>
  </table>
  </form>
<?php
	}
?>
</div>
<?php
}
elseif ($_GET['mod'] == 'Lista')
{
	$r = mysql_query("SELECT * FROM clientes ORDER BY nombre ASC");
	if (mysql_num_rows($r) > 0)
	{
?>
	<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="10%">No. de Cliente</td>
        <td width="24%">Nombre</td>
        <td width="20%">Contacto</td>
        <td width="25%">E-mail</td>
        <td width="11%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
      </tr>
<?php
			while ($reg = mysql_fetch_array($r))
			{
?>
      <tr class="fila">
        <td class="divFolio"><?php echo sprintf('%06d',$reg['id'])?></td>
        <td><?php echo $reg['nombre']?></td>
        <td><?php echo $reg['contacto']?></td>
        <td><?php echo $reg['email']?></td>
        <td align="center"><input type="button" value="Orden de Servicio" onclick="window.location = 'ordenServicio.php?ID=<?php echo $reg['id']?>';" /></td>
        <td align="center"><input type="button" value="Editar" onclick="window.location = 'clientes.php?mod=Editar&OT=3&ID=<?php echo $reg['id']?>';" /></td>
      </tr>
<?php
			}
?>
    </table>
<?php
	}
}
?>
</div>
<?php include ('footer.php'); ?>