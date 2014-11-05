$(document).on("ready", inicio);
function evento(e) {
    e.preventDefault();
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

$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

var dialogo =
{
    autoOpen: false,
    resizable: false,
    width: 860,
    height: 350,
    modal: true
};

function abrirDialogo(e)
{
    $("#empresas").dialog("open");
}

function nueva_empresa(e) {
    location.reload();
}

function ValidNum() {
    if (event.keyCode < 48 || event.keyCode > 57) {
        event.returnValue = false;
    }
    return true;
}

function Num_Let() {
    if ((event.keyCode !== 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122)) {
        event.returnValue = false;
    }
    return true;
}

$(function() {
    guidely.init({
        startTrigger: false
    });
});


$(function(){
    Test = {
        UpdatePreview: function(obj){
            // if IE < 10 doesn't support FileReader
            if(!window.FileReader){
            // don't know how to proceed to assign src to image tag
            } else {
                var reader = new FileReader();
                var target = null;
             
                reader.onload = function(e) {
                    target =  e.target || e.srcElement;
                    $("#foto").prop("src", target.result);
                };
                reader.readAsDataURL(obj.files[0]);
            }
        }
    };
});


function inicio() {
    
    //////////////////para cargar mpresa/////////////
    function getDoc(frame) {
        var doc = null;     
     	
        try {
            if (frame.contentWindow) {
                doc = frame.contentWindow.document;
            }
        } catch(err) {
        }
        if (doc) { 
            return doc;
        }
        try { 
            doc = frame.contentDocument ? frame.contentDocument : frame.document;
        } catch(err) {
       
            doc = frame.document;
        }
        return doc;
    }
    //////////////////////////
    
    ///////////////enviar datos////////////////
    $("#btnGuardar").click(function (){
        var iden = $("#ruc_empresa").val();
        if ($("#nombre_empresa").val() === "") {
            $("#nombre_empresa").focus();
            alert("Ingrese nombre de la empresa");
        } else {
            if ($("#ruc_empresa").val() === "") {
                $("#ruc_empresa").focus();
                alert("Ingrese ruc de la empresa");
            }else{
                if ( iden.length < 13) {
                    $("#ruc_ci").focus();
                    alert("Error.. Minimo 13 digitos ");
                } else {
                    if ($("#descripcion_empresa").val() === "") {
                        $("#descripcion_empresa").focus();
                        alert("Ingrese una descripción");
                    }else{
                        if ($("#propietario_empresa").val() === "") {
                            $("#propietario_empresa").focus();
                            alert("Ingrese el propietario");
                        }else{
                            if ($("#direccion_empresa").val() === "") {
                                $("#direccion_empresa").focus();
                                alert("Ingrese dirección de la empresa");
                            }else{
                                if ($("#telefono_empresa").val() === "") {
                                    $("#telefono_empresa").focus();
                                    alert("Ingrese telefóno de la empresa");
                                }else{ 
                                    $("#empresa_form").submit(function(e)
                                    {
                                        var formObj = $(this);
                                        var formURL = formObj.attr("action");
                                        if(window.FormData !== undefined)  
                                        {	
                                            var formData = new FormData(this);   
                                            formURL=formURL;        	
                                            $.ajax({
                                                url: formURL,
                                                type: "POST",
                                                data:  formData,
                                                mimeType:"multipart/form-data",
                                                contentType: false,
                                                cache: false,
                                                processData:false,
                                                success: function(data, textStatus, jqXHR)
                                                {
                                                    var res=data;
                                                    if(res == 1){
                                                        alert("Empresa guardada correctamente");
                                                        location.reload();
                                                    }
                                                    else{
                                                        alert("Error..... registro no guardado");
                                                    }
                                                },
                                                error: function(jqXHR, textStatus, errorThrown) 
                                                {
                                                } 	        
                                            });
                                            e.preventDefault();
                                        }
                                        else  //for olden browsers
                                        {
                                            //generate a random id
                                            var  iframeId = "unique" + (new Date().getTime());
                                            //create an empty iframe
                                            var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
                                            //hide it
                                            iframe.hide();
                                            //set form target to iframe
                                            formObj.attr("target",iframeId);
                                            //Add iframe to body
                                            iframe.appendTo("body");
                                            iframe.load(function(e)
                                            {
                                                var doc = getDoc(iframe[0]);
                                                var docRoot = doc.body ? doc.body : doc.documentElement;
                                                var data = docRoot.innerHTML;
                                            //data return from server.			
                                            });
                                        }
                                    });
                                    $("#empresa_form").submit();
                                }
                            }
                        }
                    }
                } 
            }
        }
    });
    /////////////////////////////////////////
    
    
    ///////////////modificar empresa//////////////////////////
     $("#btnModificar").click(function (){
        var iden = $("#ruc_empresa").val();
        if ($("#nombre_empresa").val() === "") {
            $("#nombre_empresa").focus();
            alert("Ingrese nombre de la empresa");
        } else {
            if ($("#ruc_empresa").val() === "") {
                $("#ruc_empresa").focus();
                alert("Ingrese ruc de la empresa");
            }else{
                if ( iden.length < 13) {
                    $("#ruc_ci").focus();
                    alert("Error.. Minimo 13 digitos ");
                } else {
                    if ($("#descripcion_empresa").val() === "") {
                        $("#descripcion_empresa").focus();
                        alert("Ingrese una descripción");
                    }else{
                        if ($("#propietario_empresa").val() === "") {
                            $("#propietario_empresa").focus();
                            alert("Ingrese el propietario");
                        }else{
                            if ($("#direccion_empresa").val() === "") {
                                $("#direccion_empresa").focus();
                                alert("Ingrese dirección de la empresa");
                            }else{
                                if ($("#telefono_empresa").val() === "") {
                                    $("#telefono_empresa").focus();
                                    alert("Ingrese telefóno de la empresa");
                                }else{ 
                                    $("#empresa_form").submit(function(e)
                                    {
                                        var formObj = $(this);
                                        var formURL = formObj.attr("action");
                                        if(window.FormData !== undefined)  
                                        {	
                                            var formData = new FormData(this);   
                                            formURL=formURL; 
                                            
                                            $.ajax({
                                                url: "../procesos/modificar_empresa.php",
                                                type: "POST",
                                                data:  formData,
                                                mimeType:"multipart/form-data",
                                                contentType: false,
                                                cache: false,
                                                processData:false,
                                                success: function(data, textStatus, jqXHR)
                                                {
                                                    var res=data;
                                                    if(res == 1){
                                                        alert("Empresa modificada correctamente");
                                                        location.reload();
                                                    }
                                                    else{
                                                        alert("Error..... registro no modificado");
                                                    }
                                                },
                                                error: function(jqXHR, textStatus, errorThrown) 
                                                {
                                                } 	        
                                            });
                                            e.preventDefault();
                                        }
                                        else  //for olden browsers
                                        {
                                            //generate a random id
                                            var  iframeId = "unique" + (new Date().getTime());
                                            //create an empty iframe
                                            var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
                                            //hide it
                                            iframe.hide();
                                            //set form target to iframe
                                            formObj.attr("target",iframeId);
                                            //Add iframe to body
                                            iframe.appendTo("body");
                                            iframe.load(function(e)
                                            {
                                                var doc = getDoc(iframe[0]);
                                                var docRoot = doc.body ? doc.body : doc.documentElement;
                                                var data = docRoot.innerHTML;
                                            //data return from server.			
                                            });
                                        }
                                    });
                                    $("#empresa_form").submit();
                                }
                            }
                        }
                    }
                } 
            }
        }
    });
    

    $("#ruc_empresa").validCampoFranz("0123456789");
    $("#telefono_empresa").validCampoFranz("0123456789");
    $("#celular_empresa").validCampoFranz("0123456789");
    $("#ruc_empresa").attr("maxlength", "13");
    
    
    $("#ruc_empresa").keyup(function() {
        var ci = $("#ruc_empresa").val();
        var pares = 0;
        var impares = 0;
        var cont = 0;
        var total = 0;
        var residuo = 0;
       
        var ruc = ci.substr(10,13);
                
        if(ruc == "001" ){
            var ce = ci.substr(0,10);
            for (var i = 0; i < 9; i++) {
                if (i % 2 === 0) {
                    if (parseInt(ce.charAt(i)) * 2 > 9) {
                        cont = (parseInt(ce.charAt(i)) * 2) - 9;
                    }
                    else {
                        cont = (parseInt(ce.charAt(i)) * 2);
                    }
                    impares = impares + cont;
                }
                else {
                    pares = pares + parseInt(ce.charAt(i));
                }
            }
            total = pares + impares;
            if (total % 10 === 0) {
            }
            else {
                residuo = total % 10;
                residuo = 10 - residuo;
                if (parseInt(ce.charAt(9)) === residuo) {
                }
                else {
                    alert("Error.... Ruc Incorrecto");
                    $("#ruc_empresa").val("");
                }
            }
        }else{
            if($("#ruc_empresa").val().length === 13){
                alert("Error.... Ruc Incorrecto");   
                $("#ruc_empresa").val("");
            }
        }
    });

    //////////////////////
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    $("#btnModificar").click(function(e) {
        e.preventDefault();
    });
    $("#btnBuscar").click(function(e) {
        e.preventDefault();
    });
    $("#btnNuevo").click(function(e) {
        e.preventDefault();
    });
    //////////////////////////

    ///////////////////////////
    //$("#btnGuardar").on("click", guardar_empresa);
//    $("#btnModificar").on("click", modificar_empresa);
    $("#btnBuscar").on("click", abrirDialogo);
    $("#btnNuevo").on("click", nueva_empresa);
    //////////////////////////

    /////////////////////////// 
    $("#empresas").dialog(dialogo);
/////////////////////////// 

/////////////tabla clientes/////////
 jQuery("#list").jqGrid({
        url: '../xml/datos_empresa.php',
        datatype: 'xml',
        colNames: ['Codigo', 'Empresa', 'RUC', 'Descripción', 'Propietario', 'Dirección', 'Telefóno', 'Celular', 'Fax', 'Correo', 'Página Web', 'Imagen'],
        colModel: [
            {name: 'id_empresa', index: 'id_empresa', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'nombre_empresa', index: 'nombre_empresa', editable: true, align: 'center', width: '120', search: false, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'ruc_empresa', index: 'ruc_empresa', editable: true, align: 'center', width: '120', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'descripcion_empresa', index: 'descripcion_empresa', editable: true, align: 'center', width: '120', search: true, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'propietario_empresa', index: 'propietario_empresa', editable: true, align: 'center', width: '120', search: true, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'direccion_empresa', index: 'direccion_empresa', editable: true, align: 'center', width: '120', search: true, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'telefono_empresa', index: 'telefono_empresa', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'celular_empresa', index: 'celular_empresa', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'fax_empresa', index: 'fax_empresa', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'correo_empresa', index: 'correo_empresa', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'pagina_empresa', index: 'pagina_empresa', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'imagen', index: 'imagen', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}}
        ],
        rowNum: 10,
        width: 830,
        rowList: [10, 20, 30],
        pager: jQuery('#pager'),
        sortname: 'id_empresa',
        shrinkToFit: false,
        sortorder: 'asc',
        caption: 'Lista de Clientes',
        editurl: 'procesos/estadio_del.php',
        viewrecords: true,
        ondblClickRow: function(){
         var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
         jQuery('#list').jqGrid('restoreRow', id);   
         var ret = jQuery("#list").jqGrid('getRowData', id);
         $("#foto").attr("src", "../fotos_empresa/"+ ret.imagen);
         jQuery("#list").jqGrid('GridToForm', id, "#empresa_form");
         $("#btnGuardar").attr("disabled", true);
         $("#empresas").dialog("close");    
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
        closeOnEscape: true,        
        multipleSearch: false, overlay: false

    },
    {
    },
            {
                closeOnEscape: true
            }
    );
    /////////////////		
    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "Añadir",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            jQuery('#list').jqGrid('restoreRow', id);
            var ret = jQuery("#list").jqGrid('getRowData', id);
            if (id) {
                jQuery("#list").jqGrid('GridToForm', id, "#empresa_form");
                $("#foto").attr("src", "../fotos_empresa/"+ ret.imagen);
                $("#btnGuardar").attr("disabled", true);
                $("#empresas").dialog("close");
            } else {
                alert("Seleccione un fila");
            }
        }
    });   
}

