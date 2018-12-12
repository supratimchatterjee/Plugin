<style>
.tracking-table td:first-child{background-color:transparent;}
#batch_mail_process_table{display:none;}
</style>
<script>


  jQuery( function() {
  
	jQuery('input[name="choosemailprocessoption"]').click(function() {
       // alert( jQuery(this).val() );
		
		if(jQuery(this).val()=='Batch') {
			
			jQuery('#batch_mail_process_table').show();
			jQuery('#individual_mail_process_table').hide();
		} else {
			jQuery('#batch_mail_process_table').hide();
			jQuery('#individual_mail_process_table').show();
		}
		});
		
		
			jQuery('input[name="individual_mail[]"]').click(function() {
				jQuery('input[name="individual_mail[]"]').not(this).prop('checked', false);
			});
			jQuery('input[name="batch_mail[]"]').click(function() {
				jQuery('input[name="batch_mail[]"]').not(this).prop('checked', false);
			});
		
  });
</script>

			
<div id="step-1" class="tab-pane step-content" style="display:block;">
<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end">
			<div class="btn-group mr-2 sw-btn-group-extra pull-right" role="group">
				<button class="btn btn-danger" onclick="window.location='<?php echo site_url('wp-admin/admin.php?page=mail_process')?>';">Cancel</button>
			</div>
			
			<div class="btn-group mr-2 sw-btn-group pull-right" role="group">
				<!--<button class="btn btn-default sw-btn-prev" type="button">Previous</button>-->
				<button class="btn btn-default sw-btn-next" type="button" onclick="tag_step(2);">Next</button>
				
			</div> 
</div> 
                    <h3 class="border-bottom border-gray pb-2">Choose Client/Batch</h3>
					<div class="tracking-table">
						<div class="row">
						<form class="mail_process_form">
						<input type="hidden" name="action" value="mail_process">
						<div class="col-sm-8">
						<label class="radio-inline">
								  <input type="radio" checked="" name="choosemailprocessoption" value="Individual" id="Individual">Individual
								</label>
						<label class="radio-inline">
								  <input type="radio" name="choosemailprocessoption" value="Batch">Batch
								</label>
<br>								
<br>								
							<table class="table table-striped table-bordered" id="individual_mail_process_table">
							
								<thead class="thead-inverse">
								  <tr >
								  <th></th>
									<th class="text-center">Client</th>
									<th class="text-center">Tracking Number</th>
									<th class="text-center">Total Amount / Value($)</th>
									<th class="text-center">Total Weight(gram)</th>
								  </tr>
								</thead>
								<tbody>
			<?php 
			$show_mail_process_data=show_mail_process_data();
				foreach($show_mail_process_data as $show_mail_process_dataValue){

						$userData = get_userdata($show_mail_process_dataValue->created_by);
			?>							 	
								  <tr>
									<td><input type="checkbox" name="individual_mail[]" value="<?php echo $show_mail_process_dataValue->tracking_number; ?>"></td>
									<td><?php echo $userData->display_name; ?></td>
									<td><?php echo $show_mail_process_dataValue->tracking_number; ?></td>
									<td><?php echo $show_mail_process_dataValue->amount; ?></td>
									<td><?php echo $show_mail_process_dataValue->weight_kg; ?></td>
								  </tr>
								  
			<?php } ?>
								  <tr>
								 
								</tbody>
							  </table>
							  
							  <table class="table table-striped table-bordered" id="batch_mail_process_table">
								<thead class="thead-inverse">
								  <tr class="warning">
								  <th></th>
									<th class="text-center">Client</th>
									<th class="text-center">Batch Id</th>
									<th class="text-center">Total Amount / Value($)</th>
									<th class="text-center">Total Weight(gram)</th>
								  </tr>
								</thead>
								<tbody>
								<?php 
								$show_mail_process_data=show_batchmail_process_data();
									foreach($show_mail_process_data as $show_mail_process_dataValue){

											$userData = get_userdata($show_mail_process_dataValue->batch_upload_by);
								?>							 	
													  <tr>
														<td><input type="checkbox" name="batch_mail[]" value="<?php echo $show_mail_process_dataValue->batch_id; ?>"></td>
														<td><?php echo $userData->display_name; ?></td>
														<td><?php echo $show_mail_process_dataValue->batch_id; ?></td>
														<td><?php echo $show_mail_process_dataValue->total_amount; ?></td>
														<td><?php echo $show_mail_process_dataValue->total_waight; ?></td>
													  </tr>
													  
								<?php } ?>
								  <tr>
								 
								</tbody>
							  </table>
							 </div>
						<div class="col-sm-4"><button class="btn btn-default" type="button" onclick="tagprocess();">Choose</button>
						</div>
						</form>
						</div>
						</div>
                </div>