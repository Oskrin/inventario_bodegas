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
        url: '../xml/xmlUsuario.php',
        datatype: 'xml',
        colNames: ['Cod. Usuario', 'CI Usuario', 'Nombres Usuario', 'Apellidos Usuario', 'Dirección Usuario', 'Teléfono Usuario', 'Celular Usuario', 'E-mail Usuario', 'User', 'Clave', 'Bodega','Cargo'],
        colModel: [
            {name: 'id_usuario', index: 'id_usuario', editable: true, align: 'center', width: '100', search: false, frozen: true, editoptions: {readonly: 'readonly'}},
            {name: 'ci_usuario', index: 'ci_usuario', editable: true, align: 'center', width: '100', size: '10', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'nombre_usuario', index: 'nombre_usuario', editable: true, align: 'center', width: '140', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'apellido_usuario', index: 'apellido_usuario', editable: true, align: 'center', width: '140', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'direccion_usuario', index: 'direccion_usuario', editable: true, align: 'center', width: '140', search: false},
            {name: 'telefono_usuario', index: 'telefono_usuario', editable: true, align: 'center', width: '140', search: false},
            {name: 'celular_usuario', index: 'celular_usuario', editable: true, align: 'center', width: '140', search: false, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'email_usuario', index: 'email_usuario', editable: true, align: 'center', width: '140', search: false, formatter: 'email'},
            {name: 'user', index: 'user', editable: true, align: 'center', width: '140', search: false, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'password_usuario', index: 'password_usuario', editable: true, align: 'center', width: '140', search: false, formoptions: {elmsuffix: " (*)"}, editrules: {edithidden: true, required: true}, edittype: 'password', hidden: true},
            {name: 'id_bodega', index:'id_bodega', width:'300',search: false, align: 'center', editable:true, edittype:"select", editoptions:{dataUrl:'../procesos/retornar_combo.php', size: 1, cols:"20"}},
            {name: 'cargo_usuario', index: 'cargo_usuario', width:'300',search: false, align: 'center', editable: true, edittype: "select", editoptions: {value: "1:Administrador;2:Vendedor"}},
        ],
        rowNum: 10,
        rowList: [10, 20, 30],
        width: null,
        height: 400,
        pager: jQuery('#pager'),
        editurl: "../procesos/procesosUsuarios.php",
        sortname: 'id_usuario',
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista Usuarios',
        viewrecords: true
    }).jqGrid('navGrid', '#pager',
            {
                add: true,
                edit: true,
                del: false,
                refresh: true,
                search: true,
                view: true,
                addtext: "Nuevo",
                edittext: "Modificar",
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
    jQuery("#list").jqGrid('setFrozenColumns');
    jQuery("#list").setGridWidth($('#centro').width() - 10);
}

function Defecto(e) {
    e.preventDefault();
}

