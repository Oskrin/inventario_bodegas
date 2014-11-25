$(document).on("ready", inicio);

$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

function Defecto(e) {
    e.preventDefault();
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

function limpiar_asignacion(){
    location.reload(); 
}

function a_entero(valor){  
   valor = parseInt(valor);  
    if (isNaN(valor)) {  
          return 0;  
    }else{  
          return valor;  
    }  
}

function guardar_asignacion() {
    var tam = jQuery("#list2").jqGrid("getRowData");
    
    if($("#id_bodega").val() === ""){
        $("#nombres_bodega").focus();
        alertify.error('Seleccione una bodega.');
    }else{
        if (tam.length > 0) {
            var v1 = new Array();
            var v2 = new Array();
            var string_v1 = "";
            var string_v2 = "";
            var fil = jQuery("#list2").jqGrid("getRowData");
            var can = 0;

            for (var i = 0; i < fil.length; i++) {
                var datos = fil[i];
                v1[i] = datos['cod_productos'];
                v2[i] = datos['cantidad'];
                if (v2[i] == "" || isNaN(v2[i])) { 
                    can = 1;
                  $("#list2").trigger("reloadGrid");
                }else{
                $("#list2").trigger("reloadGrid");
                }
            }
            
            if(can == 1){
              alertify.error('Ingrese cantidad de los productos.');  
            }else{
               for (i = 0; i < fil.length; i++) {
                 string_v1 = string_v1 + "|" + v1[i];
                 string_v2 = string_v2 + "|" + v2[i];
                 }
               $.ajax({
                type: "POST",
                url: "../procesos/guardar_asignacion.php",
                data: "campo1=" + string_v1 + "&campo2=" + string_v2 + "&fecha_actual=" + $("#fecha_actual").val()+ "&hora_actual=" + $("#hora_actual").val()+ "&id_bodega=" + $("#id_bodega").val(),
                success: function(data) {
                    var val = data;
                    if (val == 1) {
                        alertify.alert("Asignación guardada correctamente", function(){location.reload();});
                    }
                }
            });
            }
        } else {
            alertify.error('Ingrese productos a las bodegas.');
        }
    }
}

function numeros(e) { 
tecla = (document.all) ? e.keyCode : e.which;
if (tecla==8) return true;
patron = /\d/;
te = String.fromCharCode(tecla);
return patron.test(te);
}

function inicio() {
    
    jQuery().UItoTop({ easingType: 'easeOutQuart' });
    //////////////para hora///////////
    show();
    ///////////////////
    
    
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    $("#btnNuevo").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnGuardar").on("click", guardar_asignacion);
    $("#btnNuevo").on("click", limpiar_asignacion);
     
     
    /////buscador clientes nombres///// 
    $("#nombres_bodega").autocomplete({
        source: "../procesos/buscar_bodegas.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#nombres_bodega").val(ui.item.value);
        $("#id_bodega").val(ui.item.id_bodega);
        return false;
        },
        select: function(event, ui) {
        $("#nombres_bodega").val(ui.item.value);
        $("#id_bodega").val(ui.item.id_bodega);
        return false;
        }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
    ////////////////////////////// 
     
    $("#search_codigo").keyup(function() {
      $("#list").jqGrid('setGridParam', {url: '../xml/search.php?valor=' + $("#search_codigo").val() + '&categoria=' + $("#categoria").val(), datatype: 'xml'}).trigger('reloadGrid');
    });
    
     $("#search_producto").keyup(function() {
      $("#list").jqGrid('setGridParam', {url: '../xml/search2.php?valor=' + $("#search_producto").val() + '&categoria=' + $("#categoria").val(), datatype: 'xml'}).trigger('reloadGrid');
    });
    
    //////////cambio categorias//////////////
    
    $("#categoria").change(function(){
       $("#list").jqGrid('setGridParam', {url: '../xml/datos_productos3.php?categoria=' + $("#categoria").val(), datatype: 'xml'}).trigger('reloadGrid');
    });
    
    ////////////////////////////////////////
     
      $(window).bind('resize', function() {
    jQuery("#list").setGridWidth($('#centro').width() - 10);
    }).trigger('resize');
    
    jQuery("#list").jqGrid({
        url: '../xml/datos_productos2.php',
        datatype: 'xml',
        colNames: ['ID', 'CÓDIGO', 'ARTICULO', 'PRECIO COSTO', 'STOCK'],
        colModel: [
            {name: 'cod_productos', index: 'cod_productos', editable: true, align: 'center', width: '100', search: false, frozen: true, editoptions: {readonly: 'readonly'}},
            {name: 'codigo', index: 'codigo', editable: true, align: 'center', width: '150', size: '10', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'articulo', index: 'articulo', editable: true, align: 'center', width: '300', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'precio_compra', index: 'precio_compra', editable: true, hidden: true, align: 'center', width: '140', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'stock', index: 'stock', editable: true, align: 'center', width: '140', search: false},
        ],
        rowNum: 300,
        rowList: [300, 600, 900],
        height: 230,
        pager: jQuery('#pager'),
        editurl: "../procesos/procesosUsuarios.php",
        sortname: 'cod_productos',
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista Productos',
        viewrecords: true,
        onSelectRow: function(rowid) {
        var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
        jQuery('#list').jqGrid('restoreRow', id);
        var ret = jQuery("#list").jqGrid('getRowData', id);
        
        if(ret.stock <= 0){
           alertify.alert("Error... Fuera de stock");  
        }else{
        var filas = jQuery("#list2").jqGrid("getRowData");
        if (filas.length === 0) {
          jQuery("#list2").jqGrid('addRowData',rowid,{cod_productos: ret.cod_productos, codigo2: ret.codigo, articulo2: ret.articulo, disponibles: ret.stock});  
        }else{
            var repe = 0;
            for (var i = 0; i < filas.length; i++) {
                var cod = filas[i];
                if (cod['cod_productos'] === ret.cod_productos) {
                    repe = 1;
                }
            }
            if (repe === 1) {
                alertify.alert("Error... Producto cargado a bodega");
            }else{
              jQuery("#list2").jqGrid('addRowData',rowid,{cod_productos: ret.cod_productos, codigo2: ret.codigo, articulo2: ret.articulo, disponibles: ret.stock});    
            }
          }
       }
      }
    }).jqGrid('navGrid', '#pager',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: false,
                view: true,
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
    jQuery("#list").setGridWidth($('#centro').width() - 10);


      $(window).bind('resize', function() {
    jQuery("#list2").setGridWidth($('#centro2').width() - 10);
    }).trigger('resize');
    
    jQuery("#list2").jqGrid({
	datatype: "local",
   	colNames:['','Cod','Codigo','Productos', 'Cantidad','Disponibles'],
   	colModel:[
                {name: 'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
                formatoptions: {keys: false, delbutton: true, editbutton: false}},
                {name:'cod_productos',index:'cod_productos', width:50, hidden: true},
                {name:'codigo2',index:'codigo2', width:250},
   		{name:'articulo2',index:'articulo2', width:300},
   		{name:'cantidad',index:'cantidad', width:100, resizable:true,sortable:true,editable:true, align: 'center', editoptions:{ size:15,dataInit: function(elem){$(elem).bind("keypress", function(e) {return numeros(e)})}}}, 
                {name:'disponibles', index: 'disponibles', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',frozen: true, width: 100},
   	],
   	rowNum:500,
   	rowList:[500,100,150],
   	pager: '#pager2',
        height: 300,
   	sortname: 'cod_productos',
        viewrecords: true,
        sortorder: "asc",
        cellEdit: true,
        cellsubmit: 'clientArray',
        shrinkToFit: true,
	caption:"Productos Asignados",
        reloadAfterEdit: true,
        delOptions: {
            modal: true,
            jqModal: true,
            onclickSubmit: function(rp_ge, rowid) {
            rp_ge.processing = true;
            var su = jQuery("#list2").jqGrid('delRowData', rowid);
            if (su === true) {
             $(".ui-icon-closethick").trigger('click');
            }
            return true;   
            },
            processing: true
        },
        afterSaveCell : function(rowid,name,val,iRow,iCol) {
            if(name == 'cantidad') {
                var dispo = jQuery("#list2").jqGrid('getCell',rowid,iCol+1);
                if(parseInt(val)>parseInt(dispo)){
                  alertify.alert("Error... Fuera de stock", function(){
                   jQuery("#list2").jqGrid('setRowData',rowid,{cantidad: "" });    
                  });
                }else{
                    $("#list2").trigger("reloadGrid");
                }
            }
        }
}).navGrid('#pager2',{
    add:false,
    edit:false,
    del:false,
    refresh: true,
    view: true,
    viewtext: "Consultar",
    searchtext: "Buscar"
});   
    jQuery("#list2").setGridWidth($('#centro').width() - 10);
}



