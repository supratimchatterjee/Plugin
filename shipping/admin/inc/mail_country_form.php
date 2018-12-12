<?php 
global $wpdb;
//echo "SELECT * FROM $wpdb->shipping_country";
$country = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."shipping_country");
//print_r($country );
?>
<h3 class="border-bottom border-gray pb-2">Step 1 - Destination Country</h3>
<hr>
<div class="form-group">
	<div class="row">
		<div class="col-lg-3">
			<select class="form-control" id="country" name="country">
				<?php 
				foreach($country  as $countryData ){
				
				echo '<option value="'.$countryData->country_code.'" >'.$countryData->country_name.'</option>';
				}
				
				?>
				
				
			</select>
		</div>
	</div>
</div>

<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end"><div class="btn-group mr-2 sw-btn-group pull-right" role="group"><button class="btn btn-default sw-btn-next" type="button" onclick="nextPrevious('mailCreateForm')">Next</button></div></div>