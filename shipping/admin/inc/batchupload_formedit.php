
<form id="uploadbatch_formedit" class="uploadbatch_formedit">
<input type="hidden" name="action" id="batch_uploadreview_action" value="batch_uploadreview">
<h3 class="border-bottom border-gray pb-2">Step 2 - Edit</h3>
<hr>
<div class="form-group">
	<div class="row">
		<div class="col-lg-12" style="overflow:scroll; height:600px;">
			<table class="table table-striped table-bordered" id="batch_upload_edit">
								<thead>
									<tr class="warning">
									<th >Tracking No.</th>
									<th>ADDRESSEE</th>
									<th>ADDRESS</th>
									<th>WEIGHT(grams)</th>
									<th>MAIL TYPE</th>
									<th>CONTENT</th>
									<th>DESCRIPTION</th>
									<th>DESTINATION COUNTRY (2D ISO)</th>
									<th>AMOUNT VALUE ($)</th>
								  </tr>
								</thead>
								<tbody>
								 							  
								</tbody>
							  </table>
		</div>
		
	</div>
</div>

<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end"><div class="btn-group mr-2 sw-btn-group pull-right" role="group"><button class="btn btn-default sw-btn-next" type="button" onclick="nextPreviousbatch('batchupload_form_edit');">Previous</button><button class="btn btn-default sw-btn-next" type="button" onclick="batchsummary();">Next</button></div></div>
</form>