<?php
session_start();
include ('include/config.php');
include ('include/libreria.php');

switch ($_GET['mod'])
{
	case 'Cliente':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$r = mysql_query("INSERT INTO clientes (nombre,contacto,email,observaciones,listaTelefonos,listaPrecios) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['contacto']).",".Limpia($_POST['email']).",".Limpia($_POST['observaciones']).",".Limpia($_POST['listaTelefonos']).",".Limpia($_POST['listaPrecios']).")");
			$IDCliente = mysql_insert_id();
			
			$arrDomicilios = array();
			if (isset($_SESSION['arrDomiciliosAmNetPV2012'])) { $arrDomicilios = $_SESSION['arrDomiciliosAmNetPV2012']; }
			if (count($arrDomicilios) > 0)
			{
				foreach ($arrDomicilios as $k => $v)
				{
					mysql_query("INSERT INTO clientes_direcciones (direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($v['domicilio']).",".Limpia($v['colonia']).",".Limpia($v['cp']).",".Limpia($v['pais']).",".Limpia($v['estado']).",".Limpia($v['ciudad']).",".$IDCliente.")");
				}
			}
			if (trim($_POST['domicilio']) <> '' and trim($_POST['colonia']) <> '' and trim($_POST['cp']) <> '' and trim($_POST['pais']) <> '' and trim($_POST['estado']) <> '' and trim($_POST['ciudad']) <> '')
			{
				mysql_query("INSERT INTO clientes_direcciones (direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($_POST['domicilio']).",".Limpia($_POST['colonia']).",".Limpia($_POST['cp']).",".Limpia($_POST['pais']).",".Limpia($_POST['estado']).",".Limpia($_POST['ciudad']).",".$IDCliente.")");
			}
			$arrVehiculos = array();
			if (isset($_SESSION['arrVehiculosAmNetPV2012'])) { $arrVehiculos = $_SESSION['arrVehiculosAmNetPV2012']; }
			if (count($arrVehiculos) > 0)
			{
				foreach ($arrVehiculos as $k => $v)
				{
					mysql_query("INSERT INTO clientes_vehiculos (placa,noSerie,noEconomico,year,marcaID,modeloID,clienteID) VALUES (".Limpia($v['placa']).",".Limpia($v['noSerie']).",".Limpia($v['noEconomico']).",".Limpia($v['year']).",".Limpia($v['marca']).",".Limpia($v['modelo']).",".$IDCliente.")");
				}
			}
			if (trim($_POST['placa']) <> '' and trim($_POST['noSerie']) <> '' and trim($_POST['noEconomico']) <> '' and trim($_POST['year']) <> '' and trim($_POST['marca']) <> '' and trim($_POST['modelo']) <> '')
			{
				mysql_query("INSERT INTO clientes_vehiculos (placa,noSerie,noEconomico,year,marcaID,modeloID,clienteID) VALUES (".Limpia($_POST['placa']).",".Limpia($_POST['noSerie']).",".Limpia($_POST['noEconomico']).",".Limpia($_POST['year']).",".Limpia($_POST['marca']).",".Limpia($_POST['modelo']).",".$IDCliente.")");
			}
			$arrFiscales = array();
			if (isset($_SESSION['arrFiscalesAmNetPV2012'])) { $arrFiscales = $_SESSION['arrFiscalesAmNetPV2012']; }
			if (count($arrFiscales) > 0)
			{
				foreach ($arrFiscales as $k => $v)
				{
					mysql_query("INSERT INTO clientes_datos_fiscales (razonSocial,rfc,direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($v['razonSocial']).",".Limpia($v['rfc']).",".Limpia($v['domicilio']).",".Limpia($v['colonia']).",".Limpia($v['cp']).",".Limpia($v['pais']).",".Limpia($v['estado']).",".Limpia($v['ciudad']).",".$IDCliente.")");
				}
			}
			if (trim($_POST['razonSocial']) <> '' and trim($_POST['rfc']) <> '' and trim($_POST['domicilioFiscal']) <> '' and trim($_POST['coloniaFiscal']) <> '' and trim($_POST['cpFiscal']) <> '' and trim($_POST['paisFiscal']) <> '' and trim($_POST['estadoFiscal']) <> '' and trim($_POST['ciudadFiscal']) <> '')
			{
				mysql_query("INSERT INTO clientes_datos_fiscales (razonSocial,rfc,direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($_POST['razonSocial']).",".Limpia($_POST['rfc']).",".Limpia($_POST['domicilioFiscal']).",".Limpia($_POST['coloniaFiscal']).",".Limpia($_POST['cpFiscal']).",".Limpia($_POST['paisFiscal']).",".Limpia($_POST['estadoFiscal']).",".Limpia($_POST['ciudadFiscal']).",".$IDCliente.")");
			}
			unset($_SESSION['arrDomiciliosAmNetPV2012']);
			unset($_SESSION['arrFiscalesAmNetPV2012']);
			unset($_SESSION['arrVehiculosAmNetPV2012']);
			$_SESSION['systemAlertTEXT'] = 'El Cliente ha sido registrado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ("location: clientes.php?OT=3");
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE clientes SET nombre = ".Limpia($_POST['nombre']).",contacto = ".Limpia($_POST['contacto']).",email = ".Limpia($_POST['email']).",observaciones = ".Limpia($_POST['observaciones']).",listaTelefonos = ".Limpia($_POST['listaTelefonos']).",listaPrecios = ".Limpia($_POST['listaPrecios'])." WHERE id = ".Limpia($_POST['ID']));
			if (trim($_POST['domicilio']) <> '' and trim($_POST['colonia']) <> '' and trim($_POST['cp']) <> '' and trim($_POST['pais']) <> '' and trim($_POST['estado']) <> '' and trim($_POST['ciudad']) <> '')
			{
				mysql_query("INSERT INTO clientes_direcciones (direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($_POST['domicilio']).",".Limpia($_POST['colonia']).",".Limpia($_POST['cp']).",".Limpia($_POST['pais']).",".Limpia($_POST['estado']).",".Limpia($_POST['ciudad']).",".Limpia($_POST['ID']).")");
			}
			if (trim($_POST['placa']) <> '' and trim($_POST['noSerie']) <> '' and trim($_POST['noEconomico']) <> '' and trim($_POST['year']) <> '' and trim($_POST['marca']) <> '' and trim($_POST['modelo']) <> '')
			{
				mysql_query("INSERT INTO clientes_vehiculos (placa,noSerie,noEconomico,year,marcaID,modeloID,clienteID) VALUES (".Limpia($_POST['placa']).",".Limpia($_POST['noSerie']).",".Limpia($_POST['noEconomico']).",".Limpia($_POST['year']).",".Limpia($_POST['marca']).",".Limpia($_POST['modelo']).",".$IDCliente.")");
			}
			if (trim($_POST['razonSocial']) <> '' and trim($_POST['rfc']) <> '' and trim($_POST['domicilioFiscal']) <> '' and trim($_POST['coloniaFiscal']) <> '' and trim($_POST['cpFiscal']) <> '' and trim($_POST['paisFiscal']) <> '' and trim($_POST['estadoFiscal']) <> '' and trim($_POST['ciudadFiscal']) <> '')
			{
				mysql_query("INSERT INTO clientes_datos_fiscales (razonSocial,rfc,direccion,colonia,cp,paisID,estadoID,ciudadID,clienteID) VALUES (".Limpia($_POST['razonSocial']).",".Limpia($_POST['rfc']).",".Limpia($_POST['domicilioFiscal']).",".Limpia($_POST['coloniaFiscal']).",".Limpia($_POST['cpFiscal']).",".Limpia($_POST['paisFiscal']).",".Limpia($_POST['estadoFiscal']).",".Limpia($_POST['ciudadFiscal']).",".Limpia($_POST['ID']).")");
			}
			$_SESSION['systemAlertTEXT'] = 'El Cliente ha sido modificado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ("location: clientes.php?OT=3");
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			mysql_query("DELETE FROM productos_prospectos WHERE prospectoID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM seguimientos WHERE prospectoID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM prospectos WHERE id = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM prospectos_contactos WHERE prospectoID = ".Limpia($_GET['ID']));
			header ("location: buscador.php?mod=Eliminar");
		}
		break;
	}
	case 'Proveedor':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$r = mysql_query("INSERT INTO productos_proveedores (nombreComercial,razonSocial,rfc,direccion,colonia,cp,nombreContacto,apellidosContacto,email,listaTelefonos,observaciones,paisID,estadoID,ciudadID) VALUES (".Limpia($_POST['nombreComercial']).",".Limpia($_POST['razonSocial']).",".Limpia($_POST['rfc']).",".Limpia($_POST['domicilioFiscal']).",".Limpia($_POST['coloniaFiscal']).",".Limpia($_POST['cpFiscal']).",".Limpia($_POST['nombre']).",".Limpia($_POST['apellidos']).",".Limpia($_POST['email']).",".Limpia($_POST['listaTelefonos']).",".Limpia($_POST['observaciones']).",".Limpia($_POST['paisFiscal']).",".Limpia($_POST['estadoFiscal']).",".Limpia($_POST['ciudadFiscal']).")");
			$_SESSION['systemAlertTEXT'] = 'El Proveedor ha sido registrado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ("location: proveedores.php?OT=4");
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE productos_proveedores SET nombreComercial = ".Limpia($_POST['nombreComercial']).",razonSocial = ".Limpia($_POST['razonSocial']).",rfc = ".Limpia($_POST['rfc']).",direccion = ".Limpia($_POST['domicilioFiscal']).",colonia = ".Limpia($_POST['coloniaFiscal']).",cp = ".Limpia($_POST['cpFiscal']).",nombreContacto = ".Limpia($_POST['nombre']).",apellidosContacto = ".Limpia($_POST['apellidos']).",email = ".Limpia($_POST['email']).",listaTelefonos = ".Limpia($_POST['listaTelefonos']).",observaciones = ".Limpia($_POST['observaciones']).",paisID = ".Limpia($_POST['paisFiscal']).",estadoID = ".Limpia($_POST['estadoFiscal']).",ciudadID = ".Limpia($_POST['ciudadFiscal'])." WHERE id = ".Limpia($_POST['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Proveedor ha sido modificado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ("location: proveedores.php?OT=4");
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			/*mysql_query("DELETE FROM productos_prospectos WHERE prospectoID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM seguimientos WHERE prospectoID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM prospectos WHERE id = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM prospectos_contactos WHERE prospectoID = ".Limpia($_GET['ID']));
			header ("location: buscador.php?mod=Eliminar");*/
		}
		break;
	}
	case 'Pais':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$q = "INSERT INTO paises(nombre) VALUE (".Limpia($_POST['pais']).")";
			mysql_query($q);
			header ("location: configuracion.php");
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			$q = "UPDATE paises SET nombre = ".Limpia($_POST['pais'])." WHERE id = ".Limpia($_POST['ID']);
			mysql_query($q);
			header ("location: configuracion.php");
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$q0 = "SELECT id FROM estados WHERE paisID = ".Limpia($_GET['ID']);
			$r0 = mysql_query($q0);
			if (mysql_num_rows($r0) > 0)
			{
				$_SESSION['systemAlertTEXT'] = 'El Pais no puede ser Eliminado porque esta relacionado con uno o Varios Estados y/o Clientes';
				$_SESSION['systemAlertTYPE'] = 'Alerta';
				header ("location: configuracion.php");
			}
			else
			{
				mysql_query("DELETE FROM paises WHERE id = ".Limpia($_GET['ID']));
				header ("location: configuracion.php");
			}
		}
		break;
	}
	case 'Estado':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$q = "INSERT INTO estados(nombre,paisID) VALUE (".Limpia($_POST['estado']).",".Limpia($_POST['pais']).")";
			mysql_query($q);
			header ("location: configuracion.php?Ver=Estado&ID=".$_POST['pais']);
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			$q1 = "SELECT paisID FROM estados WHERE id = ".Limpia($_POST['ID']);
			$r1 = mysql_query($q1);
			$reg1 = mysql_fetch_array($r1);
			$q = "UPDATE estados SET nombre = ".Limpia($_POST['estado'])." WHERE id = ".Limpia($_POST['ID']);
			mysql_query($q);
			header ("location: configuracion.php?Ver=Estado&ID=".$reg1['paisID']);
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$q1 = "SELECT paisID FROM estados WHERE id = ".Limpia($_GET['ID']);
			$r1 = mysql_query($q1);
			$reg1 = mysql_fetch_array($r1);
			$q0 = "SELECT id FROM ciudades WHERE estadoID = ".Limpia($_GET['ID']);
			$r0 = mysql_query($q0);
			if (mysql_num_rows($r0) > 0)
			{
				$_SESSION['systemAlertTEXT'] = 'El Estado no puede ser Eliminado porque esta relacionado con uno o Varios Ciudades y/o Clientes';
				$_SESSION['systemAlertTYPE'] = 'Alerta';
				header ("location: configuracion.php?Ver=Estado&ID=".$reg1['paisID']);
			}
			else
			{
				mysql_query("DELETE FROM estados WHERE id = ".Limpia($_GET['ID']));
				header ("location: configuracion.php?Ver=Estado&ID=".$reg1['paisID']);
			}
		}
		break;
	}
	case 'Ciudad':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$q = "INSERT INTO ciudades(nombre,estadoID) VALUE (".Limpia($_POST['ciudad']).",".Limpia($_POST['estado']).")";
			mysql_query($q);
			header ("location: configuracion.php?Ver=Ciudad&ID=".$_POST['estado']);
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			$q1 = "SELECT estadoID FROM ciudades WHERE id = ".Limpia($_POST['ID']);
			$r1 = mysql_query($q1);
			$reg1 = mysql_fetch_array($r1);
			$q = "UPDATE ciudades SET nombre = ".Limpia($_POST['ciudad'])." WHERE id = ".Limpia($_POST['ID']);
			mysql_query($q);
			header ("location: configuracion.php?Ver=Ciudad&ID=".$reg1['estadoID']);
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$q1 = "SELECT estadoID FROM ciudades WHERE id = ".Limpia($_GET['ID']);
			$r1 = mysql_query($q1);
			$reg1 = mysql_fetch_array($r1);
			$q0 = "SELECT id FROM prospectos WHERE ciudadID = ".Limpia($_GET['ID']);
			$r0 = mysql_query($q0);
			if (mysql_num_rows($r0) > 0)
			{
				$_SESSION['systemAlertTEXT'] = 'La Ciudad no puede ser Eliminada porque esta relacionada con uno o Varios Clientes';
				$_SESSION['systemAlertTYPE'] = 'Alerta';
				header ("location: configuracion.php?Ver=Ciudad&ID=".$reg1['estadoID']);
			}
			else
			{
				mysql_query("DELETE FROM ciudades WHERE id = ".Limpia($_GET['ID']));
				header ("location: configuracion.php?Ver=Ciudad&ID=".$reg1['estadoID']);
			}
		}
		break;
	}
	case 'Sucursal':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO config_sucursales(nombre,frontera) VALUE (".Limpia($_POST['nombre']).",".Limpia($_POST['frontera']).")");
			$_SESSION['systemAlertTEXT'] = 'La Sucursal ha sido registrada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=Sucursales&OT=9');
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE config_sucursales SET nombre = ".Limpia($_POST['nombre']).", frontera = ".Limpia($_POST['frontera'])." WHERE id = ".Limpia($_POST['ID']));
			$_SESSION['systemAlertTEXT'] = 'La Sucursal ha sido editada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=Sucursales&OT=9');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$q1 = "SELECT combo FROM valores_combos WHERE id = ".Limpia($_GET['ID']);
			$r1 = mysql_query($q1);
			$reg1 = mysql_fetch_array($r1);
			mysql_query("DELETE FROM valores_combos WHERE id = ".Limpia($_GET['ID']));
			header ("location: configuracion.php?mod=Combo&Ver=".$reg1['combo']);
		}
		break;
	}
	case 'Categoria':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$q = "INSERT INTO categorias (nombre,categoriaID) VALUES (".Limpia($_POST['categoria']).",".Limpia($_POST['categoriaID']).")";
			mysql_query($q);
			if ($_POST['categoriaID'] == 0)
			{
				header("Location: configuracion.php?mod=Productos");
			}
			else
			{
				header("Location: configuracion.php?mod=Productos&Ver=Categorias&catID=".$_POST['categoriaID']);
			}
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			$q = "UPDATE categorias SET nombre = ".Limpia($_POST['categoria'])." WHERE id = ".Limpia($_POST['ID']);
			mysql_query($q);
			header ("location: ".$_SERVER['HTTP_REFERER']);
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$q0 = "SELECT id FROM categorias WHERE categoriaID = ".Limpia($_GET['ID']);
			$r0 = mysql_query($q0);
			$q1 = "SELECT id FROM productos WHERE categoriaID = ".Limpia($_GET['ID']);
			$r1 = mysql_query($q1);
			if (mysql_num_rows($r0) > 0 or mysql_num_rows($r1) > 0)
			{
				 $_SESSION['systemAlertTEXT'] = 'La Categoria no puede ser Eliminada porque esta relacionada con uno o Varios Subcategorias y/o Productos';
				 $_SESSION['systemAlertTYPE'] = 'Alerta';
				 header("Location: configuracion.php?mod=Productos");
			}
			else
			{
				mysql_query("DELETE FROM categorias WHERE id = ".Limpia($_GET['ID']));
				header("Location: configuracion.php?mod=Productos");
			}
		}
		break;
	}
	case 'Producto':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$r = mysql_query("SELECT id FROM productos WHERE upc = '".$_POST['upc']."'");
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				header('Location: productos.php?OT=3&ID='.$reg['id']);
			}
			else
			{
				mysql_query("INSERT INTO productos (upc) VALUE (".Limpia($_POST['upc']).")");
				$IDProducto = mysql_insert_id();
				$_SESSION['systemAlertTEXT'] = 'El Producto no ha sido dado de alta o esta inactivo';
				$_SESSION['systemAlertTYPE'] = 'Alerta';
				header('Location: productos.php?OT=3&ID='.$IDProducto);
			}
		}
		elseif ($_GET['acc'] == "Editar")
		{
			mysql_query("UPDATE productos SET upc = ".Limpia($_POST['upc']).",clave = ".Limpia($_POST['clave']).",nombre = ".Limpia($_POST['nombre']).",descripcion = ".Limpia($_POST['descripcion']).",costoActual = ".Limpia($_POST['costo']).",precio1 = ".Limpia($_POST['precio1']).",precio2 = ".Limpia($_POST['precio2']).",precio3 = ".Limpia($_POST['precio3']).",precio4 = ".Limpia($_POST['precio4']).",precio5 = ".Limpia($_POST['precio5']).",factorConversion = ".Limpia($_POST['conversion']).",activo = 1,proveedorID = ".Limpia($_POST['proveedor']).",categoriaID = ".Limpia($_POST['categoria']).",unidadEntradaID = ".Limpia($_POST['uEntrada']).",unidadSalidaID = ".Limpia($_POST['uSalida'])." WHERE id = ".Limpia($_POST['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Producto ha sido modificado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header('Location: productos.php?mod=Imagenes&ID='.$_POST['ID'].'&OT=3');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$q0 = "SELECT id FROM productos_cotizaciones WHERE generalID = ".Limpia($_GET['ID']);
			$r0 = mysql_query($q0);
			if (mysql_num_rows($r0) > 0)
			{
				 $_SESSION['systemAlertTEXT'] = 'El Producto no puede ser Eliminado porque esta relacionado con una o Varias Cotizaciones y/o Pedidos';
				 $_SESSION['systemAlertTYPE'] = 'Alerta';
				 header("Location: configuracion.php?mod=Productos");
			}
			else
			{
				mysql_query("DELETE FROM productos WHERE id = ".Limpia($_GET['ID']));
				header("Location: configuracion.php?mod=Productos");
			}
		}
		elseif ($_GET['acc'] == 'Importar')
		{
			$tipos = array(".XLS");
			$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],".")));
			if (in_array($extension,$tipos))
			{
				if (move_uploaded_file($_FILES['archivo']['tmp_name'],'temp/productos.xls'))
				{
					require_once ('include/php-excel-reader/reader.php');
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('temp/productos.xls');
					for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++)
					{
						$arrRegistros[$i] = array('categoria' => trim($data->sheets[0]['cells'][$i][1]), 'upc' => trim($data->sheets[0]['cells'][$i][2]), 'clave' => trim($data->sheets[0]['cells'][$i][3]), 'nombre' => trim($data->sheets[0]['cells'][$i][4]), 'descripcion' => trim($data->sheets[0]['cells'][$i][5]), 'precio1' => trim($data->sheets[0]['cells'][$i][6]), 'precio2' => trim($data->sheets[0]['cells'][$i][7]), 'precio3' => trim($data->sheets[0]['cells'][$i][8]), 'precio4' => trim($data->sheets[0]['cells'][$i][9]), 'precio5' => trim($data->sheets[0]['cells'][$i][10]), 'factorConversion' => trim($data->sheets[0]['cells'][$i][11]), 'proveedor' => trim($data->sheets[0]['cells'][$i][12]), 'uSalida' => trim($data->sheets[0]['cells'][$i][13]), 'uEntrada' => trim($data->sheets[0]['cells'][$i][14]), 'activo' => trim($data->sheets[0]['cells'][$i][15]));
					}
					$i = 0;
					foreach ($arrRegistros as $k => $v)
					{
						if ($v['upc'] <> '')
						{
							$r = mysql_query("SELECT id FROM productos_proveedores WHERE UPPER(nombreComercial) = '".strtoupper($v['proveedor'])."'");
							if (mysql_num_rows($r) <= 0)
							{
								mysql_query("INSERT INTO productos_proveedores (nombreComercial,razonSocial) VALUES ('".$v['proveedor']."','".$v['proveedor']."')");
								$IDProveedor = mysql_insert_id();
							}
							else
							{
								$reg = mysql_fetch_array($r);
								$IDProveedor = $reg['id'];
							}
							$r = mysql_query("SELECT id FROM productos_categorias WHERE UPPER(nombre) = '".strtoupper($v['categoria'])."'");
							if (mysql_num_rows($r) <= 0)
							{
								mysql_query("INSERT INTO productos_categorias (nombre) VALUE ('".$v['categoria']."')");
								$IDCategoria = mysql_insert_id();
							}
							else
							{
								$reg = mysql_fetch_array($r);
								$IDCategoria = $reg['id'];
							}
							$r = mysql_query("SELECT id FROM productos_unidades WHERE UPPER(nombre) = '".strtoupper($v['uEntrada'])."'");
							if (mysql_num_rows($r) <= 0)
							{
								mysql_query("INSERT INTO productos_unidades (nombre) VALUE ('".$v['uEntrada']."')");
								$IDUEntrada = mysql_insert_id();
							}
							else
							{
								$reg = mysql_fetch_array($r);
								$IDUEntrada = $reg['id'];
							}
							$r = mysql_query("SELECT id FROM productos_unidades WHERE UPPER(nombre) = '".strtoupper($v['uSalida'])."'");
							if (mysql_num_rows($r) <= 0)
							{
								mysql_query("INSERT INTO productos_unidades (nombre) VALUE ('".$v['uSalida']."')");
								$IDUSalida = mysql_insert_id();
							}
							else
							{
								$reg = mysql_fetch_array($r);
								$IDUSalida = $reg['id'];
							}
							$r = mysql_query("SELECT id FROM productos WHERE UPPER(upc) = '".strtoupper($v['upc'])."'");
							if (mysql_num_rows($r) <= 0)
							{
								mysql_query("INSERT INTO productos (upc,clave,nombre,descripcion,precio1,precio2,precio3,precio4,precio5,factorConversion,activo,proveedorID,categoriaID,unidadEntradaID,unidadSalidaID) VALUES ('".$v['upc']."','".$v['clave']."','".$v['nombre']."','".$v['descripcion']."','".$v['precio1']."','".$v['precio2']."','".$v['precio3']."','".$v['precio4']."','".$v['precio5']."',".$v['factorConversion'].",".$v['activo'].",".$IDProveedor.",".$IDCategoria.",".$IDUEntrada.",".$IDUSalida.")");
							}
							else
							{
								$reg = mysql_fetch_array($r);
								mysql_query("UPDATE productos SET clave = '".$v['clave']."',nombre = '".$v['nombre']."',descripcion = '".$v['descripcion']."',precio1 = '".$v['precio1']."',precio2 = '".$v['precio2']."',precio3 = '".$v['precio3']."',precio4 = '".$v['precio4']."',precio5 = '".$v['precio5']."',factorConversion = ".$v['factorConversion'].",activo = ".$v['activo'].",proveedorID = ".$IDProveedor.",categoriaID = ".$IDCategoria.",unidadEntradaID = ".$IDUEntrada.",unidadSalidaID = ".$IDUSalida." WHERE id = ".$reg['id']);
							}
							$i++;
						}
					}
					unlink ('temp/productos.xls');
					$_SESSION['systemAlertTEXT'] = 'Se importaron '.$i.' productos exitosamente';
					$_SESSION['systemAlertTYPE'] = 'Aviso';
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir el Archivo al servidor';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El archivo que intentas subir No es Valido';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header("Location: importaDatos.php?mod=Productos&OT=9");
		}
		break;
	}
	case 'ImagenProducto':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$tipos = array('.JPG','.GIF','.PNG');
			$directorio = 'imagenes/productos/';
			$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],".")));
			if (in_array($extension,$tipos))
			{
				$ID = 1;
				$r = mysql_query("SELECT id FROM productos_imagenes ORDER BY id DESC LIMIT 1");
				if (mysql_num_rows($r) > 0) { $reg = mysql_fetch_array($r); $ID = $reg['id'] + 1; }
				
				foreach ($tipos as $k => $v)
				{
					if ($extension == $v)
					{
						$temp = "temp".$ID.strtolower($extension);
						$img = "img".$ID.strtolower($extension);
					}
				}
				if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$temp))
				{
					ReDimensionaImagen($temp,$img,600,800,$directorio);
					unlink($directorio.$temp);
					mysql_query("INSERT INTO productos_imagenes (archivo,productoID) VALUES ('".$img."',".Limpia($_POST['ID']).")");
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir el Archivo al servidor';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El Archivo que intentas subir no esta en un formato valido';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header('Location: productos.php?mod=Imagenes&ID='.$_POST['ID'].'&OT=4');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$r = mysql_query("SELECT archivo,productoID FROM productos_imagenes WHERE id = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				 $reg = mysql_fetch_array($r);
				 if (file_exists('../imagenes/productos/'.$reg['archivo'])) { unlink ('../imagenes/productos/'.$reg['archivo']); }
			}
			header('Location: productos.php?mod=Imagenes&ID='.$reg['productoID']);
		}
		break;
	}
	case 'Usuario':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO config_usuarios(nombre,username,password,facturacion,perfilID,sucursalID) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['username']).",MD5('".$_POST['password']."'),".Limpia($_POST['facturacion']).",".Limpia($_POST['perfil']).",".Limpia($_POST['sucursal']).")");
			$_SESSION['systemAlertTEXT'] = 'El Usuario ha sido registrado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ("location: usuarios.php?OT=9");
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			$q = "UPDATE config_usuarios SET nombre = ".Limpia($_POST['nombre']).", username = ".Limpia($_POST['username']);
			if ($_POST['mPassword'] == 1)
			{
				$q .= ", password = MD5('".$_POST['password']."')";
			}
			$q .= ", facturacion = ".Limpia($_POST['facturacion']).", perfilID = ".Limpia($_POST['perfil']).", sucursalID = ".Limpia($_POST['sucursal'])." WHERE id = ".Limpia($_POST['ID']);
			mysql_query($q);
			$_SESSION['systemAlertTEXT'] = 'El Usuario ha sido modificado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ("location: usuarios.php?OT=9");
		}
		elseif ($_GET['acc'] == 'Suspender')
		{
			mysql_query("UPDATE config_usuarios SET activo = NOT(activo) WHERE id = ".Limpia($_GET['ID']));
			header ("location: usuarios.php?mod=Lista&OT=9");
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			mysql_query("DELETE FROM usuarios WHERE id = ".Limpia($_GET['ID']));
			header ("location: usuarios.php");
		}
		break;
	}
	case 'Inventario':
	{
		if ($_GET['acc'] == 'Entrada')
		{
			foreach ($_POST as $k => $v)
			{
				if (strpos($k,'cantidad_') === 0 and trim($v) <> '' and is_numeric($v))
				{
					$ID = substr($k,strpos($k,'_') + 1);
					//echo "SELECT factorConversion FROM productos WHERE id = ".$ID.'<br>';
					$r = mysql_query("SELECT factorConversion FROM productos WHERE id = ".$ID);
					$reg = mysql_fetch_array($r);
					$cantidad = $v * $reg['factorConversion'];
					//echo "INSERT INTO productos_movimientos_inventario (cantidad,descripcion,productoID,usuarioID) VALUES ('".$cantidad."','Entrada de Mercancia',".$ID.",".$_SESSION['usuarioID'].")<br>";
					mysql_query("INSERT INTO productos_movimientos_inventario (cantidad,descripcion,productoID,usuarioID) VALUES ('".$cantidad."','Entrada de Mercancia',".$ID.",".$_SESSION['usuarioID'].")");
					//echo "SELECT id FROM productos_existencias WHERE productoID = ".$ID." AND sucursalID = ".$_SESSION['usuarioSUCURSAL'].'<br>';
					$r = mysql_query("SELECT id FROM productos_existencias WHERE productoID = ".$ID." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
					if (mysql_num_rows($r) > 0)
					{
						$reg = mysql_fetch_array($r);
						mysql_query("UPDATE productos_existencias SET cantidad = cantidad + ".$cantidad." WHERE id = ".$reg['id']);
					}
					else
					{
						mysql_query("INSERT INTO productos_existencias (cantidad,productoID,sucursalID) VALUES ('".$cantidad."',".$ID.",".$_SESSION['usuarioSUCURSAL'].")");
					}
				}
			}
			$_SESSION['systemAlertTEXT'] = 'La Entrada ha sido registrada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('location: inventario.php?mod=Entrada&OT=4');
		}
		elseif ($_GET['acc'] == 'Ajuste')
		{
			foreach ($_POST as $k => $v)
			{
				if (strpos($k,'cantidad_') === 0 and trim($v) <> '' and is_numeric($v))
				{
					$ID = substr($k,strpos($k,'_') + 1);
					$existencia = 0;
					$r = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$ID." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
					if (mysql_num_rows($r) > 0)
					{
						$reg = mysql_fetch_array($r);
						$existencia = $reg['cantidad'];
					}
					mysql_query("INSERT INTO productos_movimientos_inventario (cantidad,descripcion,productoID,usuarioID) VALUES ('".abs($existencia - $v)."','Ajuste de Inventario: ".$_POST['motivo_'.$ID]."',".$ID.",".$_SESSION['usuarioID'].")");
					mysql_query("UPDATE productos_existencias SET cantidad = ".$v." WHERE productoID = ".$ID." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				}
			}
			$_SESSION['systemAlertTEXT'] = 'El Ajuste ha sido registrado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('location: inventario.php?mod=Ajuste&OT=4');
		}
		break;
	}
	case 'Venta':
	{
		if ($_GET['acc'] == 'AddFirst')
		{
			$r = mysql_query("SELECT id FROM productos WHERE upc = '".$_POST['upc']."'");
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				if ($_POST['clienteID'] == 0) { $_POST['clienteID'] = 'NULL'; }
				mysql_query("INSERT INTO ventas (porcentajeDescuento,porcentajeIva,clienteID,usuarioID,sucursalID) VALUES (0,".$_SESSION['IVASucursalAmNetPV2012'].",".$_POST['clienteID'].",".$_SESSION['usuarioID'].",".$_SESSION['usuarioSUCURSAL'].")");
				$IDVenta = mysql_insert_id();
				$listaPrecios = 'precio1';
				if ($_POST['clienteID'] > 0)
				{
					$r1 = mysql_query("SELECT listaPrecios FROM clientes WHERE id = ".$_POST['clienteID']);
					$reg1 = mysql_fetch_array($r1);
					$listaPrecios = 'precio'.$reg1['listaPrecios'];
				}
				$r1 = mysql_query("SELECT ".$listaPrecios." AS precio FROM productos WHERE id = ".$reg['id']);
				$reg1 = mysql_fetch_array($r1);
				$estatus = 2;
				$r2 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r2) > 0)
				{
					$reg2 = mysql_fetch_array($r2);
					if ($reg2['cantidad'] > 0)
					{
						$estatus = 1;
						mysql_query("UPDATE productos_existencias SET cantidad = cantidad - 1 WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
					}
				}
				mysql_query("INSERT INTO ventas_partidas (cantidad,precio,estatus,productoID,ventaID) VALUES (1,".$reg1['precio'].",".$estatus.",".$reg['id'].",".$IDVenta.")");
				if ($reg2['cantidad'] > 0)
				{
					$iva = $reg1['precio'] - ($reg1['precio'] / (1 + ($_SESSION['IVASucursalAmNetPV2012'] / 100)));
					$subtotal = $reg1['precio'] - $iva;
					mysql_query("UPDATE ventas SET subtotal = ".$subtotal.", iva = ".$iva." WHERE id = ".$IDVenta);
				}
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El UPC no esta relacionado con ningun producto';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'Add')
		{
			$r = mysql_query("SELECT id FROM productos WHERE upc = '".$_POST['upc']."'");
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				$r1 = mysql_query("SELECT id,porcentajeIva,clienteID FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
				$reg1 = mysql_fetch_array($r1);
				$listaPrecios = 'precio1';
				if ($reg1['clienteID'] <> NULL)
				{
					$r2 = mysql_query("SELECT listaPrecios FROM clientes WHERE id = ".$reg1['clienteID']);
					$reg2 = mysql_fetch_array($r2);
					$listaPrecios = 'precio'.$reg2['listaPrecios'];
				}
				$r2 = mysql_query("SELECT ".$listaPrecios." AS precio FROM productos WHERE id = ".$reg['id']);
				$reg2 = mysql_fetch_array($r2);
				$estatus = 2;
				$r3 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r3) > 0)
				{
					$reg3 = mysql_fetch_array($r3);
					if ($reg3['cantidad'] > 0)
					{
						$estatus = 1;
						mysql_query("UPDATE productos_existencias SET cantidad = cantidad - 1 WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
					}
				}
				$r3 = mysql_query("SELECT id FROM ventas_partidas WHERE productoID = ".$reg['id']." AND ventaID = ".$reg1['id']." AND estatus = ".$estatus);
				if (mysql_num_rows($r3) > 0 and $estatus > 0)
				{
					$reg3 = mysql_fetch_array($r3);
					mysql_query("UPDATE ventas_partidas SET cantidad = cantidad + 1 WHERE id = ".$reg3['id']);
				}
				else
				{
					mysql_query("INSERT INTO ventas_partidas (cantidad,precio,estatus,productoID,ventaID) VALUES (1,".$reg2['precio'].",".$estatus.",".$reg['id'].",".$reg1['id'].")");
				}
				$total = 0;
				$r2 = mysql_query("SELECT cantidad,precio FROM ventas_partidas WHERE estatus = 1 AND ventaID = ".$reg1['id']);
				if (mysql_num_rows($r2) > 0)
				{
					while ($reg2 = mysql_fetch_array($r2))
					{
						$total += $reg2['cantidad'] * $reg2['precio'];
					}
				}
				$descuento = $total * ($reg1['porcentajeDescuento'] / 100);
				$total = $total - $descuento;
				$iva = $total - ($total / (1 + ($_SESSION['IVASucursalAmNetPV2012'] / 100)));
				$subtotal = $total - $iva;
				mysql_query("UPDATE ventas SET subtotal = ".$subtotal.", descuento = ".$descuento.", iva = ".$iva." WHERE id = ".$reg1['id']);
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El UPC no esta relacionado con ningun producto';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'Edita')
		{
			$r1 = mysql_query("SELECT id,porcentajeIva,porcentajeDescuento FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
			$reg1 = mysql_fetch_array($r1);
			$r2 = mysql_query("SELECT cantidad,precio,productoID,ventaID FROM ventas_partidas WHERE id = ".$_GET['ID']);
			$reg2 = mysql_fetch_array($r2);
			$cantidad = $_GET['cantidad'] - $reg2['cantidad'];
			if ($cantidad > 0)
			{
				$r3 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg2['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r3) > 0)
				{
					$reg3 = mysql_fetch_array($r3);
					if ($reg3['cantidad'] >= $cantidad)
					{
						mysql_query("UPDATE productos_existencias SET cantidad = cantidad - ".$cantidad." WHERE productoID = ".$reg2['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
						mysql_query("UPDATE ventas_partidas SET cantidad = ".$_GET['cantidad']." WHERE id = ".$_GET['ID']);
					}
					elseif ($reg3['cantidad'] > 0)
					{
						$cantidadBO = $cantidad - $reg3['cantidad'];
						mysql_query("UPDATE productos_existencias SET cantidad = 0 WHERE productoID = ".$reg2['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
						mysql_query("UPDATE ventas_partidas SET cantidad = cantidad + ".$reg3['cantidad']." WHERE id = ".$_GET['ID']);
						$r4 = mysql_query("SELECT id FROM ventas_partidas WHERE productoID = ".$reg2['productoID']." AND ventaID = ".$reg2['ventaID']." AND estatus = 2");
						if (mysql_num_rows($r4) > 0)
						{
							$reg4 = mysql_fetch_array($r4);
							mysql_query("UPDATE ventas_partidas SET cantidad = cantidad + ".$cantidadBO." WHERE id = ".$reg4['id']);
						}
						else
						{
							mysql_query("INSERT INTO ventas_partidas (cantidad,precio,estatus,productoID,ventaID) VALUES (".$cantidadBO.",".$reg2['precio'].",2,".$reg2['productoID'].",".$reg2['ventaID'].")");
						}
					}
					else
					{
						
						$r4 = mysql_query("SELECT id FROM ventas_partidas WHERE productoID = ".$reg2['productoID']." AND ventaID = ".$reg2['ventaID']." AND estatus = 2");
						if (mysql_num_rows($r4) > 0)
						{
							$reg4 = mysql_fetch_array($r4);
							mysql_query("UPDATE ventas_partidas SET cantidad = cantidad + ".$cantidad." WHERE id = ".$reg4['id']);
						}
						else
						{
							mysql_query("INSERT INTO ventas_partidas (cantidad,precio,estatus,productoID,ventaID) VALUES (".$cantidad.",".$reg2['precio'].",2,".$reg2['productoID'].",".$reg2['ventaID'].")");
						}
					}
				}
			}
			elseif ($cantidad < 0)
			{
				mysql_query("UPDATE productos_existencias SET cantidad = cantidad - ".$cantidad." WHERE productoID = ".$reg2['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				mysql_query("UPDATE ventas_partidas SET cantidad = ".$_GET['cantidad']." WHERE id = ".$_GET['ID']);
			}
			$total = 0;
			$r3 = mysql_query("SELECT cantidad,precio FROM ventas_partidas WHERE estatus = 1 AND ventaID = ".$reg1['id']);
			if (mysql_num_rows($r3) > 0)
			{
				while ($reg3 = mysql_fetch_array($r3))
				{
					$total += $reg3['cantidad'] * $reg3['precio'];
				}
			}
			$descuento = $total * ($reg1['porcentajeDescuento'] / 100);
			$total = $total - $descuento;
			$iva = $total - ($total / (1 + ($_SESSION['IVASucursalAmNetPV2012'] / 100)));
			$subtotal = $total - $iva;
			mysql_query("UPDATE ventas SET subtotal = ".$subtotal.", descuento = ".$descuento.", iva = ".$iva." WHERE id = ".$reg1['id']);
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'Cancela')
		{
			$r1 = mysql_query("SELECT id,porcentajeIva,porcentajeDescuento FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
			$reg1 = mysql_fetch_array($r1);
			$r2 = mysql_query("SELECT cantidad,productoID,ventaID FROM ventas_partidas WHERE id = ".$_GET['ID']);
			$reg2 = mysql_fetch_array($r2);
			mysql_query("UPDATE productos_existencias SET cantidad = cantidad + ".$reg2['cantidad']." WHERE productoID = ".$reg2['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
			mysql_query("UPDATE ventas_partidas SET estatus = 0 WHERE id = ".$_GET['ID']);
			$total = 0;
			$r3 = mysql_query("SELECT cantidad,precio FROM ventas_partidas WHERE estatus = 1 AND ventaID = ".$reg1['id']);
			if (mysql_num_rows($r3) > 0)
			{
				while ($reg3 = mysql_fetch_array($r3))
				{
					$total += $reg3['cantidad'] * $reg3['precio'];
				}
			}
			$descuento = $total * ($reg1['porcentajeDescuento'] / 100);
			$total = $total - $descuento;
			$iva = $total - ($total / (1 + ($_SESSION['IVASucursalAmNetPV2012'] / 100)));
			$subtotal = $total - $iva;
			mysql_query("UPDATE ventas SET subtotal = ".$subtotal.", descuento = ".$descuento.", iva = ".$iva." WHERE id = ".$reg1['id']);
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'Descuento')
		{
			$r1 = mysql_query("SELECT id,porcentajeIva FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
			$reg1 = mysql_fetch_array($r1);
			$total = 0;
			$r3 = mysql_query("SELECT cantidad,precio FROM ventas_partidas WHERE estatus = 1 AND ventaID = ".$reg1['id']);
			if (mysql_num_rows($r3) > 0)
			{
				while ($reg3 = mysql_fetch_array($r3))
				{
					$total += $reg3['cantidad'] * $reg3['precio'];
				}
			}
			$descuento = $total * ($_GET['descuento'] / 100);
			$total = $total - $descuento;
			$iva = $total - ($total / (1 + ($_SESSION['IVASucursalAmNetPV2012'] / 100)));
			$subtotal = $total - $iva;
			mysql_query("UPDATE ventas SET subtotal = ".$subtotal.", porcentajeDescuento = ".$_GET['descuento'].", descuento = ".$descuento.", iva = ".$iva." WHERE id = ".$reg1['id']);
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'FormaPago')
		{
			$r1 = mysql_query("SELECT id FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
			$reg1 = mysql_fetch_array($r1);
			mysql_query("UPDATE ventas SET formaPagoID = ".$_GET['formaPago']." WHERE id = ".$reg1['id']);
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'MontoPago')
		{
			$r1 = mysql_query("SELECT id,subtotal,iva FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
			$reg1 = mysql_fetch_array($r1);
			if ($_GET['montoPago'] >= ($reg1['subtotal'] + $reg1['iva']))
			{
				mysql_query("UPDATE ventas SET montoPago = ".$_GET['montoPago']." WHERE id = ".$reg1['id']);
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El Monto del Pago no puede ser menor que el Total a Pagar';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'Cancelar')
		{
			$r = mysql_query("SELECT id FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
			$reg = mysql_fetch_array($r);
			$r1 = mysql_query("SELECT cantidad,productoID FROM ventas_partidas WHERE ventaID = ".$reg['id']." WHERE estatus = 1");
			if (mysql_num_rows($r1) > 0)
			{
				while ($reg1 = mysql_fetch_array($r1))
				{
					mysql_query("UPDATE productos_existencias SET cantidad = cantidad + ".$reg1['cantidad']." WHERE productoID = ".$reg1['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				}
			}
			mysql_query("UPDATE ventas SET cerrada = 1, cancelada = 1 WHERE id = ".$reg['id']);
			$_SESSION['systemAlertTEXT'] = 'La Venta ha sido Cancelada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('location: venta.php');
		}
		elseif ($_GET['acc'] == 'Cerrar')
		{
			if (isset($_GET['password']))
			{
				$r1 = mysql_query("SELECT id FROM config_usuarios WHERE username = ".Limpia($_GET['username'])." AND password = MD5('".$_GET['password']."') AND perfilID = 1");
				if (mysql_num_rows($r1) > 0)
				{
					$reg1 = mysql_fetch_array($r1);
					$r = mysql_query("SELECT id,subtotal,iva,montoPago FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
					$reg = mysql_fetch_array($r);
					if ($reg['montoPago'] == 0) { mysql_query("UPDATE ventas SET montoPago = ".($reg['subtotal'] + $reg['iva'])." WHERE id = ".$reg['id']); }
					mysql_query("UPDATE ventas SET cerrada = 1, autorizoID = ".$reg1['id']." WHERE id = ".$reg['id']);
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'Los datos de autorizacion no coinciden con ningun administrador registrado';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			else
			{
				$r = mysql_query("SELECT id,subtotal,iva,montoPago FROM ventas WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrada = 0");
				$reg = mysql_fetch_array($r);
				if ($reg['montoPago'] == 0) { mysql_query("UPDATE ventas SET montoPago = ".($reg['subtotal'] + $reg['iva'])." WHERE id = ".$reg['id']); }
				mysql_query("UPDATE ventas SET cerrada = 1 WHERE id = ".$reg['id']);
			}
			header ('location: ticket.php?ID='.$reg['id']);
		}
		break;
	}
	case 'Servicio':
	{
		if ($_GET['acc'] == 'AddFirst')
		{
			$r = mysql_query("SELECT id FROM productos WHERE upc = '".$_POST['upc']."'");
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				$r1 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r1) > 0)
				{
					$reg1 = mysql_fetch_array($r1);
					if ($reg1['cantidad'] > 0)
					{
						mysql_query("INSERT INTO servicios (usuarioID,sucursalID) VALUES (".$_SESSION['usuarioID'].",".$_SESSION['usuarioSUCURSAL'].")");
						$ID = mysql_insert_id();
						mysql_query("UPDATE productos_existencias SET cantidad = cantidad - 1 WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
						mysql_query("INSERT INTO servicios_partidas (cantidad,productoID,servicioID) VALUES (1,".$reg['id'].",".$ID.")");
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'El producto que intentas agregar a la salida de mercancia no tiene existencia en el inventario';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'El producto que intentas agregar a la salida de mercancia no tiene existencia en el inventario';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El UPC no esta relacionado con ningun producto';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header ('location: salida.php?OT=4');
		}
		elseif ($_GET['acc'] == 'Add')
		{
			$r = mysql_query("SELECT id FROM productos WHERE upc = '".$_POST['upc']."'");
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				$r1 = mysql_query("SELECT id FROM servicios WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrado = 0");
				$reg1 = mysql_fetch_array($r1);
				$r2 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r2) > 0)
				{
					$reg2 = mysql_fetch_array($r2);
					if ($reg2['cantidad'] > 0)
					{
						mysql_query("UPDATE productos_existencias SET cantidad = cantidad - 1 WHERE productoID = ".$reg['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
						$r3 = mysql_query("SELECT id FROM servicios_partidas WHERE productoID = ".$reg['id']." AND servicioID = ".$reg1['id']);
						if (mysql_num_rows($r3) > 0)
						{
							$reg3 = mysql_fetch_array($r3);
							mysql_query("UPDATE servicios_partidas SET cantidad = cantidad + 1 WHERE id = ".$reg3['id']);
						}
						else
						{
							mysql_query("INSERT INTO servicios_partidas (cantidad,productoID,servicioID) VALUES (1,".$reg['id'].",".$reg1['id'].")");
						}
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'El producto que intentas agregar a la salida de mercancia no tiene existencia en el inventario';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'El producto que intentas agregar a la salida de mercancia no tiene existencia en el inventario';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
                         			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El UPC no esta relacionado con ningun producto';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header ('location: salida.php?OT=4');
		}
		elseif ($_GET['acc'] == 'Edita')
		{
			$r = mysql_query("SELECT id FROM servicios WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrado = 0");
			$reg = mysql_fetch_array($r);
			$r1 = mysql_query("SELECT cantidad,productoID FROM servicios_partidas WHERE id = ".$_GET['ID']);
			$reg1 = mysql_fetch_array($r1);
			$cantidad = $_GET['cantidad'] - $reg1['cantidad'];
			if ($cantidad > 0)
			{
				$r2 = mysql_query("SELECT cantidad FROM productos_existencias WHERE productoID = ".$reg1['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r2) > 0)
				{
					$reg2 = mysql_fetch_array($r2);
					if ($reg2['cantidad'] >= $cantidad)
					{
						mysql_query("UPDATE productos_existencias SET cantidad = cantidad - ".$cantidad." WHERE productoID = ".$reg1['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
						mysql_query("UPDATE servicios_partidas SET cantidad = ".$_GET['cantidad']." WHERE id = ".$_GET['ID']);
					}
					elseif ($reg2['cantidad'] > 0)
					{
						mysql_query("UPDATE productos_existencias SET cantidad = 0 WHERE productoID = ".$reg1['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
						mysql_query("UPDATE servicios_partidas SET cantidad = cantidad + ".$reg2['cantidad']." WHERE id = ".$_GET['ID']);
						$_SESSION['systemAlertTEXT'] = 'El producto que intentas agregar a la salida de mercancia no tiene existencia suficiente en el inventario';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'El producto que intentas agregar a la salida de mercancia no tiene existencia en el inventario';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
			}
			elseif ($cantidad < 0)
			{
				mysql_query("UPDATE productos_existencias SET cantidad = cantidad - ".$cantidad." WHERE productoID = ".$reg1['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				mysql_query("UPDATE servicios_partidas SET cantidad = ".$_GET['cantidad']." WHERE id = ".$_GET['ID']);
			}
			header ('location: salida.php?OT=4');
		}
		elseif ($_GET['acc'] == 'Cancela')
		{
			$r1 = mysql_query("SELECT id FROM servicios WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrado = 0");
			$reg1 = mysql_fetch_array($r1);
			$r2 = mysql_query("SELECT cantidad,productoID,servicioID FROM servicios_partidas WHERE id = ".$_GET['ID']);
			$reg2 = mysql_fetch_array($r2);
			mysql_query("UPDATE productos_existencias SET cantidad = cantidad + ".$reg2['cantidad']." WHERE productoID = ".$reg2['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
			mysql_query("DELETE FROM servicios_partidas WHERE id = ".$_GET['ID']);
			header ('location: salida.php?OT=4');
		}
		elseif ($_GET['acc'] == 'Cancelar')
		{
			$r = mysql_query("SELECT id FROM servicios WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrado = 0");
			$reg = mysql_fetch_array($r);
			$r1 = mysql_query("SELECT cantidad,productoID FROM servicios_partidas WHERE ventaID = ".$reg['id']." WHERE estatus = 1");
			if (mysql_num_rows($r1) > 0)
			{
				while ($reg1 = mysql_fetch_array($r1))
				{
					mysql_query("UPDATE productos_existencias SET cantidad = cantidad + ".$reg1['cantidad']." WHERE productoID = ".$reg1['productoID']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				}
			}
			mysql_query("UPDATE ventas SET cerrado = 1, cancelado = 1 WHERE id = ".$reg['id']);
			$_SESSION['systemAlertTEXT'] = 'La Salida de Mercancia ha sido Cancelada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('location: salida.php?OT=4');
		}
		elseif ($_GET['acc'] == 'Cerrar')
		{
			$r = mysql_query("SELECT id FROM servicios WHERE usuarioID = ".$_SESSION['usuarioID']." AND cerrado = 0");
			$reg = mysql_fetch_array($r);
			mysql_query("UPDATE servicios SET cerrado = 1 WHERE id = ".$reg['id']);
			header ('location: ticketServicio.php?ID='.$reg['id']);
		}
		break;
	}
	case 'Factura':
	{
		$tipos = array('.JPG','.GIF');
		$directorio = 'imagenes/codigos/';
		if ($_GET['acc'] == 'Crear')
		{
			if (isset($_POST['facturaDia']) and $_POST['facturaDia'] == 1)
			{
				$fecha = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
				$total = 0;
				$iva = 0;
				$r = mysql_query("SELECT id,subtotal,descuento,iva FROM ventas WHERE fecha >= '".$fecha." 00:00:00' AND fecha <= '".$fecha." 23:59:59' AND clienteID IS NULL AND facturaID IS NULL AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
				if (mysql_num_rows($r) > 0)
				{
					while ($reg = mysql_fetch_array($r))
					{
						$total += $reg['subtotal'];
						$iva += $reg['iva'];
						mysql_query("UPDATE ventas SET facturaID = ".Limpia($_POST['folio'])." WHERE id = ".$reg['id']);
					}
				}
				mysql_query("INSERT INTO facturas (id,fecha,subtotal,descuento,iva,metodoPagoID,estatusID) VALUE (".Limpia($_POST['folio']).",'".date('Y-m-d')."',".$total.",0,".$iva.",2,2)");
			}
			else
			{
				$arrDatos = explode('_',$_POST['Concepto']);
				$concepto = 'NULL';
				if (isset($_POST['Alternativo']) and trim($_POST['Alternativo']) <> '') { $concepto = Limpia($_POST['Alternativo']); }
				$digitosCuenta = 'NULL';
				if ($_POST['metodoPago'] >= 3) { $digitosCuenta = Limpia($_POST['cuenta']); }
				
				if ($arrDatos[0] == 'Servicio')
				{
					$r = mysql_query("SELECT precio FROM servicios WHERE id = ".Limpia($arrDatos[1]));
					$reg = mysql_fetch_array($r);
					$subtotal = $reg['precio'];
					$descuento = 0;
					$iva = $reg['precio'] * (IVA / 100);
					mysql_query("UPDATE servicios SET estatusID = 4, facturaID = ".Limpia($_POST['folio'])." WHERE id = ".Limpia($arrDatos[1]));
				}
				else
				{
					$r = mysql_query("SELECT subtotal,descuento,iva FROM ventas WHERE id = ".Limpia($arrDatos[1]));
					$reg = mysql_fetch_array($r);
					$subtotal = $reg['subtotal'];
					$descuento = $reg['descuento'];
					$iva = $reg['iva'];
					mysql_query("UPDATE ventas SET facturaID = ".Limpia($_POST['folio'])." WHERE id = ".Limpia($arrDatos[1]));
				}
				
				mysql_query("INSERT INTO facturas (id,fecha,concepto,subtotal,descuento,iva,digitosCuenta,metodoPagoID,clienteID,datosFiscalesID) VALUE (".Limpia($_POST['folio']).",".Limpia($_POST['fecha']).",".$concepto.",".$subtotal.",".$descuento.",".$iva.",".$digitosCuenta.",".Limpia($_POST['metodoPago']).",".Limpia($_POST['clienteID']).",".Limpia($_POST['datosFactura']).")");
			}
			header ('Location: imprimeFactura.php?ID='.$_POST['folio']);
		}
		elseif ($_GET['acc'] == 'Folios')
		{
			if(!isset($_POST['nuevosFolios']) or $_POST['nuevosFolios'] == 1)
			{
				mysql_query("UPDATE facturas_folios SET vigente = 0");
				mysql_query("INSERT INTO facturas_folios (fechaAprobacion,folioInicial,folioFinal,noSicofi) VALUES (".Limpia($_POST['fecha']).",".Limpia($_POST['folioInicial']).",".Limpia($_POST['folioFinal']).",".Limpia($_POST['numeroSicofi']).")");
				$ID = mysql_insert_id();
				if ($_FILES['codigo']['name'] <> '')
				{
					$extension = strtoupper(substr($_FILES['codigo']['name'],strrpos($_FILES['codigo']['name'],'.')));
					if (in_array($extension,$tipos))
					{
						foreach ($tipos as $k => $v)
						{
							if ($extension == $v)
							{
								$img = 'codigo'.$ID.strtolower($extension);
							}
						}
						if (move_uploaded_file($_FILES['codigo']['tmp_name'],$directorio.$img))
						{
							mysql_query("UPDATE facturas_folios SET cbb = '".$img."' WHERE id = ".$ID);
						}
						else
						{
							$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir el Codigo Bidimensional al servidor';
							$_SESSION['systemAlertTYPE'] = 'Error';
						}
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'La Imagen que intentas subir no esta en un formato valida';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
			}
			else
			{
				mysql_query("UPDATE facturas_folios SET fechaAprobacion = ".Limpia($_POST['fecha']).",folioInicial = ".Limpia($_POST['folioInicial']).", folioFinal = ".Limpia($_POST['folioFinal']).", numeroSicofi= ".Limpia($_POST['numeroSicofi'])." WHERE vigente = 1");
				if ($_FILES['codigo']['name'] <> '')
				{
					$r = mysql_query("SELECT id,cbb FROM facturas_folios WHERE vigente = 1");
					$reg = mysql_fetch_array($r);
					$ID = $reg['id'];
					$extension = strtoupper(substr($_FILES['codigo']['name'],strrpos($_FILES['codigo']['name'],".")));
					if (in_array($extension,$tipos))
					{
						foreach ($tipos as $k => $v)
						{
							if ($extension == $v)
							{
								$img = 'codigo'.$ID.strtolower($extension);
							}
						}
						if (file_exists($directorio.$reg['cbb'])) { unlink ($directorio.$reg['cbb']); }
						if (move_uploaded_file($_FILES['codigo']['tmp_name'],$directorio.$img))
						{
							mysql_query("UPDATE facturas_folios SET cbb = '".$img."' WHERE id = ".$ID);
						}
						else
						{
							$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir la Imagen al servidor';
							$_SESSION['systemAlertTYPE'] = 'Error';
						}
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'La Imagen que intentas subir no esta en un formato valido';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
			}
			header('Location: facturacion.php?mod=Folios&OT=5');
			break;
		}
		break;
	}
	case 'Reporte':
	{
		if ($_POST['ID'] == 4)
		{
			$_SESSION['PVAmNetUserCC'] = $_POST['usuario'];
			header ('Location: corteCaja.php');
		}
		else
		{
			$_SESSION['PVAmNetReporte'] = $_POST['ID'];
			$_SESSION['PVAmNetTipoReporte'] = $_POST['tipoReporte'];
			$_SESSION['PVAmNetVendedor'] = $_POST['vendedor'];
			if ($_POST['ID'] == 1)
			{
				if ($_POST['tipoReporte'] == 1) { $_SESSION['PVAmNetReporteFecha'] = $_POST['fecha']; }
				if ($_POST['tipoReporte'] == 5) { $_SESSION['PVAmNetReporteFecha1'] = $_POST['fecha1']; $_SESSION['PVAmNetReporteFecha2'] = $_POST['fecha2']; }
				if ($_POST['tipoReporte'] == 6) { $_SESSION['PVAmNetReporteProducto'] = $_POST['upc']; }
			}
			elseif ($_POST['ID'] == 2)
			{
				$_SESSION['PVAmNetReporteSucursal'] = $_POST['sucursal'];
				if ($_POST['tipoReporte'] == 1) { $_SESSION['PVAmNetReporteProducto'] = $_POST['upc']; }
				if ($_POST['tipoReporte'] == 2) { $_SESSION['PVAmNetReporteProveedor'] = $_POST['proveedor']; }
				if ($_POST['tipoReporte'] == 3) { $_SESSION['PVAmNetReporteCategoria'] = $_POST['categoria']; $_SESSION['PVAmNetReporteProveedor'] = $_POST['proveedor']; }
			}
			elseif ($_POST['ID'] == 3)
			{
				$_SESSION['PVAmNetReporteProducto'] = $_POST['upc'];
				if ($_POST['tipoReporte'] == 1) { $_SESSION['PVAmNetReporteFecha'] = $_POST['fecha']; }
				if ($_POST['tipoReporte'] == 5) { $_SESSION['PVAmNetReporteFecha1'] = $_POST['fecha1']; $_SESSION['PVAmNetReporteFecha2'] = $_POST['fecha2']; }
			}
			header ('Location: getReporte.php');
		}
		break;
	}
	case 'Marca':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO config_vehiculos_marcas(nombre) VALUE (".Limpia($_POST['nombre']).")");
			$_SESSION['systemAlertTEXT'] = 'La Marca ha sido registrada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=Marcas&OT=9');
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE config_vehiculos_marcas SET nombre = ".Limpia($_POST['nombre'])." WHERE id = ".Limpia($_POST['ID']));
			$_SESSION['systemAlertTEXT'] = 'La Marca ha sido editada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=Marcas&OT=9');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			mysql_query("UPDATE config_vehiculos_marcas SET activo = 0 WHERE id = ".Limpia($_GET['ID']));
			$_SESSION['systemAlertTEXT'] = 'La Marca ha sido eliminada';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=Marcas&OT=9');
		}
		break;
	}
	case 'Modelo':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO config_vehiculos_modelos(nombre,marcaID) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['ID']).")");
			$_SESSION['systemAlertTEXT'] = 'El Modelo ha sido registrado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=Modelos&ID='.$_POST['ID'].'&OT=9');
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE config_vehiculos_modelos SET nombre = ".Limpia($_POST['nombre'])." WHERE id = ".Limpia($_POST['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Modelo ha sido editado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			$r = mysql_query("SELECT marcaID FROM config_vehiculos_modelos WHERE id = ".Limpia($_POST['ID']));
			$reg = mysql_fetch_array($r);
			header ('Location: configuracion.php?mod=Modelos&ID='.$reg['marcaID'].'&OT=9');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			mysql_query("UPDATE config_vehiculos_modelos SET activo = 0 WHERE id = ".Limpia($_GET['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Modelo ha sido eliminado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			$r = mysql_query("SELECT marcaID FROM config_vehiculos_modelos WHERE id = ".Limpia($_POST['ID']));
			$reg = mysql_fetch_array($r);
			header ('Location: configuracion.php?mod=Modelos&ID='.$reg['marcaID'].'&OT=9');
		}
		break;
	}
	case 'ManoObra':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO config_mano_obra(nombre,duracion,costo,categoriaID) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['duracion']).",".Limpia($_POST['precio']).",".Limpia($_POST['categoria']).")");
			$_SESSION['systemAlertTEXT'] = 'El Recurso ha sido registrado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=ManoObra&OT=9');
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE config_mano_obra SET nombre = ".Limpia($_POST['nombre']).", duracion = ".Limpia($_POST['duracion']).", costo = ".Limpia($_POST['precio']).", categoriaID = ".Limpia($_POST['categoria'])." WHERE id = ".Limpia($_POST['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Recurso ha sido editado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=ManoObra&OT=9');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			mysql_query("UPDATE config_mano_obra SET activo = 0 WHERE id = ".Limpia($_GET['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Recurso ha sido eliminado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=ManoObra&OT=9');
		}
		break;
	}
	case 'Paquete':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO productos_paquetes(nombre,precio) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['precio']).")");
			$ID = mysql_insert_id();
			if (isset($_SESSION['ajaxCestaPartidas']))
			{
				foreach ($_SESSION['ajaxCestaPartidas'] as $k => $v)
				{
					mysql_query("INSERT INTO productos_paquetes_partidas (cantidad,recursoID,tipo,paqueteID) VALUES (".$v['cantidad'].",".$v['id'].",".$v['tipo'].",".$ID.")");
				}
			}
			unset($_SESSION['ajaxCestaPartidas']);
			$_SESSION['systemAlertTEXT'] = 'El Paquete ha sido registrado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=Paquetes&OT=9');
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE config_mano_obra SET nombre = ".Limpia($_POST['nombre']).", duracion = ".Limpia($_POST['duracion']).", costo = ".Limpia($_POST['precio']).", categoriaID = ".Limpia($_POST['categoria'])." WHERE id = ".Limpia($_POST['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Recurso ha sido editado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=ManoObra&OT=9');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			mysql_query("UPDATE config_mano_obra SET activo = 0 WHERE id = ".Limpia($_GET['ID']));
			$_SESSION['systemAlertTEXT'] = 'El Recurso ha sido eliminado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: configuracion.php?mod=ManoObra&OT=9');
		}
		break;
	}
	case 'OrdenServicio':
	{
		if ($_GET['acc'] == 'Crear')
		{
			if (isset($_POST['clienteID']) and isset($_POST['automovil']) and isset($_SESSION['ajaxCestaServicio']) and count($_SESSION['ajaxCestaServicio']) > 0)
			{
				mysql_query("INSERT INTO servicios(precio,duracion,clienteID,vehiculoID,usuarioID,sucursalID) VALUES (0,0,".Limpia($_POST['clienteID']).",".Limpia($_POST['automovil']).",".Limpia($_SESSION['usuarioID']).",".Limpia($_SESSION['usuarioSUCURSAL']).")");
				$ID = mysql_insert_id();
				$arrPaquetes = array();
				$total = 0;
				$duracion = 0;
				foreach ($_SESSION['ajaxCestaServicio'] as $k => $v)
				{
					mysql_query("INSERT INTO servicios_partidas (cantidad,precio,tipo,recursoID,paqueteID,servicioID) VALUES (".$v['cantidad'].",".$v['precio'].",".$v['tipo'].",".$v['id'].",".$v['paqueteID'].",".$ID.")");
					if ($v['paqueteID'] <> 0 and !array_key_exists($v['paqueteID'],$arrPaquetes))
					{
						$arrPaquetes[$v['paqueteID']] = $v['paqueteID'];
						$total += $v['precio'];
					}
					else
					{
						$total += ($v['cantidad'] * $v['precio']);
					}
					$duracion += $v['duracion'];
					if ($v['tipo'] == 2)
					{
						$r = mysql_query("SELECT id FROM productos_existencias WHERE productoID = ".$v['id']." AND sucursalID = ".$_SESSION['usuarioSUCURSAL']);
						if (mysql_num_rows($r) > 0)
						{
							$reg = mysql_fetch_array($r);
							mysql_query("UPDATE productos_existencias SET cantidad = cantidad - ".$v['cantidad']." WHERE id = ".$reg['id']);
						}
						else
						{
							mysql_query("INSERT INTO productos_existencias (cantidad,productoID,sucursalID) VALUES (-".$v['cantidad'].",".$v['id'].",".$_SESSION['usuarioSUCURSAL'].")");
						}
					}
				}
				mysql_query("UPDATE servicios SET precio = ".$total.", duracion = ".$duracion." WHERE id = ".$ID);
				unset($_SESSION['ajaxCestaServicio']);
				$_SESSION['systemAlertTEXT'] = 'La Orden de Servicio ha sido registrada con el No. de Folio <b>'.sprintf('%06d',$ID).'</b>';
				$_SESSION['systemAlertTYPE'] = 'Aviso';
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'La Orden de Servicio no puede ser registrada por falta de datos.';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header ('Location: ordenServicio.php');
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE servicios SET estatusID = ".Limpia($_GET['estatus'])." WHERE id = ".Limpia($_GET['ID']));
			$_SESSION['systemAlertTEXT'] = 'El estatus fue actualizado';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
			header ('Location: ordenServicio.php?mod=Editar&ID='.$_GET['ID']);
		}
		break;
	}
	case 'Seguimiento':
	{
		mysql_query("INSERT INTO servicios_seguimientos(seguimiento,usuarioID,servicioID) VALUE (".Limpia($_POST['seguimiento']).",".$_SESSION['usuarioID'].",".Limpia($_POST['ID']).")");
		header ("location: ordenServicio.php?mod=Editar&ID=".$_POST['ID']);
		break;
	}
}
?>