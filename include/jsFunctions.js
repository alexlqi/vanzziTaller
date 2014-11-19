/******************** GENERALES **********************************/
function Trim(cadena)
{
	cadena = cadena.replace(/^\s*|\s*$/g,"");
	return cadena;
}

function Alerta(texto,tipo)
{
	switch (tipo)
	{
		case 'Error': { Sexy.error('<h2>Error en el Sistema</h2><em>Panel de Administracion <b>Americanet</b></em><br/><p>' + texto + '</p>'); break; }
		case 'Alerta': { Sexy.alert('<h2>Alerta del Sistema</h2><em>Panel de Administracion <b>Americanet</b></em><br/><p>' + texto + '</p>'); break; }
		case 'Aviso': { Sexy.info('<h2>Aviso del Sistema</h2><em>Panel de Administracion <b>Americanet</b></em><br/><p>' + texto + '</p>'); }
	}
}

function CerrarAutoCompleta(divID)
{
	document.getElementById(divID).innerHTML = '';
}

function AutoCompleta(id,mod)
{
	switch (mod)
	{
		case 'Proveedores': { window.location = 'proveedores.php?OT=4&mod=Editar&ID=' + id; break; }
		case 'Clientes': { window.location = 'clientes.php?mod=Editar&OT=3&ID=' + id; break; }
		case 'Ventas': { LoadContent('ajaxGetCliente.php?ID=' + id + '&mod=Venta', 'divClienteVenta'); break; }
		case 'Servicio': { window.location = 'ordenServicio.php?ID=' + id; break; }
		case 'Sucursales': { window.location = 'configuracion.php?mod=Sucursales&acc=Editar&OT=9&ID=' + id; break; }
		case 'Productos': { document.getElementById('upc').value = id; CerrarAutoCompleta(); break; }
		case 'Facturacion': { LoadContent('ajaxGetCliente.php?ID=' + id + '&mod=Factura', 'divClienteVenta'); LoadContent('ajaxGetDatosCliente.php?ID=' + id, 'divDatosCliente'); break; }
		case 'Usuarios': { window.location = 'usuarios.php?OT=9&mod=Editar&ID=' + id; break; }
		case 'Marcas': { window.location = 'configuracion.php?mod=Marcas&acc=Editar&OT=9&ID=' + id; break; }
		case 'ManoObra': { window.location = 'configuracion.php?mod=ManoObra&acc=Editar&OT=9&ID=' + id; break; }
	}
}

function setEntrada(valor,id,factor)
{
	if (Trim(valor) != '' && !isNaN(valor))
	{
		document.getElementById('fila' + id).style.background = '#acf8c0';
		var entrada = valor * factor;
	}
	else
	{
		document.getElementById('fila' + id).style.background = '#ffffff';
		var entrada = 0;
	}
	document.getElementById('cantidad' + id).innerHTML = entrada;
}

function setAjuste(valor,id,existencia)
{
	if (Trim(valor) != '' && !isNaN(valor))
	{
		document.getElementById('fila' + id).style.background = '#acf8c0';
	}
	else
	{
		document.getElementById('fila' + id).style.background = '#ffffff';
	}
}

function setSalida(valor,id,existencia)
{
	if (Trim(valor) != '' && !isNaN(valor))
	{
		if (parseInt(valor) <= parseInt(existencia)) { document.getElementById('fila' + id).style.background = '#acf8c0'; }
		else { document.getElementById('fila' + id).style.background = '#fadbdb'; }
	}
	else
	{
		document.getElementById('fila' + id).style.background = '#ffffff';
	}
}

function saveProducto(accion,id)
{
	switch (accion)
	{
		case 'AddFirst':
		{
			var upc = Trim(document.getElementById('upc').value);
			var clienteID = Trim(document.getElementById('clienteID').value);
			window.location = 'backend.php?mod=Venta&acc=' + accion + '&upc=' + upc + '&clienteID=' + clienteID;
			break;
		}
		case 'Add':
		{
			var upc = Trim(document.getElementById('upc').value);
			window.location = 'backend.php?mod=Venta&acc=' + accion + '&upc=' + upc;
			break;
		}
		case 'Edita':
		{
			var cantidad = Trim(document.getElementById('cantidad_' + id).value);
			window.location = 'backend.php?mod=Venta&acc=' + accion + '&ID=' + id + '&cantidad=' + cantidad;
			break;
		}
		case 'Cancela':
		{
			Sexy.confirm("<h2>Confirmacion del Sistema</h2><em>Panel de Administracion <b>Americanet</b></em><p>&iquest;Estas seguro de querer Eliminar este producto de la venta?</p>", { onComplete: 
				function(returnvalue)
				{
					if(returnvalue)
					{
						window.location = 'backend.php?mod=Venta&acc=' + accion + '&ID=' + id;
					}
				}
			});
			break;
		}
		case 'Descuento':
		{
			var descuento = Trim(document.getElementById('descuento').value);
			window.location = 'backend.php?mod=Venta&acc=' + accion + '&descuento=' + descuento;
			break;
		}
		case 'FormaPago':
		{
			var formaPago = Trim(document.getElementById('formaPago').value);
			window.location = 'backend.php?mod=Venta&acc=' + accion + '&formaPago=' + formaPago;
			break;
		}
		case 'MontoPago':
		{
			var montoPago = Trim(document.getElementById('montoPago').value);
			window.location = 'backend.php?mod=Venta&acc=' + accion + '&montoPago=' + montoPago;
			break;
		}
	}
}

