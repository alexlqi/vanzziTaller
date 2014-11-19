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
?>
<div id="body">
<h1>Proveedores</h1>
<div id="forma">
<?php
if (!isset($_GET['ID']))
{
?>
	<form id="form1" name="form1" method="post" action="backend.php?mod=Proveedor&acc=Crear" onsubmit="return ValidaForm(this,'Proveedor');" autocomplete="off">
    <h2>Datos de la Empresa</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Nombre Comercial</label>
        <input type="text" name="nombreComercial" id="nombreComercial" value="Buscar Proveedor..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombreComercial','Proveedores','divAutoBuscar');" /><div id="divAutoBuscar"></div></td>
        <td><label>Razon Social</label>
        <input type="text" name="razonSocial" id="razonSocial" /></td>
      </tr>
      <tr>
        <td width="50%"><label>R.F.C.</label>
        <input type="text" name="rfc" id="rfc" /></td>
        <td width="50%"><label>Domicilio</label>
        <input type="text" name="domicilioFiscal" id="domicilioFiscal" /></td>
      </tr>
      <tr>
        <td width="50%"><label>Colonia</label>
        <input type="text" name="coloniaFiscal" id="coloniaFiscal" /></td>
        <td width="50%"><label>Codigo Postal</label>
        <input type="text" name="cpFiscal" id="cpFiscal" /></td>
      </tr>
      <tr>
        <td><label>Pais</label>
          <select name="paisFiscal" id="paisFiscal" onchange="ajaxGetSelectValues(this.value,'divEstadoFiscal')">
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
        <td><div id="divEstadoFiscal">
          <label>Estado</label>
          <select name="estadoFiscal" id="estadoFiscal" onchange="ajaxGetSelectValues(this.value,'divCiudadFiscal')">
            <option value="" selected="selected">- Selecciona -</option>
          </select>
        </div></td>
      </tr>
      <tr>
        <td><div id="divCiudadFiscal">
          <label>Ciudad</label>
          <select name="ciudadFiscal" id="ciudadFiscal">
            <option value="">- Selecciona -</option>
          </select>
        </div></td>
        <td>&nbsp;</td>
      </tr>
  </table>
  <h2>Datos del Contacto</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre(s)</label><input type="text" name="nombre" id="nombre"></td>
        <td width="50%"><label>Apellidos</label><input type="text" name="apellidos" id="apellidos"></td>
      </tr>
      <tr>
        <td><label>Lista de Telefonos</label><textarea name="listaTelefonos" rows="3" id="listaTelefonos"></textarea></td>
        <td><label>Observaciones</label><textarea name="observaciones" rows="3" id="observaciones"></textarea></td>
      </tr>
      <tr>
        <td><label>Correo Electronico</label><input type="text" name="email" id="email"></td>
        <td>&nbsp;</td>
      </tr>
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
else
{
	$r = mysql_query("SELECT * FROM productos_proveedores WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		$arrEstados = array();
		$r1 = mysql_query("SELECT id,nombre FROM config_estados WHERE paisID = ".$reg['paisID']);
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$arrEstados[] = array('id' => $reg1['id'], 'nombre' => utf8_encode($reg1['nombre']));
			}
		}
		$arrCiudades = array();
		$r1 = mysql_query("SELECT id,nombre FROM config_ciudades WHERE estadoID = ".$reg['estadoID']);
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$arrCiudades[] = array('id' => $reg1['id'], 'nombre' => utf8_encode($reg1['nombre']));
			}
		}
?>
	<form id="form1" name="form1" method="post" action="backend.php?mod=Proveedor&acc=Editar" onsubmit="return ValidaForm(this,'Proveedor');" autocomplete="off">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
    <h2>Datos de la Empresa</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Nombre Comercial</label>
        <input type="text" name="nombreComercial" id="nombreComercial" value="<?php echo $reg['nombreComercial']?>" /></td>
        <td><label>Razon Social</label>
        <input type="text" name="razonSocial" id="razonSocial" value="<?php echo $reg['razonSocial']?>" /></td>
      </tr>
      <tr>
        <td width="50%"><label>R.F.C.</label>
        <input type="text" name="rfc" id="rfc" value="<?php echo $reg['rfc']?>" /></td>
        <td width="50%"><label>Domicilio</label>
        <input type="text" name="domicilioFiscal" id="domicilioFiscal" value="<?php echo $reg['direccion']?>" /></td>
      </tr>
      <tr>
        <td width="50%"><label>Colonia</label>
        <input type="text" name="coloniaFiscal" id="coloniaFiscal" value="<?php echo $reg['colonia']?>" /></td>
        <td width="50%"><label>Codigo Postal</label>
        <input type="text" name="cpFiscal" id="cpFiscal" value="<?php echo $reg['cp']?>" /></td>
      </tr>
      <tr>
        <td><label>Pais</label>
          <select name="paisFiscal" id="paisFiscal" onchange="ajaxGetSelectValues(this.value,'divEstadoFiscal')">
            <?php
	if (count($arrPaises) > 0)
	{
		foreach ($arrPaises as $k => $v)
		{
?>
            <option value="<?php echo $v['id']?>"<?php if ($reg['paisID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
            <?php
		}
	}
?>
        </select></td>
        <td><div id="divEstadoFiscal">
          <label>Estado</label>
          <select name="estadoFiscal" id="estadoFiscal" onchange="ajaxGetSelectValues(this.value,'divCiudadFiscal')">
            <?php
	if (count($arrEstados) > 0)
	{
		foreach ($arrEstados as $k => $v)
		{
?>
            <option value="<?php echo $v['id']?>"<?php if ($reg['estadoID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
            <?php
		}
	}
?>
          </select>
        </div></td>
      </tr>
      <tr>
        <td><div id="divCiudadFiscal">
          <label>Ciudad</label>
          <select name="ciudadFiscal" id="ciudadFiscal">
            <?php
	if (count($arrCiudades) > 0)
	{
		foreach ($arrCiudades as $k => $v)
		{
?>
            <option value="<?php echo $v['id']?>"<?php if ($reg['ciudadID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
            <?php
		}
	}
?>
          </select>
        </div></td>
        <td>&nbsp;</td>
      </tr>
  </table>
  <h2>Datos del Contacto</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre(s)</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombreComercial']?>"></td>
        <td width="50%"><label>Apellidos</label><input type="text" name="apellidos" id="apellidos" value="<?php echo $reg['nombreComercial']?>"></td>
      </tr>
      <tr>
        <td><label>Lista de Telefonos</label><textarea name="listaTelefonos" rows="3" id="listaTelefonos"><?php echo $reg['nombreComercial']?></textarea></td>
        <td><label>Observaciones</label><textarea name="observaciones" rows="3" id="observaciones"><?php echo $reg['nombreComercial']?></textarea></td>
      </tr>
      <tr>
        <td><label>Correo Electronico</label><input type="text" name="email" id="email" value="<?php echo $reg['nombreComercial']?>"></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Edicion" onclick="window.location = 'proveedores.php?OT=4';" /></td>
      </tr>
  </table>
  </form>
<?php
	}
}
?>
</div>
</div>
<?php include ('footer.php'); ?>