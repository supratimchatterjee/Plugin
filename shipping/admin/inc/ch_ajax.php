<?php
/*
	*
	* Code House Ajax Function
	*
*/

require_once('chDb.php');
$spDB = new SHIPPING;

/*
*  Insert Function Ajax
*/

if(!function_exists('chShipmentinsert')){
	function chShipmentinsert(){
		global $spDB;
		// jQuery Post Form Data
		$fData = array();
		parse_str($_POST['formVar'], $fData);
		$jfData = json_encode($fData);

		$consignmentNo 	= $_POST['consignmentNo'];
		$insert = $spDB->add_shipping($jfData, $consignmentNo);
		echo $insert;
	die();
	}
	// Add the ajax hooks for admin
	add_action( 'wp_ajax_chShipmentinsert', 'chShipmentinsert' );
	// Add the ajax hooks for front end
	//add_action( 'wp_ajax_nopriv_chShipmentinsert', 'chShipmentinsert' );
}




/*
*  Update Function Ajax
*/

if(!function_exists('chShipmentUpdate')){
	function chShipmentUpdate(){
		global $spDB;
		// jQuery Post Form Data
		$fData = array();
		parse_str($_POST['formVar'], $fData);
		//$jfData = json_encode($fData);

		$update = $spDB->update_shipping($fData);
		echo $update;
		
	die();
	}
	// Add the ajax hooks for admin
	add_action( 'wp_ajax_chShipmentUpdate', 'chShipmentUpdate' );
	// Add the ajax hooks for front end
	//add_action( 'wp_ajax_nopriv_chShipmentUpdate', 'chShipmentUpdate' );
}




/*
*  Delete Function Ajax
*/

if(!function_exists('chShipmentDelete')){
	function chShipmentDelete(){
		global $spDB;
		// jQuery Post Form Data
		$ids = implode( ',', array_map( 'absint', $_POST['dArray'] ) );
		$delete = $spDB->delete_shipping($ids);
		echo $delete;
	die();
	}
	// Add the ajax hooks for admin
	add_action( 'wp_ajax_chShipmentDelete', 'chShipmentDelete' );
	// Add the ajax hooks for front end
	//add_action( 'wp_ajax_nopriv_chShipmentDelete', 'chShipmentDelete' );
}



/*
*  Search Function Ajax
*/

if(!function_exists('chShipmentSearch')){
	function chShipmentSearch(){
		$sVal = $_POST['sVal'];
		global $spDB;
		// jQuery Post Form Data
		$search = $spDB->search_shipping($sVal);
		$searchOutput = array();
		foreach($search as $ser):
			$allDecode 				= json_decode($ser->all);
			$allDecode->s_id 		= $ser->s_id;
			$allDecode->insert_date	= $ser->insert_date;
			array_push($searchOutput, $allDecode);
		endforeach;
		echo json_encode($searchOutput );
	die();
	}
	// Add the ajax hooks for admin
	add_action( 'wp_ajax_chShipmentSearch', 'chShipmentSearch' );
	// Add the ajax hooks for front end
	//add_action( 'wp_ajax_nopriv_chShipmentSearch', 'chShipmentSearch' );
}



/*
* Quick Form
*/

if(!function_exists('quickShipment')){
	function quickShipment(){
		global $spDB;
		// jQuery Post Form Data
		$qData = array();
		parse_str($_POST['quickForm'], $qData);

		$insert = $spDB->add_quick_shipping($qData, $_POST['truckNo']);
		echo $insert;
	die();
	}
	// Add the ajax hooks for admin
	add_action( 'wp_ajax_quickShipment', 'quickShipment' );
	// Add the ajax hooks for front end
	//add_action( 'wp_ajax_nopriv_quickShipment', 'quickShipment' );
}


/*
* Delete Quick data
*/

if(!function_exists('deleteQuick')){
	function deleteQuick(){
		global $spDB;
		// jQuery Post Form Data

		$delete = $spDB->delete_quick_shipment($_POST['quickId']);
		echo $delete;
	die();
	}
	// Add the ajax hooks for admin
	add_action( 'wp_ajax_deleteQuick', 'deleteQuick' );
	// Add the ajax hooks for front end
	//add_action( 'wp_ajax_nopriv_deleteQuick', 'deleteQuick' );
}


