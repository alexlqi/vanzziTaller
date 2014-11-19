<?php session_start();?>
<?php require_once ('include/config.php'); ?>
<?php require_once ('include/libreria.php'); ?>
<?php
$r = mysql_query("SELECT nombreCampo,valorCampo FROM configuracion WHERE nombreCampo = 'Nombre Comercial' OR nombreCampo = 'Logotipo'");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		if ($reg['nombreCampo'] == 'Nombre Comercial') { $nombreNegocio = $reg['valorCampo']; }
		else { $logo = $reg['valorCampo']; }
	}
}
if (!isset($_GET['OT'])) { $_GET['OT'] = 3; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<title>Sistema Punto de Venta<?php echo ' - '.$nombreNegocio?></title>
<!--ALERTAS -->
<link rel="stylesheet" type="text/css" media="all" href="include/SA/sexyalertbox.css"/>
<script type="text/javascript" src="include/SA/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="include/SA/sexyalertbox.v1.2.moo.js"></script>
<!--AJAX -->
<script src="include/ajax.js" type="text/javascript"></script>
<!--CALENDARIO -->
<link type="text/css" rel="stylesheet" href="include/calendario/datepickercontrol_mozilla.css">
<script type="text/javascript" src="include/calendario/datepickercontrol.js"></script>
<!--GALERIA -->
<link rel="stylesheet" type="text/css" href="include/galeria/highslide.css" />
<script type="text/javascript" src="include/galeria/highslide-with-gallery.js"></script>
<script type="text/javascript">
hs.graphicsDir = 'include/galeria/graphics/';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'glossy-dark';
hs.wrapperClassName = 'dark';
hs.fadeInOut = true;
hs.numberPosition = 'caption';
//hs.dimmingOpacity = 0.75;

// Add the controlbar
if (hs.addSlideshow) hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: .6,
		position: 'bottom center',
		hideOnMouseOut: true
	}
});
</script>
<!--GENERALES -->
<link href="css/estilos.css" type="text/css" rel="stylesheet" media="screen" />
<link href="css/jquery-ui-1.10.4.custom.min.css" type="text/css" rel="stylesheet" media="screen" />
<script src="include/jsFunctions.js" type="text/javascript"></script>
<script src="include/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="include/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
</head>

<body onload="runAccordion(<?php echo $_GET['OT']?>); if (document.getElementById('upc') != null) { document.getElementById('upc').focus(); }<?php if (isset($_SESSION['systemAlertTEXT']) and isset($_SESSION['systemAlertTYPE'])) {?> Alerta('<?php echo $_SESSION['systemAlertTEXT']?>','<?php echo $_SESSION['systemAlertTYPE']?>');return false;<?php unset($_SESSION['systemAlertTEXT']); unset($_SESSION['systemAlertTYPE']); }?>">
<?php
$SID = session_id();
if (!isset($_SESSION['sesionID']) or $_SESSION['sesionID'] <> $SID or !isset($_SESSION['sesionNAME']) or $_SESSION['sesionNAME'] <> 'AnetPV2012')
{
?>
    <div id="bgLogin">
        <div id="login">
            <p>Para ingresar, proporciona tu Usuario y Contrase&ntilde;a</p>
          <form id="formLogin" name="form1" method="post" action="main.php">
            <label>Usuario</label>
                <input type="text" name="username" id="username" />
            <label>Contraseña</label>
                <input type="password" name="password" id="password" />
                <br />
              <br />
                <br />
              <input type="submit" value="Ingresar" />
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
	<div id="top" style="background:url(imagenes/<?php echo $logo?>) no-repeat center; background-size:contain;">
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
<?php
if (!strpos($_SERVER['PHP_SELF'],'venta.php'))
{
?>
<div id="menu"><?php include('menu.php');?></div>
<?php
}
?>