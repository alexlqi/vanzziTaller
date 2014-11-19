<?php 
session_start();
require_once('include/config.php');
require_once('include/libreria.php');

if (isset($_GET['username']) and isset($_GET['password']))
{
	$r = mysql_query("SELECT id,nombre,facturacion,perfilID,sucursalID FROM config_usuarios WHERE username = ".Limpia($_GET['username'])." AND password = '".MD5($_GET['password'])."'");
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		$_SESSION['usuarioID'] = $reg['id'];
		$_SESSION['usuarioNAME'] = $reg['nombre'];
		$_SESSION['usuarioPERFIL'] = $reg['perfilID'];
		$_SESSION['usuarioSUCURSAL'] = $reg['sucursalID'];
		$_SESSION['usuarioFACTURACION'] = $reg['facturacion'];
		$_SESSION['sesionID'] = session_id();
		$_SESSION['sesionNAME'] = 'AnetPV2012';
		$_SESSION['IVASucursalAmNetPV2012'] = 16;
		$r1 = mysql_query("SELECT frontera FROM config_sucursales WHERE id = ".$reg['sucursalID']);
		$reg1 = mysql_fetch_array($r1);
		if ($reg1['frontera'] == 1) { $_SESSION['IVASucursalAmNetPV2012'] = 11; }
	}
}
$SID = session_id();
if (!isset($_SESSION['sesionID']) or $_SESSION['sesionID'] <> $SID or !isset($_SESSION['sesionNAME']) or $_SESSION['sesionNAME'] <> 'AnetPV2012')
{
?>
    <div id="bgLogin">
        <div id="login">
            <p>Para ingresar, proporciona tu Usuario y Contrase&ntilde;a</p>
          <form id="formLogin" name="form1" method="post" action="">
            <label>Usuario</label>
                <input type="text" name="username" id="username" />
            <label>Contraseña</label>
                <input type="password" name="password" id="password" />
                <br />
              <br />
                <br />
              <input type="button" value="Ingresar" onclick="ajaxLogin();" />
            </form>
        </div>
    </div>
<?php
}
$r = mysql_query("SELECT nombreCampo,valorCampo FROM configuracion WHERE nombreCampo = 'Logotipo'");
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$logo = $reg['valorCampo'];
}
?>
	<div id="top" style="background:url(imagenes/<?php echo $logo?>) no-repeat center;">
<?php
if (isset($_SESSION['usuarioNAME']))
{
?>
		<div id="enLinea"><a href="logout.php" id="logout">[ Cerrar Sesion ]</a><?php echo 'Usuario: '.$_SESSION['usuarioNAME']?></div>
<?php
}
?>
		<div id="fecha"><?php echo Fecha(date('Y-m-d'),'w d de M de Y')?></div>
    	<div class="clear"></div>
	</div>