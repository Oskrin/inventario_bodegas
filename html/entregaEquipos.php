<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
include '../menus/menu.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:ENTREGA EQUIPO:.</title>
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
        <script type="text/javascript" src="../js/entregaEquipo.js"></script>
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

        <div class="main" >
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">      		
                            <div class="widget ">
                                <div class="widget-header">
                                    <i class="icon-user"></i>
                                    <h3>ENTREGA</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable" id="entregaP">
                                        <fieldset>
                                            <form class="form-horizontal" id="formEntrega" name="formEntrega" method="post">
                                                <section class="columna1">
                                                    <div class="control-group">
                                                        <label class="control-label" for="txtRegistro">Nro.Registro: </label>
                                                        <div class="controls" >
                                                            <input type="text" id="txtRegistro" name="txtRegistro" readonly class="campo" />
                                                        </div>  
                                                    </div>   

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtIngreso">Fecha Ingreso:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtIngreso" name="txtIngreso" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtTipoEquipo">Tipo de Equipo:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtTipoEquipo" name="txtTipoEquipo" class="campo" />
                                                            <input type="hidden" id="txtTipoEquipoId" name="txtTipoEquipoId" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtSerie">Nro. Serie:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtSerie" name="txtSerie" class="campo"/>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="txtMarca">Marca:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtMarca" name="txtMarca" class="campo" />
                                                            <input type="hidden" id="txtMarcaId" name="txtMarcaId" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="resp">Técnico Resp:</label>
                                                        <div class="controls">
                                                            <input type="text" id="resp" name="resp" readonly class="campo"/>  
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <div class="control-group">											
                                                            <label class="control-label" for="txtObservaciones">Observaciones:</label>
                                                            <div class="controls">
                                                                <textarea id="txtObservaciones" name="txtObservaciones" class="campo" style="width: 300px"></textarea>
                                                            </div>
                                                        </div> 
                                                    </div>

                                                    <div class="control-group">
                                                        <div class="control-group">											
                                                            <label class="control-label" for="txtAccesorios">Accesorios:</label>
                                                            <div class="controls">
                                                                <textarea id="txtAccesorios" name="txtAccesorios" class="campo" style="width: 300px"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <div class="control-group">											
                                                            <label class="control-label" for="txtReco">Recomendaciones:</label>
                                                            <div class="controls">
                                                                <textarea id="txtReco" name="txtReco" class="campo" style="width: 300px"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

                                                <section class="columna2">
                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtCliente">Nombre Cliente: </label>
                                                        <div class="controls">
                                                            <input type="text" id="txtCliente" name="txtCliente" class="campo" />
                                                            <input type="hidden" id="txtClienteId" name="txtClienteId" />   
                                                        </div>			
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtSalida">Fecha Salida:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtSalida" name="txtSalida" class="campo"  />  
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtModelo">Modelo:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtModelo" name="txtModelo" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="txtColor">Color:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtColor" name="txtColor" class="campo" />
                                                            <input type="hidden" id="txtColorId" name="txtColorId" class="campo"/>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="nombre_user">Ingresado Por:</label>
                                                        <div class="controls">
                                                            <input type="text" id="nombre_user" name="nombre_user" readonly class="campo" /> 
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="email">Total Pagar:</label>
                                                        <div class="controls">
                                                            <input type="text" id="txtTotal" name="txtTotal" readonly class="campo" /> 
                                                            <input type="hidden" id="txtTotal1" readonly class="campo"/> 
                                                        </div>
                                                    </div>
                                                </section>
                                            </form>
                                        </fieldset>

                                        <div class="widget-content" style="width: 600px; margin-left: 100px">
                                            <div class="widget big-stats-container">
                                                <div id="reparacionesTb">
                                                    <table id="tblRepracion" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>                
                                                                <th style="width:10%">Cantidad</th>
                                                                <th style="width:40%">Descripción</th>                        
                                                                <th style="width:25%">Valor Unitario</th>                        
                                                                <th style="width:25%">Valor Total</th>                        
                                                                <th style="width:10%"> </th>                                  
                                                            </tr>                                                                                
                                                        </thead>
                                                        <tfoot>
                                                        </tfoot>
                                                        <tbody> 
                                                            <tr></tr>                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="desc" class="dd">
                                                    <label>Descuento</label>
                                                    <input type="text" id="txtDesc" name="txtDesc" value="0" readonly style="width: 40px; height: 25px;"/>
                                                </div> 
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                            <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                            <button class="btn btn-primary" id='btnFacturar'><i class="icon-th-list"></i> Facturar</button>
                                        </div>
                                    </div>
                                    <div id="tablaEn" style="margin-left:  10px">
                                        <table id="list"></table>
                                        <div id="pager"></div>
                                        <br/>
                                        <table id="list1"></table>
                                        <div id="pager1"></div>
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