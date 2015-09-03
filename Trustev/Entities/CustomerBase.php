<?php
namespace Trustev\Entities {

	/**
	 * The Customer object includes the information on a Customer such as Address, Names, Email, Phone Number and Social Account information.
	 */
	class CustomerBase {
				
		/**
		* This is the Customer Id. This Id is returned when Customer Information has been added. 
        * This Id is required should you wish to update the Customer details after a Trustev Case has been added.
        * Please note: this Id is always returned from the Trustev API as a reference Id to the specific object.
		* @var string
		*/
		public $Id;
		
		/**
		* The First Name of the Customer.
		* @var string
		*/
		public $FirstName;
		
		/**
		* The Last Name of the Customer.
		* @var string
		*/
		public $LastName;
		
		/**
		* A collection of Emails.
        * Please see Emails object for further parameter information.
		* @var EmailBase[]
		*/
		public $Emails;
		
		/**
		* The Phone Number for the Customer.
		* @var string
		*/
		public $PhoneNumber;
		
		/**
		* The Date of Birth of the Customer. Accepted format: yyyy-MM-ddTHH:mm:ss.fffZ
		* @var \DateTime
		*/
		public $DateOfBirth;
		
		/**
		* Addresses Object – Contains standard/delivery/billing information. 
        * Please see Address Object for further parameter information.
		* @var AddressBase[]
		*/
		public $Addresses;
		
		/**
		* Social Account Object - Contains Short Term and Long Term Access Tokens, along with Social Account Ids and Types. 
		* @var SocialAccountBase[]
		*/
		public $SocialAccounts;
		
		/**
		* The Account number of the Customer.
		* @var string
		*/
		public $AccountNumber;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)
			{
				if(array_key_exists("Id", $object)) $this->Id = $object["Id"];
				if(array_key_exists("FirstName", $object)) $this->FirstName = $object["FirstName"];
				if(array_key_exists("LastName", $object)) $this->LastName = $object["LastName"];
				if(array_key_exists("Emails", $object)) $this->Emails = $object["Emails"];
				if(array_key_exists("PhoneNumber", $object)) $this->PhoneNumber = $object["PhoneNumber"];
				if(array_key_exists("DateOfBirth", $object)) $this->DateOfBirth = $object["DateOfBirth"];
				if(array_key_exists("Addresses", $object)) $this->Addresses = $object["Addresses"];
				if(array_key_exists("SocialAccounts", $object)) $this->SocialAccounts = $object["SocialAccounts"];
				if(array_key_exists("AccountNumber", $object)) $this->AccountNumber = $object["AccountNumber"];
			}
		}
	}
}

