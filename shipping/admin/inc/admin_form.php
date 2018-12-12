<?php
	/*
	* Admin Form
	*/
if( isset($_GET['edit']) )
{
	global $spDB;
	$getData = $spDB->get_ch_shipping($_GET['edit']);
	$all = json_decode($getData->all);
	//echo json_decode($getData->all) . '<br/>';
	$edit = true;
}
elseif(isset($_GET['dvs']))
{
	global $spDB;
	$markedDelivered = $spDB->marked_delivered($_GET['dvs']);
	if($markedDelivered){ ?>
		<script>	
		jQuery(document).ready(function(){
			var base_url = jQuery('#base_url').val()
			window.location.href = base_url + 'admin.php?page=shipping#listShipment'; //Will take you to Google.
		});
		</script>";
	<?php }
}
else
{
	global $spDB;
	$singleQuick = $spDB->get_ch_quick($_GET['compete']);
	$comlt = true;
	$edit = false;
}
?>
<?php if(!$edit): ?>
<form class="<?= ($edit ? 'updateShipmentForm': 'addShipmentForm') ?>" id="<?= ($edit ? 'updateShipmentF': 'addShipmentF') ?>">
	<div class="errorMessage"></div>
	<div class="successMessage"></div>
	<div class="formSection">
		<div class="col-left half">
			<input type="reset" id="reset" class="button button-primary" name="reset" style="display: none;">
			<h4>Shipper Info</h4>
			<input type="hidden" id="base_url" name="base_url" value="<?= get_admin_url( null, '', 'admin' ); ?>">
			<div class="formGroup">
				<label for="shipperName">Shipper Name: </label>
				<input type="text" name="shipperName" id="shipperName" value="" required="required">*
			</div>
			<div class="formGroup">
				<label for="shipperTel">Phone: </label>
				<input type="tel" name="shipperTel"  value="" id="shipperTel" required="required">*
			</div>
			<div class="formGroup">
				<label for="shipperAddress">Address: </label>
				<input type="text"  value="" name="shipperAddress" id="shipperAddress">
			</div>
		</div>
		<div class="col-right half">
			<h4>Receiver Info</h4>
			<div class="formGroup">
				<label for="receiverName">Receiver Name: </label>
				<input type="text"  value="" name="receiverName" id="receiverName" required="required">*
			</div>
			<div class="formGroup">
				<label for="shipperTel">Phone: </label>
				<input type="tel"  value="" name="receiverTel" id="receiverTel" required="required">*
			</div>
			<div class="formGroup">
				<label for="shipperAddress">Address: </label>
				<input type="text"  value="" name="receiverAddress" id="receiverAddress">
			</div>
		</div>
	</div>
	<div class="formSection">
		<h4>Shipment info </h4>
		<div class="formGroup">
			<label for="consignmentNo">Consignment No: </label>
			<input type="text"  <?= ($edit ? 'readonly': '' ); ?> value="<?= ( $comlt ? $singleQuick->tracking_number : '' ); ?>" name="consignmentNo" id="consignmentNo" required="required">*
		</div>
		<div class="formGroup">
			<label for="typeOfShipment">Type of Shipment: </label>
			<select name="typeOfShipment" id="typeOfShipment">
				<option value="Documents">Documents</option>
				<option value="Parcel">Parcel</option>
				<option value="Sentiments">Sentiments</option>
			</select>
		</div>
		<div class="formGroup">
			<label for="weight">Weight: </label>
			<input type="number" value="<?= ( $comlt ? $singleQuick->weight : '' ); ?>" name="weight" id="weight"> (kg)
		</div>
		
		<div class="formGroup">
			<label for="invoiceNo">Invoice no: </label>
			<input type="text" name="invoiceNo" value="" id="invoiceNo">
		</div>
		
		<div class="formGroup">
			<label for="qnty">Qnty: </label>
			<input type="text" value="" name="qnty" id="qnty">
		</div>
		
		<div class="formGroup">
			<label for="totalFreight">Total freight: </label>
			<input type="text" value="" name="totalFreight" id="totalFreight">
		</div>
		<div class="formGroup">
			<label for="mode">Mode: </label>
			<select name="mode" id="mode">
				<option value="Air">Air</option>
				<option value="Road">Road</option>
				<option value="Train">Train</option>
				<option value="Sea">Sea</option>
			</select>
		</div>
		<div class="formGroup">
			<label for="deptTime">Dept time: </label>
			<input type="text"  value="" name="deptTime" id="deptTime">
		</div>
		<div class="formGroup">
			<label for="origin">Origin: </label>
			<input type="text" name="origin"  value="<?= ( $comlt ? $singleQuick->origin : '' ); ?>" id="origin" required="required">*
		</div>
		<div class="formGroup">
			<label for="origin">Destination: </label>
			<input type="text" name="destination"  value="<?= ( $comlt ? $singleQuick->destination : '' ); ?>" id="destination" required="required">*
		</div>
		
		<div class="formGroup">
			<label for="status">Status: </label>
			<select name="status" id="status">
				<?= ( $comlt ? '<option selected value="'.$singleQuick->status.'">'.$singleQuick->status.'</option>' : '' ); ?>
				<option value="In Transit">In Transit</option>
			</select>
		</div>
		<div class="formGroup">
			<label for="expectedDlyDate">Expected Dly Date: </label>
			<input type="text" onkeydown="return false" value="" name="expectedDlyDate" id="expectedDlyDate">
		</div>
		<div class="formGroup">
			<label for="comments">Comments: </label>
			<textarea name="comments" id="comments"></textarea>
		</div>
	</div>
	<?php
		if($edit)
		{
			submit_button( 'Update Shipping', 'primary', 'submit', true, array('id' => 'shippingUpdate') );
		}
		else
		{
			submit_button( 'Submit Shipping', 'primary', 'submit', true, array('id' => 'shippingSubmit') );
		}
	?>