/** function for print mail **/
add_action( 'wp_ajax_printmail', 'printmail_fn' );
add_action( 'wp_ajax_printmail', 'printmail_fn' );
function printmail_fn(){

//echo '<pre>';
//print_r($_POST);

$user = new WP_User(get_current_user_id());




$docType="";
$weight_kg =  $_POST['weight_kg'];
if($_POST['mail_type']){

	if($_POST['mail_type']=='EMS'){
		$docType = 'AIRWAY BILL';
	} else if($_POST['mail_type']=='Ordinary Mail'){
		$docType = 'PPI LABEL';
	} else if($_POST['mail_type']=='Parcel'){
		
		//if($weight_kg>=2)
		$docType = "CN23";
	} else if($_POST['mail_type']=='Registerd'){
		$docType = "CN22";
	} else {
		$docType = "";
	}
}
$giftCheck="";
if($_POST['content_type']=='Gift'){
	$giftCheck="checked='checked'";
}
$DocumentCheck="";
if($_POST['content_type']=='Document'){
	$DocumentCheck="checked='checked'";
}
$MarchandiseCheck="";
if($_POST['content_type']=='Marchandise'){
	$MarchandiseCheck="checked='checked'";
}
$Commerical_SampleCheck="";
if($_POST['content_type']=='Commerical Sample'){
	$Commerical_SampleCheck="checked='checked'";
}

include_once('barcode/autoload.php');
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();

/* ...................*/
		$countryCode=$_POST["country"];
		global $wpdb;
		$table_shipping_country = $wpdb->prefix . "shipping_country";
		$result = $wpdb->get_row(
						"SELECT country_name FROM ".$table_shipping_country." WHERE country_code='".$countryCode."'" 
					);
		$countryName=$result->country_name;
/* ...................*/





$company=getExterafieldProfileData(1,get_current_user_id());
$address=getExterafieldProfileData(2,get_current_user_id());





$logo = site_url() . '/wp-content/plugins/shipping/admin/img/img-logo.jpg';
$data = '<table cellpadding="0" cellspacing="10" width="600" align="center" style="border:solid 1px #000; font-family: Arial, Helvetica, sans-serif; font-size:13px; color:#333; line-height:1.5; border-collapse:collapse;">
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="50%" style="border-right:solid 1px #000;">
<img src="'.$logo.'">
</td>
<td style="padding-left:10px;"> 
<span style="text-transform:uppercase;">Charge Collected "Taxe Percue"</span><br>
Philippines PPI No. 2425
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="border-top:solid 1px #000;" align="center">AIRMAIL<br>P.O. Box 1010<br>CLARK FREEPORT POST OFFICE, PHILIPPINES
</td>
</tr>
<tr>
<td style="border-top:solid 1px #000; padding:10px 0;" align="center">
'.$generator->getBarcode($_POST["tracking_number"], $generator::TYPE_CODE_128).'
<br>
'.$_POST["tracking_number"].'
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="center" style="border-right:solid 1px #000; border-top:solid 1px #000;padding-top: 10px;padding-bottom:10px;">
Deliver To:<br>
<strong>'.$_POST["addressee"].'<br>
'.$_POST["address1"].'<br>
'.$_POST["address2"].'<br>
'.$_POST["city"].' ,'.$_POST["state"].', '.$countryName.'</strong>
</td>
<td style="padding-left:10px; border-top:solid 1px #000; font-weight:bold; font-size:24px;" align="center"> 
'.$_POST["country"].'
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding-left:10px;">
CUTOMS DECLARATION Postal administration (May be opened officially)
</td>
<td style="padding-left:10px; border-top:solid 1px #000;" align="left"> 
'.$docType.'<br>
Important!
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="border-top:solid 1px #000; padding:10px 0; padding-left:10px;" align="left">
<input type="checkbox" '.$giftCheck.'> Gift &nbsp; <input type="checkbox" '.$Commerical_SampleCheck.'> Commercial Sample<br>
<input type="checkbox" '.$DocumentCheck.'> Document &nbsp; <input type="checkbox" '.$MarchandiseCheck.'> Other (Merchandize)
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding:10px 0; padding-left:10px;">
Detailed description of Contents
</td>
<td style=" padding:10px 0; padding-right:10px; border-top:solid 1px #000;" align="right"> 
Value
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding:10px 0; padding-left:10px; font-weight:bold; font-size:20px;">'.$_POST['description'].'
</td>
<td style=" padding:10px 0; padding-right:10px; border-top:solid 1px #000; font-weight:bold; font-size:16px;" align="right"> 
$'.$_POST['amount'].'
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="47%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding:10px 0; padding-left:10px;">
Origin:<b>PH</b>
</td>
<td width="33%" style="border-right:solid 1px #000;  padding:10px 0; padding-left:10px; border-top:solid 1px #000;" align="left"> 
Total Weight (kg):<strong>'.$_POST['weight_kg'].'</strong>
</td>
<td style="padding:10px 0; padding-right:10px; border-top:solid 1px #000;" align="right"> 
Total <span style=" font-weight:bold; font-size:16px;">$'.$_POST['amount'].'</span>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="padding:10px; border-top:solid 1px #000;" align="left;">I, the undersigned, whose name and address are given on the item, certify that the particulars given in this declaration are correct and that this item does not contain dangerous article or articles prohibited by legislation or by postal customs regulations.
</td>
</tr>
<tr>
<td style="padding:10px; border-top:solid 1px #000;" align="center"><strong>'.ucfirst($user->display_name).'</strong><br>
'.$company.', '.$address.'<br>'.date('F d, Y H:i:s').'<br>
</td>
</tr>
</table>
';

echo $data;
die;
}

/** End for printmail **/

