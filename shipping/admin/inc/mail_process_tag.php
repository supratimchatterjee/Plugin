<div id="step-2" class="tab-pane step-content" style="display:none"  >

<!--<div class="btn-group mr-2 sw-btn-group-extra pull-right nexttag" role="group">
						<button class="btn btn-danger">Previoustag</button>
					</div>

<div class="btn-group mr-3 sw-btn-group pull-right" role="group">
	
	<button class="btn btn-default sw-btn-next" type="button">Next</button></div> 
</div>

<div class="btn-group mr-2 sw-btn-group-extra pull-right nexttag1" role="group">
						<button class="btn btn-danger">Save</button>
					</div>

<div class="btn-group mr-3 sw-btn-group pull-right" role="group">
	
	<button class="btn btn-default sw-btn-next" type="button">Cancel</button></div> 
</div> -->

<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end">
			<div class="btn-group mr-2 sw-btn-group-extra pull-right" role="group">
				<!--<button class="btn btn-primary" onclick="savetagging();">Save</button>-->
				<button class="btn btn-danger" onclick="window.location='<?php echo site_url('wp-admin/admin.php?page=mail_process')?>';">Cancel</button>
			</div>
			
			<div class="btn-group mr-2 sw-btn-group pull-right" role="group">
				<button class="btn btn-default sw-btn-prev" onclick="tag_step(1);" type="button">Previous</button>
				<button class="btn btn-default sw-btn-next" onclick="tag_summary();" type="button">Next</button>
				
			</div> 
</div> 




                    <h3 class="border-bottom border-gray pb-2" id="batchnumber"></h3>
                    <h3 class="border-bottom border-gray pb-2">Tag</h3>
					<div class="row">
						<div class="col-sm-6" style="height:400px;overflow:scroll;">
						<form class="tag_process_form">
						<input type="hidden" name="action" value="" id="tag_process_form_action_field">
							<table class="table table-striped table-bordered" id="mail_tagging_output">
								<thead class="thead-inverse">
								  <tr class="warning">
									<th width="85%">Tracking No.</th>
									<th>Remarks</th>
								  </tr>
								</thead>
								<tbody id="mail_tagging_output_tbody">
								  
								
								 
								  
								  
								</tbody>
							  </table>
							</form>  
						</div>
						<div class="col-sm-6">
							<div class="panel panel-default">
                        <div class="panel-heading">
                            Check details here                 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Tracking Number" id="tag_section_tracking_input_id" onkeyup="keyChecking()"> 
										
										
										
										
										
									</div>
								</div>
							</div>
							<button class="btn btn-success" onclick="tag_section_summary_button();">Tag</button>
							<hr>
							<h4>Details</h4>
							<div class="well summary" id="tag_section_summary">
								Mail details will show here
							</div>
					   </div>
                        <!-- /.panel-body -->
                    </div>
						</div>
					</div>
                </div>