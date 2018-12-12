<?php
$page = trim($_GET['page']);
if(isset($_GET['trackingid'],$_GET['type'])){
	$type = trim($_GET['type']);
	$trackingid = trim($_GET['trackingid']);
	global $wpdb;
	$tableName = $wpdb->prefix."upload_cert_of_mail";
	$currUserId = get_current_user_id();
	
	$results = $wpdb->get_results( "SELECT * FROM ".$tableName." WHERE tracking_id ='".$trackingid."'", OBJECT );
	if(empty($results)){
		$invoice_table_id = "";
		$invovice_table_url = "";
	}else{
		$invoice_table_id = $results[0]->id;
		$invovice_table_url = $results[0]->cert_url;
	}
	if(!empty($type) && !empty($trackingid)){
					if ( 
			isset( $_POST['__cert_upload_nonce'], $_FILES['__cert_upload'],$_GET['trackingid'],$_GET['type']) 
			&& wp_verify_nonce( $_POST['__cert_upload_nonce'], '__cert_upload' )
			
		) {
			// The nonce was valid and the user has the capabilities, it is safe to continue.

			// These files need to be included as dependencies when on the front end.
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			
			// Let WordPress handle the upload.
			// Remember, 'my_image_upload' is the name of our file input in our form above.
			$attachment_id = media_handle_upload( '__cert_upload', 0 );
			
			if ( is_wp_error( $attachment_id ) ) {
				
				echo " <div class='errorshow'>There was an error uploading the image.</div>";
			} else {
				//die;	
				$cert_url = wp_get_attachment_url( $attachment_id );
				$invovice_table_url = $cert_url;
				if(empty($invoice_table_id)){
						
						$wpdb->insert( 
						$tableName, 
						array( 
							'cert_url' => $cert_url, 
							'tracking_id' => $trackingid,
							'type' => $type,
							'added_by' => $currUserId,
							'create_date' => current_time('mysql', 1) 
						), 
						array( 
							'%s',
							'%s',
							'%s',
							'%d',
							'%s'
						) 
					);
				}else{
						
						$wpdb->update( 
						$tableName, 
						array( 
							'cert_url' => $cert_url,
							'updated_by' => $currUserId,
							'update_date' => current_time('mysql', 1) 
						), 
						array( 'id' => $invoice_table_id ),
						array(
							'%s',
							'%d',
							'%s'
						) 
					);
				}
				
				// The image was uploaded successfully!
			}

		}

		?>
		<style>
		.error{color:red;}
		.errorshow{color:red;text-align:center}
		.tcenter{text-align:center;}
		.col-lg-8{margin:0 auto;float:none;padding-top:50px;}
		.uploaded {margin-bottom:50px;}
		</style>
	
		<form id="cert_upload_form" class="uploadbatch_form" enctype="multipart/form-data" method="post" action="" >
		<input type="hidden" name="post_id" id="post_id" value="55" />
			<?php wp_nonce_field( '__cert_upload', '__cert_upload_nonce' ); ?>
			
	
		<h3 class="border-bottom border-gray pb-2">Step 1 - Upload Cert</h3>
		<hr>
		<div class="form-group">
			<div class="row tcenter" >
				<div class="col-lg-8">
				<?php 
			if(!empty($invovice_table_url)){
				//echo '<a href="'.$invovice_table_url.'" target="_blank" class="uploaded">'.$invovice_table_url.'</a>';
				
				echo '<iframe src="'.$invovice_table_url.'" style="width: 100%;height: 400px;border: none;" class="uploaded"></iframe>';
			} 
		?>			
			<?php
				//echo $page;
				if( $page !="view_cert_of_email"){
				?>
					<input type="file" class="required" name="__cert_upload" id="__cert_upload" style="display:inline-block;" >
					<button class="btn btn-info sw-btn-next" type="submit" >Upload</button>
					<?php
				}
				?>	
				</div>
				
			</div>
		</div>
		</form>
<?php
	}
	
}
