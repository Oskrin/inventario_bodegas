$(document).on("ready", inicio);

$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

function inicio() {
    $(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#centro').width() - 10);
    }).trigger('resize');
    jQuery("#list").jqGrid({
        url: '../xml/xmlProductosServicios.php',
        datatype: 'xml',
        colNames: ['Cod. Serv.', 'Servicio', 'Valor Servicio'],
        colModel: [
            {name: 'id_trabajo', index: 'id_trabajo', editable: true, align: 'center', width: '140', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: "", elmprefix: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"}},
            {name: 'nombre_trabajo', index: 'nombre_trabajo', editable: true, align: 'center', width: '470', search: true, frozen: true, formoptions: {elmsuffix: " (*)", elmprefix: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"}, editrules: {required: true}, edittype: "textarea", editoptions: {rows: "4", cols: "20"}},
            {name: 'precio_trabajo', index: 'precio_trabajo', editable: true, align: 'center', width: '200', search: true, frozen: true, formoptions: {elmsuffix: " (*)", elmprefix: " ($)"}, editrules: {required: true}}
        ],
        rowNum: 10,
        rowList: [10, 20, 30],
        height: 255,
        pager: jQuery('#pager'),
        editurl: "../procesos/productosServicios.php",
        sortname: 'id_trabajo',
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista Servicios',
        viewrecords: true
    }).jqGrid('navGrid', '#pager',
            {
                add: true,
                edit: true,
                del: false,
                refresh: true,                
                view: true,
                search: true,
                addtext: "Nuevo",
                edittext: "Modificar",
                refreshtext: "Recargar",
                viewtext: "Consultar"
            },
    {
        recreateForm: true, closeAfterEdit: true, checkOnUpdate: true, reloadAfterSubmit: true, closeOnEscape: true, width: 370
    },
    {
        reloadAfterSubmit: true, closeAfterAdd: true, checkOnUpdate: true, closeOnEscape: true,
        bottominfo: "Los campos marcados con (*) son obligatorios", width: 370, checkOnSubmit: false
    },
    {
        width: 370, closeOnEscape: true
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

    jQuery("#list").setGridWidth($('#centro').width() - 10);
}

function Defecto(e) {
    e.preventDefault();
}