/** function for print mail **/
add_action( 'wp_ajax_printbatchmail', 'printbatchmail_fn' );
add_action( 'wp_ajax_printbatchmail', 'printbatchmail_fn' );
function printbatchmail_fn(){

//echo '<pre>';
//print_r($_POST);

$user = new WP_User(get_current_user_id());

$docType="";
$data = "";
$i=0;

include_once('barcode/autoload.php');
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$logo = site_url() . '/wp-content/plugins/shipping/admin/img/img-logo.jpg';
ini_set('diplay_error',true);
error_reporting(E_ALL);
//echo $_POST['weight'][1];

//die;
foreach( $_POST['tracking'] as $batchEditData){
$weight_kg =  $_POST['weight'][$i];
//echo $_POST['weight'][$i];

if( $_POST['mail_type'][$i] ){

	if( $_POST['mail_type'][$i]=='EMS' || $_POST['mail_type'][$i]=='ems'){
		$docType = 'AIRWAY BILL';
	} else if( $_POST['mail_type'][$i]=='Ordinary Mail' || $_POST['mail_type'][$i]=='ORDINARY MAIL'){
		$docType = 'PPI LABEL';
	} else if( $_POST['mail_type'][$i]=='Parcel' || $_POST['mail_type'][$i]=='PARCEL'){
		
		//if($weight_kg>=2)
		$docType = "CN23";
	} else if( $_POST['mail_type'][$i]=='Registerd' || $_POST['mail_type'][$i]=='REGISTERED'){
		$docType = "CN22";
	} else {
		$docType = "";
	}
}
$giftCheck="";
if($_POST['content'][$i]=='Gift' || $_POST['content'][$i]=='GIFT'){
	$giftCheck="checked='checked'";
}
$DocumentCheck="";
if($_POST['content'][$i]=='Document' || $_POST['content'][$i]=='DOCUMENT'){
	$DocumentCheck="checked='checked'";
}
$MarchandiseCheck="";
if($_POST['content'][$i]=='Marchandise' || $_POST['content'][$i]=='MARCHANDISE' || $_POST['content'][$i]=='MERCHANDIZE'){
	$MarchandiseCheck="checked='checked'";
}
$Commerical_SampleCheck="";
if($_POST['content'][$i]=='Commerical Sample' || $_POST['content'][$i]=='COMMERICAL SAMPLE'){
	$Commerical_SampleCheck="checked='checked'";
}



/* ...................*/
		$countryCode=$_POST['destination_country'][$i];
		//print_r($countryCode);
		
		
		global $wpdb;
		$table_shipping_country = $wpdb->prefix . "shipping_country";
		
		$result = $wpdb->get_row(
						"SELECT country_name FROM ".$table_shipping_country." WHERE country_code='".$countryCode."'" 
					);
					
		$countryName=$result->country_name;
		
/* ...................*/


$company=getExterafieldProfileData(1,get_current_user_id());
$address=getExterafieldProfileData(2,get_current_user_id());






$data .= '<div style=""><table cellpadding="0" cellspacing="10" width="600" align="center" style="border:solid 1px #000; font-family: Arial, Helvetica, sans-serif; font-size:13px; color:#333; line-height:1.5; border-collapse:collapse;">
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="50%" style="border-right:solid 1px #000;">
<img src="'.$logo.'">
</td>
<td style="padding-left:10px;"> 
<span style="text-transform:uppercase;">Charge Collected "Taxe Percue"</span><br>
Philippines PPI No. 2425
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="border-top:solid 1px #000;" align="center">AIRMAIL<br>P.O. Box 1010<br>CLARK FREEPORT POST OFFICE, PHILIPPINES
</td>
</tr>
<tr>
<td style="border-top:solid 1px #000; padding:10px 0;" align="center">
'.$generator->getBarcode($_POST['tracking'][$i], $generator::TYPE_CODE_128).'
<br>
'.$_POST['tracking'][$i].'
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="center" style="border-right:solid 1px #000; border-top:solid 1px #000;padding-top: 10px;padding-bottom:10px;">
Deliver To:<br>
<strong>'.$_POST['addresee'][$i].'<br>
'.$_POST['address'][$i].'</strong>
</td>
<td style="padding-left:10px; border-top:solid 1px #000; font-weight:bold; font-size:24px;" align="center"> 
'.$_POST['destination_country'][$i].'
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding-left:10px;">
CUTOMS DECLARATION Postal administration (May be opened officially)
</td>
<td style="padding-left:10px; border-top:solid 1px #000;" align="left"> 
'.$docType.'<br>
Important!
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="border-top:solid 1px #000; padding:10px 0; padding-left:10px;" align="left">
<input type="checkbox" '.$giftCheck.'> Gift &nbsp; <input type="checkbox" '.$Commerical_SampleCheck.'> Commercial Sample<br>
<input type="checkbox" '.$DocumentCheck.'> Document &nbsp; <input type="checkbox" '.$MarchandiseCheck.'> Other (Merchandize)
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding:10px 0; padding-left:10px;">
Detailed description of Contents
</td>
<td style=" padding:10px 0; padding-right:10px; border-top:solid 1px #000;" align="right"> 
Value
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="80%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding:10px 0; padding-left:10px; font-weight:bold; font-size:20px;">'.$_POST['description'][$i].'
</td>
<td style=" padding:10px 0; padding-right:10px; border-top:solid 1px #000; font-weight:bold; font-size:16px;" align="right"> 
$'.$_POST['amount'][$i].'
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="47%" align="left" style="border-right:solid 1px #000; border-top:solid 1px #000; padding:10px 0; padding-left:10px;">
Origin:<b>PH</b>
</td>
<td width="33%" style="border-right:solid 1px #000;  padding:10px 0; padding-left:10px; border-top:solid 1px #000;" align="left"> 
Total Weight (kg):<strong>'.$_POST['weight'][$i].'</strong>
</td>
<td style="padding:10px 0; padding-right:10px; border-top:solid 1px #000;" align="right"> 
Total <span style=" font-weight:bold; font-size:16px;">$'.$_POST['amount'][$i].'</span>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="padding:10px; border-top:solid 1px #000;" align="left;">I, the undersigned, whose name and address are given on the item, certify that the particulars given in this declaration are correct and that this item does not contain dangerous article or articles prohibited by legislation or by postal customs regulations.
</td>
</tr>
<tr>
<td style="padding:10px; border-top:solid 1px #000;" align="center"><strong>'.ucfirst($user->display_name).'</strong><br>
'.$company.', '.$address.'<br>'.date('F d, Y H:i:s').'<br>
</td>
</tr>
</table></div>
';

$i++;
$data .="<br>";
}
echo $data;
//die('check country code formate');
die;
}


