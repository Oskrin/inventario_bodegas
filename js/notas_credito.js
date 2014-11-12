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

var dialogo =
{
    autoOpen: false,
    resizable: false,
    width: 600,
    height: 420,
    modal: true
};

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

function ValidNum(e) {
    if (e.keyCode < 48 || e.keyCode > 57) {
        e.returnValue = false;
    }
    return true;
}

function enter(e) {
    if (e.which === 13 || e.keyCode === 13) {
        entrar();
        return false;
    }
    return true;
}

function enter2(e) {
    if (e.which === 13 || e.keyCode === 13) {
        entrar2();
        return false;
    }
    return true;
}

function enter3(e) {
    if (e.which === 13 || e.keyCode === 13) {
        comprobar();
        return false;
    }
    return true;
}

function entrar() {
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
                    if ($("#cantidad").val() === "0") {
                        $("#cantidad").focus();
                        alertify.alert("Ingrese una cantidad");
                    } else {
                        if (parseInt($("#cantidad").val()) > parseInt($("#canti").val())) {
                            $("#cantidad").focus();
                            alertify.alert("Error.. La catidad ingresada es mayor a la de compra");
                        } else {
                            $("#precio").focus();
                        }
                    }
                }
            }
        }
    }
}

function entrar2() {
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
                    if ($("#cantidad").val() === "0") {
                        $("#cantidad").focus();
                        alertify.alert("Ingrese una cantidad");
                    } else {
                        if (parseInt($("#cantidad").val()) > parseInt($("#canti").val())) {
                            $("#cantidad").focus();
                            alertify.alert("Error.. La catidad ingresada es mayor a la de compra");
                        } else {                  
                            if ($("#precio").val() === "") {
                                $("#precio").focus();
                                alertify.alert("Ingrese un precio");
                            } else {
                                if($("#estado").val() == "Pasivo"){
                                    $("#cod_producto").val("");
                                    $("#codigo").val("");
                                    $("#producto").val("");
                                    $("#cantidad").val("");
                                    $("#precio").val("");
                                    $("#descuento").val("");
                                    $("#canti").val("");
                                    $("#estado").val("");
                                    $("#codigo").focus();
                                    alertify.alert("El producto ya fue devuelto");
                                } else {
                                    var filas = jQuery("#list").jqGrid("getRowData");
                                    var descuento = 0;
                                    var cal = 0;
                                    var total = 0;
                                    var su = 0;
                                    var desc = 0;
                                    var precio = 0;
                                    var multi = 0;
                                    if (filas.length === 0) {
                                        if ($("#descuento").val() !== 0) {
                                        desc = $("#descuento").val();
                                        precio = (parseFloat($("#precio").val())).toFixed(2);
                                        multi = ($("#cantidad").val() * precio).toFixed(2);
                                        descuento = ((multi * parseFloat($("#descuento").val())) / 100);
                                        total = (multi - descuento).toFixed(2);
                                        } else {
                                            desc = $("#descuento").val();
                                            precio = (parseFloat($("#precio").val())).toFixed(2);
                                            total = ($("#cantidad").val() * precio).toFixed(2);
                                        }
                                        var datarow = {
                                            cod_producto: $("#cod_producto").val(), 
                                            codigo: $("#codigo").val(), 
                                            detalle: $("#producto").val(), 
                                            cantidad: $("#cantidad").val(), 
                                            precio_u: precio, 
                                            descuento: desc, 
                                            precio_t: total, 
                                            iva: $("#iva_producto").val()
                                            };
                                        su = jQuery("#list").jqGrid('addRowData', $("#cod_producto").val(), datarow);
                                        ////////limpiar///////////
                                        $("#cod_producto").val("");
                                        $("#codigo").val("");
                                        $("#producto").val("");
                                        $("#cantidad").val("");
                                        $("#precio").val("");
                                        $("#canti").val("");
                                        $("#descuento").val("");
                                        $("#estado").val("");
                                    ///////////////////////////
                                    } else {
                                        var repe = 0;
                                        for (var i = 0; i < filas.length; i++) {
                                            var id = filas[i];
                                            if (id['cod_producto'] === $("#cod_producto").val()) {
                                                repe = 1;
                                            }
                                        }
                                        if (repe === 1) {
                                            if ($("#descuento").val() !== 0) {
                                            desc = $("#descuento").val();
                                            precio = (parseFloat($("#precio").val())).toFixed(2);
                                            multi = ($("#cantidad").val() * precio).toFixed(2);
                                            descuento = ((multi * parseFloat($("#descuento").val())) / 100);
                                            total = (multi - descuento).toFixed(2);
                                            } else {
                                                desc = $("#descuento").val();
                                                precio = (parseFloat($("#precio").val())).toFixed(2);
                                                total = ($("#cantidad").val() * precio).toFixed(2);
                                            }
                                            
                                            datarow = {
                                                cod_producto: $("#cod_producto").val(), 
                                                codigo: $("#codigo").val(), 
                                                detalle: $("#producto").val(), 
                                                cantidad: $("#cantidad").val(), 
                                                precio_u: precio, 
                                                descuento: desc, 
                                                precio_t: total, 
                                                iva: $("#iva_producto").val()
                                                };
                                            su = jQuery("#list").jqGrid('setRowData', $("#cod_producto").val(), datarow);
                                            ////////limpiar///////////
                                            $("#cod_producto").val("");
                                            $("#codigo").val("");
                                            $("#producto").val("");
                                            $("#cantidad").val("");
                                            $("#precio").val("");
                                            $("#canti").val("");
                                            $("#descuento").val("");
                                            $("#estado").val("");
                                        ///////////////////////////
                                        } else {
                                            if ($("#descuento").val() !== 0) {
                                            desc = $("#descuento").val();
                                            precio = (parseFloat($("#precio").val())).toFixed(2);
                                            multi = ($("#cantidad").val() * precio).toFixed(2);
                                            descuento = ((multi * parseFloat($("#descuento").val())) / 100);
                                            total = (multi - descuento).toFixed(2);
                                            } else {
                                                desc = $("#descuento").val();
                                                precio = (parseFloat($("#precio").val())).toFixed(2);
                                                total = ($("#cantidad").val() * precio).toFixed(2);
                                            }
                                            
                                            datarow = {
                                                cod_producto: $("#cod_producto").val(), 
                                                codigo: $("#codigo").val(), 
                                                detalle: $("#producto").val(), 
                                                cantidad: $("#cantidad").val(), 
                                                precio_u: precio, 
                                                descuento: desc, 
                                                precio_t: total, 
                                                iva: $("#iva_producto").val()
                                                };
                                            su = jQuery("#list").jqGrid('addRowData', $("#cod_producto").val(), datarow);
                                            ////////limpiar///////////
                                            $("#cod_producto").val("");
                                            $("#codigo").val("");
                                            $("#producto").val("");
                                            $("#cantidad").val("");
                                            $("#precio").val("");
                                            $("#canti").val("");
                                            $("#descuento").val("");
                                            $("#estado").val("");
                                        ///////////////////////////
                                        }
                                    }

                                    if ($("#iva_producto").val() === "Si") {
                                        var fil = jQuery("#list").jqGrid("getRowData");
                                        var subtotal = 0;
                                        var iva = 0;
                                        var t_fc = 0;
                                        var mu = 0;
                                        var des = 0;
                                        var descu = 0;
                                        for (var t = 0; t < fil.length; t++) {
                                            var dd = fil[t];
                                            if (dd['iva'] === "Si") {
                                                subtotal = (subtotal + parseFloat(dd['precio_t']));
                                                iva = parseFloat((subtotal * 0.12)).toFixed(2);
                                                var sub = (parseFloat(subtotal) - parseFloat(iva)).toFixed(2);
                                                mu = (dd['cantidad'] * dd['precio_u']).toFixed(2);
                                                des = ((mu * dd['descuento'])/100).toFixed(2);
                                                descu = (parseFloat(descu) + parseFloat(des)).toFixed(2);
                                                t_fc = ((parseFloat(sub) + parseFloat(iva)) + parseFloat($("#total_p").val())).toFixed(2);
                                                $("#iva_producto option[value=" + 'Elija' + "]").attr("selected", true);
                                            }
                                        }
                                        $("#total_p2").val(sub);
                                        $("#iva").val(iva);
                                        $("#desc").val(descu);
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
                                                    subtotal = (subtotal + parseFloat(dd['precio_t']));
                                                    sub = parseFloat(subtotal).toFixed(2);
                                                    iva = parseFloat($("#iva").val());
                                                    mu = (dd['cantidad'] * dd['precio_u']).toFixed(2);
                                                    des = ((mu * dd['descuento'])/100).toFixed(2);
                                                    descu = (parseFloat(descu) + parseFloat(des)).toFixed(2);
                                                    t_fc = ((parseFloat(sub) + parseFloat(iva)) + parseFloat($("#total_p2").val())).toFixed(2);
                                                    $("#iva_producto option[value=" + 'Elija' + "]").attr("selected", true);
                                                }
                                            }
                                            $("#total_p").val(sub);
                                            $("#desc").val(descu);
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
    }
}

function comprobar() {
    if ($("#tipo_docu").val() === "") {
        $("#tipo_docu").focus();
        alertify.alert("Seleccione tipo documento");
    } else {
        if ($("#id_cliente").val() === "") {
            $("#ruc_ci").focus();
            alertify.alert("Indique un cliente");
        } else {
            if ($("#tipo_comprobante").val() === "") {
                $("#tipo_comprobante").focus();
                alertify.alert("Seleccione tipo comprobante");
            } else {
                if ($("#id_factura_venta").val() === "") {
                    $("#serie").focus();
                    alertify.alert("Seleccione una factura");
                } else {
                    $("#codigo").focus();
                }
            }
        }
    }
}

function agregar() {
    if ($("#serie").val() !== "") {
        var filas2 = jQuery("#list2").jqGrid("getRowData");
        var su;
        var count = 0;
        var canti = $("#cantidad").val();
        if (filas2.length < canti) {
            if (filas2.length === 0) {
                var datarow = {
                    id_serie: count = count + 1, 
                    serie: $("#serie").val()
                    };
                su = jQuery("#list2").jqGrid('addRowData', count, datarow);
                $("#serie").val("");
            } else {
                var repe = 0;
                for (var i = 0; i < filas2.length; i++) {
                    var id = filas2[i];
                    if (id['serie'] === $("#serie").val()) {
                        repe = 1;
                    }
                }
                if (repe === 0) {
                    datarow = {
                        id_serie: count = count + 1, 
                        serie: $("#serie").val()
                        };
                    su = jQuery("#list2").jqGrid('addRowData', count, datarow);
                    $("#serie").val("");
                } else {
                    $("#serie").val("");
                    alertify.alert("Error... La serie ya existe");
                }
            }
        } else {
            $("#serie").val("");
            $("#btnAgregar").attr("disabled", "disabled");
            alertify.alert("Error... Alcanzo el limite máximo");
        }
    } else {
        $("#serie").focus();
        alertify.alert("Error... Indique una serie");
    }
}


function guardar_serie() {
    var tam2 = jQuery("#list2").jqGrid("getRowData");
    if ($("#cod_producto").val() === "") {
        alertify.alert("Error... Seleccione un producto");
    } else {
        if (tam2.length > 0) {
            var v1 = new Array();
            var string_v1 = "";
            var fil = jQuery("#list2").jqGrid("getRowData");

            for (var i = 0; i < fil.length; i++) {
                var datos = fil[i];
                v1[i] = datos['serie'];
            }

            for (var i = 0; i < fil.length; i++) {
                string_v1 = string_v1 + "|" + v1[i];
            }
            $.ajax({
                type: "POST",
                url: "../procesos/guardar_series.php",
                data: "cod_producto=" + $("#cod_producto").val() + "&campo1=" + string_v1,
                success: function(data) {
                    var val = data;
                    if (val == 1) {
                        $("#series").dialog("close");
                        $("#descuento").focus();
                    }
                }
            });
        } else {
            alertify.alert("Error... Ingrese las series");
        }
    }
}

function guardar_devolucion() {
    var tam = jQuery("#list").jqGrid("getRowData");

    if ($("#tipo_docu").val() === "") {
        $("#tipo_docu").focus();
        alertify.alert("Seleccione tipo documento");
    } else {
        if ($("#id_cliente").val() === "") {
            $("#ruc_ci").focus();
            alertify.alert("Indique un cliente");
        } else {
            if ($("#tipo_comprobante").val() === "") {
                $("#tipo_comprobante").focus();
                alertify.alert("Seleccione tipo comprobante");
            } else {
                if ($("#id_factura_venta").val() === "") {
                    $("#serie").focus();
                    alertify.alert("Ingrese una factura valida");
                } else {
                    if ($("#autorizacion").val() === "") {
                        alertify.alert("Ingrese la autorización");
                        $("#autorizacion").focus();
                    } else {
                        if (tam.length === 0) {
                            alertify.alert("Error... Ingrese productos");
                        } else {
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
                                v5[i] = datos['precio_t'];
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
                                url: "../procesos/guardar_notas_credito.php",
                                data: "id_cliente=" + $("#id_cliente").val() + "&id_factura_venta=" + $("#id_factura_venta").val() + "&comprobante=" + $("#comprobante").val() + "&fecha_actual=" + $("#fecha_actual").val() + "&hora_actual=" + $("#hora_actual").val() + "&tipo_comprobante=" + $("#tipo_comprobante").val() + "&serie=" + $("#serie").val()+ "&tarifa0=" + $("#total_p").val() + "&tarifa12=" + $("#total_p2").val() + "&iva=" + $("#iva").val() + "&desc=" + $("#desc").val() + "&tot=" + $("#tot").val() + "&observaciones=" + $("#observaciones").val() + "&campo1=" + string_v1 + "&campo2=" + string_v2 + "&campo3=" + string_v3 + "&campo4=" + string_v4 + "&campo5=" + string_v5,
                                success: function(data) {
                                    var val = data;
                                    if (val == 1) {
                                        
                                        alertify.alert("Nota de Crédito guardada correctamente", function(){
                                        window.open("../reportes/reportes/notaCredito.php?id="+$("#comprobante").val());  
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
    }
}
    
function flecha_atras(){
   $.ajax({
        type: "POST",
        url: "../procesos/flechas.php",
        data: "comprobante=" + $("#comprobante").val() + "&tabla=" + "devolucion_venta" + "&id_tabla=" + "id_devolucion_venta" + "&tipo=" + 1,
        success: function(data) {
            var val = data;
            if(val != ""){
                $("#comprobante").val(val);
                var valor = $("#comprobante").val();
                
                ///////////////////llamar devolucion flechas primera parte/////
                $("#btnGuardar").attr("disabled", true);
                $("#btnModificar").attr("disabled", true);

                $("#num_factura").attr("disabled", "disabled");
                $("#ruc_ci").attr("disabled", "disabled");
                $("#nombre_cliente").attr("disabled", "disabled");
                $("#codigo").attr("disabled", "disabled");
                $("#producto").attr("disabled", "disabled");
                $("#cantidad").attr("disabled", "disabled");
                $("#precio").attr("disabled", "disabled");
                $("#observaciones").attr("disabled", "disabled");

                $("#list").jqGrid("clearGridData", true);
                $("#total_p").val("0.00");
                $("#total_p2").val("0.00");
                $("#iva").val("0.00");
                $("#tot").val("0.00");

                $.getJSON('../procesos/retornar_notas.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 18)
                        {
                            $("#fecha_actual").val(data[i]);
                            $("#hora_actual").val(data[i + 1 ]);
                            $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                            $("#id_cliente").val(data[i + 4]);
                            $("#tipo_docu").val(data[i + 5]);
                            $("#ruc_ci").val(data[i + 6]);
                            $("#nombre_cli").val(data[i + 7]);
                            $("#telefono_cli").val(data[i + 8]);
                            $("#direccion_cli").val(data[i + 9]);
                            $("#tipo_comprobante").val(data[i + 10]);
                            $("#serie").val(data[i + 11]);
                            $("#observaciones").val(data[i + 12]);
                            $("#total_p").val(data[i + 13]);
                            $("#total_p2").val(data[i + 14]);
                            $("#iva").val(data[i + 15]);
                            $("#desc").val(data[i + 16]);
                            $("#tot").val(data[i + 17]);
                        }
                    }
                });
                ///////////////////////////////////////////////////   
                //
                ////////////////////llamar devolucion segunda parte/////
                $.getJSON('../procesos/retornar_notas2.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 8)
                        {
                            var datarow = {
                                cod_producto: data[i], 
                                codigo: data[i + 1], 
                                detalle: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_u: data[i + 4], 
                                descuento: data[i + 5], 
                                precio_t: data[i + 6], 
                                iva: data[i + 7]
                            };
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
        data: "comprobante=" + $("#comprobante").val() + "&tabla=" + "devolucion_venta" + "&id_tabla=" + "id_devolucion_venta" + "&tipo=" + 2,
        success: function(data) {
            var val = data;
            if(val != ""){   
             $("#comprobante").val(val);
                var valor = $("#comprobante").val();
                ///////////////////llamar devolucion flechas primera parte/////
                $("#btnGuardar").attr("disabled", true);
                $("#btnModificar").attr("disabled", true);

                $("#num_factura").attr("disabled", "disabled");
                $("#ruc_ci").attr("disabled", "disabled");
                $("#nombre_cliente").attr("disabled", "disabled");
                $("#codigo").attr("disabled", "disabled");
                $("#producto").attr("disabled", "disabled");
                $("#cantidad").attr("disabled", "disabled");
                $("#precio").attr("disabled", "disabled");
                $("#observaciones").attr("disabled", "disabled");

                $("#list").jqGrid("clearGridData", true);
                $("#total_p").val("0.00");
                $("#total_p2").val("0.00");
                $("#iva").val("0.00");
                $("#tot").val("0.00");

                $.getJSON('../procesos/retornar_notas.php?com=' + valor, function(data) {
                var tama = data.length;
                if (tama !== 0) {
                    for (var i = 0; i < tama; i = i + 18)
                    {
                        $("#fecha_actual").val(data[i]);
                        $("#hora_actual").val(data[i + 1 ]);
                        $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                        $("#id_cliente").val(data[i + 4]);
                        $("#tipo_docu").val(data[i + 5]);
                        $("#ruc_ci").val(data[i + 6]);
                        $("#nombre_cli").val(data[i + 7]);
                        $("#telefono_cli").val(data[i + 8]);
                        $("#direccion_cli").val(data[i + 9]);
                        $("#tipo_comprobante").val(data[i + 10]);
                        $("#serie").val(data[i + 11]);
                        $("#observaciones").val(data[i + 12]);
                        $("#total_p").val(data[i + 13]);
                        $("#total_p2").val(data[i + 14]);
                        $("#iva").val(data[i + 15]);
                        $("#desc").val(data[i + 16]);
                        $("#tot").val(data[i + 17]);
                    }
                }
            });
            ///////////////////////////////////////////////////   

            ////////////////////llamar notas segunda parte/////
            $.getJSON('../procesos/retornar_notas2.php?com=' + valor, function(data) {
                var tama = data.length;
                if (tama !== 0) {
                    for (var i = 0; i < tama; i = i + 8)
                    {
                        var datarow = {
                            cod_producto: data[i], 
                            codigo: data[i + 1], 
                            detalle: data[i + 2], 
                            cantidad: data[i + 3], 
                            precio_u: data[i + 4], 
                            descuento: data[i + 5], 
                            precio_t: data[i + 6], 
                            iva: data[i + 7]
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

function limpiar_nota(){
    location.reload(); 
}

function limpiar_campo1(){
    if($("#ruc_ci").val() === ""){
        $("#id_cliente").val("");
        $("#nombre_cli").val("");
        $("#direccion_cli").val("");
        $("#telefono_cli").val("");
        $("#id_factura_venta").val("");
        $("#serie").val("");
    }
}

function limpiar_campo2(){
    if($("#serie").val() === ""){
        $("#id_factura_venta").val("");
        $("#cod_producto").val("");
        $("#codigo").val("");
        $("#producto").val("");
        $("#cantidad").val("");
        $("#precio").val("");
        $("#canti").val("");
        $("#descuento").val("");
    }
}

function limpiar_campo3(){
    if($("#codigo").val() === ""){
        $("#cod_producto").val("");
        $("#producto").val("");
        $("#cantidad").val("");
        $("#precio").val("");
        $("#canti").val("");
        $("#descuento").val("");
    }
}

function limpiar_campo4(){
    if($("#producto").val() === ""){
        $("#cod_producto").val("");
        $("#codigo").val("");
        $("#cantidad").val("");
        $("#precio").val("");
        $("#canti").val("");
        $("#descuento").val("");
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

    ///////botones ///////////////////
    $("#btncargar").click(function(e) {
        e.preventDefault();
    });
    $("#btnAgregar").click(function(e) {
        e.preventDefault();
    });
    $("#btnGuardarSeries").click(function(e) {
        e.preventDefault();
    });
    $("#btnCancelarSeries").click(function(e) {
        e.preventDefault();
    });

    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    $("#btnModificar").click(function(e) {
        e.preventDefault();
    });
    $("#btnCancelar").click(function(e) {
        e.preventDefault();
    });
    $("#btnNuevo").click(function(e) {
        e.preventDefault();
    });
    $("#btnImprimir").click(function (e){
        $.ajax({
        type: "POST",
        url: "../procesos/validacion.php",
        data: "comprobante=" + $("#comprobante").val() + "&tabla=" + "devolucion_venta" + "&id_tabla=" + "id_devolucion_venta" + "&tipo=" + 1,
        success: function(data) {
            var val = data;
            if(val != "") {
                window.open("../reportes/reportes/notaCredito.php?id="+$("#comprobante").val());  
            } else {
              alertify.alert("Nota de Crédito no creada!!");
            }   
          }
        }); 
    });

    $("#btnAgregar").on("click", agregar);
    $("#btnGuardarSeries").on("click", guardar_serie);
    $("#btnGuardar").on("click", guardar_devolucion);
    $("#btnNuevo").on("click", limpiar_nota);
    $("#btnAtras").on("click", flecha_atras);
    $("#btnAdelante").on("click", flecha_siguiente);
    //////////////////////////

    /////////////////////////// 
    $("#buscar_notas_credito").dialog(dialogo2);
    $("#btnBuscar").click(function(e) {
        e.preventDefault();
         $("#buscar_notas_credito").dialog("open");   
    });
    /////////////////////////// 

     /////////////////////////////////
    $("#cantidad").validCampoFranz("0123456789");
    $("#autorizacion").validCampoFranz("0123456789");
    $("#serie").validCampoFranz("0123456789");
    $("#serie").attr("disabled", "disabled");
    $("#serie").attr("maxlength", "17");
    $("#autorizacion").attr("disabled", "disabled");
    $("#descuento").validCampoFranz("0123456789");
    ///////////////////////////////////////////

    ////////////////eventos////////////////////
    //$("input[type=text]").on("keyup", enter);
    $("#ruc_ci").on("keyup", limpiar_campo1);
    $("#serie").on("keyup", limpiar_campo2);
    $("#codigo").on("keyup", limpiar_campo3);
    $("#producto").on("keyup", limpiar_campo4);
    $("#codigo").on("keypress", enter);
    $("#producto").on("keypress", enter);
    $("#cantidad").on("keypress", enter);
    $("#precio").on("keypress", enter2);
    $("#ruc_ci").on("keypress", enter3);
    $("#empresa").on("keypress", enter3);
    $("#serie").on("keypress", enter3);
    /////////////////////////////////////////

    //////////atributos////////////
    $("#ruc_ci").attr("disabled", "disabled");
    $("#empresa").attr("disabled", "disabled");
    $("#adelanto").attr("disabled", "disabled");
    $("#meses").attr("disabled", "disabled");
    $("#cuotas").attr("disabled", "disabled");
    /////////////////////////////////

    //////////////para precio////////
    $("#precio").on("keypress",punto);
   ////////////////////////////////

    ///////////////////buscar cliente/////////////////////
    $("#tipo_docu").change(function() {
        var tipo = $("#tipo_docu").val();
        if (tipo === "Cedula") {
            $("#ruc_ci").validCampoFranz("0123456789");
            $("#ruc_ci").removeAttr("disabled");
            $("#serie").removeAttr("disabled");
            $("#ruc_ci").attr("maxlength", "10");
            $("#ruc_ci").autocomplete({
                source: "../procesos/buscar_clientedev.php?tipo_docu=" + tipo,
                minLength: 1,
                focus: function(event, ui) {
                $("#ruc_ci").val(ui.item.value);
                $("#nombre_cli").val(ui.item.nombre_cli);
                $("#telefono_cli").val(ui.item.telefono_cli);
                $("#direccion_cli").val(ui.item.direccion_cli);
                $("#id_cliente").val(ui.item.id_cliente);
                return false;
                },
                select: function(event, ui) {
                $("#ruc_ci").val(ui.item.value);
                $("#nombre_cli").val(ui.item.nombre_cli);
                $("#telefono_cli").val(ui.item.telefono_cli);
                $("#direccion_cli").val(ui.item.direccion_cli);
                $("#id_cliente").val(ui.item.id_cliente);
                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
            //////////////////////////////
            $("#ruc_ci").val("");
            $("#nombre_cli").val("");
            $("#telefono_cli").val("");
            $("#direccion_cli").val("");
            $("#id_cliente").val("");
            $("#serie").val("");
            $("#id_factura_venta").val("");

        } else {
            if (tipo === "Ruc") {
                $("#ruc_ci").validCampoFranz("0123456789");
                $("#ruc_ci").removeAttr("disabled");
                $("#serie").removeAttr("disabled");
                $("#ruc_ci").removeAttr("maxlength");
                $("#ruc_ci").attr("maxlength", "13");
                $("#ruc_ci").autocomplete({
                    source: "../procesos/buscar_clientedev.php?tipo_docu=" + tipo,
                    minLength: 1,
                    focus: function(event, ui) {
                    $("#ruc_ci").val(ui.item.value);
                    $("#nombre_cli").val(ui.item.nombre_cli);
                    $("#telefono_cli").val(ui.item.telefono_cli);
                    $("#direccion_cli").val(ui.item.direccion_cli);
                    $("#id_cliente").val(ui.item.id_cliente);
                    return false;
                    },
                    select: function(event, ui) {
                    $("#ruc_ci").val(ui.item.value);
                    $("#nombre_cli").val(ui.item.nombre_cli);
                    $("#telefono_cli").val(ui.item.telefono_cli);
                    $("#direccion_cli").val(ui.item.direccion_cli);
                    $("#id_cliente").val(ui.item.id_cliente);
                    return false;
                    }

                    }).data("ui-autocomplete")._renderItem = function(ul, item) {
                    return $("<li>")
                    .append("<a>" + item.value + "</a>")
                    .appendTo(ul);
                };
                //////////////////////////////
                $("#ruc_ci").val("");
                $("#nombre_cli").val("");
                $("#telefono_cli").val("");
                $("#direccion_cli").val("");
                $("#id_cliente").val("");
                $("#serie").val("");
                $("#id_factura_venta").val("");
            } else {
                if (tipo === "Pasaporte") {
                    $("#ruc_ci").unbind("keypress");
                    $("#ruc_ci").removeAttr("disabled");
                    $("#serie").removeAttr("disabled");
                    $("#ruc_ci").attr("maxlength", "30");
                    $("#ruc_ci").autocomplete({
                        source: "../procesos/buscar_clientedev.php?tipo_docu=" + tipo,
                        minLength: 1,
                        focus: function(event, ui) {
                        $("#ruc_ci").val(ui.item.value);
                        $("#nombre_cli").val(ui.item.nombre_cli);
                        $("#telefono_cli").val(ui.item.telefono_cli);
                        $("#direccion_cli").val(ui.item.direccion_cli);
                        $("#id_cliente").val(ui.item.id_cliente);
                        return false;
                        },
                        select: function(event, ui) {
                        $("#ruc_ci").val(ui.item.value);
                        $("#nombre_cli").val(ui.item.nombre_cli);
                        $("#telefono_cli").val(ui.item.telefono_cli);
                        $("#direccion_cli").val(ui.item.direccion_cli);
                        $("#id_cliente").val(ui.item.id_cliente);
                        return false;
                        }

                        }).data("ui-autocomplete")._renderItem = function(ul, item) {
                        return $("<li>")
                        .append("<a>" + item.value + "</a>")
                        .appendTo(ul);
                    };
                    //////////////////////////////
                    $("#ruc_ci").val("");
                    $("#nombre_cli").val("");
                    $("#telefono_cli").val("");
                    $("#direccion_cli").val("");
                    $("#id_cliente").val("");
                    $("#serie").val("");
                    $("#id_factura_venta").val("");
                }
            }
        }
    });
    ////////////////////////////////////////////////////////////

    //////////////////buscar facturas///////////////////////////
    $("#serie").keyup(function(e) {
        var id = $("#id_cliente").val();
        if (id === "") {
            $("#ruc_ci").focus();
            $("#serie").val("");
            alertify.alert("Error... Seleccione un cliente");
        } else {
            $("#serie").autocomplete({
                source: "../procesos/buscar_facturas2.php?id=" + id,
                minLength: 1,
                focus: function(event, ui) {
                $("#serie").val(ui.item.value);
                $("#id_factura_venta").val(ui.item.id_factura_venta);
                return false;
                },
                select: function(event, ui) {
                $("#serie").val(ui.item.value);
                $("#id_factura_venta").val(ui.item.id_factura_venta);
                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
        }
    });
    //////////////////////////////////////////////////////

    ///////////////primer buscador productos//////////////////    
    $("#codigo").keyup(function(e) {
        var ids = $("#id_factura_venta").val();
        if (ids === "") {
            $("#serie").focus();
            $("#codigo").val("");
            alertify.alert("Error... Seleccione una factura");
        } else {
            /////buscador productos codigo///// 
            $("#codigo").autocomplete({
                source: "../procesos/buscar_productonotas.php?ids=" + ids,
                minLength: 1,
                focus: function(event, ui) {
                $("#codigo").val(ui.item.value);
                $("#producto").val(ui.item.producto);
                $("#precio").val(ui.item.precio);
                $("#canti").val(ui.item.canti);
                $("#descuento").val(ui.item.descuento);
                $("#iva_producto").val(ui.item.iva_producto);
                $("#carga_series").val(ui.item.carga_series);
                $("#estado").val(ui.item.estado);
                $("#cod_producto").val(ui.item.cod_producto);
                return false;
                },
                select: function(event, ui) {
                $("#codigo").val(ui.item.value);
                $("#producto").val(ui.item.producto);
                $("#precio").val(ui.item.precio);
                $("#canti").val(ui.item.canti);
                $("#descuento").val(ui.item.descuento);
                $("#iva_producto").val(ui.item.iva_producto);
                $("#carga_series").val(ui.item.carga_series);
                $("#estado").val(ui.item.estado);
                $("#cod_producto").val(ui.item.cod_producto);
                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
        //////////////////////////////
        }
    });
    ////////////////////////////////////////////////////////////////////

    ////////////////////segundo buscador productos/////////////////////
    $("#producto").keyup(function(e) {
        var ids = $("#id_factura_venta").val();
        if (ids === "") {
            alert("Error... Seleccione una factura");
            $("#serie").focus();
            $("#producto").val("");
        } else {
            /////buscador productos codigo///// 
            $("#producto").autocomplete({
                source: "../procesos/buscar_productonotas2.php?ids=" + ids,
                minLength: 1,
                focus: function(event, ui) {
                $("#producto").val(ui.item.value);
                $("#codigo").val(ui.item.codigo);
                $("#precio").val(ui.item.precio);
                $("#canti").val(ui.item.canti);
                $("#descuento").val(ui.item.descuento);
                $("#iva_producto").val(ui.item.iva_producto);
                $("#carga_series").val(ui.item.carga_series);
                $("#estado").val(ui.item.estado);
                $("#cod_producto").val(ui.item.cod_producto);
                return false;
                },
                select: function(event, ui) {
                $("#producto").val(ui.item.value);
                $("#codigo").val(ui.item.codigo);
                $("#precio").val(ui.item.precio);
                $("#canti").val(ui.item.canti);
                $("#descuento").val(ui.item.descuento);
                $("#iva_producto").val(ui.item.iva_producto);
                $("#carga_series").val(ui.item.carga_series);
                $("#estado").val(ui.item.estado);
                $("#cod_producto").val(ui.item.cod_producto);
                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
        }
    });
    //////////////////////////////////////////////////

    ///////////calendarios/////
    $('#fecha_actual').datepicker({
        dateFormat: 'yy-mm-dd'
    });
////////////////////////

//////////////////////tabla notas credito/////////////////////////
    jQuery("#list").jqGrid({
        datatype: "local",
        colNames: ['', 'ID', 'Código', 'Detalle', 'Cantidad', 'Precio. U', 'Descuento', 'Total', 'Iva'],
        colModel: [
            {name: 'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
                formatoptions: {keys: false, delbutton: true, editbutton: false}
            },
            {name: 'cod_producto', index: 'cod_producto', editable: false, search: false, hidden: true, editrules: {edithidden: false}, align: 'center', frozen: true, width: 50},
            {name: 'codigo', index: 'codigo', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 100},
            {name: 'detalle', index: 'detalle', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 290},
            {name: 'cantidad', index: 'cantidad', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 70},
            {name: 'precio_u', index: 'precio_u', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'descuento', index: 'descuento', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 70},
            {name: 'precio_t', index: 'precio_t', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'iva', index: 'iva', align: 'center', width: 100, hidden: true}
        ],
        rowNum: 30,
        width: 780,
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
                var totalrifa12 = 0;
                var tarifa0 = 0;
                var iva = 0;
                var total_iva = 0;
                var mul = 0;
                var des = 0;
                var total_des = 0;
                var total = 0;
                var total_to = 0;
                var total_to2 = 0;

                if (su === true) {
                    if (ret.iva === "Si") {
                        iva = $("#iva").val();
                        total_iva = parseFloat(ret.precio_t * 0.12).toFixed(2);
                        iva = ($("#iva").val() - total_iva).toFixed(2);
                        totalrifa12 = (ret.precio_t - total_iva).toFixed(2);
                        tarifa12 = (parseFloat($("#total_p2").val()) - totalrifa12).toFixed(2);
                        mul = (ret.cantidad * ret.precio_u).toFixed(2);
                        des = ((mul * ret.descuento)/100).toFixed(2);
                        total_des = (parseFloat($("#desc").val()) - des).toFixed(2);
                        total = (parseFloat(totalrifa12) + parseFloat(total_iva)).toFixed(2);
                        total_to = (parseFloat($("#tot").val()) - total).toFixed(2);
                        $("#total_p2").val(tarifa12);
                        $("#iva").val(iva);
                        $("#desc").val(total_des);
                        $("#tot").val(total_to);
                     } else {
                        if (ret.iva === "No") {
                            tarifa0 = ($("#total_p").val() - ret.precio_t).toFixed(2);
                            mul = (ret.cantidad * ret.precio_u).toFixed(2);
                            des = ((mul * ret.descuento)/100).toFixed(2);
                            total_des = (parseFloat($("#desc").val()) - des).toFixed(2);
                            total_to2 = ($("#tot").val() - ret.precio_t).toFixed(2);
                            $("#total_p").val(tarifa0);
                            $("#desc").val(total_des);
                            $("#tot").val(total_to2);
                        }
                    }
                }
                $(".ui-icon-closethick").trigger('click');
                //$("#delmodlist").hide();
                return true;
            },
            processing: true
        }
    });
            
////////////////////buscador notas crédito/////////////////////////
        jQuery("#list2").jqGrid({
        url: '../xml/xmlBuscarNotasCredito.php',
        datatype: 'xml',
        colNames: ['ID','IDENTIFICACIÓN','CLIENTE', 'FACTURA NRO.','MONTO TOTAL','FECHA'],
        colModel: [
            {name: 'id_devolucion_venta', index: 'id_factura_venta', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 50},
            {name: 'identificacion', index: 'identificacion', editable: false, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 150},
            {name: 'nombres_cli', index: 'nombres_cli', editable: true, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 200},
            {name: 'num_serie', index: 'num_serie', editable: true, search: true, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 200},
            {name: 'total_venta', index: 'total_venta', editable: true, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 100},
            {name: 'fecha_nota', index: 'fecha_nota', editable: true, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 100},
        ],
        rowNum: 30,
        width: 750,
        height:220,
        sortable: true,
        rowList: [10, 20, 30],
        pager: jQuery('#pager2'),
        sortname: 'id_devolucion_venta',
        sortorder: 'asc',
        viewrecords: true,              
        ondblClickRow: function(){
        var id = jQuery("#list2").jqGrid('getGridParam', 'selrow');
        jQuery('#list2').jqGrid('restoreRow', id);
        
        if (id) {
           var ret = jQuery("#list2").jqGrid('getRowData', id);
           var valor = ret.id_devolucion_venta;
           /////////////agregregar notas credito////////
           $("#comprobante").val(valor);
           $("#btnGuardar").attr("disabled", true);
            $("#btnModificar").attr("disabled", true);

            $("#num_factura").attr("disabled", "disabled");
            $("#ruc_ci").attr("disabled", "disabled");
            $("#nombre_cliente").attr("disabled", "disabled");
            $("#codigo").attr("disabled", "disabled");
            $("#producto").attr("disabled", "disabled");
            $("#cantidad").attr("disabled", "disabled");
            $("#precio").attr("disabled", "disabled");
            $("#observaciones").attr("disabled", "disabled");

            $("#list").jqGrid("clearGridData", true);
            $("#total_p").val("0.00");
            $("#total_p2").val("0.00");
            $("#iva").val("0.00");
            $("#tot").val("0.00");
        
            $.getJSON('../procesos/retornar_notas.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 18)
                {
                    $("#fecha_actual").val(data[i]);
                    $("#hora_actual").val(data[i + 1 ]);
                    $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                    $("#id_cliente").val(data[i + 4]);
                    $("#tipo_docu").val(data[i + 5]);
                    $("#ruc_ci").val(data[i + 6]);
                    $("#nombre_cli").val(data[i + 7]);
                    $("#telefono_cli").val(data[i + 8]);
                    $("#direccion_cli").val(data[i + 9]);
                    $("#tipo_comprobante").val(data[i + 10]);
                    $("#serie").val(data[i + 11]);
                    $("#observaciones").val(data[i + 12]);
                    $("#total_p").val(data[i + 13]);
                    $("#total_p2").val(data[i + 14]);
                    $("#iva").val(data[i + 15]);
                    $("#desc").val(data[i + 16]);
                    $("#tot").val(data[i + 17]);
                }
            }
        });
        ///////////////////////////////////////////////////   
    
        ////////////////////llamar notas segunda parte/////
        $.getJSON('../procesos/retornar_notas2.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 8)
                {
                    var datarow = {
                        cod_producto: data[i], 
                        codigo: data[i + 1], 
                        detalle: data[i + 2], 
                        cantidad: data[i + 3], 
                        precio_u: data[i + 4], 
                        descuento: data[i + 5], 
                        precio_t: data[i + 6], 
                        iva: data[i + 7]
                    };
                    var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                }
            }
        });
           
        $("#buscar_notas_credito").dialog("close");
        } else {
          alertify.alert("Seleccione una Factura");
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
            var valor = ret.id_devolucion_venta;
           /////////////agregregar notas credito////////
            $("#comprobante").val(ret.id_devolucion_venta);
            $("#btnGuardar").attr("disabled", true);
            $("#btnModificar").attr("disabled", true);

            $("#num_factura").attr("disabled", "disabled");
            $("#ruc_ci").attr("disabled", "disabled");
            $("#nombre_cliente").attr("disabled", "disabled");
            $("#codigo").attr("disabled", "disabled");
            $("#producto").attr("disabled", "disabled");
            $("#cantidad").attr("disabled", "disabled");
            $("#precio").attr("disabled", "disabled");
            $("#observaciones").attr("disabled", "disabled");

            $("#list").jqGrid("clearGridData", true);
            $("#total_p").val("0.00");
            $("#total_p2").val("0.00");
            $("#iva").val("0.00");
            $("#tot").val("0.00");
        
            $.getJSON('../procesos/retornar_notas.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
                for (var i = 0; i < tama; i = i + 18)
                {
                    $("#fecha_actual").val(data[i]);
                    $("#hora_actual").val(data[i + 1 ]);
                    $("#digitador").val(data[i + 2 ] + " " + data[i + 3 ] );
                    $("#id_cliente").val(data[i + 4]);
                    $("#tipo_docu").val(data[i + 5]);
                    $("#ruc_ci").val(data[i + 6]);
                    $("#nombre_cli").val(data[i + 7]);
                    $("#telefono_cli").val(data[i + 8]);
                    $("#direccion_cli").val(data[i + 9]);
                    $("#tipo_comprobante").val(data[i + 10]);
                    $("#serie").val(data[i + 11]);
                    $("#observaciones").val(data[i + 12]);
                    $("#total_p").val(data[i + 13]);
                    $("#total_p2").val(data[i + 14]);
                    $("#iva").val(data[i + 15]);
                    $("#desc").val(data[i + 16]);
                    $("#tot").val(data[i + 17]);
                }
            }
        });
        ///////////////////////////////////////////////////   
    
        ////////////////////llamar notas segunda parte/////
        $.getJSON('../procesos/retornar_notas2.php?com=' + valor, function(data) {
            var tama = data.length;
            if (tama !== 0) {
              for (var i = 0; i < tama; i = i + 8) {
                    var datarow = {
                        cod_producto: data[i], 
                        codigo: data[i + 1], 
                        detalle: data[i + 2], 
                        cantidad: data[i + 3], 
                        precio_u: data[i + 4], 
                        descuento: data[i + 5], 
                        precio_t: data[i + 6], 
                        iva: data[i + 7]
                    };
                    var su = jQuery("#list").jqGrid('addRowData', data[i], datarow);
                }
            }
        });
            
        $("#buscar_notas_credito").dialog("close");
        } else {
          alertify.alert("Seleccione una Factura");
        }
    }
});
/////////////////////////////////////////////////////////////
}




