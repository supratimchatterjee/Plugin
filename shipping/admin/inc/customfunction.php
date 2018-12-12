<?php 

/** This function is used to show individual data in mail process page **/


if(!function_exists('show_mail_process_data')){
	function show_mail_process_data(){
	global $wpdb;
	
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		
	/*** get all record from mail_creation table where tagged = 0 .***/
	
		$result = $wpdb->get_results(
						"SELECT * FROM  ".$table_mail_creation." where is_tagged=0"
					);
		return $result;
	}
}
/** End **/


/** This Function is used to get created mail user name and date  **/


if(!function_exists('createdUserMail')){
	/** in Function passing 2 parameter  1st is Tracking No. and 2nd is mail Type Batch or Individual **/
	function createdUserMail($tracking_code ,$type ){
	global $wpdb;
	
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		if($type=='Batch'){
			/****that quy find mail creation  user name and created date in batch case ***/
			$qry="SELECT created_by , created_on FROM ".$table_batch_creation." WHERE batch_name='".$tracking_code."' or batch_id='".$tracking_code."'";
			
		}
		
		if($type=='Individual'){
			/****that quy find mail creation  user name and created date in individual case ***/
			$qry="SELECT created_by , created_on FROM ".$table_mail_creation." WHERE tracking_number ='".$tracking_code."'";
			
		}
		
		
		$result = $wpdb->get_row(
						$qry
					);
					
		return $result;
	}
}

/** End**/


/**This function to used mail type count in Mail Summary Count section **/

if(!function_exists('mail_summary_count')){
	
	/** in Function passing 2 parameter  1st is countType (registered ,Parcel, Ordinary Mail, EMS, Express)  and 2nd is time (week, month or day)  **/
	function mail_summary_count($countType, $time=""){
	global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$count_type=$countType;
		$roleCondition='';
		//AND created_by='1'
		
		$userCurr = wp_get_current_user();
		if ( in_array( 'client', (array) $userCurr->roles ) ) {
		//The user has the "client" role
		$roleCondition='AND created_by='.$userCurr->ID;
		//
		}




		/** That query is Find count registered mail according to time from mail_creation table **/
		
		
		//$sql= "SELECT COUNT(*) as registerd_mail_count FROM ".$table_name." WHERE mail_type='".$count_type."'".$roleCondition;
		$sql= "SELECT COUNT(b.mail_type) as mailCount FROM  ".$table_mail_tagging." a INNER JOIN ".$table_mail_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Individual' AND b.mail_type='".$count_type."' ".$roleCondition;
		
	
		if($time!=""){
			
			if($time=='week'){
				$sql .= ' and created_on >= (CURDATE() + INTERVAL -7 DAY)';
			}
			if($time=='month'){
				$sql .= ' and created_on >= (CURDATE() + INTERVAL -30 DAY)';
			}
			if($time=='today'){
				$sql .= ' and created_on >= (CURDATE() + INTERVAL - 0 DAY)';
			}
		}
		//echo $sql;
		$result = $wpdb->get_results( $sql );
		
		//$resultCount=$result[0]->registerd_mail_count;
		$result[0]->mailCount;
		
		//return $resultCount;
		

   /** Batch Query **/
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		//$sqlBatch= "SELECT COUNT(*) as registerd_mail_count FROM ".$table_name2." WHERE mail_type='".$count_type."'".$roleCondition;
		$sqlBatch= "SELECT COUNT(b.mail_type) as mailCount FROM  ".$table_mail_tagging." a INNER JOIN ".$table_batch_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Batch' AND b.mail_type='".$count_type."' ".$roleCondition;
		//echo $sqlBatch;
		if($time!=""){
			
			if($time=='week'){
				$sqlBatch .= ' and created_on >= (CURDATE() + INTERVAL -7 DAY)';
			}
			if($time=='month'){
				$sqlBatch .= ' and created_on >= (CURDATE() + INTERVAL -30 DAY)';
			}
			if($time=='today'){
				$sqlBatch .= ' and created_on >= (CURDATE() + INTERVAL - 0 DAY)';
			}
		}
		
		
		//echo $sqlBatch."<br>".$sql;
		$resultBatch = $wpdb->get_results( $sqlBatch );
		//$result[0]->mailCount;
		
		
		$resultCount= $result[0]->mailCount+$resultBatch[0]->mailCount;
		
		//echo '<pre>';
		//print_r($resultCount);
		
		
		
		return $resultCount;



		
	}
}