/** Save batch upload data **/
add_action( 'wp_ajax_savebatchmail', 'savebatchmail_fn' );

function savebatchmail_fn(){
	$i=0;
	global $wpdb;
	$table = $wpdb->prefix."batch_creation";
	$currentUserId = get_current_user_id();
	$amount = 0;
	$totamount = 0;
	$weight = 0;
	$totweight = 0;
	if($_REQUEST['batch_name']!=""){
	
	$myrows = $wpdb->get_row( "SELECT count(*) as tot FROM ".$wpdb->prefix."batch_creation where batch_name= '".$_REQUEST['batch_name']."' or batch_id =  '".$_REQUEST['batch_ID']."' limit 1" );
	
	//echo "SELECT count(*) as tot FROM ".$wpdb->prefix."batch_creation where batch_name= '".$_REQUEST['batch_name']."' or batch_id =  '".$_REQUEST['batch_ID']."' limit 1";
	
	//die('chcking');
	//$time= time();
	
	//$batch_id = $time;
	//$batch_id=$_REQUEST['batch_ID'];
	
	
	if($myrows->tot>0) {
		echo 'all';
	} else {
		foreach( $_POST['tracking'] as $batchEditData){
		
			$tracking_number = $_REQUEST['tracking'][$i];
			$mail_type = $_REQUEST['mail_type'][$i];
			$country= $_REQUEST['destination_country'][$i];
			$content_type = $_REQUEST['content'][$i];
			$addressee = $_REQUEST['addresee'][$i];
			$address1 = $_REQUEST['address'][$i];
			$description = $_REQUEST['description'][$i];
			$amount = $_REQUEST['amount'][$i];
			$weight_kg = $_REQUEST['weight'][$i];
			$batch_name = $_REQUEST['batch_name'];
			
			$batch_id=$_REQUEST['batch_ID'];
			
			$status = 'initial';
			$created_by = get_current_user_id();
			$data = compact('tracking_number','mail_type','country','content_type','addressee','address1','description','amount','weight_kg','created_by','batch_name','created_on','batch_id');
			$wpdb->insert( $table, $data);
				
			
			$totamount = $totamount+$amount;
			$totweight = $totweight+$weight_kg;
			
			$i++;
			 
		}
		
		//echo '--'.$totamount;
		//die('y');
		$total_number_mail = $i;
		$batch_name= $_REQUEST['batch_name'];
		$total_waight =$totweight; 
		$total_amount =$totamount; 
		//$batch_id= $time;
		$batch_id=$_REQUEST['batch_ID'];
		$date_create = date('Y-m-d H:i:s');
		$batch_upload_by = get_current_user_id();
		$table2 = $wpdb->prefix."batch_summary";
		$data2 = compact('batch_name','batch_id','total_waight','total_amount','total_number_mail','date_create','batch_upload_by');
		$wpdb->insert( $table2, $data2);
		echo 'yes';
	}
	
	
	} else {
		echo 'done';
	}
	die;
} 

add_action( 'wp_ajax_batch_upload', 'batch_upload_fn' );
add_action( 'wp_ajax_batch_uploadreview', 'batch_uploadreview_fn' );
function batch_uploadreview_fn(){
	
	$i=0;
	$data="";
	$amount= 0;
	$weight=0;
	if($_POST){
		 $result = array_count_values( $_POST['destination_country'] );
		// print_r( $_POST['tracking']);
		 //$countCountry= count($result);
		foreach( $_POST['tracking'] as $batchEditData){
			//if($_POST['tracking'][$i]!=""){
			  $amount = $amount+$_POST['amount'][$i];
			  $weight = $weight+$_POST['weight'][$i];
			  $i++;
			//}
		}
		$data .= '<tbody class="thead-inverse">';
		$data .="<tr><td>Batch Name</td><td>".$_POST['batch_name']."</td></tr>";
		$data .="<tr><td>Batch No</td><td>".$_POST['batch_ID']."</td></tr>";
		$data .="<tr><td>Date & Time</td><td>".date('Y-m-d H:i:s')."</td></tr>";
		$data .="<tr><td>Total number of mails</td><td>".$i."</td></tr>";
		$data .="<tr><td>No. of mails per country</td>";
		$data .= "<td>";
		foreach($result as $key => $countData){
			$data .= $key.'-'.$countData.'<br>';
		}
		$data .= "</td></tr>";
		$data .="<tr><td>Total Amount / Value($)</td><td>".$amount."</td></tr>";
		$data .="<tr><td>Total Weight(gram) </td><td>".$weight."</td></tr>";
		$data .="<tr><td colspan='2'><input type='checkbox' name='confirm_batch'>&nbsp;&nbsp;I, the undersigned whose name and address are given on the item/s, certify that the particulars given in this Declaration are correct and that this/these item/s does/do not contain any dangerous article or articles prohibited by legislation or by postal or customs regulations.</td></tr>";
		$data .= "</tbody>";
	
	}
	echo  $data;
	die;
}

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}

