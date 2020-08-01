<?php


    ob_implicit_flush(); ### Отключаем SAPI-буфер
    ob_end_flush();



    $debug_mode = true; // Выводить все переменные и не делать реальный редирект в конце
    #$debug_mode = false;


    $db_host = '127.0.0.1';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = "vk_monitor";


    require_once( "db_controller_mysqli.php" );
    require_once( "SF_CLASS.php" );

    #####

    $DBC = new DB_Controller();
    $DBC -> Connect( $db_host, $db_user , $db_pass );
    $DBC -> Select_db( $db_name );
    //$DBC -> Get_error();

    #####


    if( ! isset($_POST['url_for_add']) )
        exit("Нет get параметра url_for_add");

    $url = $_POST['url_for_add'];


    # TODO: Тут будет куча проверок


    $sql = "INSERT INTO curent_states ( post_url )
                    VALUES(  '".$url."' )";


    //echo "<br>".$sql; exit();

    if ($debug_mode) echo "<br>Пишем в лог => $sql";
    //$DBC->Exec($sql);








    //exit("<hr>Exit");







    #####


    //exit();

	
?>