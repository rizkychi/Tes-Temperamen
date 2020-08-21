<?php 
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    $url  = "http://$host$uri"; //localhost
    //$url  = "http://$host"; //internet
?>