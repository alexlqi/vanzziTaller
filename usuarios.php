<?php include ('header.php'); ?>
<?php
$arrPerfiles = array();
$r = mysql_query("SELECT id,nombre FROM config_usuarios_perfiles");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrPerfiles[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
	}
}
$arrSucursales = array();
$r = mysql_query("SELECT id,nombre FROM config_sucursales");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrSucursales[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
	}
}
?>
<div id="body">
<h1>Usuarios</h1>
<div id="divBotones"><input type="button" value="Lista de Usuarios" onclick="window.location = 'usuarios.php?mod=Lista&OT=9'" /></div>
<?php
if (!isset($_GET['mod']))
{
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Usuario&acc=Crear" onsubmit="return ValidaForm(this,'Usuario');" autocomplete="off">
  <h2>Datos Personales</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="Buscar Usuario..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Usuarios','divAutoBuscar');"><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
        <td width="50%"><label>Perfil</label>
          <select name="perfil" id="perfil">
          	<option value="" selected="selected">- Selecciona -</option>
<?php
	if (count($arrPerfiles) > 0)
	{
		foreach ($arrPerfiles as $k => $v)
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
        <td><label>Sucursal</label>
          <select name="sucursal" id="sucursal">
          	<option value="" selected="selected">- Selecciona -</option>
<?php
	if (count($arrSucursales) > 0)
	{
		foreach ($arrSucursales as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
		}
		
	}
?>
          </select></td>
        <td><label>Nombre de Usuario</label><input type="text" name="username" id="username"></td>
      </tr>
      <tr>
        <td><label>Contraseña</label><input type="password" name="password" id="password"></td>
        <td><label>Confirmar Contraseña</label><input type="password" name="Cpassword" id="Cpassword"></td>
      </tr>
      <tr>
        <td><label>Permitir modificar facturas</label>
        <select name="facturacion">
        	<option value="0" selected="selected">No</option>
            <option value="1">Si</option>
        </select></td>
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
</div>
<?php
}
elseif ($_GET['mod'] == 'Editar')
{
	$r = mysql_query("SELECT * FROM config_usuarios WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Usuario&acc=Editar" onsubmit="return ValidaForm(this,'Usuario');" autocomplete="off">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
  <h2>Datos Personales</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>"></td>
        <td width="50%"><label>Perfil</label>
          <select name="perfil" id="perfil">
<?php
	if (count($arrPerfiles) > 0)
	{
		foreach ($arrPerfiles as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"<?php if ($reg['perfilID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
		}
		
	}
?>
          </select></td>
      </tr>
      <tr>
        <td><label>Sucursal</label>
          <select name="sucursal" id="sucursal">
<?php
	if (count($arrSucursales) > 0)
	{
		foreach ($arrSucursales as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"<?php if ($reg['sucursalID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
		}
		
	}
?>
          </select></td>
        <td><label>Nombre de Usuario</label><input type="text" name="username" id="username" value="<?php echo $reg['username']?>"></td>
      </tr>
      <tr>
        <td><label>Contraseña</label><input type="password" name="password" id="password" value="**********" disabled="disabled"><small><input name="mPass" type="checkbox" id="mPass" value="1" onclick="if (this.checked) { document.getElementById('Cpassword').disabled=false; document.getElementById('password').disabled=false; document.getElementById('password').value=''; document.getElementById('password').focus(); } else { document.getElementById('Cpassword').disabled=true; document.getElementById('password').disabled=true; document.getElementById('password').value='**********'; }" /> Modificar</small></td>
        <td valign="top"><label>Confirmar Contraseña</label><input type="password" name="Cpassword" id="Cpassword" disabled="disabled"></td>
      </tr>
      <tr>
        <td><label>Permitir modificar facturas</label>
        <select name="facturacion">
        	<option value="0"<?php if ($reg['facturacion'] == 0) { echo ' selected="selected"'; }?>>No</option>
            <option value="1"<?php if ($reg['facturacion'] == 1) { echo ' selected="selected"'; }?>>Si</option>
        </select></td>
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
</div>
<?php
	}
}
elseif ($_GET['mod'] == 'Lista')
{
	$r = mysql_query("SELECT a.id AS id,a.nombre AS nombre,a.username AS username,a.activo AS activo,b.nombre AS perfil,c.nombre AS sucursal FROM config_usuarios a JOIN config_usuarios_perfiles b ON b.id = a.perfilID JOIN config_sucursales c ON c.id = a.sucursalID ORDER BY a.nombre ASC") or die (mysql_error());
	if (mysql_num_rows($r) > 0)
	{
?>
	<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="35%">Nombre</td>
        <td width="15%">Username</td>
        <td width="10%">Perfil</td>
        <td width="20%">Sucursal</td>
        <td width="10%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
      </tr>
<?php
			while ($reg = mysql_fetch_array($r))
			{
				$class = 'fila';
				if ($reg['activo'] == 0) { $class = 'filaSuspendida'; }
?>
      <tr class="<?php echo $class?>">
        <td><?php echo $reg['nombre']?></td>
        <td><?php echo $reg['username']?></td>
        <td><?php echo $reg['perfil']?></td>
        <td><?php echo $reg['sucursal']?></td>
        <td align="center"><input type="button" value="Editar" onclick="window.location = 'usuarios.php?OT=9&mod=Editar&ID=<?php echo $reg['id']?>';" /></td>
        <td align="center"><input type="button" value="<?php if ($reg['activo'] == 1) { echo 'Eliminar'; } else { echo 'Reactivar'; }?>" onclick="window.location = 'backend.php?mod=Usuario&acc=Suspender&ID=<?php echo $reg['id']?>';" /></td>
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