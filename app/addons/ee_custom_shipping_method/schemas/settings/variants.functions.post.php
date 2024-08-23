<?php
if (!defined('BOOTSTRAP')) { die('Access denied'); }

/**
* Методы доставки
*/
function fn_settings_variants_addons_ee_custom_shipping_method_multiple_shipping_methods() {
	$shippings_data = fn_get_shippings(true);
	return $shippings_data;
}
