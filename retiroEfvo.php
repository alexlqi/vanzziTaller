<?php include ('header.php'); ?>
<div id="body">
<h1>Retiro de Efectivo</h1>
<div id="forma">
<form id="form1" name="form1" method="post" action="backend.php?mod=RetiroEfvo" autocomplete="off">
  <h2>Datos del Movimiento</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%"><label>Monto a Retirar</label><input type="text" name="username2" id="username2"></td>
        </tr>
      <tr>
        <td><label>Concepto</label>
          <textarea name="textarea" id="textarea" rows="3"></textarea></td>
        </tr>
      <tr>
        <td><label>Usuario</label>
          <input type="text" name="username" id="username"></td>
        </tr>
      <tr>
        <td><label>Contraseña</label><input type="password" name="password" id="password"></td>
        </tr>
    </table>
  <br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="50%" align="right">
          <input type="submit" value="Guardar Datos" />
        </td>
      </tr>
  </table>
  </form>
</div>
</div>
<?php include ('footer.php'); ?>