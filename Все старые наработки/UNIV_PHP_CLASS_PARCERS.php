<?php

echo "<br><font size=3 color=MediumVioletRed> Объявлен класс </font> => <font color=blue>PARCER_SHD.</font>";

	//SHDOM   APIST   DIDOM

# Записывать в переменную "UN_PARCER_SHD"


class UNIV_PHP_PARCER_SHD
{
	
	public $Class_Name = "UNIV_PHP_PARCER_SHD";
	
	
	#############################################################
	
	function __construct()
	{
		echo "<br> Создан класс ".$this->Class_Name; 
	}
	
	function __destruct() 
	{	
		echo "<br> Уничтожается класс ".$this->Class_Name ;
	}
	
	#############################################################
	############# Сделать параметр = делать ли unset
	# РАБОТАЕТ
	### БЕЗ забивки лишней памяти
	### return ARRAY с SHD объектами;
	### return "TAG_NOT_FOUND";
	# Выдаст HTML теги в массиве    "<123> куча всего </123>  ,  <123> еще </123>..."
	function DOM__GET_SHD_EXTRACTED_HTML_TAG_FROM_MAIN_SHD( $TAG , $Echo_cnt = true )
	{
		
		#$CNT_TARGET_TAGS_IN_HTML = 0;
		
		########################################################

		$CNT_TARGET_TAGS_IN_HTML = count( $this -> SHD_Current_HTML->find( $TAG ) ); 
		
	
		########################################################

		
		if(  $CNT_TARGET_TAGS_IN_HTML  ) ###Такие теги есть
		{			
				
			####################
			if ( $Echo_cnt )
				if ( $CNT_TARGET_TAGS_IN_HTML > 1)
					echo "<br>GET_EXTRACTED_HTML_TAG: <font color=green>Найдено несколько($CNT_TARGET_TAGS_IN_HTML) таких id - $TAG </font>";
				else
					echo "<br>GET_EXTRACTED_HTML_TAG: <font color=green>ID НАЙДЕН = $TAG </font>";
					
			####################

			$arr_all_target_tags = array();
				


			foreach( $this -> SHD_Current_HTML->find( $TAG ) as $One_target_tag)
			{
				$arr_all_target_tags[] = $One_target_tag;
			}

				#echo "<hr>";
				#echo htmlspecialchars( $One_target_tag->outertext );
				#echo $One_target_tag;
				//exit;
			
			
			return $arr_all_target_tags;
			
			
		}
		else
		{
			if ( $Echo_cnt )
				echo "<br>GET_EXTRACTED_HTML_TAG: <font color=red>ID НЕ НАЙДЕН = $TAG </font> Возвращаю ".$this->CNST_ERR_TEXT_FOR_DB__TAGS__NOT_FOUND;
			
			return $this -> CNST_ERR_TEXT_FOR_DB__TAGS__NOT_FOUND;
		}
		
		
	}
	

	# Уборка лишних тегов(поле бд)
	### Срокее всего работает очень криво
	function PSAF__SHDOM_Cut_First_Lvl_Tags( &$ARR_SHD , &$ARR_White = array())
	{
		
		foreach( $ARR_SHD as &$SHD_one_tag )
			foreach($SHD_one_tag -> children(  ) as &$child_tag)
				if ( ! in_array( $child_tag -> tag  ,  $ARR_White ) )
					$child_tag -> outertext = ''; // outertext
		return;
		
		
		#$ARR_tags_null_lvl = array();
	
		foreach( $ARR_SHD as &$SHD_one_tag )
		{	
			foreach($SHD_one_tag -> children(  ) as &$child_tag) //
			{

				if ( in_array( $child_tag -> tag  ,  $ARR_White ) )
				{
					echo "<br><font color=green>Допустимый вложенный в целевой тег, тег: ".$child_tag -> tag ." в белом листе(Со всеми его потомками)</font>";
				}
				else
				{
					#echo "<br>Было:" , $child_tag -> outertext;
					$child_tag -> outertext = ''; // outertext
					echo "<br><font color=red>Убран вложенный в целевой тег, тег: ".$child_tag -> tag ."</font>";
					#echo "<br>Стало:" , $child_tag -> outertext;
				}	
			}

			#$ARR_tags_null_lvl[] = $SHD_one_tag;
		}
		
		
		#$this -> MIXED_TAGS_BUF = $ARR_tags_null_lvl;
	
	
	
		# То же что и вверху, но коротко
		#foreach( $ARR_SHD as &$SHD_one_tag )
		#	foreach($SHD_one_tag -> children(  ) as &$child_tag)
		//		if ( ! in_array( $child_tag -> tag  ,  $ARR_White ) )
		#			$child_tag -> outertext = ''; // outertext
		
	}
	
	
	