/** End **/



/** This function is used to count country group by in mail Destination section**/

if(!function_exists('country_group_by')){
	
		/** in Function passing  parameter is time (week, month or day)  **/
	function country_group_by($time=""){
	    global $wpdb;
	  
	    $table_mail_creation = $wpdb->prefix . "mail_creation";
	    $table_shipping_country = $wpdb->prefix . "shipping_country";
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		
		/*this  condition  for fiter data on client*/
		$roleCondition='';
		//AND created_by='1'
		$resultArr=array();
		
		$userCurr = wp_get_current_user();
		if ( in_array( 'client', (array) $userCurr->roles ) ) {
		//The user has the "client" role
		$roleCondition='AND b.created_by='.$userCurr->ID;
		//
		}
		
		
		$sqlCountryGroup="SELECT b.country as country_code , count(b.country) as countryCount ,(select country_name from ".$table_shipping_country." where country_code = b.country  ) as country_name FROM ".$table_mail_tagging." a INNER JOIN ".$table_mail_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Individual' ".$roleCondition;
		
	
	
	if($time!==""){
			if($time == 'week'){
				
				
				/** in this query  find  the country Count and  country name  **/
				$resultIndividual = $wpdb->get_results(
						$sqlCountryGroup .= ' and created_on >= (CURDATE() + INTERVAL -7 DAY) '
								);
				
			}
			if($time == 'month'){
				
				$resultIndividual = $wpdb->get_results(
						$sqlCountryGroup .= ' and created_on >= (CURDATE() + INTERVAL -30 DAY)'
								);
				
			}
			
			  if($time == 'today'){
				
				$resultIndividual = $wpdb->get_results(
						$sqlCountryGroup .= ' and created_on >= (CURDATE() + INTERVAL -0 DAY)'
								);
				
			}  
			
		}
		
			
			$resultIndividual = $wpdb->get_results( $sqlCountryGroup.=" group by b.country" );
			
			
			
	      
	    //echo $sqlCountryGroup;
		
		/** Batch Query **/
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		
		$sqlCountryGroupBatch="SELECT b.country as country_code , count(b.country) as countryCount, (select country_name from ".$table_shipping_country." where country_code = b.country  ) as country_name FROM ".$table_mail_tagging." a INNER JOIN ".$table_batch_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Batch' ".$roleCondition;
		
		if($time!==""){
			if($time == 'week'){
				
				
				/** in this query  find  the country Count and  country name  **/
				$resultBatch = $wpdb->get_results(
						$sqlCountryGroupBatch .= ' and created_on >= (CURDATE() + INTERVAL -7 DAY) '
								);
				
			}
			if($time == 'month'){
				
				$resultBatch = $wpdb->get_results(
						$sqlCountryGroupBatch .= ' and created_on >= (CURDATE() + INTERVAL -30 DAY)'
								);
				
			}
			
			  if($time == 'today'){
				
				$resultBatch = $wpdb->get_results(
						$sqlCountryGroupBatch .= ' and created_on >= (CURDATE() + INTERVAL -0 DAY)'
								);
				
			}  
			
		}
			
		$resultBatch = $wpdb->get_results( $sqlCountryGroupBatch.=" group by b.country" );

		//echo $sqlCountryGroupBatch ."<br>".$sqlCountryGroup;
		

		
		if(!empty($resultIndividual)){
			$counter =  0;
			foreach($resultIndividual as $resultIndividualSingle){
				$resultArr[$counter]['count'] = $resultIndividualSingle->countryCount ;
				$resultArr[$counter]['country_code'] = $resultIndividualSingle->country_code ;
				$resultArr[$counter]['country_name'] = $resultIndividualSingle->country_name ;
				$counter++;
			}
		}

		if(!empty($resultBatch)){
			$counter =  count($resultArr);
			foreach($resultBatch as $resultBatchSingle){
				$resultArr[$counter]['count'] = $resultBatchSingle->countryCount ;
				$resultArr[$counter]['country_code'] = $resultBatchSingle->country_code ;
				$resultArr[$counter]['country_name'] = $resultBatchSingle->country_name ;
				$counter++;
			}
		}
		
		$returnResult = array();
		if(!empty($resultArr)){
			foreach($resultArr as $resultArrSing){
				if(array_key_exists($resultArrSing['country_name'],$returnResult)){
					$returnResult[$resultArrSing['country_name']] = $returnResult[$resultArrSing['country_name']] + $resultArrSing['count'];
				}else{
					$returnResult[$resultArrSing['country_name']] = $resultArrSing['count'];
				}
				
			}
		}
		
		
		return $returnResult;

	}
}

