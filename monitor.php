<?php
	
    # TODO: сделать статусы у ссылок как в краулере
    #
    #


    # Выводить таблицу текущих активных. Если их больше 5, то не давать запустить еще один
    # В таблице в каждой строке сразу кнопки с выховом аякса с гет параметром.
    # id  ссылка(уник)  статус  интервал_обновления  дата_поста  дата_добавки
    # datetime_start datetime_last_update  memory_used  current_iteration

    #$debug_mode = true; // Выводить все переменные и не делать реальный редирект в конце
    $debug_mode = false;


    $db_host = '127.0.0.1';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = "vk-monitor";




    require_once( "db_controller_mysqli.php" );
    require_once( "SF_CLASS.php" );

    #####

    $DBC = new DB_Controller();
    $DBC -> Connect( $db_host, $db_user , $db_pass );
    $DBC -> Select_db( $db_name );
    //$DBC -> Get_error();

    #####



    exit("<hr>Exit");








    #####

    $sql = "SELECT * FROM directions WHERE uri='$request_uri'";
    $result = $DBC -> Query($sql , "assoc");

    if ( ! $result )
    {
        header("Location: " . SF::Get_This_Server_Domain() . "/uri_not_found");
        exit();
    }

    if( $debug_mode ) SF::PRINTER($result);
    /*  [uri] => /uri_not_found
        [destination] => https://yandex.ru/
        [delay_ms] => 5
        [description] => Если не нашли uri в этой таблице  */

    #####

    if( $debug_mode ) echo "<br>Спим ".$result['delay_ms']."мс" ;

    usleep( $result['delay_ms'] );

    #####

    if( $logging_active )
    {
        $sql = "INSERT INTO logs (uri, destination )
                VALUES(  '".$request_uri."' , '".$result['destination'] ."' )";

        //echo "<br>".$sql; exit();

        if ($debug_mode) echo "<br>Пишем в лог => $sql";
        $DBC->Exec($sql);
    }

    #####

    if( $debug_mode ) exit( "<br>Сейчас был бы переход в => ".$result['destination']."<hr>Exit" ) ;


    header("Location: ".$result['destination'] );
    exit();

	
?>