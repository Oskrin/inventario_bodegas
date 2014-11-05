$(document).on("ready", inicio);

var dialogo =
{
    autoOpen: false,
    resizable: false,
    width: 500,
    height: 600,
    modal: true
};

function cancelar(){
    $("#crear_empresa").dialog("close");  
    $("#txt_usuario").val("");
    $("#txt_contra").val("");
}


function guardar_empresa(){
    if ($("#nombre_empresa").val() === "") {
        $("#nombre_empresa").focus();
        alertify.alert("Ingrese nombre de la empresa");
    } else {
        if ($("#ruc_empresa").val() === "") {
            $("#ruc_empresa").focus();
            alertify.alert("Ingrese ruc de la empresa");
        }else{
            if ($("#direccion_empresa").val() === "") {
                $("#direccion_empresa").focus();
                alertify.alert("Ingrese dirección de la empresa");
            }else{
                if ($("#telefono_empresa").val() === "") {
                    $("#telefono_empresa").focus();
                    alertify.alert("Ingrese telefóno de la empresa");
                }else{
                    $.ajax({
                        type: "POST",
                        url: "../procesos/guardar_empresa.php",
                        data: "nombre_empresa=" + $("#nombre_empresa").val() + "&ruc_empresa=" + $("#ruc_empresa").val() + "&direccion_empresa=" + $("#direccion_empresa").val() +
                        "&telefono_empresa=" + $("#telefono_empresa").val() + "&celular_empresa=" + $("#celular_empresa").val() + "&fax_empresa=" + $("#fax_empresa").val() + "&correo_empresa=" + $("#correo_empresa").val() + "&pagina_empresa=" + $("#pagina_empresa").val(),
                        success: function(data) {
                            var val = data;
                            if (val == 1)
                            {
                                alertify.alert("Empresa guardada Correctamente",function(){
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            }
        }
    }
}

function enter(e) {
    if (e.which === 13 || e.keyCode === 13) {
        ingresarSistema();
        return false;
    }
    return true;
}

function ingresarSistema() {
    if ($("#txt_usuario").val() === "") {
        $("#txt_usuario").focus();
        alertify.alert("Ingrese el usuario");
    } else {
        if ($("#txt_contra").val() === "") {
            $("#txt_contra").focus();
            alertify.alert("Ingrese la contraseña");
        }else{
            $.ajax({
                url: '../procesos/index.php',
                type: 'POST',
                data: "usuario=" + $("#txt_usuario").val() + "&clave=" + $("#txt_contra").val(),
                success: function(data) {
                    var val = data;
                    if (val == 1) {
                        window.location.href = "principal.php";  
                    }else{
                        if (val == 0) {
                            alertify.alert("Error... Los datos son incorrectos ingrese nuevamente");
                            $("#txt_contra").val("")
                            $("#txt_contra").focus();
                        }
                    }
                }
            });
        }
    }
}

function inicio()
{
    $("#ruc_empresa").validCampoFranz("0123456789");
    $("#telefono_empresa").validCampoFranz("0123456789");
    $("#celular_empresa").validCampoFranz("0123456789");
    $("#ruc_empresa").attr("maxlength", "13");
    
    $("#btnIngreso").click(function(e) {
        e.preventDefault();
    });
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    $("#btnCancelar").click(function(e) {
        e.preventDefault();
    });
    
    ////////////eventos botones/////////////
    $("#btnCancelar").on("click", cancelar);
    $("#btnGuardar").on("click", guardar_empresa);
    //////////////////////////////////////
   
   
   
    ////////////dialogo///////////////
    $("#crear_empresa").dialog(dialogo);
    
    ///////////////////////////////
    $("#txt_usuario").focus();
    $("#txt_contra").on("keypress", enter);
    $("#txt_usuario").on("keypress", enter);
    $("#btnIngreso").on("click", ingresarSistema);
}