function batch_upload_fn(){

$rawCSV = readCSV($_FILES['batchupload']['tmp_name']);
$baseName = $_FILES['batchupload']['name'];
$baseName = basename($baseName,".csv");
//print_r( $rawCSV );
//echo '<pre>';
 $data= "";
 $i=0;
if($rawCSV){
//print_r( $rawCSV );
	foreach( $rawCSV as $rawCSVData){
		//echo $rawCSVData[0];
		if( $i>0) {
				if($rawCSVData[0]!=""){
				$data .= '<tr>
				<td><input type="text" name="tracking[]" value="'.$rawCSVData[0].'"></td>
				<td><input type="text" name="addresee[]" value="'.$rawCSVData[1].'"></td>
				<td><input type="text" name="address[]" value="'.$rawCSVData[2].'"></td>
				<td><input type="text" name="weight[]" value="'.$rawCSVData[3].'"></td>
				<td><input type="text" name="mail_type[]" value="'.$rawCSVData[4].'"></td>
				<td><input type="text" name="content[]" value="'.$rawCSVData[5].'"></td>
				<td><input type="text" name="description[]" value="'.$rawCSVData[6].'"></td>
				<td><input type="text" name="destination_country[]" value="'.$rawCSVData[7].'"></td>
				<td><input type="text" name="amount[]" value="'.$rawCSVData[8].'"></td>
			  </tr>';
			  }
		}
		$data .= '<tr><input type="hidden" name="batch_name" value="'.$baseName.'"></tr>';		
		$data .= '<tr><input type="hidden" name="batch_ID" value="'.time().'"></tr>';		
			$i++;	
	}
echo  $data;

}

//print_r($_FILES);
die(123);
}

add_action( 'wp_ajax_mail_create_save', 'mail_create_save' );
function  mail_create_save(){
	global $wpdb;
	$table = $wpdb->prefix."mail_creation";get_current_user_id();$tracking_number = $_REQUEST['tracking_number'];$mail_type = $_REQUEST['mail_type'];$country= $_REQUEST['country'];
	$content_type = $_REQUEST['content_type'];
	$addressee = $_REQUEST['addressee'];$address1 = $_REQUEST['address1'];
	$address2 = $_REQUEST['address2'];$city = $_REQUEST['city'];
	$state = $_REQUEST['state'];$description = $_REQUEST['description'];
	$amount = $_REQUEST['amount'];$weight_kg = $_REQUEST['weight_kg'];
	$weight_grm = $_REQUEST['weight_grm'];
	$zip_code = $_REQUEST['zip_code'];$status = 'initial';$created_by = get_current_user_id();
	$data = compact('tracking_number','mail_type','country','content_type','addressee','address1','address2','city','state','description','amount','weight_kg','weight_grm','created_by','zip_code','status');
	$wpdb->insert( $table, $data);
	addactivity('newmail');
	echo $wpdb->insert_id;
	
	die;
}


function show_batchmail_process_data(){

		global $wpdb;
		$table_name = $wpdb->prefix . "batch_summary";
		$result = $wpdb->get_results(
						"SELECT * FROM  ".$table_name." where is_tagged=0"
					);
		return $result;

}

add_action( 'wp_ajax_mail_process', 'mail_process_tag' );
function mail_process_tag(){
//echo '1';
	global $wpdb;
	$choosemailprocessoption = $_REQUEST['choosemailprocessoption'];
	$data="";
	$individual_mail = $_REQUEST['individual_mail'];
	$batch_mail = $_REQUEST['batch_mail'];
	$data3="";
	//print_r($_REQUEST);
	//die;
	if($choosemailprocessoption){
		
		if($choosemailprocessoption=='Individual'){
		
			foreach($individual_mail as $singleData){
			
				$data .= '<tr id="'.$singleData.'">
							<td>'.$singleData.'</td>
							<td><input type="hidden" name="tracking_code[]" value="'.$singleData.'" ><input type="text" name="tag_type[]" value=""></a></td>
						  </tr>';
						  
			}
			
			
			$myrows = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."mail_creation where tracking_number='".$singleData."' limit 1" );
									
									if($myrows){
									
									$data2 = '<table class="mailSummary" border="1">
										<thead class="thead-inverse">
											<tr>
												<th>Fields</th>
												<th>Values</th>
											</tr>
											<tr >
												<td>Country</td>
												<td id="td_country">'.$myrows->country.'</td>
											</tr>
											<tr >
												<td>Tracking Number</td>
												<td id="td_tracking_number">'.$myrows->tracking_number.'</td>
											</tr>
											<tr >
												<td>Mail Type</td>
												<td id="td_mail_type">'.$myrows->mail_type.'</td>
											</tr>
											<tr >
												<td>Content</td>
												<td id="td_content_type">'.$myrows->content_type.'</td>
											</tr>
											<tr >
												<td>Addressee</td>
												<td id="td_addressee">'.$myrows->addressee.'</td>
											</tr>
											<tr >
												<td>Address 1</td>
												<td id="td_address1">'.$myrows->address1.'</td>
											</tr>
											<tr >
												<td>Address 2</td>
												<td id="td_address2">'.$myrows->address2.'</td>
											</tr>
											<tr >
												<td>Town / City</td>
												<td id="td_city">'.$myrows->city.'</td>
											</tr>
											<tr >
												<td>State / Province</td>
												<td id="td_state">'.$myrows->state.'</td>
											</tr>
											<tr >
												<td>Zip / Postal Code</td>
												<td id="td_zip_code">'.$myrows->zip_code.'</td>
											</tr>
											
											<tr >
												<td>Description</td>
												<td id="td_description">'.$myrows->description.'</td>
											</tr>
											
											<tr >
												<td>Amount / Value($)</td>
												<td  id="td_amount">'.$myrows->amount.'</td>
											</tr>
											
											<tr >
												<td>Weight(kilogram)</td>
												<td  id="td_weight_kg">'.$myrows->weight_kg.'</td>
											</tr>
											
											<tr >
												<td>Weight(gram)</td>
												<td id="td_weight_grm">'.$myrows->weight_grm.'</td>
											</tr>
											
											
										</thead>
										</table>';
									}
			
			
		} else {
		
			foreach($batch_mail as $batch_mail_id){
			$table_name = $wpdb->prefix . "batch_creation";
			$result = $wpdb->get_results("SELECT * FROM  ".$table_name." where batch_id='".$batch_mail_id."'");
				//echo "SELECT * FROM  ".$table_name." where batch_id='".$batch_mail_id."'";	
				
				//echo"<pre>";
				//print_r($result);
				foreach($result as $resultData){
				
					$data .= '<tr id="'.$resultData->tracking_number.'">
								<td>'.$resultData->tracking_number.'</td>
								<td><input type="hidden" name="tracking_code[]" value="'.$resultData->tracking_number.'" ><input type="text" name="tag_type[]" value=""></a></td>
							  </tr>';
				}
				$data .= '<tr>
					<td colspan="2"><input type="hidden" name="batch_id" value="'.$batch_mail_id.'"></td>
					
				  </tr>';
				  
				$myrowsbatch = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."batch_summary where batch_id='".$batch_mail_id."'" );
									$amount = 0;
									$weight = 0;
									
									$data2 .= '<table class="table table-striped table-bordered" ><tbody class="thead-inverse">';
									$data2 .="<tr><td>Batch Name</td><td>".$myrowsbatch->batch_name."</td></tr>";
									$data2 .="<tr><td>Date & Time</td><td>".date('Y-m-d H:i:s')."</td></tr>";
									$data2 .="<tr><td>Total number of mails</td><td>".$myrowsbatch->total_number_mail."</td></tr>";
									$data2 .="<tr><td>Total Amount / Value($)</td><td>".$myrowsbatch->total_amount."</td></tr>";
									$data2 .="<tr><td>Total weight(gram) </td><td>".$myrowsbatch->total_waight."</td></tr>";
									
									$data2 .= "</tbody></table>";  
					$data3 = "BATCH ID:- ".$batch_mail_id;				
			}			
		
		}
		
		$data .= '<tr><td colspan="2"><input type="hidden" name="tag_save_type" value="'.$choosemailprocessoption.'"></a></td><tr>';
	}
	
	
	
	//echo $data;
	$arr[0] = $data;
	$arr[1] = $data2;
	$arr[2] = $data3;
	

	echo json_encode($arr);
	die;

}

