<?php
namespace Trustev\Entities {

	/**
	 * 
	 */
	class EmailBase {
				
		/**
		* This is the Email Id. This Id is returned when an Email Address has been added. 
        * This Id is required should you wish to update the Email details after a Trustev Case has been added.
        * Please note: this Id is always returned from the Trustev API as a reference Id to the specific object.
		* @var string
		*/
		public $Id;
		
		/**
		* Email Address of the customer
		* @var string
		*/
		public $EmailAddress;
		
		/**
		* Is this is the default email for the customer?
		* @var boolean
		*/
		public $IsDefault;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Id", $object)) $this->Id = $object["Id"];
				if(array_key_exists("EmailAddress", $object)) $this->EmailAddress = $object["EmailAddress"];
				if(array_key_exists("IsDefault", $object)) $this->IsDefault = $object["IsDefault"];

						}
		}
	}
}

