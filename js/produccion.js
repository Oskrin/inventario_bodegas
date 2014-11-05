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
    $("#hora_actual").val(hours + ":" + minutes + ":" + seconds + " " + dn);

    setTimeout("show()", 1000);
}

var dialogos =
{
    autoOpen: false,
    resizable: false,
    width: 780,
    height: 350,
    modal: true
};

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

function enter2(event) {
    if (event.which === 13 || event.keyCode === 13) {
        entrar2();
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
                alertify.alert("Ingrese una cantidad");
            } else {
                if ($("#cantidad").val() === "0") {
                    $("#cantidad").val("");
                    $("#cantidad").focus();
                    alertify.alert("Ingrese una cantidad válida");
                } else {
                    var filas = jQuery("#list2").jqGrid("getRowData");
                    var su = 0;
                    if (filas.length === 0) {
                        var datarow = {
                            cod_productos: $("#cod_producto").val(), 
                            codigo: $("#codigo").val(), 
                            producto: $("#producto").val(), 
                            cantidad: $("#cantidad").val(), 
                            precio_v: $("#precio_v").val()
                            };
                        su = jQuery("#list2").jqGrid('addRowData', $("#cod_producto").val(), datarow);
                        $("#cod_producto").val("");
                        $("#codigo").val("");
                        $("#producto").val("");
                        $("#cantidad").val("");
                        $("#precio_v").val("");
                        $("#stock").val("");
                        $("#codigo").focus();
                    } else {
                        var repe = 0;
                        for (var i = 0; i < filas.length; i++) {
                            var id = filas[i];
                            if (id['cod_productos'] === $("#cod_producto").val()) {
                                repe = 1;
                            }
                        }
                        if (repe === 1) {
                            datarow = {
                                cod_productos: $("#cod_producto").val(), 
                                codigo: $("#codigo").val(), 
                                producto: $("#producto").val(), 
                                cantidad: $("#cantidad").val(), 
                                precio_v: $("#precio_v").val()
                                };
                            su = jQuery("#list2").jqGrid('setRowData', $("#cod_producto").val(), datarow);
                            $("#cod_producto").val("");
                            $("#codigo").val("");
                            $("#producto").val("");
                            $("#precio_v").val("");
                            $("#stock").val("");
                            $("#cantidad").val("");
                        } else {
                            $("#codigo").focus();
                            alertify.alert("Error... Solo se puede ingresar un producto a la vez");
                        }
                    }
                }
            }
        }
    }
}


