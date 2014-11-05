$(document).on("ready",inicio);
function lim(){
    $("input").val("");
}

function inicio (){	
    $("#btnLimCliente,#btnLimEquipo,#btnLimCategoria,#btnLimTec,#btnLimMarca,#btnLimFechasI,#btnLimEquiU").on("click",lim)
    $("#btnCliente").button({
        icons: {
            primary: "ui-icon-search"
        }    
    });
    $("#btnLimCliente").button({
        icons: {
            primary: "ui-icon-close"
        }    
    });
    $("#btnEquipo").button({
        icons: {
            primary: "ui-icon-search"
        }    
    });
    $("#btnLimEquipo").button({
        icons: {
            primary: "ui-icon-close"
        }    
    });
    $("#btnCategoria").button({
        icons: {
            primary: "ui-icon-search"
        }    
    });
    $("#btnLimCategoria").button({
        icons: {
            primary: "ui-icon-close"
        }    
    });

    $("#btnTec").button({
        icons: {
            primary: "ui-icon-search"
        }    
    });
    $("#btnLimTec").button({
        icons: {
            primary: "ui-icon-close"
        }    
    });
    $("#btnMarca").button({
        icons: {
            primary: "ui-icon-search"
        }   
    });
    $("#btnLimMarca").button({
        icons: {
            primary: "ui-icon-close"
        }    
    });
    $("#btnFechasI").button({
        icons: {
            primary: "ui-icon-search"
        }    
    });
    $("#btnLimFechasI").button({
        icons: {
            primary: "ui-icon-close"
        }    
    });
    $("#btnEquiU").button({
        icons: {
            primary: "ui-icon-search"
        }   
    });
    $("#btnLimEquiU").button({
        icons: {
            primary: "ui-icon-close"
        }    
    });
    
    $("#txtCliente").autocomplete({
        source: "../procesos/busquedaCliente.php",
        minLength:1,
        focus: function( event, ui ) {
        $( "#txtCliente" ).val( ui.item.value );
        $( "#txtClienteId" ).val( ui.item.label );  
        return false;
        },
        select: function( event, ui ) {
        $( "#txtCliente" ).val( ui.item.value );
        $( "#txtClienteId" ).val( ui.item.label );      
        return false;
        }     
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<a>"+ item.value + "</a>" )
        .appendTo( ul );
    };
    $("#txtCat").autocomplete({
        source: "../procesos/busquedaEquipo.php",
        minLength:1,
        focus: function( event, ui ) {
        $( "#txtCat" ).val( ui.item.value );
        $( "#txtCatId" ).val( ui.item.label );  
        return false;
        },
        select: function( event, ui ) {
        $( "#txtCat" ).val( ui.item.value );
        $( "#txtCatId" ).val( ui.item.label );      
        return false;
        }     
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<a>"+ item.value + "</a>" )
        .appendTo( ul );
    };	
    $("#txtMar").autocomplete({
        source: "../procesos/busquedaMarca.php",
        minLength:1,
        focus: function( event, ui ) {
        $( "#txtMar" ).val( ui.item.value );
        $( "#txtMarId" ).val( ui.item.label );  
        return false;
        },
        select: function( event, ui ) {
        $( "#txtMar" ).val( ui.item.value );
        $( "#txtMarId" ).val( ui.item.label );      
        return false;
        }     
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<a>"+ item.value + "</a>" )
        .appendTo( ul );
    };
    $("#txtTec").autocomplete({
        source: "../procesos/busquedaUsuario.php",
        minLength:1,
        focus: function( event, ui ) {
        $( "#txtTec" ).val( ui.item.value );
        $( "#txtTecId" ).val( ui.item.label );  
        return false;
        },
        select: function( event, ui ) {
        $( "#txtTec" ).val( ui.item.value );
        $( "#txtTecId" ).val( ui.item.label );      
        return false;
        }     
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<a>"+ item.value + "</a>" )
        .appendTo( ul );
    };
    $("#txtU").autocomplete({
        source: "../procesos/busquedaCliente.php",
        minLength:1,
        focus: function( event, ui ) {
        $( "#txtU" ).val( ui.item.value );
        $( "#txtUId" ).val( ui.item.label ); 
        return false;
        },
        select: function( event, ui ) {
        $( "#txtU" ).val( ui.item.value );
        $( "#txtUId" ).val( ui.item.label );                  
        var id = $('#txtUId').val();
        $('#txtE').load('../procesos/cargaEquipos.php?cod=' + id);
            

        return false;
        }     
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<a>"+ item.value + "</a>" )
        .appendTo( ul );
    };
    $( "#txtInicio" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        dateFormat:"yy-mm-dd",    
        showAnim: 'slide',
        onClose: function( selectedDate ) {
            $( "#txtFin" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#txtFin1" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        dateFormat:"yy-mm-dd",    
        showAnim: 'slide',
        onClose: function( selectedDate ) {
            $( "#txtInicio1" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
    $( "#txtInicio1" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        dateFormat:"yy-mm-dd",    
        showAnim: 'slide',
        onClose: function( selectedDate ) {
            $( "#txtFin1" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#txtFin" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        dateFormat:"yy-mm-dd",    
        showAnim: 'slide',
        onClose: function( selectedDate ) {
            $( "#txtInicio" ).datepicker( "option", "maxDate", selectedDate );
        }
    });   
    ///////llamados a los reportes
    $("#btnCliente").click(function (){
        if($("#txtClienteId").val()!="" && $("#txtInicio").val()!="" && $("#txtFin").val()!="" && $("#selectEstado").val()!="")
        {
            window.open("../reportes/reportes/reporteCliente.php?id="+$("#txtClienteId").val()+"&inicio="+$("#txtInicio").val()+"&fin="+$("#txtFin").val()+"&estado="+$("#selectEstado").val());  
        }
        else{
            alert("Error llene todos los campos antes de continuar");
        }  
    })
    $("#btnEquipo").click(function (){
        if($("#txtNro").val()!=""){
            window.open("../reportes/reportes/reporteEquipo.php?id="+$("#txtNro").val());  
        }
        else{
            alert("Error llene todos los campos antes de continuar");
        }
    });
    $("#btnCategoria").click(function (){
        if($("#txtCatId").val()!=""){
            window.open("../reportes/reportes/reporteCategorias.php?id="+$("#txtCatId").val());    
        }
        else{
            alert("Error llene todos los campos antes de continuar");
        } 
    });
    $("#btnMarca").click(function (){
        if($("#txtMarId").val()!="")
        {
            window.open("../reportes/reportes/reporteMarca.php?id="+$("#txtMarId").val());  
        }
        else{
            alert("Error llene todos los campos antes de continuar");
        }
    });
    $("#btnTec").click(function (){
        if($("#txtTecId").val()!=""){
            window.open("../reportes/reportes/reporteTecnico.php?id="+$("#txtTecId").val());  
        }
        else{
            alert("Error llene todos los campos antes de continuar");
        }
    });
    $("#btnFechasI").click(function (){
        if($("#txtInicio1").val()!="" && $("#txtFin1").val()!=""){
            window.open("../reportes/reportes/reporteFechas.php?inicio="+$("#txtInicio1").val()+"&fin="+$("#txtFin1").val());  
        }
        else{
            alert("Error llene todos los campos antes de continuar");
        }
    });
    $("#btnEquiU").click(function (){
        if($("#txtUId").val()!="" && $("#txtE").text()!=""){
            window.open("../reportes/reportes/reporteConsulta.php?id_registro="+$("#txtE").val());        
        }
        else{
            alert("Error llene todos los campos antes de continuar");
        }
      
    });
    $("#centro a").on("click",Defecto);
}
function Defecto(e){
    e.preventDefault();
}
