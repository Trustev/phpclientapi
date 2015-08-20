<?php
namespace Trustev\Entities {

	/**
	 * 
	 */
	class CaseStatusBase {
				
		/**
		* This is the Status Id. This Id is returned in the response header of the Add a Case method, when Status Information has been added. 
        * This Id is required should you wish to retrieve the Status details after a Trustev Case has been added.
        * Please note: this Id is always returned from the Trustev API as a reference Id to the specific object.
		* @var string
		*/
		public $Id;
		
		/**
		* The Status Type of the Trustev Case
		* @var CaseStatusTypeEnum
		*/
		public $Status;
		
		/**
		* Comment on the Status
		* @var string
		*/
		public $Comment;
		
		/**
		* Current Timestamp. Accepted format: yyyy-MM-ddTHH:mm:ss.fffZ 
        * See our FAQ section for more information.
		* @var \DateTime
		*/
		public $Timestamp;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Id", $object)) $this->Id = $object["Id"];
				if(array_key_exists("Status", $object)) $this->Status = $object["Status"];
				if(array_key_exists("Comment", $object)) $this->Comment = $object["Comment"];
				if(array_key_exists("Timestamp", $object)) $this->Timestamp = $object["Timestamp"];

						}
		}
	}
}