function finVenta(accion)
{
	Sexy.confirm("<h2>Confirmacion del Sistema</h2><em>Panel de Administracion <b>Americanet</b></em><p>&iquest;Estas seguro de querer " + accion.toUpperCase() + " esta venta?</p>", { onComplete: 
		function(returnvalue)
		{
			if(returnvalue)
			{
				var descuento = 0;
				if (accion == 'Cerrar') { descuento = Trim(document.getElementById('descuento').value); }
				if (accion == 'Cerrar' && descuento >= 10)
				{
					document.getElementById('divAutorizar').style.display = 'block';
				}
				else
				{
					window.location = 'backend.php?mod=Venta&acc=' + accion;
				}
			}
		}
	});
}

function saveServicio(accion,id)
{
	switch (accion)
	{
		case 'Add':
		{
			var upc = Trim(document.getElementById('upc').value);
			window.location = 'backend.php?mod=Servicio&acc=' + accion + '&upc=' + upc;
			break;
		}
		case 'Edita':
		{
			var cantidad = Trim(document.getElementById('cantidad_' + id).value);
			window.location = 'backend.php?mod=Servicio&acc=' + accion + '&ID=' + id + '&cantidad=' + cantidad;
			break;
		}
		case 'Cancela':
		{
			Sexy.confirm("<h2>Confirmacion del Sistema</h2><em>Panel de Administracion <b>Americanet</b></em><p>&iquest;Estas seguro de querer Eliminar este producto de la salida?</p>", { onComplete: 
				function(returnvalue)
				{
					if(returnvalue)
					{
						window.location = 'backend.php?mod=Servicio&acc=' + accion + '&ID=' + id;
					}
				}
			});
			break;
		}
	}
}

function finServicio(accion)
{
	Sexy.confirm("<h2>Confirmacion del Sistema</h2><em>Panel de Administracion <b>Americanet</b></em><p>&iquest;Estas seguro de querer " + accion.toUpperCase() + " esta salida de mercancia?</p>", { onComplete: 
		function(returnvalue)
		{
			if(returnvalue)
			{
				window.location = 'backend.php?mod=Servicio&acc=' + accion;
			}
		}
	});
}

function selectThis(id)
{
	document.getElementById('datosFactura_' + id).checked = true;
}

function selectAll(flag)
{
	for (i = 0; i < document.form1.elements.length; i++)
	{
		if (document.form1.elements[i].type == "checkbox")
		{
			document.form1.elements[i].checked = flag;
		}
	}
}

