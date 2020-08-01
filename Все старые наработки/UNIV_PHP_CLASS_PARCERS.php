<?php

echo "<br><font size=3 color=MediumVioletRed> �������� ����� </font> => <font color=blue>PARCER_SHD.</font>";

	//SHDOM   APIST   DIDOM

# ���������� � ���������� "UN_PARCER_SHD"


class UNIV_PHP_PARCER_SHD
{
	
	public $Class_Name = "UNIV_PHP_PARCER_SHD";
	
	
	#############################################################
	
	function __construct()
	{
		echo "<br> ������ ����� ".$this->Class_Name; 
	}
	
	function __destruct() 
	{	
		echo "<br> ������������ ����� ".$this->Class_Name ;
	}
	
	#############################################################
	############# ������� �������� = ������ �� unset
	# ��������
	### ��� ������� ������ ������
	### return ARRAY � SHD ���������;
	### return "TAG_NOT_FOUND";
	# ������ HTML ���� � �������    "<123> ���� ����� </123>  ,  <123> ��� </123>..."
	function DOM__GET_SHD_EXTRACTED_HTML_TAG_FROM_MAIN_SHD( $TAG , $Echo_cnt = true )
	{
		
		#$CNT_TARGET_TAGS_IN_HTML = 0;
		
		########################################################

		$CNT_TARGET_TAGS_IN_HTML = count( $this -> SHD_Current_HTML->find( $TAG ) ); 
		
	
		########################################################

		
		if(  $CNT_TARGET_TAGS_IN_HTML  ) ###����� ���� ����
		{			
				
			####################
			if ( $Echo_cnt )
				if ( $CNT_TARGET_TAGS_IN_HTML > 1)
					echo "<br>GET_EXTRACTED_HTML_TAG: <font color=green>������� ���������($CNT_TARGET_TAGS_IN_HTML) ����� id - $TAG </font>";
				else
					echo "<br>GET_EXTRACTED_HTML_TAG: <font color=green>ID ������ = $TAG </font>";
					
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
				echo "<br>GET_EXTRACTED_HTML_TAG: <font color=red>ID �� ������ = $TAG </font> ��������� ".$this->CNST_ERR_TEXT_FOR_DB__TAGS__NOT_FOUND;
			
			return $this -> CNST_ERR_TEXT_FOR_DB__TAGS__NOT_FOUND;
		}
		
		
	}
	

