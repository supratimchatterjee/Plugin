


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
					<div class="col-sm-2 col-half-offset">
						<img src="<?php echo plugins_url('shipping/admin');?>/images/icon-tracking.png"><br>
						Tracking
					</div>
					<div class="col-sm-2 col-half-offset">
						<img src="<?php echo plugins_url('shipping/admin');?>/images/icon-remarks.png"><br>
						Remarks
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
					<th width="13%" class="text-center">Client</th>
					<th width="15%" class="text-center">Batch ID / Filename</th>
					<th width="13%" class="text-center">Total Mails</th>
					<th width="13%" class="text-center">Total Weight(g)</th>
					<th width="13%" class="text-center">Total Destination Countries</th>
					<th width="13%" class="text-center">Total Amount($)</th>
					<th width="20%" class="text-center">Actions</th>
				</tr>
				
				<?php $transactionsBatchInfo_Details=transactionsBatchInfo_Details();
					
					
					
					foreach($transactionsBatchInfo_Details as $transactionsBatchInfo_DetailsValue){
						$batchID=$transactionsBatchInfo_DetailsValue->batch_id;
						
						$batch_upload_by=$transactionsBatchInfo_DetailsValue->batch_upload_by;
					
						$userdata = get_userdata($batch_upload_by);
				
				
				    ?>
				     
				
				<tr>
					<td><?php echo strtoupper($userdata->display_name); ?></td>
					<td><?php echo $transactionsBatchInfo_DetailsValue->batch_name.' / '.$batchID;?></td>
					<td><?php echo getTaggedMailNumberInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><?php echo getTaggedMailWeightInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><?php echo getTaggedMailCountryInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><?php echo getTaggedMailAmountInBatch($transactionsBatchInfo_DetailsValue->batch_id);?></td>
					<td><a href="<?php echo admin_url()."admin.php?page=details&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-details.png"></a> <a href="<?php echo admin_url()."admin.php?page=upload_invoice&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-invoice.png"></a>  <a href="<?php echo admin_url()."admin.php?page=cert_of_email&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-cert-mail.png"></a><a href="<?php echo admin_url()."admin.php?page=tracking_info&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-tracking.png"></a> <a href="<?php echo admin_url()."admin.php?page=remarks_info&trackingid=".$batchID."&type=Batch";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-remarks.png"></a></td>
				</tr>
				 <?php
					
				 } 
				 
				 ?>
				
			</table>
			</div>
			<div id="individualDiv" >
			<table class="table table-bordered table-striped transaction-table">
				<tr class="thead-inverse">
					<th width="14%" class="text-center">Client</th>
					<th width="14%" class="text-center">Tracking No.</th>
					<th width="14%" class="text-center">Weight (g) </th>
					<th width="13%" class="text-center">Country </th>
					<th width="13%" class="text-center">Amount($)</th>
					<th width="16%" class="text-center">Actions</th>
				</tr>
				
				<?php $transactionsIndividualInfo_Details=transactionsIndividualInfo_Details();
				  	 
					//echo "<pre>";
					//print_r($transactionsIndividualInfo_Details);

				
				 foreach($transactionsIndividualInfo_Details as $transactionsIndividualInfo_DetailsValue){
					  
					  $individualID=$transactionsIndividualInfo_DetailsValue->tracking_number;
					  $created_by=$transactionsIndividualInfo_DetailsValue->created_by;
					  $userdata = get_userdata($created_by);
				?>
				<tr>
					<td><?php echo strtoupper($userdata->display_name); ?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->tracking_number;?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->weight_grm;?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->country;?></td>
					<td><?php echo $transactionsIndividualInfo_DetailsValue->amount;?></td>
					<td><a href="<?php echo admin_url()."admin.php?page=details&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-details.png"></a> <a href="<?php echo admin_url()."admin.php?page=upload_invoice&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-invoice.png"></a>  <a href="<?php echo admin_url()."admin.php?page=cert_of_email&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-cert-mail.png"></a><a href="<?php echo admin_url()."admin.php?page=tracking_info&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-tracking.png"></a> <a href="<?php echo admin_url()."admin.php?page=remarks_info&trackingid=".$individualID."&type=Individual";?>"><img src="<?php echo plugins_url('shipping/admin');?>/images/icon-remarks.png"></a></td>
				</tr>
				  <?php } ?>
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