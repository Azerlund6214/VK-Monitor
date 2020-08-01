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




echo '  <link rel="stylesheet" type="text/css" href="table_style.css">
        <table border=2px class="result_table">
					<thead>
						<tr >
							<td><strong>Начало круга</strong></td>
							<td><strong>Время</strong></td>
							<td><strong>Просмотров</strong></td>
							<td><strong>Лайков</strong></td>
							<td><strong>Итерация</strong></td>
							<td><strong>Сейчас сплю</strong></td>
						</tr>
					</thead>
					<tbody>
					';


for ( $i = 0 ;  ; $i++ )
{
    echo "<tr>";
    echo 	"<td>". $i ."</td>";

    //file_put_contents( "12345.html" , file_get_contents($post_url) ); exit;

    ### SHD
    $SHD_html = file_get_html( $post_url );

    $current_likes = $SHD_html -> find('.item_like')[1] -> attr['aria-label'];
    $current_likes = explode( " " , $current_likes )[0];

    $current_views = $SHD_html -> find('.item_views')[0] -> attr['aria-label'];
    $current_views = explode( " " , $current_views )[0];

    unset( $SHD_html );

    #TODO: Проверка на непустые значения
    #TODO: Проверка что страница нормально распарсилась
    #TODO: Проверка что пришла страница с постом, а не с капчей




    $date_time_now = date("Y-m-d H:i:s");
    $Current_iteration = $DBC -> Query( "SELECT current_iteration FROM curent_states WHERE post_url = '$post_url'" )[0][0];

    echo 	"<td>". $date_time_now ."</td>";
    echo 	"<td>". $current_views ."</td>";
    echo 	"<td>". $current_likes ."</td>";
    echo 	"<td>". $Current_iteration ."</td>";

    $sql = "INSERT INTO mon_results ( post_url ,      iteration        , count_likes      , count_views )
                           VALUES(  '$post_url' , $Current_iteration , '$current_likes' , '$current_views' )";
    $DBC -> Exec( $sql );





    $memory_used = round(SF::Memory_Usage_EchoGet("M","Get"),2 )."Mb";

    # Обновление всей главной таблицы
    $sql = "UPDATE curent_states SET 
                datetime_mon_last_update = '$date_time_now', 
                memory_used = '$memory_used' ,
                current_iteration=current_iteration+1
            WHERE
                post_url = '$post_url' ";
    $DBC -> Exec( $sql );

    //$DBC -> Get_error();

    //exit( "<hr>Exit" );

    echo 	"<td>". $sleep_time ."сек</td>";
    echo "</tr>";


    sleep($sleep_time);

}









    exit("<hr>Exit");

    #####

	
?>