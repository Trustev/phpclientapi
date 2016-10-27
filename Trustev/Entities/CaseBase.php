<?php
namespace Trustev\Entities {

	/**
	 * The Case Object is the what Trustev bases its Decision on. It is a container for all the information that can be provided.
     * The more information that you provide us with, the more accurate our Decision, so please populate as much as possible.
	 */
	class CaseBase {
				
		/**
		* This is the Case Id. The CaseId is returned once a Trustev Case has been created. 
        * It is required when getting a Trustev Decision on a Trustev Case, when updating a Case Status, and anytime you wish to update Trustev Case information.
		* @var string
		*/
		public $Id;
		
		/**
		* SessionId is required when adding a Trustev Case. SessionId is available through the Trustev.js as a publicly accessible variable - TrustevV2.SessionId
		* @var string
		*/
		public $SessionId;
		
		/**
		* The CaseNumber is chosen by the Merchant to uniquely identify the Trustev Case. It can be an alphanumeric string of your liking, but it must be unique.
		* We would always recommend that Merchants set the Case Number as the internal Order Number so it is easy to reference in later reporting. 
        * Please see our Testing Guide to find out how to use the CaseNumber to get expected Trustev Decisions during Integration.
		* @var string
		*/
		public $CaseNumber;
		
		/**
		* Transaction Object - includes details such as Transaction Amount, Currency, Items and Transaction delivery/billing address.
		* @var TransactionBase
		*/
		public $Transaction;
		
		/**
		* Customer Object - includes details like First/Last name of Customer, address details, phone numbers, email addresses. 
        * Social details may also be included here where available. 
        * Please see Customer object for further parameter information.
		* @var CustomerBase
		*/
		public $Customer;
		
		/**
		* A Status includes the Order Status and a Comment section. 
        * Trustev require that a Status is attached to a Trustev Case so that we can learn from the decision that you make on a Trustev Case. 
		* @var CaseStatusBase[]
		*/
		public $Statuses;
		
		/**
		* Payments includes forwarding the Payment Type (Credit/Debit Card, PayPal, etc), and the BIN/IIN Number of the relevant card should it be available.
		* @var PaymentBase[]
		*/
		public $Payments;
		
		/**
		* Current Timestamp. Accepted format: yyyy-MM-ddTHH:mm:ss.fffZ 
		* @var \DateTime
		*/
		public $Timestamp;

		/**
		* Current Timestamp. Accepted format: yyyy-MM-ddTHH:mm:ss.fffZ 
		* @var \DateTime
		*/
		public $CaseType;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)
			{
				if(array_key_exists("Id", $object)) $this->Id = $object["Id"];
				if(array_key_exists("SessionId", $object)) $this->SessionId = $object["SessionId"];
				if(array_key_exists("CaseNumber", $object)) $this->CaseNumber = $object["CaseNumber"];
				if(array_key_exists("Transaction", $object)) $this->Transaction = $object["Transaction"];
				if(array_key_exists("Customer", $object)) $this->Customer = $object["Customer"];
				if(array_key_exists("Statuses", $object)) $this->Statuses = $object["Statuses"];
				if(array_key_exists("Payments", $object)) $this->Payments = $object["Payments"];
				if(array_key_exists("Timestamp", $object)) $this->Timestamp = $object["Timestamp"];
				if(array_key_exists("CaseType", $object)) $this->CaseType = $object["CaseType"];

			}
		}
	}
}

