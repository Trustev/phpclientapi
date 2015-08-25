<?php
namespace Trustev\Entities {

	class HttpMethodBase {
				
		/**
		* @var string
		*/
		public $Method;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Method", $object)) $this->Method = $object["Method"];
			}
		}
	}
}

