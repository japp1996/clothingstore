<?php

	namespace App\Libraries;
	use App\Libraries\IpCheck;

	class CalcPrice {

		public static function get($precio,$coin,$exchange) {
			$ip = IpCheck::get();
			if ($ip != 'VE') {
				$currency = '1'; // Bolivares
			}
			else {
				$currency = '2'; // Dolares
			}
			$price = $precio;
			if ($coin == '1' && $currency == '2') {
				$price = $price / $exchange;
			}
			else if ($coin == '2' && $currency == '1') {
				$price = $price * $exchange;
			}
			return $price;
		}
	}