<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
include '../menus/menu.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>.:PROVEEDORES:.</title>
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
        <script type="text/javascript" src="../js/proveedores.js"></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../js/guidely/guidely.min.js"></script>
        <script type="text/javascript" src="../js/alertify.min.js"></script>
        <script type="text/javascript" src="../js/jquery.smartmenus.js"></script>
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
                                    <i class="icon-user"></i>
                                    <h3>PROVEEDORES</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <fieldset>
                                            <form class="form-horizontal" id="proveedores_form" name="proveedores_form" method="post">
                                                <section class="columna1">
                                                    <div class="control-group">
                                                        <label class="control-label" for="tipo_docu">Tipo Documento: <font color="red">*</font></label>
                                                        <div class="controls" >
                                                            <select name="tipo_docu" id="tipo_docu" required class="campo">
                                                                <option value="">......Seleccione......</option>
                                                                <option value="Cedula">Cedula</option>
                                                                <option value="Ruc">Ruc</option>
                                                                <option value="Pasaporte">Pasaporte</option>
                                                            </select>
                                                        </div> 
                                                    </div>  

                                                    <div class="control-group">
                                                        <label class="control-label" for="empresa_pro">Empresa: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" name="empresa_pro"  id="empresa_pro" placeholder="Nombre de la Empresa" required class="campo"/>
                                                        </div>  
                                                    </div> 

                                                    <div class="control-group">
                                                        <label class="control-label" for="visitador">Visitador:</label>
                                                        <div class="controls">
                                                            <input type="text" name="visitador" id="visitador" placeholder="Empleado Empresa" required  class="campo"/>
                                                        </div>   
                                                    </div> 

                                                    <div class="control-group">
                                                        <label class="control-label" for="nro_telefono">Nro. Telefónico: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="tel" name="nro_telefono" id="nro_telefono" placeholder="062-999-999" maxlength="10" class="campo"/>
                                                        </div>   
                                                    </div> 

                                                    <div class="control-group">
                                                        <label class="control-label" for="correo">E-mail: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <div class="input-prepend input-append">
                                                                <span class="add-on">@</span>
                                                                <input type="text" name="correo" id="correo" placeholder="xxxx@example.com" class="campo" style="width: 165px"/>
                                                            </div>
                                                        </div>  
                                                    </div> 

                                                    <div class="control-group">
                                                        <label class="control-label" for="pais_pro">País: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" name="pais_pro" id="pais_pro" required  class="campo"/>
                                                        </div>  
                                                    </div> 

                                                    <div class="control-group">
                                                        <label class="control-label" for="forma_pago">Formas de Pago: <font color="red">*</font></label>
                                                        <div class="controls" >
                                                            <select name="forma_pago" id="forma_pago" required class="campo">
                                                                <option value="">......Seleccione......</option>
                                                                <option value="Contado">Contado</option>
                                                                <option value="Credito">Credito</option>
                                                            </select>
                                                        </div>  
                                                    </div> 

                                                    <div class="control-group">
                                                        <label class="control-label" for="observaciones_pro">Observaciones:</label>
                                                        <div class="controls" >
                                                            <textarea name="observaciones_pro" id="observaciones_pro" rows="3" class="campo"></textarea>
                                                        </div>  
                                                    </div> 
                                                </section>  

                                                <section class="columna2">
                                                    <div class="control-group">											
                                                        <label class="control-label" for="ruc_ci">RUC/CI: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text" name="ruc_ci"  id="ruc_ci" placeholder="10000000000" required class="campo" />
                                                            <input type="hidden" name="id_proveedor"  id="id_proveedor" readonly class="campo" >
                                                        </div>	
                                                        <!--<div id="mensaje1" class="errores">Dame tu nombre</div>-->
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="representante_legal">Representante Legal: </label>
                                                        <div class="controls">
                                                            <input type="text" name="representante_legal" id="representante_legal" placeholder="Representante Legal" required class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="direccion_pro">Dirección: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <input type="text"  name="direccion_pro" id="direccion_pro" placeholder="Dirección de la Empresa" required class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="nro_celular">Nro. de Celular:</label>
                                                        <div class="controls">
                                                            <input type="tel" name="nro_celular" id="nro_celular" maxlength="10" placeholder="09-9999-999" class="campo"/>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="fax">Fax: </label>
                                                        <div class="controls">
                                                            <input type="text" name="fax" id="fax" class="campo" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="ciudad_pro">Ciudad: <font color="red">*</font> </label>
                                                        <div class="controls">
                                                            <input type="text" name="ciudad_pro" id="ciudad_pro" required class="campo"/>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">											
                                                        <label class="control-label" for="principal_pro">Proveedor Principal: <font color="red">*</font></label>
                                                        <div class="controls">
                                                            <select name="principal_pro" id="principal_pro" required class="campo" >
                                                                <option value="">......Seleccione......</option>
                                                                <option value="Si">Si</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>			
                                                    </div>
                                                </section>
                                            </form>
                                        </fieldset>  

                                        <div class="form-actions">
                                            <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                            <button class="btn btn-primary" id='btnModificar'><i class="icon-edit"></i> Modificar</button>
                                            <button class="btn btn-primary" id='btnEliminar'><i class="icon-remove"></i> Eliminar</button>
                                            <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                            <button class="btn btn-primary" id='btnNuevo'><i class="icon-pencil"></i> Nuevo</button>
                                        </div>

                                        <div id="proveedores" title="Búsqueda de Proveedores" class="">
                                            <table id="list"><tr><td></td></tr></table>
                                            <div id="pager"></div>
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
                                            <label>Esta seguro de eliminar al cliente</label>  
                                            <br />
                                            <button class="btn btn-primary" id='btnAceptar'><i class="icon-ok"></i> Aceptar</button>
                                            <button class="btn btn-primary" id='btnSalir'><i class="icon-remove-sign"></i> Cancelar</button>
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