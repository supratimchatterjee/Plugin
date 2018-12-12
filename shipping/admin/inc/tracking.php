<?php 
	global $wpdb;
	$myrows = $wpdb->get_results( "SELECT tracking_number FROM ".$wpdb->prefix."mail_creation" );
	$tag="";
	foreach($myrows as $data){
		$tag = $tag.',"'.$data->tracking_number.'"';
	}
	$tag = trim($tag,',');
	
	$myrowsBatch = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."batch_creation group by batch_name" );
	$tagBatch="";
	foreach($myrowsBatch as $dataBatch){
		$tagBatch = $tagBatch.',"'.$dataBatch->batch_name.'"';
	}
	foreach($myrowsBatch as $dataBatch){
		$tagBatch = $tagBatch.',"'.$dataBatch->batch_id.'"';
	}
	$tagBatch = trim($tagBatch,',');
//echo $tag;
?>
<script>

  jQuery( function() {
    var availableTags = [<?php echo $tag; ?>];
    var availableBatchTags = [<?php echo $tagBatch; ?>];
	
    jQuery( "#tracking_code" ).autocomplete({
	  <?php if($choosetrackingoption=="" || $choosetrackingoption=='Individual') {	 ?>
      source: availableTags
	  <?php } ?>
	   <?php if($choosetrackingoption=='Batch') {	 ?>
      source: availableBatchTags
	  <?php } ?>
    });
	
	jQuery('input[name="choosetrackingoption"]').click(function() {
       // alert( jQuery(this).val() );
		
		if(jQuery(this).val()=='Batch') {
			jQuery( "#tracking_code" ).autocomplete({
			  source: availableBatchTags
			});
		}
		
		if(jQuery(this).val()=='Individual') {
			jQuery( "#tracking_code" ).autocomplete({
			  source: availableTags
			});
		}
	
    });
	
  } );
  
  
	
  </script>
  <style>
  td, th {
    padding: 10px;
}
.well.summary {
   height: 400px;
    overflow: scroll;
}
.greencolor{background-color:green !important;}

.YQContainerCss{margin-top: 15px;}
  </style>
