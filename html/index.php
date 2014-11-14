<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>.:INGRESO AL SISTEMA:.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 

        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.4.custom.css"/> 
        <link href="../css/font-awesome.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="../css/pages/signin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/alertify.core.css" />
        <link rel="stylesheet" href="../css/alertify.default.css" id="toggleCSS" />
        <link rel="stylesheet" href="../css/logo.css" id="dclogo" />

        <!--<script src="js/jquery-1.7.2.min.js"></script>-->
        <script src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/index.js"></script>
        <script type="text/javascript" src="../js/signin.js"></script>
        <script type="text/javascript" src="../js/alertify.min.js"></script>
    </head>

    <body style="background: url(../images/fondo.fw.png)no-repeat fixed center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">
        <div class="account-container">
            <div class="content clearfix">
                <form action="" method="post" name="form_admin">
                    <h1>Usuario</h1>
                    <div class="login-fields">
                        <p>Por favor, proporcione sus datos</p>
                        <div class="field">
                            <label for="username">Usuario:</label>
                            <input type="text" id="txt_usuario" name="txt_usuario" placeholder="Usuario" class="login username-field" />
                        </div> <!-- /field -->

                        <div class="field">
                            <label for="password">Password:</label>
                            <input type="password" id="txt_contra" name="txt_contra" placeholder="Constraseña" class="login password-field"/>
                        </div>
                    </div>

                    <div class="login-actions">
                        <span class="login-checkbox">
                            <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
                            <label class="choice" for="Field">Recordar conexión</label>
                        </span>
                        <button class="button btn btn-success btn-large" id="btnIngreso">Ingresar</button>
                    </div>
                </form>
            </div>
            <div class="member span4">
                <div class="member-thumbnail">
                    <a href="#">
                        <img src="../images/system.jpg" alt="avatar" />
                    </a>
                </div>
                <ul class="member-menu">
                    <li class="path-wrapper">
                        <span class="overlay"></span>
                        <div class="member-data">
                            <h3>P&S Systems</h3>
                            <div class="position">Desarrollo de Software</div>
                        </div> 
                    </li>
                </ul>
            </div>
        </div> 
    </body>
</html>