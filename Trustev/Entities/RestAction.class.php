<?php
/**
 * Created by PhpStorm.
 * User: stepan.fryd@gmail.com
 * Date: 19. 5. 2015
 * Time: 13:40
 */

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
		 * @param $url string REST URL mask
		 * @param $method string HTTP action method
		 */
		public function __construct($url, $method) {
			$this->Url = $url;
			$this->Method = $method;
		}
	}
}