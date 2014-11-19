<div id="AccordionContainer" class="AccordionContainer">
<?php
if (isset($_SESSION['usuarioPERFIL']) and $_SESSION['usuarioPERFIL'] == 2)
{
?>
  <div onclick="runAccordion(3);">
    <div class="AccordionTitle" onselectstart="return false;">
      Ventas
    </div>
  </div>
  <div id="Accordion3Content" class="AccordionContent">
    <ul>
    	<li><a href="venta.php"><img src="imagenes/iconVentas.png" border="0"><br>Venta de Productos</a></li>
        <li><a href="retiroEfvo.php"><img src="imagenes/iconRetiro.png" border="0"><br>Retiro de Efectivo</a></li>
    </ul>
  </div>
<?php
}
else
{
?>
<!--  <div onclick="runAccordion(1);">
    <div class="AccordionTitle" onselectstart="return false;">
      Cotizacion
    </div>
  </div>
  <div id="Accordion1Content" class="AccordionContent">
    &nbsp;
  </div>

  <div onclick="runAccordion(2);">
    <div class="AccordionTitle" onselectstart="return false;">
      Recepcion
    </div>
  </div>
  <div id="Accordion2Content" class="AccordionContent">
  	&nbsp;
  </div> -->

  <div onclick="runAccordion(3);">
    <div class="AccordionTitle" onselectstart="return false;">
      Ventas
    </div>
  </div>
  <div id="Accordion3Content" class="AccordionContent">
    <ul>
    	<li><a href="venta.php"><img src="imagenes/iconVentas.png" border="0"><br>Venta de Productos</a></li>
        <li><a href="ordenServicio.php"><img src="imagenes/iconVentas.png" border="0"><br>Ordenes de Servicio</a></li>
        <li><a href="retiroEfvo.php"><img src="imagenes/iconRetiro.png" border="0"><br>Retiro de Efectivo</a></li>
        <li><a href="reportes.php?OT=3&ID=4"><img src="imagenes/iconCorte.png" border="0"><br>Corte de Caja</a></li>
	    <li><a href="clientes.php?OT=3"><img src="imagenes/iconClientes.png" border="0"><br>Clientes</a></li>
        <li><a href="backorder.php?OT=3"><img src="imagenes/iconBackorder.png" border="0"><br>BackOrders</a></li>
        <li><a href="tickets.php?OT=3"><img src="imagenes/iconReimprimir.png" border="0"><br>Reimprimir Ticket</a></li>
    </ul>
  </div>

  <div onclick="runAccordion(4);">
    <div class="AccordionTitle" onselectstart="return false;">
      Inventario
    </div>
  </div>
  <div id="Accordion4Content" class="AccordionContent">
    <ul>
	    <li><a href="proveedores.php?OT=4"><img src="imagenes/iconProveedores.png" border="0"><br>Proveedores</a></li>
        <li><a href="productos.php?OT=4"><img src="imagenes/iconProductos.png" border="0"><br>Productos</a></li>
        <li><a href="inventario.php?mod=Entrada&OT=4"><img src="imagenes/iconEntrada.png" border="0"><br>Entrada de Mercancia</a></li>
        <li><a href="inventario.php?mod=Ajuste&OT=4"><img src="imagenes/iconInventario.png" border="0"><br>Ajuste de Inventario</a></li>
        <li><a href="salida.php?OT=4"><img src="imagenes/iconTaller.png" border="0"><br>Productos para Taller</a></li>
    </ul>
  </div>

  <div onclick="runAccordion(5);">
    <div class="AccordionTitle" onselectstart="return false;">
      Facturacion
    </div>
  </div>
  <div id="Accordion5Content" class="AccordionContent">
    <ul>
	    <li><a href="facturacion.php?OT=5"><img src="imagenes/iconFactura.png" border="0"><br>Crear Factura</a></li>
        <li><a href="facturacion.php?mod=Folios&OT=5"><img src="imagenes/iconFactura.png" border="0"><br>Folios</a></li>
    </ul>
  </div>
  
<!--  <div onclick="runAccordion(6);">
    <div class="AccordionTitle" onselectstart="return false;">
      Cuentas por Pagar
    </div>
  </div>
  <div id="Accordion6Content" class="AccordionContent">
    &nbsp;
  </div>
  
  <div onclick="runAccordion(7);">
    <div class="AccordionTitle" onselectstart="return false;">
      Cuentas por Cobrar
    </div>
  </div>
  <div id="Accordion7Content" class="AccordionContent">
    &nbsp;
  </div> -->
  
  <div onclick="runAccordion(8);">
    <div class="AccordionTitle" onselectstart="return false;">
      Reportes
    </div>
  </div>
  <div id="Accordion8Content" class="AccordionContent">
    <ul>
    	<li><a href="reportes.php?OT=8&ID=4"><img src="imagenes/iconReportes.png" border="0"><br>Ordenes de Servicio</a></li>
    	<li><a href="reportes.php?OT=8&ID=1"><img src="imagenes/iconReportes.png" border="0"><br>Ventas por Vendedor</a></li>
	    <li><a href="reportes.php?OT=8&ID=2"><img src="imagenes/iconReportes.png" border="0"><br>Existencias Totales</a></li>
        <li><a href="reportes.php?OT=8&ID=3"><img src="imagenes/iconReportes.png" border="0"><br>Movimientos de Articulo</a></li>
    </ul>
  </div>
  
  <div onclick="runAccordion(9);">
    <div class="AccordionTitle" onselectstart="return false;">
      Configuracion
    </div>
  </div>
  <div id="Accordion9Content" class="AccordionContent">
    <ul>
    	<li><a href="getListado.php?mod=ProductosBD"><img src="imagenes/iconExporta.png" border="0"><br>Exportar Productos</a></li>
        <li><a href="importaDatos.php?mod=Productos&OT=9"><img src="imagenes/iconImporta.png" border="0"><br>Importar Productos</a></li>
        <li><a href="usuarios.php?OT=9"><img src="imagenes/iconUsuarios.png" border="0"><br>Usuarios del Sistema</a></li>
        <li><a href="configuracion.php?mod=Sucursales&OT=9"><img src="imagenes/iconSucursales.png" border="0"><br>Sucursales</a></li>
        <li><a href="configuracion.php?mod=Paises&OT=9"><img src="imagenes/iconPaises.png" border="0"><br>Paises, Estados y Ciudades</a></li>
        <li><a href="configuracion.php?mod=Marcas&OT=9"><img src="imagenes/iconPaises.png" border="0"><br>Marcas y Modelos de Vehiculos</a></li>
        <li><a href="configuracion.php?mod=ManoObra&OT=9"><img src="imagenes/iconPaises.png" border="0"><br>Catalogo de Mano de Obra</a></li>
        <li><a href="configuracion.php?mod=Paquetes&OT=9"><img src="imagenes/iconPaises.png" border="0"><br>Paquetes</a></li>
    </ul>
  </div>
<?php
}
?>
</div>