add_action( 'wp_ajax_save_tag', 'save_tag_fun' );
function save_tag_fun(){
	
	global $wpdb;
	$choosemailprocessoption = $_REQUEST['tag_save_type'];
	$type = $_REQUEST['tag_save_type'];
	$addedby = get_current_user_id();
	$batch_id = $_REQUEST['batch_id'];
	$created_date = date('Y-m-d H:i:s');
	$table = $wpdb->prefix."mail_tagging";
	$i=0;
	if( !empty( $_REQUEST['tracking_code']) ){
		foreach( $_REQUEST['tracking_code'] as $trackingcode){
		
			$tracking_id = $_REQUEST['tracking_code'][$i];
			$tag = $_REQUEST['tag_type'][$i];
			$data = compact('tracking_id','tag','type','batch_id','addedby','created_date');
			
			$wpdb->insert( $table, $data);
		
			$i++;
		}
		
		if($choosemailprocessoption=='Individual'){
			$wpdb->query( $wpdb->prepare("UPDATE ".$wpdb->prefix."mail_creation SET is_tagged = '1' WHERE tracking_number = '".$_REQUEST['tracking_code'][0]."'") );
			//echo "UPDATE ".$wpdb->prefix."mail_creation SET is_tagged = '1' WHERE tracking_number = '".$_REQUEST['tracking_code'][0]."'";
		} else {
			
			$wpdb->query( $wpdb->prepare("UPDATE ".$wpdb->prefix."batch_summary SET is_tagged = '1' WHERE batch_id = '".$batch_id."'") );
		}
	}
	echo 'done';
	die;
}

