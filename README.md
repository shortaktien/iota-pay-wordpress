# iota-pay-wordpress

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

This IOTA plugin works on the basis of the IOTA button https://iota-button.org which can be found here.

This plugin lets you easily insert this button anywhere on your WordPress site. Whether in an article, on a page or as a widget.
		
There are 4 entries you need to make: 

		
	The Address
	this is the same as your address in the Firefly app. This is needed so that you can receive your donations and earnings.
		 
	The amount
	here you enter the amount of IOTA you want to receive. It is calculated in the smallest form of IOTA.
		 
	The Currency
	specify here which currency you want to have, in case you want to give people the possibility to convert to USD/EUR for 		 
	example, you will still get your donations and income in IOTA here. The conversion rate will be updated every minute.
		 
	The user
	this input will be necessary for the [donation] button. The users will see who they are donating too. Here you can enter
	your name or the name of your website.

How to use:
	 
	To insert the button anywhere on your WordPress site, simply paste the shortcode [iota]
	This is the Button for a payment with IOTA
		 
	The shortcode [fiat] stand for the button with the option to make a transaktion with a  conversion fiat currency 
		
	The shortcode [donation] gives you the Button for a Donation. The user can enter here set or own data for the sum.
