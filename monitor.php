<?php





    set_time_limit(0);



    # TODO: 123
    #
    #


    # Выводить таблицу текущих активных. Если их больше 5, то не давать запустить еще один
    # В таблице в каждой строке сразу кнопки с выховом аякса с гет параметром.

    $debug_mode = true; // Выводить все переменные и не делать реальный редирект в конце
    #$debug_mode = false;



    include "config.php";

    include "libs/LIB_simple_html_dom.php";

    require_once( "libs/db_controller_mysqli.php" );
    require_once( "libs/SF_CLASS.php" );

    #####

    if( ! isset($_GET['url_for_mon']) )
        exit("Нет get параметра url_for_mon");

    $url = $_GET['url_for_mon'];





    #####

    $DBC = new DB_Controller();
    $DBC -> Connect( $db_host, $db_user , $db_pass );
    $DBC -> Select_db( $db_name );
    //$DBC -> Get_error();

    #####


    exit( $url );



    exit("<hr>Exit");

    #####

	
?>