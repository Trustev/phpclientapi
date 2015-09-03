<?php
namespace Trustev\Entities {

	/**
	 * 
	 */
	class HttpRequestMessageBase {
				
		/**
		* @var VersionBase
		*/
		public $Version;
		
		/**
		* @var HttpContentBase
		*/
		public $Content;
		
		/**
		* @var HttpMethodBase
		*/
		public $Method;
		
		/**
		* The request Uri
		* @var URI
		*/
		public $RequestUri;
		
		/**
		* @var Object[]
		*/
		public $Headers;
		
		/**
		* @var Dictionary of string [key]
		* 	and Object [value]
		*/
		public $Properties;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Version", $object)) $this->Version = $object["Version"];
				if(array_key_exists("Content", $object)) $this->Content = $object["Content"];
				if(array_key_exists("Method", $object)) $this->Method = $object["Method"];
				if(array_key_exists("RequestUri", $object)) $this->RequestUri = $object["RequestUri"];
				if(array_key_exists("Headers", $object)) $this->Headers = $object["Headers"];
				if(array_key_exists("Properties", $object)) $this->Properties = $object["Properties"];
			}
		}
	}
}

