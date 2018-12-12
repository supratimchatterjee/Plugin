<?php 
if(isset($_GET['trackingid'],$_GET['type'])){
	$type = trim($_GET['type']);
	$trackingId = trim($_GET['trackingid']);
	global $wpdb; 
	
  $table_mail_batch_remarks_info = $wpdb->prefix . "mail_batch_remarks_info";
		
		$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_batch_remarks_info." WHERE tracking_id='".$trackingId."'"
					);

			//print_r($result);		
	if(empty($result)){
		$tackinginfo_table_id = "";

	}else{
		$tackinginfo_table_id = $result[0]->id;
		echo $tackinginfo_table_id;

	}

	if(isset($_POST['remarksInfoSubmit'])){
		
		
		$current_user = wp_get_current_user();
		$currentUserID = $current_user->ID;
		$currentTime=date('Y-m-d H:i:s');
	
	
	       $remarksMessage=trim($_POST['remarksMessage']);
		 // die('test');
		  
		
		if(!empty($remarksMessage)){
			if(!empty($result)){
			
				  $wpdb->update(
							$table_mail_batch_remarks_info, 
							array( 
							
								'message'=>$remarksMessage,
								'updateby' => $currentUserID,
								'updateon' => $currentTime
								
							), 
							array(
								'id'=>$tackinginfo_table_id
								
							),
							array( 
									'%s',
									'%d', 
									'%s' 
									
									
								)
						);
				$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_batch_remarks_info." WHERE tracking_id='".$trackingId."'"
					);
					
					//echo $result[0]->message;
				
				}else{
				
				$wpdb->insert($table_mail_batch_remarks_info, array(
								'tracking_id' => $trackingId,
								'type' => $type,
								'message'=>$remarksMessage,
								'addedon' => $currentTime,
								'addedby' => $currentUserID
							),
								array( 
									'%s',
									'%s', 
									'%s', 
									'%s', 
									'%d'
									
								) 
				 ); 

					$result = $wpdb->get_results(
						"SELECT * FROM ".$table_mail_batch_remarks_info." WHERE tracking_id='".$trackingId."'"
					);
					//echo $result[0]->message;
			}	
			
			
				
				
			
			
		}
		  
		  
}




?>
<style>
.remarksInfoDiv{text-align:center;}
.col-lg-8{margin:0 auto;float:none;padding-top:50px;}
.error{color:red;}
</style>

<div id="wrapper">

	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                   <h1 class="page-header"> Remarks Info </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows batchuploadsection">
				<div class="sw-container tab-content remarksInfoDiv">
					<h3 class="border-bottom border-gray pb-2">Remarks Info Form</h3>
					<hr>
					<form method="post" id="remarkInfoForm">
						<div class="form-group">
								<div class="row tcenter">
									<div class="col-lg-8">
								
										<label>Message : </label>
										<textarea id="remarksMessage" name="remarksMessage"  class="form-control" placeholder="Enter Message" ><?php echo $result[0]->message; ?></textarea>
									</div>
									
								</div>
								
						</div>
						<hr>
						<div id="btnremarksInfoSubmit">
						<button class="btn btn-default sw-btn-next" name="remarksInfoSubmit" id="remarksInfoSubmit" value='save' type="submit">SAVE</button>
						</div>
						
					</form>
				</div>
			
			</div>
	</div>
</div>
		<script>
		     
			   jQuery(document).ready(function($){
				//***********form validation***************//
							$('#remarkInfoForm').submit(function(e) {
							/* e.preventDefault();
							return false;  */
							var errorcount = 0;
							var remarksMessage = $('#remarksMessage').val();
							$(".error").remove();
						
							if (remarksMessage.length < 1) {
							$('#remarksMessage').after('<span class="error">This field is required</span>');
							errorcount++;
							}
							if(errorcount > 0){
							
							e.preventDefault();
						
						}
		
					});
				});
		
		
		</script>
			
<?php }?>		