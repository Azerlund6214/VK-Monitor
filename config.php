<?php


    ob_implicit_flush(); ### Отключаем SAPI-буфер
    ob_end_flush();

    date_default_timezone_set("Europe/Moscow");


    $db_host = '127.0.0.1';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = "vk_monitor";



	
?>