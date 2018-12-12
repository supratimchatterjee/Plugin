<?php 
if(isset($_GET['trackingid'],$_GET['type'])){
	$type = trim($_GET['type']);
	$trackingId = trim($_GET['trackingid']);
	 global $wpdb; 
	
  $table_mail_tackinginfo = $wpdb->prefix . "mail_tackinginfo"; 
		
		$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='".$trackingId."'"
					);
		
  if(empty($result)){
		$tackinginfo_table_id = "";

	}else{
		$tackinginfo_table_id = $result[0]->id;

	}
 if(isset($_POST['trackingInfoSubmit'])){
	 
		$current_user = wp_get_current_user();
		$currentUserID = $current_user->ID;
		$currentTime=date('Y-m-d H:i:s');
		
		
		$createUploadedDate=$_POST['createUploadedDate'];
		$dateRecived=$_POST['dateRecived'];
		$dateDispatched=$_POST['dateDispatched'];
		$dateDelivery=$_POST['dateDelivery'];
		$receivedBy=$_POST['receivedBy'];
		$deliveredReceivedBy=$_POST['deliveredReceivedBy'];
		$dispatchedDetails=$_POST['dispatchedDetails'];
		$delivered_details=$_POST['delivery_details'];
		
		
	if(!empty($createUploadedDate) && !empty($dateRecived) && !empty($dateDispatched) && !empty($dateDelivery) && !empty($dispatchedDetails)){
		
			if(!empty($result)){
			
				  $wpdb->update(
							$table_mail_tackinginfo, 
							array( 
								'date_recived' => $dateRecived,
								'received_by' => $receivedBy,
								'date_dispatched' => $dateDispatched,
								'dispatch_details' => $dispatchedDetails,
								'date_delivery' => $dateDelivery,
								'delivered_details' => $delivered_details,
								'updateby' => $currentUserID,
								'updateon' => $currentTime
								
							), 
							array(
								'id'=>$tackinginfo_table_id
								
							),
							array( 
									'%s',
									'%s', 
									'%s', 
									'%s', 
									'%s', 
									'%s', 
									'%d',
									'%s'
									
								)
						);
				$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='".$trackingId."'"
					);
				
				}else{
				
				
				
				
				$wpdb->insert($table_mail_tackinginfo, array(
								'tracking_id' => $trackingId,
								'created_upload_date' => $createUploadedDate,
								'date_recived' => $dateRecived,
								'received_by' => $receivedBy,
								'date_dispatched' => $dateDispatched,
								'dispatch_details' => $dispatchedDetails,
								'date_delivery' => $dateDelivery,
								'delivered_details' => $delivered_details,
								'addedby' => $currentUserID,
								'addedon' => $currentTime,
								'type' => $type
								
							),
								array( 
									'%s',
									'%s', 
									'%s', 
									'%s', 
									'%s', 
									'%s', 
									'%s', 
									'%s', 
									'%d',
									'%s',
									'%s'
								) 
				 );

					$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_tackinginfo." WHERE tracking_id='".$trackingId."'"
					);
					
			
			
					
				
				
				
				
				
				
				
				
				
				
				
			}		
		
	}
		
	  
	 }




?>
<style>
.error{color:red;}
.batchuploadsection .trackingInfoDiv{padding:15px;}
</style>

<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                   <h1 class="page-header"> Tracking Info </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows batchuploadsection">
          
			
            <div class="sw-container tab-content trackingInfoDiv">
              
			<form method="post" id="TrackingInfoForm">
			<div class="form-group">
					<div class="row">
					
						<div class="col-lg-4">
						  <?php
						  
						  $createDate = showCreateDate_batch_individual($type,$trackingId);
						  
						  ?>
						  <?php if($type == 'Batch'){
							   echo'<label>Batch Uploaded</label>';
							   echo'<input readonly type="text" id="createUploadedDate" name="createUploadedDate"  class="form-control" placeholder="Enter Mail Created / Batch Uploaded" value="'.$createDate.'">';
							   }
							   if($type == 'Individual'){
								   //die('enter in individual');
								    echo'<label>Mail Created</label>';
									echo'<input readonly type="text" id="createUploadedDate" name="createUploadedDate"  class="form-control" placeholder="Enter Mail Created / Batch Uploaded" value="'.$createDate.'">';
								   
							   }?>
							<!--<label>Mail Created / Batch Uploaded</label>
							<input type="text" id="createUploadedDate" name="createUploadedDate"  class="form-control" placeholder="Enter Mail Created / Batch Uploaded" value="">-->
						</div>
					
						<div class="col-lg-4">
						 <?php 	
								if($type == 'Batch'){echo '<label>Uploaded by</label><br>';}
								if($type == 'Individual'){echo '<label>Created by</label><br>';}
						  ?>

							<?php 
							
							    $createdUserMail=createdUserMail($trackingId,$type);
							
							
								///$current_user = wp_get_current_user();
								$userdata = get_userdata( $createdUserMail->created_by);
								
							?>
							<label><?php echo strtoupper($userdata->display_name); ?></label>
						
						</div>
					</div>
			</div>
			<hr>
			<div class="form-group">
						<div class="row">
						
							<div class="col-lg-4">
								<label>Date Received</label>
								<input type="text" id="dateRecived" value="<?php echo $result[0]->date_recived; ?>" name="dateRecived" class="form-control" placeholder="Enter Date Received">
							</div>	
							<div class="col-lg-4">
								<label>Received by</label>
								
								<?php 
								
								$trackingInfo_Details=trackingInfo_Details();
								?>
								<select class="form-control" id="receivedBy" name="receivedBy">
								<?php 
								foreach($trackingInfo_Details as $trackingInfo_DetailsValue){
									
									if($result[0]->received_by == $trackingInfo_DetailsValue->display_name){
										
										echo '<option selected>'.$trackingInfo_DetailsValue->display_name.'</option>';  
										
									}else{
										
										echo '<option>'.$trackingInfo_DetailsValue->display_name.'</option>';  
										
									}
									  
									
								  }
								
								?>
									
								</select>
								
							</div>	
						</div>
			</div>
			<hr>
			<div class="form-group">
						<div class="row">
						<div class="col-lg-4">
								<label>Date Dispatched</label>
								<input type="text" id="dateDispatched" value="<?php echo $result[0]->date_dispatched
