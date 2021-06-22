<?php
/*
Plugin Name: IOTA Pay
Author: Alexander K.
Description: Get a donation with a simple Button with IOTA via Firefly.
Version: 1.06
Text Domain: https://short-aktien.de
Author URI: https://short-aktien.de
Plugin URI:
License: GPLv2
*/

add_action('admin_menu', 'iotaPayMenuFunc');
function iotaPayMenuFunc(){
	add_options_page(__("IOTA Pay", 'iota-pay'), __("IOTA Pay", 'iota-pay'), 'manage_options', 'iota-button-setting', 'iotaPaySettingFunc');
}

function iotaPaySettingFunc(){
	if(current_user_can('administrator')){
		$formHtml = '';
		$formHtml .= '
		<style>
			.iota-button-setting{
				margin: 0px auto;
				width: 50%;
			}
			.iota-button-setting label{
				margin-bottom: 8px;
				margin-top: 8px;
				display: block;
			}
			.iota-button-setting input[type=text]{
				width: 100%;
				font-size: 15px;
				padding: 15px 5px;
				height: 40px;	
			}					
			.iota-button-setting input[type=submit]{
				font-size: 15px;
				padding: 15px 5px;
				margin-top: 10px;
			}		
			.error-message{
				color: #cd2653;
				font-weight:bold;
				margin-top: 5px;
				margin-bottom: 5px;
			}
			.success-message{
				color: #32CD32;
				font-weight:bold;
				margin-top: 5px;
				margin-bottom: 5px;	
			}
			.warning-message{
				color: #ffc107;
				font-weight:bold;
				margin-top: 5px;
				margin-bottom: 5px;	
			}			
		</style>
		';
		
/*--------------settings--------------*/
		
		if(isset($_POST['save_iota_setting'])){
			$iotaSetting = [
				'address' => (isset($_POST['address']) ? $_POST['address'] : ""),
				'amount' => (isset($_POST['amount']) ? $_POST['amount'] : 0),
				'user' => (isset($_POST['user']) ? $_POST['user'] : ""),
				'currency' => (isset($_POST['currency']) ? $_POST['currency'] : "")
			];
			
			update_option('_iotaSetting', $iotaSetting);
		}
		$iotaSavedSetting = get_option('_iotaSetting');
		
		$formHtml .= '<div class="iota-button-setting">';
			$formHtml .= '<h2>IOTA Pay Settings</h2>';
			
			$formHtml .= $message;
			$formHtml .= '<form action="" method="post">';
				$formHtml .= wp_nonce_field('_wpnonce');
/*--------------adress-------------*/		
		
				$formHtml .= '<label for="address"><strong>IOTA Address</strong></label>';
				$formHtml .= '<input type="text" value="'.(isset($iotaSavedSetting["address"]) ? $iotaSavedSetting["address"] : "").'" id="address" name="address" placeholder="Address" />';				
				
/*--------------amount-------------*/	
			
				$formHtml .= '<label for="amount"><strong>Amount</strong></label>';
				$formHtml .= '<input type="text" value="'.(isset($iotaSavedSetting["amount"]) ? $iotaSavedSetting["amount"] : "").'" id="amount" name="amount" placeholder="Amount" />';
				
/*--------------currency-----------*/
				
				$formHtml .= '<label for="currency"><strong>Currency</strong></label>';
				$formHtml .= '<input type="text" value="'.(isset($iotaSavedSetting["currency"]) ? $iotaSavedSetting["currency"] : "").'" id="currency" name="currency" placeholder="Currency" />';
				
/*--------------user---------------*/	
			
				$formHtml .= '<label for="user"><strong>User</strong></label>';
				$formHtml .= '<input type="text" value="'.(isset($iotaSavedSetting["user"]) ? $iotaSavedSetting["user"] : "").'" id="user" name="user" placeholder="User" />';

/*--------------save---------------*/
				
				$formHtml .= '<input name="save_iota_setting" type="submit" class="button button-primary button-large save-order-setting" value="Save Setting">';
			$formHtml .= '</form>';
		$formHtml .= '</div>';
		
		echo $formHtml;
		
/*----------------- Description Text in Settings Menu--------------*/
		
		echo "<br>This <b>IOTA plugin</b> works on the basis of the IOTA button https://iota-button.org which can be found here.<br>

		 This plugin lets you easily insert this button anywhere on your WordPress site. Whether in an article, on a page or as a widget.<br> <br>
		 
		 There are 4 entries you need to make: <br><br>

		 <b>Address</b> - this is the same as your address in the Firefly app. This is needed so that you can receive your donations and earnings.
		 <br><br>

		 <b>The amount</b> - here you enter the amount of IOTA you want to receive. It is calculated in the smallest form of IOTA.
		 <br><br>

		 <b>Currency</b> - specify here which currency you want to have, in case you want to give people the possibility to convert to USD/EUR for 		 example, you will still get your donations and income in IOTA here. The conversion rate will be updated every minute.
		 <br><br>

		 <b>The user</b> - this input will be necessary for the [donation] button. The users will see who they are donating to. Here you can enter 		 your name or the name of your website.
		 <br><br>
		 
		 <br><b>How to use:</b><br>
		 
		 To insert the button anywhere on your WordPress site, simply paste the shortcode <b>[iota]</b>. This is the Button for a payment with 			 IOTA<br>
		 
		 The shortcode <b>[fiat]</b> stand for the button with the option to make a transaktion with a  conversion fiat currency <br>
		 
		 The shortcode <b>[donation]</b> gives you the Button for a Donation. The user can enter here set or own data for the sum.<br>
		 
		 
		 ";
	}
}



