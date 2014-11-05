<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
include '../menus/menu.php';
////////////////comprobante ordenes//////////////////
include '../procesos/base.php';
conectarse();
error_reporting(0);


/////////////////contador produccion///////////
$cont1 = 0;
$consulta2 = pg_query("select max(id_ordenes) from ordenes_produccion");
while ($row = pg_fetch_row($consulta2)) {
    $cont1 = $row[0];
}
$cont1++;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:ORDENES DE PRODUCCIÓN:.</title>
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
        <script type="text/javascript" src="../js/produccion.js"></script>
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
                                    <h3>ORDENES DE PRODUCCIÓN</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <div class="widget-content">
                                            <div class="widget big-stats-container">
                                                <form id="ordenes_form" name="ordenes_form" method="post" class="form-horizontal">
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
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </fieldset>
                                                    <br />
                                                    <fieldset>
                                                        <div class="widget widget-nopad">
                                                            <div class="widget-header"> <i class="icon-list-alt"></i>
                                                                <h3>PRODUCTOS A REALIZAR</h3>
                                                            </div>
                                                            <!-- /widget-header -->
                                                            <div class="widget-content">
                                                                <div class="widget big-stats-container">
                                                                    <br />
                                                                    <table cellpadding="2" border="0" style="margin-left: 20px">
                                                                        <tr>
                                                                            <td><label style="width: 100%">Código: </label></td>
                                                                            <td><label style="width: 100%; margin-left: 10px">Producto: </label></td>  
                                                                            <td><label style="width: 100%; margin-left: 10px">Cantidad: </label></td>
                                                                            <td><label style="width: 100%; margin-left: 10px">Precio: </label></td>
                                                                            <td><label style="width: 100%; margin-left: 10px">Stock: </label></td>
                                                                        </tr>  
                                                                        <tr>
                                                                            <td><input type="text" name="codigo" id="codigo" class="campo" placeholder="Buscar..." style="width: 200px" /></td>
                                                                            <td><input type="text" name="producto" id="producto" class="campo" style="width: 200px"  placeholder="Buscar..."/></td>
                                                                            <td><input type="text" name="cantidad" id="cantidad" class="campo" style="width: 60px" /></td>
                                                                            <td><input type="text" name="precio_v" id="precio_v" class="campo" style="width: 60px" /></td>
                                                                            <td><input type="text" name="stock" id="stock" class="campo" style="width: 60px" /></td>
                                                                            <td><input type="hidden" name="cod_producto" id="cod_producto" class="campo" style="width: 100px" maxlength="10"/></td>
                                                                        </tr> 
                                                                    </table>
                                                                    <div style="margin-left: 20px">
                                                                        <table id="list2"></table>  
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="widget widget-nopad">
                                                            <div class="widget-header"> <i class="icon-list-alt"></i>
                                                                <h3>COMPONENTES</h3>
                                                            </div>
                                                            <!-- /widget-header -->
                                                            <div class="widget-content">
                                                                <div class="widget big-stats-container">
                                                                    <br />
                                                                    <table cellpadding="2" border="0" style="margin-left: 20px">
                                                                        <tr>
                                                                            <td><label>Código:</label></td>   
                                                                            <td><label>Producto:</label></td>   
                                                                            <td><label>Cantidad:</label></td>   
                                                                            <td><label style="width: 100%">P. Costo:</label></td>
                                                                            <td><label>Disponibles:</label></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td><input type="text" name="codigo2" id="codigo2" class="campo" style="width: 200px"  placeholder="Buscar..."/></td>
                                                                            <td><input type="text" name="producto2" id="producto2" class="campo" style="width: 200px"  placeholder="Buscar..."/></td>
                                                                            <td><input type="text" name="cantidad2" id="cantidad2" class="campo" style="width: 60px" maxlength="10"/></td>
                                                                            <td><input type="text" name="precio2" id="precio2" class="campo" style="width: 60px" maxlength="10"/></td>
                                                                            <td><input type="text" name="disponibles" id="disponibles" style="width: 60px" class="campo"/></td>
                                                                            <td><input type="hidden" name="cod_producto2" id="cod_producto2" class="campo" style="width: 100px" maxlength="10"/></td>
                                                                        </tr>
                                                                    </table>
                                                                    <div style="margin-left: 20px">
                                                                        <table id="list" ></table>
                                                                    </div>
                                                                    <div style="margin-left: 650px">
                                                                        <table border="0" cellspacing="2">
                                                                            <tr>
                                                                                <td><label for="subtot" style="width:100%" >SubTotal:</label></td>
                                                                                <td><input type="text" style="width:80px" name="subtot" id="subtot" readonly value="0.00" class="campo" /></td>
                                                                            </tr>
                                                                        </table> 
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </form>

                                                <div id="ordenes" title="Búsqueda de Ordenes" class="">
                                                    <table id="list3"><tr><td></td></tr></table>
                                                    <div id="pager3"></div>
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