<?php 
	/*
	* Shipping Front View
	*/

require_once('ch_frontAjax.php');
if(!function_exists('ch_script_front')){
	function ch_script_front(){
		// Javascript
		wp_register_script( 'ch_script', plugin_dir_url( __FILE__ ) . 'js/ch_script.js', '', '10.0.0', true );
		wp_enqueue_script('ch_script');

		// Css
		wp_register_style( 'ch_wp_front_css', plugin_dir_url(__FILE__) . 'css/ch_wp_front.css', false, '10.0.0' );
		wp_enqueue_style( 'ch_wp_front_css' );
	}
	add_action( 'wp_enqueue_scripts', 'ch_script_front');
}

if(!function_exists('ch_shpping_front')){
	function ch_shpping_front(){
		global $spDB; ?>
		<div class="ch_shpping">
			<div class="ch_shppingInner">
				<form id="ch_Form" class="form inline-form">
					<h4>Search Your Booking for Current Status</h4>
					<fieldset class="form-group">
						<label for="consignmentno">Consignment No</label>
						<input type="text" name="consignmentno" class="form-control" id="consignmentno" placeholder="Consignment No">
						<small class="text-muted"><small>Hit with your Consignment No</small></small>
					</fieldset>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>			
		</div>
		<div class="chResult mt30" style="display: none;">
			<div class="resultInner">
				<table class="table table-hover">
					<thead>
		               	<tr><th>Consignment No</th>
		               	<th>Origin</th>
		               	<th>Destination</th>
		               	<th>Pickup DateTime</th>
		               	<th>Status</th>
		               	<th>Full View</th>
		               	</tr>
	               	</thead>
	               	<tbody>

	               	</tbody>
	               	</table>
			</div>
		</div>
		<script type="text/javascript">
    	var ajaxurl = "<?= admin_url('admin-ajax.php'); ?>";
		</script>
		<?php }
	//add_shortcode( 'ch_shpping', 'ch_shpping_front' );
}
?>