/** End **/


/** This Function is used to get all users **/


if(!function_exists('trackingInfo_Details')){
	function trackingInfo_Details(){
		global $wpdb;
		$table_name = $wpdb->prefix . "users";
		
		$result = $wpdb->get_results(
						"SELECT display_name FROM ".$table_name
					);
		
		
		return $result;
		
	
	}
}

/** End **/


/* if(!function_exists('transactionsInfo_Details')){
	function transactionsInfo_Details(){
		global $wpdb;
		$table_name = $wpdb->prefix . "mail_tagging";
		
		$result = $wpdb->get_results(
						"SELECT * FROM ".$table_name
					);
		
		
		return $result;
		
	
	
	}
} */




/**************************************************************************************************/


if(!function_exists('transactionsBatchInfo_Details')){
	function transactionsBatchInfo_Details(){
		global $wpdb;
		$table_name1 = $wpdb->prefix . "batch_creation";
		$table_name2 = $wpdb->prefix . "batch_summary";
		
	
					
					$result = $wpdb->get_results(
						"SELECT COUNT(DISTINCT(country)) as countryCount ,b.* FROM ".$table_name1." a INNER JOIN ".$table_name2." b ON a.batch_id = b.batch_id WHERE b.is_tagged='1' GROUP BY b.batch_name"
					);
					
		
		
		return $result;
		
	
	
	}
}

if(!function_exists('transactionsBatchInfo_DetailsForCLient')){
	function transactionsBatchInfo_DetailsForCLient(){
		$userId = get_current_user_id();
		global $wpdb;
		$table_name1 = $wpdb->prefix . "batch_creation";
		$table_name2 = $wpdb->prefix . "batch_summary";
		
	
					
					$result = $wpdb->get_results(
						"SELECT COUNT(DISTINCT(country)) as countryCount ,b.* FROM ".$table_name1." a INNER JOIN ".$table_name2." b ON a.batch_id = b.batch_id WHERE b.is_tagged='1' and a.created_by=".$userId."   GROUP BY b.batch_name"
					);
					
		
		
		return $result;
		
	
	
	}
}



/**************************************************************************************************/




if(!function_exists('transactionsIndividualInfo_Details')){
	function transactionsIndividualInfo_Details(){
		global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		//$table_name2 = $wpdb->prefix . "batch_summary";
		
		/* $result = $wpdb->get_results(
						"SELECT * FROM ".$table_name
					); */
					
					$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_creation." WHERE is_tagged='1'"
					);
		
		
		return $result;
		
	
	
	}
}

/*
Get single mail for client 
*/

if(!function_exists('transactionsIndividualInfo_DetailstClient')){
	function transactionsIndividualInfo_DetailstClient(){
	$userId = get_current_user_id();
		global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		//$table_name2 = $wpdb->prefix . "batch_summary";
		//$menuname="Reports";
		$user = wp_get_current_user();
		
		$role = ( array ) $user->roles;
		if($role[0]=="client"){
			//$menuname="Transactions";
			$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_creation." WHERE is_tagged='1' and created_by='".$userId."'"
					);
		} else {
		
			$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_creation." WHERE is_tagged='1'"
					);
		}
		/* $result = $wpdb->get_results(
						"SELECT * FROM ".$table_name
					); */
					
					
		
		
		return $result;
		
	
	
	}
}


