$(document).on("ready", inicio);
function evento(e) {
    e.preventDefault();
}

$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

var dialogo2 =
{
    autoOpen: false,
    resizable: false,
    width: 800,
    height: 350,
    modal: true,
    position: "top",
    show: "explode",
    hide: "blind"    
}

function scrollToBottom() {
    $('html, body').animate({
        scrollTop: $(document).height()
        }, 'slow');
}

function scrollToTop() {
    $('html, body').animate({
        scrollTop: 0
    }, 'slow');
}

function show() {
    var Digital = new Date();
    var hours = Digital.getHours();
    var minutes = Digital.getMinutes();
    var seconds = Digital.getSeconds();
    var dn = "AM";
    if (hours > 12) {
        dn = "PM";
        hours = hours - 12;
    }
    if (hours === 0)
        hours = 12;
    if (minutes <= 9)
        minutes = "0" + minutes;
    if (seconds <= 9)
        seconds = "0" + seconds;
    $("#hora_actual").val(hours + ":" + minutes + ":"+ seconds + " " + dn);
    
    setTimeout("show()", 1000);
}

function ValidNum(e) {
    if (e.keyCode < 48 || e.keyCode > 57) {
        e.returnValue = false;
    }
    return true;
}

function enter(event) {
    if (event.which === 13 || event.keyCode === 13) {
        entrar();
        return false;
    }
    return true;
}

function enter2(e) {
    if (e.which === 13 || e.keyCode === 13) {
        comprobar();
        return false;
    }
    return true;
}

function enter3(e) {
    if (e.which === 13 || e.keyCode === 13) {
        comprobar2();
        return false;
    }
    return true;
}

function entrar() {
    if ($("#cod_producto").val() === "") {
        $("#codigo").focus();
        alertify.alert("Ingrese un producto");
    } else {
        if ($("#producto").val() === "") {
            $("#producto").focus();
            alertify.alert("Ingrese un producto");
        } else {
            if ($("#cantidad").val() === "") {
                $("#cantidad").focus();
                alertify.alert("Ingrese una cantidad valida");
            } else {
                $("#precio").focus();
            }
        }
    }
}


function comprobar() {
    if ($("#cod_producto").val() === "") {
        $("#codigo").focus();
        alertify.alert("Ingrese un producto");
    } else {
        if ($("#codigo").val() === "") {
            $("#codigo").focus();
            alertify.alert("Ingrese un producto");
        } else {
            if ($("#producto").val() === "") {
                $("#producto").focus();
                alertify.alert("Ingrese un producto");
            } else {
                if ($("#cantidad").val() === "") {
                    $("#cantidad").focus();
                    alertify.alert("Ingrese una cantidad");
                } else {
                    if ($("#precio").val() === "") {
                        $("#precio").focus();
                        alertify.alert("Ingrese un precio");
                    } else {
                        $("#p_venta").focus();
                    }
                }
            }
        }
    }
}

