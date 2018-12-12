<?php
$num =  mt_rand(10000000, 99999999);
 
 $digitCount = (str_split($num));
 $result = 0;
 $tmp = 0;
 $i=1;
 $trackingNumberLast = 0;
 $subTotal=0;
  if($num>0){
  
	 foreach($digitCount as $numDigit) {
     
		if( $i==1){
			$subTotal = $subTotal + $numDigit*8;
		}
		if( $i==2){
			$subTotal = $subTotal + $numDigit*6;
		}
		if( $i==3){
			$subTotal = $subTotal + $numDigit*4;
		}
		if( $i==4){
			$subTotal = $subTotal + $numDigit*2;
		}
		if( $i==5){
			$subTotal = $subTotal + $numDigit*3;
		}
		if( $i==6){
			$subTotal = $subTotal + $numDigit*5;
		}
		if( $i==7){
			$subTotal = $subTotal + $numDigit*9;
		}
		if( $i==8){
			$subTotal = $subTotal + $numDigit*7;
		}
		
		$i++;
	 }
    
	if($subTotal){
		 $reminder = $subTotal%11;
		
		$reminderDivide = 11-$reminder;
		
		if($reminderDivide>=0 && $reminderDivide<=9){
			$trackingNumberLast = $reminderDivide;
		}
		if($reminderDivide==10){
			$trackingNumberLast = 0;
		}
		if($reminderDivide==11){
			$trackingNumberLast = 5;
		}
	}
	
  }
	//echo '<br>';
  $trackingCode = 'RR'.$num.$trackingNumberLast.'PH'; 
	
	
?>
<h3 class="border-bottom border-gray pb-2">Step 2 - Mail Details</h3>
					<hr>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4">
								<label>Tracking Number</label>
								<input type="text" class="form-control" readonly id="tracking_number" name="tracking_number" value="<?php echo $trackingCode;?>"/>
							</div>
							<div class="col-lg-4">
								<label>Mail Type</label>
								<select class="form-control" id="mail_type" name="mail_type">
									<option>Registered</option>
									<option>Parcel</option>
									<option>Ordinary Mail</option>
									<option>EMS</option>
									<option>Express</option>
								</select>
							</div>
							<div class="col-lg-4">
								<label>Content</label>
								<select class="form-control" id="content_type" name="content_type">
									<option>Document</option>
									<option>Marchandise</option>
									<option>Gift</option>
									<option>Commerical Sample</option>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-4">
								<label>Addressee</label>
								<input type="text" class="form-control" id="addressee" name="addressee"/>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-4">
								<label>Address 1</label>
								<input type="text" class="form-control" id="address1" name="address1"/>
							</div>
							<div class="col-lg-4">
								<label>Address 2</label>
								<input type="text" class="form-control" id="address2" name="address2"/>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-4">
								<label>Town / City</label>
								<input type="text" class="form-control" id="city" name="city"/>
							</div>
							<div class="col-lg-4">
								<label>State / Province</label>
								<input type="text" class="form-control" id="state" name="state"/>
							</div>
							<div class="col-lg-4">
								<label>Zip / Postal Code</label>
								<input type="text" class="form-control" id="zip_code" name="zip_code"/>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-8">
								<label>Description</label>
								<input type="text" class="form-control" id="description" name="description"/>
							</div>
							<div class="col-lg-4">
								<label>Amount / Value($)</label>
								<input type="text" class="form-control" id="amount" name="amount"/>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-4">
								<label>Weight(kilogram)</label>
								<input type="text" class="form-control" id="weight_kg" name="weight_kg" oninput="weightConverter(this.value);" onchange="weightConverter(this.value);"/>
							</div>
							<div class="col-lg-4">
								<label>Weight(gram)</label>
								<input type="text" class="form-control" id="weight_grm" name="weight_grm"/>
							</div>
						</div>
					</div>
					
					<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end"><div class="btn-group mr-2 sw-btn-group pull-right" role="group">
					<button class="btn btn-default sw-btn-prev" type="button" onclick="nextPrevious('destinationcountry')">Previous</button>
					<button class="btn btn-default sw-btn-next" type="button" onclick="nextPrevious('mailSummary')">Next</button></div></div>