	function PSAF__SHDOM_Get_Text_From_Tags( &$MIX_ARR , &$ATRIBUTE )
	{
		#echo "<br>Заход в " , __FUNCTION__;

		
		
		$ARR_TEXTS = array(); // можно заменить сразу на поле
	
		foreach( $MIX_ARR  as  $One_SHD )
		{
			
			if( is_string($One_SHD) ) // Текст ошибки
			{
				# $ARR_TEXTS[] = $One_SHD;
				continue;
			}
			
			switch( $ATRIBUTE )
			{						### КОММЕНТЫ СПРАВА ПРАВИЛЬНЫЕ!!!!      //Начальная: <div>foo <b>bar</b></div>
				case "OUTERTEXT": $ARR_TEXTS[] = $One_SHD -> outertext; break; //Вернет: <div>foo <b>bar</b></div>
				case "INNERTEXT": $ARR_TEXTS[] = $One_SHD -> innertext; break; //Вернет: foo <b>bar</b>
				case "PLAINTEXT": $ARR_TEXTS[] = $One_SHD -> plaintext; break; //Вернет: foo bar
				case  "TAG" : $ARR_TEXTS[] = $One_SHD -> tag; break; //Вернет: "div"
				case  "ALL" : $ARR_TEXTS[] = $One_SHD; break;
				default: echo "<br>P__Get_Text_From_Tags ДЕФОЛТ = $ATRIBUTE";
			}
			
			### $e->tag         Читает или записывает имя тега элемента.
			### $e->outertext   Читает или записывает весь HTML элемента, включая его самого.
			### $e->innertext   Читает или записывает внутренний HTML элемента
			### $e->plaintext   Читает или записывает простой текст элемента, это эквивалентно функции strip_tags($e->innertext). 
		
			### Если текст тега пуст
			if( end($ARR_TEXTS) === ""  or  end($ARR_TEXTS) === " " ) ### Проверяем последний(текущий) элемент
			{
				array_pop( $ARR_TEXTS );### Вырезаем его
				$ARR_TEXTS[] = $this -> CNST_ERR_TEXT_FOR_DB__TAGS__TAG_EMPTY; ### Сразу пишем замену
				continue; //юзлесс ибо итак конец
			}
		
		
			
		}


		$MIX_ARR = $ARR_TEXTS;
	}

	#############################################################
	
	# Кривоовато, но робит(SHD)
	function P__Print_Current_Tags_Tree( $SHD = null , $msg = null )
	{
	
		if ( $SHD === null ) // на 1 запуске   вход === массив
		{
			#echo "<br>", count($this -> MIXED_TAGS_BUF);
			foreach( $this -> MIXED_TAGS_BUF as $One_SHD ) // массив с SHD
			{
				
				#$msg = "<br>" . $this -> Current_Tag ;
				$msg = "<br># " . $One_SHD -> tag ;
				
				if( $One_SHD -> children() != null )
					echo $msg;
					
					
				$this -> P__Print_Current_Tags_Tree( $One_SHD , $msg );

			}
			
			return;
		}
		
		
		foreach( $SHD -> children() as $One_Child )
		{

			$msg2 = $msg . " ==> " . $One_Child -> tag ;

			echo $msg2;	
			
			$this -> P__Print_Current_Tags_Tree( $One_Child );

		}
		

	}
	