function comprobar2() {
    if ($("#cod_producto").val() === "") {
        $("#codigo").focus();
        alertify.alert("Ingrese un producto");
    } else {
        if ($("#codigo").val() === "") {
            $("#codigo").focus();
            alertify.alert("Ingrese un producto");
        } else {
            if ($("#producto").val() === "") {
                $("#producto").focus();
                alertify.alert("Ingrese un producto");
            } else {
                if ($("#cantidad").val() === "") {
                    $("#cantidad").focus();
                    alertify.alert("Ingrese una cantidad");
                } else {
                    if ($("#precio").val() === "") {
                        $("#precio").focus();
                        alertify.alert("Ingrese un precio");
                    } else {
                        if ($("#p_venta").val() === "") {
                            $("#p_venta").focus();
                            alertify.alert("Ingrese un precio");
                        } else {
                             var filas = jQuery("#list").jqGrid("getRowData");
                            var descuento = 0;
                            var desc = 0;
                            var cal = 0;
                            var total = 0;
                            var su = 0;
                            if (filas.length === 0) {
                                if ($("#descuento").val() !== "")
                                {
                                    descuento = $("#descuento").val();
                                    desc = ((parseFloat($("#precio").val()) * parseFloat($("#descuento").val())) / 100);
                                    cal = (parseFloat($("#precio").val()) - desc).toFixed(2);
                                    total = ($("#cantidad").val() * cal).toFixed(2);
                                } else {
                                    descuento = 0;
                                    cal = parseFloat($("#precio").val()).toFixed(2);
                                    total = ($("#cantidad").val() * cal).toFixed(2);
                                }
                                var datarow = {
                                    cod_producto: $("#cod_producto").val(), 
                                    codigo: $("#codigo").val(), 
                                    detalle: $("#producto").val(), 
                                    cantidad: $("#cantidad").val(), 
                                    precio_u: cal, 
                                    descuento: descuento, 
                                    total: total, 
                                    iva: $("#iva_producto").val(), 
                                    precio_v: $("#p_venta").val()
                                    };
                                su = jQuery("#list").jqGrid('addRowData', $("#cod_producto").val(), datarow);
                                $("#cod_producto").val("");
                                $("#codigo").val("");
                                $("#producto").val("");
                                $("#cantidad").val("");
                                $("#precio").val("");
                                $("#p_venta").val("");
                                $("#descuento").val("");
                            }
                            else {
                                var repe = 0;
                                for (var i = 0; i < filas.length; i++) {
                                    var id = filas[i];
                                    if (id['cod_producto'] === $("#cod_producto").val()) {
                                        repe = 1;
                                    }
                                }
                                if (repe === 1) {
                                    if ($("#descuento").val() !== "")
                                    {
                                        descuento = $("#descuento").val();
                                        desc = ((parseFloat($("#precio").val()) * parseFloat($("#descuento").val())) / 100);
                                        cal = (parseFloat($("#precio").val()) - desc).toFixed(2);
                                        total = ($("#cantidad").val() * cal).toFixed(2);
                                    } else {
                                        descuento = 0;
                                        cal = parseFloat($("#precio").val()).toFixed(2);
                                        total = ($("#cantidad").val() * cal).toFixed(2);
                                    }
                                    datarow = {
                                        cod_producto: $("#cod_producto").val(), 
                                        codigo: $("#codigo").val(), 
                                        detalle: $("#producto").val(), 
                                        cantidad: $("#cantidad").val(), 
                                        precio_u: cal, 
                                        descuento: descuento, 
                                        total: total, 
                                        iva: $("#iva_producto").val(), 
                                        precio_v: $("#p_venta").val()
                                        };
                                    su = jQuery("#list").jqGrid('setRowData', $("#cod_producto").val(), datarow);
                                    $("#cod_producto").val("");
                                    $("#codigo").val("");
                                    $("#producto").val("");
                                    $("#cantidad").val("");
                                    $("#precio").val("");
                                    $("#p_venta").val("");
                                    $("#descuento").val("");
                                }
                                else {
                                    if ($("#descuento").val() !== "")
                                    {
                                        descuento = $("#descuento").val();
                                        desc = ((parseFloat($("#precio").val()) * parseFloat($("#descuento").val())) / 100);
                                        cal = (parseFloat($("#precio").val()) - desc).toFixed(2);
                                        total = ($("#cantidad").val() * cal).toFixed(2);
                                    } else {
                                        descuento = 0;
                                        cal = parseFloat($("#precio").val()).toFixed(2);
                                        total = ($("#cantidad").val() * cal).toFixed(2);
                                    }
                                    datarow = {
                                        cod_producto: $("#cod_producto").val(), 
                                        codigo: $("#codigo").val(), 
                                        detalle: $("#producto").val(), 
                                        cantidad: $("#cantidad").val(), 
                                        precio_u: cal, 
                                        descuento: descuento, 
                                        total: total, 
                                        iva: $("#iva_producto").val(), 
                                        precio_v: $("#p_venta").val()
                                        };
                                    su = jQuery("#list").jqGrid('addRowData', $("#cod_producto").val(), datarow);
                                    $("#cod_producto").val("");
                                    $("#codigo").val("");
                                    $("#producto").val("");
                                    $("#cantidad").val("");
                                    $("#precio").val("");
                                    $("#p_venta").val("");
                                    $("#descuento").val("");
                                }
                            }

                            if ($("#iva_producto").val() === "Si") {
                                var fil = jQuery("#list").jqGrid("getRowData");
                                var subtotal = 0;
                                var iva = 0;
                                var t_fc = 0;
                                for (var t = 0; t < fil.length; t++) {
                                    var dd = fil[t];
                                    if (dd['iva'] === "Si") {
                                        subtotal = (subtotal + parseFloat(dd['total']));
                                        iva = ((subtotal * 12) / 100).toFixed(2);
                                        var sub = parseFloat(subtotal).toFixed(2);
                                        t_fc = ((parseFloat(sub) + parseFloat(iva)) + parseFloat($("#total_p").val())).toFixed(2);
                                        $("#iva_producto option[value=" + 'Elija' + "]").attr("selected", true);
                                    }
                                }
                                
                                
                                $("#total_p2").val(sub);
                                $("#iva").val(iva);
                                $("#tot").val(t_fc);
                            } else {
                                if ($("#iva_producto").val() === "No") {
                                    fil = jQuery("#list").jqGrid("getRowData");
                                    subtotal = 0;
                                    t_fc = 0;
                                    iva = 0;
                                    for (t = 0; t < fil.length; t++) {
                                        dd = fil[t];
                                        if (dd['iva'] === "No") {
                                            subtotal = (subtotal + parseFloat(dd['total']));
                                            sub = parseFloat(subtotal).toFixed(2);
                                            iva = parseFloat($("#iva").val());
                                            t_fc = ((parseFloat(sub) + parseFloat(iva)) + parseFloat($("#total_p2").val())).toFixed(2);
                                            $("#iva_producto option[value=" + 'Elija' + "]").attr("selected", true);
                                        }
                                    }
                                    $("#total_p").val(sub);
                                    $("#tot").val(t_fc);
                                }
                            }
                            $("#codigo").focus();
                        }
                    }
                }
            }
        }
    }
}