<?php
$choosetrackingoption = trim($_REQUEST['choosetrackingoption']);
?>
    <div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tracking</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
							Please use tracking number for INDIVIDUAL or filename/id for BATCH
							
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<form action="<?php echo site_url('wp-admin/admin.php')?>" method="get">
						<input type="hidden" value="tracking" name="page">
							<div>
							   <label class="radio-inline">
								  <input type="radio" <?php if($choosetrackingoption=="" || $choosetrackingoption=='Individual') { echo 'checked';}?> name="choosetrackingoption" value="Individual" id="Individual">Individual
								</label>
								<label class="radio-inline">
								  <input type="radio" <?php if($choosetrackingoption=='Batch') { echo 'checked';}?> name="choosetrackingoption" value="Batch">Batch
								</label>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<input type="text" value="<?php echo $_GET['tracking_code'];?>" id="tracking_code" name="tracking_code" class="form-control"> 
									</div>
								</div>
							</div>
							<button class="btn btn-success" type="submit">Search</button>
							</form>
							<hr>
							<h4>Details</h4>
							<div class="well summary">
							
							<?php 
							$data="";
							$data="";
							if($_GET['tracking_code']!=""){
								
								if( $_GET['choosetrackingoption'] =='Individual' ){
								//echo "SELECT * FROM ".$wpdb->prefix."mail_creation where tracking_number='".$_GET['tracking_code']."' limit 1";
									$myrows = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."mail_creation where tracking_number='".$_GET['tracking_code']."' limit 1" );
									
									if($myrows){
									
									$data = '<table class="mailSummary" border="1">
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
									}else{
										
										$data="No data found";
									}
								} else {
								
									$myrowsbatch = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."batch_summary where batch_name='".$_GET['tracking_code']."' or batch_id='".$_GET['tracking_code']."'" );
									$amount = 0;
									$weight = 0;
									
									
									if($myrowsbatch){
									
									$data .= '<table class="table table-striped table-bordered" ><tbody class="thead-inverse">';
									$data .="<tr><td>Batch Name</td><td>".$myrowsbatch->batch_name."</td></tr>";
									$data .="<tr><td>Date & Time</td><td>".date('Y-m-d H:i:s')."</td></tr>";
									$data .="<tr><td>Total number of mails</td><td>".$myrowsbatch->total_number_mail."</td></tr>";
									$data .="<tr><td>Total Amount </td><td>".$myrowsbatch->total_amount."</td></tr>";
									$data .="<tr><td>Total weight </td><td>".$myrowsbatch->total_waight."</td></tr>";
									
									$data .= "</tbody></table>";
									
									}else{
										
										$data="No data found";
									}
								}
							
							}
							echo $data;
							?>
								
							</div>
					   </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                   
                </div>
            
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Tracking Details
                        </div>
                        <!-- /.panel-heading -->
						
						<?php 
			
						  if($choosetrackingoption=='Batch'){
							  
							  $tracking_code= $myrowsbatch->batch_name;
								$show_tracking_details = show_tracking_details($tracking_code, $choosetrackingoption);
							  
							  
						  }
						  
						  if($choosetrackingoption=='Individual'){
							  
								$tracking_code=$_GET['tracking_code'];
								$show_tracking_details = show_tracking_details($tracking_code, $choosetrackingoption);
							  
						  }
						  
						 
						
						
						?>
                        <div class="panel-body">
							<ul class="timeline">
								<li>
								
								 <?php 
									$tracking_code=$_GET['tracking_code'];
									$createdUserMail=createdUserMail($tracking_code ,$choosetrackingoption);

									//echo "<pre>";
									////print_r($createdUserMail);
									//echo $createdUserMail->created_on;
									
								 
								 ?>
								
								 <?php
										  if($createdUserMail->created_on!=""){
											  
											echo '<div class="timeline-badge greencolor ">';
										  } else {
											  
											echo '<div class="timeline-badge">' ;
										  }
									  ?>
								  <i class="fa fa-check"></i></div>
								  <div class="timeline-panel">
								  
								
								   
									<div class="timeline-heading">
										<?php if($choosetrackingoption == "Batch"){
											
											echo '<h4 class="timeline-title">Batch Uploaded</h4>';
										}elseif($choosetrackingoption == "Individual"){
											
											echo '<h4 class="timeline-title">Mail Created</h4>';
										}else{
											
											echo'<h4 class="timeline-title">Mail Created / Batch Uploaded</h4>';
										}
										?>
									  <!--<h4 class="timeline-title">Mail Created / Batch Uploaded</h4>-->
										<p>
											<small class="text-muted">
											<i class="">&nbsp 
												<b style="color:#cc5b19;font-size:18px;"><?php echo $createdUserMail->created_on; ?></b>
											</i>
											</small>
										</p>
									</div>
									<div class="timeline-body">
									   <p></p>
									  <?php 
									  //$current_user = wp_get_current_user();
											$userdata = get_userdata( $createdUserMail->created_by);
											
												if($choosetrackingoption == 'Batch'){
												echo '<p><small class="text-muted">Uploaded by:'.strtoupper($userdata->display_name).'</small></p>';
												}
												if($choosetrackingoption == 'Individual'){
												echo '<p><small class="text-muted">Created by:'.strtoupper($userdata->display_name).'</small></p>';
												}
											
								?>
									 <!--  <p><small class="text-muted">Created / Uploaded by:<?php// echo strtoupper($userdata->display_name); ?></small></p>-->
									</div>
								  </div>
								</li>
								<li class="timeline-inverted">
								 
								  <?php
										  if($show_tracking_details[0]->date_recived!=""){
											  
											echo '<div class="timeline-badge greencolor ">';
										  } else {
											  
											echo '<div class="timeline-badge">' ;
										  }
									  ?>
									  
									<i class="fa fa-save"></i>
								  </div>
								  <div class="timeline-panel">
									<div class="timeline-heading">
									  
									  <h4 class="timeline-title">Date Received</h4>
									  <p>
										  <small class="text-muted">
										  <i class="">&nbsp 
												<b style="color:#cc5b19;font-size:18px;"><?php echo $show_tracking_details[0]->date_recived; ?></b>
											</i> 
										  </small>
									  </p>
									</div>
									<div class="timeline-body">
									  <p></p>
									   <p><small class="text-muted">Received by:<?php echo $show_tracking_details[0]->received_by; ?></small></p>
									</div>
								  </div>
								</li>
								<li>
								 
								   <?php
										  if($show_tracking_details[0]->date_dispatched!=""){
											  
											echo '<div class="timeline-badge greencolor ">';
										  } else {
											  
											echo '<div class="timeline-badge">' ;
										  }
									  ?>
								  
								  
								  
								  <i class="fa fa-truck"></i></div>
								  <div class="timeline-panel">
									<div class="timeline-heading">
									  <h4 class="timeline-title">Date Dispatched</h4>
									  <p><small class="text-muted">
									    <i class="z">&nbsp 
												<b style="color:#cc5b19;font-size:18px;"><?php echo $show_tracking_details[0]->date_dispatched; ?></b>
											</i> 
									  </small>
									  </p>
									</div>
									<div class="timeline-body">
									  <p></p>
									   <p><small class="text-muted">Dispatch Details:<?php echo $show_tracking_details[0]->dispatch_details; ?></small></p>
									</div>
								  </div>
								</li>
								<li class="timeline-inverted">
								
								
								
								 <?php
										  if($show_tracking_details[0]->date_delivery!=""){
											  
											echo '<div class="timeline-badge greencolor ">';
										  } else {
											  
											echo '<div class="timeline-badge">' ;
										  }
									  ?>
								
								<i class="fa fa-bell"></i></div>
								  <div class="timeline-panel">
									<div class="timeline-heading">
									  <h4 class="timeline-title">Delivery Details</h4>
									   <p><small class="text-muted">
									   <i class="">&nbsp <b style="color:#cc5b19;font-size:18px;"> <?php echo $show_tracking_details[0]->date_delivery; ?></b></i>
									   </small></p>
									</div>
									<div class="timeline-body">
									  <p></p>
									   <p><small class="text-muted">Received by:<?php echo $show_tracking_details[0]->delivered_received_by; ?></small></p>
									</div>
								  </div>
								</li>
							</ul>
						
			
			
			</div>
			
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               
            </div>
		<div class="row" id="trackShippingDetails">
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
							Track your shipping details 
							
							
                        </div>
						<div class="panel-body">
						
							<!--Tracking number input box.-->
							<input type="text" id="YQNum" maxlength="50"/>
							<!--The button is used to call script method.-->
							<input type="button" class="btn btn-success" value="TRACK" onclick="doTrack()"/>
							<!--Container to display the tracking result.-->
							<div id="YQContainer" class="YQContainerCss"></div>


							<!--Script code can be put in the bottom of the page, wait until the page is loaded then execute.-->
							<script type="text/javascript" src="//www.17track.net/externalcall.js"></script>

							<!--Script code can be put in the bottom of the page, wait until the page is loaded then execute.-->
							<script type="text/javascript">
							function doTrack() {
								var num = document.getElementById("YQNum").value;
								if(num===""){
									alert("Enter your number."); 
									return;
								}
								YQV5.trackSingle({
									//Required, Specify the container ID of the carrier content.
									YQ_ContainerId:"YQContainer",
									//Optional, specify tracking result height, max height 800px, default is 560px.
									YQ_Height:560,
									//Optional, select carrier, default to auto identify.
									YQ_Fc:"0",
									//Optional, specify UI language, default language is automatically detected based on the browser settings.
									YQ_Lang:"en",
									//Required, specify the number needed to be tracked.
									YQ_Num:num
								});
							}
							</script>				
													
						
						
						</div>
                    </div>
                </div>
			</div>
		</div>
        <!-- /#page-wrapper -->

    </div>
	
	
	
	 <script>
		
		jQuery(document).ready(function($){
			 //alert('hshdlf');
			jQuery('input[name="choosetrackingoption"]').click(function() {
				
				//alert( jQuery(this).val() );
				if(jQuery(this).val()=='Batch') {
					
					jQuery('#trackShippingDetails').hide();
				}
				
				if(jQuery(this).val()=='Individual') {
					
					jQuery('#trackShippingDetails').show();
					
					}
				}); 
			
			});
			
		
	   
	   
	   </script>
	