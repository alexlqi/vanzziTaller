<?php session_start();
header('Content-type: application/json');
date_default_timezone_set("America/Monterrey");
include("config.php");
$id=$_POST["id"];

//Matriz de facturación
$Comprobante = array(
	'serie' => "A",
	'folio' => "15",
	'fecha' => date("Y-m-d")."T" .date("H:i:s"),
	'condicionesDePago' => 'PAGO EN UNA SOLA EXHIBICION',
	'subTotal' => "1000",
	'descuento' => "",
	'motivoDescuento' => "",
	'TipoCambio' => '1',
	'Moneda' => 'MXN',
	'total' => "1160",
	'metodoDePago' => "Contado",
	'tipoDeComprobante' => 'ingreso',
	'formaDePago' => 'Efectivo',
	'LugarExpedicion' => "Monterrey N.L.",
	'NumCtaPago' => '',
	'Complemento'=>'',
	'observaciones'=>'',
	'Emisor' => array(
		'rfc' => "AAA010101AAA",
		'nombre' => "RAZON SOCIAL",
		'DomicilioFiscal' => array(
			'calle' => "CALLE EMISOR",
			'municipio' => "PUEBLA",
			'localidad' => "",
			'estado' => "PUEBLA",
			'pais' => "MEXICO",
			'codigoPostal' => "72000",
			'noExterior' => "",
			'noInterior' => "",
			'colonia' => "",
		),
		'ExpedidoEn' => array(
			'calle' => "",
			'municipio' => "",
			'localidad' => "",
			'estado' => "",
			'pais' => "MEXICO",
			'codigoPostal' => "72000",
			'noExterior' => "",
			'noInterior' => "",
			'colonia' => "",
		),
		'RegimenFiscal' => array(
			'regimen' => "REGIMEN FISCAL"
		),
	),
	'Receptor' => array(
		'rfc' => "AAA010101AAA",
		'nombre' => "AAA010101AAAAAA010101AAA",
		'calle' => "",
		'municipio' => "",
		'localidad' => "",
		'estado' => "",
		'pais' => "MEXICO",
		'codigoPostal' => "72000",
		'noExterior' => "",
		'noInterior' => "",
		'colonia' => "",
		'referencia' => "",
	),
	'Conceptos' => array(),
	'Impuestos' => array(
		'totalImpuestosTrasladados' => "0",
		'totalImpuestosRetenidos' => "160",
		'Traslados' => array(
			'0' => array(
				'impuesto' => 'IVA',
				'tasa'=>'0',
				'importe' => "160",
			)
		),
		'Retenciones' => array(
			'0' => array(
				'impuesto' => 'IVA',
				'importe' => "160",
			)
		), /*
	  'Retenciones' => array(
	  '0' => array(
	  'impuesto' => 'ISR',
	  'importe' => '13',
	  )
	  )
	 * 
	 */
	),
);

$DatosAdicionales=array(
	'observaciones'=>'',
	'email'=>'',
	'otros'=>''
);

//modificación de la matriz desde la base de datos
$sql="SELECT * FROM servicios WHERE id=$id;"; 
$r=mysql_query($sql); $datos=mysql_fetch_assoc($r);
foreach($_POST as $i=>$d){
	$datos[$i]=$d;
}

array_push($Comprobante["Conceptos"],array(
	'cantidad' => '1',
	'unidad' => 'Servicio',
	'noIdentificacion' => '0',
	'pDescuento' => '',
	'descuento' => '',
	'ped' => '',
	'descripcion' => 'DESCRIPCION',
	'valorUnitario' => "1000",
	'importe' => "1000",
	'InformacionAduanera' => '',
));

//identificación de los documentos
$ident=$Comprobante["serie"].$Comprobante["folio"]."_".date("YmdHis");

//Modul de facturación con click factura
try{
// Crear un cliente apuntando al script del servidor (Creado con WSDL)
	$serverURL ='https://www.clickfactura.com.mx/webservice/yii/generaTimbrePortalv2/';
	
	$cliente=new SoapClient("$serverURL?wsdl");
	$result=$cliente->generaTimbreParametros('AAA010101AAA','demo',$Comprobante,$DatosAdicionales);//*/
	//var_dump($result);
	$id_fact=$result->uuid;
	if($result->resultado=="true"){
		file_put_contents('../comprobantes/'.$ident.'.xml',base64_decode($result->xmlData));
		file_put_contents('../comprobantes/'.$ident.'.pdf',base64_decode($result->pdfData));
		file_put_contents('../comprobantes/'.$ident.'.txt',$id_fact);
		/*Aquí poner el script para alamcenar los documentos en la base de datos*/
		mysql_query("INSERT INTO ");
	}else{
		echo "Hubo un error en el proceso. <br />";
		echo $result->error;
	}
}catch(SoapFault $e){
	echo "<pre>";
	print_r ($e);
	echo "</pre>";
}

//PDO para guardar los datos de la factura dentro de la base de datos
try{
	$bd=new PDO($dsnw,$db_us,$db_pas,$optPDO);
	
	$bd->beginTransaction();
	//actualizar los 
	$sql="INSERT INTO dummy (col1) VALUES ('sdasd');";
	$bd->exec($sql);
	
	$sql="INSERT INTO dummy (col2) VALUES ('sdasd');";
	$bd->exec($sql);
	
	$bd->commit();
}catch(PDOException $e){
	$bd->rollBack();
	echo json_encode(array("error"=>$e->getMessage()));
}

$bd=NULL;

mysql_close($db_conn);
?>