function getParametros(reporteID,tipoID)
{
	switch (reporteID)
	{
		case '1':
		{
			switch (tipoID)
			{
				case '1':
				{
					document.getElementById('parametros1').className = 'parametrosEnabled';
					document.getElementById('parametros5').className = 'parametrosDisabled';
					document.getElementById('parametros6').className = 'parametrosDisabled';
					document.getElementById('DPC_fecha_YYYY-MM-DD').disabled = false;
					document.getElementById('DPC_fecha1_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha2_YYYY-MM-DD').disabled = true;
					document.getElementById('upc').disabled = true;
					document.getElementById('producto').disabled = true;
					break;
				}
				case '5':
				{
					document.getElementById('parametros1').className = 'parametrosDisabled';
					document.getElementById('parametros5').className = 'parametrosEnabled';
					document.getElementById('parametros6').className = 'parametrosDisabled';
					document.getElementById('DPC_fecha_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha1_YYYY-MM-DD').disabled = false;
					document.getElementById('DPC_fecha2_YYYY-MM-DD').disabled = false;
					document.getElementById('upc').disabled = true;
					document.getElementById('producto').disabled = true;
					break;
				}
				case '6':
				{
					document.getElementById('parametros1').className = 'parametrosDisabled';
					document.getElementById('parametros5').className = 'parametrosDisabled';
					document.getElementById('parametros6').className = 'parametrosEnabled';
					document.getElementById('DPC_fecha_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha1_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha2_YYYY-MM-DD').disabled = true;
					document.getElementById('upc').disabled = false;
					document.getElementById('producto').disabled = false;
					break;
				}
				default:
				{
					document.getElementById('parametros1').className = 'parametrosDisabled';
					document.getElementById('parametros5').className = 'parametrosDisabled';
					document.getElementById('parametros6').className = 'parametrosDisabled';
					document.getElementById('DPC_fecha_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha1_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha2_YYYY-MM-DD').disabled = true;
					document.getElementById('upc').disabled = true;
					document.getElementById('producto').disabled = true;
					break;
				}
			}
			break;
		}
		case '2':
		{
			switch (tipoID)
			{
				case '1':
				{
					document.getElementById('parametros1').className = 'parametrosEnabled';
					document.getElementById('parametros2').className = 'parametrosDisabled';
					document.getElementById('parametros3').className = 'parametrosDisabled';
					document.getElementById('upc').disabled = false;
					document.getElementById('producto').disabled = false;
					document.getElementById('proveedor').disabled = true;
					document.getElementById('categoria').disabled = true;
					break;
				}
				case '2':
				{
					document.getElementById('parametros1').className = 'parametrosDisabled';
					document.getElementById('parametros2').className = 'parametrosEnabled';
					document.getElementById('parametros3').className = 'parametrosDisabled';
					document.getElementById('upc').disabled = true;
					document.getElementById('producto').disabled = true;
					document.getElementById('proveedor').disabled = false;
					document.getElementById('categoria').disabled = true;
					break;
				}
				case '3':
				{
					document.getElementById('parametros1').className = 'parametrosDisabled';
					document.getElementById('parametros2').className = 'parametrosEnabled';
					document.getElementById('parametros3').className = 'parametrosEnabled';
					document.getElementById('upc').disabled = true;
					document.getElementById('producto').disabled = true;
					document.getElementById('proveedor').disabled = false;
					document.getElementById('categoria').disabled = false;
					break;
				}
			}
			break;
		}
		case '3':
		{
			switch (tipoID)
			{
				case '1':
				{
					document.getElementById('parametros1').className = 'parametrosEnabled';
					document.getElementById('parametros5').className = 'parametrosDisabled';
					document.getElementById('DPC_fecha_YYYY-MM-DD').disabled = false;
					document.getElementById('DPC_fecha1_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha2_YYYY-MM-DD').disabled = true;
					break;
				}
				case '5':
				{
					document.getElementById('parametros1').className = 'parametrosDisabled';
					document.getElementById('parametros5').className = 'parametrosEnabled';
					document.getElementById('DPC_fecha_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha1_YYYY-MM-DD').disabled = false;
					document.getElementById('DPC_fecha2_YYYY-MM-DD').disabled = false;
					break;
				}
				default:
				{
					document.getElementById('parametros1').className = 'parametrosDisabled';
					document.getElementById('parametros5').className = 'parametrosDisabled';
					document.getElementById('DPC_fecha_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha1_YYYY-MM-DD').disabled = true;
					document.getElementById('DPC_fecha2_YYYY-MM-DD').disabled = true;
					break;
				}
			}
			break;
		}
	}
}

function setDatosFactura(flag)
{
	if (flag == 'VentaDia')
	{
		document.getElementById('clienteID').value = 0;
		document.getElementById('nombre').value = 'VENTAS DEL DIA';
		document.getElementById('nombre').disabled = true;
		LoadContent('ajaxGetDatosCliente.php?ID=0', 'divDatosCliente');
	}
	else
	{
		document.getElementById('nombre').value = 'Buscar Cliente...';
		document.getElementById('nombre').disabled = false;
		document.getElementById('divDatosCliente').innerHTML = '';
	}
}
/******************** GENERALES **********************************/

/******************** AJAX **********************************/
function LoadContent(url, id)
{
	var asynchronous = new Asynchronous();
	asynchronous.complete = function(responseText, id) {
		document.getElementById(id).innerHTML = responseText;
	}
	var responseItem = document.getElementById(id)
    responseItem.innerHTML = 'Cargando, por favor espere...';
    asynchronous.call(url, id)
}

function ajaxLogin()
{
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	LoadContent('ajaxLogin.php?username=' + username + '&password=' + password, 'divLogin');
}

