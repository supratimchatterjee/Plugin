<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Transactions</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="transaction-icons">
				<div class="row">
					<div class="col-sm-2">
						<img src="<?php echo plugins_url('shipping/admin');?>/images/icon-details.png"><br>
						Details
					</div>
					<div class="col-sm-2 col-half-offset">
						<img src="<?php echo plugins_url('shipping/admin');?>/images/icon-invoice.png"><br>
						Invoice
					</div>
					<div class="col-sm-2 col-half-offset">
						<img src="<?php echo plugins_url('shipping/admin');?>/images/icon-cert-mail.png"><br>
						Cert of Mail
					</div>
					
				</div>
			</div>
			<?php //echo admin_url()."admin.php?page=tracking_info&trackingid=12454";
			       
			
			
			?>
			<div style="padding-bottom: 10px;>
				<label class="radio-inline">
				  <input type="radio" name="choosetrackingoption" value="Individual" id="Individual" checked>Individual
				</label>
				<label class="radio-inline">
				  <input type="radio" name="choosetrackingoption" value="Batch" id="Batch" >Batch
				</label>
			</div>
		<div id="batchDiv" style="display:none;">
			<table class="table table-bordered table-striped transaction-table">
				<tr class="thead-inverse">
					<th width="13%" class="text-center">Batch Name</th>
					<th width="15%" class="text-center">Batch No.</th>
					<th width="13%" class="text-center">Total Mails</th>
					<th width="13%" class="text-center">Total Weight(g)</th>
					<th width="13%" class="text-center">Total Destination Countries</th>
					<th width="13%" class="text-center">Total Amount/values($)</th>
					<th width="20%" class="text-center">Actions</th>
				</tr>
				
				<?php $transactionsBatchInfo_Details=transactionsBatchInfo_DetailsForCLient();
				  	  //$current_user = wp_get_current_user();
					 //  $userdata = get_userdata( $current_user->ID);
				  foreach($transactionsBatchInfo_Details as $transactionsBatchInfo_DetailsValue){
						$batchID=$transactionsBatchInfo_DetailsValue->batch_id;
						$batch_upload_by=$transactionsBatchInfo_DetailsValue->batch_upload_by;
						//$userdata = get_userdata($batch_upload_by);
						
				?>
				<tr>
					
					<td><?php echo $transactionsBatchInfo_DetailsValue->batch_name;?></td>
					<td><?php echo $batchID; ?></td>
				<td><?php echo getTaggedMailNumberInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><?php echo getTaggedMailWeightInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><?php echo getTaggedMailCountryInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><?php echo getTaggedMailAmountInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><a href="<?php echo admin_url()."admin.php?page=view_details&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-details.png"></a> <a href="<?php echo admin_url()."admin.php?page=view_upload_invoice&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-invoice.png"></a>  <a href="<?php echo admin_url()."admin.php?page=view_cert_of_email&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-cert-mail.png"></a></td>
				</tr>
				  <?php } ?>
				
			</table>
			</div>		
			<div id="individualDiv" >
			<table class="table table-bordered table-striped transaction-table">
				<tr class="thead-inverse">
					<th width="14%" class="text-center">Date Created</th>
					<th width="14%" class="text-center">Tracking No.</th>
					<th width="14%" class="text-center">Weight(g)</th>
					<th width="13%" class="text-center">Country</th>
					<th width="13%" class="text-center">Amount($)</th>
					<th width="16%" class="text-center">Actions</th>
				</tr>
				
				<?php $transactionsIndividualInfo_Details=transactionsIndividualInfo_DetailstClient();
				  	 // $current_user = wp_get_current_user();
					   //$userdata = get_userdata( $current_user->ID);
				  foreach($transactionsIndividualInfo_Details as $transactionsIndividualInfo_DetailsValue){
					  
					  $individualID=$transactionsIndividualInfo_DetailsValue->tracking_number;
					  $created_by=$transactionsIndividualInfo_DetailsValue->created_by;
					  $userdata = get_userdata($created_by);
					  if(!empty($transactionsBatchInfo_DetailsValue->countryCount)){
				?>
				<tr>
					<td><?php echo date('Y-m-d',strtotime($transactionsIndividualInfo_DetailsValue->created_on)); ?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->tracking_number;?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->weight_grm;?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->country;?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->amount;?></td>
					<td><a href="<?php echo admin_url()."admin.php?page=details&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-details.png"></a> <a href="<?php echo admin_url()."admin.php?page=view_upload_invoice&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-invoice.png"></a>  <a href="<?php echo admin_url()."admin.php?page=view_cert_of_email&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-cert-mail.png"></a></td>
				</tr>
					  <?php
						} 
					  } ?>
			</table>
		</div>
		
		</div>
       
	   <script>
		
		jQuery(document).ready(function($){
			
			//alert('heloo');
			jQuery('input[name="choosetrackingoption"]').click(function() {
				//alert( jQuery(this).val() );
				if(jQuery(this).val()=='Batch') {
					
					jQuery('#individualDiv').hide();
					jQuery('#batchDiv').show();
					
					}
				
				if(jQuery(this).val()=='Individual') {
					jQuery('#individualDiv').show();
					jQuery('#batchDiv').hide();
					}
				}); 
			
			});
			
		
	   
	   
	   </script>