if(!function_exists('showCreateDate_batch_individual')){
	function showCreateDate_batch_individual($type,$tracking_code){
		global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_batch_summary = $wpdb->prefix . "batch_summary";
		if($type == 'Batch'){
			
			$result = $wpdb->get_results(
						"SELECT * FROM ".$table_batch_summary
					);
		
		
		
		//echo "<pre>";
		//print_r($result[0]->date_create);
		//die('test batch');
		$result = $result[0]->date_create;
		
		return $result;
			
			
		}
		if($type == 'Individual'){
			
			$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_creation." WHERE tracking_number='".$tracking_code."'"
					);
				//echo "SELECT * FROM ".$table_mail_creation." WHERE tracking_number='".$tracking_code."'";
		// print_r($result);
		$result = $result[0]->created_on;
		return $result;
			
		}
	}
}

/* if(!function_exists('update_Batch_individual_detail')){
	function update_Batch_individual_detail($type,$tracking_code){
		global $wpdb;
		$table_mail_tackinginfo = $wpdb->prefix . "mail_tackinginfo";
		//$table_batch_summary = $wpdb->prefix . "batch_summary";
		if($type == 'Batch'){
			
			$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='".$tracking_code."'"
					);
					
			if(!empty($result)){
				
				 $wpdb->update(
							$table_name, 
							array( 
								'delight_title' => $delightvalue,
								'updated_date' => current_time('mysql', 1)
							), 
							array(
								"level_id" => $levelId,
								"user_id" => $userid
								
							) 
						);
				
			}else{
				
				return $result;
				
			}
		
		
		//echo "<pre>";
		//print_r($result[0]->date_create);
		//die('test batch');
		return $result;
			
		}
		if($type == 'Individual'){
			
		$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_tackinginfo
					);
					
		return $result;
			
		}
	}
}
 */









 
if(!function_exists('show_tracking_details')){
	function show_tracking_details($tracking_code,$type){
		global $wpdb;
		  
		$table_mail_tackinginfo = $wpdb->prefix . "mail_tackinginfo";
		$table_batch_summary = $wpdb->prefix . "batch_summary";
		
		 if($type == 'Individual'){
			
			$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='".$tracking_code."' AND type='".$type."'");
						
						}
		 if($type == 'Batch'){
			 
			 $result = $wpdb->get_results(
						"SELECT a.* , b.*  FROM  ".$table_batch_summary." a INNER JOIN ".$table_mail_tackinginfo." b ON a.batch_id = b.tracking_id WHERE a.batch_name='".$tracking_code."'");
				
			 
			// SELECT a.* , b.*  FROM  wpn1_batch_summary a INNER JOIN wpn1_mail_tackinginfo b ON a.batch_id = b.tracking_id
		 }
		 
		/* echo "SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='".$tracking_code."' AND type='".$type;
		$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='".$tracking_code."' AND type='".$type."'"); */
						//echo"SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='1533625463' AND type='".$ba;
		//echo "<pre>";
		//print_r($result);
		//die('test');
		return $result;
	    
		
	}
}


if(!function_exists('showMailBatchInfoDetails')){
	function showMailBatchInfoDetails($tracking_code,$type){
		global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_batch_summary = $wpdb->prefix . "batch_summary";
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		
		if($type == 'Batch'){
			
			/*  $result = $wpdb->get_results(
						"SELECT * FROM ".$table_batch_summary." WHERE batch_id='".$tracking_code."'"
					); */


				 $result = $wpdb->get_results(
						" SELECT a.* , b.* FROM  ".$table_batch_summary." a INNER JOIN ".$table_mail_tagging." b ON a.batch_id = b.batch_id WHERE a.batch_id='".$tracking_code."' GROUP BY a.batch_id"
					 ); 
				//echo 'SELECT a.* , b.* FROM  ".$table_batch_summary." a INNER JOIN ".$table_mail_tagging." b ON a.batch_id = b.batch_id GROUP BY a.batch_id"';
		//echo'<pre>';
	 //print_r($result);
		return $result;
			
			
		}
		if($type == 'Individual'){
				
			$result = $wpdb->get_results(
						"SELECT a.* , b.* FROM ".$table_mail_creation." a INNER JOIN ".$table_mail_tagging." b ON a.tracking_number = b.tracking_id"
					);
			
				//die('test individual details');
		 
		return $result;
			
		}
	}
}

