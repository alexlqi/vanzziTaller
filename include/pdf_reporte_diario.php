<?php session_start();
setlocale(LC_ALL,"");
setlocale(LC_ALL,"es_MX");
require_once('clases/html2pdf.class.php');
include_once("func_form.php");
$emp=1;

//funciones para convertir px->mm
function mmtopx($d){
	$fc=96/25.4;
	$n=$d*$fc;
	return $n;
}
function pxtomm($d){
	$fc=96/25.4;
	$n=$d/$fc;
	return $n;
}
function checkmark(){
	$url="http://".$_SERVER["HTTP_HOST"]."/img/checkmark.png";
	$s='<img src="'.$url.'" style="height:10px;" />';
	return $s;
}
//tamaño carta alto:279.4mm ancho:215.9mm
$heightCarta=mmtopx(279.4);
$widthCarta=mmtopx(215.9);
$celdas=12;
$widthCell=$widthCarta/$celdas;

$mmCartaH=pxtomm($heightCarta);
$mmCartaW=pxtomm($widthCarta);
ob_start();
//no mover -------------------------------------------->
?>
<style>
td{
	background-color:#FFF;
}
</style>
<table cellspacing="0" style="width:100%;">
	<tr>
    	<td style="width:20%;"><img src="img/lasilla.png" style="width:100%;"/></td>
    	<td style="font-size:20px;width:60%;" align="center"><p><strong>LA SILLA SERVICIO AUTOMOTRIZ S.A. DE     C.V.   </strong></p>	
          <p style="font-size:10px;margin:0;"><p><strong>CONSECUTIVO DE FACTURAS CON IMPUESTOS | SUCURSAL MÉRIDA PENSIONES DEL : 08/08/2014 : 08/08/2014</strong></p></p></td>
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
     <tr style="font-size:8px;"> 
        <td style="width:5%;">C-238</td>
        <td align="center" style="width:5%;">07/08/2014</td>
        <td style="width:5%;">OFIX S.A DE C.V</td>
        <td style="width:5%;">1153</td>
        <td style="width:5%;">MJK1769</td>
        <td style="width:5%;">$ 1,039.62</td>
        <td style="width:5%;">$ 473.10</td>
        <td style="width:5%;">$ 166.34</td>
        <td style="width:5%;">$ 1,205.96</td>
        <td style="width:5%;">$ 566.52</td>
        <td style="width:5%;">54.49</td>
        <td style="width:5%;">CHEQUE NOMINATIVO</td>
    </tr>
   <tr style="font-size:8px;"> 
        <td style="">C-239</td>
        <td align="center" style="width:5%;">08/08/2014</td>
        <td style="">SINDI LIVIER YAH</td>
        <td style="">1171</td>
        <td style="">USH832A</td>
        <td style="">$ 1,293.10</td>
        <td style="">$ 0.00</td>
        <td style="">$ 206.90</td>
        <td style="">$ 1,500.00</td>
        <td style="">$ 1,293.10</td>
        <td style="">100.00</td>
        <td style="">EFECTIVO</td>
    </tr>
    <tr>
    	<td></td>
        <td></td>
   <td style="font-size:10px;" align="center"><p><strong>TOTAL REPORTE:</strong></p></td>
   <td></td>
   <td style="font-size:10px;"><p><strong>$2,332.72</strong></p></td>
    <td style="font-size:10px;"><p><strong>$ 473.10</strong></p></td>
    <td style="font-size:10px;"><p><strong>$ 373.24</strong></p></td>
    <td style="font-size:10px;"><p><strong>$ 2,705.96</strong></p></td>
    <td style="font-size:10px;"><p><strong>$ 1,859.62</strong></p></td>
    </tr>
</table>

    

<?php //no mover -------------------------------------------->
$html=ob_get_clean();
$path='docs/';
$filename="generador.pdf";
//$filename=$_POST["nombre"].".pdf";

//configurar la pagina
//$orientar=$_POST["orientar"];
$orientar="landscape";

$topdf=new HTML2PDF($orientar,array($mmCartaW,$mmCartaH),'es');
$topdf->writeHTML($html);
$topdf->Output();
//$path.$filename,'F'

//echo "http://".$_SERVER['HTTP_HOST']."/docs/".$filename;

?>