	#############################################################
	
	### УБРАТЬ в трейт парсера SHD
	### Потом дописать более точный поиск по тегу
	function MF__Parce_And_Write_Urls()
	{
	
		$ARR_SHD_a = $this -> DOM__GET_SHD_EXTRACTED_HTML_TAG_FROM_MAIN_SHD( "a" );
		 
		if( ! is_array( $ARR_SHD_a ) ) // ссылок не нашлось
			return;
			

		$protocol_site = $this->GL_siteinfo_site_protocol . $this->GL_TARGET_SITE_NAME ;
		
		#echo "<hr>Ищем: $protocol_site";
		
		$cnt = 0;
		
		foreach( $ARR_SHD_a as $One_Shd_a )
		{
			$href = $One_Shd_a -> href ;
			$text = $One_Shd_a -> plaintext ;
			
			
			if( strpos( $href , $protocol_site ) === false ) ### без ! ибо может(так и делает) вернуть 0 который приведется к false
				continue;
				
			$text = trim( preg_replace( '/ {2,}/'  ,  ' '  , $text ) );
				
			# Простенькая очистка от  ' и "	
			$this -> SF__ERASE_ONE_SUMB( $text , "'" ); // робит
			$this -> SF__ERASE_ONE_SUMB( $text , "\"" );// возможно не робит
			
			
			#echo "<br>Ссылка прошла: <font color=green>$href</font>";
			
			$this -> SF__CONVERT_ENCODING( $text , "Windows-1251" );
			$this -> DBA__WIRTE_ONE_URL_IN_BASE( $href , $text , "" , "" , $this -> Who_Add );
			
			$cnt++;
		}

		echo "<br>Найдно подходящих ссылок: $cnt";
		
	}
	
	
	
	
	
	
	
	
	function MAIN_FOR_SITEMAPS()
	{
		$this -> Who_Add = "SITEMAPS_GRABBER";
		
		
		$ARR_URL_and_LAST = $this->GET_ARR_URLSETSURL_and_LAST( $this->GL_TARGET_SITE_NAME );
		
		echo "<hr color=black>";
		
		
		for (   ;   ; $this->Current_Iteration++ )
		{
		
			echo "<hr color=blue> <hr color=red> <hr color=blue>"; ###Разделитель итераций
		
			$Time_Start_Iteration = microtime(true);
		
		
		
			if ( $this -> MF__Iters_Exit_If_Need() === "BREAK" ) 
				break;
			
			
			
			
			$this -> Current_URL = $ARR_URL_and_LAST['URL'][ $this->Current_Iteration - 1 ];
			$Last =                $ARR_URL_and_LAST['LAST'][$this->Current_Iteration-1] ;
			
			
			$this -> DBS__UPDATE_STATE( "current_iteration" , "$this->Current_Iteration" );
			
			##########
			######################################
			##########
			
			
			
			
			$this -> MF__Check_All_Connections();

			$this -> MF__Refill_Cfg();

			$this -> MF__Check_Command();
			
			if ( $this -> MF__Sleep() === "BREAK" ) 
				break;
			
			$this -> DBS__UPDATE_STATES_FOR_URL(  );
			
			
			if( $this -> MF__Check_HTTP_Response_Code() === "CONTINUE" ) 
				continue; # URL недоступен
			
			$this -> MF__Download_Html_And_Convert_To_SHD();
			if( $this-> SHD_Current_HTML === "DOWNLOAD_ERROR" )	
				continue;
			
			
			
			
			$this -> PERCE_CONTENT( $this->Current_URL , $Last );
		
			
			
			
			#$this -> MF__Parce_Final_Data(); ### Внутри свитч по парсерам
			
			#
			#$this -> MF__WRITE_FINAL_DATA_IN_BASE();
			
			
			
		
			##########
			######################################
			##########

			######
			
			

			
			
			echo "<br>###MAIN_FOR_C: Конец итерации номер: $this->Current_Iteration  из  $this->GL_Max_Iters_Cnt";
			
			$Time_End_Iteration = microtime(true) - $Time_Start_Iteration - $this->Current_Sleep_Time;
			echo "<br>###MAIN_FOR_C: Итерация заняла(без сна): $Time_End_Iteration Секунд";
		
		
		
		
		
		}# END Main for
		
		
		

	}


	
	
