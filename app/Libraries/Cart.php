<?php

	namespace App\Libraries;
	use Cookie;

	class Cart {

		public static $items = [];
		public static $name = "WaraCarrito";

		private static function init() {
			if (Cookie::get(self::$name) != null) {
				self::$items = Cookie::get(self::$name);
			}
		}

		public static function count() {
			self::init();
			return count(self::$items);
		}

		public static function get() {
			self::init();
			return self::$items;
		}

		public static function in($id,$_index = false) {
			self::init();
			$in = false;
			$index = null;
			foreach(self::$items as $key => $item) {
				if ($id == $item['id']) {
					$in = true;
					$index = $key;
				}
			}
			if ($_index)
				return $index;
			else
				return $in;
		}

		public static function set($item) {
			self::init();
			if (self::in($item['id'])) {
				self::$items[self::in($item['id'],true)] = $item;
			}
			else {
				self::$items[] = $item;
			}			
			Cookie::queue(self::$name,self::$items, 2628000);
		}

		public static function delete($index) {
			self::init();
			unset(self::$items[$index]);
			Cookie::queue(self::$name,self::$items, 2628000);
		}

		public static function destroy() {
			Cookie::queue(
			    Cookie::forget(self::$name)
			);
		}
	}