add_action( 'wp_ajax_tag_process_summary', 'tag_process_summary_fun' );
function tag_process_summary_fun(){
	//echo 'done1';
	//die;
	global $wpdb;
	$tag_save_type= $_REQUEST['tag_save_type']; 
	$tag_type = $_REQUEST['tag_type']; 
	$country = "";
	if($tag_save_type=='Individual'){
		$tracking_id= $_REQUEST['tracking_code'][0];

		$table_name = $wpdb->prefix . "mail_creation";
		$result = $wpdb->get_row("SELECT * FROM  ".$table_name." where tracking_number='".$tracking_id."'");
		//return $result;	
		//echo "SELECT * FROM  ".$table_name." where tracking_number='".$tracking_id."'";
		$data=' <tbody class="thead-inverse">
			<tr>
				<td>Mail Created</td>
				<td>'.$result->created_on.'</td>
			</tr>
			<tr>
				<td>Date Received</td>
				<td>-</td>
			</tr>
			
			
			<tr><td>Tracking Id.</td><td>'.$_REQUEST['tracking_code'][0].'</td></tr>
			
			<tr><td>Destination Country</td><td>'.$result->country.'</td></tr>
			<tr><td>Total Amount / Value($)</td><td>'.$result->amount.'</td></tr>
			<tr><td>Total Weight(gram)</td><td>'.$result->weight_kg.'</td></tr>
			</tbody>';
	
	} else {
		$batch_id = $_REQUEST['batch_id'];
		$table_name = $wpdb->prefix . "batch_summary";
		$result = $wpdb->get_row("SELECT * FROM  ".$table_name." where batch_id='".$batch_id."'");
		
		//echo '<pre>';
		//print_r($result);
		
		
		
		//echo "SELECT country FROM ".$wpdb->prefix."batch_creation WHERE batch_id='".$batch_id."' GROUP by country";
		$resultCountry = $wpdb->get_results("SELECT country  , COUNT(country) as countryCount  FROM ".$wpdb->prefix."batch_creation WHERE batch_id='".$batch_id."' GROUP by country");
		//echo "SELECT country FROM ".$wpdb->prefix."batch_creation WHERE batch_id='".$batch_id."' GROUP by country";
		//$country = implode (", ", $resultCountry->country);
		//echo "<pre>";
		//print_r($resultCountry);
		
		
		/* foreach($resultCountry as $countryData){
			$country .= ','.$countryData->country;
			
		} */
		foreach($resultCountry as $key => $countData){
			$country .= $resultCountry[$key]->country.'-'.$resultCountry[$key]->countryCount.'<br>';
		}
		
		//print_r($country);
		
		//$country = trim($country ,',');
		
		$processed=0;
		$unmailed=0;
		$Discrepancy=0;
		//print_r($tag_type);
		foreach($tag_type as $tag_typeData){
			//if($tag_typeData=='bad' || $tag_typeData=='bad' || $tag_typeData=='BAD' ){
				//$unmailed++;
			//}
			//if($tag_typeData='bad' || $tag_typeData=='bad' || $tag_typeData=='BAD' ){
				//$unmailed++;
			//}
			if( $tag_typeData!="" ){
				$processed++;
			}
			//if( ($tag_typeData!="") && ($tag_typeData=='good' || $tag_typeData=='Good' || $tag_typeData=='GOOD') ){
				//$processed++;
			//}
			if( trim($tag_typeData)!='' && $tag_typeData!='good'){
				$unmailed++;
			}
			
		}
		//$Discrepancy = $processed-$unmailed;
		$Discrepancy = $result->total_number_mail-$processed;
		//die;
	$data=' <tbody class="thead-inverse">
			<tr><td>Batch No</td><td>'.$result->batch_id.'</td></tr>
			<tr><td>Batch Name</td><td>'.$result->batch_name.'</td></tr>
			<tr>
				<td> Batch Uploaded</td>
				<td>'.$result->date_create.'</td>
			</tr>
			<tr>
				<td>Declared</td>
				<td>'.$result->total_number_mail.'</td>
			</tr>
			<tr>
				<td>Processed</td>
				<td>'.$processed.'</td>
			</tr>
			<tr>
				<td>Un-mailable</td>
				<td>'.$unmailed.'</td>
			</tr>
			<tr>
				<td>Discrepancy</td>
				<td>'.$Discrepancy.'</td>
			</tr>
			
			
			
			<tr><td>Mail/s Per Country</td><td>'.$country.'</td></tr>
			<tr><td>Total Amount / Value($)</td><td>'.$result->total_amount.'</td></tr>
			<tr><td>Total Weight(gram)</td><td>'.$result->total_waight.'</td></tr>
			
			
			</tbody>';
	}		
	echo $data;		
die;	
}

add_action( 'wp_ajax_showsummaryintag', 'showsummaryintag_fun' );
function showsummaryintag_fun(){
	global $wpdb;
	$data2 ="";
	$tag_section_tracking_input_id =$_REQUEST['tag_section_tracking_input_id'];
	$myrows = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."mail_creation where tracking_number='".$tag_section_tracking_input_id."' limit 1" );
									
	if($myrows){

	$data2 = '<table class="mailSummary" border="1">
		<thead class="thead-inverse">
			<tr>
				<th>Fields</th>
				<th>Values</th>
			</tr>
			<tr >
				<td>Country</td>
				<td id="td_country">'.$myrows->country.'</td>
			</tr>
			<tr >
				<td>Tracking Number</td>
				<td id="td_tracking_number">'.$myrows->tracking_number.'</td>
			</tr>
			<tr >
				<td>Mail Type</td>
				<td id="td_mail_type">'.$myrows->mail_type.'</td>
			</tr>
			<tr >
				<td>Content</td>
				<td id="td_content_type">'.$myrows->content_type.'</td>
			</tr>
			<tr >
				<td>Addressee</td>
				<td id="td_addressee">'.$myrows->addressee.'</td>
			</tr>
			<tr >
				<td>Address 1</td>
				<td id="td_address1">'.$myrows->address1.'</td>
			</tr>
			<tr >
				<td>Address 2</td>
				<td id="td_address2">'.$myrows->address2.'</td>
			</tr>
			<tr >
				<td>Town / City</td>
				<td id="td_city">'.$myrows->city.'</td>
			</tr>
			<tr >
				<td>State / Province</td>
				<td id="td_state">'.$myrows->state.'</td>
			</tr>
			<tr >
				<td>Zip / Postal Code</td>
				<td id="td_zip_code">'.$myrows->zip_code.'</td>
			</tr>
			
			<tr >
				<td>Description</td>
				<td id="td_description">'.$myrows->description.'</td>
			</tr>
			
			<tr >
				<td>Amount / Value($)</td>
				<td  id="td_amount">'.$myrows->amount.'</td>
			</tr>
			
			<tr >
				<td>Weight(kilogram)</td>
				<td  id="td_weight_kg">'.$myrows->weight_kg.'</td>
			</tr>
			
			<tr >
				<td>Weight(gram)</td>
				<td id="td_weight_grm">'.$myrows->weight_grm.'</td>
			</tr>
			
			
		</thead>
		</table>';
	} else {
		//$data2 ="No Record Found";
		$myrows = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."batch_creation where tracking_number='".$tag_section_tracking_input_id."' limit 1" );
		
		if($myrows){

		$data2 = '<table class="mailSummary" border="1">
		<thead class="thead-inverse">
			<tr>
				<th>Fields</th>
				<th>Values</th>
			</tr>
			
			<tr >
				<td>Batch Number</td>
				<td id="td_tracking_number">'.$myrows->batch_id.'</td>
			</tr>
			
			<tr >
				<td>Tracking Number</td>
				<td id="td_tracking_number">'.$myrows->tracking_number.'</td>
			</tr>
			<tr >
				<td>Country</td>
				<td id="td_country">'.$myrows->country.'</td>
			</tr>
			<tr >
				<td>Mail Type</td>
				<td id="td_mail_type">'.$myrows->mail_type.'</td>
			</tr>
			<tr >
				<td>Content</td>
				<td id="td_content_type">'.$myrows->content_type.'</td>
			</tr>
			<tr >
				<td>Addressee</td>
				<td id="td_addressee">'.$myrows->addressee.'</td>
			</tr>
			
			<tr >
				<td>Addressee</td>
				<td id="td_addressee">'.$myrows->address1.'</td>
			</tr>
			
			<tr >
				<td>Description</td>
					<td id="td_description">'.$myrows->description.'</td>
			</tr>
			
			<tr >
				<td>Amount / Value($)</td>
				<td  id="td_amount">'.$myrows->amount.'</td>
			</tr>
			
			<tr >
				<td>Weight(gram)</td>
				<td  id="td_weight_kg">'.$myrows->weight_kg.'</td>
				</tr>
				
			<tr >
				<td>Batch Upload On</td>
				<td  id="td_weight_kg">'.$myrows->created_on.'</td>
				</tr>	
			</thead>
			</table>';
		} else {
			$data2 ="No Record Found";
		}
	}

	echo $data2;
	exit;
}

