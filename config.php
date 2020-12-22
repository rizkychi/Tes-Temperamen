<?php 
    // Global url
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    // Online/offline mode
    //$url  = "http://$host$uri"; //localhost
    $url  = "http://$host"; //internet

    // Path for python script (algorithm)
    $python_path = 'http://seruva.masrizky.com/'
?>