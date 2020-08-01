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

    $post_url = $_GET['url_for_mon'];

    echo "<br>Целевой url получен => $post_url";



    #####

    $DBC = new DB_Controller();
    $DBC -> Connect( $db_host, $db_user , $db_pass );
    $DBC -> Select_db( $db_name );
    //$DBC -> Get_error();

    echo "<br>Подключились к бд";

    #####





    $sql = "SELECT * FROM curent_states WHERE post_url='$post_url'";
    $result = $DBC -> Query($sql , "assoc");
    //$DBC -> Get_error();
    //SF::PRINTER($result);

    # TODO: Проверка если не нашли

    $sleep_time = $result['update_interval'];

    echo "<br>Получили запись из главной таблицы, начинается цикл.<hr color='red'>";





for ( $i = 0 ;  ; $i++ )
{
    echo "<br>Начало круга -> $i ===> ";

    //file_put_contents( "12345.html" , file_get_contents($post_url) ); exit;

    ### SHD
    $SHD_html = file_get_html( $post_url );

    $current_likes = $SHD_html -> find('.item_like')[1] -> attr['aria-label'];
    $current_likes = explode( " " , $current_likes )[0];

    $current_views = $SHD_html -> find('.item_views')[0] -> attr['aria-label'];
    $current_views = explode( " " , $current_views )[0];

    unset( $SHD_html );

    echo "<pre>Likes="; print_r( $current_likes ); echo "</pre>";
    echo "<pre>Views="; print_r( $current_views ); echo "</pre>";





    //write_in_file( $target_file_name , $final_text );


    exit( "<hr>Exit" );

    echo " ===> Сплю $sleep_time секунд";

    sleep($sleep_time);

}









    exit("<hr>Exit");

    #####

	
?>