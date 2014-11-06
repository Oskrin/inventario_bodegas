<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
include '../menus/menu.php';

////////////////numero factura//////////////////
include '../procesos/base.php';
conectarse();
error_reporting(0);

$consulta = pg_query("select num_factura from factura_venta");
while ($row = pg_fetch_row($consulta)) {
    $num_factura = $row[0];
}
/////////////////////////////////////////////
/////////////////contador factura venta///////////
$cont1 = 0;
$consulta2 = pg_query("select max(id_factura_venta) from factura_venta");
while ($row = pg_fetch_row($consulta2)) {
    $cont1 = $row[0];
}
$cont1++;
///////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:FACTURA VENTA:.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 
        <link rel="stylesheet" type="text/css" href="../css/buttons.css"/>
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.4.custom.css"/>    
        <link rel="stylesheet" type="text/css" href="../css/normalize.css"/>    
        <link rel="stylesheet" type="text/css" href="../css/ui.jqgrid.css"/> 
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
        <link href="../css/font-awesome.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/link_top.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/alertify.core.css" />
        <link rel="stylesheet" href="../css/alertify.default.css" id="toggleCSS" />
        <link href="../css/sm-core-css.css" rel="stylesheet" type="text/css" />
        <link href="../css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-loader.js"></script>
        <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/grid.locale-es.js"></script>
        <script type="text/javascript" src="../js/jquery.jqGrid.src.js"></script>
        <script type="text/javascript" src="../js/buttons.js" ></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/factura_venta.js"></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../js/guidely/guidely.min.js"></script>
        <script type="text/javascript" src="../js/easing.js" ></script>
        <script type="text/javascript" src="../js/jquery.ui.totop.js" ></script>
        <script type="text/javascript" src="../js/jquery.smartmenus.js"></script>
        <script type="text/javascript" src="../js/alertify.min.js"></script>
        <script type="text/javascript" src="../js/ruc_jquery_validator.min.js"></script>
    </head>

    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">

                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <a class="brand" href="">
                        <h1><?php echo $_SESSION['empresa']; ?></h1>				
                    </a>
                </div>
            </div>
        </div> 

        <!-- /Inicio  Menu Principal -->
        <div class="subnavbar">
            <div class="subnavbar-inner">
                <?Php
                // Cabecera Menu 
                if ($_SESSION['cargo'] == '1') {
                    print menu_1();
                }
                if ($_SESSION['cargo'] == '2') {
                    print menu_2();
                }
                if ($_SESSION['cargo'] == '3') {
                    print menu_3();
                }
                ?> 
            </div> 
        </div> 
        <!-- /Fin  Menu Principal -->

        <div class="main">
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">      		
                            <div class="widget ">
                                <div class="widget-header">
                                    <i class="icon-list-alt"></i>
                                    <h3>FACTURA VENTA</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <div class="widget-content">
                                            <div class="widget big-stats-container">
                                                <form id="formularios_fac" name="formularios_fac" method="post" class="form-horizontal">
                                                    <fieldset>
                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label for="comprobante" style="width: 100%">Comprobante Nro:</label></td>   
                                                                <td><input type="text" name="comprobante" id="comprobante" class="campo" readonly style="width: 80px" value="<?php echo $cont1 ?>" /></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Fecha:</label></td>
                                                                <td><input type="text" name="fecha_actual" id="fecha_actual" class="campo" readonly style="margin-left: 5px; width: 100px" value="<?php echo date("Y-m-d"); ?>" /></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Hora:</label></td>
                                                                <td><input type="text" name="hora_actual" id="hora_actual" class="campo" readonly style="margin-left: 5px; width: 100px"/></td>
                                                                <td><label for="proforma" style="width: 100%; margin-left: 10px">Proforma Nro:</label></td>   
                                                                <td><input type="text" name="proforma" id="proforma" class="campo" style="margin-left: 5px; width: 100px"/></td>
                                                                <td><input type="hidden" name="comprobante2" id="comprobante2" class="campo" style="width: 100px" value="<?php echo $cont1 ?>" /></td>
                                                            </tr>  
                                                        </table>  

                                                        <hr style="color: #0056b2;" /> 

                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Digitador (a): </label></td>
                                                                <td><input type="text" name="digitador" id="digitador" value="<?php echo $_SESSION['nombres'] ?>" class="campo" style="width: 200px" readonly/></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Nro de Factura Preimpresa: </label></td>
                                                                <td><label style="width: 100%; margin-left: 10px">001  - </label></td>
                                                                <td><label style="width: 100%; margin-left: 10px">001  - </label></td>
                                                                <td><input type="text" name="num_factura" id="num_factura" class="campo" style="width: 100px" /></td>
                                                                <td><input type="hidden" name="num_oculto" id="num_oculto" class="campo" style="width: 150px" value="<?php echo $num_factura ?>" /></td>
                                                                <td><div id="estado"><h3></h3></div></td>
                                                            </tr>  
                                                        </table>

                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Cédula Identidad/RUC: <font color="red">*</font></label></td>  
                                                                <td><input type="text" name="ruc_ci"  id="ruc_ci" placeholder="Buscar....." class="campo" style="width: 150px"/></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Nombres Completos del Cliente: <font color="red">*</font></label></td>
                                                                <td><input type="text" name="nombre_cliente" id="nombre_cliente" class="campo" style="width: 250px"/></td>
                                                            </tr>  
                                                        </table>

                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Dirección: <font color="red">*</font></label></td>  
                                                                <td><input type="text" name="direccion_cliente" id="direccion_cliente" class="campo" style="width: 250px" /></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Teléfono: </label></td>  
                                                                <td><input type="text" name="telefono_cliente" id="telefono_cliente" class="campo" style="width: 120px; margin-left: 5px" /></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Correo: </label></td>  
                                                                <td><input type="text" name="correo" id="correo" class="campo" style="margin-left: 5px" /></td>
                                                                <td><input type="hidden" name="id_cliente" id="id_cliente" class="campo" style="width: 120px; margin-left: 5px" /></td>
                                                        </table>

                                                        <table cellpadding="2" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Fecha Cancelación: <font color="red">*</font></label></td>
                                                                <td><input type="text" name="cancelacion" id="cancelacion" class="campo" style="width: 150px" value="<?php echo date("Y-m-d"); ?>" readonly/></td>
                                                                <td><label for="tipo_precio" style="width: 100%">Tipo de Precio: <font color="red">*</font></label></td>  
                                                                <td><select id="tipo_precio" name="tipo_precio" style="width: 180px">
                                                                        <option value="MINORISTA">MINORISTA</option>
                                                                        <option value="MAYORISTA">MAYORISTA</option>
                                                                    </select></td>
                                                            </tr>  
                                                        </table>

                                                        <table cellpadding="2" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label for="autorizacion"  style="width: 100%">Autorización: </label></td>
                                                                <td><input type="text" name="autorizacion" id="autorizacion" class="campo" maxlength="45"/></td>
                                                                <td><label for="fecha_auto" style="margin-left: 10px">Fecha autorización:</label></td>
                                                                <td><input type="text" name="fecha_auto" id="fecha_auto" class="campo" style="width: 120px; margin-left: 5px" value="<?php echo date("Y-m-d"); ?>" readonly /></td>
                                                                <td><label for="fecha_caducidad" style="margin-left: 10px">Fecha caducidad:</label></td>
                                                                <td><input type="text" name="fecha_caducidad" id="fecha_caducidad" class="campo" style="width: 120px; margin-left: 5px" value="<?php echo date("Y-m-d"); ?>" readonly /></td>
                                                            </tr>
                                                        </table>

                                                        <table cellpadding="2" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label for="formas"  style="width: 100%">Formas de Pago:</label></td>
                                                                <td><select name="formas" id="formas">
                                                                        <option value="Contado">Contado</option>
                                                                        <option value="Credito">Crédito</option>
                                                                        <option value="Cheque">Cheque</option>
                                                                    </select> </td>
                                                                <td><label for="adelanto" style="margin-left: 10px">Adelanto:</label></td>
                                                                <td><input type="text" name="adelanto" id="adelanto" class="campo" placeholder="$0.00" style="width: 120px"/></td>
                                                                <td><label for="meses" style="margin-left: 10px">Meses:</label></td>
                                                                <td><input type="text" name="meses" id="meses"  class="campo" style="width: 100px"/></td>
                                                                <td><label for="cuotas" style="margin-left: 10px">Cuotas:</label></td>
                                                                <td><select id="cuotas" name="cuotas" style="width: 100px"></select></td>
                                                            </tr>
                                                        </table>

                                                        <hr style="color: #0056b2;" /> 
                                                        <p>Detalle de la factura</p>
                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label>Código:</label></td>   
                                                                <td><label>Producto:</label></td>   
                                                                <td><label>Cantidad:</label></td>   
                                                                <td><label style="width: 100%">P. Venta:</label></td>
                                                                <td><label>Descuento:</label></td>
                                                                <td><label>Disponibles:</label></td>
                                                            </tr>

                                                            <tr>
                                                                <td><input type="text" name="codigo" id="codigo" class="campo" style="width: 180px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="producto" id="producto" class="campo" style="width: 200px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="cantidad" id="cantidad" class="campo" style="width: 60px" maxlength="10"/></td>
                                                                <td><input type="text" name="p_venta" id="p_venta" style="width: 60px" class="campo" maxlength="10"/></td>
                                                                <td><input type="text" name="descuento" id="descuento" class="campo" readonly style="width: 60px" maxlength="10" placeholder="%" /></td>
                                                                <td><input type="text" name="disponibles" id="disponibles" class="campo" readonly style="width: 60px" maxlength="10" value=""/></td>
                                                                <!--<td><input type="button" class="btn btn-primary" id='btncargar' style="margin-top: -10px" value="Cargar"></td>-->
                                                                <td><input type="hidden" name="iva_producto" id="iva_producto" class="campo" /></td>
                                                                <td><input type="hidden" name="carga_series" id="carga_series" class="campo" /></td>
                                                                <td><input type="hidden" name="cod_producto" id="cod_producto" class="campo" /></td>
                                                                <td><input type="hidden" name="des" id="des" class="campo"/></td>
                                                                <td><input type="hidden" name="inventar" id="inventar" class="campo" /></td>
                                                            </tr>
                                                        </table>

                                                        <div style="margin-left: 10px">
                                                            <table id="list"></table>
                                                        </div>

                                                        <table border="0" cellspacing="2" style="margin-left: 625px">
                                                            <tr>
                                                                <td><label for="total_p" style="width: 100%">Tarifa 0:</label></td>
                                                                <td><input type="text" style="width:80px" name="total_p" id="total_p" readonly value="0.00" class="campo"/></td>
                                                            </tr>    
                                                            <tr>
                                                                <td><label for="total_p2" style="width: 100%" >Tarifa  12:</label></td>
                                                                <td><input type="text" style="width: 80px" name="total_p2" id="total_p2" readonly value="0.00" class="campo"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="iva" style="width:100%" >12 %Iva:</label></td>
                                                                <td><input type="text" style="width:80px" name="iva" id="iva" readonly value="0.00" class="campo"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="desc" style="width: 100%" >Descuentos:</label></td>
                                                                <td><input type="text" style="width: 80px" name="desc" id="desc" value="0.00" class="campo" readonly/></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="tot" style="width:100%" >Total:</label></td>
                                                                <td><input type="text" style="width:80px" name="tot" id="tot" readonly value="0.00" class="campo" /></td>
                                                            </tr>
                                                        </table> 
                                                    </fieldset>
                                                </form>

                                                <div id="series" title="AGREGAR SERIES">
                                                    <table cellpadding="2" border="0" style="margin-left: 10px">
                                                        <tr>
                                                            <td><label>Series: <font color="red">*</font></label></td>
                                                            <td><div class="ui-widget"><select name="combobox" id="combobox" class="campo">
                                                                        <option value=""></option>
                                                                    </select> </div></td>
                                                            <td><button class="btn btn-primary" id='btnAgregar' style="margin-top: -5px; margin-left: 50px"><i class="icon-list"></i> Agregar</button></td>
                                                        </tr>
                                                    </table>
                                                    <hr style="color: #0056b2;" /> 
                                                    <div align="center">
                                                        <table id="list3"><tr><td></td></tr></table>
                                                        <div class="form-actions">
                                                            <button class="btn btn-primary" id='btnGuardarSeries'><i class="icon-save"></i> Guardar</button>
                                                            <button class="btn btn-primary" id='btnCancelarSeries'><i class="icon-remove-sign"></i> Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="buscar_facturas_venta" title="BUSCAR FACTURAS VENTAS">

                                                    <table id="list2"><tr><td></td></tr></table>
                                                    <div id="pager2"></div>
                                                </div> 

                                                <div id="clave_permiso" title="PERMISOS">
                                                    <table border="0" >
                                                        <tr>
                                                            <td><label>Ingese la clave de seguridad</label></td> 
                                                            <td><input type="password" name="clave" id="clave" class="campo"></td>
                                                        </tr>  
                                                    </table>
                                                    <div class="form-actions" align="center">
                                                        <button class="btn btn-primary" id='btnAcceder'><i class="icon-ok"></i> Acceder</button>
                                                        <button class="btn btn-primary" id='btnCancelar'><i class="icon-remove-sign"></i> Cancelar</button>
                                                    </div>
                                                </div> 

                                                <div id="seguro">
                                                    <label>Esta seguro de Anular la factura</label>  
                                                    <br />

                                                    <button class="btn btn-primary" id='btnAceptar'><i class="icon-ok"></i> Aceptar</button>
                                                    <button class="btn btn-primary" id='btnSalir'><i class="icon-remove-sign"></i> Cancelar</button>
                                                </div>

                                                <div class="form-actions">
                                                    <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                                    <button class="btn btn-primary" id='btnModificar'><i class="icon-edit"></i> Modificar</button>
                                                    <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                                    <button class="btn btn-primary" id='btnNuevo'><i class="icon-pencil"></i> Nuevo</button>
                                                    <button class="btn btn-primary" id='btnAnular'><i class="icon-remove-circle"></i> Anular</button>
                                                    <button class="btn btn-primary" id='btnImprimir'><i class="icon-print"></i> Imprimir</button>
                                                    <button class="btn btn-primary" id='btnAtras'><i class="icon-step-backward"></i> Atras</button>
                                                    <button class="btn btn-primary" id='btnAdelante'>Adelante <i class="icon-step-forward"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
        <script type="text/javascript" src="../js/base.js"></script>
        <script type="text/javascript" src="../js/jquery.ui.datepicker-es.js"></script>

        <div class="footer">
            <div class="footer-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            &copy; 2014 <a href=""> <?php echo $_SESSION['empresa']; ?></a>.
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </body>
    <a href="" id="toTop" style="display: inline;">
        <span id="toTopHover" style="opacity: 0;"></span>
        "toTop"
    </a>
</html>