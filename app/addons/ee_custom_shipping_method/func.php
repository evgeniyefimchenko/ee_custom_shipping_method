<?php
if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Registry;

function fn_ee_custom_shipping_method_install() {
	$message = 'The module was installed on the site ' . Registry::get('config.http_host');
	mail('evgeniy@efimchenko.ru', 'module installed', $message);	
}

function fn_ee_custom_shipping_method_uninstall() {
	return true;
}

function fn_ee_custom_shipping_method_shippings_calculate_rates_post($shippings, &$rates) {
	$addons_params = Registry::get('addons.ee_custom_shipping_method');
	// fn_print_die($addons_params);
	if (isset($addons_params['multiple_shipping_methods']) && isset($addons_params['fixed_rate']) && is_array($addons_params['multiple_shipping_methods']) && count($addons_params['multiple_shipping_methods'])) {
		foreach ($rates as &$rate) {
			if (array_key_exists($rate['keys']['shipping_id'] ,$addons_params['multiple_shipping_methods'])) {
				$rate['price'] = $addons_params['fixed_rate'];
			}
		}
	}
}
