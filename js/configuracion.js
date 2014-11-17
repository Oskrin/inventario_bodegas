$(document).on("ready", inicio);
function Defecto(e) {
    e.preventDefault();
}


$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

function numeros(e) { 
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    patron = /\d/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

var dialogo =
{
    autoOpen: false,
    resizable: false,
    width: 860,
    height: 300,
    modal: true
};



function abrirDialogo() {
    $("#usuarios").dialog("open");
    $("#contra_nueva").val("");
    $("#verificar_nueva").val("");
}

function modificar_usuario() {
    if($("#id_usuario").val() == ""){
        $("#btnBuscar").focus();
        alertify.alert("Seleccione un usuario");
    }else{
        if($("#contra_nueva").val() == ""){
            $("#contra_nueva").focus();
            alertify.alert("Ingrese una contraseña");
        }else{
            if($("#verificar_nueva").val() == ""){
                $("#verificar_nueva").focus();
                alertify.alert("Verifique nueva contraseña");
            }else{
                if($("#contra_nueva").val() != $("#verificar_nueva").val()){
                    alertify.alert("Las contraseñas no coinciden");
                }else{
                    $.ajax({
                        type: "POST",
                        url: "../procesos/contrasenia_usuario.php",
                        data: "id_usuario=" + $("#id_usuario").val() + "&verificar_nueva=" + $("#verificar_nueva").val(),
                        success: function(data) {
                            var val = data;
                            if (val == 1) {
                                alertify.alert("Datos Modificados Correctamente",function(){
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

function inicio() {
    
    //////////////////////
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    $("#btnBuscar").click(function(e) {
        e.preventDefault();
    });
    $("#btnNuevo").click(function(e) {
        e.preventDefault();
    });  
    
    ///////////////////////////
    $("#btnGuardar").on("click", modificar_usuario);
    $("#btnBuscar").on("click", abrirDialogo);
    $("#usuarios").dialog(dialogo);


    jQuery("#list").jqGrid({
        url: '../xml/xmlUsuario1.php',
        datatype: 'xml',
        colNames: ['Cod. Usuario', 'CI Usuario', 'Nombres Usuario', 'Apellidos Usuario','Cargo'],
        colModel: [
            {name: 'id_usuario', index: 'id_usuario', editable: true, align: 'center', width: '100', search: false, frozen: true, editoptions: {readonly: 'readonly'}},
            {name: 'ci_usuario', index: 'ci_usuario', editable: true, align: 'center', width: '100', size: '10', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}, editoptions:{maxlength: 10, size:20,dataInit: function(elem){$(elem).bind("keypress", function(e) {return numeros(e)})}}}, 
            {name: 'nombre_usuario', index: 'nombre_usuario', editable: true, align: 'center', width: '250', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'apellido_usuario', index: 'apellido_usuario', editable: true, align: 'center', width: '250', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'cargo_usuario', index: 'cargo_usuario', width:'100',search: false, align: 'center', editable: true, edittype: "select", editoptions: {value: "1:Administrador;2:Vendedor"}},
        ],
        rowNum: 10,
        rowList: [10, 20, 30],
        width: null,
        pager: jQuery('#pager'),
        sortname: 'id_usuario',
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista Usuarios',
        viewrecords: true,
        ondblClickRow: function(){
         var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
         jQuery('#list').jqGrid('restoreRow', id);   
         jQuery("#list").jqGrid('GridToForm', id, "#configuracion_form");
         $("#usuarios").dialog("close");    
        }
    }).jqGrid('navGrid', '#pager',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: true,
                addtext: "Nuevo",
                searchtext: "Buscar",
                refreshtext: "Recargar",
                viewtext: "Consultar"
            },
    {
        recreateForm: true, closeAfterEdit: true, checkOnUpdate: true, reloadAfterSubmit: true, closeOnEscape: true
    },
    {
        reloadAfterSubmit: true, closeAfterAdd: true, checkOnUpdate: true, closeOnEscape: true,
        bottominfo: "Los campos marcados con (*) son obligatorios", width: 350, checkOnSubmit: false
    },
    {
        width: 300, closeOnEscape: true
    },
    {
        closeOnEscape: true,
        multipleSearch: false, overlay: false
    },
    {
        closeOnEscape: true,
        width: 400
    },
    {
        closeOnEscape: true
    });
    
    /////////////////		
    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "Añadir",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            jQuery('#list').jqGrid('restoreRow', id);
            if (id) {
                jQuery("#list").jqGrid('GridToForm', id, "#configuracion_form");
                $("#usuarios").dialog("close");
            } else {
                alertify.alert("Seleccione un fila");
            }
        }
    });
}


