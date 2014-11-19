<?php //date_default_timezone_set("America/Monterrey"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
require_once('include/nusoap.php');

// Crear un cliente apuntando al script del servidor (Creado con WSDL)
$serverURL ='https://www.clickfactura.com.mx/webservice/webservice/server32_salesPartner.php';
$cliente = new nusoap_client("$serverURL?wsdl", true);

$datosXml = array();

$datosXml['Comprobante']['serie'] = "a";
$datosXml['Comprobante']['folio'] = "1";
$datosXml['Comprobante']['fecha'] = date("Y-m-d")."T08:18:20";
$datosXml['Comprobante']['condicionesDePago'] = "";
$datosXml['Comprobante']['subTotal'] = "1000";
$datosXml['Comprobante']['descuento'] = "";
$datosXml['Comprobante']['motivoDescuento'] = "";
$datosXml['Comprobante']['TipoCambio'] = "13";
$datosXml['Comprobante']['Moneda'] = "MXN";
$datosXml['Comprobante']['total'] = "1160";
$datosXml['Comprobante']['metodoDePago'] = "Contado";
$datosXml['Comprobante']['tipoDeComprobante'] = "ingreso";
$datosXml['Comprobante']['formaDePago'] = "Efectivo";
$datosXml['Comprobante']['LugarExpedicion'] = "Monterrey N.L.";
$datosXml['Comprobante']['NumCtaPago'] = "";
$datosXml['Comprobante']['FolioFiscalOrig'] ="";
$datosXml['Comprobante']['SerieFolioFiscalOrig'] ="";
$datosXml['Comprobante']['FechaFolioFiscalOrig'] ="";
$datosXml['Comprobante']['MontoFolioFiscalOrig'] ="";
$datosXml['Comprobante']['Complemento'] ="";
$datosXml['Comprobante']['Impuestos'] ="";


$datosXml['Emisor'] = array();

$datosXml['Emisor']['rfc'] ="AAA010101AAA";
$datosXml['Emisor']['RegimenFiscal']["regimen"]="General";
$datosXml['Emisor']['nombre'] ="a";
$datosXml['Emisor']['ExpedidoEn'] ="Monterrey N.L.";
$datosXml['Emisor']['DomicilioFiscal']['calle'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['noExterior'] ="1";
$datosXml['Emisor']['DomicilioFiscal']['noInterior'] ="1";
$datosXml['Emisor']['DomicilioFiscal']['colonia'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['localidad'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['municipio'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['estado'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['pais'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['codigoPostal'] ="1";

$datosXml['Receptor'] = array();

$datosXml['Receptor']['rfc'] ="AAA010101AAA";
$datosXml['Receptor']['nombre'] ="a";
$datosXml['Receptor']['calle'] ="";
$datosXml['Receptor']['noExterior'] ="";
$datosXml['Receptor']['noInterior'] ="";
$datosXml['Receptor']['colonia'] ="";
$datosXml['Receptor']['localidad'] ="";
$datosXml['Receptor']['referencia'] ="";
$datosXml['Receptor']['municipio'] ="";
$datosXml['Receptor']['estado'] ="";
$datosXml['Receptor']['pais'] ="";
$datosXml['Receptor']['codigoPostal'] ="";

$datosXml['Conceptos'][0] = array(
	'cantidad' => 1,
	'unidad'=>'NO APLICA',
	'noIdentificacion' => "1",
	'descripcion' => "aaaa",
	'valorUnitario' => "1",
	'importe' => "1",
	'pDescuento'=>'',
	'ped'=>'',
	'descuento'=>'',
	'InformacionAduanera'=>'',
	'CuentaPredial'=>'',
);
$datosXml['Complementos']['Donatarias'] = array();

$datosXml['Complementos']['Donatarias']["version"] = "";
$datosXml['Complementos']['Donatarias']["noAutorizacion"] = "";
$datosXml['Complementos']['Donatarias']["fechaAutorizacion"] = "";
$datosXml['Complementos']['Donatarias']["leyenda"] = "";


$datosXml['Complementos']['ImpuestosLocales'] = array();
$datosXml['Complementos']['ImpuestosLocales']["version"] = "";
$datosXml['Complementos']['ImpuestosLocales']["TotaldeRetenciones"] = "";
$datosXml['Complementos']['ImpuestosLocales']["TotaldeTraslados"] = "";


$datosXml['Complementos']['ImpuestosLocales']["TrasladosLocales"][0]['ImpLocTrasladado'] = "";
$datosXml['Complementos']['ImpuestosLocales']["TrasladosLocales"][0]['TasadeTraslado'] = "";
$datosXml['Complementos']['ImpuestosLocales']["TrasladosLocales"][0]['Importe'] = "";

$datosXml['Complementos']['ImpuestosLocales']["RetencionesLocales"][0]['ImpLocRetenido'] = "";
$datosXml['Complementos']['ImpuestosLocales']["RetencionesLocales"][0]['TasadeRetencion'] = "";
$datosXml['Complementos']['ImpuestosLocales']["RetencionesLocales"][0]['Importe'] = "";

$datosXml['Impuestos'] = array();
$datosXml['Impuestos']['totalImpuestosRetenidos'] = "0";
$datosXml['Impuestos']['totalImpuestosTrasladados'] = "0";

$datosXml['Impuestos']['Traslados'][0]['impuesto'] = "";
$datosXml['Impuestos']['Traslados'][0]['tasa'] = "";
$datosXml['Impuestos']['Traslados'][0]['importe'] = "";

$datosXml['Impuestos']['Retenciones'][0]['impuesto'] = "";
$datosXml['Impuestos']['Retenciones'][0]['importe'] = "";

$serverScript="";
$metodoALlamar="generaXML";


try{
$result = $cliente->call(
    "generaXML",                     // Funcion a llamar
    array('Usuario' => 'AAA010101AAA',
          'Pass' => 'demo',
          'DatosXML' => $datosXml)   // Parametros pasados a la funcion
);//*/

/*$cliente=new soapclient("$serverURL?wsdl");
$result=$cliente->__getFunctions();
$result=$cliente->generaXML('AAA010101AAA','demo',$datosXml);//*/
var_dump($result);
}catch(SoapFault $e){
	var_dump($e);
	$trace=$e->xdebug_message;
	echo $trace;
}
?>
</body>
</html>