function guardar_factura() {
    var tam = jQuery("#list").jqGrid("getRowData");
    
    if (tam.length === 0) {
        $("#codigo").focus();
        alertify.alert("Error... Ingrese productos");
    }else{
        var v1 = new Array();
        var v2 = new Array();
        var v3 = new Array();
        var v4 = new Array();
        var v5 = new Array();
        var string_v1 = "";
        var string_v2 = "";
        var string_v3 = "";
        var string_v4 = "";
        var string_v5 = "";
        var fil = jQuery("#list").jqGrid("getRowData");
        for (var i = 0; i < fil.length; i++) {
            var datos = fil[i];
            v1[i] = datos['cod_producto'];
            v2[i] = datos['cantidad'];
            v3[i] = datos['precio_u'];
            v4[i] = datos['descuento'];
            v5[i] = datos['total'];
        }
        for (i = 0; i < fil.length; i++) {
            string_v1 = string_v1 + "|" + v1[i];
            string_v2 = string_v2 + "|" + v2[i];
            string_v3 = string_v3 + "|" + v3[i];
            string_v4 = string_v4 + "|" + v4[i];
            string_v5 = string_v5 + "|" + v5[i];
        }
        
        $.ajax({
            type: "POST",
            url: "../procesos/guardar_egresos.php",
            data: "comprobante=" + $("#comprobante").val() + "&fecha_actual=" + $("#fecha_actual").val() + "&hora_actual=" + $("#hora_actual").val() + "&origen=" + $("#origen").val() + "&destino=" + $("#destino").val() + "&observaciones=" + $("#observaciones").val() + "&tarifa0=" + $("#total_p").val() + "&tarifa12=" + $("#total_p2").val() + "&iva=" + $("#iva").val() + "&desc=" + $("#desc").val() + "&tot=" + $("#tot").val() + "&campo1=" + string_v1 + "&campo2=" + string_v2 + "&campo3=" + string_v3 + "&campo4=" + string_v4 + "&campo5=" + string_v5,
            success: function(data) {
                var val = data;
                if (val == 1) {
                    alertify.alert("Egreso Guardado correctamente", function(){location.reload();});
                }
            }
        });
    }
}

