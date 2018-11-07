<?php

	namespace App\Libraries;
	use App\Libraries\CalcPrice;

	class Total {

		public static function get($pedido) {
			$total = 0;
			foreach($pedido->details as $item) {
				$total += $item->quantity * CalcPrice::get($item->price,$item->coin,$pedido->exchange->change);
			}
			return $total;
		}
	}