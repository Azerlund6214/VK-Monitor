<?php


    ob_implicit_flush(); ### Отключаем SAPI-буфер
    ob_end_flush();



    #$debug_mode = true; // Выводить все переменные и не делать реальный редирект в конце
    $debug_mode = false;


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

    $sql = "SELECT * FROM curent_states";
    $result = $DBC -> Query($sql , "all");
    //$DBC -> Get_error();

    if ( ! $result )
        exit("Таблица пуста");

    if( $debug_mode ) SF::PRINTER($result);







    //exit("<hr>Exit");




    echo '<table border=2px class="result_table">
					<thead>
						<tr >
							<td><strong>id</strong></td>
							<td><strong>Ссылка</strong></td>
							<td><strong>Интервал</strong></td>
							<td><strong>Время добавки</strong></td>
							<td><strong>Последнее обн.</strong></td>
							<td><strong>Память</strong></td>
							<td><strong>Итерация</strong></td>
							<td><strong>Запуск/Пауза</strong></td>
							<td><strong>Подробнее</strong></td>
						</tr>
					</thead>
					<tbody>
					';

    echo "<form method='POST' id='form_states_tbl'>";

        foreach( $result as $One_Set)
        {
            echo "<tr>";

            echo 	"<td>". $One_Set[0] ."</td>";
            echo 	"<td>". $One_Set[1] ."</td>";
            echo 	"<td>". $One_Set[2] ."</td>";
            echo 	"<td>". $One_Set[3] ."</td>";
            echo 	"<td>". $One_Set[4] ."</td>";
            echo 	"<td>". $One_Set[5] ."</td>";
            echo 	"<td>". $One_Set[6] ."</td>";



            echo 	'<td>
                        <input name="test" type="text" value="https://www.vk.com/123" hidden>
                        <input type="button" value="Запуск" onsubmit=Exec_AJAX( "monitor.php" , "#form_states_tbl" , "#div_result" )>

                    </td>';

            echo 	"<td>"

                ."</td>";

            echo "</tr>";
        }

    echo "</form>";


    echo 	"</tbody>";
    echo "</table>";






    #####


    //exit();

	
?>