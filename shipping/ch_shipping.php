<?php

/*
Plugin Name: Shipping
Description: This is a plugin for Shipping.  
*/

require_once('admin/ch_shipping_admin.php');
require_once('admin/inc/ch_ajax.php');
require_once('admin/inc/customfunction.php');
require_once('front/ch_shpping_front.php');

/*
* Create Tables

*/

	function create_shippingtables(){

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."batch_creation (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  batch_id int(255) NOT NULL,
				  country varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
				  tracking_number varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  mail_type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  content_type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  addressee varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  address1 varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  address2 varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  city varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  state varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  zip_code varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  amount float(10,2) NOT NULL,
				  weight_kg float(10,2) NOT NULL,
				  weight_grm varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  status varchar(211) COLLATE utf8mb4_unicode_ci NOT NULL,
				  batch_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  created_by varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
				  created_on timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (id)
				)  $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."batch_summary (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  batch_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  total_waight varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  total_amount varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  date_time varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  total_number_mail int(11) NOT NULL,
				  batch_id int(255) NOT NULL,
				  batch_upload_by int(11) NOT NULL,
				  date_dispatched varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  date_delivery varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  date_create varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  is_tagged varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
				  PRIMARY KEY (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."mail_batch_remarks_info (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  tracking_id varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  message varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  addedon datetime NOT NULL,
				  updateon datetime NOT NULL,
				  addedby int(11) NOT NULL,
				  updateby int(11) NOT NULL,
				  PRIMARY KEY (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."mail_creation (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  country varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
				  tracking_number varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  mail_type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  content_type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  addressee varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  address1 varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  address2 varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  city varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  state varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  zip_code varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  amount varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  weight_kg varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  weight_grm varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  status varchar(211) COLLATE utf8mb4_unicode_ci NOT NULL,
				  created_by varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
				  created_on timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  is_tagged varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
				  PRIMARY KEY (id)
				)$charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."mail_tackinginfo (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  tracking_id varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  created_upload_date varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  date_recived varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  received_by varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  date_dispatched varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  dispatch_details varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  date_delivery varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  delivered_details varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  type varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
				  addedon datetime NOT NULL,
				  updateon datetime NOT NULL,
				  addedby int(11) NOT NULL,
				  updateby int(11) NOT NULL,
				  PRIMARY KEY (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."mail_tagging (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  tracking_id varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  tag varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  batch_id int(11) DEFAULT NULL,
				  created_date datetime NOT NULL,
				  addedby int(11) NOT NULL,
				  PRIMARY KEY (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."shipping_activity (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  activity varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
				  created_by int(11) NOT NULL,
				  created_date datetime NOT NULL,
				  PRIMARY KEY (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."shipping_country (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  country_name varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
				  country_code varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
				  PRIMARY KEY (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."upload_cert_of_mail (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  cert_url varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
			  tracking_id varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
			  type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
			  added_by int(11) NOT NULL,
			  updated_by int(11) NOT NULL,
			  create_date datetime NOT NULL,
			  update_date datetime NOT NULL,
			  PRIMARY KEY (id)
			) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."upload_invoice (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  invoce_url varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
			  tracking_id varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
			  type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
			  added_by int(11) NOT NULL,
			  updated_by int(11) NOT NULL,
			  create_date datetime NOT NULL,
			  update_date datetime NOT NULL,
			  PRIMARY KEY (id)
			) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$sql = "INSERT INTO ".$wpdb->prefix ."shipping_country (id, country_name, country_code) VALUES
			(1, 'Afghanistan', 'AF'),
			(2, 'Åland Islands', 'AX'),
			(3, 'Albania', 'AL'),
			(4, 'Algeria', 'DZ'),
			(5, 'American Samoa', 'AS'),
			(6, 'Andorra', 'AD'),
			(7, 'Angola', 'AO'),
			(8, 'Anguilla', 'AI'),
			(9, 'Antarctica', 'AQ'),
			(10, 'Antigua and Barbuda', 'AG'),
			(11, 'Argentina', 'AR'),
			(12, 'Armenia', 'AM'),
			(13, 'Aruba', 'AW'),
			(14, 'Australia', 'AU'),
			(15, 'Austria', 'AT'),
			(16, 'Azerbaijan', 'AZ'),
			(17, 'Bahamas', 'BS'),
			(18, 'Bahrain', 'BH'),
			(19, 'Bangladesh', 'BD'),
			(20, 'Barbados', 'BB'),
			(21, 'Belarus', 'BY'),
			(22, 'Belgium', 'BE'),
			(23, 'Belize', 'BZ'),
			(24, 'Benin', 'BJ'),
			(25, 'Bermuda', 'BM'),
			(26, 'Bhutan', 'BT'),
			(27, 'Bolivia-Plurinational State of', 'BO'),
			(28, 'Bonaire-Sint Eustatius and Saba', 'BQ'),
			(29, 'Bosnia and Herzegovina', 'BA'),
			(30, 'Botswana', 'BW'),
			(31, 'Bouvet Island', 'BV'),
			(32, 'Brazil', 'BR'),
			(33, 'British Indian Ocean Territory', 'IO'),
			(34, 'Brunei Darussalam', 'BN'),
			(35, 'Bulgaria', 'BG'),
			(36, 'Burkina Faso', 'BF'),
			(37, 'Burundi', 'BI'),
			(38, 'Cambodia', 'KH'),
			(39, 'Cameroon', 'CM'),
			(40, 'Canada', 'CA'),
			(41, 'Cape Verde', 'CV'),
			(42, 'Cayman Islands', 'KY'),
			(43, 'Central African Republic', 'CF'),
			(44, 'Chad', 'TD'),
			(45, 'Chile', 'CL'),
			(46, 'China', 'CN'),
			(47, 'Christmas Island', 'CX'),
			(48, 'Cocos (Keeling) Islands', 'CC'),
			(49, 'Colombia', 'CO'),
			(50, 'Comoros', 'KM'),
			(51, 'Congo', 'CG'),
			(52, 'Congo-the Democratic Republic of the', 'CD'),
			(53, 'Cook Islands', 'CK'),
			(54, 'Costa Rica', 'CR'),
			(55, 'Côte d\'Ivoire', 'CI'),
			(56, 'Croatia', 'HR'),
			(57, 'Cuba', 'CU'),
			(58, 'Curaçao', 'CW'),
			(59, 'Cyprus', 'CY'),
			(60, 'Czech Republic', 'CZ'),
			(61, 'Denmark', 'DK'),
			(62, 'Djibouti', 'DJ'),
			(63, 'Dominica', 'DM'),
			(64, 'Dominican Republic', 'DO'),
			(65, 'Ecuador', 'EC'),
			(66, 'Egypt', 'EG'),
			(67, 'El Salvador', 'SV'),
			(68, 'Equatorial Guinea', 'GQ'),
			(69, 'Eritrea', 'ER'),
			(70, 'Estonia', 'EE'),
			(71, 'Ethiopia', 'ET'),
			(72, 'Falkland Islands (Malvinas)', 'FK'),
			(73, 'Faroe Islands', 'FO'),
			(74, 'Fiji', 'FJ'),
			(75, 'Finland', 'FI'),
			(76, 'France', 'FR'),
			(77, 'French Guiana', 'GF'),
			(78, 'French Polynesia', 'PF'),
			(79, 'French Southern Territories', 'TF'),
			(80, 'Gabon', 'GA'),
			(81, 'Gambia', 'GM'),
			(82, 'Georgia', 'GE'),
			(83, 'Germany', 'DE'),
			(84, 'Ghana', 'GH'),
			(85, 'Gibraltar', 'GI'),
			(86, 'Greece', 'GR'),
			(87, 'Greenland', 'GL'),
			(88, 'Grenada', 'GD'),
			(89, 'Guadeloupe', 'GP'),
			(90, 'Guam', 'GU'),
			(91, 'Guatemala', 'GT'),
			(92, 'Guernsey', 'GG'),
			(93, 'Guinea', 'GN'),
			(94, 'Guinea-Bissau', 'GW'),
			(95, 'Guyana', 'GY'),
			(96, 'Haiti', 'HT'),
			(97, 'Heard Island and McDonald Islands', 'HM'),
			(98, 'Holy See (Vatican City State)', 'VA'),
			(99, 'Honduras', 'HN'),
			(100, 'Hong Kong', 'HK'),
			(101, 'Hungary', 'HU'),
			(102, 'Iceland', 'IS'),
			(103, 'India', 'IN'),
			(104, 'Indonesia', 'ID'),
			(105, 'Iran-Islamic Republic of', 'IR'),
			(106, 'Iraq', 'IQ'),
			(107, 'Ireland', 'IE'),
			(108, 'Isle of Man', 'IM'),
			(109, 'Israel', 'IL'),
			(110, 'Italy', 'IT'),
			(111, 'Jamaica', 'JM'),
			(112, 'Japan', 'JP'),
			(113, 'Jersey', 'JE'),
			(114, 'Jordan', 'JO'),
			(115, 'Kazakhstan', 'KZ'),
			(116, 'Kenya', 'KE'),
			(117, 'Kiribati', 'KI'),
			(118, 'Korea-Democratic People\'s Republic of', 'KP'),
			(119, 'Korea-Republic of', 'KR'),
			(120, 'Kuwait', 'KW'),
			(121, 'Kyrgyzstan', 'KG'),
			(122, 'Lao People\'s Democratic Republic', 'LA'),
			(123, 'Latvia', 'LV'),
			(124, 'Lebanon', 'LB'),
			(125, 'Lesotho', 'LS'),
			(126, 'Liberia', 'LR'),
			(127, 'Libya', 'LY'),
			(128, 'Liechtenstein', 'LI'),
			(129, 'Lithuania', 'LT'),
			(130, 'Luxembourg', 'LU'),
			(131, 'Macao', 'MO'),
			(132, 'Macedonia-the Former Yugoslav Republic of', 'MK'),
			(133, 'Madagascar', 'MG'),
			(134, 'Malawi', 'MW'),
			(135, 'Malaysia', 'MY'),
			(136, 'Maldives', 'MV'),
			(137, 'Mali', 'ML'),
			(138, 'Malta', 'MT'),
			(139, 'Marshall Islands', 'MH'),
			(140, 'Martinique', 'MQ'),
			(141, 'Mauritania', 'MR'),
			(142, 'Mauritius', 'MU'),
			(143, 'Mayotte', 'YT'),
			(144, 'Mexico', 'MX'),
			(145, 'Micronesia-Federated States of', 'FM'),
			(146, 'Moldova-Republic of', 'MD'),
			(147, 'Monaco', 'MC'),
			(148, 'Mongolia', 'MN'),
			(149, 'Montenegro', 'ME'),
			(150, 'Montserrat', 'MS'),
			(151, 'Morocco', 'MA'),
			(152, 'Mozambique', 'MZ'),
			(153, 'Myanmar', 'MM'),
			(154, 'Namibia', 'NA'),
			(155, 'Nauru', 'NR'),
			(156, 'Nepal', 'NP'),
			(157, 'Netherlands', 'NL'),
			(158, 'New Caledonia', 'NC'),
			(159, 'New Zealand', 'NZ'),
			(160, 'Nicaragua', 'NI'),
			(161, 'Niger', 'NE'),
			(162, 'Nigeria', 'NG'),
			(163, 'Niue', 'NU'),
			(164, 'Norfolk Island', 'NF'),
			(165, 'Northern Mariana Islands', 'MP'),
			(166, 'Norway', 'NO'),
			(167, 'Oman', 'OM'),
			(168, 'Pakistan', 'PK'),
			(169, 'Palau', 'PW'),
			(170, 'Palestine-State of', 'PS'),
			(171, 'Panama', 'PA'),
			(172, 'Papua New Guinea', 'PG'),
			(173, 'Paraguay', 'PY'),
			(174, 'Peru', 'PE'),
			(175, 'Philippines', 'PH'),
			(176, 'Pitcairn', 'PN'),
			(177, 'Poland', 'PL'),
			(178, 'Portugal', 'PT'),
			(179, 'Puerto Rico', 'PR'),
			(180, 'Qatar', 'QA'),
			(181, 'Réunion', 'RE'),
			(182, 'Romania', 'RO'),
			(183, 'Russian Federation', 'RU'),
			(184, 'Rwanda', 'RW'),
			(185, 'Saint Barthélemy', 'BL'),
			(186, 'Saint Helena-Ascension and Tristan da Cunha', 'SH'),
			(187, 'Saint Kitts and Nevis', 'KN'),
			(188, 'Saint Lucia', 'LC'),
			(189, 'Saint Martin (French part)', 'MF'),
			(190, 'Saint Pierre and Miquelon', 'PM'),
			(191, 'Saint Vincent and the Grenadines', 'VC'),
			(192, 'Samoa', 'WS'),
			(193, 'San Marino', 'SM'),
			(194, 'Sao Tome and Principe', 'ST'),
			(195, 'Saudi Arabia', 'SA'),
			(196, 'Senegal', 'SN'),
			(197, 'Serbia', 'RS'),
			(198, 'Seychelles', 'SC'),
			(199, 'Sierra Leone', 'SL'),
			(200, 'Singapore', 'SG'),
			(201, 'Sint Maarten (Dutch part)', 'SX'),
			(202, 'Slovakia', 'SK'),
			(203, 'Slovenia', 'SI'),
			(204, 'Solomon Islands', 'SB'),
			(205, 'Somalia', 'SO'),
			(206, 'South Africa', 'ZA'),
			(207, 'South Georgia and the South Sandwich Islands', 'GS'),
			(208, 'South Sudan', 'SS'),
			(209, 'Spain', 'ES'),
			(210, 'Sri Lanka', 'LK'),
			(211, 'Sudan', 'SD'),
			(212, 'Suriname', 'SR'),
			(213, 'Svalbard and Jan Mayen', 'SJ'),
			(214, 'Swaziland', 'SZ'),
			(215, 'Sweden', 'SE'),
			(216, 'Switzerland', 'CH'),
			(217, 'Syrian Arab Republic', 'SY'),
			(218, 'Taiwan-Province of China', 'TW'),
			(219, 'Tajikistan', 'TJ'),
			(220, 'Tanzania-United Republic of', 'TZ'),
			(221, 'Thailand', 'TH'),
			(222, 'Timor-Leste', 'TL'),
			(223, 'Togo', 'TG'),
			(224, 'Tokelau', 'TK'),
			(225, 'Tonga', 'TO'),
			(226, 'Trinidad and Tobago', 'TT'),
			(227, 'Tunisia', 'TN'),
			(228, 'Turkey', 'TR'),
			(229, 'Turkmenistan', 'TM'),
			(230, 'Turks and Caicos Islands', 'TC'),
			(231, 'Tuvalu', 'TV'),
			(232, 'Uganda', 'UG'),
			(233, 'Ukraine', 'UA'),
			(234, 'United Arab Emirates', 'AE'),
			(235, 'United Kingdom', 'GB'),
			(236, 'United States', 'US'),
			(237, 'United States Minor Outlying Islands', 'UM'),
			(238, 'Uruguay', 'UY'),
			(239, 'Uzbekistan', 'UZ'),
			(240, 'Vanuatu', 'VU'),
			(241, 'Venezuela-Bolivarian Republic of', 'VE'),
			(242, 'Viet Nam', 'VN'),
			(243, 'Virgin Islands-British', 'VG'),
			(244, 'Virgin Islands-U.S.', 'VI'),
			(245, 'Wallis and Futuna', 'WF'),
			(246, 'Western Sahara', 'EH'),
			(247, 'Yemen', 'YE'),
			(248, 'Zambia', 'ZM'),
			(249, 'Zimbabwe', 'ZW');
			";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	register_activation_hook( __FILE__, 'create_shippingtables' );

