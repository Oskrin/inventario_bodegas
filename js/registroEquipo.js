$(document).on("ready", inicio);

$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

var formatoFecha = {
    showButtonPanel: true,
    changeMonth: true,
    changeYear: true,
    dateFormat: "yy-mm-dd" + "  " + getCurrentTime(),
    showAnim: 'slide'
};

var formatoFecha1 = {
    showButtonPanel: true,
    changeMonth: true,
    changeYear: true,
    dateFormat: "yy-mm-dd",
    showAnim: 'slide'
};

var dialogos =
{
    autoOpen: false,
    resizable: false,
    width: 760,
    height: 400,
    modal: true
};

function getCurrentTime() {
    var CurrentTime = "";
    try {
        var CurrentDate = new Date();
        var CurrentHours = CurrentDate.getHours();
        var CurrentMinutes = CurrentDate.getMinutes();
        var CurrentAmPm = "A'M'";
        if (CurrentMinutes < 10) {
            CurrentMinutes = "0" + CurrentMinutes;
        }

        if (CurrentHours === 12) {
            CurrentHours = 12;
            CurrentAmPm = " P'M'";
        }
        else if (CurrentHours === 0) {
            CurrentHours = 12;
            CurrentAmPm = " A'M'";
        }
        else if (CurrentHours > 12) {
            CurrentHours = CurrentHours - 12;
            CurrentAmPm = " P'M'";
        }
        else {
            CurrentAmPm = " A'M'";
        }
        CurrentTime = "" + CurrentHours + ":" + CurrentMinutes + CurrentAmPm + "";
    }
    catch (ex) {
    }
    return CurrentTime;
}

function guardarRegistro() {
    if($("#txtClienteId").val() === ""){
        $("#txtCliente").focus(); 
        alertify.alert("Ingrese un cliente");
    }else{
        if($("#txtTipoEquipoId").val() === ""){
             $("#txtTipoEquipo").focus();
            alertify.alert("Ingrese el tipo de equipo");
        }else{
            if($("#txtModelo").val() === ""){
                $("#txtModelo").focus(); 
                alertify.alert("Ingrese un modelo");
            }else{
                if($("#txtSerie").val() === ""){
                    $("#txtSerie").focus();
                    alertify.alert("Ingrese la serie");
                }else{
                    if($("#txtColorId").val() === ""){
                        $("#txtColor").focus(); 
                        alertify.alert("Ingrese un color");
                    }else{
                        if($("#txtMarcaId").val() === ""){
                            $("#txtMarca").focus();
                            alertify.alert("Ingrese una marca");
                        }else{
                            $.ajax({
                                type: "POST",
                                url: "../procesos/procesosRegistroEquipo.php",
                                data: "txtRegistro=" + $("#txtRegistro").val() + "&txtClienteId=" + $("#txtClienteId").val() + "&txtIngreso=" + $("#txtIngreso").val() + "&txtTipoEquipoId=" + $("#txtTipoEquipoId").val() + "&txtModelo=" + $("#txtModelo").val() + "&txtSerie=" + $("#txtSerie").val() + "&txtColorId=" + $("#txtColorId").val() + "&txtMarcaId=" + $("#txtMarcaId").val() + "&txtObservaciones=" + $("#txtObservaciones").val() + "&txtAccesorios=" + $("#txtAccesorios").val() + "&txtSalida=" + $("#txtSalida").val() + "&tipo=" + "g",
                                success: function(data) {
                                    var val = data;
                                    if (val == 0) {
                                        alertify.alert("Datos Guardados", function(){
                                        id = $("#txtRegistro").val();
                                        window.open("../reportes/reportes/reporteRegistro.php?id=" + id);
                                        limpiarDatos();
                                        $("#txtRegistro").val(parseInt(id) + 1);   
                                        });
                                    } 
                                    if (val == 1) {
                                        alertify.alert("Error.. durante el proceso");
                                    }
                                }
                            });
                        }
                    }
                }
            }
        }
    }
}

