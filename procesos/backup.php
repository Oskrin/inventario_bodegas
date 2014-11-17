<?php
session_start();
backup();
  function dl_file($file){
     date_default_timezone_set('America/Guayaquil');
     $fecha=date('Y-m-d H:i:s', time());   
     if (!is_file($file)) { die("<b>404 File not found!</b>"); }
     $len = filesize($file);     
     $filename = basename($file);
     $temp=explode('.', $filename);
     $nombre=$temp[0].'-'.$fecha.'.'.'sql';
     $file_extension = strtolower(substr(strrchr($filename,"."),1));
     $ctype="application/force-download";
     header("Pragma: public");
     header("Expires: 0");
     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
     header("Cache-Control: public");
     header("Content-Description: File Transfer");
     header("Content-Type: $ctype");
     $header="Content-Disposition: attachment; filename=".$nombre.";";
     header($header );
     header("Content-Transfer-Encoding: binary");
     header("Content-Length: ".$len);
     @readfile($file);
     exit;
  }

  function backup(){       
    $dbname = "inventario_bodegas"; //database name
    //$dbname = "mantenimiento_inventario"; //database name
    $dbconn = pg_pconnect("host=localhost port=5432 dbname=$dbname user=postgres password=root"); //connectionstring
   
    if (!$dbconn) {
      echo "Can't connect.\n";
    exit;
    }
    /////////id de la auditoria////////////
    date_default_timezone_set('UTC');
    $fecha=date("Y-m-d");
    
    $back = fopen("$dbname.sql","w");
    /////////////////    
    $str="";
    $str .= "\nCREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog" .";";
    $str .= "\nCOMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language'" .";";
    $str .= "\nSET search_path = public, pg_catalog" .";";
    $str .= "\nSET client_encoding=LATIN1" . ";";
     ///////////
    $table = 'bodega_productos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";    
    $str .= "\n" . 'id_bodega_productos' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";
    $str .= "\n" . 'id_bodega' . " " . 'int4' . ",";
    $str .= "\n" . 'stock_bodega' . " " . 'text' . ",";
    $str .= "\n" . 'fecha_asignacion' . " " . 'text' . ",";
    $str .= "\n" . 'hora_asignacion' . " " . 'text' . ",";
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";
    $str .= "\n" . 'estado' . " " . 'text' . ",";
    $str .= "\n" . 'existencia' . " " . 'text' . ",";
    $str .= "\n" . 'diferencia' . " " . 'text';
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";

    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);      
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
    } //////////////////
    $table = 'c_cobrarexternas';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";    
    $str .= "\n" . 'id_c_cobrarexternas' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'id_cliente' . " " . 'int4' . ",";
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ",";
    $str .= "\n" . 'hora_actual' . " " . 'text' . ",";
    $str .= "\n" . 'num_factura' . " " . 'text' . ",";
    $str .= "\n" . 'tipo_documento' . " " . 'text' . ",";
    $str .= "\n" . 'total' . " " . 'text' . ",";
    $str .= "\n" . 'saldo' . " " . 'text' . ",";
    $str .= "\n" . 'estado' . " " . 'text';
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";

    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);      
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
    } //////////////////
     $table = 'bodegas';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";    
    $str .= "\n" . ' id_bodega' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'nombre_bodega' . " " . 'text' . ",";
    $str .= "\n" . 'ubicacion' . " " . 'text' . ",";
    $str .= "\n" . 'telefono' . " " . 'text' . ",";
    $str .= "\n" . 'movil' . " " . 'text' . ",";
    $str .= "\n" . 'estado' . " " . 'text';
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";

    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);      
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
    } //////////////////
    $table = 'c_pagarexternas';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_c_pagarexternas' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'id_proveedor' . " " . 'int4' . ",";
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ",";
    $str .= "\n" . 'hora_actual' . " " . 'text' . ",";
    $str .= "\n" . 'num_factura' . " " . 'text' . ",";
    $str .= "\n" . 'tipo_documento' . " " . 'text' . ",";
    $str .= "\n" . 'total' . " " . 'text' . ",";
    $str .= "\n" . 'saldo' . " " . 'text' . ",";
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);
      // Next Line Can be improved!!!
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
    } ////////////////////    
    $table = 'categoria';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_categoria' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'nombre_categoria' . " " . 'text' . ",";    
    $str .= "\n" . 'estado' . " " . 'text';   
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);
      // Next Line Can be improved!!!
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";      
  }////////////////// 
    $table = 'clientes';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_cliente' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'tipo_documento' . " " . 'text' . ",";    
    $str .= "\n" . 'identificacion' . " " . 'text' . ",";    
    $str .= "\n" . 'nombres_cli' . " " . 'text' . ",";    
    $str .= "\n" . 'tipo_cliente' . " " . 'text' . ",";    
    $str .= "\n" . 'direccion_cli' . " " . 'text' . ",";    
    $str .= "\n" . 'telefono' . " " . 'text' . ",";    
    $str .= "\n" . 'celular' . " " . 'text' . ",";    
    $str .= "\n" . 'pais' . " " . 'text' . ",";    
    $str .= "\n" . 'ciudad' . " " . 'text' . ",";    
    $str .= "\n" . 'correo' . " " . 'text' . ",";    
    $str .= "\n" . 'credito_cupo' . " " . 'text' . ",";    
    $str .= "\n" . 'notas' . " " . 'text' . ",";    
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);
      // Next Line Can be improved!!!
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";      
  }  
    $table = 'color';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_color' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'nombre_color' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  }//////////////////  
  $table = 'detalle_devolucion_compra';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla  '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_devcompra' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_devolucion_compra' . " " . 'int4' . ",";      
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";      
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";      
    $str .= "\n" . 'precio_compra' . " " . 'text' . ",";      
    $str .= "\n" . 'descuento_producto' . " " . 'text' . ",";      
    $str .= "\n" . 'total_compra' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';      
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  }///////////////////  
  $table = 'detalle_devolucion_venta';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_deventa' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_devolucion_venta' . " " . 'int4' . ",";      
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";      
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";   
    $str .= "\n" . 'precio_venta' . " " . 'text' . ",";   
    $str .= "\n" . 'descuento_producto' . " " . 'text' . ",";   
    $str .= "\n" . 'total_venta' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  }////////////////////// 
  $table = 'detalle_egreso';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_egreso' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_egresos' . " " . 'int4' . ",";      
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";      
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";      
    $str .= "\n" . 'precio_costo' . " " . 'text' . ",";      
    $str .= "\n" . 'descuento' . " " . 'text' . ",";      
    $str .= "\n" . 'total' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  }/////////////////// 
  $table = 'detalle_factura_compra';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_compra' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_factura_compra' . " " . 'int4' . ",";      
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";      
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";      
    $str .= "\n" . 'precio_compra' . " " . 'text' . ",";      
    $str .= "\n" . 'descuento_producto' . " " . 'text' . ",";      
    $str .= "\n" . 'total_compra' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";      
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'detalle_factura_venta';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_venta' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_factura_venta' . " " . 'int4' . ",";      
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ","; 
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";     
    $str .= "\n" . 'precio_venta' . " " . 'text' . ",";     
    $str .= "\n" . 'descuento_producto' . " " . 'text' . ",";     
    $str .= "\n" . 'total_venta' . " " . 'text' . ",";     
    $str .= "\n" . 'estado' . " " . 'text' . ",";     
    $str .= "\n" . 'pendientes' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  }///////////////
  $table = 'detalle_ingreso';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_ingreso' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_ingresos' . " " . 'int4' . ",";      
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";      
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";      
    $str .= "\n" . 'precio_costo' . " " . 'text' . ",";      
    $str .= "\n" . 'descuento' . " " . 'text' . ",";      
    $str .= "\n" . 'total' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } ////////////////
  $table = 'detalle_inventario';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_inventario' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_inventario' . " " . 'int4' . ",";      
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";      
    $str .= "\n" . 'p_costo' . " " . 'text' . ",";      
    $str .= "\n" . 'p_venta' . " " . 'text' . ",";      
    $str .= "\n" . 'disponibles' . " " . 'text' . ",";      
    $str .= "\n" . 'existencia' . " " . 'text' . ",";      
    $str .= "\n" . 'diferencia' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';                  
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } /////////////////
  $table = ' detalle_pagos_venta';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_pagos_venta' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_pagos_venta' . " " . 'int4' . ",";                  
    $str .= "\n" . 'fecha_pago' . " " . 'text' . ",";                  
    $str .= "\n" . 'cuota' . " " . 'text' . ",";                  
    $str .= "\n" . 'saldo' . " " . 'text' . ",";                  
    $str .= "\n" . 'estado' . " " . 'text';                  
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } ////////////////
  $table = 'detalle_proforma';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalle_proforma' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_proforma' . " " . 'int4' . ",";                  
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";                  
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";                  
    $str .= "\n" . 'precio_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'total_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'detalles_ordenes';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalles_ordenes' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_ordenes' . " " . 'int4' . ",";                  
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";                  
    $str .= "\n" . 'cantidad' . " " . 'text' . ",";                  
    $str .= "\n" . 'precio_costo' . " " . 'text' . ",";                  
    $str .= "\n" . 'total_costo' . " " . 'text' . ",";                  
    $str .= "\n" . 'estado' . " " . 'text';                      

    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } /////////////
  $table = 'detalles_pagos_internos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_detalles_pagos_interna' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_cuentas_cobrar' . " " . 'int4' . ",";                  
    $str .= "\n" . 'fecha_pago_actual' . " " . 'text' . ",";                  
    $str .= "\n" . 'total_pagos' . " " . 'text' . ",";                  
    $str .= "\n" . 'saldo' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'devolucion_compra';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_devolucion_compra' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_proveedor' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'num_serie' . " " . 'text' . ","; 
    $str .= "\n" . 'num_autorizacion' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa0' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa12' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_compra' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_compra' . " " . 'text' . ","; 
    $str .= "\n" . 'total_compra' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'devolucion_venta';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_devolucion_venta' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_cliente' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'num_serie' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa0' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa12' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'total_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'egresos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_egresos ' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'origen' . " " . 'text' . ","; 
    $str .= "\n" . 'destino' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa0' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa12' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_egreso' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_egreso' . " " . 'text' . ","; 
    $str .= "\n" . 'total_egreso' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'empresa';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_empresa' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_empresa' . " " . 'text' . ",";                  
    $str .= "\n" . 'ruc_empresa' . " " . 'text' . ",";                  
    $str .= "\n" . 'direccion_empresa' . " " . 'text' . ",";                  
    $str .= "\n" . 'telefono_empresa' . " " . 'text' . ","; 
    $str .= "\n" . 'celular_empresa' . " " . 'text' . ","; 
    $str .= "\n" . 'fax_empresa' . " " . 'text' . ","; 
    $str .= "\n" . 'email_empresa' . " " . 'text' . ","; 
    $str .= "\n" . 'pagina_web' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'factura_compra';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_factura_compra' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_proveedor' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_registro' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_emision' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_caducidad' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'num_serie' . " " . 'text' . ","; 
    $str .= "\n" . 'num_autorizacion' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_cancelacion' . " " . 'text' . ","; 
    $str .= "\n" . 'forma_pago' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa0' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa12' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_compra' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_compra' . " " . 'text' . ","; 
    $str .= "\n" . 'total_compra' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'factura_venta';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_factura_venta' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_cliente' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'num_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_cancelacion' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_precio' . " " . 'text' . ","; 
    $str .= "\n" . 'forma_pago' . " " . 'text' . ","; 
    $str .= "\n" . 'num_autorizacion' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_autorizacion' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_caducidad' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa0' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa12' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'total_venta' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_anulacion' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'gastos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_gastos' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_factura_venta' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'descripcion' . " " . 'text' . ","; 
    $str .= "\n" . 'valor' . " " . 'text' . ","; 
    $str .= "\n" . 'saldo' . " " . 'text' . ","; 
    $str .= "\n" . 'acumulado' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'gastos_internos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_gastos' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_proveedor' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'num_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'descripcion' . " " . 'text' . ","; 
    $str .= "\n" . 'total' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'ingresos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_ingresos' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'origen' . " " . 'text' . ","; 
    $str .= "\n" . 'destino' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa0' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa12' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_ingreso' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_ingreso' . " " . 'text' . ","; 
    $str .= "\n" . 'total_ingreso' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'inventario';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_inventario' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'kardex';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_kardex' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'fecha_kardex' . " " . 'text' . ",";                  
    $str .= "\n" . 'detalle' . " " . 'text' . ",";                  
    $str .= "\n" . 'cantidad_c' . " " . 'text' . ",";                  
    $str .= "\n" . 'valor_unitario_c' . " " . 'text' . ","; 
    $str .= "\n" . 'total_c' . " " . 'text' . ","; 
    $str .= "\n" . 'cantidad_v' . " " . 'text' . ","; 
    $str .= "\n" . 'valor_unitario_v' . " " . 'text' . ","; 
    $str .= "\n" . 'total_v ' . " " . 'text' . ","; 
    $str .= "\n" . 'cod_productos ' . " " . 'int4' . ","; 
    $str .= "\n" . 'transaccion ' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'kardex_valorizado';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_kardex' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";                  
    $str .= "\n" . 'fecha_transaccion' . " " . 'text' . ",";                  
    $str .= "\n" . 'concepto' . " " . 'text' . ",";                  
    $str .= "\n" . 'entrada' . " " . 'text' . ","; 
    $str .= "\n" . 'salida' . " " . 'text' . ","; 
    $str .= "\n" . 'existencia' . " " . 'text' . ","; 
    $str .= "\n" . 'costo_unitario' . " " . 'text' . ","; 
    $str .= "\n" . 'costo_promedio' . " " . 'text' . ","; 
    $str .= "\n" . 'debe' . " " . 'text' . ","; 
    $str .= "\n" . 'haber' . " " . 'text' . ","; 
    $str .= "\n" . 'saldo' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'marcas';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_marca' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_marca' . " " . 'text' . ","; 
     $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'ordenes_produccion';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_ordenes' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ",";                  
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ","; 
    $str .= "\n" . 'cantidad' . " " . 'text' . ","; 
    $str .= "\n" . 'sub_total' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'pagos_cobrar';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_cuentas_cobrar' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_cliente' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'forma_pago' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_pago' . " " . 'text' . ","; 
    $str .= "\n" . 'num_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'total_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'valor_pagado' . " " . 'text' . ","; 
    $str .= "\n" . 'saldo_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'pagos_compra';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_pagos_compra' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_proveedor' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_factura_compra' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'fecha_credito' . " " . 'text' . ","; 
    $str .= "\n" . 'adelanto' . " " . 'text' . ","; 
    $str .= "\n" . 'meses' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_documento' . " " . 'text' . ","; 
    $str .= "\n" . 'monto_credito' . " " . 'text' . ","; 
    $str .= "\n" . 'saldo' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'pagos_pagar';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_cuentas_pagar' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_proveedor' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'forma_pago' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_pago' . " " . 'text' . ","; 
    $str .= "\n" . 'num_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'total_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'valor_pagado' . " " . 'text' . ","; 
    $str .= "\n" . 'saldo_factura' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'pagos_venta';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_pagos_venta' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_cliente' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_factura_venta' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'fecha_credito' . " " . 'text' . ","; 
    $str .= "\n" . 'adelanto' . " " . 'text' . ","; 
    $str .= "\n" . 'meses' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_documento' . " " . 'text' . ","; 
    $str .= "\n" . 'monto_credito' . " " . 'text' . ","; 
    $str .= "\n" . 'saldo' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'productos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'cod_productos' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'codigo' . " " . 'text' . ",";                  
    $str .= "\n" . 'cod_barras' . " " . 'text' . ",";                  
    $str .= "\n" . 'articulo' . " " . 'text' . ",";                  
    $str .= "\n" . 'iva' . " " . 'text' . ","; 
    $str .= "\n" . 'series' . " " . 'text' . ","; 
    $str .= "\n" . 'precio_compra' . " " . 'text' . ","; 
    $str .= "\n" . 'utilidad_minorista' . " " . 'text' . ","; 
    $str .= "\n" . 'utilidad_mayorista' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_minorista' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_mayorista' . " " . 'text' . ","; 
    $str .= "\n" . 'categoria' . " " . 'text' . ","; 
    $str .= "\n" . 'marca' . " " . 'text' . ","; 
    $str .= "\n" . 'stock' . " " . 'text' . ","; 
    $str .= "\n" . 'stock_minimo' . " " . 'text' . ","; 
    $str .= "\n" . 'stock_maximo' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_creacion' . " " . 'text' . ","; 
    $str .= "\n" . 'caracteristicas' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento' . " " . 'text' . ","; 
    $str .= "\n" . 'estado' . " " . 'text' . ","; 
    $str .= "\n" . 'inventariable' . " " . 'text' . ","; 
    $str .= "\n" . ' imagen' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'proforma';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_proforma' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_cliente' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_empresa' . " " . 'int4' . ",";                  
    $str .= "\n" . 'comprobante' . " " . 'text' . ","; 
    $str .= "\n" . 'fecha_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'hora_actual' . " " . 'text' . ","; 
    $str .= "\n" . 'tipo_precio' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa0' . " " . 'text' . ","; 
    $str .= "\n" . 'tarifa12' . " " . 'text' . ","; 
    $str .= "\n" . 'iva_proforma' . " " . 'text' . ","; 
    $str .= "\n" . 'descuento_proforma' . " " . 'text' . ","; 
    $str .= "\n" . 'total_proforma' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'proveedores';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_proveedor' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'tipo_documento' . " " . 'text' . ",";                  
    $str .= "\n" . 'identificacion_pro' . " " . 'text' . ",";                  
    $str .= "\n" . 'empresa_pro' . " " . 'text' . ",";                  
    $str .= "\n" . 'representante_legal' . " " . 'text' . ","; 
    $str .= "\n" . 'visitador' . " " . 'text' . ","; 
    $str .= "\n" . 'direccion_pro' . " " . 'text' . ","; 
    $str .= "\n" . 'telefono' . " " . 'text' . ","; 
    $str .= "\n" . 'celular' . " " . 'text' . ","; 
    $str .= "\n" . 'fax' . " " . 'text' . ","; 
    $str .= "\n" . 'pais' . " " . 'text' . ","; 
    $str .= "\n" . 'ciudad' . " " . 'text' . ","; 
    $str .= "\n" . 'forma_pago' . " " . 'text' . ","; 
    $str .= "\n" . 'correo' . " " . 'text' . ","; 
    $str .= "\n" . 'principal' . " " . 'text' . ","; 
    $str .= "\n" . 'observaciones' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  
  $table = 'seguridad';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_seguridad' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'clave' . " " . 'text' . ",";                  
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'serie_venta';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_serie_venta' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_factura_venta' . " " . 'int4' . ",";                  
    $str .= "\n" . 'serie' . " " . 'text' . ",";                  
    $str .= "\n" . 'observacion' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  $table = 'series_compra';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_serie' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'cod_productos' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_factura_compra' . " " . 'int4' . ",";                  
    $str .= "\n" . 'serie' . " " . 'text' . ",";                  
    $str .= "\n" . 'observacion' . " " . 'text' . ","; 
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////

 
  $table = 'usuario';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_usuario' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_usuario' . " " . 'text' . ",";                  
    $str .= "\n" . 'apellido_usuario' . " " . 'text' . ",";                  
    $str .= "\n" . 'ci_usuario' . " " . 'text' . ",";                  
    $str .= "\n" . 'telefono_usuario' . " " . 'text' . ",";                  
    $str .= "\n" . 'celular_usuario' . " " . 'text' . ",";                  
    $str .= "\n" . 'cargo_usuario' . " " . 'text' . ",";                  
    $str .= "\n" . 'clave' . " " . 'text' . ",";                  
    $str .= "\n" . 'email_usuario' . " " . 'text' . ",";                  
    $str .= "\n" . 'direccion_usuario' . " " . 'text' . ",";                  	
    $str .= "\n" . 'usuario' . " " . 'text' . ",";                    
    $str .= "\n" . 'id_bodega' . " " . 'int4' . ",";                    
    $str .= "\n" . ' estado' . " " . 'text'; 
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } //////////////////
  
  /////////////////////////////// 
  $res = pg_query(" SELECT
  cl.relname AS tabela,ct.conname,
   pg_get_constraintdef(ct.oid)
   FROM pg_catalog.pg_attribute a
   JOIN pg_catalog.pg_class cl ON (a.attrelid = cl.oid AND cl.relkind = 'r')
   JOIN pg_catalog.pg_namespace n ON (n.oid = cl.relnamespace)
   JOIN pg_catalog.pg_constraint ct ON (a.attrelid = ct.conrelid AND
   ct.confrelid != 0 AND ct.conkey[1] = a.attnum)
   JOIN pg_catalog.pg_class clf ON (ct.confrelid = clf.oid AND 
clf.relkind = 'r')
   JOIN pg_catalog.pg_namespace nf ON (nf.oid = clf.relnamespace)
   JOIN pg_catalog.pg_attribute af ON (af.attrelid = ct.confrelid AND
   af.attnum = ct.confkey[1]) order by cl.relname ");
  while($row = pg_fetch_row($res))
  {
    $str .= "\n\n--\n";
    $str .= "-- Creating relacionships for '".$row[0]."'";
    $str .= "\n--\n\n";
    $str .= "ALTER TABLE ONLY ".$row[0] . " ADD CONSTRAINT " . $row[1] . 
" " . $row[2] . ";";
  }     

	  
  ////////////////  
  fwrite($back,$str);
  fclose($back);
  dl_file("$dbname.sql");
  
}

?>
 