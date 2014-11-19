<?php include ('header.php'); ?>
<?php
$arrReportes = array(1 => 'Ventas por Vendedor', 2 => 'Existencias Totales', 3 => 'Movimientos de Articulo', 4 => 'Corte de Caja');
?>
<div id="body">
<h1>Reportes</h1>
<div id="forma">
	<h2><?php echo $arrReportes[$_GET['ID']]?></h2>
    <div id="divParametros">
    <form id="f_reporte" action="backend.php?mod=Reporte" method="post" target="_blank">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
<?php
switch ($_GET['ID'])
{
	case 1:
	{
		$arrVendedores = array();
		$r = mysql_query("SELECT id,nombre FROM config_usuarios WHERE activo = 1 ORDER BY nombre");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrVendedores[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
			}
		}
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Selecciona los Parametros del Reporte</label><input name="tipoReporte" type="radio" id="radio" value="1" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);" checked>
          Por Dia&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; 
            <input type="radio" name="tipoReporte" id="radio2" value="2" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Ultimos 7 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio3" value="3" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Ultimos 15 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio4" value="4" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Ultimos 30 Dias &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio5" value="5" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Por Rango de Fechas&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio6" value="6" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Por Producto</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td>
        <div id="parametros1" class="parametrosEnabled">
        <label>Fecha</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" />
        </div>
        <div id="parametros5" class="parametrosDisabled">
        <table width="60%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="50%"><label>Del</label>
              <input id="DPC_fecha1_YYYY-MM-DD" name="fecha1" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" disabled="disabled" /></td>
              <td width="50%"><label>Al</label>
              <input id="DPC_fecha2_YYYY-MM-DD" name="fecha2" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" disabled="disabled" /></td>
          </tr>
        </table>
        </div>
        <div id="parametros6" class="parametrosDisabled">
        <table width="60%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="50%"><label>UPC</label><input type="text" name="upc" id="upc" style="width:200px;" disabled="disabled"></td>
              <td width="50%"><label>Buscar UPC por Nombre de Producto</label><input type="text" name="producto" id="producto" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('producto','Productos');" disabled="disabled"><div id="divAutoBuscar"></div></td>
          </tr>
        </table>
        </div>
        <div id="parametros7" class="parametrosEnabled">
      	<label>Vendedor</label>
        <select name="vendedor" id="vendedor">
<?php
	if (count($arrVendedores) > 0)
	{
		foreach ($arrVendedores as $k => $v)
		{
?>
			<option value="<?php echo $v['id']?>"><?php echo $v['nombre']?></option>
<?php
		}
	}
?>
        </select>
        </div>
        </td>
      </tr>
      <tr>
        <td align="right"><input type="submit" value="Generar Reporte" /></td>
      </tr>
      </table>
<?php
		break;
	}
	case 2:
	{
		$arrProveedores = array();
		$r = mysql_query("SELECT id,nombreComercial FROM productos_proveedores WHERE activo = 1 ORDER BY nombreComercial");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrProveedores[] = array('id' => $reg['id'], 'nombre' => $reg['nombreComercial']);
			}
		}
		$arrCategorias = array();
		$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY nombre");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrCategorias[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
			}
		}
		$arrSucursales = array();
		$r = mysql_query("SELECT id,nombre FROM config_sucursales WHERE activo = 1 ORDER BY nombre");
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$arrSucursales[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
			}
		}
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Selecciona los Parametros del Reporte</label><input name="tipoReporte" type="radio" id="radio" value="1" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);" checked>
          Por Producto&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; 
            <input type="radio" name="tipoReporte" id="radio2" value="2" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Por Proveedor&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio3" value="3" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Por Categoria</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td>
        <div id="parametros1" class="parametrosEnabled">
      	<table width="60%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="50%"><label>UPC</label><input type="text" name="upc" id="upc" style="width:200px;"></td>
              <td width="50%"><label>Buscar UPC por Nombre de Producto</label><input type="text" name="producto" id="producto" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('producto','Productos');"><div id="divAutoBuscar"></div></td>
          </tr>
        </table>
        </div>
        <div id="parametros2" class="parametrosDisabled">
      	<label>Proveedor</label>
        <select name="proveedor" id="proveedor" disabled="disabled">
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
        </div>
        <div id="parametros3" class="parametrosDisabled">
      	<label>Categoria</label>
        <select name="categoria" id="categoria" disabled="disabled">
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
        </select>
        </div>
        <div id="parametros4" class="parametrosEnabled">
      	<label>Sucursal</label>
        <select name="sucursal" id="sucursal">
        	<option value="0" selected="selected">Todas</option>
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
        </select>
        </div>
        </td>
      </tr>
      <tr>
        <td align="right"><input type="submit" value="Generar Reporte" /></td>
      </tr>
      </table>
<?php
		break;
	}
	case 3:
	{
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Selecciona los Parametros del Reporte</label><input name="tipoReporte" type="radio" id="radio" value="1" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);" checked>
          Por Dia&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; 
            <input type="radio" name="tipoReporte" id="radio2" value="2" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Ultimos 7 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio3" value="3" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Ultimos 15 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio4" value="4" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Ultimos 30 Dias &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio5" value="5" onclick="getParametros('<?php echo $_GET['ID']?>',this.value);">
Por Rango de Fechas</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td>
        <div id="parametros1" class="parametrosEnabled">
        <label>Fecha</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" />
        </div>
        <div id="parametros5" class="parametrosDisabled">
        <table width="60%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="50%"><label>Del</label>
              <input id="DPC_fecha1_YYYY-MM-DD" name="fecha1" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" disabled="disabled" /></td>
              <td width="50%"><label>Al</label>
              <input id="DPC_fecha2_YYYY-MM-DD" name="fecha2" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" disabled="disabled" /></td>
          </tr>
        </table>
        </div>
        <div class="parametrosEnabled">
        <table width="60%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="50%"><label>UPC</label><input type="text" name="upc" id="upc" style="width:200px;"></td>
              <td width="50%"><label>Buscar UPC por Nombre de Producto</label><input type="text" name="producto" id="producto" value="Buscar Producto..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('producto','Productos','divAutoBuscar');"><div id="divAutoBuscar"></div></td>
          </tr>
        </table>
        </div>
        </td>
      </tr>
      <tr>
        <td align="right"><input type="submit" value="Generar Reporte" /></td>
      </tr>
      </table>
<?php
		break;
	}
	case 4:
?>
<script>
$(document).ready(function(e) {
    $("#go").click(function(e) {
		$("#f_reporte").attr("action","reporte_os.php");
		$("#f_reporte").submit();
    });
	$(".fecha").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
	});
});
</script>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Selecciona los Parametros del Reporte</label></td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td>
        	<label>De:</label><input class="fecha" type="tex" name="desde" />
            <label>Hasta:</label><input class="fecha" type="tex" name="hasta" />
        </td>
      </tr>
      <tr>
      	<td align="right"><input id="go" type="button" value="Generar Reporte" /></td>
      </tr>
      </table>
<?php
		break;
}
?>
      </form>
    </div>
</div>
</div>
<?php include ('footer.php'); ?>