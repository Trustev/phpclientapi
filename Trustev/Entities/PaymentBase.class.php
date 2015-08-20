<?php
namespace Trustev\Entities {

	/**
	 * 
	 */
	class PaymentBase {
				
		/**
		* This is the Payment Id. This Id is returned when a Payment has been added. 
        * This Id is required should you wish to update the Payment details after a Trustev Case has been added.
        * Please note: this Id is always returned from the Trustev API as a reference Id to the specific object.
		* @var string
		*/
		public $Id;
		
		/**
		* The type of Payment method used
		* @var PaymentTypeEnum
		*/
		public $PaymentType;
		
		/**
		* The BIN Number - the first 6 digits of a Debit/Credit Card Number.
		* @var string
		*/
		public $BINNumber;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Id", $object)) $this->Id = $object["Id"];
				if(array_key_exists("PaymentType", $object)) $this->PaymentType = $object["PaymentType"];
				if(array_key_exists("BINNumber", $object)) $this->BINNumber = $object["BINNumber"];

						}
		}
	}
}

