<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
require_once('include/nusoap.php');

// function defination to convert array to xml
function array_to_xml($student_info, $xml_student_info) {
    foreach($student_info as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_student_info->addChild("$key");
                array_to_xml($value, $subnode);
            }
            else{
                $subnode = $xml_student_info->addChild("item$key");
                array_to_xml($value, $subnode);
            }
        }
        else {
            $xml_student_info->addChild("$key",htmlspecialchars("$value"));
        }
    }
}


try{
// Crear un cliente apuntando al script del servidor (Creado con WSDL)
$serverURL = 'https://www.clickfactura.com.mx/webservice/yii/generaTimbrePortalv2/';
$cliente = new nusoap_client("$serverURL?wsdl", 'wsdl');

$datosXml = array();
$datosXml['Emisor'] = array();


$datosXml['Emisor']['rfc'] ="AAA010101AAA";
$datosXml['Emisor']['DomicilioFiscal']['calle'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['noExterior'] ="1";
$datosXml['Emisor']['DomicilioFiscal']['noInterior'] ="1";
$datosXml['Emisor']['DomicilioFiscal']['colonia'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['localidad'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['referencia'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['municipio'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['estado'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['pais'] ="a";
$datosXml['Emisor']['DomicilioFiscal']['codigoPostal'] ="66666";

$datosXml['Receptor'] = array();

$datosXml['Receptor']['rfc'] ="AAA010101AAA";
$datosXml['Receptor']['nombre'] ="a";
$datosXml['Receptor']['calle'] ="a";
$datosXml['Receptor']['noExterior'] ="1";
$datosXml['Receptor']['noInterior'] ="1";
$datosXml['Receptor']['colonia'] ="a";
$datosXml['Receptor']['localidad'] ="a";
$datosXml['Receptor']['referencia'] ="a";
$datosXml['Receptor']['municipio'] ="a";
$datosXml['Receptor']['estado'] ="a";
$datosXml['Receptor']['pais'] ="a";
$datosXml['Receptor']['codigoPostal'] ="a";


$datosXml['Conceptos'] = array();

$datosXml['Conceptos'][0]['cantidad'] = "1";
$datosXml['Conceptos'][0]['unidad'] = "no aplica";
$datosXml['Conceptos'][0]['noIdentificacion'] = "1";
$datosXml['Conceptos'][0]['descripcion'] = "p";
$datosXml['Conceptos'][0]['valorUnitario'] = "1000";
$datosXml['Conceptos'][0]['importe'] = "1000";
$datosXml['Conceptos'][0]['InformacionAduanera'] = "";
$datosXml['Conceptos'][0]['CuentaPredial'] = "";


$datosXml['Impuestos'] = array();
$datosXml['Impuestos']['totalImpuestosRetenidos'] = "";
$datosXml['Impuestos']['totalImpuestosTrasladados'] = "";

$datosXml['Impuestos']['Traslados'][0]['impuesto'] = "";
$datosXml['Impuestos']['Traslados'][0]['tasa'] = "";
$datosXml['Impuestos']['Traslados'][0]['importe'] = "";

$datosXml['Impuestos']['Retenciones'][0]['impuesto'] = "";
$datosXml['Impuestos']['Retenciones'][0]['importe'] = "";

$datosXml['Complementos']['Donatarias'] = array();

$datosXml['Complementos']['Donatarias']["version"] = "";
$datosXml['Complementos']['Donatarias']["noAutorizacion"] = "";
$datosXml['Complementos']['Donatarias']["fechaAutorizacion"] = "2014-09-12T11:00:50";
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

 
	function arrayToObject($d) {
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return (object) array_map(__FUNCTION__, $d);
		}
		else {
			// Return object
			return $d;
		}
	}

$compr=new stdClass();
$compr->serie = "A";
$compr->folio = "1";
$compr->fecha = date("Y-m-d")."T".date("H:i:s");
$compr->condicionesDePago = "a";
$compr->subTotal = "1000";
$compr->descuento = "0";
$compr->motivoDescuento = "a";
$compr->TipoCambio = "13.5";
$compr->Moneda = "MXN";
$compr->total = "1160";
$compr->metodoDePago = "contado";
$compr->tipoDeComprobante = "ingreso";
$compr->formaDePago = "efectivo";
$compr->LugarExpedicion = "aqui";
$compr->NumCtaPago = "0001";

$compr->Emisor=$datosXml["Emisor"];
$compr->Receptor=$datosXml["Receptor"];

//*/

$serverScript="";
$metodoALlamar="";

$result = $cliente->call(
    "generaTimbreParametros",			// Funcion a llamar
    array('Usuario' => 'AAA010101AAA',	// Parametros pasados a la funcion
          'Pass' => 'demo',
          'Comprobante' => $compr
	),
    "uri:$serverURL/$serverScript",                    // namespace
    "uri:$serverURL/$serverScript/$metodoALlamar"      // SOAPAction
);

var_dump($result);
}catch(SoapFault $e){
	var_dump($e);
}
?>
</body>
</html>