<h3 class="border-bottom border-gray pb-2">Step 3 - Mail Summary</h3>
<hr>
<style>
.mailSummary th{padding-top: 20px;   text-align: center;   padding-bottom: 20px;}
.mailSummary td{padding-top: 20px;   text-align: center;   padding-bottom: 20px;}
#mailSummary_review.col-lg-8{float:none;margin:0 auto;}
</style>
<div class="form-group">
	<div class="row">
		<div class="col-lg-8" id="mailSummary_review">
		
		<table class="mailSummary" border="1">
		<thead class="thead-inverse">
			<tr>
				<th>Fields</th>
				<th>Values</th>
			</tr>
			<tr >
				<td>Country</td>
				<td id="td_country"></td>
			</tr>
			<tr >
				<td>Tracking Number</td>
				<td id="td_tracking_number"></td>
			</tr>
			<tr >
				<td>Mail Type</td>
				<td id="td_mail_type"></td>
			</tr>
			<tr >
				<td>Content</td>
				<td id="td_content_type"></td>
			</tr>
			<tr >
				<td>Addressee</td>
				<td id="td_addressee"></td>
			</tr>
			<tr >
				<td>Address 1</td>
				<td id="td_address1"></td>
			</tr>
			<tr >
				<td>Address 2</td>
				<td id="td_address2"></td>
			</tr>
			<tr >
				<td>Town / City</td>
				<td id="td_city"></td>
			</tr>
			<tr >
				<td>State / Province</td>
				<td id="td_state"></td>
			</tr>
			<tr >
				<td>Zip / Postal Code</td>
				<td id="td_zip_code"></td>
			</tr>
			
			<tr >
				<td>Description</td>
				<td id="td_description"></td>
			</tr>
			
			<tr >
				<td>Amount / Value($)</td>
				<td  id="td_amount"></td>
			</tr>
			
			<tr >
				<td>Weight(kilogram)</td>
				<td  id="td_weight_kg"></td>
			</tr>
			
			<tr >
				<td>Weight(gram)</td>
				<td id="td_weight_grm"></td>
			</tr>
			
			
		</thead>
		</table>
			
		</div>
	</div>
</div>

	<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end"><div class="btn-group mr-2 sw-btn-group pull-right" role="group">
					<button class="btn btn-default sw-btn-prev" type="button" onclick="nextPrevious('mailCreateForm')">Previous</button>
					<button class="btn btn-default sw-btn-next" type="button" onclick="nextPrevious('printmail')">Next</button></div></div>