if(!function_exists('showMailBatchInfo_teg_Details')){
	function showMailBatchInfo_teg_Details($tracking_code,$type){
		global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_batch_summary = $wpdb->prefix . "batch_summary";
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		
		
		if($type == 'Batch'){
			
			
			 $result = $wpdb->get_results(
						" SELECT a.* , b.* FROM  ".$table_batch_summary." a INNER JOIN ".$table_mail_tagging." b ON a.batch_id = b.batch_id WHERE a.batch_id='".$tracking_code."'"
					 );
//echo'SELECT a.* , b.* FROM  ".$table_batch_summary." a INNER JOIN ".$table_mail_tagging." b ON a.batch_id = b.batch_id ';
					 
			
				//die('test individual details');
		return $result;
			
		}
	}
}

if(!function_exists('showMailBatchInfo_Countries_Details')){
	function showMailBatchInfo_Countries_Details($tracking_code,$type){
		global $wpdb;
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		
		
		if($type == 'Batch'){
			
			/* $result = $wpdb->get_results(
						" SELECT country FROM ".$table_batch_creation." GROUP BY country "
					 ); 
				*/	
				 $result = $wpdb->get_results(
						" SELECT COUNT(mail_type) as TotalMailCount,  country , SUM(weight_kg) as TotalWeightSum FROM ".$table_batch_creation."  WHERE batch_id='".$tracking_code."' GROUP BY country "
					 ); 

//echo "<pre>";
//print_r($result);
				
					// echo'SELECT country FROM  wpn1_batch_creation GROUP BY country ';
					 
			
				//die('test individual details');
		return $result;
			
		}
	}
}

if(!function_exists('show_upload_invoice_Details')){
	function show_upload_invoice_Details(){
		global $wpdb;
		$table_upload_invoice = $wpdb->prefix . "upload_invoice";
		
		 $result = $wpdb->get_results(
						" SELECT * FROM ".$table_upload_invoice
					 ); 
		//echo "SELECT * FROM ".$table_upload_invoice;
		return $result;

	}
}

if(!function_exists('show_activity')){
	function show_activity(){
		global $wpdb;
		
		
		$table_shipping_activity = $wpdb->prefix . "shipping_activity";
		//SELECT * FROM `wpn1_shipping_activity` ORDER BY activity DESC LIMIT 4 
		 $result = $wpdb->get_results(
						" SELECT * FROM ".$table_shipping_activity." ORDER BY id DESC limit 4"
					 ); 
		//echo "SELECT * FROM ".$table_upload_invoice;
		return $result;

	}
}

if(!function_exists('show_GoodBed_Tag')){
	function show_GoodBed_Tag($tag , $time=""){
		global $wpdb;
		
		
		$roleCondition='';
		$userCurr = wp_get_current_user();
		if ( in_array( 'client', (array) $userCurr->roles ) ) {
		//The user has the "client" role
		$roleCondition='AND b.created_by='.$userCurr->ID;
		
		}
		
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		 
		// echo "SELECT COUNT(tag) as TagCount FROM ".$table_mail_tagging." WHERE tag='".$tag."";
		
		$qryIndividual=" SELECT COUNT(tag) as TagCount FROM ".$table_mail_tagging." a INNER JOIN ".$table_mail_creation." b ON b.tracking_number = a.tracking_id  WHERE a.tag ='".$tag."'".$roleCondition;
		
		
			 
			if($time!==""){
			
			
			if($time == 'today' ){
				$qryIndividual .= 
						" AND a.created_date >= (CURDATE() + INTERVAL - 0 DAY)";
					 
			}
			if($time == 'week'){
				$qryIndividual .= 
						" AND a.created_date >= (CURDATE() + INTERVAL - 7 DAY)";
					 
			}
			if($time == 'month'){
				
				$qryIndividual .=
						" AND a.created_date >= (CURDATE() + INTERVAL - 30 DAY)";
					
			}
			
		}
		
		$resultIndividual = $wpdb->get_results( $qryIndividual);
		
		/*Batch Query*/
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		
		
		$qryBatch=" SELECT COUNT(tag) as TagCount FROM ".$table_mail_tagging." a INNER JOIN ".$table_batch_creation." b ON b.tracking_number = a.tracking_id  WHERE a.tag ='".$tag."'".$roleCondition;
		if($tag=="bad"){
			$qryBatch=" SELECT COUNT(tag) as TagCount FROM ".$table_mail_tagging." a INNER JOIN ".$table_batch_creation." b ON b.tracking_number = a.tracking_id  WHERE (a.tag !='good' and a.tag !='') ".$roleCondition;
		}
		
			 
			if($time!==""){
			
			
			if($time == 'today' ){
				$qryBatch .=
						" AND a.created_date >= (CURDATE() + INTERVAL - 0 DAY)";
					 
			}
			if($time == 'week'){
				$qryBatch .= 
						" AND a.created_date >= (CURDATE() + INTERVAL - 7 DAY)";
					 
			}
			if($time == 'month'){
				
				$qryBatch .=
						" AND a.created_date >= (CURDATE() + INTERVAL - 30 DAY)";
					 
			}
			
		}
		$resultBatch = $wpdb->get_results($qryBatch);
		
		
		
		
		
		  //echo $qryIndividual. '<br>'. $qryBatch;
		  
		 // echo '<pre>';
		  
		 // print_r($resultBatch);
		 // print_r($resultIndividual);
		  
		  $result =$resultBatch[0]->TagCount + $resultIndividual[0]->TagCount;
		  
		 // print_r($result);
		  
		//echo "SELECT * FROM ".$table_upload_invoice;
		return $result;
        
	}
}

