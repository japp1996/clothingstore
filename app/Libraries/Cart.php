<?php

	namespace App\Libraries;
	use Cookie;

	class Cart {

		public static $ids = [];
		public static $name = "WaraCarrito";

		private static function init() {
			if (Cookie::get(self::$name) != null) {
				self::$ids = Cookie::get(self::$name);
			}
		}

		public static function count() {
			self::init();
			return count(self::$ids);
		}

		public static function get() {
			self::init();
			return self::$ids;
		}

		public static function in($id) {
			self::init();
			return in_array($id,self::$ids);
		}

		public static function set($id) {
			self::init();
			self::$ids[] = $id;
			Cookie::queue(self::$name,self::$ids, 2628000);
		}

		public static function delete($id) {
			self::init();
			self::$ids = array_diff(self::$ids,[$id]);
			Cookie::queue(self::$name,self::$ids, 2628000);
		}

		public static function destroy() {
			Cookie::queue(
			    Cookie::forget(self::$name)
			);
		}
	}