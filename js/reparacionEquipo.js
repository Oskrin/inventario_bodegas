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

var dialogos =
        {
            autoOpen: false,
            resizable: false,
            width: 760,
            height: 500,
            modal: true
        };
var dialogos1 =
        {
            autoOpen: false,
            resizable: false,
            width: 460,
            height: 320,
            modal: true
        };
function fn_dar_eliminar(e) {
    $("a.elimina").click(function() {
        id = $(this).parents("tr").find("td").eq(0).html();
        $(this).parents("tr").fadeOut("normal", function() {
            $(this).remove();
            Rtotal();
        });
    });
}

function agregarR() {
    $("#tblRepracion tbody").append("<tr>" +
            "<td align=center>" + $("#selectRepa").val() + "</td>" +
            "<td align=center>" + "1" + "</td>" +
            "<td align=center>" + $("#selectRepa option:selected").text() + "</td>" +
            "<td align=center>" + "$ " + $("#selectRepa").find('option:selected').data('foo') + "</td>" +
            "<td align=center>" + " <a class='elimina'><img src='../imagenes/delete.png' onclick='return fn_dar_eliminar(event)' title='Borrar fila'/>" + "</td>" +
            "<td align=center style='display:none;'>" + "Servicio" + "</td>" + "</tr>");
    Rtotal();
}