function flecha_atras(){
    $.ajax({
        type: "POST",
        url: "../procesos/flechas.php",
        data: "comprobante=" + $("#comprobante").val() + "&tabla=" + "egresos" + "&id_tabla=" + "id_egresos" + "&tipo=" + 1,
        success: function(data) {
            var val = data;
            if(val != ""){
                $("#comprobante").val(val);
                var valor = $("#comprobante").val();
                
                 //////////////////////////////////////
                $("#btnGuardar").attr("disabled", true);
                $("#btnModificar").attr("disabled", true);

                $("#origen").attr("disabled", "disabled");
                $("#destino").attr("disabled", "disabled");
                $("#codigo").attr("disabled", "disabled");
                $("#producto").attr("disabled", "disabled");
                $("#cantidad").attr("disabled", "disabled");
                $("#descuento").attr("disabled", "disabled");
                $("#observaciones").attr("disabled", "disabled");

                $("#list").jqGrid("clearGridData", true);
                $("#total_p").val("0.00");
                $("#total_p2").val("0.00");
                $("#iva").val("0.00");
                $("#tot").val("0.00");

                ///////////////////llamar egresos primera parte/////
                $.getJSON('../procesos/retornar_egreso.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 12)
                        {
                            $("#fecha_actual").val(data[i]);
                            $("#hora_actual").val(data[i + 1 ]);
                            $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                            $("#origen").val(data[i + 4]);
                            $("#destino").val(data[i + 5]);
                            $("#observaciones").val(data[i + 6]);
                            $("#total_p").val(data[i + 7]);
                            $("#total_p2").val(data[i + 8]);
                            $("#iva").val(data[i + 9]);
                            $("#desc").val(data[i + 10]);
                            $("#tot").val(data[i + 11]);
                        }
                    }
                });
                ///////////////////////////////////////////////////   

                ////////////////////llamar egresos segunda parte/////
                $.getJSON('../procesos/retornar_egresos2.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 9)
                        {
                            var datarow = {cod_producto: data[i],
                                codigo: data[i + 1],
                                detalle: data[i + 2],
                                cantidad: data[i + 3],
                                precio_u: data[i + 4],
                                descuento: data[i + 5],
                                total: data[i + 6],
                                precio_v: data[i + 7],
                                iva: data[i + 8]};
                            var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                        }
                    }
                });
                }else{
                alertify.alert("No hay mas registros posteriores!!");
            }
        }
    });
} 

function flecha_siguiente(){
    
    $.ajax({
        type: "POST",
        url: "../procesos/flechas.php",
        data: "comprobante=" + $("#comprobante").val() + "&tabla=" + "egresos" + "&id_tabla=" + "id_egresos" + "&tipo=" + 2,
        success: function(data) {
            var val = data;
            if(val != ""){
                $("#comprobante").val(val);
                var valor = $("#comprobante").val();
                
                //////////////////////////////////////////////
                $("#origen").attr("disabled", "disabled");
                $("#destino").attr("disabled", "disabled");
                $("#codigo").attr("disabled", "disabled");
                $("#producto").attr("disabled", "disabled");
                $("#cantidad").attr("disabled", "disabled");
                $("#descuento").attr("disabled", "disabled");
                $("#observaciones").attr("disabled", "disabled");

                $("#list").jqGrid("clearGridData", true);
                $("#total_p").val("0.00");
                $("#total_p2").val("0.00");
                $("#iva").val("0.00");
                $("#tot").val("0.00");
                
                  ///////////////////llamar egresos primera parte/////
                $.getJSON('../procesos/retornar_egreso.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 12)
                        {
                            $("#fecha_actual").val(data[i]);
                            $("#hora_actual").val(data[i + 1 ]);
                            $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                            $("#origen").val(data[i + 4]);
                            $("#destino").val(data[i + 5]);
                            $("#observaciones").val(data[i + 6]);
                            $("#total_p").val(data[i + 7]);
                            $("#total_p2").val(data[i + 8]);
                            $("#iva").val(data[i + 9]);
                            $("#desc").val(data[i + 10]);
                            $("#tot").val(data[i + 11]);
                        }
                    }
                });
                ///////////////////////////////////////////////////   

                ////////////////////llamar egresos segunda parte/////
                $.getJSON('../procesos/retornar_egresos2.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                         for (var i = 0; i < tama; i = i + 9)
                        {
                            var datarow = {cod_producto: data[i],
                                codigo: data[i + 1],
                                detalle: data[i + 2],
                                cantidad: data[i + 3],
                                precio_u: data[i + 4],
                                descuento: data[i + 5],
                                total: data[i + 6],
                                precio_v: data[i + 7],
                                iva: data[i + 8]};
                            var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                        }
                    }
                });
              }else{
                alertify.alert("No hay mas registros superiores!!");
            }
        }
    });
} 

function limpiar_ingreso(){
    location.reload(); 
}

function limpiar_campo1(){
    if($("#codigo").val() === ""){
        $("#cod_producto").val("");
        $("#producto").val("");
        $("#cantidad").val("");
        $("#precio").val("");
        $("#p_venta").val("");
        $("#descuento").val("");
        $("#iva_producto option[value=" + 'Elija' + "]").attr("selected", true);
    }
}

function limpiar_campo2(){
    if($("#producto").val() === ""){
        $("#cod_producto").val("");
        $("#codigo").val("");
        $("#cantidad").val("");
        $("#precio").val("");
        $("#p_venta").val("");
        $("#descuento").val("");
        $("#iva_producto option[value=" + 'Elija' + "]").attr("selected", true);
    }
}

