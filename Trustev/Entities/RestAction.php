<?php

namespace Trustev\Entities {


	class RestAction
	{
		/**
		 * @var string REST URL mask
		 */
		public $Url;

		/**
		 * @var string HTTP action method GET | POST | PUT | DELETE
		 */
		public $Method;

		/**
		 * @param string $url REST URL mask
		 * @param string $method HTTP action method
		 */
		public function __construct($url, $method) {
			$this->Url = $url;
			$this->Method = $method;
		}
	}
}