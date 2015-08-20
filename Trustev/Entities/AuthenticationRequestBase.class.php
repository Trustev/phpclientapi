<?php
namespace Trustev\Entities {

	/**
	 * 
	 */
	class AuthenticationRequestBase {
				
		/**
		* This is your Site UserName, available from your API Keys accessed through the Trustev Dashboard
		* @var string
		*/
		public $UserName;
		
		/**
		* This is the current Timestamp in the format yyyy-MM-ddTHH:mm:ss.fffZ
        * See our FAQ section for more information.
		* @var \DateTime
		*/
		public $Timestamp;
		
		/**
		* This is a hashed value involving your Timestamp, Site Password, and Shared Secret.
        * Please see Step 5 of our Integration Documentation for information on how to form this.
		* @var string
		*/
		public $PasswordHash;
		
		/**
		* This is a hashed value involving your Timestamp, Site UserName, and Shared Secret.
        * Please see Step 5 of our Integration Documentation for information on how to form this.
		* @var string
		*/
		public $UserNameHash;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("UserName", $object)) $this->UserName = $object["UserName"];
				if(array_key_exists("Timestamp", $object)) $this->Timestamp = $object["Timestamp"];
				if(array_key_exists("PasswordHash", $object)) $this->PasswordHash = $object["PasswordHash"];
				if(array_key_exists("UserNameHash", $object)) $this->UserNameHash = $object["UserNameHash"];
			}
		}
	}
}

