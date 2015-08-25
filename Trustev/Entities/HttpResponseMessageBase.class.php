<?php
namespace Trustev\Entities {

	class HttpResponseMessageBase {
				
		/**
		* @var VersionBase
		*/
		public $Version;
		
		/**
		* @var HttpContentBase
		*/
		public $Content;
		
		/**
		* @var HttpStatusCodeEnum
		*/
		public $StatusCode;
		
		/**
		* @var string
		*/
		public $ReasonPhrase;
		
		/**
		* @var Object[]
		*/
		public $Headers;
		
		/**
		* @var HttpRequestMessageBase
		*/
		public $RequestMessage;
		
		/**
		* @var boolean
		*/
		public $IsSuccessStatusCode;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Version", $object)) $this->Version = $object["Version"];
				if(array_key_exists("Content", $object)) $this->Content = $object["Content"];
				if(array_key_exists("StatusCode", $object)) $this->StatusCode = $object["StatusCode"];
				if(array_key_exists("ReasonPhrase", $object)) $this->ReasonPhrase = $object["ReasonPhrase"];
				if(array_key_exists("Headers", $object)) $this->Headers = $object["Headers"];
				if(array_key_exists("RequestMessage", $object)) $this->RequestMessage = $object["RequestMessage"];
				if(array_key_exists("IsSuccessStatusCode", $object)) $this->IsSuccessStatusCode = $object["IsSuccessStatusCode"];
			}
		}
	}
}

