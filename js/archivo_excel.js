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

function inicio(){
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
    $("#btnGuardarCargar").on("click",guardarCargar);
}
function cargar(){

}
function guardarCargar(){
     $("#tabla_excel tbody").empty(); 
	$("#formulario_excel").submit(function(e)
	{
	    var formObj = $(this);
	    var formURL = formObj.attr("action");
	    if(window.FormData !== undefined)  
	    {	
	        var formData = new FormData(this);   
	        formURL=formURL;        	
	        $.ajax({
	            url: "../procesos/guardarExcel.php",
	            type: "POST",
	            data:  formData,
	            mimeType:"multipart/form-data",
	            dataType: 'json',
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(data, textStatus, jqXHR)
	            {
	                var res=data;
	                if(res != ""){
	                    alert("Datos cargados");
	                    cargarTabla(data);
	                }
	                else{
	                    alert("Error..... Al cargar los registros");
	                    cargarTabla(data);
	                }
	            },
	            error: function(jqXHR, textStatus, errorThrown) 
	            {
	            } 	        
	        });
	        e.preventDefault();
                $(this).unbind("submit");
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
	
}

function cargarTabla(data){
	for(var i=0;i<data.length;i+=13){
		vector = new Array();
		vector[0]=data[i];
		vector[1]=data[i+1];
		vector[2]=data[i+2];
		vector[3]=data[i+3];
		vector[4]=data[i+4];
		vector[5]=data[i+5];
		vector[6]=data[i+6];
		vector[7]=data[i+7];
		vector[8]=data[i+8];
		vector[9]=data[i+9];
		vector[10]=data[i+10];
		vector[11]=data[i+11];
                vector[12]=data[i+12];
		guardar_datos_excel(vector);
	}
}

function guardar_datos_excel(vector){
	$.ajax({
        type: "POST",
        url: "../procesos/guardar_producto_excel.php",
        data: "var="+vector[0]+"&var1="+vector[1]+"&var2="+vector[2]+"&var3="+vector[3]+"&var4="+vector[4]+"&var5="+vector[5]+"&var6="+vector[6]+"&var7="+vector[7]+"&var8="+vector[8]+"&var9="+vector[9]+"&var10="+vector[10]+"&var11="+vector[11]+"&var12="+vector[12],
        success: function(data) {
            var val = data;
            if (val == 1)
            {
             	$("#tabla_excel tbody").append( "<tr>" +
            	"<td align=center>" + vector[0] + "</td>" +
            	"<td align=center>" + vector[1] + "</td>" +	            
            	"<td align=center>" + 'Guardado Correctamente' + "</td>" +            
            	"<td align=center>" + " <a class='elimina'><img src='../imagenes/valid.png'/>"  + "</td>" + "</tr>" );
            }
            if (val == 2)
            {
             	$("#tabla_excel tbody").append( "<tr>" +
            	"<td align=center>" + vector[0] + "</td>" +
            	"<td align=center>" + vector[1] + "</td>" +	            
            	"<td align=center>" + 'Producto Repetido' + "</td>" +            
            	"<td align=center>" + " <a class='elimina'><img src='../imagenes/invalid.png' />"  + "</td>" + "</tr>" );
            }
            if (val == 3)
            {
             	$("#tabla_excel tbody").append( "<tr>" +
            	"<td align=center>" + vector[0] + "</td>" +
            	"<td align=center>" + vector[1] + "</td>" +	            
            	"<td align=center>" + 'Sintaxis incorrecta' + "</td>" +            
            	"<td align=center>" + " <a class='elimina'><img src='../imagenes/delete.png' />"  + "</td>" + "</tr>" );
            }
        }
    });
}