<?php
// Shipping Admin
if(!function_exists('ch_shipping_script'))
{
	function ch_shipping_script()
	{
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'admin_time_picker',  plugin_dir_url( __FILE__ ) . 'js/jquery.timepicker.min.js');
		wp_enqueue_script( 'admin_ch_script',  plugin_dir_url( __FILE__ ) . 'js/admin_ch_script.js');
		wp_localize_script( 'ajaxCh', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_register_style( 'ch_wp_admin_css', plugin_dir_url(__FILE__) . 'css/ch_adminCss.css', false, '1.0.0' );
		wp_enqueue_style( 'ch_wp_admin_css' );
		wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
		wp_enqueue_style( 'jquery-ui' );
		
		
		wp_enqueue_script( 'jueryuljs',  'https://code.jquery.com/ui/1.12.1/jquery-ui.js');
		
		wp_register_style('bootstrap-ui', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css');
		wp_enqueue_style( 'bootstrap-ui' );
		
		wp_register_style('sb-admin-2', plugin_dir_url(__FILE__) . 'css/sb-admin-2.css');
		wp_enqueue_style( 'sb-admin-2' );
		
		wp_register_style('smart_wizard', plugin_dir_url(__FILE__) . 'css/smart_wizard.css');
		wp_enqueue_style( 'smart_wizard' );
		
		wp_register_style('smart_wizard_theme_arrows', plugin_dir_url(__FILE__) . 'css/smart_wizard_theme_arrows.css');
		wp_enqueue_style( 'smart_wizard_theme_arrows' );
		
		 
		
		wp_register_style('font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.min.css');
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_script( 'validatejs',  plugin_dir_url( __FILE__ ) . 'js/validate.js');
		
   
   
	
		wp_register_style( 'ch_timeKiper_css', plugin_dir_url(__FILE__) . 'css/jquery.timepicker.css', false, '1.1.0' );
		wp_enqueue_style( 'ch_timeKiper_css' );
		
		wp_register_style('custom-css', plugin_dir_url(__FILE__) . 'css/custom-css.css');
		wp_enqueue_style( 'custom-css' );
	}
	add_action( 'admin_enqueue_scripts', 'ch_shipping_script' );
}



/*
* Admin Menu

*/
if(!function_exists('ch_admin_menu'))
{
	add_action( 'admin_menu', 'ch_admin_menu' );
	function ch_admin_menu()
	{
		$icon_url = plugin_dir_url( __FILE__) . 'img/delivery.png';	
		//add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )
		add_menu_page( 'Shipping', 'Shipping ', 'shipping_overview', 'shipping', 'ch_shipping_overview', $icon_url);		
		add_submenu_page( 'shipping', 'Mail Creation', 'Mail Creation','shipping_mail_creation', 'mail_creation','mail_creation');
		add_submenu_page( 'shipping', 'Mail Process', 'Mail Process','shipping_mail_process', 'mail_process','mail_process');
		add_submenu_page( 'shipping', 'Tracking', 'Tracking','shipping_tracking', 'tracking','tracking');
		add_submenu_page( 'shipping', 'Accounting', 'Accounting','shipping_accounting', 'accounting','accounting');		
		add_submenu_page( 'shipping', 'Transactions', 'Transactions','shipping_transactions', 'transactions','transactions');
		
		$user = wp_get_current_user();
		
		$role = ( array ) $user->roles;
		//print_r($role);
		//echo $role[0];
		$menuname="Reports";
		if($role[0]=="client"){
			$menuname="Transactions";
		}
		add_submenu_page( 'shipping', $menuname, $menuname,'shipping_reports', 'shipping_reports','shipping_reports');
		
		
		add_submenu_page( null, 'Batch Upload', 'Batch Upload','shipping_mail_creation', 'batch_upload','batch_upload');
		add_submenu_page( null, 'Tracking Info', 'Tracking Info','shipping_transactions', 'tracking_info','tracking_info');
		add_submenu_page( null, 'Upload Invoice', 'Upload Invoice','shipping_transactions', 'upload_invoice','upload_invoice');
		
		add_submenu_page( null, 'Remarks Info', 'Remarks Info','shipping_transactions', 'remarks_info','remarks_info');
		add_submenu_page( null, 'Details', 'Details','shipping_transactions', 'details','details');
		add_submenu_page( null, 'Cert Of Mail', 'Cert Of Mail','shipping_transactions', 'cert_of_email','cert_of_email');
		
		add_submenu_page( null, 'View Cert Of Mail', 'Cert Of Mail','shipping_reports', 'view_cert_of_email','view_cert_of_email');
		add_submenu_page( null, 'View Invoice', 'Upload Invoice','shipping_reports', 'view_upload_invoice','view_upload_invoice');
		add_submenu_page( null, 'View Details', 'View Details','shipping_reports', 'view_details','view_details');
	}
}

function shipping_reports(){

	require_once('inc/reports.php');

}

function cert_of_email(){


?>
	<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cert of Mail</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows">
            
			
            <div class="sw-container tab-content">
                
				
				<div id="uploadinvoice" class="tab-pane step-content1 active" >
                    <?php require_once('inc/upload_cert_of_mail.php'); ?>
                </div>
				
				
            </div>
			
			
        </div>
        
		<?php
}

function view_cert_of_email(){


?>
	<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cert of Mail</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows">
            
			
            <div class="sw-container tab-content">
                
				
				<div id="uploadinvoice" class="tab-pane step-content1 active" >
                    <?php require_once('inc/upload_cert_of_mail.php'); ?>
                </div>
				
				
            </div>
			
			
        </div>
        
		<?php
}

function view_upload_invoice(){
	//
	?>
	<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">View Invoice</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows">
            
			
            <div class="sw-container tab-content">
                
				
				<div id="uploadinvoice" class="tab-pane step-content1 active" >
                    <?php require_once('inc/upload_invoice.php'); ?>
                </div>
				
				
            </div>
			
			
        </div>
		<?php
}

function upload_invoice(){
	//
	?>
	<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Upload Invoice</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows">
            
			
            <div class="sw-container tab-content">
                
				
				<div id="uploadinvoice" class="tab-pane step-content1 active" >
                    <?php require_once('inc/upload_invoice.php'); ?>
                </div>
				
				
            </div>
			
			
        </div>
		<?php
}
function tracking(){

	require_once('inc/tracking.php');

}

function transactions(){
	
	require_once('inc/transactions.php');
	
}
function accounting(){
	
	require_once('inc/accounting.php');
	
}

function tracking_info(){
	
	require_once('inc/tracking_info.php');
	
}
function remarks_info(){
	
	require_once('inc/remarks_info.php');
	
}
function details(){
	
	require_once('inc/details.php');
	
}

function view_details(){
	
	require_once('inc/details.php');
	
}





function mail_process(){

//require_once('inc/mail_process.php');
?>

<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Mail Process</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows">
            <ul class="nav nav-tabs step-anchor">
                <li class="nav-item active"><a href="#step-1" class="nav-link">Step 1<br><small>Choose Client/Batch</small></a></li>
                <li class="nav-item "><a href="#step-2" class="nav-link">Step 2<br><small>Tag</small></a></li>
                <li class="nav-item"><a href="#step-3" class="nav-link">Step 3<br><small>Summary</small></a></li>
            </ul>
			
            <div class="sw-container tab-content" style="padding-right:0;">
			
			
			<?php require_once('inc/mail_process.php'); ?>
			<?php require_once('inc/mail_process_tag.php'); ?>
			<?php require_once('inc/mail_process_tag_summary.php'); ?>
			
        </div>
        </div>
		</div>
        </div>
        <!-- /#page-wrapper -->
<?php

}

function ch_shipping_overview(){


?>

<?php require_once('inc/overview.php'); ?>


<?php



}

function batch_upload()
	{
	ob_start();
	global $spDB; ?>
<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                   <h1 class="page-header"> Batch Upload </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows batchuploadsection">
            <ul class="nav nav-tabs step-anchor">               
				
				<li class="nav-item active batchupload_form"><a class="nav-link" href="#batchupload_form" class="active">Step 1- Upload</a></li>
				<li class="nav-item batchupload_form_edit"><a class="nav-link" href="#batchupload_form_edit">Step 2- Edit</a></li>
				<li class="nav-item batchupload_form_confirm"><a class="nav-link" href="#batchupload_form_confirm">Step 3- Confirm</a></li>
				<li class="nav-item batchupload_form_print"><a class="nav-link" href="#batchupload_form_print">Step 4- Print</a></li>
            </ul>
			
            <div class="sw-container tab-content ">
              
				<div id="batchupload_form" class="tab-pane step-content" style="display:block;">
                    <?php require_once('inc/batchupload_form.php'); ?>
                </div>
				
				<div id="batchupload_form_edit" class="tab-pane step-content" >
                    <?php require_once('inc/batchupload_formedit.php'); ?>
                </div>
				
				<div id="batchupload_form_confirm" class="tab-pane step-content" >
                    <?php require_once('inc/batchupload_formreview.php'); ?>
                </div>
				
				<div id="batchupload_form_print" class="tab-pane step-content" >
                    <?php require_once('inc/batch_print.php'); ?>
                </div>
				
				
            </div>
			
			
        </div>
<?php }

function mail_creation()
	{
	ob_start();
	global $spDB; ?>
<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="<?php echo admin_url('admin.php?page=mail_creation');?>">Individual</a> | <a href="<?php echo admin_url('admin.php?page=batch_upload');?>">Batch Upload</a></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div id="smartwizard" class="sw-main sw-theme-arrows">
            <ul class="nav nav-tabs step-anchor">               
				
				<li class="nav-item active destinationcountry"><a class="nav-link" href="#destinationcountry" class="active">Destination Country</a></li>
				<li class="nav-item mailCreateForm"><a class="nav-link" href="#mailCreateForm">Mail Details</a></li>
				<li class="nav-item mailSummary"><a class="nav-link" href="#mailSummary">Summary</a></li>
				<li class="nav-item printmail"><a class="nav-link" href="#printmail">Print Manifest</a></li>
            </ul>
			
            <div class="sw-container tab-content">
                <form id="mail_creation_form" name="mail_creation_form">
				<input type="hidden" name="action" id="mail_action" value="mail_create_save">
				<div id="destinationcountry" class="tab-pane step-content" style="display:block;">
                    <?php require_once('inc/mail_country_form.php'); ?>
                </div>
				
				<div id="mailCreateForm" class="tab-pane step-content" >
                    <?php require_once('inc/mail_create_form.php'); ?>
                </div>
				</form>
				<div id="mailSummary" class="tab-pane step-content" >
                    <?php require_once('inc/mail_summery_form.php'); ?>
                </div>
				
				<div id="printmail" class="tab-pane step-content" >
                    <?php require_once('inc/mail_print.php'); ?>
                </div>
				
				
            </div>
			
			
        </div>
<?php }
/*
* Admin Action Page
*/
if(!function_exists('ch_shipping_options'))
{
	function ch_shipping_options()
	{
 }
}
?>