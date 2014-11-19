<?php
session_start();
require_once('include/config.php');
require_once('include/libreria.php');

$arrReportes = array(1 => 'Ventas por Vendedor', 2 => 'Existencias Totales', 3 => 'Movimientos de Articulo');
?>
    <form action="backend.php?mod=Reporte" method="post" target="_blank">
    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
<?php
switch ($_GET['ID'])
{
	case 1:
	{
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Selecciona los Parametros del Reporte</label><input name="tipoReporte" type="radio" id="radio" value="1" onclick="ajaxGetParametros(this.value,'<?php echo $_GET['ID']?>');"<?php if ($_GET['tipo'] == 1) { echo ' checked'; }?>>
          Por Dia&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; 
            <input type="radio" name="tipoReporte" id="radio2" value="2" onclick="ajaxGetParametros(this.value,'<?php echo $_GET['ID']?>');"<?php if ($_GET['tipo'] == 2) { echo ' checked'; }?>>
Ultimos 7 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio3" value="3" onclick="ajaxGetParametros(this.value,'<?php echo $_GET['ID']?>');"<?php if ($_GET['tipo'] == 3) { echo ' checked'; }?>>
Ultimos 15 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio4" value="4" onclick="ajaxGetParametros(this.value,'<?php echo $_GET['ID']?>');"<?php if ($_GET['tipo'] == 4) { echo ' checked'; }?>>
Ultimos 30 Dias &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio5" value="5" onclick="ajaxGetParametros(this.value,'<?php echo $_GET['ID']?>');"<?php if ($_GET['tipo'] == 5) { echo ' checked'; }?>>
Por Rango de Fechas&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio6" value="6" onclick="ajaxGetParametros(this.value,'<?php echo $_GET['ID']?>');"<?php if ($_GET['tipo'] == 6) { echo ' checked'; }?>>
Por Articulo</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
<?php
		switch ($_GET['tipo'])
		{
			case 1:
			{
?>
      <tr>
        <td>
        <script>
$(function() {
	$( "#datepicker" ).datepicker();
	$( "#format" ).change(function() {
		$( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
	});
});
</script>
        <label>Fecha</label><input type="text" id="datepicker" size="30"/></td>
      </tr>
<?php
				break;
			}
			case 5:
			{
?>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="50%"><label>Del</label>
              <input id="DPC_fecha1_YYYY-MM-DD" name="fecha1" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" /></td>
              <td width="50%"><label>Al</label>
              <input id="DPC_fecha2_YYYY-MM-DD" name="fecha2" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" /></td>
          </tr>
        </table></td>
      </tr>
<?php
				break;
			}
			case 6:
			{
				$r = mysql_query("SELECT id,clave,nombre FROM ");
?>
      <tr>
        <td><label>Producto</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" /></td>
      </tr>
<?php
				break;
			}
		}
?>
      <tr>
        <td align="right"><input type="submit" value="Generar Reporte" /></td>
      </tr>
      </table>
<?php
		break;
	}
	case 2:
	{
?>
    <table width="98%" border="0" align="center" cellspacing="0" cellpadding="5">
      <tr>
        <td><label>Selecciona los Parametros del Reporte</label><input name="tipoReporte" type="radio" id="radio" value="1" checked>
          Por Producto</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td><label>Fecha</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" /></td>
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
        <td><label>Selecciona los Parametros del Reporte</label><input name="tipoReporte" type="radio" id="radio" value="1" checked>
          Por Dia&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; 
            <input type="radio" name="tipoReporte" id="radio2" value="2">
Ultimos 7 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio3" value="3">
Ultimos 15 Dias&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio4" value="4">
Ultimos 30 Dias &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio5" value="5">
Por Rango de Fechas&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="tipoReporte" id="radio6" value="6">
Por Articulo</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td><label>Fecha</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php echo date("Y-m-d")?>" style="width:200px;" /></td>
      </tr>
      <tr>
        <td align="right"><input type="submit" value="Generar Reporte" /></td>
      </tr>
      </table>
<?php
		break;
	}
}
?>
      </form>
<br />