function modificarRegistro(e){
    if($("#txtClienteId").val() === ""){
        $("#txtCliente").focus(); 
        alertify.alert("Ingrese un registro");
    }else{
        if($("#txtTipoEquipoId").val() === ""){
            $("#txtTipoEquipo").focus(); 
            alertify.alert("Ingrese el tipo de equipo");
        }else{
            if($("#txtModelo").val() === ""){
                $("#txtModelo").focus(); 
                alertify.alert("Ingrese un modelo");
            }else{
                if($("#txtSerie").val() === ""){
                    $("#txtSerie").focus();
                    alertify.alert("Ingrese la serie");
                }else{
                    if($("#txtColorId").val() === ""){
                        $("#txtColor").focus(); 
                        alertify.alert("Ingrese un color");
                    }else{
                        if($("#txtMarcaId").val() === ""){
                            $("#txtMarca").focus();
                            alertify.alert("Ingrese una marca");
                        }else{
                            $.ajax({
                                type: "POST",
                                url: "../procesos/procesosRegistroEquipo.php",
                                data: "txtRegistro=" + $("#txtRegistro").val() + "&txtClienteId=" + $("#txtClienteId").val() + "&txtIngreso=" + $("#txtIngreso").val() + "&txtTipoEquipoId=" + $("#txtTipoEquipoId").val() + "&txtModelo=" + $("#txtModelo").val() + "&txtSerie=" + $("#txtSerie").val() + "&txtColorId=" + $("#txtColorId").val() + "&txtMarcaId=" + $("#txtMarcaId").val() + "&txtObservaciones=" + $("#txtObservaciones").val() + "&txtAccesorios=" + $("#txtAccesorios").val() + "&txtSalida=" + $("#txtSalida").val() + "&tipo=" + "m",
                                success: function(data) {
                                    var val = data; 
                                    if (val == 0) {
                                        alertify.alert("Datos Modificados", function(){
                                        $("#txtRegistro").val("");
                                        location.reload();   
                                        });
                                    }
                                    if (val == 1) {
                                        alertify.alert("Error.. durante el proceso");
                                    }
                                }
                            });
                        }
                    }
                }
            }
        }
    }
}

function flecha_atras(){
    var valor = $("#txtRegistro").val();
    ///////////////////llamar facturas flechas primera parte/////
    $("#btnGuardar").attr("disabled", true);

    $.getJSON('../procesos/retornar_registro_equipo.php?com=' + valor, function(data) {
        var tama = data.length;
        if (tama !== 0) {
            for (var i = 0; i < tama; i = i + 17)
            {
                    
                $("#txtRegistro").val(data[i]);
                $("#txtClienteId").val(data[i + 1]);
                $("#txtCliente").val(data[i + 2]);
                $("#txtIngreso").val(data[i + 3]);
                $("#txtSalida").val(data[i + 4]);
                $("#txtTipoEquipoId").val(data[i + 5]);
                $("#txtTipoEquipo").val(data[i + 6]);
                $("#txtModelo").val(data[i + 7]);
                $("#txtSerie").val(data[i + 8]);
                $("#txtColorId").val(data[i + 9]);
                $("#txtColor").val(data[i + 10]);
                $("#txtMarcaId").val(data[i + 11]);
                $("#txtMarca").val(data[i + 12]);
                $("#resp").val(data[i + 13 ] + " " + data[i + 14 ] );
                $("#txtObservaciones").val(data[i + 15]);
                $("#txtAccesorios").val(data[i + 16]);
            }
        }else{
            alertify.alert("No hay mas registros posteriores!!");
        }
    });
} 

function flecha_siguiente(){
    var valor = $("#txtRegistro").val();
    var compro2=  $("#comprobante2").val();
    ///////////////////llamar facturas flechas primera parte/////
    if(parseInt(valor) === parseInt(compro2)){
        alert("Error... Ingreso no creado");
    }else{
        $("#btnGuardar").attr("disabled", true);
        $.getJSON('../procesos/retornar_registro_equipo2.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 17)
                {
                    
                    $("#txtRegistro").val(data[i]);
                    $("#txtClienteId").val(data[i + 1]);
                    $("#txtCliente").val(data[i + 2]);
                    $("#txtIngreso").val(data[i + 3]);
                    $("#txtSalida").val(data[i + 4]);
                    $("#txtTipoEquipoId").val(data[i + 5]);
                    $("#txtTipoEquipo").val(data[i + 6]);
                    $("#txtModelo").val(data[i + 7]);
                    $("#txtSerie").val(data[i + 8]);
                    $("#txtColorId").val(data[i + 9]);
                    $("#txtColor").val(data[i + 10]);
                    $("#txtMarcaId").val(data[i + 11]);
                    $("#txtMarca").val(data[i + 12]);
                    $("#resp").val(data[i + 13 ] + " " + data[i + 14 ] );
                    $("#txtObservaciones").val(data[i + 15]);
                    $("#txtAccesorios").val(data[i + 16]);
                }
            }else{
            alertify.alert("No hay mas registros superiores!!");
           }
        });
    }
} 

