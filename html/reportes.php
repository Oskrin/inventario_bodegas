<?php    
    session_start();         
    if(empty($_SESSION['id'])) {      
        header('Location: index.php');
    }
    include '../menus/menu.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:REPORTES GENERALES:.</title>
<link rel="stylesheet" type="text/css" href="../css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="../css/font-awesome.css">	
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.3.custom.min.css"/>    
<link rel="stylesheet" type="text/css" href="../css/normalize.css"/>    
<link rel="stylesheet" type="text/css" href="../css/ui.jqgrid.css"/>  
<link rel="stylesheet" type="text/css" href="../css/style.css"  media="screen" />  

<script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="../js/grid.locale-es.js"></script>
<script type="text/javascript" src="../js/jquery.jqGrid.src.js"></script>
<script type="text/javascript" src="../js/buttons.js" ></script>
<script type="text/javascript" src="../js/reportes.js"></script>
<script type="text/javascript" src="../js/datosUser.js"></script>
</head>

<body>
<header class="navbar-inner">
  <div id="header">
    <div id="logo">
        <h1><a href=""><?php echo $_SESSION['empresa']; ?>      </a></h1>
    </div>  
  </div> 
</header>
    
     <div id="menu">
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

 <div id="page">
<div id="principal">    
  <div id="centro">
<fieldset>
  <legend>Reporte Clientes</legend>
  <label><h2>Nombre Cliente</h2></label>
  <input type="text" id="txtCliente" value="">
  <input type="hidden" id="txtClienteId" value="">
  <label><h2>Fecha Inicio:</h2></label>
  <input type="text" id="txtInicio" value="">
  <label><h2>Fecha Fin</h2></label>
  <input type="text" id="txtFin" value="">
  <label><h2>Estado</h2></label>
  <select id="selectEstado">
    <option value="0">Ingresado</option>
    <option value="1">Reparado</option>
    <option value="2">Entregado</option>
    <option value="3">En reparación</option>
    <option value="4">Todos</option>
    option
  </select>
  <br>
  <a href="#" id='btnCliente'>Reporte</a>
  <a href="#" id='btnLimCliente'>Limpiar</a>
</fieldset>
<br><br>
<div id="md">
<fieldset>
  <legend>Reporte Equipos</legend>
  <label> <h2>Nro Registro</h2></label>
  <input type="text" id="txtNro" value="">
  <br>
  <a href="#" id='btnEquipo'>Reporte</a>
  <a href="#" id='btnLimEquipo'>Limpiar</a>
</fieldset>
<fieldset>
  <legend>Categorías</legend>
  <label> <h2>Nombre Categoría</h2></label>
  <input type="text" id="txtCat" value="">
   <input type="hidden" id="txtCatId" value="">
  <br>
  <a href="#" id='btnCategoria'>Reporte</a>
  <a href="#" id='btnLimCategoria'>Limpiar</a>
</fieldset>
<fieldset>
  <legend>Reporte de Usuarios</legend>
  <label> <h2>Nombre Usuario</h2></label>
  <input type="text" id="txtTec" value="">
   <input type="hidden" id="txtTecId" value="">
  <br>
  <a href="#" id='btnTec'>Reporte</a>
  <a href="#" id='btnLimTec'>Limpiar</a>
</fieldset>
<fieldset>
  <legend>Marcas</legend>
  <label> <h2>Nombre Marca</h2></label>
  <input type="text" id="txtMar" value="">
   <input type="hidden" id="txtMarId" value="">
  <br>
  <a href="#" id='btnMarca'>Reporte</a>
  <a href="#" id='btnLimMarca'>Limpiar</a>
</fieldset>
<fieldset>
  <legend>Reporte Fechas</legend>  
  <label><h2>Fecha Inicio:</h2></label>
  <input type="text" id="txtInicio1" value="">
  <label><h2>Fecha Fin</h2></label>
  <input type="text" id="txtFin1" value="">  
  <br>
  <a href="#" id='btnFechasI'>Reporte</a>
  <a href="#" id='btnLimFechasI'>Limpiar</a>
</fieldset>
<fieldset>
  <legend>Reporte Equipos Clientes</legend>  
  <label><h2>Nombre Usuario:</h2></label>
  <input type="text" id="txtU" value="">
  <input type="hidden" id="txtUId" value="">
  <label><h2>Equipo:</h2></label>
  <select id="txtE" style="width:60%">
    <option value="">Seleccione un equipo</option>    
  </select>  
  <br>
  <a href="#" id='btnEquiU'>Reporte</a>
  <a href="#" id='btnLimEquiU'>Limpiar</a>
</fieldset>
</div>
</div>
</div>
    </div>
 <br />
                         <hr style="color: #0056b2;" />
                  <div id="footer">
                 <p>&copy; 2014 <?php echo $_SESSION['empresa']; ?></p>
              </div>
</body>
    <div id="modUser" title="Modificar Usuario">
  <label>Nombres: </label>
  <input type="text" id="userNombre"></input><br>
  <label>Apellidos: </label>
  <input type="text" id="userApellido"></input><br>  
  <label>Nick: </label>
  <input type="text" id="userNick"></input><br>
  <label>CI: </label>
  <input type="text" id="userCi"></input><br>
  <label>Teléfono: </label>
  <input type="text" id="userTelefono"></input><br>
  <label>Celular: </label>
  <input type="text" id="userCelular"></input><br>
  <label>Email: </label>
  <input type="text" id="userEmail"></input><br>
  <label>Dirección: </label>
  <input type="text" id="userDirección"></input><br>
  <label>Constraseña: </label>
  <input type="password" id="userPass"></input><br>
  <br>
  <a href="#" id="btnModUser">Modificar datos</a>
  <a href="#" id="btnModSes">Salir</a>
</div>
</html>