function ajaxGetSelectValues(id,divID)
{
	LoadContent('ajaxGetSelectValues.php?div=' + divID + '&ID=' + id,divID);
}

function ajaxSaveData(accion,id,divID)
{
	if (document.getElementById('ID') != null) { var cliente = Trim(document.getElementById('ID').value); }
	else { var cliente = ''; }
	switch (divID)
	{
		case 'divDirecciones':
		{
			if (id == '')
			{
				var domicilio = Trim(document.getElementById('domicilio').value);
				var colonia = Trim(document.getElementById('colonia').value);
				var cp = Trim(document.getElementById('cp').value);
				var pais = Trim(document.getElementById('pais').value);
				var estado = Trim(document.getElementById('estado').value);
				var ciudad = Trim(document.getElementById('ciudad').value);
				if (domicilio == '' || colonia == '' || cp == '' || pais == '' || estado == '' || ciudad == '') { Alerta('Todos los campos son requeridos','Error'); return false; }
				else { LoadContent('ajaxSaveData.php?acc=' + accion + '&cliente=' + cliente + '&domicilio=' + domicilio + '&colonia=' + colonia + '&cp=' + cp + '&pais=' + pais + '&estado=' + estado + '&ciudad=' + ciudad + '&divID=' + divID, divID); }
			}
			else
			{
				LoadContent('ajaxSaveData.php?acc=' + accion + '&ID=' + id + '&divID=' + divID + '&cliente=' + cliente, divID);
			}
			break;
		}
		case 'divFiscales':
		{
			if (id == '')
			{
				var razonSocial = Trim(document.getElementById('razonSocial').value);
				var rfc = Trim(document.getElementById('rfc').value);
				var domicilio = Trim(document.getElementById('domicilioFiscal').value);
				var colonia = Trim(document.getElementById('coloniaFiscal').value);
				var cp = Trim(document.getElementById('cpFiscal').value);
				var pais = Trim(document.getElementById('paisFiscal').value);
				var estado = Trim(document.getElementById('estadoFiscal').value);
				var ciudad = Trim(document.getElementById('ciudadFiscal').value);
				if (razonSocial == '' || rfc == '' || domicilio == '' || colonia == '' || cp == '' || pais == '' || estado == '' || ciudad == '') { Alerta('Todos los campos son requeridos','Error'); return false; }
				else { LoadContent('ajaxSaveData.php?acc=' + accion + '&cliente=' + cliente + '&razonSocial=' + razonSocial + '&rfc=' + rfc + '&domicilio=' + domicilio + '&colonia=' + colonia + '&cp=' + cp + '&pais=' + pais + '&estado=' + estado + '&ciudad=' + ciudad + '&divID=' + divID, divID); }
			}
			else
			{
				LoadContent('ajaxSaveData.php?acc=' + accion + '&ID=' + id + '&divID=' + divID + '&cliente=' + cliente, divID);
			}
			break;
		}
		case 'divVehiculos':
		{
			if (id == '')
			{
				var placa = Trim(document.getElementById('placa').value);
				var noSerie = Trim(document.getElementById('noSerie').value);
				var marca = Trim(document.getElementById('marca').value);
				var modelo = Trim(document.getElementById('modelo').value);
				var year = Trim(document.getElementById('year').value);
				var noEconomico = Trim(document.getElementById('noEconomico').value);
				if (placa == '' || noSerie == '' || marca == '' || modelo == '' || year == '' || noEconomico == '') { Alerta('Todos los campos son requeridos','Error'); return false; }
				else { LoadContent('ajaxSaveData.php?acc=' + accion + '&cliente=' + cliente + '&placa=' + placa + '&noSerie=' + noSerie + '&marca=' + marca + '&modelo=' + modelo + '&year=' + year + '&noEconomico=' + noEconomico + '&divID=' + divID, divID); }
			}
			else
			{
				LoadContent('ajaxSaveData.php?acc=' + accion + '&ID=' + id + '&divID=' + divID + '&cliente=' + cliente, divID);
			}
			break;
		}
	}
}

function ajaxGetCategorias(mod)
{
	var nombre = Trim(document.getElementById('nCategoria').value);
	if (nombre == '') { Alerta('El nombre de la categoria es requerido','Error'); return false; }
	else { LoadContent('ajaxGetCategorias.php?nombre=' + nombre + '&mod=' + mod, 'divCategorias'); }
}

