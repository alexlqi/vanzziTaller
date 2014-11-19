<?php include ('header.php'); ?>
<?php
$arrProveedores = array();
$r = mysql_query("SELECT id,nombreComercial FROM productos_proveedores");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrProveedores[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombreComercial']));
	}
}
$arrCategorias = array();
$r = mysql_query("SELECT id,nombre FROM productos_categorias");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrCategorias[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
	}
}
$arrUnidades = array();
$r = mysql_query("SELECT id,nombre FROM productos_unidades");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrUnidades[] = array('id' => $reg['id'], 'nombre' => utf8_encode($reg['nombre']));
	}
}
?>
<div id="body">
<h1>Productos</h1>
<?php
if (!isset($_GET['ID']))
{
?>
<div class="btnDescarga" style="width:125px;" onclick="window.location = 'getListado.php?mod=Productos';">Listado de Productos</div>
<div id="forma">
  <h2>Datos del Producto</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" valign="top">
        <form id="form1" name="form1" method="post" action="backend.php?mod=Producto&acc=Crear" onsubmit="return ValidaForm(this,'Producto');">
        <label>UPC</label>
          <input type="text" name="upc" id="upc" style="width:250px;" />
          <input type="submit" value="Buscar">
        </form>
        </td>
        <td width="50%">
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
              <input type="button" value="Crear" onclick="ajaxGetCategorias('Productos');" /></td>
          </tr>
      </table>
      </div>
      </td>
      </tr>
      <tr>
        <td><label>Proveedor</label>
          <select name="proveedor" id="proveedor">
            <option value="" selected="selected"> - Selecciona -</option>
            <?php
	if (count($arrProveedores) > 0)
	{
		foreach ($arrProveedores as $k => $v)
		{
?>
            <option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
            <?php
		}
	}
?>
          </select>
<div id="divAutoBuscar"></div></td>
        <td><label>Clave</label>
          <input type="text" name="clave" id="clave" /></td>
      </tr>
      <tr>
        <td><label>Nombre</label>
          <input type="text" name="nombre" id="nombre" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Productos','divAutoBuscar');"><div id="divAutoBuscar"></div></td>
        <td><label>Descripcion</label>
          <input type="text" name="descripcion" id="descripcion"></td>
      </tr>
      <tr>
        <td><label>Costo</label>
          <input type="text" name="costo" id="costo" /></td>
        <td><label>Precio Menudeo</label>
          <input type="text" name="precio1" id="precio1" /></td>
      </tr>
      <tr>
        <td><label>Precio Mayoreo</label>
          <input type="text" name="precio2" id="precio2" /></td>
        <td><label>Precio Especial</label>
          <input type="text" name="precio3" id="precio3" /></td>
      </tr>
      <tr>
        <td><label>Precio 4</label>
          <input type="text" name="precio4" id="precio4" /></td>
        <td><label>Precio 5</label>
          <input type="text" name="precio5" id="precio5" /></td>
      </tr>
      <tr>
        <td><div id="divUEntrada">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" valign="top"><label>Unidad de Entrada</label>
                <select name="uEntrada" id="uEntrada">
                  <option value="" selected="selected">- Selecciona -</option>
                  <?php
	if (count($arrUnidades) > 0)
	{
		foreach ($arrUnidades as $k => $v)
		{
?>
                  <option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
                  <?php
		}
	}
?>
                </select></td>
              <td width="50%"><label>Crear Nueva</label>
                <input type="text" name="nUEntrada" id="nUEntrada" />
                <input type="button" value="Crear" onclick="ajaxGetUnidades('nUEntrada','divUEntrada');" /></td>
            </tr>
          </table>
        </div></td>
        <td><div id="divUSalida">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" valign="top"><label>Unidad de Salida</label>
                <select name="uSalida" id="uSalida">
                  <option value="" selected="selected">- Selecciona -</option>
                  <?php
	if (count($arrUnidades) > 0)
	{
		foreach ($arrUnidades as $k => $v)
		{
?>
                  <option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
                  <?php
		}
	}
?>
                </select></td>
              <td width="50%"><label>Crear Nueva</label>
                <input type="text" name="nUSalida" id="nUSalida" />
                <input type="button" value="Crear" onclick="ajaxGetUnidades('nUSalida','divUSalida');" /></td>
            </tr>
          </table>
        </div></td>
      </tr>
      <tr>
        <td><label>Factor de Conversion (Unidades de Salida por Unidad de Entrada)</label>
          <input type="text" name="conversion" id="conversion" value="1" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
</div>
<?php
}
elseif (isset($_GET['ID']) and !isset($_GET['mod']))
{
	$r = mysql_query("SELECT * FROM productos WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<div id="forma">
	<form id="form1" name="form1" method="post" action="backend.php?mod=Producto&acc=Editar" onsubmit="return ValidaForm(this,'Producto');">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
  <h2>Datos del Producto</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" valign="top"><label>UPC</label>
          <input type="text" name="upc" id="upc" value="<?php echo $reg['upc']?>" /></td>
        <td width="50%">
        <div id="divCategorias">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" valign="top"><label>Categoria</label>
              <select name="categoria" id="categoria">
                <?php
		if (count($arrCategorias) > 0)
		{
			foreach ($arrCategorias as $k => $v)
			{
?>
                <option value="<?php echo $v['id']?>"<?php if ($reg['proveedorID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
                <?php
			}
		}
?>
              </select></td>
            <td width="50%"><label>Crear Nueva</label>
              <input type="text" name="nCategoria" id="nCategoria" style="width:70%;" />
              <input type="button" value="Crear" onclick="ajaxGetCategorias('Productos');" /></td>
          </tr>
      </table>
      </div>
      </td>
      </tr>
      <tr>
        <td><label>Proveedor</label>
        <select name="proveedor" id="proveedor">
<?php
		if (count($arrProveedores) > 0)
		{
			foreach ($arrProveedores as $k => $v)
			{
?>
             <option value="<?php echo $v['id']?>"<?php if ($reg['proveedorID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
			}
		}
?>
        </select></td>
        <td><label>Clave</label>
          <input type="text" name="clave" id="clave" value="<?php echo $reg['clave']?>" /></td>
      </tr>
      <tr>
        <td><label>Nombre</label>
          <input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
        <td><label>Descripcion</label>
          <input type="text" name="descripcion" id="descripcion" value="<?php echo $reg['descripcion']?>"></td>
      </tr>
      <tr>
        <td><label>Costo</label>
          <input type="text" name="costo" id="costo" value="<?php echo $reg['costoActual']?>" /></td>
        <td><label>Precio Menudeo</label>
          <input type="text" name="precio1" id="precio1" value="<?php echo $reg['precio1']?>" /></td>
      </tr>
      <tr>
        <td><label>Precio Mayoreo</label>
          <input type="text" name="precio2" id="precio2" value="<?php echo $reg['precio2']?>" /></td>
        <td><label>Precio Especial</label>
          <input type="text" name="precio3" id="precio3" value="<?php echo $reg['precio3']?>" /></td>
      </tr>
      <tr>
        <td><label>Precio 4</label>
          <input type="text" name="precio4" id="precio4" value="<?php echo $reg['precio4']?>" /></td>
        <td><label>Precio 5</label>
          <input type="text" name="precio5" id="precio5" value="<?php echo $reg['precio5']?>" /></td>
      </tr>
      <tr>
        <td><div id="divUEntrada">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" valign="top"><label>Unidad de Entrada</label>
                <select name="uEntrada" id="uEntrada">
                  <?php
		if (count($arrUnidades) > 0)
		{
			foreach ($arrUnidades as $k => $v)
			{
?>
                  <option value="<?php echo $v['id']?>"<?php if ($reg['unidadEntradaID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
                  <?php
			}
		}
?>
                </select></td>
              <td width="50%"><label>Crear Nueva</label>
                <input type="text" name="nUEntrada" id="nUEntrada" />
                <input type="button" value="Crear" onclick="ajaxGetUnidades('nUEntrada','divUEntrada');" /></td>
            </tr>
          </table>
        </div></td>
        <td><div id="divUSalida">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" valign="top"><label>Unidad de Salida</label>
                <select name="uSalida" id="uSalida">
                  <?php
		if (count($arrUnidades) > 0)
		{
			foreach ($arrUnidades as $k => $v)
			{
?>
                  <option value="<?php echo $v['id']?>"<?php if ($reg['unidadSalidaID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
                  <?php
			}
		}
?>
                </select></td>
              <td width="50%"><label>Crear Nueva</label>
                <input type="text" name="nUSalida" id="nUSalida" />
                <input type="button" value="Crear" onclick="ajaxGetUnidades('nUSalida','divUSalida');" /></td>
            </tr>
          </table>
        </div></td>
      </tr>
      <tr>
        <td><label>Factor de Conversion (Unidades de Salida por Unidad de Entrada)</label>
          <input type="text" name="conversion" id="conversion" value="<?php echo $reg['factorConversion']?>" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />
          <input type="button" value="Cancelar Edicion" onclick="window.location = 'productos.php?OT=4'" /></td>
      </tr>
  </table>
  </form>
</div>
<?php
	}
	else
	{
		echo '<div class="BoxError>El producto que intentas editar no existe</div>';
	}
}
else
{
	$r = mysql_query("SELECT upc, clave, nombre FROM productos WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<div id="forma">
	<form action="backend.php?mod=ImagenProducto&acc=Crear" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return ValidaForm(this,'ImagenProducto');">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
  <h2>Agregar Imagen al Producto: <?php echo $reg['clave'].' - '.$reg['nombre']?></h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td valign="top"><label>Formatos Permitidos JPG, GIF o PNG</label>
          <input type="file" name="archivo" id="archivo" /></td>
        </tr>
      </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Imagen" />
          <input type="button" value="Salir" onclick="window.location = 'productos.php?OT=4'" /></td>
      </tr>
  </table>
  </form>
</div>
<div class="subiendoMsg"><img src="imagenes/loader.png" width="60" height="60" /><br />Subiendo Archivo...<br />Esta operacion puede tardar unos minutos, dependiendo del tamaño del archivo.</div>
<?php
		$r1 = mysql_query("SELECT id,archivo FROM productos_imagenes WHERE productoID = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
	<div class="divImagen"><img src="imagenes/productos/<?php echo $reg1['archivo']?>" width="150" /><br /><input type="button" value="Eliminar" /></div>
<?php
			}
		}
		else
		{
			echo '<div class="alertaMsg">No se han agregado imagenes a este producto</div>';
		}
	}
	else
	{
		echo '<div class="BoxError>El producto que intentas editar no existe</div>';
	}
}
?>
</div>
<?php include ('footer.php'); ?>