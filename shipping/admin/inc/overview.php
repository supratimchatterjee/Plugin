<?php
$time="";
if(isset( $_REQUEST['time'])){
	
		$time =$_REQUEST['time'];
}

			
$user = wp_get_current_user();
$role = ( array ) $user->roles;
		
?>
<style>
.clientperformance table.table tbody td{text-align:left;}
.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
.disabledbutton .panel-primary>.panel-heading {
    color: #fff;
    background-color: #e0e0e0;
    border-color: #e0e0e0;
}
a.disabledbutton {
    color: #e0e0e0;
}
</style>
<div id="wrapper">

	   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
				<?php if($role[0]=="supervisor" || $role[0]=="team"){ 
					echo ' <h1 class="page-header">All Client</h1>';
				} else {
				 echo ' <h1 class="page-header">Overview</h1>';
				}
				
				?>
                   
					<h5> 
						<a href="<?php echo admin_url('admin.php?page=shipping');?>">All<a> | 
						<a href="<?php echo admin_url('admin.php?page=shipping&time=week');?>"> 7 Days</a> |
						<a href="<?php echo admin_url('admin.php?page=shipping&time=month');?>">Month</a> | 
						<a href="<?php echo admin_url('admin.php?page=shipping&time=today');?>">Latest</a>
					</h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<?php $show_Good_Tag = show_GoodBed_Tag('good',$time);
			 $show_Bad_Tag = show_GoodBed_Tag('bad',$time);
			//echo "<pre>";
			
					//print_r($show_Good_Tag);
		//die();		
			 ?>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-envelope-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $show_Good_Tag;?></div>
                                    <div>Mail Sent</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="disabledbutton">
                            <div class="panel-footer">
                                <span class="pull-left ">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-exclamation-circle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $show_Bad_Tag;?></div>
                                    <div>Unmailable</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="disabledbutton">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 disabledbutton">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-credit-card fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								 <?php
									$show_batch_totalAmount = Show_batch_totalAmount($time);
									    if(!empty($show_batch_totalAmount)){
											
											$TotalAmount = $show_batch_totalAmount[0]->TotalAmount;
											
										}else{
											
											$TotalAmount = 0;
										}
									//print_r($show_batch_totalAmount);
								 
								 ?>
                                    <div class="huge"><?php echo $TotalAmount; ?></div>
                                    <div>Balance</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-bell fa-fw"></i> Recent Activity
							</div>
							<!-- /.panel-heading -->
							<div class="panel-body">
								<div class="recent-notification">
								<?php $show_activity = show_activity();
								 
								 foreach($show_activity  as $show_activityKey => $show_activityValue ){
									 

									 echo '<p>'.$show_activity[$show_activityKey]->activity.'</p>';
									  
									  
								  }
								                 
								?>
									
								</div>
							</div>
							<!-- /.panel-body -->
						</div>
					</div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mail Summary                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="" >
                            <table class="table table-striped">
								<thead>
								  <tr>
									<th class="text-center">#</th>
									<th class="text-center">Mail Type</th>
									<th class="text-center">Count</th>
								  </tr>
								</thead>
								<tbody>
								  <tr>
									<td>1</td>
									<td>Registered Mail</td>
									<?php $resultCount = mail_summary_count('Registered',$time); ?>
									  
									<td><?php echo $resultCount; ?></td>
								  </tr>
								  <tr>
									<td>2</td>
									<td>Parcel</td>
									<?php $resultCount = mail_summary_count('Parcel',$time); ?>
									<td><?php echo $resultCount; ?></td>
								  </tr>
								  <tr>
									<td>3</td>
									<td>EMS</td>
									<?php $resultCount = mail_summary_count('EMS',$time); ?>
									<td><?php echo $resultCount; ?></td>
								  </tr>
								   <tr>
									<td>4</td>
									<td>Ordinary Mail</td>
									<?php $resultCount = mail_summary_count('Ordinary Mail',$time); ?>
									<td><?php echo $resultCount; ?></td>
								  </tr>
								  <tr>
									<td>5</td>
									<td>Express</td>
									<?php $resultCount = mail_summary_count('Express',$time); ?>
									<td><?php echo $resultCount; ?></td>
								  </tr>
								</tbody>
							  </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                   
                </div>
               
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Mail Destination
                        </div>
                        <!-- panel-heading -->
                        <div class="panel-body" style="height: 233px; overflow: scroll;">
                           <table class="table table-striped">
								<thead>
								  <tr>
									<th class="text-center">#</th>
									<th class="text-center">Country</th>
									<th class="text-center">Count</th>
								  </tr>
								</thead>
								
								<tbody>
								
								<?php
								//$colorarry=array('success','warning','info','danger');
								  
								$a=1;
								$b=2;
								$c=3;
								$d=4;
								
								$count=1;
								// echo "----".$time;
								
								$country_group=country_group_by($time); 
								//echo "<pre>";
								//print_r($country_group);
								//die('test');
								foreach($country_group as $keyB => $country_groupValue){
								   if($a==$count){
									   $a=$a+4;
								?>
								<tr class="success">
									<td><?php echo $count; ?></td>
									<td><?php echo $keyB; ?></td>
									<td><?php echo $country_groupValue; ?></td>
								
								</tr>
									   
								<?php
									}
									  if($b==$count){
										  $b=$b+4;
								?>
								<tr class="info">
									<td><?php echo $count; ?></td>
									<td><?php echo $keyB; ?></td>
									<td><?php echo $country_groupValue; ?></td>
								
								</tr>
									   
								<?php
									}
									  if($c==$count){
										  $c=$c+4;
								?>
								<tr class="warning">
									<td><?php echo $count; ?></td>
									<td><?php echo $keyB; ?></td>
									<td><?php echo $country_groupValue; ?></td>
								
								</tr>
									   
								<?php
									}
									  if($d==$count){
										  $d=$d+4;
								?>
								<tr class="danger">
									<td><?php echo $count; ?></td>
									<td><?php echo $keyB; ?></td>
									<td><?php echo $country_groupValue; ?></td>
								
								</tr>
									   
								<?php
									}
								
									$count++; 
								}
								
								?>
								  
								</tbody>
							  </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               
            </div>
            <!-- /.row -->
			
			<?php
			//echo $role[0];
			if($role[0]=="supervisor" || $role[0]=="administrator"){
			
			$args = array(
				'role'    => 'client',
				'orderby' => 'user_nicename',
				'order'   => 'ASC'
			);
			$users = get_users( $args );
			
			//echo"<pre>";
			//foreach ( $users as $user ) {
			//	
			//	echo $user->ID;
			//}
			//print_r($users->ID);
			//echo '</pre>';
			?>
			<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Client Performance                           
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body clientperformance" style="">
                            <table class="table table-striped">
								<thead>
								  <tr>
									<th width="30%">Client</th>
									<th width="10%">RM</th>
									<th width="10%">P</th>
									<th width="10%">EMS</th>
									<th width="10%">OM</th>
									<th width="10%">EX</th>
									<th width="20%">Total value</th>
								  </tr>
								</thead>
								<tbody>
								<?php
								foreach ( $users as $user ) {
								?>
								  <tr>
									<td><?php echo $user->display_name;?></td>
									<td><?php echo getClientDataBasedonFilters($user->ID,'Registered','REGISTERED',$time);?></td>
									<td><?php echo getClientDataBasedonFilters($user->ID,'Parcel','PARCEL',$time);?></td>
									<td><?php echo getClientDataBasedonFilters($user->ID,'Ordinary Mail','ORDINARY MAIL',$time);?></td>
									<td><?php echo getClientDataBasedonFilters($user->ID,'EMS','EMS',$time);?></td>
									<td><?php echo getClientDataBasedonFilters($user->ID,'Express','EXPRESS',$time);?></td>
									
									<?php $getClientTotalDataBasedonFilters=getClientTotalDataBasedonFilters($user->ID,$time);?>
									<td><?php echo $getClientTotalDataBasedonFilters;?></td>
																		  
									
								  </tr>
								 <?php 
									}
								?>
								
								 
								</tbody>
							  </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                   
                </div>
			<?php
			}
			?>
			
			<?php
			if($role[0]!="team"){
			?>
			 <div class="row">
                <div class="col-lg-12">
					<div class="panel panel-green">
                        <div class="panel-heading">
                           What would you like to do?
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body what-do">
                           <div class="row">
								<div class="col-sm-3">
									<div class="well text-center">
										<i class="fa fa-envelope fa-5x"></i> <br>
										<button onclick="location.href='<?php echo admin_url('admin.php?page=mail_creation');?>';" type="button" class="btn btn-default">Create Mail</button>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="well text-center">
										<i class="fa fa-arrow-circle-o-up fa-5x"></i> <br>
										<button type="button" class="btn btn-default" onclick="location.href='<?php echo admin_url('admin.php?page=batch_upload');?>';">Batch Upload</button>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="well text-center">
										<i class="fa fa-search  fa-5x"></i> <br>
										<button type="button" class="btn btn-default" onclick="location.href='<?php echo admin_url('admin.php?page=tracking');?>';">Track Shipment</button>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="well text-center">
										<i class="fa fa-file  fa-5x"></i> <br>
										<button type="button" class="btn btn-default" onclick="location.href='<?php echo admin_url('admin.php?page=shipping_reports');?>';">View Report</button>
									</div>
								</div>
						   </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
			</div>
			
			<?php
			}
			?>
			<!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>

