<?php 

if(isset($_GET['trackingid'],$_GET['type'])){
	$type = trim($_GET['type']);
	$trackingId = trim($_GET['trackingid']);
 

$showMailBatchInfoDetails = showMailBatchInfoDetails($trackingId,$type);
$showMailBatchInfo_teg_Details = showMailBatchInfo_teg_Details($trackingId,$type);
 
$addedby=$showMailBatchInfoDetails[0]->addedby;

$userdata = get_userdata($addedby);
$addedByName = $userdata->display_name;
 
  

?>



	<div id="wrapper">

		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                   <h1 class="page-header"> Details </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			
			<div id="smartwizard" class="sw-main sw-theme-arrows1 batchuploadsection">
				<div class="form-group">
				<div class="row">
					<div class="col-lg-8" id="mailSummary_review">
					
					<?php 
					$details='';
					$countryArr=array();
					if($type=='Batch'){
						
						 //print_r($showMailBatchInfo_teg_Details);
						 //print_r($showMailBatchInfoDetails);
						 
							$Processed=0;
							$GoodProcessed=0;
							//$BedProcessed=0;
							$Un_mailable=0;
							$Discrepancy=0;
					 
					foreach($showMailBatchInfo_teg_Details as $showMailBatchInfo_teg_Detailskey =>$showMailBatchInfo_teg_DetailsValue){
							 
							 
							// print_r($showMailBatchInfoDetails[$showMailBatchInfoDetailsKey]->tag);
							  if($showMailBatchInfo_teg_Details[$showMailBatchInfo_teg_Detailskey]->tag == 'good'){
								  
								  $GoodProcessed++;
								  
							  }
							  if($showMailBatchInfo_teg_Details[$showMailBatchInfo_teg_Detailskey]->tag == 
							 'bad'){
								  
								  $Un_mailable++;
								  //$BedProcessed++;
								  
							  }
							  
							 
							 
							
							 
							 
						 }
					 $Processed=$GoodProcessed+$Un_mailable;
					 $Discrepancy =  $showMailBatchInfoDetails[0]->total_number_mail - $Processed ;
						
						   
						   
						
						   //***showMailBatchInfo_Countries_Details***///
						   
						 $showMailBatchInfo_Countries_Details = showMailBatchInfo_Countries_Details($trackingId,$type);
						 
						 
						$countryHtml='';
						   foreach($showMailBatchInfo_Countries_Details as $showMailBatchInfo_Countries_DetailsKey => $showMailBatchInfo_Countries_DetailsValue){
							   
							
							
							$countryHtml.=$showMailBatchInfo_Countries_DetailsValue->country ."- mails ".$showMailBatchInfo_Countries_DetailsValue->TotalMailCount ." / weight(kg) " .$showMailBatchInfo_Countries_DetailsValue->TotalWeightSum ."<br>";
					
							  
							  //$countryArr[$showMailBatchInfo_Countries_DetailsKey]=$showMailBatchInfo_Countries_Details[$showMailBatchInfo_Countries_DetailsKey]->country;
								   
							 }
							 
							 //echo"<pre>";
							// print_r($countryArr);
							 
							// $countryArr_array = implode(',', $countryArr);
							 
							 //echo $countryArr_array;
							 
							 
							
					
			$details='<table class="mailSummary active" border="1">
						
						<thead class="thead-inverse">
							<tr>
								<th>Fields</th>
								<th>Values</th>
							</tr>
							<tr>
								<td>Tagged By</td>
								<td id="td_addedby">'.$addedByName.'</td>
							</tr>
							<tr>
								<td>Batch Uploaded</td>
								<td id="td_created_date">'.$showMailBatchInfoDetails[0]->created_date.'</td>
							</tr>
							
							<tr>
								<td>Batch Name.</td>
								<td id="td_">'.$showMailBatchInfoDetails[0]->batch_name.'</td>
							</tr>
							<tr>
								<td>Batch ID.</td>
								<td id="td_batch_id">'.$showMailBatchInfoDetails[0]->batch_id.'</td>
							</tr>
							<tr>
								<td>Declared</td>
								<td id="td_total_number_mail">'.$showMailBatchInfoDetails[0]->total_number_mail.'</td>
							</tr>
							
							<tr>
								<td>Processed</td>
								<td id="td_Processed">'.$Processed.'</td>
							</tr>
							<tr>
								<td>Un-mailable</td>
								<td id="td_Un_mailable">'.$Un_mailable.'</td>
							</tr>
							
							<tr>
								<td>Discrepancy </td>
								<td id="td_Discrepancy">'.$Discrepancy.'</td>
							</tr>
							
							<tr>
								<td>Destination Countries</td>
								<td id="td_">'.$countryHtml.'</td>
							</tr>
							<tr>
								<td>Total Amount/Value($)</td>
								<td id="td_">'.$showMailBatchInfoDetails[0]->total_amount.'</td>
							</tr>
						</thead>
					</table>';
					echo $details;
					}
					if($type == 'Individual'){
						  
				$details='<table class="mailSummary active" border="1">
							<thead class="thead-inverse">
								
								<tr>
									<th>Fields</th>
									<th>Values</th>
								</tr>
								<tr>
									<td>Date Created</td>
									<td id="td_created_on">'.$showMailBatchInfoDetails[0]->created_on.'</td>
								</tr>
								<tr>
									<td>Tracking Number</td>
									<td id="td_tracking_number">'.$showMailBatchInfoDetails[0]->tracking_number.'</td>
								</tr>
								<tr>
									<td>Tagged By</td>
									<td id="td_addedby">'.$addedByName.'</td>
								</tr>
								<tr>
									<td>Total Weight</td>
									<td id="td_weight_kg">'.$showMailBatchInfoDetails[0]->weight_kg.'</td>
								</tr>
								
								<tr>
									<td>Amount</td>
									<td id="td_amount">'.$showMailBatchInfoDetails[0]->amount.'</td>
								</tr>
								<tr>
									<td>Country</td>
									<td id="td_country">'.$showMailBatchInfoDetails[0]->country.'</td>
								</tr>
								
	
							</thead>
						</table>';
						
						
						echo $details;
						
						
					}
					?>
			   
					</div>
				
				</div>
			</div>
		</div>
	</div>
</div>

			
<?php 
	}
		?>		
			 
			