	# ������ ������ �����(���� ��)
	### ������ ����� �������� ����� �����
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
					echo "<br><font color=green>���������� ��������� � ������� ���, ���: ".$child_tag -> tag ." � ����� �����(�� ����� ��� ���������)</font>";
				}
				else
				{
					#echo "<br>����:" , $child_tag -> outertext;
					$child_tag -> outertext = ''; // outertext
					echo "<br><font color=red>����� ��������� � ������� ���, ���: ".$child_tag -> tag ."</font>";
					#echo "<br>�����:" , $child_tag -> outertext;
				}	
			}

			#$ARR_tags_null_lvl[] = $SHD_one_tag;
		}
		
		
		#$this -> MIXED_TAGS_BUF = $ARR_tags_null_lvl;
	
	
	
		# �� �� ��� � ������, �� �������
		#foreach( $ARR_SHD as &$SHD_one_tag )
		#	foreach($SHD_one_tag -> children(  ) as &$child_tag)
		//		if ( ! in_array( $child_tag -> tag  ,  $ARR_White ) )
		#			$child_tag -> outertext = ''; // outertext
		
	}
	
	
	

	function PSAF__SHDOM_Get_Text_From_Tags( &$MIX_ARR , &$ATRIBUTE )
	{
		#echo "<br>����� � " , __FUNCTION__;

		
		
		$ARR_TEXTS = array(); // ����� �������� ����� �� ����
	
		foreach( $MIX_ARR  as  $One_SHD )
		{
			
			if( is_string($One_SHD) ) // ����� ������
			{
				# $ARR_TEXTS[] = $One_SHD;
				continue;
			}
			
			switch( $ATRIBUTE )
			{						### �������� ������ ����������!!!!      //���������: <div>foo <b>bar</b></div>
				case "OUTERTEXT": $ARR_TEXTS[] = $One_SHD -> outertext; break; //������: <div>foo <b>bar</b></div>
				case "INNERTEXT": $ARR_TEXTS[] = $One_SHD -> innertext; break; //������: foo <b>bar</b>
				case "PLAINTEXT": $ARR_TEXTS[] = $One_SHD -> plaintext; break; //������: foo bar
				case  "TAG" : $ARR_TEXTS[] = $One_SHD -> tag; break; //������: "div"
				case  "ALL" : $ARR_TEXTS[] = $One_SHD; break;
				default: echo "<br>P__Get_Text_From_Tags ������ = $ATRIBUTE";
			}
			
			### $e->tag         ������ ��� ���������� ��� ���� ��������.
			### $e->outertext   ������ ��� ���������� ���� HTML ��������, ������� ��� ������.
			### $e->innertext   ������ ��� ���������� ���������� HTML ��������
			### $e->plaintext   ������ ��� ���������� ������� ����� ��������, ��� ������������ ������� strip_tags($e->innertext). 
		
			### ���� ����� ���� ����
			if( end($ARR_TEXTS) === ""  or  end($ARR_TEXTS) === " " ) ### ��������� ���������(�������) �������
			{
				array_pop( $ARR_TEXTS );### �������� ���
				$ARR_TEXTS[] = $this -> CNST_ERR_TEXT_FOR_DB__TAGS__TAG_EMPTY; ### ����� ����� ������
				continue; //������ ��� ���� �����
			}
		
		
			
		}


		$MIX_ARR = $ARR_TEXTS;
	}

	#############################################################
	
	# ����������, �� �����(SHD)
	function P__Print_Current_Tags_Tree( $SHD = null , $msg = null )
	{
	
		if ( $SHD === null ) // �� 1 �������   ���� === ������
		{
			#echo "<br>", count($this -> MIXED_TAGS_BUF);
			foreach( $this -> MIXED_TAGS_BUF as $One_SHD ) // ������ � SHD
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
	
	### ������ � ����� ������� SHD
	### ����� �������� ����� ������ ����� �� ����
	function MF__Parce_And_Write_Urls()
	{
	
		$ARR_SHD_a = $this -> DOM__GET_SHD_EXTRACTED_HTML_TAG_FROM_MAIN_SHD( "a" );
		 
		if( ! is_array( $ARR_SHD_a ) ) // ������ �� �������
			return;
			

		$protocol_site = $this->GL_siteinfo_site_protocol . $this->GL_TARGET_SITE_NAME ;
		
		#echo "<hr>����: $protocol_site";
		
		$cnt = 0;
		
		foreach( $ARR_SHD_a as $One_Shd_a )
		{
			$href = $One_Shd_a -> href ;
			$text = $One_Shd_a -> plaintext ;
			
			
			if( strpos( $href , $protocol_site ) === false ) ### ��� ! ��� �����(��� � ������) ������� 0 ������� ���������� � false
				continue;
				
			$text = trim( preg_replace( '/ {2,}/'  ,  ' '  , $text ) );
				
			# ����������� ������� ��  ' � "	
			$this -> SF__ERASE_ONE_SUMB( $text , "'" ); // �����
			$this -> SF__ERASE_ONE_SUMB( $text , "\"" );// �������� �� �����
			
			
			#echo "<br>������ ������: <font color=green>$href</font>";
			
			$this -> SF__CONVERT_ENCODING( $text , "Windows-1251" );
			$this -> DBA__WIRTE_ONE_URL_IN_BASE( $href , $text , "" , "" , $this -> Who_Add );
			
			$cnt++;
		}

		echo "<br>������ ���������� ������: $cnt";
		
	}
	
	
	
	
	
	
	
	
	function MAIN_FOR_SITEMAPS()
	{
		$this -> Who_Add = "SITEMAPS_GRABBER";
		
		
		$ARR_URL_and_LAST = $this->GET_ARR_URLSETSURL_and_LAST( $this->GL_TARGET_SITE_NAME );
		
		echo "<hr color=black>";
		
		
		for (   ;   ; $this->Current_Iteration++ )
		{
		
			echo "<hr color=blue> <hr color=red> <hr color=blue>"; ###����������� ��������
		
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
				continue; # URL ����������
			
			$this -> MF__Download_Html_And_Convert_To_SHD();
			if( $this-> SHD_Current_HTML === "DOWNLOAD_ERROR" )	
				continue;
			
			
			
			
			$this -> PERCE_CONTENT( $this->Current_URL , $Last );
		
			
			
			
			#$this -> MF__Parce_Final_Data(); ### ������ ����� �� ��������
			
			#
			#$this -> MF__WRITE_FINAL_DATA_IN_BASE();
			
			
			
		
			##########
			######################################
			##########

			######
			
			

			
			
			echo "<br>###MAIN_FOR_C: ����� �������� �����: $this->Current_Iteration  ��  $this->GL_Max_Iters_Cnt";
			
			$Time_End_Iteration = microtime(true) - $Time_Start_Iteration - $this->Current_Sleep_Time;
			echo "<br>###MAIN_FOR_C: �������� ������(��� ���): $Time_End_Iteration ������";
		
		
		
		
		
		}# END Main for
		
		
		

	}


	
	
	function PERCE_CONTENT( $URL , $LAST )
	{
		$this -> UPDATE_SITEMAP_INFO( $URL , "urlset_state" , "'CHECKING'" ); ### 
		
		
		echo "<hr>LAST: '$LAST'";
	
		$ARR_SHD_ALL_SETS     = $this -> DOM__Get_Tags_Parser_Switch( "urlset url" );
		
		echo "<hr>������� �����: ".count( $ARR_SHD_ALL_SETS );
		
		
		$ARR_STR_ALL_URL = array();
		
		$this -> UPDATE_SITEMAP_INFO( $URL , "sets_count" , count( $ARR_SHD_ALL_SETS ) ); ### 
		

		for( $i=0 ; $i < count( $ARR_SHD_ALL_SETS ) ; $i++ )
		{
			if( $i < $LAST ) ### ������� ������
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

		echo "<br>� �� ���� $cnt ������(�������� �����)";
	
	
	}
	
	
	
	#############################################################
	
	
	#############################################################
	
	
	#############################################################
	
	
	
	#############################################################
	
	
	#############################################################
	
	#$e->children ( [int $index] )	���������� N-�� ������ �������, ���� ���������� index, ����� ���������� ������ ���������.
	#$e->parent ()	����������� ������������ �������.
	#$e->first_child ()	���������� ������� ������� �������, ��� null, ���� ������� �� ����� ������.
	#$e->last_child ()	���������� ������� ���������� �������, ��� null, ���� ������� �� ����� ������.
	#$e->next_sibling ()	���������� ��������� �������� �������, ��� null, ���� �� ����� ����� ������.
	#$e->prev_sibling ()	���������� ���������� �������� �������, ��� null, ���� �� ����� ����� ������.
	
	// ����� ������ � ���������� ������ ��������� ��������
	#$ret = $html->find('a');
	// ����� (N)-�� �� ����� ������ � ���������� ��������� ������ ��� null � ������, ���� ������ �� ������
	#$ret = $html->find('a', 0);
	// ����� ��� �������� <div>, � ������� id=foo
	#$ret = $html->find('div[id=foo]'); 
	// ����� ��� �������� <div>, ������� ������� id
	#$ret = $html->find('div[id]');
	// ����� ��� ��������, ������� ������� id
	#$ret = $html->find('[id]');
	
	#############################################################
	
	
	
}#END CLASS

		
		
?>