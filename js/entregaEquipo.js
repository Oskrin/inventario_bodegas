$(document).on("ready", inicio);
var dialogos1 =
        {
            autoOpen: false,
            resizable: false,
            width: 460,
            height: 320,
            modal: true
        };
        
$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});
function fn_dar_eliminar(e) {
    $("a.elimina").click(function() {
        id = $(this).parents("tr").find("td").eq(0).html();
        $(this).parents("tr").fadeOut("normal", function() {
            $(this).remove();
            Rtotal();
        });
    });
}
function inicio()
{
    $(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#tablaEn').width() - 10);
    }).trigger('resize');
    $("#tablaEn").css("display", "block");
    $("#entregaP").css("display", "none");
    $("#btnDetTec").on("click", guardarReco);
    $("#txtDesc").spinner({
        min: 0,
        step: 1
    });
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
    
    $("#btnFacturar").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnDetTec").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnDetTecS").click(function(e) {
        e.preventDefault();
    });
    
    //////////////////////////
    $("#modDetTec").dialog(dialogos1);
    $("#btnDetTecS").click(function() {
        $("#modDetTec").dialog('close');
        $("#idR").val("");
        $("#txtDetTe").val("");
    });
    jQuery("#list").jqGrid({
        url: '../xml/xmlEntregaEquipo.php',
        datatype: 'xml',
        colNames: ['Nro Registro', 'Nombres Cliente', 'Id Cliente', 'Fecha Ingreso', 'Fecha Salida', 'Id estado', 'Estado', 'Técnico a cargo', 'Nro. de Serie', 'Modelo', 'Id categoria', 'Tipo de Equipo', 'Id Marca', 'Marca', 'Id color', 'Nombre Color', 'Accesosios', 'Observaciones', 'Id Usuario', 'Registrado por'],
        colModel: [
            {name: 'txtRegistro', index: 'txtRegistro', editable: true, align: 'center', width: '100', search: false, frozen: true},
            {name: 'txtCliente', index: 'txtCliente', editable: true, align: 'center', width: '180', search: true, frozen: true},
            {name: 'txtClienteId', index: 'txtClienteId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtIngreso', index: 'txtIngreso', editable: true, align: 'center', width: '160', search: false, frozen: true},
            {name: 'txtSalida', index: 'txtSalida', editable: true, align: 'center', width: '100', search: false, frozen: false},
            {name: 'id_estado', index: 'id_estado', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'Estado', index: 'Estado', editable: true, align: 'center', width: '160', search: true, frozen: false},
            {name: 'tecnico', index: 'tecnico', editable: true, align: 'center', width: '160', search: true, frozen: false},
            {name: 'txtSerie', index: 'txtSerie', editable: true, align: 'center', width: '200', search: true, frozen: false},
            {name: 'txtModelo', index: 'txtModelo', editable: true, align: 'center', width: '200', search: false, frozen: false},
            {name: 'txtTipoEquipoId', index: 'txtTipoEquipoId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'txtTipoEquipo', index: 'txtTipoEquipo', editable: true, align: 'center', width: '330', search: true, frozen: false},
            {name: 'txtMarcaId', index: 'txtMarcaId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'txtMarca', index: 'txtMarca', editable: true, align: 'center', width: '330', search: true, frozen: false},
            {name: 'txtColorId', index: 'txtColorId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'txtColor', index: 'txtColor', editable: true, align: 'center', width: '330', search: true, frozen: false},
            {name: 'txtAccesorios', index: 'txtAccesorios', editable: true, align: 'center', width: '330', search: false, frozen: false},
            {name: 'txtObservaciones', index: 'txtObservaciones', editable: true, align: 'center', width: '330', search: false, frozen: false},
            {name: 'id_user', index: 'id_user', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'nombre_user', index: 'nombre_user', editable: true, align: 'center', width: '330', search: false, frozen: false}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        height: 200,
        pager: jQuery('#pager'),
        sortname: 'id_registro',
        shrinkToFit: false,
        forceFit: true,
        sortorder: 'asc',
        caption: 'Lista de Equipos para entregar',
        viewrecords: true,
        gridview: true,
        ondblClickRow: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            
            if (id) {                
                var ret = jQuery("#list").jqGrid('getRowData', id);
                if (ret.id_estado == 1) {
                    jQuery("#list").jqGrid('GridToForm', id, "#formEntrega");                    
                    $("#entregaP").css("display", "block");
                    $("#tablaEn").css("display", "none");
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "../procesos/cargaReparaciones.php",
                        data: "id_registro=" + $("#txtRegistro").val(),
                        success: function(response) {
                            var data = response;
                            $("#resp").val(data[3]);
                            $("#txtTotal").val("$ " + data[4]);
                            $("#txtTotal1").val(data[4]);
                            $("#txtReco").val(data[5]);
                            for (i = 6; i < data.length; i = i + 6)
                            {
                                if((data[i + 1] / data[i + 4])>=0){
                                    resp=data[i + 1] / data[i + 4];
                                } else{
                                    resp=0;
                                }
                                
                                $("#tblRepracion tbody").append("<tr>" +
                                        "<td align=center>" + data[i + 4] + "</td>" +
                                        "<td align=center>" + data[i] + "</td>" +
                                        "<td align=center>" + "$ " + resp+ "</td>" +
                                        "<td align=center>" + "$ " + data[i + 1] + "</td>" +
                                        "<td align=center>" + " <a class='elimina'><img src='../imagenes/delete.png' onclick='return fn_dar_eliminar(event)' title='Borrar fila'/>" + "</td>" + "</tr>");
                            }
                            $("#txtDesc").spinner({
                                max: data[4],
                                min: 0
                            });
                        }
                    });
                }
                if (ret.id_estado == 0) {
                    alertify.alert("El producto fue ingresado recientemente");
                }
                if (ret.id_estado == 2) {
                    alertify.alert("El producto ya fue entregado");
                }
                if (ret.id_estado == 3) {
                    alertify.alert("El producto esta en estado de reparación a cargo del técnico: " + ret.tecnico);
                }
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
    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "Entregar Producto",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                if (ret.id_estado == 1) {
                    jQuery("#list").jqGrid('GridToForm', id, "#formEntrega");
                    $("#entregaP").css("display", "block");
                    $("#tablaEn").css("display", "none");
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "../procesos/cargaReparaciones.php",
                        data: "id_registro=" + $("#txtRegistro").val(),
                        success: function(response) {
                            var data = response;
                            $("#resp").val(data[3]);
                            $("#txtTotal").val("$ " + data[4]);
                            $("#txtTotal1").val(data[4]);
                            for (i = 6; i < data.length; i = i + 6)
                            {
                                if((data[i + 1] / data[i + 4])>=0){
                                    resp=data[i + 1] / data[i + 4];
                                } else{
                                    resp=0;
                                }
                                
                                $("#tblRepracion tbody").append("<tr>" +
                                        "<td align=center>" + data[i + 4] + "</td>" +
                                        "<td align=center>" + data[i] + "</td>" +
                                        "<td align=center>" + "$ " + resp+ "</td>" +
                                        "<td align=center>" + "$ " + data[i + 1] + "</td>" +
                                        "<td align=center>" + " <a class='elimina'><img src='../imagenes/delete.png' onclick='return fn_dar_eliminar(event)' title='Borrar fila'/>" + "</td>" + "</tr>");
                            }
                            $("#txtDesc").spinner({
                                max: data[4],
                                min: 0
                            });
                        }
                    });
                }
                if (ret.id_estado == 0) {
                    alertify.alert("El producto aún no esta pendiente para su reparación");
                }
                if (ret.id_estado == 2) {
                    alertify.alert("El producto ya fue entregado");
                }
                if (ret.id_estado == 3) {
                    alertify.alert("El producto esta en estado de reparación a cargo del técnico: " + ret.tecnico);
                }
            } else {
                alertify.alert("Seleccione un fila");
                
            }
        }
    });
    $("#list").jqGrid('setFrozenColumns');
    jQuery("#list").setGridWidth($('#tablaEn').width() - 10);
