<?php
namespace Trustev\Entities {

	class HttpContentBase {
				
		/**
		* @var Object[]
		*/
		public $Headers;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Headers", $object)) $this->Headers = $object["Headers"];
			}
		}
	}
}

