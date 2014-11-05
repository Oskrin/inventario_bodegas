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

function inicio()
{
    $(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#tablaEn').width() - 10);
    }).trigger('resize');
    jQuery("#list").jqGrid({
        url: '../xml/xmlRestablecer.php',
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
        height: 400,
        width: 400,
        pager: jQuery('#pager'),
        sortname: 'id_registro',
        shrinkToFit: false,
        forceFit: true,
        sortorder: 'asc',
        caption: 'Restablecer pedidos',
        viewrecords: true,
        gridview: true,
        ondblClickRow: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                $.ajax({
                    type: "POST",
                    url: "../procesos/restablecer.php",
                    data: "id=" + ret.txtRegistro,
                    success: function(response) {
                        val = response;
                        if (val == 1) {
                            alert("Datos Restablecidos");
                            $("#list").trigger("reloadGrid");
                        }
                        else {
                            alert("Error al restablecer datos");
                        }
                    }
                });
            }
        }
    }).jqGrid('navGrid', '#pager',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: false,
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
    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "Restablecer Producto",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            if (id) {
                var ret = jQuery("#list").jqGrid('getRowData', id);
                $.ajax({
                    type: "POST",
                    url: "../procesos/restablecer.php",
                    data: "id=" + ret.txtRegistro,
                    success: function(response) {
                        val = response;
                        if (val == 1) {
                            alert("Datos Restablecidos");
                            $("#list").trigger("reloadGrid");
                        }
                        else {
                            alert("Error al restablecer datos");
                        }
                    }
                });
            }
            else {
                alert("Seleccione un fila");
            }
        }
    });
    $("#list").jqGrid('setFrozenColumns');
    jQuery("#list").setGridWidth($('#tablaEn').width() - 10);
/////////////////////   
}