function ajaxGetUnidades(nombreID,divID)
{
	var nombre = Trim(document.getElementById(nombreID).value);
	if (divID == 'divUSalida') { var divID2 = 'divUEntrada'; }
	else { var divID2 = 'divUSalida'; }
	if (nombre == '') { Alerta('El nombre de la unidad es requerido','Error'); return false; }
	else { LoadContent('ajaxGetUnidades.php?nombre=' + nombre + '&divID=' + divID, divID); LoadContent('ajaxGetUnidades.php?divID=' + divID2, divID2); }
}

function ajaxGetAutoBuscar(textID,mod,divID)
{
	var searchText = Trim(document.getElementById(textID).value);
	if (searchText != '') { LoadContent('ajaxGetAutoBuscar.php?Search=' + searchText + '&mod=' + mod + '&divID=' + divID, divID); }
}

function ajaxGetDescuento(valor)
{
	LoadContent('ajaxSaveData.php?acc=Descuento&valor=' + valor + '&divID=divVenta', 'divVenta');
}

function ajaxGetListaProductos(mod,divID,tipo)
{
	switch (mod)
	{
		case 'Proveedor':
		{
			var id = Trim(document.getElementById('proveedor').value);
			break;
		}
		case 'Categoria':
		{
			var id = Trim(document.getElementById('categoria').value);
			break;
		}
		case 'UPC':
		{
			var id = Trim(document.getElementById('upc').value);
			break;
		}
	}
	LoadContent('ajaxGetListaProductos.php?mod=' + mod + '&ID=' + id + '&tipo=' + tipo, divID);
}

function ajaxGetVentas()
{
	var fecha = document.getElementById('year').value + '-' + document.getElementById('month').value + '-' + document.getElementById('day').value;
	LoadContent('ajaxGetDatosCliente.php?ID=0&fecha=' + fecha, 'divDatosCliente');
}

function ajaxGetBackorder()
{
	var id = document.getElementById('cliente').value;
	LoadContent('ajaxGetBackorder.php?ID=' + id, 'divBackorder');
}

function ajaxGetTickets(mod)
{
	switch (mod)
	{
		case 'Cliente':
		{
			var id = Trim(document.getElementById('cliente').value);
			break;
		}
		case 'Fecha':
		{
			var id = Trim(document.getElementById('DPC_fecha_YYYY-MM-DD').value);
			break;
		}
		case 'Ticket':
		{
			var id = Trim(document.getElementById('ticket').value);
			break;
		}
	}
	LoadContent('ajaxGetTickets.php?mod=' + mod + '&ID=' + id, 'divTickets');
}

function ajaxPartidas(seccion,accion,mod,recursoID,categoriaID,paqueteID)
{
	var url = 'ajaxPartidas.php?secc=' + seccion + '&acc=' + accion + '&mod=' + mod + '&catID=' + categoriaID;
	if (recursoID != 'NULL') { url += '&ID=' + recursoID; }
	if (paqueteID != 'NULL') { url += '&paqID=' + paqueteID; }
	if (accion == 'Edit') { url += '&cantidad=' + document.getElementById('cantidad' + recursoID).value; }
	LoadContent(url, 'ajaxDivPartidas');
}
/******************** AJAX **********************************/

/******************** MENU **********************************/
var ContentHeight = 400;
var TimeToSlide = 250.0;

var openAccordion = '';

function animate(lastTick, timeLeft, closingId, openingId)
{  
  var curTick = new Date().getTime();
  var elapsedTicks = curTick - lastTick;
 
  var opening = (openingId == '') ? null : document.getElementById(openingId);
  var closing = (closingId == '') ? null : document.getElementById(closingId);
 
  if(timeLeft <= elapsedTicks)
  {
    if(opening != null)
      opening.style.height = ContentHeight + 'px';
   
    if(closing != null)
    {
      closing.style.display = 'none';
      closing.style.height = '0px';
    }
    return;
  }
 
  timeLeft -= elapsedTicks;
  var newClosedHeight = Math.round((timeLeft/TimeToSlide) * ContentHeight);

  if(opening != null)
  {
    if(opening.style.display != 'block')
      opening.style.display = 'block';
    opening.style.height = (ContentHeight - newClosedHeight) + 'px';
  }
 
  if(closing != null)
    closing.style.height = newClosedHeight + 'px';

  setTimeout("animate(" + curTick + "," + timeLeft + ",'"
      + closingId + "','" + openingId + "')", 33);
}

function runAccordion(index)
{
  var nID = "Accordion" + index + "Content";
  if(openAccordion == nID)
    nID = '';
   
  setTimeout("animate(" + new Date().getTime() + "," + TimeToSlide + ",'"
      + openAccordion + "','" + nID + "')", 33);
 
  openAccordion = nID;
}
/******************** MENU **********************************/