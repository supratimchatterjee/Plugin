<style>
.error{color:red;}
</style>
<form id="uploadbatch_form" class="uploadbatch_form">
<input type="hidden" name="action" value="batch_upload">
<h3 class="border-bottom border-gray pb-2">Step 1 - upload your XLS or CSV file</h3>
<hr>
<div class="form-group">
	<div class="row">
		<div class="col-lg-8">
			<input type="file" class="required" name="batchupload" id="batchupload" style="display:inline-block;" >
			<button class="btn btn-info sw-btn-next" type="submit" >Upload</button>
		</div>
		
	</div>
</div>

<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end"><div class="btn-group mr-2 sw-btn-group pull-right" role="group"><button class="btn btn-default sw-btn-next" type="button" onclick="nextPreviousbatch('batchupload_form_edit');">Next</button></div></div>
</form>