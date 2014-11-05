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


/////////////////contador cuentas///////////
$cont1 = 0;
$consulta = pg_query("select max(id_cuentas_pagar) from pagos_pagar");
while ($row = pg_fetch_row($consulta)) {
    $cont1 = $row[0];
}
$cont1++;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:CUENTAS POR PAGAR:.</title>
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
        <script type="text/javascript" src="../js/cuentasxpagar.js"></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../js/guidely/guidely.min.js"></script>
        <script type="text/javascript" src="../js/easing.js" ></script>
        <script type="text/javascript" src="../js/jquery.ui.totop.js" ></script>
        <script type="text/javascript" src="../js/jquery.smartmenus.js"></script>
        <script type="text/javascript" src="../js/alertify.min.js"></script>
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
                        <?php echo $_SESSION['empresa']; ?>         
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
                                    <i class="icon-user"></i>
                                    <h3>CUENTAS POR PAGAR</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <div class="widget-content">
                                            <div class="widget big-stats-container">
                                                <form id="formularios_pag" name="formularios_pag" method="post" class="form-horizontal">
                                                    <fieldset>
                                                        <section class="columna_1">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="nombres_cli">Comprobante:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="comprobante" id="comprobante" readonly class="campo" value="<?php echo $cont1 ?>" style="width: 80px"/>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section class="columna_2">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="nombres_cli">Fecha Actual:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="fecha_actual" id="fecha_actual" readonly value="<?php echo date("Y-m-d"); ?>" class="campo" style="width: 100px" />
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section class="columna_3">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="nombres_cli">Hora Actual:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="hora_actual" id="hora_actual" readonly class="campo" style="width: 100px"/>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section class="columna_4">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="nombres_cli"> Digitad@r:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="digitador" id="digitador" value="<?php echo $_SESSION['nombres'] ?>" class="campo" style="width: 200px" readonly/>
                                                                    <input type="hidden" name="comprobante2" id="comprobante2" class="campo" style="width: 100px" value="<?php echo $cont1 ?>" />
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </fieldset>

                                                    <fieldset>
                                                        <legend></legend>
                                                        <section class="columna1">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="tipo_docu">Proveedor: <font color="red">*</font></label>
                                                                <div class="controls">
                                                                    <select name="tipo_docu" id="tipo_docu" required class="campo">
                                                                        <option value="">......Seleccione......</option>
                                                                        <option value="Cedula">Cedula</option>
                                                                        <option value="Ruc">Ruc</option>
                                                                        <option value="Pasaporte">Pasaporte</option>  
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">											
                                                                <label class="control-label" for="tipo_docu">Empresa: <font color="red">*</font></label>
                                                                <div class="controls">
                                                                    <input type="text" name="empresa" id="empresa" class="campo" placeholder="Empresa" style="width: 250px"/>
                                                                    <input type="hidden" name="id_proveedor" id="id_proveedor" class="campo" />
                                                                </div>
                                                            </div>

                                                            <div class="control-group">											
                                                                <label class="control-label" for="tipo_docu">Forma de pago: <font color="red">*</font></label>
                                                                <div class="controls">
                                                                    <select id="forma_pago" name="forma_pago" style="width: 180px">
                                                                        <option value="0">........SELECCIONE........</option>
                                                                        <option value="EFECTIVO">EFECTIVO</option>
                                                                        <option value="CHEQUE">CHEQUE</option>
                                                                        <option value="TARGETA">TARGETA</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section class="columna2">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="ruc_ci">Identificación: <font color="red">*</font></label>
                                                                <div class="controls">
                                                                    <input type="text" name="ruc_ci" id="ruc_ci" class="campo" placeholder="Buscar..."/>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">											
                                                                <label class="control-label" for="tipo_pago">Pago: <font color="red">*</font></label>
                                                                <div class="controls">
                                                                    <select id="tipo_pago" name="tipo_pago" style="width: 180px">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </fieldset>
                                                    <br />
                                                    <fieldset>
                                                        <legend>Facturas</legend>
                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><input type="button" class="btn btn-primary" id='btnfacturas' value="Buscar Facturas"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label>Nro de factura a pagar:</label></td>   
                                                                <td><label>Tipo Factura:</label></td>   
                                                                <td><label>Fecha de Factura:</label></td>   
                                                                <td><label style="width: 100%">Total CxC</label></td>
                                                                <td><label>Valor Pagado:</label></td>
                                                                <td><label>Saldo:</label></td>
                                                            </tr>

                                                            <tr>
                                                                <td><input type="text" name="num_factura" id="num_factura" class="campo" readonly style="width: 150px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="tipo_factura" id="tipo_factura" class="campo" readonly style="width: 150px" /></td>
                                                                <td><input type="text" name="fecha_factura" id="fecha_factura" class="campo" readonly style="width: 120px" maxlength="10"/></td>
                                                                <td><input type="text" name="totalcxc" id="totalcxc" readonly style="width: 80px"  class="campo"/></td>
                                                                <td><input type="text" name="valor_pagado" id="valor_pagado" class="campo" style="width: 80px" /></td>
                                                                <td><input type="text" name="saldo2" id="saldo2" class="campo" style="width: 80px" readonly /></td>
                                                                <td><input type="hidden" name="ids" id="ids" class="campo" style="width: 80px"/></td>
                                                            </tr>
                                                        </table>

                                                        <div style="margin-left: 10px">
                                                            <table id="list" ></table>
                                                            <table id="tablaNuevo" style="display: none; vertical-align: top; width: 250px; margin-left: 20px;" class="table table-striped table-bordered"  >
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 280px">Fecha Pagos</th>
                                                                        <th style="width: 200px">Monto</th>
                                                                        <th style="width: 200px">Saldo</th>
                                                                    </tr>   
                                                                </thead>
                                                                <tbody>
                                                                    <tr></tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div style="margin-left: 10px">
                                                            <table border="0" cellpadding="2">
                                                                <tr>
                                                                    <td><label>Observaciones:</label></td>
                                                                    <td><textarea name="observaciones" id="observaciones" class="campo" style="width: 300px; margin-top: 20px" ></textarea></td>
                                                                </tr> 
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                                <div id="buscar_facturas" title="BUSCAR FACTURAS">
                                                    <fieldset>
                                                        <table id="list2"><tr><td></td></tr></table>
                                                        <div id="pager2"></div>
                                                    </fieldset>
                                                </div> 

                                                <div id="buscar_cuentas_pagar" title="BUSCAR CUENTAS POR PAGAR">
                                                    <fieldset>
                                                        <table id="list3"><tr><td></td></tr></table>
                                                        <div id="pager3"></div>
                                                    </fieldset>
                                                </div> 

                                                <div class="form-actions">
                                                    <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                                    <button class="btn btn-primary" id='btnModificar'><i class="icon-edit"></i> Modificar</button>
                                                    <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                                    <button class="btn btn-primary" id='btnNuevo'><i class="icon-pencil"></i> Nuevo</button>
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
</html>