function entrar2() {
    if ($("#cod_producto2").val() === "") {
        $("#codigo2").focus();
        alertify.alert("Ingrese un producto");
    } else {
        if ($("#producto2").val() === "") {
            $("#producto2").focus();
            alertify.alert("Ingrese un producto");
        } else {
            if ($("#cantidad2").val() === "") {
                $("#cantidad2").focus();
                alertify.alert("Ingrese una cantidad");
            } else {
                if ($("#precio2").val() === "") {
                    $("#precio2").focus();
                    alertify.alert("Ingrese precio costo");
                } else {
                    if ($("#cantidad2").val() === "0") {
                        $("#cantidad2").val("");
                        $("#cantidad2").focus();
                        alertify.alert("Ingrese una cantidad válida");
                    } else {
                        if (parseInt($("#cantidad2").val()) <= parseInt($("#disponibles").val())) {
                            var filas = jQuery("#list").jqGrid("getRowData");
                            var su = 0;
                            var total = 0;
                            if (filas.length === 0) {
                                total = ($("#cantidad2").val() * $("#precio2").val()).toFixed(2);
                                var datarow = {
                                    cod_productos: $("#cod_producto2").val(), 
                                    codigo: $("#codigo2").val(), 
                                    detalle: $("#producto2").val(), 
                                    cantidad: $("#cantidad2").val(), 
                                    precio_u: $("#precio2").val(), 
                                    total: total,
                                    stock: $("#disponibles").val()
                                   // oculto: $("#cantidad2").val() 
                                };
                                su = jQuery("#list").jqGrid('addRowData', $("#cod_producto2").val(), datarow);
                                $("#cod_producto2").val("");
                                $("#codigo2").val("");
                                $("#producto2").val("");
                                $("#cantidad2").val("");
                                $("#precio2").val("");
                                $("#p_venta2").val("");
                                $("#disponibles").val("");
                            } else {
                                var repe = 0;
                                for (var i = 0; i < filas.length; i++) {
                                    var id = filas[i];
                                    if (id['cod_productos'] === $("#cod_producto2").val()) {
                                        repe = 1;
                                    }
                                }
                                if (repe === 1) {
                                    total = ($("#cantidad2").val() * $("#precio2").val()).toFixed(2);
                                    datarow = {
                                        cod_productos: $("#cod_producto2").val(), 
                                        codigo: $("#codigo2").val(), 
                                        detalle: $("#producto2").val(), 
                                        cantidad: $("#cantidad2").val(), 
                                        precio_u: $("#precio2").val(), 
                                        total: total,
                                        stock: $("#disponibles").val()
                                        //oculto: $("#cantidad2").val() 
                                    };
                                    su = jQuery("#list").jqGrid('setRowData', $("#cod_producto2").val(), datarow);
                                    $("#cod_producto2").val("");
                                    $("#codigo2").val("");
                                    $("#producto2").val("");
                                    $("#cantidad2").val("");
                                    $("#precio2").val("");
                                    $("#p_venta2").val("");
                                    $("#disponibles").val("");
                                } else {
                                    total = ($("#cantidad2").val() * $("#precio2").val()).toFixed(2);
                                    datarow = {
                                        cod_productos: $("#cod_producto2").val(), 
                                        codigo: $("#codigo2").val(), 
                                        detalle: $("#producto2").val(), 
                                        cantidad: $("#cantidad2").val(), 
                                        precio_u: $("#precio2").val(), 
                                        total: total,
                                        stock: $("#disponibles").val()
                                        //oculto: $("#cantidad2").val() 
                                    };
                                    su = jQuery("#list").jqGrid('addRowData', $("#cod_producto2").val(), datarow);
                                    $("#cod_producto2").val("");
                                    $("#codigo2").val("");
                                    $("#producto2").val("");
                                    $("#cantidad2").val("");
                                    $("#precio2").val("");
                                    $("#p_venta2").val("");
                                    $("#disponibles").val("");
                                }
                            }

                            var fil = jQuery("#list").jqGrid("getRowData");
                            var subtotal = 0;
                            for (var t = 0; t < fil.length; t++) {
                                var dd = fil[t];
                                subtotal = (subtotal + parseFloat(dd['total']));
                                var sub = parseFloat(subtotal).toFixed(2);
                            }
                            $("#subtot").val(sub);
                            $("#codigo2").focus();
                        } else {
                            $("#cantidad2").focus();
                            alertify.alert("Error... Fuera de stock");
                        }
                    }
                }
            }
        }
    }
}

function guardar_ordenes() {
    var tam = jQuery("#list2").jqGrid("getRowData");
    var tam2 = jQuery("#list").jqGrid("getRowData");
    if (tam.length > 0) {
        if (tam2.length > 0) {

            /////////////////primera tabla/////////
            var v1 = new Array();
            var v2 = new Array();
            var string_v1 = "";
            var string_v2 = "";
            var fil = jQuery("#list2").jqGrid("getRowData");
            for (var i = 0; i < fil.length; i++) {
                var datos = fil[i];
                v1[i] = datos['cod_productos'];
                v2[i] = datos['cantidad'];
            }
            for (i = 0; i < fil.length; i++) {
                string_v1 = string_v1 + "|" + v1[i];
                string_v2 = string_v2 + "|" + v2[i];
            }
            //////////////////////////////

            /////////////////segunda tabla/////////
            var v3 = new Array();
            var v4 = new Array();
            var v5 = new Array();
            var v6 = new Array();
            var string_v3 = "";
            var string_v4 = "";
            var string_v5 = "";
            var string_v6 = "";
            var fil2 = jQuery("#list").jqGrid("getRowData");
            for (i = 0; i < fil2.length; i++) {
                var datos2 = fil2[i];
                v3[i] = datos2['cod_productos'];
                v4[i] = datos2['cantidad'];
                v5[i] = datos2['precio_u'];
                v6[i] = datos2['total'];
            }
            for (i = 0; i < fil2.length; i++) {
                string_v3 = string_v3 + "|" + v3[i];
                string_v4 = string_v4 + "|" + v4[i];
                string_v5 = string_v5 + "|" + v5[i];
                string_v6 = string_v6 + "|" + v6[i];
            }
            //////////////////////////////

            $.ajax({
                type: "POST",
                url: "../procesos/guardar_ordenes.php",
                data: "comprobante=" + $("#comprobante").val() + "&fecha_actual=" + $("#fecha_actual").val() + "&hora_actual=" + $("#hora_actual").val() + "&campo1=" + string_v1 + "&campo2=" + string_v2 + "&subtotal=" + $("#subtot").val() + "&campo3=" + string_v3 + "&campo4=" + string_v4 + "&campo5=" + string_v5 + "&campo6=" + string_v6,
                success: function(data) {
                    var val = data;
                    if (val == 1) {
                        alertify.alert(" Ordenes de producción guardada correctamente", function(){
                        window.open("../reportes/reportes/orden_produccion.php?hoja=A4&id="+$("#comprobante").val(),'_blank');
                        location.reload();
                        });
                    }
                }
            });
        } else {
            $("#codigo2").focus();
            alertify.alert("Error... Ingrese los componentes del producto");
        }
    } else {
        $("#codigo").focus();
        alertify.alert("Error... Ingrese el producto a realizar");
    }
}

