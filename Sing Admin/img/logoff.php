<?php
require_once("include/config.php");

foreach($_SESSION as $key=>$value) {
		unset($key);		
}
session_destroy();
header("location:login.php"); exit;
?>