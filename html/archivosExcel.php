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
        <title>.:ARCHIVOS DE EXCEL:.</title>
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

        <script type="text/javascript" src="../js/base.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-loader.js"></script>
        <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/grid.locale-es.js"></script>
        <script type="text/javascript" src="../js/jquery.jqGrid.src.js"></script>
        <script type="text/javascript" src="../js/buttons.js" ></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/archivo_excel.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../js/guidely/guidely.min.js"></script>
        <script type="text/javascript" src="../js/jquery.smartmenus.js"></script>
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
        <!-- /Fin  Menu Principal -->

        <div class="main">
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">      		
                            <div class="widget ">
                                <div class="widget-header">
                                    <i class="icon-user"></i>
                                    <h3>SUBIR ARCHIVOS EXCEL</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable" id="centro">
                                        <form id="formulario_excel" name="formulario_excel" method="post" class="form">
                                            <fieldset>
                                                <div class="controls">
                                                    <div class="alert alert-info">
                                                        <h4>Recomendaciones</h4>  
                                                        <br />
                                                        <strong>Poner tipos numéricos y texto en las celdas que corresponde caso contrario saldra error de sintaxis.</strong>
                                                        <br />
                                                        <strong>Tener en cuenta de no repetir los articulos.</strong>
                                                    </div>
                                                </div>
                                                <table cellpadding="2" border="0" style="margin-left: 10px;">
                                                    <tr>
                                                        <td><label for="archivo_excel" style="width: 20%">Seleccione: </label></td>   
                                                        <td><input type="file" name="archivo_excel" id="archivo_excel" class="campo" readonly style="width: 500px"/></td>
                                                        <td><button class="btn btn-primary" id='btnGuardarCargar'><i class="icon-save"></i> Guardar y Cargar</button></td>
                                                    </tr>  
                                                </table>  
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div style="width:100%;height:300px;border:solid 0px;border-color:rgb(204, 201, 201);overflow:scroll;">
                                        <table style="width:100%;" class="table table-bordered table-hover table-condensed" id="tabla_excel" >
                                            <thead>
                                                <tr>
                                                    <th style="width:20%;">Codigo</th>
                                                    <th style="width:40%;">Articulo</th>
                                                    <th style="width:35%;">Estado</th>
                                                    <th style="width:5%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>

                                                </tr>
                                        </table>
                                    </div>  
                                </div> 
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 

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