	function PERCE_CONTENT( $URL , $LAST )
	{
		$this -> UPDATE_SITEMAP_INFO( $URL , "urlset_state" , "'CHECKING'" ); ### 
		
		
		echo "<hr>LAST: '$LAST'";
	
		$ARR_SHD_ALL_SETS     = $this -> DOM__Get_Tags_Parser_Switch( "urlset url" );
		
		echo "<hr>Найдено сетов: ".count( $ARR_SHD_ALL_SETS );
		
		
		$ARR_STR_ALL_URL = array();
		
		$this -> UPDATE_SITEMAP_INFO( $URL , "sets_count" , count( $ARR_SHD_ALL_SETS ) ); ### 
		

		for( $i=0 ; $i < count( $ARR_SHD_ALL_SETS ) ; $i++ )
		{
			if( $i < $LAST ) ### Условие верное
				continue;
			
			echo " = $i";
			
			$STR_URL      = @$ARR_SHD_ALL_SETS[$i] -> find( 'loc' )[0] -> innertext;
			$STR_LASTMOD  = @$ARR_SHD_ALL_SETS[$i] -> find( 'lastmod' )[0] -> innertext;
			$STR_PRIORITY = @$ARR_SHD_ALL_SETS[$i] -> find( 'priority' )[0] -> innertext;
			

			$this -> DBA__WIRTE_ONE_URL_IN_BASE( @$STR_URL , "" , @$STR_LASTMOD , @$STR_PRIORITY , $this->Who_Add );
			
			$this -> UPDATE_SITEMAP_INFO( $URL , "last_checked_index" , $i ); ###
			
			$this -> MF__Refill_Cfg();
			$this -> MF__Check_Command();
			
			
		}
		
		echo "<hr color=red>";
	
	
		
		$this -> UPDATE_SITEMAP_INFO( $URL , "urlset_state" , "'CHECKED'" ); ### 
		$this -> UPDATE_SITEMAP_INFO( $URL , "datetime_last_scan" , "now()" ); ### 

		echo "<br>В бд ушло $cnt ссылок(возможны дубли)";
	
	
	}
	
	
	
	#############################################################
	
	
	#############################################################
	
	
	#############################################################
	
	
	
	#############################################################
	
	
	#############################################################
	
	#$e->children ( [int $index] )	Возвращает N-ый объект потомка, если установлен index, иначе возвращает массив элементов.
	#$e->parent ()	Возваращает родительский элемент.
	#$e->first_child ()	Возвращает элемент первого потомка, или null, если элемент не будет найден.
	#$e->last_child ()	Возвращает элемент последнего потомка, или null, если элемент не будет найден.
	#$e->next_sibling ()	Возвращает следующий соседний элемент, или null, если не будет такой найден.
	#$e->prev_sibling ()	Возвращает предыдущий соседний элемент, или null, если не бидет такой найден.
	
	// Найти ссылки и возвратить массив найденных объектов
	#$ret = $html->find('a');
	// Найти (N)-ую по счету ссылку и возвратить найденный объект или null в случае, если объект не найден
	#$ret = $html->find('a', 0);
	// Найти все элементы <div>, у которых id=foo
	#$ret = $html->find('div[id=foo]'); 
	// Найти все элементы <div>, имеющие атрибут id
	#$ret = $html->find('div[id]');
	// Найти все элементы, имеющие атрибут id
	#$ret = $html->find('[id]');
	
	#############################################################
	
	
	
}#END CLASS

		
		
?>