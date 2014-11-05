<?php 

 exec('pg_dump -c -F c -Z 9 -h localhost -U postgres -p 5432 -w mantenimiento > C:/xampp/htdocs/mantenimiento/backups/bases/mantenimiento.backup');  
?>