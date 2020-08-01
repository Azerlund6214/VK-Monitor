<?php
	### 120620 1128 - 
	
	
	ob_implicit_flush(); ### Отключаем SAPI-буфер
	ob_end_flush();
	
	date_default_timezone_set("Europe/Moscow");
	
	set_time_limit(0);
	
	$debug_mode = true; // Не будет реального перехода
	
	
	$txt_name_log = "0=logs.txt";
	
	
	//$curr_file_url = $_SERVER['PHP_SELF'];
	
	
	########################################################
	
	
	#Данных нет
	if ( ! isset( $_POST["post_url"] ) )
	{

		echo "<hr color=red>";
		
		echo '
		
		<form action="" method="post">
		 
		 <p>Ссылка: <input type="text" name="post_url" value="https://vk.com/wall-193812347_5123" /></p>
		 <p>Дата поста(php): <input type="text" name="post_date" value="2020-0- :" /> Формат = 2020-06-12 14:00</p>
		 <p>Имя файла для записи: <input type="text" name="file_name" value="==.txt"/> Номер на стене=номер из ссылки=дата (Нельзя рус и :)</p>
		 
		 <p><textarea type="text" name="txt_data" rows="15" cols="50">'.file_get_contents( "0=settins_default.txt" ).'</textarea></p>
		 
		 
		 <p><input type="submit" /></p>
		</form>
		
		';
		
		echo "<hr color=red>";
		exit;
		
	}
	

	
	# Пришли данные
	echo "Пришли данные";
	
	
	include "LIB_simple_html_dom.php";
	
	##########################################
	
	#Подготовка всех переменных
	
	function write_in_file( $filename, $text )
	{
		if ( ! $handle = fopen($filename, 'a+')) exit ("Не могу открыть файл ($filename)");
		if (fwrite($handle, $text . PHP_EOL ) === FALSE) exit ("Не могу произвести запись в файл ($filename)");
		fclose($handle);
	}
	
	// Работает, се правильно.  Выходит по превышению.
	function refresh_reload_time( $arr_settins , $current_views )
	{
		for ( $i=0 ; $i<=count($arr_settins) ; $i++ )
		{
			
			if ( $arr_settins[$i][1] === "stop" )
				return "stop";
			
			
			// В следующем сете больше.
			if ( $current_views < $arr_settins[$i+1][0] )
				return $arr_settins[$i][1];
			
			
			
			
			#if ( $current_views < $arr_settins[1] ) // Сейчас 20 просм, в массиве 46.     Сейчас 45 просм, в массиве 46.
			#	continue;
			
			//В массиве 46.  У нас 46 и больше.
			
			/* Код проверки
			echo "<br> просм-  0 Интервал=".refresh_reload_time( $arr_settins ,  0 );
			echo "<br> просм- 24 Интервал=".refresh_reload_time( $arr_settins , 24 );
			echo "<br> просм- 25 Интервал=".refresh_reload_time( $arr_settins , 25 );
			echo "<br> просм- 30 Интервал=".refresh_reload_time( $arr_settins , 30 );
			echo "<br> просм- 31 Интервал=".refresh_reload_time( $arr_settins , 31 );
			echo "<br> просм- 50 Интервал=".refresh_reload_time( $arr_settins , 50 );
			echo "<br> просм- 90 Интервал=".refresh_reload_time( $arr_settins , 90 );
			echo "<br> просм-250 Интервал=".refresh_reload_time( $arr_settins ,250 );
			echo "<br> просм-297 Интервал=".refresh_reload_time( $arr_settins ,297 );
			echo "<br> просм-300 Интервал=".refresh_reload_time( $arr_settins ,300 );
			*/
			
			
		}
		
		
		## ищем между какими мы значениями и выдаем интервал
		return 0;
	}
	

	
	$post_url = $_POST["post_url"];
	$post_date = $_POST["post_date"];
	$target_file_name = $_POST["file_name"];
	$txt_data = $_POST["txt_data"];
	
	
	
	
	
	$arr_settins = explode( PHP_EOL , $txt_data );
	foreach ( $arr_settins as &$one_str )
	{
		$one_str = explode( "#" , $one_str );
		
		foreach ( $one_str as &$one )
			$one = trim($one);
	}
	
	
	// В разбитом виде, как юзается по факту
	//echo "<pre>"; print_r($arr_settins); echo "</pre>";
	
	
	
	# Вывод всех переменных
	# в тч в лог
	
	echo "<hr color=red>";
	echo "<br>".$post_url;
	echo "<br>".$target_file_name;
	echo "<br>".$post_date;
	echo "<br>";
	echo "<pre>"; print_r( explode( PHP_EOL , $txt_data ) ); echo "</pre>"; // Построчно, без разбивки, для наглядности
	echo "<hr color=red>";
	
	
	
	
	// Убрать и доработать
	function dates_diff( $format="Y-m-d H:i", $date1 , $date2 )
	{
		$now = new DateTime(); // текущее время на сервере
		$date = DateTime::createFromFormat( $format , '2014-09-12 23:59'); // задаем дату в любом формате
		$interval = $now->diff($date); // получаем разницу в виде объекта DateInterval
		echo $interval->y, "\n"; // кол-во лет
		echo $interval->d, "\n"; // кол-во дней
		echo $interval->h, "\n"; // кол-во часов
		echo $interval->i, "\n"; // кол-во минут
	}
	
	
	// убрать
	function getTags( $some_link, $tagName, $attrName, $attrValue )
	{
		/*
		$tagName = 'div';
		$attrName = 'class';
		$attrValue = 'like_button_count';
		*/
		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = false;
		$dom->loadHTMLFile($some_link);
		
		
		$html = '';
		$domxpath = new DOMXPath($dom);
		$newDom = new DOMDocument;
		$newDom->formatOutput = true;
		
		$filtered = $domxpath->query("//$tagName" . '[@' . $attrName . "='$attrValue']");
		// $filtered =  $domxpath->query('//div[@class="className"]');
		// '//' when you don't know 'absolute' path
		
		// since above returns DomNodeList Object
		// I use following routine to convert it to string(html); copied it from someone's post in this site. Thank you.
		$i = 0;
		while( $myItem = $filtered->item($i++) ){
			$node = $newDom->importNode( $myItem, true );    // import node
			$newDom->appendChild($node);                    // append node
		}
		$html = $newDom->saveHTML();
		
		return $html;
	}
	
	
	
	/*
		// Поиск по тегам и классам
		#########
		#$html = file_get_contents( $post_url );
		
		### Explode
		#$current_likes = explode( '</b>' , explode( '<b class="v_like" aria-hidden="true">' , $html )[1] )[0]   ;
		#$current_views = explode( '</b>' , explode( '<b class="v_views">' , $html )[1] )[0]   ;
		
		### RegExp (робит, но кривовато)
		#preg_match_all('|<b class="v_like" aria-hidden="true">(.+?)</b>|isU', $html, $current_likes);
		#preg_match_all('|<b class="v_views">(.+?)</b>|isU', $html, $current_views);
		
		#unset( $html );
		#########
	
	*/
	
	
	# $date1 = '2009-01-21 18:45'; // Для тестов
	# $date2 = '2010-05-19 12:30';
	# Формат: 2010-05-19 12:30   или 2010-05-19 12:30:00 , будут работать и другие
	function date_diff_my($date1, $date2 , $target="m")
	{
		$diff = strtotime($date2) - strtotime($date1); // Время в секцндах
		
		switch($target)
		{
			case "s": return $diff;
			case "m": return $diff/60;
			case "h": return $diff/60/60;
			case "d": return $diff/60/60/24;
			default: exit("exit-дефолт в date_diff_my()");
		
		}
		
		//return abs($diff);  Было так
	}
	
	
	$current_rescan_time = refresh_reload_time( $arr_settins , 0 );
	
	$current_likes = 0;
	$current_views = 0;
	
	
	//echo "Начало круга -> 0 ===> 2020-06-12 14:00 ### 2020-06-12 17:43 ### 223 ### 795 ### 130 ===> Сплю 15 секунд";
	echo "_________________ ===> ___Дата поста___ ### __Текущая дата__ ##_Минут_#_Просм_#_Лайков ";
	
	
	write_in_file( $txt_name_log , date("Y-m-d H:i")." = Запущен цикл для: $post_url" );
	
	for ( $i = 0 ;  ; $i++ )
	{	
		//$post_url = "https://vk.com/wall-68915392_85594";
		echo "<br>Начало круга -> $i ===> ";
		
		//file_put_contents( "12345.html" , file_get_contents($post_url) ); exit;
		
		### SHD
		$SHD_html = file_get_html( $post_url );
		
		$current_likes = $SHD_html -> find('.item_like')[1] -> attr['aria-label'];
		$current_likes = explode( " " , $current_likes )[0];
		
		$current_views = $SHD_html -> find('.item_views')[0] -> attr['aria-label'];
		$current_views = explode( " " , $current_views )[0];
		
		unset( $SHD_html );
		
		#echo "<pre>"; print_r( $current_likes ); echo "</pre>";
		#echo "<pre>"; print_r( $current_views ); echo "</pre>";
		
		
		
		/*   попытка считать ипреобразовать дату поста.
		if ( $i == 0 )
		{
			$post_date     = $SHD_html -> find('.wi_date')[0] -> innertext;
			
			$post_date_date = explode( " в " , $post_date )[0];
			$post_date_time = explode( " в " , $post_date )[1];
			
			echo "<pre>"; print_r( $post_date_date ); echo "</pre>";
			echo "<pre>"; print_r( $post_date_time ); echo "</pre>";
			
			$date = $post_date_date . " " . $post_date_time;
			echo "<pre>"; print_r( $date ); echo "</pre>";
			
			date_default_timezone_set("+28800");
			$now = new DateTime(); // текущее время на сервере
			$date = DateTime::createFromFormat( "Y-m-d H:i" , $date); // задаем дату в любом формате
			$interval = $now->diff($date); // получаем разницу в виде объекта DateInterval
			
			//echo "<pre>"; print_r( $interval ); echo "</pre>";
		}
		*/
		
		
		
		$post_date = "2020-06-12 14:00";
		$date_now = date("Y-m-d H:i");
		
		$post_date_diff_minutes = date_diff_my($post_date, $date_now, "m");
		//echo "<pre>"; print_r( $post_date_diff_minutes ); echo "</pre>";
		
		
		
		
		
		
		
		
		
		#Пишем в файл и на страницу
		$razdelitel = " ### ";
		
		$final_text = "";
		
		$final_text .= $post_date . $razdelitel;
		$final_text .= $date_now . $razdelitel;
		$final_text .= $post_date_diff_minutes . $razdelitel;
		$final_text .= $current_views . $razdelitel;
		$final_text .= $current_likes;
		
		
		echo $final_text;
		write_in_file( $target_file_name , $final_text );
		
		
		
		
		
		
		# в конце цикла
		$current_rescan_time = refresh_reload_time( $arr_settins , $current_views );
		if ( $current_rescan_time === "stop" ) exit("<br>Выход по лимитам (stop)");
		
		echo " ===> Сплю $current_rescan_time секунд";
	
		sleep($current_rescan_time);
		
	}
	
	exit("123");
	exit("exit");
	
	
	EXIT( ); EXIT( ); EXIT( ); EXIT( ); EXIT( );
	
	
	
	
	
	###############################
	
	
	
	
	
	
	
	
	
	
	
	########################################################
	
	
	
	echo "<hr>Выход за пределы цикла - в файле не стоит END !!!!!";
	
	
	
	echo "<hr>123";
	
	
	
?>