function punto(e){
var key;
if (window.event) {
    key = e.keyCode;
} else if (e.which) {
    key = e.which;
}

if (key < 48 || key > 57) {
    if (key === 46 || key === 8) {
        return true;
    } else {
        return false;
    }
}
return true;   
}

function inicio() {
jQuery().UItoTop({ easingType: 'easeOutQuart' });
    //////////////para hora///////////
    show();
    ///////////////////

    //////////////botones//////////
    $("#btnfacturas").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnModificar").click(function(e) {
        e.preventDefault();
    });

    $("#btnNuevo").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnImprimir").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnAtras").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnAdelante").click(function(e) {
        e.preventDefault();
    });
    ///////////////////////////////////

 
    $("#btnGuardar").on("click", guardar_factura);
    $("#btnNuevo").on("click", limpiar_ingreso);
    $("#btnAtras").on("click", flecha_atras);
    $("#btnAdelante").on("click", flecha_siguiente);
    //////////////////////////

    /////////////////////////////////
    $("#cantidad").validCampoFranz("0123456789");
    $("#descuento").validCampoFranz("0123456789");
    $("#descuento").attr("maxlength", "3");
    /////////////////////////////////////

    ////////////////eventos////////////////////
    $("#codigo").on("keyup", limpiar_campo1);
    $("#producto").on("keyup", limpiar_campo2);
    $("#codigo").on("keypress", enter);
    $("#producto").on("keypress", enter);
    $("#cantidad").on("keypress", enter);
    $("#precio").on("keypress", enter2);
    $("#p_venta").on("keypress", enter3);
    /////////////////////////////////////////

    $("#buscar_egresos").dialog(dialogo2);
    $("#btnBuscar").click(function(e) {
        e.preventDefault();
        $("#buscar_egresos").dialog("open");  
    });

    //////////////para precio////////
    $("#precio").on("keypress",punto);
    ////////////////////////////////

    /////buscador productos codigo///// 
    $("#codigo").autocomplete({
        source: "../procesos/buscar_producto11.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#codigo").val(ui.item.value);
        $("#producto").val(ui.item.producto);
        $("#precio").val(ui.item.precio);
        $("#p_venta").val(ui.item.p_venta);
        $("#iva_producto").val(ui.item.iva_producto);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        },
        select: function(event, ui) {
        $("#codigo").val(ui.item.value);
        $("#producto").val(ui.item.producto);
        $("#precio").val(ui.item.precio);
        $("#p_venta").val(ui.item.p_venta);
        $("#iva_producto").val(ui.item.iva_producto);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        }

        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };

    //////////////////////////////

    /////buscador productos nombre///// 
    $("#producto").autocomplete({
        source: "../procesos/buscar_producto22.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#producto").val(ui.item.value);
        $("#codigo").val(ui.item.codigo);
        $("#precio").val(ui.item.precio);
        $("#p_venta").val(ui.item.p_venta);
        $("#iva_producto").val(ui.item.iva_producto);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        },
        select: function(event, ui) {
        $("#producto").val(ui.item.value);
        $("#codigo").val(ui.item.codigo);
        $("#precio").val(ui.item.precio);
        $("#p_venta").val(ui.item.p_venta);
        $("#iva_producto").val(ui.item.iva_producto);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        }

        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };

//////////////////////////////

///////////calendarios/////
    $('#fecha_actual').datepicker({
        dateFormat: 'yy-mm-dd'
    });