; ?>" name="dateDispatched" class="form-control" placeholder="Enter Date Dispatched">
							</div>	
							<div class="col-lg-4">
								<label>Dispatch Details</label>
								<input type="text" id="dispatchedDetails" value="<?php echo $result[0]->dispatch_details; ?>" name="dispatchedDetails" class="form-control">
							</div>
						</div>
			</div>
			<hr>
			<div class="form-group">
						<div class="row">
							<div class="col-lg-4">
								<label>Delivered</label>
								 <input type="text" id="dateDelivery"  value="<?php echo $result[0]->date_delivery; ?>" name="dateDelivery" class="form-control" placeholder="Enter Delivered ">
							</div>
							<div class="col-lg-4">
								<!--<label>Received by</label>-->
								<label>Delivery Details</label>
								<?php 
								
								$trackingInfo_Details=trackingInfo_Details();
								?>
								<!--<select class="form-control" id="deliveredReceivedBy" name="deliveredReceivedBy">
								<?php 
								//foreach($trackingInfo_Details as $trackingInfo_DetailsValue){
									
									//if($result[0]->delivered_received_by == $trackingInfo_DetailsValue->display_name){
										//echo '<option selected>'.$trackingInfo_DetailsValue->display_name.'</option>';  
										
									//}else{
										
										//echo '<option>'.$trackingInfo_DetailsValue->display_name.'</option>';  
										
									//}
									  
									
								 // }
								
								?>
									
								</select>-->
								<input type="text" id="delivery_details" name="delivery_details" value="<?php echo $result[0]->delivered_details; ?>" class="form-control" placeholder="Delivered Details" >
							</div>	
						</div>
			</div>
			<hr>
				
				<button class="btn btn-default sw-btn-next" name="trackingInfoSubmit" id="trackingInfoSubmit" value='save' type="submit">SAVE</button>
				
				
			</form>
			
			
			
			<!--<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end">
			
			<div class="btn-group mr-2 sw-btn-group pull-right" role="group"><button class="btn btn-default sw-btn-next" type="button" onclick="nextPrevious('mailCreateForm')">Next</button></div></div>-->
			</div>
			
			
		 </div>
	</div>
</div>
			
			
			 
			<script>
					jQuery(document).ready(function($){
					//******This code for pick date ******//	
						//$('#createUploadedDate').datepicker();
						$('#dateDispatched').datepicker({ dateFormat: 'yy-mm-dd' });
						
						$('#dateDelivery').datepicker({ dateFormat: 'yy-mm-dd' });
						$('#dateRecived').datepicker({ dateFormat: 'yy-mm-dd' });
						
						//***********form validation***************//
							$('#TrackingInfoForm').submit(function(e) {
							/* e.preventDefault();
							return false;  */
							var errorcount = 0;
							//var createUploadedDate = $('#createUploadedDate').val();
							var dateDispatched = $('#dateDispatched').val();
							var dateDelivery= $('#dateDelivery').val();
							var dateRecived = $('#dateRecived').val();
							var receivedBy = $('#receivedBy').val();
							var dispatchedDetails = $('#dispatchedDetails').val();
							//var deliveredReceivedBy = $('#deliveredReceivedBy').val();
							var delivery_details = $('#delivery_details').val();

							$(".error").remove();
							
							/* if (createUploadedDate.length < 1) {
							$('#createUploadedDate').after('<span class="error">This field is required</span>');
							errorcount++;
							} */
							
							if (dateDispatched.length < 1) {
							$('#dateDispatched').after('<span class="error">This field is required</span>');
							errorcount++;
							}
							
							if (dateRecived.length < 1) {
							$('#dateRecived').after('<span class="error">This field is required</span>');
							errorcount++;
							}
							
							if (receivedBy.length < 1) {
							$('#receivedBy').after('<span class="error">This field is required</span>');
							errorcount++;
							}
							
							if (dispatchedDetails.length < 1) {
							$('#dispatchedDetails').after('<span class="error">This field is required</span>');
							errorcount++;
							}
							
							if (delivery_details.length < 1) {
							$('#delivery_details').after('<span class="error">This field is required</span>');
							errorcount++;
							}
							
							if (dateDelivery.length < 1) {
							$('#dateDelivery').after('<span class="error">This field is required</span>');
							errorcount++;
							}
						if(errorcount > 0){
							
							e.preventDefault();
						
						}
							
							});
						
						
						
						
						//***********form validation End***************//
						 
						
						
						
						
						
						
						
						
					});
					
			</script>
<?php
 }
?>