<?php include ('header.php'); ?>
<div id="body">
<h1>Facturacion</h1>
<div id="forma">
<?php
if (!isset($_GET['mod']))
{
	$r = mysql_query("SELECT folioInicial,folioFinal,cbb FROM facturas_folios WHERE vigente = 1");
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		if (file_exists('imagenes/codigos/'.$reg['cbb']))
		{
			$folio = $reg['folioInicial'];
			$r1 = mysql_query("SELECT MAX(id) AS folio FROM facturas");
			if (mysql_num_rows($r1) > 0)
			{
				$reg1 = mysql_fetch_array($r1);
				$folio = $reg1['folio'] + 1;
			}
			if ($folio <= $reg['folioFinal'])
			{
				$arrMetodosPago = array();
				$r1 = mysql_query("SELECT id,nombre FROM facturas_metodos_pago");
				if (mysql_num_rows($r1) > 0)
				{
					while ($reg1 = mysql_fetch_array($r1))
					{
						$arrMetodosPago[] = array('id' => $reg1['id'], 'nombre' => $reg1['nombre']);
					}
				}
?>
<form id="form1" name="form1" method="post" action="backend.php?mod=Factura&acc=Crear" onsubmit="return ValidaForm(this,'Factura');" autocomplete="off" target="_blank">
<h2>Datos de la Factura</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
   	<tr>
       	<td colspan="3"><?php echo '<div class="divFolioFactura">Folio <span>'.sprintf('%05d',$folio).'</span></div>'?></td>
    </tr>
    <tr>
      	<td colspan="3"><input name="facturaDia" type="checkbox" id="facturaDia" value="1" onclick="if (this.checked) { setDatosFactura('VentaDia'); } else { setDatosFactura('VentaCliente'); }">Facturar Ventas del Dia</td>
    </tr>
    <tr>
    	<td colspan="3"><div id="divClienteVenta"><input type="hidden" name="clienteID" id="clienteID" value="0" /><label>Nombre</label><input type="text" name="nombre" id="nombre" value="Buscar Cliente..." style="color:#9b9999;" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Facturacion','divAutoBuscar');"><div id="divAutoBuscar" class="divAutoBuscar"></div></div></td>
        
    </tr>
    <tr>
    	<td width="33%"><label>Fecha</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php echo date("Y-m-d")?>" readonly /></td>
        <td width="34%"><label>Metodo de Pago</label><select name="metodoPago" id="metodoPago" onchange="if (this.value >= 3) { document.getElementById('cuenta').disabled = false; document.getElementById('cuenta').focus(); alert('Recuerda que es necesario proporcionar los ultimos 4 digitos de la cuenta'); } else { document.getElementById('cuenta').disabled = true; document.getElementById('cuenta').value = ''; }">
<?php
				if (count($arrMetodosPago) > 0)
				{
					foreach ($arrMetodosPago as $k => $v)
					{
?>
				<option value="<?php echo $v['id']?>"<?php if (isset($_SESSION['facturaMETODO']) and $_SESSION['facturaMETODO'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
					}
				}
?>
        </select></td>
       	<td width="33%"><label>Ultimos 4 digitos de la Cuenta</label><input name="cuenta" type="text" id="cuenta" disabled="disabled" /></td>
    </tr>
</table>
<div id="divDatosCliente"></div>
</form>
<?php
			}
			else
			{
				echo '<div class="alertaMsg">Ya no tienes mas folios disponibles para facturar</div>';
			}
		}
		else
		{
			echo '<div class="alertaMsg">No existe la imagen del codigo de barras bidimensional</div>';
		}
	}
	else
	{
		echo '<div class="alertaMsg">No hay folios vigentes para facturar</div>';
	}
}
elseif ($_GET['mod'] == 'Folios')
{
	$r = mysql_query("SELECT * FROM facturas_folios WHERE vigente = 1");
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
	}
?>
<h2>Administrar Folios y Codigo de Barras Bidimensional</h2>
<form action="backend.php?mod=Factura&acc=Folios" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return ValidaForm(this,'DatosFactura');" autocomplete="off">
          <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="forma">
            <tr class="warning">
              <td colspan="4"><input name="nuevosFolios" type="checkbox" id="nuevosFolios" value="1"<?php if (mysql_num_rows($r) <= 0) { echo ' checked="checked" disabled="disabled"';}?> />
MARCA ESTA CASILLA SI ESTAS INGRESANDO  FOLIOS NUEVOS</td>
            </tr>
            <tr>
              <td width="25%"><label>Fecha de Aprobaci&oacute;n de Folios</label><input id="DPC_fecha_YYYY-MM-DD" name="fecha" type="text" value="<?php if (isset($reg['fechaAprobacion'])) { echo $reg['fechaAprobacion']; } else { echo date('Y-m-d'); }?>" readonly /></td>
              <td width="25%"><label>Primer Folio a Utilizar</label><input name="folioInicial" type="text" id="folioInicial" size="40" value="<?php echo $reg['folioInicial']?>" /></td>
              <td width="25%"><label>Ultimo Folio Aprobado</label><input name="folioFinal" type="text" id="folioFinal" size="40" value="<?php echo $reg['folioFinal']?>" /></td>
              <td width="25%"><label>N&uacute;mero de Afiliaci&oacute;n SICOFI</label><input name="numeroSicofi" type="text" id="numeroSicofi" size="40" value="<?php echo $reg['noSicofi']?>" /></td>
            </tr>
            <tr>
              <td colspan="2"><label>C&oacute;digo de Barras Bidimensional <small>(JPG o GIF)</small></label><input name="codigo" type="file" id="codigo" size="40" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" align="center"><input type="submit" value="Guardar" /></td>
            </tr>
      </table>
  </form>
<?php
}
?>
</div>
</div>
<?php include ('footer.php'); ?>