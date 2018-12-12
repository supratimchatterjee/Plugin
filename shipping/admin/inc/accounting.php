<style>
.invoiceHeading{text-align:center;}

</style>


<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> Invoice Details  </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
		<div id="InvoiceDiv">
			<table class="table table-bordered table-striped transaction-table">
				
				<tr class="thead-inverse">
					
					<th width="25%" class="invoiceHeading">Batch No./Tracking No.</th>
					<th width="25%" class="invoiceHeading">Type</th>
					<th width="25%" class="invoiceHeading">Invoice Uploaded Date</th>
					<th width="25%" class="invoiceHeading">Actions</th>
				</tr>
				
				<?php 
				$show_upload_invoice_Details=show_upload_invoice_Details();
				$details='';
				//echo"<pre>";
				//print_r($show_upload_invoice_Details[0]);
				//die();
				foreach($show_upload_invoice_Details as $show_upload_invoice_DetailsKey => $show_upload_invoice_DetailsValue){
					//echo $show_upload_invoice_Details[$show_upload_invoice_DetailsKey]->tracking_id;
					//die();
				$details.='<tr>
							<td>'.$show_upload_invoice_Details[$show_upload_invoice_DetailsKey]->tracking_id.'</td>
							<td>'.$show_upload_invoice_Details[$show_upload_invoice_DetailsKey]->type.'</td> 
							<td>'.$show_upload_invoice_Details[$show_upload_invoice_DetailsKey]->create_date.'</td>
							<td><a href="'.$show_upload_invoice_Details[$show_upload_invoice_DetailsKey]->invoce_url.'"><img src="'.plugins_url("shipping/admin").'/images/icon-details.png"></a></td>
						</tr>';
					
				}
				echo $details;
				?>
			</table>
		</div>		
			
		
</div>
    