function inicio() {
    $("#selectPro").focus(function() {
        $("#contador").val("0");
    });
    $("#selectPro").autocomplete({
        source: "../procesos/buscar_producto6.php",
        minLength: 1,
        focus: function(event, ui) {
            $("#selectPro").val(ui.item.value);
            $("#codigoPro").val(ui.item.cod_producto2);
            $("#precioPro").val(ui.item.precio2);
            //$("#contador").spinner({max: ui.item.disponibles});
            return false;
        },
        select: function(event, ui) {
            $("#selectPro").val(ui.item.value);
            $("#codigoPro").val(ui.item.cod_producto2);
            $("#precioPro").val(ui.item.precio2);
           // $("#contador").spinner({max: ui.item.disponibles});
            return false;
        }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);

    };
    ////////////
    $("#agrePro").on("click", agregarProducto);
    ///////////
    $(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#grilla').width() - 10);
    }).trigger('resize');
    $("#btnGuardar").on("click", guardarTrabajo);
    $("#btnDetTec").on("click", guardarReco);
    $("#agreDa").on("click", agregarR);
    $("#tRepraciones").dialog(dialogos);
    $("#btnAgregar").on("click", function() {
        $("#tRepraciones").dialog('open');
    });
    $("#modDetTec").dialog(dialogos1);
    $("#btnDetTecS").click(function() {
        $("#modDetTec").dialog('close');
        $("#idR").val("");
        $("#txtDetTe").val("");
    });
    $("#formReparaEquipo").css("display", "none");
    $("#botones a").on("click", Defecto);
    $("#modDetTec a").on("click", Defecto);
    $("#tRepraciones a").on("click", Defecto);
    $("#btnBuscar").on("click", function() {
        $("#grilla").css("display", "block");
        $("#formReparaEquipo").css("display", "none");
        ////cambiar el estado  
        $.ajax({
            type: "POST",
            url: "../procesos/cambioEstado.php",
            data: "id_registro=" + $("#txtRegistro").val() + "&tipo=" + "m",
            success: function(data) {
                val = data;
            }
        });
        ///
        limpiarDatos();

    });

    $("#btnModificar").button({
        icons: {
            primary: "ui-icon-pencil"
        }
    });

     $("#btnAgregar").click(function(e) {
        e.preventDefault();
    });
    
     $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnBuscar").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnDetTec").click(function(e) {
        e.preventDefault();
    });
    
     $("#btnDetTecS").click(function(e) {
        e.preventDefault();
    });
    
    $("#agrePro").click(function(e) {
        e.preventDefault();
    });
    
    $("#agreDa").click(function(e) {
        e.preventDefault();
    });
   
    $("#contador").spinner({max: 100, min: 0});
    jQuery("#list").jqGrid({
        url: '../xml/xmlreparacionEquipo.php',
        datatype: 'xml',
        colNames: ['Nro Registro', 'Nombres Cliente', 'Id Cliente', 'Fecha Ingreso', 'Fecha Salida', 'Nro. de Serie', 'Modelo', 'Id categoria', 'Tipo de Equipo', 'Id Marca', 'Marca', 'Id color', 'Nombre Color', 'Accesosios', 'Observaciones', 'Id Usuario', 'Registrado por', 'Id estado', 'Estado'],
        colModel: [
            {name: 'txtRegistro', index: 'txtRegistro', editable: true, align: 'center', width: '100', search: false, frozen: true},
            {name: 'txtCliente', index: 'txtCliente', editable: true, align: 'center', width: '150', search: true, frozen: true},
            {name: 'txtClienteId', index: 'txtClienteId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtIngreso', index: 'txtIngreso', editable: true, align: 'center', width: '150', search: false, frozen: true},
            {name: 'txtSalida', index: 'txtSalida', editable: true, align: 'center', width: '150', search: false, frozen: false},
            {name: 'txtSerie', index: 'txtSerie', editable: true, align: 'center', width: '180', search: true, frozen: false},
            {name: 'txtModelo', index: 'txtModelo', editable: true, align: 'center', width: '180', search: false, frozen: false},
            {name: 'txtTipoEquipoId', index: 'txtTipoEquipoId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtTipoEquipo', index: 'txtTipoEquipo', editable: true, align: 'center', width: '150', search: true, frozen: false},
            {name: 'txtMarcaId', index: 'txtMarcaId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtMarca', index: 'txtMarca', editable: true, align: 'center', width: '150', search: true, frozen: false},
            {name: 'txtColorId', index: 'txtColorId', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'txtColor', index: 'txtColor', editable: true, align: 'center', width: '150', search: true, frozen: false},
            {name: 'txtAccesorios', index: 'txtAccesorios', editable: true, align: 'center', width: '150', search: false, frozen: false},
            {name: 'txtObservaciones', index: 'txtObservaciones', editable: true, align: 'center', width: '150', search: false, frozen: false},
            {name: 'id_user', index: 'id_user', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'nombre_user', index: 'nombre_user', editable: true, align: 'center', width: '150', search: false, frozen: false},
            {name: 'id_estado', index: 'id_estado', search: false, editable: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 80},
            {name: 'Estado', index: 'Estado', editable: true, align: 'center', width: '150', search: true, frozen: false}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        height: 350,
        pager: jQuery('#pager'),
        sortname: 'id_registro',
        shrinkToFit: false,
        sortorder: 'asc',
        caption: 'Lista Equipos',
        viewrecords: true,
        gridview: true,
        ondblClickRow: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                jQuery("#list").jqGrid('GridToForm', id, "#formReparaEquipo");
                ////cambiar el estado  
                $.ajax({
                    type: "POST",
                    url: "../procesos/cambioEstado.php",
                    data: "id_registro=" + $("#txtRegistro").val() + "&tipo=" + "g",
                    success: function(data) {
                        val = data;
                    }
                });
                ///
                $("#formReparaEquipo").css("display", "block");
                $("#grilla").css("display", "none");
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
                jQuery("#list").jqGrid('GridToForm', id, "#formReparaEquipo");
                ////cambiar el estado  
                $.ajax({
                    type: "POST",
                    url: "../procesos/cambioEstado.php",
                    data: "id_registro=" + $("#txtRegistro").val() + "&tipo=" + "g",
                    success: function(data) {
                        val = data;
                    }
                });
                ///
                $("#formReparaEquipo").css("display", "block");
                $("#grilla").css("display", "none");
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
    
    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "Técnicos",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                $("#idR").val(ret.txtRegistro);
                $("#modDetTec").dialog('open');
                $.ajax({
                    type: "POST",
                    url: "../procesos/cargaReco.php",
                    data: "id=" + ret.txtRegistro,
                    success: function(data) {
                        val = data;
                        $("#txtDetTe").val(val);
                    }
                });
            } else {
              alertify.alert("Seleccione un fila");
            }
        }
    });
    jQuery("#list").jqGrid('setFrozenColumns');
    jQuery("#list").setGridWidth($('#grilla').width() - 10);
}
function limpiarDatos()
{
    $("#txtRegistro").val("");
    $("#txtCliente").val("");
    $("#txtClienteId").val("");
    $("#txtIngreso").val("");
    $("#txtMante").val("$ 0");
    $("#txtTipoEquipo").val("");
    $("#txtTipoEquipoId").val("");
    $("#txtModelo").val("");
    $("#txtSerie").val("");
    $("#txtColor").val("");
    $("#txtColorId").val("");
    $("#txtMarca").val("");
    $("#txtMarcaId").val("");
    $("#resp").val("");
    $("#txtObservaciones").val("");
    $("#txtAccesorios").val("");
    $("txtReco").val("");
    $("#tblRepracion tbody tr").remove();
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
    $("#txtMante").val("");
    $("#txtMante").val("$ " + total);
}
function guardarTrabajo() {
    var vect0 = new Array();
    var vect1 = new Array();
    var vect2 = new Array();
    var vect3 = new Array();
    var vect5 = new Array();
    cont = 0;
    $("#tblRepracion tbody tr").each(function(index3) {
        $(this).children("td").each(function(index3) {
            switch (index3) {
                case 0:
                    vect0[cont] = $(this).text();
                    break;
                case 1:
                    vect1[cont] = $(this).text();
                    break;
                case 2:
                    vect2[cont] = $(this).text();
                    break;
                case 3:
                    vect3[cont] = $(this).text().substr(2);
                    break;
                case 5:
                    vect5[cont] = $(this).text();
                    break;
            }
        });
        cont++;
    });
    if ($("#txtMante").val().substr(2) > 0)
    {
        $.ajax({
            type: "POST",
            url: "../procesos/reparacionEquipos.php",
            data: "id_registro=" + $("#txtRegistro").val() + "&total_reparaciones=" + $("#txtMante").val().substr(2) + "&vector0=" + vect0 + "&vector1=" + vect1 + "&vector2=" + vect2 + "&vector3=" + vect3 + "&vector5=" + vect5 + "&recomendacion=" + $("#txtReco").val() + "&tipo=" + "g",
            success: function(data) {
                var val = data;
                if (val == 1) {
                    alertify.alert("Datos Guardados", function(){location.reload();});
                }
                if (val == 0) {
                    alertify.alert("Error.. durante el proceso");
                }
            }
        });
    }
    else {
        alertify.alert("Antes de proceder ingrese las reparaciones realizadas")
        $("#tRepraciones").dialog("open");
    }
}