/*------------Pay with IOTA--------------*/


add_shortcode('iota', 'iotaPayButtonFunc'); 
function iotaPayButtonFunc(){
	$buttonHtml = '';
	ob_start();
		$iotaSavedSetting = get_option('_iotaSetting');
		
 		$buttonHtml .= '<script type="module" src="//iota-button.org/build/iota-button.esm.js"></script>';
		$buttonHtml .= '<script nomodule src="//iota-button.org/build/iota-button.js"></script>'; 
		
		$buttonHtml .= '<iota-button address="'.(isset($iotaSavedSetting["address"]) ? $iotaSavedSetting["address"] : "").'"
									 amount="'.(isset($iotaSavedSetting["amount"]) ? $iotaSavedSetting["amount"] : "").'"
					   </iota-button>';
		
		echo $buttonHtml;
	$contents = ob_get_contents();
	ob_get_clean();
	return $contents;
}



/*------------Pay with USD/EUR-------------*/


add_shortcode('fiat', 'iotaPayButtonFuncFiat'); 
function iotaPayButtonFuncFiat(){
	$buttonHtml = '';
	ob_start();
		$iotaSavedSetting = get_option('_iotaSetting');
		
 		$buttonHtml .= '<script type="module" src="//iota-button.org/build/iota-button.esm.js"></script>';
		$buttonHtml .= '<script nomodule src="//iota-button.org/build/iota-button.js"></script>'; 
		
		$buttonHtml .= '<iota-button 	address="'.(isset($iotaSavedSetting["address"]) ? $iotaSavedSetting["address"] : "").'" 
										amount="'.(isset($iotaSavedSetting["amount"]) ? $iotaSavedSetting["amount"] : "").' "
										currency="'.(isset($iotaSavedSetting["currency"]) ? $iotaSavedSetting["currency"] : "").'"
					   </iota-button>';
		
		echo $buttonHtml;
	$contents = ob_get_contents();
	ob_get_clean();
	return $contents;
}


/*------------Donation Button with IOTA-------------*/


add_shortcode('donation', 'iotaPayButtonFuncDonate'); 
function iotaPayButtonFuncDonate(){
	$buttonHtml = '';
	ob_start();
		$iotaSavedSetting = get_option('_iotaSetting');
		
 		$buttonHtml .= '<script type="module" src="//iota-button.org/build/iota-button.esm.js"></script>';
		$buttonHtml .= '<script nomodule src="//iota-button.org/build/iota-button.js"></script>'; 
		
		$buttonHtml .= '<iota-button address="'.(isset($iotaSavedSetting["address"]) ? $iotaSavedSetting["address"] : "").'"
									 currency="'.(isset($iotaSavedSetting["currency"]) ? $iotaSavedSetting["currency"] : "").'" 
									 label="Donate" 
									 merchant="'.(isset($iotaSavedSetting["user"]) ? $iotaSavedSetting["user"] : "").'"
									 type="donation">
									 </iota-button>';
		                
		echo $buttonHtml;
	$contents = ob_get_contents();
	ob_get_clean();
	return $contents;
}


?>
