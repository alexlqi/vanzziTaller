<?php include ('header.php'); ?>
<div id="body">
<?php
if ($_GET['mod'] == 'Productos')
{
?>
<h1>Importar Productos desde Archivo</h1>
<div id="forma">
	<h2>Archivo de Microsoft Excel 97-2003</h2>
    <form name="form1" enctype="multipart/form-data" method="post" action="backend.php?mod=Producto&acc=Importar">
	<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
	  <tr>
	    <td><label>Ruta del Archivo</label>
        <input name="archivo" type="file" id="archivo" size="70"></td>
      </tr>
	  <tr>
	    <td><input type="submit" value="Importar" /></td>
      </tr>
    </table>
	</form>
</div>
<?php
}
?>
</div>
<?php include ('footer.php'); ?>