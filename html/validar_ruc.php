<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Validacion ruc Ecuador</title>
        <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
    </head>
    <body>
        <p>Numero Ruc</p>
        <input type="text" id="ruc_ci" maxlength="13" />
        <input type="submit" value="consultar" onclick="validacion()" >

    </body>
    <script type="text/javascript">
        function validacion () {
            var digito3;
            var i;
            var ruc;
            var cadenar;
            var digito;
            var suma;
            var d;
            var c;
            var ver;
            ruc = $("#ruc_ci").val();
            digito3 = ruc.substring(2,3);
            if(digito3 < 6){
                for(i = 1; i<10; i++){
                    if(i%2 == 0){
                        cadenar = ruc.substring(i-1, i);
                        suma+=parseInt(cadenar);
                    }else{
                        cadenar = ruc.substring(i-1,1);
                        cadenar = parseInt(cadenar)*2;
                        if (cadenar > 9) {
                            cadenar-=9;
                            suma+=parseInt(cadenar);
                        }else{
                            suma+=parseInt(cadenar);
                        }
                    }
                }
                c= suma.toString();
                d=c.substring(0,1);
                d=d+0;
                c=parseInt(d);
                d=c+10;
                digito = d-parseInt(suma);
                ver = ruc.substring(9,10);
                if(digito != ver){
                    alert("Ruc incorrecto 1");
                    $("#ruc_ci").val("");
                }else{
                    alert("Ruc pertenece a persona natural");
                }
            }else{
                if(digito3 == 6){
                    var psuma = 0;
                    var pcadena = 0;
                    var p;
                    var presiduo;
                    var pveri;
                    for(p=1 ; p<9 ; p++){
                        if(p==1){
                            pcadena = ruc.substring(p-1,p);
                            pcadena = parseInt(pcadena)*3;
                            psuma+=parseInt(pcadena);
                        }else{
                            if(p==2){
                                pcadena = ruc.substring(p-1,p);
                                pcadena = parseInt(pcadena)*2;
                                psuma+= parseInt(pcadena);
                            }else{
                                if(p==3){
                                    pcadena = ruc.substring(p-1,p);
                                    pcadena = parseInt(pcadena)*7;
                                    psuma+= parseInt(pcadena);	
                                }else{
                                    if (p==4){
                                        pcadena = ruc.substring(p-1,p);
                                        pcadena = parseInt(pcadena)*6;
                                        psuma+= parseInt(pcadena);
                                    }else{
                                        if (p==5){
                                            pcadena = ruc.substring(p-1,p);
                                            pcadena = parseInt(pcadena)*5;
                                            psuma+= parseInt(pcadena);
                                        }else{
                                            if (p==6){
                                                pcadena = ruc.substring(p-1,p);
                                                pcadena = parseInt(pcadena)*4;
                                                psuma+= parseInt(pcadena);
                                            }else{
                                                if (p==7){
                                                    pcadena = ruc.substring(p-1,p);
                                                    pcadena = parseInt(pcadena)*3;
                                                    psuma+= parseInt(pcadena);
                                                }else{
                                                    if (p==8){
                                                        pcadena = ruc.substring(p-1,p);
                                                        pcadena = parseInt(pcadena)*2;
                                                        psuma+= parseInt(pcadena);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    presiduo = (psuma%11);
                    presiduo = 11-presiduo;
                    pveri = ruc.substring(8,9);
                    if(presiduo != pveri){
                        alert("Ruc incorrecto 2");
                        $("#ruc_ci").val("");
                    }else{
                        alert("Ruc pertenece a personas publicas");
                    }
                }else{
                    if(digito3 == 9){
                        var jsuma = 0;
                        var jcadena= 0;
                        var jresiduo;
                        var jveri;
                        for(var j = 1 ; j<10; j++){
                            if(j==1){
                                jcadena = ruc.substring(j-1,j);
                                jcadena  =parseInt(jcadena)*4;
                                jsuma+=parseInt(jcadena);
                            }else{
                                if(j==2){
                                    jcadena = ruc.substring(j-1,j);
                                    jcadena  = parseInt(jcadena)*3;
                                    jsuma+=parseInt(jcadena);
                                }else{
                                    if(j==3){
                                        jcadena = ruc.substring(j-1,j);
                                        jcadena  = parseInt(jcadena)*2;
                                        jsuma+=parseInt(jcadena);
                                    }else{
                                        if(j==4){
                                            jcadena = ruc.substring(j-1,j);
                                            jcadena  = parseInt(jcadena)*7;
                                            jsuma+=parseInt(jcadena);
                                        }else{
                                            if(j==5){
                                                jcadena = ruc.substring(j-1,j);
                                                jcadena  = parseInt(jcadena)*6;
                                                jsuma+=parseInt(jcadena);
                                            }else{
                                                if(j==6){
                                                    jcadena = ruc.substring(j-1,j);
                                                    jcadena  = parseInt(jcadena)*5;
                                                    jsuma+=parseInt(jcadena);
                                                }else{
                                                    if(j==7){
                                                        jcadena = ruc.substring(j-1,j);
                                                        jcadena  =parseInt(jcadena)*4;
                                                        jsuma+=parseInt(jcadena);
                                                    }else{
                                                        if(j==8){
                                                            jcadena = ruc.substring(j-1,j);
                                                            jcadena  =parseInt(jcadena)*3;
                                                            jsuma+=parseInt(jcadena);
                                                        }else{
                                                            if(j==9){
                                                                jcadena = ruc.substring(j-1,j);
                                                                jcadena  =parseInt(jcadena)*2;
                                                                jsuma+=parseInt(jcadena);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } 
                        }
                        jresiduo = (jsuma % 11);
                        jresiduo = 11-jresiduo;
                        jveri = ruc.substring(9,10);
                        if(jresiduo!=jveri){
                            alert("Ruc incorrecto 3");
                            $("#ruc_ci").val("");
                        }else{
                            alert("Ruc pertenece a personas juridicas");
                        }
                    }
                }
            }
        }
    </script>
</html>