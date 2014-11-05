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


/////////////////contador registro///////////
$cont1 = 0;
$consulta2 = pg_query("select max(id_registro) from registro_equipo");
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
        <title>.:INGRESO EQUIPOS:.</title>
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
        <link href="../css/sm-core-css.css" rel="stylesheet" type="text/css" />
        <link href="../css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../css/alertify.core.css" />
        <link rel="stylesheet" href="../css/alertify.default.css" id="toggleCSS" />

        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-loader.js"></script>
        <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/grid.locale-es.js"></script>
        <script type="text/javascript" src="../js/jquery.jqGrid.src.js"></script>
        <script type="text/javascript" src="../js/buttons.js" ></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/registroEquipo.js"></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../js/guidely/guidely.min.js"></script>
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
                                    <h3>EQUIPOS</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <fieldset>
                                            <form class="form-horizontal" id="formRegistroEquipo" name="formRegistroEquipo" method="post">
                                                <section class="columna1">
                                                    <div class="control-group">
                                                        <label class="control-label" for="txtRegistro">Nro.Registro</label>
                                                        <div class="controls" >
                                                            <input type="text" id="txtRegistro" name="txtRegistro" readonly class="campo" />
                                                            <input type="hidden" name="comprobante2" id="comprobante2" class="campo" style="width: 100px" value="<?php echo $cont1 ?>" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtIngreso">Fecha Ingreso: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" id="txtIngreso" name="txtIngreso" class="campo" value="<?php echo date("Y-m-d"); ?>" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtTipoEquipo">Tipo de Equipo: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" id="txtTipoEquipo" name="txtTipoEquipo" placeholder="Buscar...." class="campo" />
                                                            <input type="hidden" id="txtTipoEquipoId" name="txtTipoEquipoId" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtSerie">Nro. Serie:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtSerie" name="txtSerie" placeholder="Indique la Serie" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtMarca">Marca: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" id="txtMarca" name="txtMarca" placeholder="Buscar...." class="campo" />
                                                            <input type="hidden" id="txtMarcaId" name="txtMarcaId" class="campo"/>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtObservaciones">Observaciones:</label>
                                                        <div class="controls">
                                                            <textarea id="txtObservaciones" name="txtObservaciones" class="campo"></textarea>
                                                        </div>
                                                    </div>

                                                </section>

                                                <section class="columna2">
                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtCliente">Nombre Cliente <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" id="txtCliente" name="txtCliente" placeholder="Buscar...." class="campo" />
                                                            <input type="hidden" id="txtClienteId" name="txtClienteId" />
                                                        </div>			
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="tipo_cli">Fecha Salida: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" id="txtSalida" name="txtSalida" class="campo" value="<?php echo date("Y-m-d"); ?>"/>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtModelo">Modelo:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtModelo" name="txtModelo" placeholder="Indique el Modelo" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtColor">Color: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" id="txtColor" name="txtColor" placeholder="Buscar...." class="campo" />
                                                            <input type="hidden" id="txtColorId" name="txtColorId" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="email">Responsable:</label>
                                                        <div class="controls">
                                                            <input type="text" id="resp" name="resp" readonly value="<?php echo $_SESSION['nombres'] ?>" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtAccesorios">Accesorios:</label>
                                                        <div class="controls">
                                                            <textarea id="txtAccesorios" name="txtAccesorios" class="campo"></textarea>
                                                        </div>
                                                    </div>
                                                </section>
                                            </form>
                                        </fieldset>
                                        <div class="form-actions">
                                            <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                            <button class="btn btn-primary" id='btnModificar'><i class="icon-edit"></i> Modificar</button>
                                            <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                            <button class="btn btn-primary" id='btnNuevo'><i class="icon-pencil"></i> Nuevo</button>
                                            <button class="btn btn-primary" id='btnImprimir'><i class="icon-print"></i> Imprimir</button>
                                            <button class="btn btn-primary" id='btnAtras'><i class="icon-step-backward"></i> Atras</button>
                                            <button class="btn btn-primary" id='btnAdelante'>Adelante <i class="icon-step-forward"></i></button>
                                        </div>
                                        <div id="bRegistros" title="Búsqueda de Registros">
                                            <table id="list"></table>
                                            <div id="pager"></div>
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