/////////////////////
    jQuery("#list1").jqGrid({
        url: '../xml/xmlEntregaEquipo1.php',
        datatype: 'xml',
        colNames: ['Nro Registro', 'Nombres Cliente', 'Id Cliente', 'Fecha Ingreso', 'Fecha Salida', 'Id estado', 'Estado', 'Técnico a cargo', 'Nro. de Serie', 'Modelo', 'Id categoria', 'Tipo de Equipo', 'Id Marca', 'Marca', 'Id color', 'Nombre Color', 'Accesosios', 'Observaciones', 'Id Usuario', 'Registrado por'],
        colModel: [
            {name: 'txtRegistro', index: 'txtRegistro', editable: true, align: 'center', width: '100', search: false, frozen: true},
            {name: 'txtCliente', index: 'txtCliente', editable: true, align: 'center', width: '180', search: true, frozen: true},
            {name: 'txtClienteId', index: 'txtClienteId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtIngreso', index: 'txtIngreso', editable: true, align: 'center', width: '160', search: false, frozen: true},
            {name: 'txtSalida', index: 'txtSalida', editable: true, align: 'center', width: '100', search: false, frozen: false},
            {name: 'id_estado', index: 'id_estado', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'Estado', index: 'Estado', editable: true, align: 'center', width: '160', search: true, frozen: false},
            {name: 'tecnico', index: 'tecnico', editable: true, align: 'center', width: '160', search: true, frozen: false},
            {name: 'txtSerie', index: 'txtSerie', editable: true, align: 'center', width: '200', search: true, frozen: false},
            {name: 'txtModelo', index: 'txtModelo', editable: true, align: 'center', width: '200', search: false, frozen: false},
            {name: 'txtTipoEquipoId', index: 'txtTipoEquipoId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'txtTipoEquipo', index: 'txtTipoEquipo', editable: true, align: 'center', width: '330', search: true, frozen: false},
            {name: 'txtMarcaId', index: 'txtMarcaId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'txtMarca', index: 'txtMarca', editable: true, align: 'center', width: '330', search: true, frozen: false},
            {name: 'txtColorId', index: 'txtColorId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'txtColor', index: 'txtColor', editable: true, align: 'center', width: '330', search: true, frozen: false},
            {name: 'txtAccesorios', index: 'txtAccesorios', editable: true, align: 'center', width: '330', search: false, frozen: false},
            {name: 'txtObservaciones', index: 'txtObservaciones', editable: true, align: 'center', width: '330', search: false, frozen: false},
            {name: 'id_user', index: 'id_user', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: false, width: 80},
            {name: 'nombre_user', index: 'nombre_user', editable: true, align: 'center', width: '330', search: false, frozen: false}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        height: 200,
        pager: jQuery('#pager1'),
        sortname: 'id_registro',
        shrinkToFit: false,
        forceFit: true,
        sortorder: 'asc',
        caption: 'Estado de Equipos',
        viewrecords: true,
        gridview: true,
        ondblClickRow: function() {
            var id = jQuery("#list1").jqGrid('getGridParam', 'selrow');
            
            if (id) {                
                var ret = jQuery("#list1").jqGrid('getRowData', id);
                if(ret.id_estado==2){
                    window.open("../reportes/reportes/rep_entrega.php?id=" + ret.txtRegistro);
               }else{
                alertify.alert("Error.. solo puede ver los reportes de los equipos entregados")
               }
            } else {
              alertify.alert("Seleccione un fila");
            }
        }
    }).jqGrid('navGrid', '#pager1',
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
     jQuery("#list1").jqGrid('navButtonAdd', '#pager1', {caption: "PDF",
        onClickButton: function() {
            var id = jQuery("#list1").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list1").jqGrid('getRowData', id);
               if(ret.id_estado==2){
                    window.open("../reportes/reportes/rep_entrega.php?id=" + ret.txtRegistro);
               }else{
                alertify.alert("Error.. solo puede ver los reportes de los equipos entregados")
               }
            } else {
              alertify.alert("Seleccione un fila");
                
            }
        }
    });
    $("#list1").jqGrid('setFrozenColumns');
    jQuery("#list1").setGridWidth($('#tablaEn').width() - 10);
/////////////////////
///////////////////////
    $('.ui-spinner-button').click(function() {
        $(this).siblings('input').change();
    });
    $(".ui-spinner-up").click(function() {
        var a = parseFloat($("#txtTotal1").val()) - parseFloat($("#txtDesc").val());
        $("#txtTotal").val("$ " + a);
    });
    $(".ui-spinner-down").click(function() {
        var a = parseFloat($("#txtTotal1").val()) + parseFloat($("#txtDesc").val());
        $("#txtTotal").val("$ " + a);
    });
    $("#btnBuscar").on("click", buscarReparacion);
    $("#btnGuardar").on("click", guardarReparacion);
}
function Rtotal() {
    cont = 0;
    var temp;
    var total = 0;
    $("#tblRepracion tbody tr").each(function(index3) {
        $(this).children("td").each(function(index3) {
            switch (index3) {
                case 3:
                    temp = $(this).text().substr(2);
                    total = total + parseFloat(temp);
                    break;
            }
        });
        cont++;
    });
    $("#txtTotal").val("");
    $("#txtTotal").val("$ " + total);
    $("#txtTotal1").val("");
    $("#txtTotal1").val(total);
}
function buscarReparacion()
{
    $("#tablaEn").css("display", "block");
    $("#entregaP").css("display", "none");
    $("#list").trigger("reloadGrid");
    limpiarDatos();
}
function guardarReparacion()
{
    cont = 0;
    var vect1 = new Array();
    var vect2 = new Array();
    $("#tblRepracion tbody tr").each(function(index3) {
        $(this).children("td").each(function(index3) {
            switch (index3) {
                case 1:
                    vect1[cont] = $(this).text();
                    break;
                case 2:
                    vect2[cont] = $(this).text().substr(2);
                    break;
            }
        });
        cont++;
    });
    var hoy = new Date().toISOString().slice(0, 10);
    $.ajax({
        type: "POST",
        url: "../procesos/procesosEntrega.php",
        data: "id_registro=" + $("#txtRegistro").val() + "&total=" + $("#txtTotal").val() + "&descuento=" + $("#txtDesc").val() + "&hoy=" + hoy,
        success: function(response) {
            var data = response;
            alertify.alert("Datos Modificados", function(){
            window.open("../reportes/reportes/rep_entrega.php?id=" + $("#txtRegistro").val());
            limpiarDatos();
            location.reload();
            $("#tablaEn").css("display", "block");
            $("#entregaP").css("display", "none");    
            });
        }
    });
}
function limpiarDatos()
{
    $("#txtRegistro").val("");
    $("#txtCliente").val("");
    $("#txtClienteId").val("");
    $("#txtIngreso").val("");
    $("#txtTotal").val("$ 0");
    $("#txtTotal1").val("");
    $("#txtTipoEquipo").val("");
    $("#txtTipoEquipoId").val("");
    $("#txtModelo").val("");
    $("#txtSerie").val("");
    $("#txtColor").val("");
    $("#txtColorId").val("");
    $("#txtMarca").val("");
    $("#txtMarcaId").val("");
    $("#resp").val("");
    $("txtObservaciones").val("");
    $("txtAccesorios").val("");
    $("#tblRepracion tbody tr").remove();
    jQuery("#list").trigger("reloadGrid");
}

function guardarReco() {
    if ($("#txtDetTe").val() !=="") {
        $.ajax({
            type: "POST",
            url: "../procesos/agregarReco.php",
            data: "id=" + $("#idR").val() + "&reco=" + $("#txtDetTe").val(),
            success: function(data) {
                var val = data;
                if (val == 1) {
                    alertify.alert("Datos Agregados", function(){
                    $("#modDetTec").dialog('close');
                    $("#idR").val("");
                    $("#txtDetTe").val("");    
                    });
                } else {
                    alertify.alert("Error al momento de guardar");
                }
            }
        });
    } else {
      alertify.alert("Llene los campos antes de continuar");
    }
}