if(!function_exists('show_batch_totalAmount')){
	function show_batch_totalAmount($time=""){
		global $wpdb;
		$table_batch_summary = $wpdb->prefix . "batch_summary";
		
		if($time!==""){
			
			if($time == 'today'){
			
				$result = $wpdb->get_results(
						"SELECT sum(total_amount) as TotalAmount FROM ".$table_batch_summary." WHERE date_create >= (CURDATE() + INTERVAL - 0 DAY)"
						); 
	             
			}
			if($time == 'week'){
				$result = $wpdb->get_results(
						"SELECT sum(total_amount) as TotalAmount FROM ".$table_batch_summary." WHERE date_create >= (CURDATE() + INTERVAL - 7 DAY)"
					 );
			
			}
			if($time == 'month'){
				$result = $wpdb->get_results(
						"SELECT sum(total_amount) as TotalAmount FROM ".$table_batch_summary." WHERE date_create >= (CURDATE() + INTERVAL - 30 DAY)"
					 );
			
			}
			
		}else{
			
			 $result = $wpdb->get_results(
						"SELECT sum(total_amount) as TotalAmount FROM ".$table_batch_summary
					 );
			
			
		}
		
		
		/* 
		 $result = $wpdb->get_results(
						"SELECT sum(total_amount) as TotalAmount FROM ".$table_batch_summary." WHERE date_create >= (CURDATE() + INTERVAL - 0 DAY) " */
					 //); 
		//echo "SELECT * FROM ".$table_upload_invoice;
		
		
		 if(empty($result))
				 {
					 
					 return 0;
				
				 }else{
					   if(empty($result[0]->TotalAmount)){
			  // die('if');
			   return 0;
			   
		   }else{
			   
			  return $result;
		   }
					 
					/*  if(empty($result[0]->TotalAmount)){
						 
						 return 0;
						 
					 }else{
						return $result; 
					 } */
					 
					 
					 
					 
				 } 
		
		
		
        
	}
}

