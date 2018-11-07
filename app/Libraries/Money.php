<?php
	
	namespace App\Libraries;
	use App\Libraries\IpCheck;

	class Money {

		public static function get($cant) {
			$ip = IpCheck::get();
			if ($ip != 'VE') {
				$currency = '1'; // Bolivares
			}
			else {
				$currency = '2'; // Dolares
			}
			return number_format($cant,2,'.',',').($currency == '1' ? ' Bs. S' : ' USD');
		}
	}