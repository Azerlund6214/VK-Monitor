<?php


    ob_implicit_flush(); ### Отключаем SAPI-буфер
    ob_end_flush();

    date_default_timezone_set("Europe/Moscow");

    set_time_limit(0);



    # TODO: сделать статусы у ссылок как в краулере
    #
    #


    # Выводить таблицу текущих активных. Если их больше 5, то не давать запустить еще один
    # В таблице в каждой строке сразу кнопки с выховом аякса с гет параметром.

    $debug_mode = true; // Выводить все переменные и не делать реальный редирект в конце
    #$debug_mode = false;


    $db_host = '127.0.0.1';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = "vk-monitor";


    include "LIB_simple_html_dom.php";

    require_once( "db_controller_mysqli.php" );
    require_once( "SF_CLASS.php" );

    #####

    if( ! isset($_GET['test']) )
        exit("Нет get параметра url_for_add");

    $url = $_GET['test'];
    exit("123");
    #####

    $DBC = new DB_Controller();
    $DBC -> Connect( $db_host, $db_user , $db_pass );
    $DBC -> Select_db( $db_name );
    //$DBC -> Get_error();

    #####



    exit("<hr>Exit");


function Echo_Table( )
{

    echo '<table border=2px class="result_table">
					<thead>
						<tr >
							<td><strong>ITAG</strong></td>
							<td><strong>mimeType</strong></td>
							<td><strong>quality</strong></td>
							<td><strong>qualityLabel</strong></td>
							<td><strong>Размер</strong></td>
							<td><strong>contentLength</strong></td>
							<td><strong>URL</strong></td>
						</tr>
					</thead>
					<tbody>
					';

    foreach($this->FIN_Video_Itag_Info_Asoc_FULL as $One_Set)
    {
        echo "<tr>";

        echo 	"<td>". $One_Set['itag'] ."</td>";
        echo 	"<td>". $One_Set['mimeType'] ."</td>";
        echo 	"<td>". $One_Set['quality'] ."</td>";
        echo 	"<td>". $One_Set['qualityLabel'] ."</td>";
        echo 	"<td>". $One_Set['width'] . "x" . $One_Set['height'] ."</td>";
        echo 	"<td>". (int)($One_Set['contentLength']/1024/1024) ."Мб</td>";
        echo 	"<td>".
            '<a href="'.$One_Set['url'].'" target="_blank" download>
								<span> Скачать </span>	
							</a>'
            ."</td>";
        echo "</tr>";
    }

    echo 	"</tbody>";
    echo "</table>";

}







    #####


    exit();

	
?>