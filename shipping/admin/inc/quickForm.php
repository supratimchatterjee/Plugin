<?php 
/*
* Quick Form
*/
?>

<form class="quickForm" id="quickForm">
	<div class="errorMessage"></div>
	<div class="successMessage"></div>
	<div class="formSection">
		<h4>Quick Form </h4>
		<div class="formGroup">
			<label for="tracking_number">Traking number: </label>
			<input type="text" value="" name="tracking_number" id="tracking_number" required="required">*
		</div>
		<div class="formGroup">
			<label for="origin">Origin: </label>
			<input type="text" value="" name="origin" id="origin" required="required">*
		</div>
		<div class="formGroup">
			<label for="destination">Destination: </label>
			<input type="text" value="" name="destination" id="destination" required="required">*
		</div>
		<div class="formGroup">
			<label for="weight">Weight: </label>
			<input type="number" value="" name="weight" id="weight"> (kg)
		</div>

		<div class="formGroup">
			<label for="charge">Charge: </label>
			<input type="text" value="" name="charge" id="charge">
		</div>
		<div class="formGroup">
			<label for="status">Status: </label>
			<select name="status" id="status">
				<option value="In Transit">In Transit</option>
			</select>
		</div>
	</div>
	<?php
			submit_button( 'Submit Shipping', 'primary', 'submit', true, array('id' => 'shippingSubmit') );
	?>
</form>
 