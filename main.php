<?php session_start();?>
<?php require_once ('include/config.php'); ?>
<?php require_once ('include/libreria.php'); ?>
<?php
$r = mysql_query("SELECT id,nombre,facturacion,perfilID,sucursalID FROM config_usuarios WHERE username = ".Limpia($_POST['username'])." AND password = '".MD5($_POST['password'])."'");
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$_SESSION['usuarioID'] = $reg['id'];
	$_SESSION['usuarioNAME'] = $reg['nombre'];
	$_SESSION['usuarioFACTURACION'] = $reg['facturacion'];
	$_SESSION['usuarioPERFIL'] = $reg['perfilID'];
	$_SESSION['usuarioSUCURSAL'] = $reg['sucursalID'];
	$_SESSION['sesionID'] = session_id();
	$_SESSION['sesionNAME'] = 'AnetPV2012';
	$_SESSION['IVASucursalAmNetPV2012'] = 16;
	$r1 = mysql_query("SELECT frontera FROM config_sucursales WHERE id = ".$reg['sucursalID']);
	$reg1 = mysql_fetch_array($r1);
	if ($reg1['frontera'] == 1) { $_SESSION['IVASucursalAmNetPV2012'] = 11; }
}
header ('Location: index.php');
?>