function flecha_atras(){
    $.ajax({
        type: "POST",
        url: "../procesos/flechas.php",
        data: "comprobante=" + $("#comprobante").val() + "&tabla=" + "ordenes_produccion" + "&id_tabla=" + "id_ordenes" + "&tipo=" + 1,
        success: function(data) {
            var val = data;
            if(val != ""){
                $("#comprobante").val(val);
                var valor = $("#comprobante").val();
                ///////////////////llamar ordenes primera parte/////
                $("#btnGuardar").attr("disabled", true);
                $("#btnModificar").attr("disabled", true);
                $("#codigo").attr("disabled", "disabled");
                $("#producto").attr("disabled", "disabled");
                $("#cantidad").attr("disabled", "disabled");
                $("#codigo2").attr("disabled", "disabled");
                $("#producto2").attr("disabled", "disabled");
                $("#cantidad2").attr("disabled", "disabled");
                $("#precio2").attr("disabled", "disabled");
                $("#subtot").val("0.00");
                $("#list").jqGrid("clearGridData", true);
                $("#list2").jqGrid("clearGridData", true);

                $.getJSON('../procesos/retornar_ordenes.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 4)
                        {
                            $("#fecha_actual").val(data[i]);
                            $("#hora_actual").val(data[i + 1 ]);
                            $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                        }
                    }
                });
                ///////////////////////////////////////////////////   

                ///////////////////llamar ordenes segunda parte/////
                $.getJSON('../procesos/retornar_ordenes2.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 6)
                        {
                            var datarow = {
                                cod_productos: data[i], 
                                codigo: data[i + 1], 
                                producto: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_v: data[i + 4]
                            };
                            var su = jQuery("#list2").jqGrid('addRowData', data[i], datarow);
                            $("#subtot").val(data[5]);
                        //////////////////////////////////////
                        }
                    }
                });
                /////////////////////////////////////////////////////////

                ///////////////////llamar ordenes tercera parte/////
                $.getJSON('../procesos/retornar_ordenes3.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 6)
                        {
                            var datarow = {
                                cod_productos: data[i], 
                                codigo: data[i + 1], 
                                detalle: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_u: data[i + 4],
                                total: data[i + 5]
                            };
                            var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                        //////////////////////////////////////
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
        data: "comprobante=" + $("#comprobante").val() + "&tabla=" + "ordenes_produccion" + "&id_tabla=" + "id_ordenes" + "&tipo=" + 2,
        success: function(data) {
            var val = data;
            if(val != ""){
                $("#comprobante").val(val);
                var valor = $("#comprobante").val();
                ///////////////////llamar ordenes primera parte/////
                $("#btnGuardar").attr("disabled", true);
                $("#btnModificar").attr("disabled", true);
                $("#codigo").attr("disabled", "disabled");
                $("#producto").attr("disabled", "disabled");
                $("#cantidad").attr("disabled", "disabled");
                $("#codigo2").attr("disabled", "disabled");
                $("#producto2").attr("disabled", "disabled");
                $("#cantidad2").attr("disabled", "disabled");
                $("#precio2").attr("disabled", "disabled");
                $("#subtot").val("0.00");
                $("#list").jqGrid("clearGridData", true);
                $("#list2").jqGrid("clearGridData", true);

                $.getJSON('../procesos/retornar_ordenes.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 4)
                        {
                            $("#fecha_actual").val(data[i]);
                            $("#hora_actual").val(data[i + 1 ]);
                            $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                        }
                    }
                });
                ///////////////////////////////////////////////////  
                //  
                ///////////////////llamar ordenes segunda parte/////
                $.getJSON('../procesos/retornar_ordenes2.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 6)
                        {
                            var datarow = {
                                cod_productos: data[i], 
                                codigo: data[i + 1], 
                                producto: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_v: data[i + 4]
                            };
                            var su = jQuery("#list2").jqGrid('addRowData', data[i], datarow);
                            $("#subtot").val(data[5]);
                        }
                    }
                });
                /////////////////////////////////////////////////////////

                ///////////////////llamar ordenes tercera parte/////
                $.getJSON('../procesos/retornar_ordenes3.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 6)
                        {
                            var datarow = {
                                cod_productos: data[i], 
                                codigo: data[i + 1], 
                                detalle: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_u: data[i + 4],
                                total: data[i + 5]
                            };
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

function limpiar_ordenes(){
    location.reload(); 
}

function limpiar_campo1(){
    if($("#codigo").val() === ""){
        $("#producto").val("");
        $("#cantidad").val("");
        $("#precio_v").val("");
        $("#stock").val("");
        $("#cod_producto").val("");
    }
}

function limpiar_campo2(){
    if($("#producto").val() === ""){
        $("#codigo").val("");
        $("#cantidad").val("");
        $("#precio_v").val("");
        $("#stock").val("");
        $("#cod_producto").val("");
    }
}

function limpiar_campo3(){
    if($("#codigo2").val() === ""){
        $("#producto2").val("");
        $("#cantidad2").val("");
        $("#precio2").val("");
        $("#disponibles").val("");
        $("#cod_producto2").val("");
    }
}

function limpiar_campo4(){
    if($("#producto2").val() === ""){
        $("#codigo2").val("");
        $("#cantidad2").val("");
        $("#precio2").val("");
        $("#disponibles").val("");
        $("#cod_producto2").val("");
    }
}

function inicio() {
    jQuery().UItoTop({ easingType: 'easeOutQuart' });
    //////////////para hora///////////
    show();
    ///////////////////

    ///////botones ///////////////////
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    $("#btnModificar").click(function(e) {
        e.preventDefault();
    });
    $("#btnBuscar").click(function(e) {
        e.preventDefault();
        $("#ordenes").dialog("open");
    });
    $("#btnNuevo").click(function(e) {
        e.preventDefault();
    });
    $("#btnImprimir").click(function(e) {
        window.open("../reportes/reportes/orden_produccion.php?hoja=A4&id="+$("#comprobante").val(),'_blank');
    });
    $("#btnAtras").click(function(e) {
        e.preventDefault();
    });
    $("#btnAdelante").click(function(e) {
        e.preventDefault();
    });

    $("#btnGuardar").on("click", guardar_ordenes);
    $("#btnNuevo").on("click", limpiar_ordenes);
    $("#btnAtras").on("click", flecha_atras);
    $("#btnAdelante").on("click", flecha_siguiente);
    //////////////////////////

    $("#ordenes").dialog(dialogos);
    
    /////////////////////////////////
    $("#cantidad").validCampoFranz("0123456789");
    $("#cantidad2").validCampoFranz("0123456789");
    $("#precio_v").attr("disabled", "disabled");
    $("#stock").attr("disabled", "disabled");
    $("#disponibles").attr("disabled", "disabled");
    /////////////////////////////////////

    ////////////////eventos////////////////////
    $("#codigo").on("keyup", limpiar_campo1);
    $("#producto").on("keyup", limpiar_campo2);
    $("#codigo2").on("keyup", limpiar_campo3);
    $("#producto2").on("keyup", limpiar_campo4);
    
    $("#codigo").on("keypress", enter);
    $("#producto").on("keypress", enter);
    $("#cantidad").on("keypress", enter);
    /////////////////////////////////////////

    $("#codigo2").on("keypress", enter2);
    $("#producto2").on("keypress", enter2);
    $("#cantidad2").on("keypress", enter2);
    $("#precio2").on("keypress", enter2);
    //////////////para precio////////

    $("#precio2").keypress(function(e) {
        var key;
        if (window.event)
        {
            key = e.keyCode;
        }
        else if (e.which)
        {
            key = e.which;
        }

        if (key < 48 || key > 57)
        {
            if (key === 46 || key === 8)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return true;
    });

    $("#p_venta2").keypress(function(e) {
        var key;
        if (window.event)
        {
            key = e.keyCode;
        }
        else if (e.which)
        {
            key = e.which;
        }

        if (key < 48 || key > 57)
        {
            if (key === 46 || key === 8)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return true;
    });
    ////////////////////////////////

    /////buscador productos primera tabla///// 
    $("#codigo").autocomplete({
        source: "../procesos/buscar_producto3.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#codigo").val(ui.item.value);
        $("#producto").val(ui.item.producto);
        $("#precio_v").val(ui.item.precio_v);
        $("#stock").val(ui.item.stock);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        },
        select: function(event, ui) {
        $("#codigo").val(ui.item.value);
        $("#producto").val(ui.item.producto);
        $("#precio_v").val(ui.item.precio_v);
        $("#stock").val(ui.item.stock);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        }

        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };

    //////////////////////////////

    /////buscador productos primera tabla///// 
    $("#producto").autocomplete({
        source: "../procesos/buscar_producto4.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#producto").val(ui.item.value);
        $("#codigo").val(ui.item.codigo);
        $("#precio_v").val(ui.item.precio_v);
        $("#stock").val(ui.item.stock);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        },
        select: function(event, ui) {
        $("#producto").val(ui.item.value);
        $("#codigo").val(ui.item.codigo);
        $("#precio_v").val(ui.item.precio_v);
        $("#stock").val(ui.item.stock);
        $("#cod_producto").val(ui.item.cod_producto);
        return false;
        }

        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };

    //////////////////////////////

    /////buscador productos2 segunda tabla///// 
    $("#codigo2").autocomplete({
        source: "../procesos/buscar_producto5.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#codigo2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#producto2").val(ui.item.producto2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
        return false;
        },
        select: function(event, ui) {
        $("#codigo2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#producto2").val(ui.item.producto2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
        return false;
        }

        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
    //////////////////////////////

    /////buscador productos2 segunda tabla///// 
    $("#producto2").autocomplete({
        source: "../procesos/buscar_producto6.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#producto2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#codigo2").val(ui.item.codigo2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
        return false;
        },
        select: function(event, ui) {
        $("#producto2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#codigo2").val(ui.item.codigo2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
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

//////////////////////tabla productos/////////////////////////
    jQuery("#list").jqGrid({
        datatype: "local",
        colNames: ['', 'ID', 'Código', 'Producto', 'Cantidad', 'Precio Costo', 'Total', 'stock'],
        colModel: [
            {name: 'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
                formatoptions: {keys: false, delbutton: true, editbutton: false}
            },
            {name: 'cod_productos', index: 'cod_productos', editable: false, search: false, hidden: true, editrules: {edithidden: false}, align: 'center',
                frozen: true, width: 50},
            {name: 'codigo', index: 'codigo', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',
                frozen: true, width: 100},
            {name: 'detalle', index: 'detalle', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 290},
            {name: 'cantidad', index: 'cantidad', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 70},
            {name: 'precio_u', index: 'precio_u', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'total', index: 'total', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'stock', index: 'stock', editable: false, search: false, frozen: true, hidden: true, editrules: {required: true}, align: 'center', width: 110},
        ],
        rowNum: 30,
        width: 780,
        sortable: true,
        rowList: [10, 20, 30],
        pager: jQuery('#pager'),
        sortname: 'cod_productos',
        sortorder: 'asc',
        viewrecords: true,
        cellEdit: true,
        cellsubmit: 'clientArray',
        shrinkToFit: true,
        delOptions: {
            onclickSubmit: function(rp_ge, rowid) {
                var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
                jQuery('#list').jqGrid('restoreRow', id);
                var ret = jQuery("#list").jqGrid('getRowData', id);
                rp_ge.processing = true;
                var su = jQuery("#list").jqGrid('delRowData', rowid);
                if (su === true) {
                    var subtotal = $("#subtot").val();
                    var total = (subtotal - ret.total).toFixed(2);
                    $("#subtot").val(total);
                    $("#delmodlist").hide();
                }
                return true;
            },
            processing: true
        }
    });

    //////////////////////tabla detalle ordenes/////////////////////////
    jQuery("#list2").jqGrid({
        datatype: "local",
        colNames: ['', 'Id', 'Código', 'Producto', 'Cantidad','Precio'],
        colModel: [
            {name: 'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
                formatoptions: {keys: false, delbutton: true, editbutton: false}
            },
            {name: 'cod_productos', index: 'cod_productos', editable: false, search: false, hidden: true, editrules: {edithidden: false}, align: 'center',
                frozen: true, width: 50},
            {name: 'codigo', index: 'codigo', editable: false, search: false, hidden: false, editrules: {edithidden: true}, align: 'center',
                frozen: true, width: 150},
            {name: 'producto', index: 'producto', editable: false, search: false, hidden: false, editrules: {edithidden: true}, align: 'center',
                frozen: true, width: 350},
            {name: 'cantidad', index: 'cantidad', editable: false, search: false, hidden: false, editrules: {edithidden: true}, align: 'center',
                frozen: true, width: 120},
            {name: 'precio_v', index: 'precio_v', editable: false, search: false, hidden: false, editrules: {edithidden: true}, align: 'center',
                frozen: true, width: 120}
        ],
        rowNum: 30,
        width: 750,
        sortable: true,
        rowList: [10, 20, 30],
        pager: jQuery('#pager2'),
        sortname: 'cod_productos',
        sortorder: 'asc',
        viewrecords: true,
        cellEdit: true,
        cellsubmit: 'clientArray',
        shrinkToFit: true,
        delOptions: {
            onclickSubmit: function(rp_ge, rowid) {
                rp_ge.processing = true;
                var su = jQuery("#list2").jqGrid('delRowData', rowid);
                if (su === true) {
                    $("#delmodlist2").hide();
                }
                return true;
            },
            processing: true
        }
    }).jqGrid('navGrid', '#pager2',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: true
            });
            
     ////////////////////buscador ordenes/////////////////////////
        jQuery("#list3").jqGrid({
        url: '../xml/xmlBuscarOrdenes.php',
        datatype: 'xml',
        colNames: ['ID','CÓDIGO','BARRAS','PRODUCTO','TOTAL'],
        colModel: [
            {name: 'id_ordenes', index: 'id_ordenes', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 50},
            {name: 'codigo', index: 'codigo', editable: false, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 150},
            {name: 'cod_barras', index: 'cod_barras', editable: true, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 150},
            {name: 'articulo', index: 'articulo', editable: true, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 200},
            {name: 'sub_total', index: 'sub_total', editable: true, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 100},
        ],
        rowNum: 30,
        width: 750,
        height:220,
        sortable: true,
        rowList: [10, 20, 30],
        pager: jQuery('#pager3'),
        sortname: 'id_ordenes',
        sortorder: 'asc',
        viewrecords: true,              
        ondblClickRow: function(){
        var id = jQuery("#list3").jqGrid('getGridParam', 'selrow');
        jQuery('#list3').jqGrid('restoreRow', id);
        var ret = jQuery("#list3").jqGrid('getRowData', id);
        var valor = ret.id_ordenes;
    
        /////////////agregregar ordenes////////
        $("#btnGuardar").attr("disabled", true);
        $("#btnModificar").attr("disabled", true);
        $("#codigo").attr("disabled", "disabled");
        $("#producto").attr("disabled", "disabled");
        $("#cantidad").attr("disabled", "disabled");
        $("#codigo2").attr("disabled", "disabled");
        $("#producto2").attr("disabled", "disabled");
        $("#cantidad2").attr("disabled", "disabled");
        $("#precio2").attr("disabled", "disabled");
        $("#subtot").val("0.00");
        $("#list").jqGrid("clearGridData", true);
        $("#list2").jqGrid("clearGridData", true);
        
        $.getJSON('../procesos/retornar_ordenes.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 4)
                {
                    $("#fecha_actual").val(data[i]);
                    $("#hora_actual").val(data[i + 1 ]);
                    $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                }
            }
        });
        ///////////////////////////////////////////////////    
        //
        ///////////////////llamar ordenes segunda parte/////
        $.getJSON('../procesos/retornar_ordenes2.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 6)
                {
                  var datarow = {
                        cod_productos: data[i], 
                        codigo: data[i + 1], 
                        producto: data[i + 2], 
                        cantidad: data[i + 3], 
                        precio_v: data[i + 4]
                    };
                    var su = jQuery("#list2").jqGrid('addRowData', data[i], datarow);
                    $("#subtot").val(data[5]);
                }
            }
        });
        /////////////////////////////////////////////////////////
        
        ///////////////////llamar ordenes tercera parte/////
        $.getJSON('../procesos/retornar_ordenes3.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 6)
                {
                  var datarow = {
                        cod_productos: data[i], 
                        codigo: data[i + 1], 
                        detalle: data[i + 2], 
                        cantidad: data[i + 3], 
                        precio_u: data[i + 4],
                        total: data[i + 5]
                    };
                    var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                }
            }
        });
        /////////////////////////////////////////////////////////
          $("#ordenes").dialog("close");
    }  
        }).jqGrid('navGrid', '#pager3',
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
        
       jQuery("#list3").jqGrid('navButtonAdd', '#pager3', {caption: "Añadir",
       onClickButton: function() {
        var id = jQuery("#list3").jqGrid('getGridParam', 'selrow');
        jQuery('#list3').jqGrid('restoreRow', id);
        
        if (id) {
           var ret = jQuery("#list3").jqGrid('getRowData', id);
           var valor = ret.id_ordenes;
           
         /////////////agregregar ordenes////////
        $("#btnGuardar").attr("disabled", true);
        $("#btnModificar").attr("disabled", true);
        $("#codigo").attr("disabled", "disabled");
        $("#producto").attr("disabled", "disabled");
        $("#cantidad").attr("disabled", "disabled");
        $("#codigo2").attr("disabled", "disabled");
        $("#producto2").attr("disabled", "disabled");
        $("#cantidad2").attr("disabled", "disabled");
        $("#precio2").attr("disabled", "disabled");
        $("#subtot").val("0.00");
        $("#list").jqGrid("clearGridData", true);
        $("#list2").jqGrid("clearGridData", true);

        $.getJSON('../procesos/retornar_ordenes.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 4)
                {
                    $("#fecha_actual").val(data[i]);
                    $("#hora_actual").val(data[i + 1 ]);
                    $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                    
                }
            }
        });
        ///////////////////////////////////////////////////    
        //
        ///////////////////llamar ordenes segunda parte/////
        $.getJSON('../procesos/retornar_ordenes2.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 6)
                {
                  var datarow = {
                        cod_productos: data[i], 
                        codigo: data[i + 1], 
                        producto: data[i + 2], 
                        cantidad: data[i + 3], 
                        precio_v: data[i + 4]
                    };
                    var su = jQuery("#list2").jqGrid('addRowData', data[i], datarow);
                    $("#subtot").val(data[5]);
                //////////////////////////////////////
                }
            }
        });
        /////////////////////////////////////////////////////////
        
          ///////////////////llamar ordenes tercera parte/////
        $.getJSON('../procesos/retornar_ordenes3.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 6)
                {
                  var datarow = {
                        cod_productos: data[i], 
                        codigo: data[i + 1], 
                        detalle: data[i + 2], 
                        cantidad: data[i + 3], 
                        precio_u: data[i + 4],
                        total: data[i + 5]
                    };
                    var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                //////////////////////////////////////
                }
            }
        });
        /////////////////////////////////////////////////////////
        $("#ordenes").dialog("close");
        } else {
          alertify.alert("Seleccione una orden");
        }
    }
});    
}




