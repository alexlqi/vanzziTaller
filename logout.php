<?php
session_start();
unset ($_SESSION['usuarioID']);
unset ($_SESSION['usuarioNAME']);
unset ($_SESSION['usuarioPERFIL']);
unset ($_SESSION['sesionID']);
unset ($_SESSION['sesionNAME']);
session_destroy();
header ("location: index.php");
?>