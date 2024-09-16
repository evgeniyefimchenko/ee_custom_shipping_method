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
	$addonsParams = Registry::get('addons.ee_custom_shipping_method');
	$currentCost = json_decode($addonsParams['ee_custom_shipping_method_active'], true);
	if (isset($addonsParams['ee_custom_shipping_method_active']) && is_array($currentCost) && count($currentCost)) {
		foreach ($rates as &$rate) {			
			if (!$rate['error'] && array_key_exists($rate['keys']['shipping_id'], $currentCost)) {
				$rate['price'] = $currentCost[$rate['keys']['shipping_id']];
			}
		}
	}
}

function fn_ee_custom_shipping_method_show_admin_table() {
	$currentCost = json_decode(Registry::get('addons.ee_custom_shipping_method')['ee_custom_shipping_method_active'], true);
	if (!is_array($currentCost)) {
		$currentCost = [];
	}
	$shippings_data = fn_get_shippings(true);	
	$html = '<div class="table-responsive-wrapper longtap-selection"><table class="table table-middle table--relative table-responsive">';
	$html .= '<thead><tr><th>Название</th><th width="30%">' . __("shipping_charges") . '</th></tr></thead>';
	$html .= '<tbody>';	
	foreach ($shippings_data as $sId => $shippingName) {
		$valueCost = isset($currentCost[$sId]) ? $currentCost[$sId] : '';
		$inputCost = '<input type="text" class="input-small" name="ee_shipping_data[' . $sId . ']" value="' . $valueCost . '"/>';
		$html .= '<tr>';
		$html .= '<td>' . $shippingName . '</td><td>' . $inputCost . '</td>';
		$html .= '</tr>';
	}
	$html .= '</tbody></table></div>';
	return $html;
}
