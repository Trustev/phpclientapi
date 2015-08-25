<?php
namespace Trustev\Entities {

	/**
	 * 
	 */
	class AddressBase {
				
		/**
		* This is the Address Id. This Id is returned when Address Information has been added to the Transaction object. 
        * This Id is required should you wish to update the Address details after a Trustev Case has been added.
        * Please note: this Id is always returned from the Trustev API as a reference Id to the specific object.
		* @var string
		*/
		public $Id;
		
		/**
		* The First Name for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $FirstName;
		
		/**
		* The Last Name for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $LastName;
		
		/**
		* Address Line 1 for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $Address1;
		
		/**
		* Address Line 2 for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $Address2;
		
		/**
		* Address Line 3 for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $Address3;
		
		/**
		* City for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $City;
		
		/**
		* State for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $State;
		
		/**
		* The Postal Code for the Standard/Billing/Delivery Address.
		* @var string
		*/
		public $PostalCode;
		
		/**
		* The Address Type - Standard (0), Billing (1), or Delivery (2)
		* @var AddressTypeEnum
		*/
		public $Type;
		
		/**
		* These are the 2 letter country codes published by ISO. 
        * Details can be found at http://www.nationsonline.org/oneworld/countrycodes.htm
		* @var string
		*/
		public $CountryCode;
		
		/**
		* Current Timestamp. Accepted format: yyyy-MM-ddTHH:mm:ss.fffZ
        * See our FAQ section for more information.
		* @var \DateTime
		*/
		public $Timestamp;
		
		/**
		* Is this the default address?
		* @var boolean
		*/
		public $IsDefault;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Id", $object)) $this->Id = $object["Id"];
				if(array_key_exists("FirstName", $object)) $this->FirstName = $object["FirstName"];
				if(array_key_exists("LastName", $object)) $this->LastName = $object["LastName"];
				if(array_key_exists("Address1", $object)) $this->Address1 = $object["Address1"];
				if(array_key_exists("Address2", $object)) $this->Address2 = $object["Address2"];
				if(array_key_exists("Address3", $object)) $this->Address3 = $object["Address3"];
				if(array_key_exists("City", $object)) $this->City = $object["City"];
				if(array_key_exists("State", $object)) $this->State = $object["State"];
				if(array_key_exists("PostalCode", $object)) $this->PostalCode = $object["PostalCode"];
				if(array_key_exists("Type", $object)) $this->Type = $object["Type"];
				if(array_key_exists("CountryCode", $object)) $this->CountryCode = $object["CountryCode"];
				if(array_key_exists("Timestamp", $object)) $this->Timestamp = $object["Timestamp"];
				if(array_key_exists("IsDefault", $object)) $this->IsDefault = $object["IsDefault"];

						}
		}
	}
}

