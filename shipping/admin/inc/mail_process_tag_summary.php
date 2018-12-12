<div id="step-3" class="tab-pane step-content" style="display:none"  >


<div class="btn-toolbar  clearfix sw-toolbar sw-toolbar-top justify-content-end">
			<div class="btn-group mr-2 sw-btn-group-extra pull-right" role="group">
				<button class="btn btn-primary" onclick="savetagging();">Save</button>
				<button class="btn btn-danger" onclick="window.location='<?php echo site_url('wp-admin/admin.php?page=mail_process')?>';">Cancel</button>
			</div>
			
			<div class="btn-group mr-2 sw-btn-group pull-right" role="group">
				<button class="btn btn-default sw-btn-prev" onclick="tag_step(2);" type="button">Previous</button>
				
				
			</div> 
</div> 

                    <h3 class="border-bottom border-gray pb-2">Mail Summary</h3>
					<div class="row">
						<div class="col-sm-8" style="">
						
							
							  <table class="table table-striped table-bordered" id="mail_tagging_output_summary">
								
								</table>
							
						</div>
					
					</div>
                </div>