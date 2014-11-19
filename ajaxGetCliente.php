<?php
session_start();
require_once ('include/config.php');
require_once ('include/libreria.php');

$r = mysql_query("SELECT id,nombre,email,listaTelefonos FROM clientes WHERE id = ".Limpia($_GET['ID']));
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$listaTelefonos = '';
	$r1 = mysql_query("SELECT a.razonSocial AS razonSocial, a.rfc AS rfc, a.direccion AS direccion, a.cp AS cp, b.nombre AS ciudad, c.nombre AS estado FROM clientes_datos_fiscales a JOIN config_ciudades b ON b.id = a.ciudadID JOIN config_estados c ON c.id = a.estadoID WHERE a.clienteID = ".$reg['id']);
	if (mysql_num_rows($r1) > 0)
	{
		while ($reg1 = mysql_fetch_array($r1))
		{
			$listaTelefonos .= utf8_encode($reg1['razonSocial']."\n".$reg1['rfc']."\n".$reg1['direccion']."\n".$reg1['cp'].', '.$reg1['ciudad'].', '.$reg1['estado']);
		}
	}
}
if ($_GET['mod'] == 'Venta')
{
?>
	<input type="hidden" name="clienteID" id="clienteID" value="<?php echo $reg['id']?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td><input name="mostrador" type="checkbox" id="mostrador" value="1" onclick="if (!this.checked) { document.getElementById('nombre').value = 'Buscar Cliente...'; document.getElementById('nombre').disabled = false; document.getElementById('listaTelefonos').value = ''; document.getElementById('email').value = ''; } else { document.getElementById('nombre').value = 'VENTA DE MOSTRADOR'; document.getElementById('nombre').disabled = true; document.getElementById('listaTelefonos').value = 'VENTA DE MOSTRADOR'; document.getElementById('email').value = 'VENTA DE MOSTRADOR'; }">
              Venta de Mostrador</td>
            <td width="50%" rowspan="3" valign="top"><label>Datos Fiscales</label>
            <textarea name="listaTelefonos" rows="4" id="listaTelefonos" readonly="readonly"><?php echo $listaTelefonos?></textarea></td>
          </tr>
          <tr>
        <td width="50%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" onfocus="this.value = ''; this.style.color = '#000000';" onkeyup="ajaxGetAutoBuscar('nombre','Ventas','divAutoBuscar');"><div id="divAutoBuscar"></div></td>
        </tr>
      <tr>
        <td><label>Correo Electronico</label>
          <input type="text" name="email" id="email" disabled="disabled" value="<?php echo $reg['email']?>"></td>
      </tr>
      </table>
<?php
}
else
{
?>
	<input type="hidden" name="clienteID" id="clienteID" value="<?php echo $reg['id']?>" /><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" onfocus="this.value = '';" onkeyup="ajaxGetAutoBuscar('nombre','Facturacion','divAutoBuscar');"><div id="divAutoBuscar" class="divAutoBuscar"></div>
<?php
}
?>