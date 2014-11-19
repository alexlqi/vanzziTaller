<?php include ('header.php'); ?>
<div id="body">
<?php
$arrRespuestas = array('No','Si');
switch ($_GET['mod'])
{
	case 'Sucursales':
	{
?>
<h1>Sucursales</h1>
<div id="divBotones"><input type="button" value="Lista de Sucursales" onclick="window.location = 'configuracion.php?mod=Sucursales&acc=Lista&OT=9'" /></div>
<?php
		if (!isset($_GET['acc']))
		{
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Sucursal&acc=Crear" onsubmit="return ValidaForm(this,'Sucursal');" autocomplete="off">
    <h2>Datos de la Sucursal</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label>
        <input type="text" name="nombre" id="nombre" value="Buscar Sucursal..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Sucursales','divAutoBuscar');" /><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
        <td width="50%"><label>¿Sucursal en Frontera?</label>
          <select name="frontera" id="frontera">
            <option value="0" selected>No</option>
            <option value="1">Si</option>
          </select></td>
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
		elseif ($_GET['acc'] == 'Editar')
		{
			$r = mysql_query("SELECT * FROM config_sucursales WHERE id = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Sucursal&acc=Editar" onsubmit="return ValidaForm(this,'Sucursal');">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
    <h2>Datos de la Sucursal</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
        <td><label>¿Sucursal en Frontera?</label>
          <select name="frontera" id="frontera">
            <option value="0"<?php if ($reg['frontera'] == 0) { echo ' selected="selected"'; }?>>No</option>
            <option value="1"<?php if ($reg['frontera'] == 1) { echo ' selected="selected"'; }?>>Si</option>
          </select></td>
      </tr>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Edicion" onclick="window.location = 'configuracion.php?mod=Sucursales&OT=9';" /></td>
      </tr>
  </table>
  </form>
</div>
<?php
			}
		}
		elseif ($_GET['acc'] == 'Lista')
		{
			$r = mysql_query("SELECT * FROM config_sucursales ORDER BY nombre ASC");
			if (mysql_num_rows($r) > 0)
			{
?>
	<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="55%">Nombre</td>
        <td width="15%">Frontera</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
      </tr>
<?php
				while ($reg = mysql_fetch_array($r))
				{
					$class = 'fila';
					if ($reg['activo'] == 0) { $class = 'filaSuspendida'; }
?>
      <tr class="<?php echo $class?>">
        <td><?php echo $reg['nombre']?></td>
        <td><?php echo $arrRespuestas[$reg['frontera']]?></td>
        <td align="center"><input type="button" value="Editar" onclick="window.location = 'configuracion.php?mod=Sucursales&acc=Editar&OT=9&ID=<?php echo $reg['id']?>';" /></td>
        <td align="center"><input type="button" value="<?php if ($reg['activo'] == 1) { echo 'Eliminar'; } else { echo 'Reactivar'; }?>" onclick="window.location = 'backend.php?mod=Sucursal&acc=Suspender&ID=<?php echo $reg['id']?>';" /></td>
      </tr>
<?php
				}
?>
    </table>
<?php
			}
		}
		break;
	}
	case 'Marcas':
	{
?>
<h1>Marcas</h1>
<div id="divBotones"><input type="button" value="Lista de Marcas" onclick="window.location = 'configuracion.php?mod=Marcas&acc=Lista&OT=9'" /></div>
<?php
		if (!isset($_GET['acc']))
		{
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Marca&acc=Crear" onsubmit="return ValidaForm(this,'Marca');" autocomplete="off">
    <h2>Datos de la Marca</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label>
          <input type="text" name="nombre" id="nombre" value="Buscar Marca de Vehiculo..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Marcas','divAutoBuscar');" /><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
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
		elseif ($_GET['acc'] == 'Editar')
		{
			$r = mysql_query("SELECT * FROM config_vehiculos_marcas WHERE id = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Marca&acc=Editar" onsubmit="return ValidaForm(this,'Marca');">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
    <h2>Datos de la Marca</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Nombre</label>
          <input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
        </tr>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />&nbsp;&nbsp;&nbsp;<input type="button" value="Ver modelos de esta marca" onclick="window.location = 'configuracion.php?mod=Modelos&ID=<?php echo $_GET['ID']?>&OT=9';" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Edicion" onclick="window.location = 'configuracion.php?mod=Marcas&OT=9';" /></td>
      </tr>
  </table>
  </form>
</div>
<?php
			}
		}
		elseif ($_GET['acc'] == 'Lista')
		{
			$r = mysql_query("SELECT * FROM config_vehiculos_marcas ORDER BY nombre ASC");
			if (mysql_num_rows($r) > 0)
			{
?>
	<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="55%">Nombre</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
      </tr>
<?php
				while ($reg = mysql_fetch_array($r))
				{
					$class = 'fila';
					if ($reg['activo'] == 0) { $class = 'filaSuspendida'; }
?>
      <tr class="<?php echo $class?>">
        <td><?php echo $reg['nombre']?></td>
        <td align="center"><input type="button" value="Modelos" onclick="window.location = 'configuracion.php?mod=Modelos&OT=9&ID=<?php echo $reg['id']?>';" /></td>
        <td align="center"><input type="button" value="Editar" onclick="window.location = 'configuracion.php?mod=Marcas&acc=Editar&OT=9&ID=<?php echo $reg['id']?>';" /></td>
        <td align="center"><input type="button" value="<?php if ($reg['activo'] == 1) { echo 'Eliminar'; } else { echo 'Reactivar'; }?>" onclick="window.location = 'backend.php?mod=Marca&acc=Suspender&ID=<?php echo $reg['id']?>';" /></td>
      </tr>
<?php
				}
?>
    </table>
<?php
			}
		}
		break;
	}
	case 'Modelos':
	{
		$r = mysql_query("SELECT nombre FROM config_vehiculos_marcas WHERE id = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r) > 0)
		{
			$reg = mysql_fetch_array($r);
?>
<h1>Modelos registrados en <i><?php echo $reg['nombre']?></i></h1>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Modelo&acc=Crear" onsubmit="return ValidaForm(this,'Modelo');" autocomplete="off">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
    <h2>Datos del Modelo</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label>
          <input type="text" name="nombre" id="nombre" /></td>
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
			$r1 = mysql_query("SELECT id,nombre FROM config_vehiculos_modelos WHERE marcaID = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r1) > 0)
			{
?>
<table width="50%" border="0" align="center" cellspacing="1" cellpadding="3" class="tabla1">
      <tr class="encabezado">
        <td width="70%">Modelo</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
      </tr>
<?php
				while ($reg1 = mysql_fetch_array($r1))
				{
?>
      <tr class="fila">
        <td>
        <div id="Label<?php echo $reg1['id']?>"><?php echo $reg1['nombre']?></div>
        <div id="Edita<?php echo $reg1['id']?>" class="divEdicion">
	        <form method="post" action="backend.php?mod=Modelo&acc=Editar">
        	<input type="hidden" name="ID" id="ID" value="<?php echo $reg1['id']?>" />
            <input type="text" name="nombre" value="<?php echo $reg1['nombre']?>" />
            <input type="submit" value="Guardar" />
            <input type="button" value="Cancelar" onclick="document.getElementById('Label<?php echo $reg1['id']?>').style.display = 'block'; document.getElementById('Edita<?php echo $reg1['id']?>').style.display = 'none';" />
    	    </form>
        </div>
        </td>
        <td align="center"><input type="button" value="Editar" onclick="document.getElementById('Label<?php echo $reg1['id']?>').style.display = 'none'; document.getElementById('Edita<?php echo $reg1['id']?>').style.display = 'block';" /></td>
        <td align="center"><input type="button" value="Eliminar" onclick="" /></td>
      </tr>
<?php
				}
?>
</table>
<?php
			}
			else
			{
				echo '<div class="alertaMsg">No se encontraron registros</div>';
			}
		}
		else
		{
			echo '<div class="errorMsg">La marca que intentas administrar no existe</div>';
		}
		break;
	}
	case 'ManoObra':
	{
		$arrCategorias = array();
		$r = mysql_query("SELECT id,nombre FROM config_mano_obra_categorias");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrCategorias[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
			}
		}
?>
<h1>Catalogo de Mano de Obra</h1>
<div id="divBotones"><input type="button" value="Lista de Sucursales" onclick="window.location = 'configuracion.php?mod=Sucursales&acc=Lista&OT=9'" /></div>
<div id="forma">
<?php
		if (!isset($_GET['acc']))
		{
?>
	<form id="form1" name="form1" method="post" action="backend.php?mod=ManoObra&acc=Crear" onsubmit="return ValidaForm(this,'ManoObra');" autocomplete="off">
    <h2>Datos del Recurso</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="30%"><label>Nombre</label>
        <input type="text" name="nombre" id="nombre" value="Buscar Mano de Obra..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','ManoObra','divAutoBuscar');" /><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
        <td width="40%">
        <div id="divCategorias">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" valign="top"><label>Categoria</label>
              <select name="categoria" id="categoria">
                <option value="" selected="selected"> - Selecciona -</option>
                <?php
				if (count($arrCategorias) > 0)
				{
					foreach ($arrCategorias as $k => $v)
					{
?>
                <option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
                <?php
					}
				}
?>
              </select></td>
            <td width="50%"><label>Crear Nueva</label>
              <input type="text" name="nCategoria" id="nCategoria" style="width:70%;" />
              <input type="button" value="Crear" onclick="ajaxGetCategorias('ManoObra');" /></td>
          </tr>
      </table>
      </div>
        </td>
        <td width="15%"><label>Duración</label>
          <select name="duracion" id="duracion">
<?php
				for ($i = 30; $i <= 300; $i += 30)
				{
?>
            <option value="<?php echo $i?>"><?php echo ($i / 60).' Hora(s)'?></option>
<?php
				}
?>
          </select></td>
        <td width="15%"><label>Precio</label>
        $ <input type="text" name="precio" id="precio" style="width:80%" /></td>
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
		elseif ($_GET['acc'] == 'Editar')
		{
			$r = mysql_query("SELECT * FROM config_mano_obra WHERE id = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
?>
	<form id="form1" name="form1" method="post" action="backend.php?mod=ManoObra&acc=Editar" onsubmit="return ValidaForm(this,'ManoObra');">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
    <h2>Datos del Recurso</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="30%"><label>Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
        <td width="40%">
        <div id="divCategorias">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" valign="top"><label>Categoria</label>
              <select name="categoria" id="categoria">
                <option value="" selected="selected"> - Selecciona -</option>
                <?php
				if (count($arrCategorias) > 0)
				{
					foreach ($arrCategorias as $k => $v)
					{
?>
                <option value="<?php echo $v['id']?>"<?php if ($reg['categoriaID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
                <?php
					}
				}
?>
              </select></td>
            <td width="50%"><label>Crear Nueva</label>
              <input type="text" name="nCategoria" id="nCategoria" style="width:70%;" />
              <input type="button" value="Crear" onclick="ajaxGetCategorias('ManoObra');" /></td>
          </tr>
      </table>
      </div>
        </td>
        <td width="15%"><label>Duración</label>
          <select name="duracion" id="duracion">
<?php
				for ($i = 30; $i <= 300; $i += 30)
				{
?>
            <option value="<?php echo $i?>"<?php if ($reg['duracion'] == $i) { echo ' selected="selected"'; }?>><?php echo ($i / 60).' Hora(s)'?></option>
<?php
				}
?>
          </select></td>
        <td width="15%"><label>Precio</label>
        $ <input type="text" name="precio" id="precio" value="<?php echo $reg['costo']?>" style="width:80%" /></td>
      </tr>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Edicion" onclick="window.location = 'configuracion.php?mod=ManoObra&OT=9';" /></td>
      </tr>
  </table>
  </form>
<?php
			}
		}
		elseif ($_GET['acc'] == 'Lista')
		{
			$r = mysql_query("SELECT * FROM config_sucursales ORDER BY nombre ASC");
			if (mysql_num_rows($r) > 0)
			{
?>
	<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="55%">Nombre</td>
        <td width="15%">Frontera</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
      </tr>
<?php
				while ($reg = mysql_fetch_array($r))
				{
					$class = 'fila';
					if ($reg['activo'] == 0) { $class = 'filaSuspendida'; }
?>
      <tr class="<?php echo $class?>">
        <td><?php echo $reg['nombre']?></td>
        <td><?php echo $arrRespuestas[$reg['frontera']]?></td>
        <td align="center"><input type="button" value="Editar" onclick="window.location = 'configuracion.php?mod=Sucursales&acc=Editar&OT=9&ID=<?php echo $reg['id']?>';" /></td>
        <td align="center"><input type="button" value="<?php if ($reg['activo'] == 1) { echo 'Eliminar'; } else { echo 'Reactivar'; }?>" onclick="window.location = 'backend.php?mod=Sucursal&acc=Suspender&ID=<?php echo $reg['id']?>';" /></td>
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
<?php
		break;
	}
	case 'Paquetes':
	{
?>
<h1>Configuracion de Paquetes</h1>
<div id="divBotones"><input type="button" value="Lista de Sucursales" onclick="window.location = 'configuracion.php?mod=Sucursales&acc=Lista&OT=9'" /></div>
<div id="forma">
<?php
		$arrPartidas = array();
		$total = 0;
		if (!isset($_GET['acc']))
		{
?>
	<form id="form1" name="form1" method="post" action="backend.php?mod=Paquete&acc=Crear" onsubmit="return ValidaForm(this,'Paquete');" autocomplete="off">
    <h2>Datos del Paquete</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Nombre</label>
          <input type="text" name="nombre" id="nombre" value="Buscar Paquete..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Paquete','divAutoBuscar');" /><div id="divAutoBuscar" class="divAutoBuscar"></div></td>
        </tr>
    </table>
    <h2>Agregar Partidas</h2>
    <div id="ajaxDivPartidas">
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?php
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
				}
?>
          </td>
        </tr>
<?php
			}
			if (isset($_SESSION['ajaxCestaPartidas'])) { $arrPartidas = $_SESSION['ajaxCestaPartidas']; }
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
<?php
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			$r = mysql_query("SELECT * FROM config_mano_obra WHERE id = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
?>
	<form id="form1" name="form1" method="post" action="backend.php?mod=ManoObra&acc=Editar" onsubmit="return ValidaForm(this,'ManoObra');">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
    <h2>Datos del Recurso</h2>
   	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
        <td width="25%"><label>Duración</label>
          <select name="duracion" id="duracion">
<?php
			for ($i = 30; $i <= 300; $i += 30)
			{
?>
            <option value="<?php echo $i?>"<?php if ($reg['duracion'] == $i) { echo ' selected="selected"'; }?>><?php echo ($i / 60).' Hora(s)'?></option>
<?php
			}
?>
          </select></td>
        <td width="25%"><label>Precio</label>
        $ <input type="text" name="precio" id="precio" value="<?php echo $reg['costo']?>" style="width:80%" /></td>
      </tr>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar Edicion" onclick="window.location = 'configuracion.php?mod=ManoObra&OT=9';" /></td>
      </tr>
  </table>
  </form>
<?php
			}
		}
		elseif ($_GET['acc'] == 'Lista')
		{
			$r = mysql_query("SELECT * FROM config_sucursales ORDER BY nombre ASC");
			if (mysql_num_rows($r) > 0)
			{
?>
	<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabla1">
      <tr class="encabezado">
        <td width="55%">Nombre</td>
        <td width="15%">Frontera</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
      </tr>
<?php
				while ($reg = mysql_fetch_array($r))
				{
					$class = 'fila';
					if ($reg['activo'] == 0) { $class = 'filaSuspendida'; }
?>
      <tr class="<?php echo $class?>">
        <td><?php echo $reg['nombre']?></td>
        <td><?php echo $arrRespuestas[$reg['frontera']]?></td>
        <td align="center"><input type="button" value="Editar" onclick="window.location = 'configuracion.php?mod=Sucursales&acc=Editar&OT=9&ID=<?php echo $reg['id']?>';" /></td>
        <td align="center"><input type="button" value="<?php if ($reg['activo'] == 1) { echo 'Eliminar'; } else { echo 'Reactivar'; }?>" onclick="window.location = 'backend.php?mod=Sucursal&acc=Suspender&ID=<?php echo $reg['id']?>';" /></td>
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
<?php
		break;
	}
}
?>
</div>
<?php include ('footer.php'); ?>