function limpiarDatos()
{
    $("input").val("");
    $("textarea").val("");
}
function abrirDialogo(e)
{
    $("#bRegistros").dialog("open");
    $("#list").trigger("reloadGrid");
}

function limpiar_campo1(){
    if($("#txtCliente").val() === ""){
        $("#txtClienteId").val("");
    }
}

function limpiar_campo2(){
    if($("#txtTipoEquipo").val() === ""){
        $("#txtTipoEquipoId").val("");
    }
}

function limpiar_campo3(){
    if($("#txtColor").val() === ""){
        $("#txtColorId").val("");
    }
}

function limpiar_campo4(){
    if($("#txtMarca").val() === ""){
        $("#txtMarcaId").val("");
    }
}

function inicio()
{
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });

    $("#btnBuscar").click(function(e) {
        e.preventDefault();
    });

    $("#btnModificar").click(function(e) {
        e.preventDefault();
    });

    $("#btnNuevo").click(function(e) {
        location.reload();
    });
    
    $("#btnAtras").click(function(e) {
        e.preventDefault();
    });
    $("#btnAdelante").click(function(e) {
        e.preventDefault();
    });
    $("#btnImprimir").click(function (){        
        window.open("../reportes/reportes/reporteRegistro.php?id=" + $("#txtRegistro").val());
    });
    $("#bRegistros").dialog(dialogos);
    $("#btnBuscar").on("click", abrirDialogo);
    $("#btnGuardar").on("click", guardarRegistro);
    $("#btnModificar").on('click', modificarRegistro);
    $("#btnAtras").on("click", flecha_atras);
    $("#btnAdelante").on("click", flecha_siguiente);
    $("#btnNuevo").on('click', limpiarDatos);
    $("#txtIngreso").datepicker(formatoFecha);
    $("#txtSalida").datepicker(formatoFecha1);
    
    $("#txtCliente").on("keyup", limpiar_campo1);
    $("#txtTipoEquipo").on("keyup", limpiar_campo2);
    $("#txtColor").on("keyup", limpiar_campo3);
    $("#txtMarca").on("keyup", limpiar_campo4);

    $("#txtColor").autocomplete({
        source: "../procesos/busquedaColor.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#txtColor").val(ui.item.value);
        $("#txtColorId").val(ui.item.label);
        return false;
        },
        select: function(event, ui) {
        $("#txtColor").val(ui.item.value);
        $("#txtColorId").val(ui.item.label);
        return false;
        }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
    $("#txtCliente").autocomplete({
        source: "../procesos/busquedaCliente.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#txtCliente").val(ui.item.value);
        $("#txtClienteId").val(ui.item.label);
        return false;
        },
        select: function(event, ui) {
        $("#txtCliente").val(ui.item.value);
        $("#txtClienteId").val(ui.item.label);
        return false;
        }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
    $("#txtTipoEquipo").autocomplete({
        source: "../procesos/busquedaEquipo.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#txtTipoEquipo").val(ui.item.value);
        $("#txtTipoEquipoId").val(ui.item.label);
        return false;
        },
        select: function(event, ui) {
        $("#txtTipoEquipo").val(ui.item.value);
        $("#txtTipoEquipoId").val(ui.item.label);
        return false;
        }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
    $("#txtMarca").autocomplete({
        source: "../procesos/busquedaMarca.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#txtMarca").val(ui.item.value);
        $("#txtMarcaId").val(ui.item.label);
        return false;
        },
        select: function(event, ui) {
        $("#txtMarca").val(ui.item.value);
        $("#txtMarcaId").val(ui.item.label);
        return false;
        }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
    ////////
    $.ajax({
        type: "POST",
        url: "../procesos/contadorRegistro.php",
        success: function(data) {
            var val = data;
            $("#txtRegistro").val(val);
        }
    });
    
        jQuery("#list").jqGrid({
        url: '../xml/xmlRegistroEquipo.php',
        datatype: 'xml',
        colNames: ['Nro Registro', 'Nombres Cliente', 'Id Cliente', 'Fecha Ingreso', 'Fecha Salida', 'Nro. de Serie', 'Modelo', 'Id categoria', 'Tipo de Equipo', 'Id Marca', 'Marca', 'Id color', 'Nombre Color', 'Accesosios', 'Observaciones', 'Id Usuario', 'Registrado por', 'Id estado', 'Estado'],
        colModel: [
            {name: 'txtRegistro', index: 'txtRegistro', editable: true, align: 'center', width: '100', search: false, frozen: true},
            {name: 'txtCliente', index: 'txtCliente', editable: true, align: 'center', width: '150', search: true, frozen: true},
            {name: 'txtClienteId', index: 'txtClienteId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtIngreso', index: 'txtIngreso', editable: true, align: 'center', width: '150', search: false, frozen: true},
            {name: 'txtSalida', index: 'txtSalida', editable: true, align: 'center', width: '120', search: false, frozen: true},
            {name: 'txtSerie', index: 'txtSerie', editable: true, align: 'center', width: '150', search: true, frozen: true},
            {name: 'txtModelo', index: 'txtModelo', editable: true, align: 'center', width: '150', search: false, frozen: true},
            {name: 'txtTipoEquipoId', index: 'txtTipoEquipoId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtTipoEquipo', index: 'txtTipoEquipo', editable: true, align: 'center', width: '150', search: true, frozen: true},
            {name: 'txtMarcaId', index: 'txtMarcaId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtMarca', index: 'txtMarca', editable: true, align: 'center', width: '150', search: true, frozen: true},
            {name: 'txtColorId', index: 'txtColorId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtColor', index: 'txtColor', editable: true, align: 'center', width: '150', search: true, frozen: true},
            {name: 'txtAccesorios', index: 'txtAccesorios', editable: true, align: 'center', width: '150', search: false, frozen: true},
            {name: 'txtObservaciones', index: 'txtObservaciones', editable: true, align: 'center', width: '150', search: false, frozen: true},
            {name: 'id_user', index: 'id_user', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'nombre_user', index: 'nombre_user', editable: true, align: 'center', width: '150', search: false, frozen: true},
            {name: 'id_estado', index: 'id_estado', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'Estado', index: 'Estado', editable: true, align: 'center', width: '150', search: true, frozen: true}
        ],
        rowNum: 10,
        rowList: [10, 20, 30],
        width: 720,
        height: 250,
        pager: jQuery('#pager'),
        sortname: 'id_registro',
        shrinkToFit: false,
        sortorder: 'asc',
        caption: 'Lista Recursos',
        viewrecords: true,
        gridview: true,
        ondblClickRow: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                jQuery("#list").jqGrid('GridToForm', id, "#formRegistroEquipo");
                $("#bRegistros").dialog('close');
                $("#btnGuardar").attr("disabled", true);
            } else {
              alertify.alert("Seleccione un fila");
            }
        }
    }).jqGrid('navGrid', '#pager',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: true
            },
    {
        recreateForm: true, closeAfterEdit: true, checkOnUpdate: true, reloadAfterSubmit: true, closeOnEscape: true
    },
    {
        reloadAfterSubmit: true, closeAfterAdd: true, checkOnUpdate: true, closeOnEscape: true,
        bottominfo: "Todos los campos son obligatorios son obligatorios"
    },
    {
        width: 300, closeOnEscape: true
    },
    {
        sopt: ['eq', 'bw'],
        multipleSearch: false, overlay: false
    },
    {
        closeOnEscape: true,
        width: 400
    },
    {
        closeOnEscape: true
    });
    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "Modificar",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                jQuery("#list").jqGrid('GridToForm', id, "#formRegistroEquipo");
                $("#bRegistros").dialog('close');
                $("#btnGuardar").attr("disabled", true);
            } else {
              alertify.alert("Seleccione un fila");
            }
        }
    });

    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "PDF",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                window.open("../reportes/reportes/reporteRegistro.php?id=" + ret.txtRegistro);
            } else {
              alertify.alert("Seleccione un fila");
            }
        }
    });
/////////////////////
    
 
}