function guardarReco() {
    if ($("#txtDetTe").val() !== "") {
        $.ajax({
            type: "POST",
            url: "../procesos/agregarReco.php",
            data: "id=" + $("#idR").val() + "&reco=" + $("#txtDetTe").val(),
            success: function(data) {
                var val = data;
                if (val == 1) {
                    alert("Datos Agregados");
                    $("#modDetTec").dialog('close');
                    $("#idR").val("");
                    $("#txtDetTe").val("");
                } else {
                  alertify.alert("Error al momento de guardar");
                }
            }
        });
    } else {
      alertify.alert("Llene los campos antes de continuar");
    }
}
function agregarProducto() {
    var cont = $("#contador").val();
    cont = parseInt(cont);
    if ($("#selectPro").val()=="" ){
        alert("Seleccione un producto");
    }
    else {
        $("#tblRepracion tbody").append("<tr>" +
                "<td align=center>" + $("#codigoPro").val() + "</td>" +
                "<td align=center>" + $("#contador").val() + "</td>" +
                "<td align=center>" + $("#selectPro").val() + "</td>" +
                "<td align=center>" + "$ " + $("#contador").val() * $("#precioPro").val() + "</td>" +
                "<td align=center>" + " <a class='elimina'><img src='../imagenes/delete.png' onclick='return fn_dar_eliminar(event)' title='Borrar fila'/>" + "</td>" +
                "<td align=center style='display:none;'>" + "Producto" + "</td>" + "</tr>");
        Rtotal();
        $("#selectPro").val("");
    }
}