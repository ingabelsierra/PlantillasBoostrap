<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
echo "exts".file_exists("/var/www/html/dilip.txt");
echo file_put_contents("/var/www/html/dilip.txt","Hello World. Testing!");
?> 