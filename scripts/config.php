<?php
$db_server = 'localhost';

if($_SERVER["HTTP_HOST"]=="sistema.vanzzi.com"){
	$db_us = 'vanzzico_admin';
	$db_pas = 'sistema231';
	$db_db = 'vanzzico_taller';
	$db_conn = @mysql_connect($db_server,$db_us,$db_pas) or die ('Imposible conectarse con el servidor');
	$db_bd = @mysql_select_db($db_db,$db_conn) or die ('Imposible comunicarse con la base de datos');
	
	//PDO
	$dsnw = "mysql:host=localhost; dbname=$db_db; charset=utf8";
}else{	
	$db_us = 'lasillai_AmNet';
	$db_pas = '_u{a@v4N?0Ca';
	$db_db = 'lasillai_sistema';
	$db_conn = @mysql_connect($db_server,$db_us,$db_pas) or die ('Imposible conectarse con el servidor');
	$db_bd = @mysql_select_db($db_db,$db_conn) or die ('Imposible comunicarse con la base de datos');
	
	//PDO
	$dsnw = "mysql:host=localhost; dbname=$db_db; charset=utf8";
}

$optPDO=array(PDO::ATTR_EMULATE_PREPARES=>false, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);

define ('IVA',16);
?>