<?php
session_start();
ini_set("display_error",true);

foreach (glob("lib/*.php") as $filename){include_once $filename;}

spl_autoload_register(function($class) {
    require_once 'modules/'.$class.'.php';
});

foreach (glob("functions/*.php") as $filename){include_once $filename;}

?>