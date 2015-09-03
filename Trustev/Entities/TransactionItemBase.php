<?php
namespace Trustev\Entities {

	/**
	 * Items Object – contains details on Item Name, Quantity and Item Value. Please see Items Object for further parameter information.
	 */
	class TransactionItemBase {
				
		/**
		* This is the Item Id. This Id is returned when Item Information has been added to the Transaction object. 
        * This Id is required should you wish to update the Item details after a Trustev Case has been added.
        * Please note: this Id is always returned from the Trustev API as a reference Id to the specific object.
		* @var string
		*/
		public $Id;
		
		/**
		* The Name of the Item being purchased.
		* @var string
		*/
		public $Name;
		
		/**
		* The Quantity of the Item being purchased.
		* @var integer
		*/
		public $Quantity;
		
		/**
		* The Value of the Item being purchased.
		* @var float
		*/
		public $ItemValue;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Id", $object)) $this->Id = $object["Id"];
				if(array_key_exists("Name", $object)) $this->Name = $object["Name"];
				if(array_key_exists("Quantity", $object)) $this->Quantity = $object["Quantity"];
				if(array_key_exists("ItemValue", $object)) $this->ItemValue = $object["ItemValue"];

						}
		}
	}
}