if(!function_exists('getClientTotalDataBasedonFilters')){
	function getClientTotalDataBasedonFilters($clientId,$time=""){
	
	global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$count_type=$countType;
		
		
		$sql= "SELECT COUNT(b.mail_type) as registerd_mail_count FROM ".$table_mail_tagging." a INNER JOIN ".$table_mail_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Individual' AND b.mail_type IN ('Registered','Parcel','Ordinary Mail','Express','EMS') AND b.created_by='".$clientId."'";
		
		if($time!=""){
			
			if($time=='week'){
				$sql .= ' and created_on >= (CURDATE() + INTERVAL -7 DAY)';
			}
			if($time=='month'){
				$sql .= ' and created_on >= (CURDATE() + INTERVAL -30 DAY)';
			}
			if($time=='today'){
				$sql .= ' and created_on >= (CURDATE() + INTERVAL - 0 DAY)';
			}
		}
		
		$result = $wpdb->get_results( $sql );
		
		$resultCount=$result[0]->registerd_mail_count;
		
		
		/** Batch Query **/
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		//$sqlBatch= "SELECT COUNT(*) as registerd_mail_count FROM ".$table_name2." WHERE mail_type='".$batchType."' and created_by='".$clientId."'";
		$sqlBatch= "SELECT COUNT(b.mail_type) as registerd_mail_count FROM ".$table_mail_tagging." a INNER JOIN ".$table_batch_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Batch' AND b.mail_type IN ('Registered','Parcel','Ordinary Mail','Express','EMS') AND b.created_by='".$clientId."'";
		
		if($time!=""){
			
			if($time=='week'){
				$sqlBatch .= ' and created_on >= (CURDATE() + INTERVAL -7 DAY)';
			}
			if($time=='month'){
				$sqlBatch .= ' and created_on >= (CURDATE() + INTERVAL -30 DAY)';
			}
			if($time=='today'){
				$sqlBatch .= ' and created_on >= (CURDATE() + INTERVAL - 0 DAY)';
			}
		}
		
		$resultBatch = $wpdb->get_results( $sqlBatch );
		
		 //echo $sql."<br>".$sqlBatch;
		
		
		$resultCount= $result[0]->registerd_mail_count+$resultBatch[0]->registerd_mail_count;
		
		return $resultCount;
		
	
	
	}
}

function getTaggedMailNumberInBatch($batchId){

		global $wpdb;
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		//$sql= "SELECT count(*) as tot_num From  ".$table_mail_tagging." where tag !='' and batch_id='".$batchId."'";
		$sql= "SELECT count(*) as tot_num From  ".$table_mail_tagging." where tag ='good' and batch_id='".$batchId."'";
		$resultBatch = $wpdb->get_row( $sql );
		return $resultBatch->tot_num;
		
}

function getTaggedMailAmountInBatch($batchId){

		global $wpdb;
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		//$sql= "SELECT *  From  ".$table_mail_tagging." where tag !='' and batch_id='".$batchId."'";
		//$sql= "SELECT sum(bc.amount) as procced_amount FROM ".$table_mail_tagging." mt INNER JOIN ".$table_batch_creation." bc ON bc.tracking_number=mt.tracking_id where mt.tag !='' and mt.batch_id='".$batchId."'";
		$sql= "SELECT sum(bc.amount) as procced_amount FROM ".$table_mail_tagging." mt INNER JOIN ".$table_batch_creation." bc ON bc.tracking_number=mt.tracking_id where mt.tag ='good' and mt.batch_id='".$batchId."'";
		$resultBatch = $wpdb->get_row( $sql );
		return $resultBatch->procced_amount;
		
}

function getTaggedMailWeightInBatch($batchId){

		global $wpdb;
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		//$sql= "SELECT *  From  ".$table_mail_tagging." where tag !='' and batch_id='".$batchId."'";
		$sql= "SELECT sum(bc.weight_kg) as weight_kg FROM ".$table_mail_tagging." mt INNER JOIN ".$table_batch_creation." bc ON bc.tracking_number=mt.tracking_id where mt.tag ='good' and mt.batch_id='".$batchId."'";
		$resultBatch = $wpdb->get_row( $sql );
		return $resultBatch->weight_kg;
		
}

function getTaggedMailCountryInBatch($batchId){

		global $wpdb;
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		//$sql= "SELECT *  From  ".$table_mail_tagging." where tag !='' and batch_id='".$batchId."'";
		$sql= "SELECT count(country) as totcountry, country FROM ".$table_mail_tagging." mt INNER JOIN ".$table_batch_creation." bc ON bc.tracking_number=mt.tracking_id where mt.tag ='good' and mt.batch_id='".$batchId."' group by country";
		$resultBatch = $wpdb->get_results( $sql );
		//return $resultBatch;
		$country= "";
		foreach($resultBatch  as $countryData){
			$country .= $countryData->country.'-'. $countryData->totcountry.',';
		}
		echo $country;
		
}
		
		
		
		
		
?>