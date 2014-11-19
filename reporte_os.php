<?php session_start();
include("datos.php");
header('Content-Type: text/html; charset=utf-8');

$desde=$_POST["desde"];
$hasta=$_POST["hasta"];

try{
	$bd=new PDO($dsnw,$userw,$passw,$optPDO);
	$sql="SELECT 
		t2.id as factura,
		t1.fecha,
		t3.nombre,
		t1.id as os,
		t4.placa,
		t2.subtotal,
		t2.iva,
		t2.subtotal + t2.iva as total,
		(SELECT nombre FROM facturas_metodos_pago ta WHERE ta.id=t2.metodoPagoID) as formapago,
		0 as costo
	FROM servicios t1
	LEFT JOIN facturas t2 ON t1.facturaID=t2.id
	LEFT JOIN clientes t3 ON t2.clienteID=t3.id
	LEFT JOIN clientes_vehiculos t4 ON t1.vehiculoID=t4.id
	WHERE t1.fecha BETWEEN '$desde' AND '$hasta';";
	$res=$bd->query($sql);
?>
<style>
td{
	background-color:#FFF;
}
</style>
<table cellspacing="0" style="width:100%;">
	<tr>
    	<td style="width:20%;"><img src="imagenes/lasilla.jpg" style="width:100%;"/></td>
    	<td style="font-size:12px;width:60%;" align="center">
        	<p><strong>LA SILLA SERVICIO AUTOMOTRIZ S.A. DE     C.V.   </strong></p>
            <p style="font-size:10px;margin:0;">
            	<p><strong>CONSECUTIVO DE FACTURAS CON IMPUESTOS | SUCURSAL MÉRIDA PENSIONES DEL : <?php echo date("d/m/Y",strtotime($desde)); ?> : <?php echo date("d/m/Y",strtotime($hasta)); ?></strong></p>
            </p></td>
        <td align="right" style="text-align:right;width:20%"><?php echo date("d-m-Y"); ?></td>
    </tr> 
</table>
<table style="margin-top:20px;width:100%;"> 
    <tr style="font-size:9px;"> 
    	<td style="width:6%;"><p><strong>FACTURA</strong></p></td>
    	<td align="center" style="width:15%;"><p><strong>FECHA</strong></p></td>
        <td style="width:12%;"><p><strong>CLIENTE</strong></p></td>
        <td style="width:6%;"><p><strong>OS</strong></p></td>
        <td style="width:6%;"><p><strong>PLACAS</strong></p></td>
        <td style="width:6%;"><p><strong>SUBTOTAL</strong></p></td>
        <td style="width:6%;"><p><strong>IVA</strong></p></td>
        <td style="width:6%;"><p><strong>COSTO</strong></p></td>
        <td style="width:6%;"><p><strong>TOTAL</strong></p></td>
        <td style="width:6%;"><p><strong>UTILIDAD</strong></p></td>
        <td style="width:6%;"><p><strong>%</strong></p></td>
        <td style="width:10%;"><p><strong>FORMA PAGO</strong></p></td>     
    </tr>
    <?php 
		//sumas de los totales
		$subtotal=0;
		$iva=0;
		$utilidad=0;
		$costo=0;
		$total=0;
		foreach($res->fetchAll(PDO::FETCH_ASSOC) as $d){ 
	?>
    <tr style="font-size:8px;"> 
        <td style=""><?php echo $d["factura"]; ?></td>
        <td align="center" style=""><?php echo $d["fecha"]; ?></td>
        <td style=""><?php echo $d["nombre"]; ?></td>
        <td style=""><?php echo $d["os"]; ?></td>
        <td style=""><?php echo $d["placa"]; ?></td>
        <td style="">$ <?php echo $d["subtotal"]; ?></td>
        <td style="">$ <?php echo $d["iva"]; ?></td>
        <td style="">$ <?php echo $d["costo"]; ?></td>
        <td style="">$ <?php echo $d["total"]; ?></td>
        <td style="">$ <?php echo $uti=$d["total"]-$d["costo"]; ?></td>
        <td style=""><?php 
			if($d["total"]>0){
				echo $uti/$d["total"]*100; 
			}else{
				echo 100;
			}?></td>
        <td style=""><?php echo $d["formapago"]; ?></td>
    </tr>
    <?php 
			$subtotal+=$d["subtotal"];
			$iva+=$d["iva"];
			$utilidad+=$uti;
			$costo+=$d["costo"];
			$total+=$d["total"];
		} 
	?>
    <tr>
        <td></td>
        <td></td>
        <td colspan="3" align="right" style="font-size:10px;"><strong>TOTALES DEL REPORTE:</strong></td>
        <td style="font-size:10px;"><p><strong>$ <?php echo $subtotal; ?></strong></p></td>
        <td style="font-size:10px;"><p><strong>$ <?php echo $iva; ?></strong></p></td>
        <td style="font-size:10px;"><p><strong>$ <?php echo $costo; ?></strong></p></td>
        <td style="font-size:10px;"><p><strong>$ <?php echo $total; ?></strong></p></td>
        <td style="font-size:10px;"><p><strong>$ <?php echo $utilidad; ?></strong></p></td>
    </tr>
</table>
<script>
print();
close();
</script>
<?php
}catch(PDOException $err){
	echo "Error: ".$err->getMessage();
}
?>