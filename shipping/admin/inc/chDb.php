<?php
/*
* alldb function
*/

class SHIPPING {
	
	function __construct(){
        global $wpdb;
        $this->db = $wpdb;
        $this->charset = $wpdb->get_charset_collate();
        $this->ch_table = $wpdb->prefix . "chShipping"; 
        $this->ch_tableUpdate = $wpdb->prefix . "chShippingUpdate"; 
        $this->ch_tableQuick = $wpdb->prefix . "chQuickShipment"; 
    }     

	protected function create_shipping_table(){
		$sql = "CREATE TABLE $this->ch_table (
		  	`s_id` bigint(9) NOT NULL AUTO_INCREMENT,
		  	`consignmentNo` varchar(100) NOT NULL,
		  	`all` longtext NOT NULL,
		  	`status` varchar(100) NOT NULL,
		  	`updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
			`insert_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
			`insert_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`s_id`),
		  	UNIQUE KEY `consignmentNo` (`consignmentNo`)
		) $this->charset;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	protected function create_shipping_update_table(){
		$upsql = "CREATE TABLE $this->ch_tableUpdate (
		  	`su_id` bigint(9) NOT NULL AUTO_INCREMENT,
		  	`consignmentNo` varchar(100) NOT NULL,
		  	`newLocation` longtext NOT NULL,
		  	`newStatus` varchar(100) DEFAULT NULL,
		  	`deliveryDate` DATETIME DEFAULT CURRENT_TIMESTAMP,
			`deliveryTime` varchar(100) DEFAULT NULL,
			`comments` longtext,
			PRIMARY KEY (`su_id`),
		  	UNIQUE KEY `su_id` (`su_id`)
		) $this->charset;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $upsql );
	}


	protected function create_shipping_quick(){
		//Quick Shipment Table
		$qsql = "CREATE TABLE $this->ch_tableQuick (
		  	`q_id` bigint(9) NOT NULL AUTO_INCREMENT,
		  	`tracking_number` varchar(100) NOT NULL,
		  	`origin` varchar(100) NOT NULL,
		  	`destination` varchar(100) NOT NULL,
		  	`weight` varchar(60) NOT NULL,
		  	`charge` varchar(60) NOT NULL,
		  	`status` varchar(60) NOT NULL,
		  	`insert_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`q_id`),
		  	UNIQUE KEY `tracking_number` (`tracking_number`)
		) $this->charset;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $qsql );
	}



	public function get_ch_shipping($consignmentNo){  
		$gShippingDB = $this->db->get_row( "SELECT * FROM $this->ch_table WHERE consignmentNo = '".$consignmentNo."'", OBJECT );
		return $gShippingDB;
	}

	public function get_all_shipping(){
		$gShippingDB = $this->db->get_results( "SELECT * FROM $this->ch_table WHERE `status` <> 'delivered'", OBJECT );
		return $gShippingDB;
	}

	public function get_all_delivered(){
		// All Delivered Shipping Items
		$allDeliveredDB = $this->db->get_results( "SELECT * FROM $this->ch_table WHERE `status` = 'delivered'", OBJECT );
		return $allDeliveredDB;
	}

	/*
	* Shipment Marked Delivered
	*/
	public function marked_delivered($consignmentNo){
		$markedUpdate = $this->db->update( 
			$this->ch_table, 
			array( 
				'status' => 'delivered',	// string
				), 
			array( 'consignmentNo' => $consignmentNo ), 
				array( 
					'%s'	// String
					), 
				array( '%s' ) 
					);
			return 'success';
		}


	/*
	* All Status
	*/
	public function get_shipping_status($consignmentNo){
		$gShippingDB = $this->db->get_results( "SELECT * FROM $this->ch_tableUpdate WHERE consignmentNo = '".$consignmentNo."' ", OBJECT );
		return $gShippingDB;
	}


	/*
	* Add Shipment Form
	*/
	public function add_shipping($fData, $consignmentNo){
			$this->create_shipping_table();
			// Insert Process
			$query = $this->db->insert(
				$this->ch_table,
				array(
					'consignmentNo'	=> $consignmentNo,
					'all'			=> $fData,
					'insert_date' 	=> current_time( 'mysql' )
				),
				array(
					'%s',
					'%s',
					'%s'
				)
			);

			if($query){
				return 'success';
			}else{
				return  '"' .$consignmentNo . '"' . ' Duplicate Consignmetn No are not Allowed. '; 
			}
	}





	/*
	* Add Quick Sipment Form
	*/
	public function add_quick_shipping($qData, $truckNo){
			$this->create_shipping_quick();
			// Insert Process
			$query = $this->db->insert(
				$this->ch_tableQuick,
				$qData,
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);

			if($query){
				return 'success';
			}else{
				return  '"' .$truckNo . '"' . ' Duplicate Trucking No are not Allowed. '; 
			}
	}


	/*
	* get All Quick Shipment
	*/
	public function get_quick_shipment(){
		$qShipment = $this->db->get_results( "SELECT * FROM $this->ch_tableQuick", OBJECT );
		return $qShipment;
	}


	/*
	* Single Quick Shipment
	*/
	public function get_ch_quick($truckingNo){  
		$squick = $this->db->get_row( "SELECT * FROM $this->ch_tableQuick WHERE tracking_number = '".$truckingNo."'", OBJECT );
		return $squick;
	}

	/*
	* Update Booking Form
	*/
	public function update_shipping($fData){
		$this->create_shipping_update_table();
			$Uquery = $this->db->insert(
				$this->ch_tableUpdate,
				$fData,
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);

		if($Uquery){
				return 'success';
			}else{
				return  '"' .$consignmentNo . '"' . ' Status Update Failed, Please Check All data Again. '; 
		}
	}


	/*
	* Delete Function  
	*/
	public function delete_shipping($ids){
		$deleteSql = $this->db->query( "DELETE FROM $this->ch_table WHERE s_id IN($ids)" );		

		if($deleteSql){
				return 'success';
			}else{
				return  "Can't Delete, Please Try Again."; 
		}
	}



	/*
	* Delete Function  
	*/
	public function last_status($consignmentNo){
		$lastStatus = $this->db->get_row( "SELECT * FROM $this->ch_tableUpdate WHERE consignmentNo = '".$consignmentNo."' ORDER BY su_id DESC LIMIT 1", OBJECT );		
			return $lastStatus->newStatus;
	}




	/*
	* Delete Function  
	*/
	public function search_shipping($sValue){
		$searchSql = $this->db->get_results( "SELECT `s_id`, `all`, `insert_date` FROM $this->ch_table WHERE `consignmentNo` LIKE '%".$sValue."%'", OBJECT );		
		return $searchSql;
	}


	/*
	* Delete Quick ID
	*/
	public function delete_quick_shipment($tracking_number){
		$deleteQuc = $this->db->query( "DELETE FROM $this->ch_tableQuick WHERE tracking_number = '".$tracking_number."'" );		

		if($deleteQuc){
				return 'success';
			}else{
				return  "Can't Delete, Please Try Again."; 
		}
	}

} // End Clas