//////////////////////tabla detalle/////////////////////////
    jQuery("#list").jqGrid({
        datatype: "local",
        colNames: ['', 'ID', 'Código', 'Producto', 'Cantidad', 'Precio Costo', 'Descuento', 'Total', 'Precio Venta', 'Iva'],
        colModel: [
            {name: 'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
                formatoptions: {keys: false, delbutton: true, editbutton: false}
            },
            {name: 'cod_producto', index: 'cod_producto', editable: false, search: false, hidden: true, editrules: {edithidden: false}, align: 'center',
                frozen: true, width: 50},
            {name: 'codigo', index: 'codigo', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',
                frozen: true, width: 100},
            {name: 'detalle', index: 'detalle', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 290},
            {name: 'cantidad', index: 'cantidad', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 70},
            {name: 'precio_u', index: 'precio_u', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'descuento', index: 'descuento', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'total', index: 'total', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'precio_v', index: 'precio_v', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'iva', index: 'iva', align: 'center', width: 100, hidden: true}
        ],
        rowNum: 30,
        width: 820,
        sortable: true,
        rowList: [10, 20, 30],
        pager: jQuery('#pager'),
        sortname: 'cod_producto',
        sortorder: 'asc',
        viewrecords: true,
        cellEdit: true,
        cellsubmit: 'clientArray',
        shrinkToFit: true,
        delOptions: {
            modal: true,
            jqModal: true,
            onclickSubmit: function(rp_ge, rowid) {
                var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
                jQuery('#list').jqGrid('restoreRow', id);
                var ret = jQuery("#list").jqGrid('getRowData', id);
                rp_ge.processing = true;
                var su = jQuery("#list").jqGrid('delRowData', rowid);
                var tarifa12 = 0;
                var tarifa0 = 0;
                var iva = 0;
                var total_iva = 0;
                var total = 0;
                var total_to = 0;
                var total_to2 = 0;

                if (su === true) {
                    if (ret.iva === "Si") {
                        tarifa12 = ($("#total_p2").val() - ret.total).toFixed(2);
                        $("#total_p2").val(tarifa12);
                        iva = $("#iva").val();
                        total_iva = ((ret.total * 12) / 100).toFixed(2);
                        iva = ($("#iva").val() - total_iva).toFixed(2);
                        $("#iva").val(iva);
                        total = (parseFloat(ret.total) + parseFloat(total_iva)).toFixed(2);
                        total_to = ($("#tot").val() - total).toFixed(2);
                        $("#tot").val(total_to);
                    } else {
                        if (ret.iva === "No") {
                            tarifa0 = ($("#total_p").val() - ret.total).toFixed(2);
                            $("#total_p").val(tarifa0);
                            total_to2 = ($("#tot").val() - ret.total).toFixed(2);
                            $("#tot").val(total_to2);
                        }
                    }
                }
                $(".ui-icon-closethick").trigger('click');
                return true;
            },
            processing: true
        },
        afterSaveCell : function(rowid,name,val,iRow,iCol) {
            var subtotal = 0;
            var iva = 0;
            var t_fc = 0;
            var mu = 0;
            var des = 0;
            var descu = 0;
            
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            jQuery('#list').jqGrid('restoreRow', id);
            var ret = jQuery("#list").jqGrid('getRowData', id);
            
            if(name == 'cantidad') {
               var precio = jQuery("#list").jqGrid('getCell',rowid,iCol+1);
               var operacion = (parseFloat(val)* parseFloat(precio)).toFixed(2); 
               jQuery("#list").jqGrid('setRowData',rowid,{total: operacion });
               
               if (ret.iva === "Si") {
                   var fil = jQuery("#list").jqGrid("getRowData");
                   for (var t = 0; t < fil.length; t++) {
                        var dd = fil[t];
                        if (dd['iva'] === "Si") {
                            subtotal = (subtotal + parseFloat(dd['total']));
                            var sub = parseFloat(subtotal).toFixed(2);

                            mu = (dd['cantidad'] * dd['precio_u']).toFixed(2);
                            des = ((mu * dd['descuento'])/100).toFixed(2);
                            descu = (parseFloat(descu) + parseFloat(des)).toFixed(2);
                            $("#iva_producto").val("");
                        }
                    }
                    iva = ((subtotal * 12) / 100).toFixed(2);
                    t_fc = ((parseFloat(subtotal) + parseFloat(iva)) + parseFloat($("#total_p").val())).toFixed(2);
                    $("#total_p2").val(sub);
                    $("#iva").val(iva);
                    $("#desc").val(descu);
                    $("#tot").val(t_fc);
               }else{
                    fil = jQuery("#list").jqGrid("getRowData");
                    subtotal = 0;
                    t_fc = 0;
                    iva = 0;
                    mu = 0;
                    des = 0;
                    descu = 0;
                    for (t = 0; t < fil.length; t++) {
                    dd = fil[t];
                    if (dd['iva'] === "No") {
                        subtotal = (subtotal + parseFloat(dd['total']));
                        sub = parseFloat(subtotal).toFixed(2);
                        mu = (dd['cantidad'] * dd['precio_u']).toFixed(2);
                        des = ((mu * dd['descuento'])/100).toFixed(2);
                        descu = (parseFloat(descu) + parseFloat(des)).toFixed(2);
                        $("#iva_producto").val("");
                    }
                }
                iva = parseFloat($("#iva").val());
                t_fc = ((parseFloat(subtotal) + parseFloat(iva)) + parseFloat($("#total_p2").val())).toFixed(2);
                $("#total_p").val(sub);
                $("#desc").val(descu);
                $("#tot").val(t_fc);
               }
            }
            
            if(name == 'precio_u') {
               var cantidad = jQuery("#list").jqGrid('getCell',rowid,iCol-1);
               var operacion2 = (parseFloat(cantidad) * parseFloat(val)).toFixed(2); 
               jQuery("#list").jqGrid('setRowData',rowid,{total: operacion2});
               
               if (ret.iva === "Si") {
                   fil = jQuery("#list").jqGrid("getRowData");
                   for (t = 0; t < fil.length; t++) {
                        dd = fil[t];
                        if (dd['iva'] === "Si") {
                            subtotal = (subtotal + parseFloat(dd['total']));
                            sub = parseFloat(subtotal).toFixed(2);

                            mu = (dd['cantidad'] * dd['precio_u']).toFixed(2);
                            des = ((mu * dd['descuento'])/100).toFixed(2);
                            descu = (parseFloat(descu) + parseFloat(des)).toFixed(2);
                            $("#iva_producto").val("");
                        }
                    }
                    
                    iva = ((subtotal * 12) / 100).toFixed(2);
                    t_fc = ((parseFloat(subtotal) + parseFloat(iva)) + parseFloat($("#total_p").val())).toFixed(2);
                    $("#total_p2").val(sub);
                    $("#iva").val(iva);
                    $("#desc").val(descu);
                    $("#tot").val(t_fc);
               }else{
                    fil = jQuery("#list").jqGrid("getRowData");
                    subtotal = 0;
                    t_fc = 0;
                    iva = 0;
                    mu = 0;
                    des = 0;
                    descu = 0;
                    for (t = 0; t < fil.length; t++) {
                    dd = fil[t];
                    if (dd['iva'] === "No") {
                        subtotal = (subtotal + parseFloat(dd['total']));
                        sub = parseFloat(subtotal).toFixed(2);
                        mu = (dd['cantidad'] * dd['precio_u']).toFixed(2);
                        des = ((mu * dd['descuento'])/100).toFixed(2);
                        descu = (parseFloat(descu) + parseFloat(des)).toFixed(2);
                        $("#iva_producto").val("");
                    }
                }
                iva = parseFloat($("#iva").val());
                t_fc = ((parseFloat(subtotal) + parseFloat(iva)) + parseFloat($("#total_p2").val())).toFixed(2);
                $("#total_p").val(sub);
                $("#desc").val(descu);
                $("#tot").val(t_fc);
               }
            }
        }
    });
    ///////////////////////////////////////////////////////
    
    ////////////////////buscador egresos/////////////////////////
        jQuery("#list2").jqGrid({
        url: '../xml/xmlBuscarEgresos.php',
        datatype: 'xml',
        colNames: ['COMPROBANTE','ORIGEN','DESTINO','NOMBRE','APELLIDO'],
        colModel: [
            {name: 'id_egresos', index: 'id_egresos', editable: false, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 100},
            {name: 'origen', index: 'origen', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 150},
            {name: 'destino', index: 'destino', editable: true, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 150},
            {name: 'nombre_usuario', index: 'nombre_usuario', editable: true, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 100},
            {name: 'apellido_usuario', index: 'apellido_usuario', editable: true, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 100},
        ],
        rowNum: 30,
        width: 750,
        height:220,
        sortable: true,
        rowList: [10, 20, 30],
        pager: jQuery('#pager2'),
        sortname: 'id_egresos',
        sortorder: 'asc',
        viewrecords: true,              
        ondblClickRow: function(){
        var id = jQuery("#list2").jqGrid('getGridParam', 'selrow');
        jQuery('#list2').jqGrid('restoreRow', id);
        
        if (id) {
           var ret = jQuery("#list2").jqGrid('getRowData', id);
           var valor = ret.id_egresos;
            /////////////agregregar egresos////////
            $("#comprobante").val(valor);
            $("#btnGuardar").attr("disabled", true);
            $("#btnModificar").attr("disabled", true);

            $("#origen").attr("disabled", "disabled");
            $("#destino").attr("disabled", "disabled");
            $("#codigo").attr("disabled", "disabled");
            $("#producto").attr("disabled", "disabled");
            $("#cantidad").attr("disabled", "disabled");
            $("#descuento").attr("disabled", "disabled");
            $("#observaciones").attr("disabled", "disabled");

            $("#list").jqGrid("clearGridData", true);
            $("#total_p").val("0.00");
            $("#total_p2").val("0.00");
            $("#iva").val("0.00");
            $("#tot").val("0.00");

            $.getJSON('../procesos/retornar_egreso.php?com=' + valor, function(data) {
                var tama = data.length;
                if (tama !== 0) {
                    for (var i = 0; i < tama; i = i + 12)
                    {
                        $("#fecha_actual").val(data[i]);
                        $("#hora_actual").val(data[i + 1 ]);
                        $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                        $("#origen").val(data[i + 4]);
                        $("#destino").val(data[i + 5]);
                        $("#observaciones").val(data[i + 6]);
                        $("#total_p").val(data[i + 7]);
                        $("#total_p2").val(data[i + 8]);
                        $("#iva").val(data[i + 9]);
                        $("#desc").val(data[i + 10]);
                        $("#tot").val(data[i + 11]);
                    }
                }
            });
            ///////////////////////////////////////////////////   

            ////////////////////llamar egresos segunda parte/////
            $.getJSON('../procesos/retornar_egresos2.php?com=' + valor, function(data) {
                var tama = data.length;
                if (tama !== 0) {
                   for (var i = 0; i < tama; i = i + 9)
                       {
                        var datarow = {cod_producto: data[i],
                            codigo: data[i + 1],
                            detalle: data[i + 2],
                            cantidad: data[i + 3],
                            precio_u: data[i + 4],
                            descuento: data[i + 5],
                            total: data[i + 6],
                            precio_v: data[i + 7],
                            iva: data[i + 8]};
                        var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                      }
                  }
            });
 
        $("#buscar_egresos").dialog("close");
        } else {
            alertify.alert("Seleccione un Egreso");
        }
    }
        
        }).jqGrid('navGrid', '#pager2',
        {
            add: false,
            edit: false,
            del: false,
            refresh: true,
            search: true,
            view: true
        },{
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
            closeOnEscape: true,        
            multipleSearch: false, overlay: false
        },
        {
        },
        {
            closeOnEscape: true
        });
        
       jQuery("#list2").jqGrid('navButtonAdd', '#pager2', {caption: "Añadir",
       onClickButton: function() {
        var id = jQuery("#list2").jqGrid('getGridParam', 'selrow');
        jQuery('#list2').jqGrid('restoreRow', id);
        if (id) {
           var ret = jQuery("#list2").jqGrid('getRowData', id);
           var valor = ret.id_egresos;
            /////////////agregregar egresos////////
            $("#comprobante").val(valor);
            $("#btnGuardar").attr("disabled", true);
            $("#btnModificar").attr("disabled", true);

            $("#origen").attr("disabled", "disabled");
            $("#destino").attr("disabled", "disabled");
            $("#codigo").attr("disabled", "disabled");
            $("#producto").attr("disabled", "disabled");
            $("#cantidad").attr("disabled", "disabled");
            $("#descuento").attr("disabled", "disabled");
            $("#observaciones").attr("disabled", "disabled");

            $("#list").jqGrid("clearGridData", true);
            $("#total_p").val("0.00");
            $("#total_p2").val("0.00");
            $("#iva").val("0.00");
            $("#tot").val("0.00");

            $.getJSON('../procesos/retornar_egreso.php?com=' + valor, function(data) {
                var tama = data.length;
                if (tama !== 0) {
                    for (var i = 0; i < tama; i = i + 12)
                    {
                        $("#fecha_actual").val(data[i]);
                        $("#hora_actual").val(data[i + 1 ]);
                        $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                        $("#origen").val(data[i + 4]);
                        $("#destino").val(data[i + 5]);
                        $("#observaciones").val(data[i + 6]);
                        $("#total_p").val(data[i + 7]);
                        $("#total_p2").val(data[i + 8]);
                        $("#iva").val(data[i + 9]);
                        $("#desc").val(data[i + 10]);
                        $("#tot").val(data[i + 11]);
                    }
                }
            });
            ///////////////////////////////////////////////////   

            ////////////////////llamar egresos segunda parte/////
            $.getJSON('../procesos/retornar_egresos2.php?com=' + valor, function(data) {
                var tama = data.length;
                if (tama !== 0) {
                    for (var i = 0; i < tama; i = i + 9)
                    {
                        var datarow = {cod_producto: data[i],
                            codigo: data[i + 1],
                            detalle: data[i + 2],
                            cantidad: data[i + 3],
                            precio_u: data[i + 4],
                            descuento: data[i + 5],
                            total: data[i + 6],
                            precio_v: data[i + 7],
                            iva: data[i + 8]};
                        var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                    }
                }
            });
 
         $("#buscar_egresos").dialog("close");
        } else {
          alertify.alert("Seleccione un Egreso");
        }
    }
});
}