function addactivity( $type ){
	global $wpdb;
	
	if($type!=""){
	
		if($type="newmail"){		
			$activity = 'New mail Created';		
		}
		if($type="newbatch"){		
			$activity = 'New batch created';		
		}
		
		
		$created_date = date('Y-m-d H:i:s');
		$created_by = get_current_user_id();
		$table2 = $wpdb->prefix."shipping_activity";
		$data2 = compact('activity','created_date','created_by');
		$wpdb->insert( $table2, $data2);
		
	}
	
}

function getClientDataBasedonFilters($clientId,$mailtype,$batchType,$time=""){
 
		global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$count_type=$countType;
		
		
		//echo "SELECT COUNT(*) as registerd_mail_count FROM ".$table_name." WHERE mail_type='".$count_type."';";
		//$sql= "SELECT COUNT(*) as registerd_mail_count FROM ".$table_name." WHERE mail_type='".$mailtype."' and created_by='".$clientId."'";
		
		
		$sql= "SELECT COUNT(b.mail_type) as registerd_mail_count FROM ".$table_mail_tagging." a INNER JOIN ".$table_mail_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Individual' AND b.mail_type='".$mailtype."' AND b.created_by='".$clientId."'";
		
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
		$sqlBatch= "SELECT COUNT(b.mail_type) as registerd_mail_count FROM ".$table_mail_tagging." a INNER JOIN ".$table_batch_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Batch' AND b.mail_type='".$mailtype."' AND b.created_by='".$clientId."'";
		
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
		
		// echo $sql."<br>".$sqlBatch;
		
		
		$resultCount= $result[0]->registerd_mail_count+$resultBatch[0]->registerd_mail_count;
		
		return $resultCount;
	

}

function getClientpriceDataBasedonFilters($clientId,$time=""){

		global $wpdb;
		$table_mail_creation = $wpdb->prefix . "mail_creation";
		$table_mail_tagging = $wpdb->prefix . "mail_tagging";
		$count_type=$countType;
		
		
		//echo "SELECT COUNT(*) as registerd_mail_count FROM ".$table_name." WHERE mail_type='".$count_type."';";
		//$sql= "SELECT sum(amount) as tot_count FROM ".$table_name." WHERE created_by='".$clientId."'";
		$sql= "SELECT sum(b.amount) as tot_count FROM ".$table_mail_tagging." a INNER JOIN ".$table_mail_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Individual' AND b.created_by='".$clientId."'";
		
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
		
		$result[0]->tot_count;
		
		
		/** Batch Query **/
		$table_batch_creation = $wpdb->prefix . "batch_creation";
		//$sqlBatch= "SELECT sum(amount) as tot_price FROM ".$table_name2." WHERE created_by='".$clientId."'";
		$sqlBatch= "SELECT sum(b.amount) as tot_price FROM ".$table_mail_tagging." a INNER JOIN ".$table_batch_creation." b ON a.tracking_id = b.tracking_number WHERE a.tag IN('good','bad') AND a.type ='Batch' AND b.created_by='".$clientId."'";
		
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
		//echo $result[0]->tot_price;
		//echo $sql."<br>".$sqlBatch;
		
		
		$resultCount= $result[0]->tot_count+$resultBatch[0]->tot_price;
		
		return $resultCount;
	

}


function getExterafieldProfileData($fieldId, $user_ID){
	
	global $wpdb;
		$table_prflxtrflds_user_field_data = $wpdb->prefix . "prflxtrflds_user_field_data";
		
		$result = $wpdb->get_row(
						"SELECT user_value FROM ".$table_prflxtrflds_user_field_data." WHERE user_id='".$user_ID."' AND field_id= '".$fieldId."'" 
					);
					
		return $result->user_value;
		
		
		
}
