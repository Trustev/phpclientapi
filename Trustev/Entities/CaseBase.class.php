<?php
namespace Trustev\Entities {

	/**
	 *
	 */
	class CaseBase {
				
		/**
		* This is the Case Id. The CaseId is returned once a Trustev Case has been created. 
        * It is required when getting a Trustev Decision on a Trustev Case, when updating a Case Status, and anytime you wish to update Trustev Case information.
		* @var string
		*/
		public $Id;
		
		/**
		* SessionId is required when adding a Trustev Case. SessionId is available through Trustev.js as a publicly accessible variable - TrustevV2.SessionId
		* @var string
		*/
		public $SessionId;
		
		/**
		* The CaseNumber is chosen by the Merchant to uniquely identify the Trustev Case. It can be an alphanumeric string of your liking, howeb. 
        * Please see our Testing Guide to find out how to use the CaseNumber to get expected Trustev Decisions during Integration.
		* @var string
		*/
		public $CaseNumber;
		
		/**
		* 
		* @var TransactionBase
		*/
		public $Transaction;
		
		/**
		* Customer Object - includes details like First/Last name of Customer, address details, phone numbers, email addresses. 
        *    Social details may also be included here where available. 
        *    Please see Customer object for further parameter information.
		* @var CustomerBase
		*/
		public $Customer;
		
		/**
		* A Status includes the Order Status and a Comment section. 
        *    Trustev require that a Status is attached to a Trustev Case so that we can learn from the decision that you make on a Trustev Case. 
        *    Please see Why add Statuses? for more information.
		* @var CaseStatusBase[]
		*/
		public $Statuses;
		
		/**
		* Payments includes forwarding the Payment Type (Credit/Debit Card, PayPalâ€¦), and the BIN/IIN Number of the relevant card should it be available.
		* @var PaymentBase[]
		*/
		public $Payments;
		
		/**
		* Current Timestamp. Accepted format: yyyy-MM-ddTHH:mm:ss.fffZ 
        *    See our FAQ section for more information.
		* @var \DateTime
		*/
		public $Timestamp;

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

			}
		}
	}
}

