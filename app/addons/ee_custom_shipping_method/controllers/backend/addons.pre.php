<?php

defined('BOOTSTRAP') or die('Access denied');

use Tygh\Settings;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['addon'] == 'ee_custom_shipping_method' && isset($_REQUEST['ee_shipping_data'])) {
	if (is_array($_REQUEST['ee_shipping_data'])) {
		$storefront_id = 0;
		if (fn_allowed_for('ULTIMATE')) {
			if (fn_get_runtime_company_id()) {
				$storefront_id = Tygh\Providers\StorefrontProvider::getStorefront()->storefront_id;
			}
		}
		$_REQUEST['ee_shipping_data'] = array_filter($_REQUEST['ee_shipping_data'], function($value) {
			return is_numeric($value) && $value != 0 && intval($value) == $value;
		});
		$settings_manager = Settings::instance(['storefront_id' => $storefront_id]);
		$settings_manager->updateValue('ee_custom_shipping_method_active', json_encode($_REQUEST['ee_shipping_data']));
	}
}