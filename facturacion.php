<?php include ('header.php'); 
//funciones de texto
function wUtf8($d){echo utf8_encode($d);}
function utf8($d){return utf8_encode($d);}

//variables para uso
//var_dump($_SESSION);

$bool_servicio=false;
$array_folio=array();
$array_servicio=array();
$array_forma_pago=array();
$array_metodo_pago=array();
$array_cliente=array();
$suc=$_SESSION["usuarioSUCURSAL"];

//Folio siguiente
$r = mysql_query("SELECT serie, MAX(folio) as folio_siguiente FROM facturas WHERE serie IN (SELECT serie FROM facturas) GROUP BY serie;");
while($row=mysql_fetch_assoc($r)){
	$id=$row["serie"];
	unset($row["id"]);
	$array_folio[$id]=$row["folio_siguiente"];
}

//forma de pago
$r = mysql_query("SELECT * FROM facturas_forma_pago;");
while($row=mysql_fetch_assoc($r)){
	$id=$row["id"];
	unset($row["id"]);
	$array_forma_pago[$id]=$row;
}

//metodos de pago
$r = mysql_query("SELECT * FROM facturas_metodos_pago;");
while($row=mysql_fetch_assoc($r)){
	$id=$row["id"];
	unset($row["id"]);
	$array_metodo_pago[$id]=$row;
}

//ordenes de servicio
$r = mysql_query("SELECT id, fecha, precio, clienteID FROM servicios WHERE estatusID = 3;");
if (mysql_num_rows($r) > 0){
	$bool_servicio=true;
	while($row=mysql_fetch_assoc($r)){
		$id=$row["id"];
		unset($row["id"]);
		$array_servicio[$id]=$row;
	}
}

//array de clientes
$r = mysql_query("SELECT * FROM clientes;");
while($row=mysql_fetch_assoc($r)){
	$id=$row["id"];
	unset($row["id"]);
	$array_cliente[$id]=$row;
}
?>
</div><!--/cierra el menu/-->
	<div id="body">
		<h1>Facturacion</h1>
		<div id="forma">
<?php
if (!isset($_GET['mod'])) {
	$r = mysql_query("SELECT serie,folioInicial,folioFinal FROM facturas_folios WHERE vigente = 1 AND sucursal=$suc;");
	if (mysql_num_rows($r) > 0){
		$row=mysql_fetch_assoc($r);
		$serie=$row["serie"];
		if($bool_servicio){ ?>
        
<!-- / Inicia html de facturación / -->
<h2>Ordenes disponibles para facturar</h2>
<table class="tabla_alex" style="margin:10px auto;display:inline-block;">
  <tr>
    <th>Orden No</th>
    <th>fecha</th>
    <th>Total</th>
    <th>Cliente</th>
    <th>Acciones</th>
  </tr>
	<?php foreach($array_servicio as $i=>$d){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $d["fecha"]; ?></td>
    <td><?php echo $d["precio"]; ?></td>
    <td><?php echo $array_cliente[$d["clienteID"]]["nombre"]; ?></td>
    <td><?php echo '<input type="button" class="facturar" data-id="'.$i.'" onclick="mostrarFacturar(this);" value="Facturar" />'; ?></td>
  </tr>
	<?php } ?>
</table>
<div class="form_factura">
  <h2>Formulario para facturar</h2>
    <form id="formaFactura">
    	<input type="hidden" id="id" name="id" value="" />
        <table>
        <tr>
          <td style="width:10%;">
            <label>Serie:</label><input type="text" name="serie" value="<?php echo $serie; ?>" readonly style="width:30px;" />
          </td>
          <td style="width:10%;">
          	<label>Folio:</label><input type="text" name="folio" value="<?php echo $array_folio[$serie]; ?>" readonly style="width:30px;" />
          </td>
          <td style="width:25%;">
            <label>Forma de pago</label><select>
                <?php foreach($array_forma_pago as $d){
                    echo '<option value="'.$d["nombre"].'">'.utf8($d["nombre"]).'</option>';
                }?>
            </select>
          </td>
          <td style="width:25%;">
            <label>Método de pago</label><select>
                <?php foreach($array_metodo_pago as $d){
                    echo '<option value="'.$d["nombre"].'">'.$d["nombre"].'</option>';
                }?>
            </select>
          </td>
          <td>
          	<label>Cuenta:</label><input type="text" name="cuenta" />
          </td>
        </tr>
        <tr>
          <td colspan="10" align="center">
            <input type="button" value="Facturar" onclick="facturar(this);" />
          </td>
        </tr>
        </table>
    </form>
</div>

<!-- / Termina html de facturación / -->
<?php 	}else{
			echo "No hay servicios para facturar";
		}
	} else {
		echo '<div class="alertaMsg">No hay folios vigentes para facturar</div>';
	}
} elseif ($_GET['mod'] == 'Folios') {
	$r = mysql_query("SELECT * FROM facturas_folios WHERE vigente = 1;");
	if (mysql_num_rows($r) > 0){
		$i=0;
		while($reg = mysql_fetch_array($r)){
			$folios[$i]=$reg;
			$i++;
		}
	}
?>
<!-- / Inicia html de folios / -->
	<h2>Administrar Folios y Codigo de Barras Bidimensional</h2>
    <table class="tabla_alex" style="margin:10px auto;">
      <tr>
        <th>Serie</th>
        <th>Folio inicial</th>
        <th>Folio final</th>
        <th>Acciones</th>
      </tr>
    <?php foreach($folios as $d){ ?>
      <tr>
        <td><?php echo $d["serie"]; ?></td>
        <td><?php echo $d["folioInicial"]; ?></td>
        <td><?php echo $d["folioFinal"]; ?></td>
        <td>
        	<form method="post" action="cambiarFolio.php" style="display:inline-block;" target="new">
            	<input type="hidden" name="id" value="<?php echo $d["id"]; ?>" />
                <input type="hidden" name="a" value="modif" />
                <input type="submit" value="Modificar" />
            </form>
            <form method="post" action="cambiarFolio.php" style="display:inline-block;">
            	<input type="hidden" name="id" value="<?php echo $d["id"]; ?>" />
                <input type="hidden" name="a" value="del" />
                <input type="submit" value="Eliminar" />
            </form>
        </td>
      </tr>
    <?php } ?>
    </table>
	<form autocomplete="off">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="forma">
            <tr>
              <td width="25%"><label>Serie</label><input name="serie" type="text" id="serie" size="40" /></td>
              <td width="25%"><label>Primer Folio a Utilizar</label><input name="folioInicial" type="text" id="folioInicial" size="40" /></td>
              <td width="25%"><label>Ultimo Folio Aprobado</label><input name="folioFinal" type="text" id="folioFinal" size="40" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="10" align="center"><input type="submit" value="Guardar" /></td>
            </tr>
      </table>
  </form>
<!-- / Termina html de folios / -->
<?php
}
?>
		</div>
	</div>
<?php include ('footer.php'); ?>