</form>
<?php else: ?>
<div class="updateStatis pt50">
	<h3 class="mt30">Edit Shipment</h3>
	<div class="topTable">
		<table align="center" cellpadding="2" cellspacing="2" bgcolor="#EEEEEE">
			
			<tbody><tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1"><div align="center">
					<table width="80%" border="0" cellspacing="1" cellpadding="1">
						<tbody><tr>
							<td width="55%"><div align="left">Shipper Name : </div></td>
							<td width="45%"><div align="left">
								<?= $all->shipperName ?>
							</div></td>
						</tr>
						<tr>
							<td><div align="left">Shipper Phone : </div></td>
							<td><div align="left">
								<?= $all->shipperTel;  ?>
							</div></td>
						</tr>
						<tr>
							<td><div align="left">Shipper Address : </div></td>
							<td><div align="left">
								<?= $all->shipperAddress;  ?>
							</div></td>
						</tr>
					</tbody></table>
				</div></td>
				<td bgcolor="#FFFFFF" class="Partext1"><div align="center">
					<table width="80%" border="0" cellspacing="1" cellpadding="1">
						<tbody><tr>
							<td width="55%"><div align="left">Receiver Name : </div></td>
							<td width="45%"><div align="left">
								<?= $all->receiverName;  ?>
							</div></td>
						</tr>
						<tr>
							<td><div align="left">Receiver Phone : </div></td>
							<td><div align="left">
								<?= $all->receiverTel;  ?>
							</div></td>
						</tr>
						<tr>
							<td><div align="left">Receiver Address : </div></td>
							<td><div align="left">
								<?= $all->receiverAddress;  ?>
							</div></td>
						</tr>
					</tbody></table>
				</div></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1">&nbsp;</td>
				<td bgcolor="#FFFFFF" class="Partext1">&nbsp;</td>
			</tr>
			<tr>
				<td width="336" align="right" bgcolor="#FFFFFF" class="Partext1">Consignment No  : </td>
				<td width="394" bgcolor="#FFFFFF" class="Partext1">
				<?= $all->consignmentNo;  ?>      </td>
			</tr>
			<tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1">Ship Type  :</td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->typeOfShipment;  ?></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1">Weight :</td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->weight;  ?> (kg)</td>
			</tr>

			<tr>
				<td align="right" bgcolor="#F3F3F3" class="Partext1">Invoice no  :</td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->invoiceNo;  ?></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#F3F3F3" class="Partext1">Total freight : </td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->totalFreight; ?></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#F3F3F3" class="Partext1">Mode : </td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->mode; ?></td>
			</tr>
			
			<tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1">Origin : </td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->origin;  ?></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1">Destination :</td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->destination; ?></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1">Pickup Date/Time  :</td>
				<td bgcolor="#FFFFFF" class="Partext1">
				<?= date('d/m/Y', strtotime($getData->insert_date)); ?> <?php if(!empty( $getData->insert_time)){echo ' - ' .  date('H:i A', strtotime($getData->insert_time)); } ?></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#FFFFFF" class="Partext1">Status :</td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->status;  ?></td>
			</tr>
			
			<tr>
				<td align="right" valign="top" bgcolor="#FFFFFF" class="Partext1">Comments :</td>
				<td bgcolor="#FFFFFF" class="Partext1"><?= $all->comments;  ?></td>
			</tr>
		</tbody></table>
	</div>
	<div class="newStatusUpdate pt50 pt20">
		<table class="table">
			<thead>
				<tr>
					<th>Date</th>
					<th>Time</th>
					<th>Location</th>
					<th>Status</th>
					<th>Comments</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$allStatus = $spDB->get_shipping_status($_GET['edit']);
				foreach($allStatus as $status):
				?>
				<tr>
					<td><?= date('d/m/Y', strtotime($status->deliveryDate)); ?></td>
					<td><?= $status->deliveryTime; ?></td>
					<td><?= $status->newLocation;  ?></td>
					<td><?= $status->newStatus; ?></td>
					<td><?= $status->comments;  ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="updateForm pt50">
		<div class="errorMessage"></div>
		<div class="successMessage"></div>
		<h3 class="mt30">Update Shipment Status</h3>
		<div class="makeDelivered">
			<a class="deliverShipment pull-right" href="<?= get_admin_url( null, '', 'admin' ) . 'admin.php?page=shipping&dvs=' . $getData->consignmentNo; ?>">Marked this shipment as to be <span style="color:red;">Delivered</span></a>
		</div>
		
		<form method="POST" action="" id="updateShipmentF">
			<input type="hidden" name="consignmentNo" id="consignmentNo" value="<?= ($_GET['edit'])?$_GET['edit']:''; ?>">
			<div class="formGroup">
				<label for="newLocation">New Location: </label>
				<input type="text" name="newLocation" id="newLocation">
			</div>
			<div class="formGroup">
				<label for="newStatus">New Status: </label>
				<select name="newStatus" id="newStatus">
					<option>--Select New Status--</option>
					<option value="In Transit">In Transit</option>
					<option value="Landed">Landed</option>
					<option value="Delayed">Delayed</option>
					<option value="Completed">Completed</option>
					<option value="Onhold">Onhold</option>
				</select>
			</div>
			<div class="formGroup">
				<label for="deliveryTime">Delivery Time: </label>
				<input type="text" name="deliveryTime" id="deliveryTime">
			</div>
			<div class="formGroup">
				<label for="comments">Comments: </label>
				<textarea name="comments" id="comments"></textarea>
			</div>
			<?php submit_button( 'Update Shipping Status', 'primary', 'submit', true, array('id' => 'shippingUpdate') ); ?>
		</form>
	</div>
</div>
<input type="hidden" id="base_url" name="base_url" value="<?= get_admin_url( null, '', 'admin' ); ?>">
<?php endif; ?>