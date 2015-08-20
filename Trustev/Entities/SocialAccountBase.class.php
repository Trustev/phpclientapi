<?php
namespace Trustev\Entities {

	/**
	 * 
	 */
	class SocialAccountBase {
				
		/**
		* This is the Social Account Id. This Id is returned when a Social Account object has been added to the Trustev API. 
        * This Id is required should you wish to update the Social Account details after a Trustev Case has been added.
        * Please note: this Id is always returned from the Trustev API as a reference Id to the specific object.
		* @var string
		*/
		public $Id;
		
		/**
		* This is the Social Network Id, i.e. Your Facebook Account Id
		* @var integer
		*/
		public $SocialId;
		
		/**
		* This is your Trustev Social Network Type
		* @var SocialNetworkTypeEnum
		*/
		public $Type;
		
		/**
		* This is the Short Term Access Token which is available from the Social Access Token you received from the relevant Social Network&#39;s API
		* @var string
		*/
		public $ShortTermAccessToken;
		
		/**
		* This is the Long Term Access Token which is available from the Social Access Token you received from the relevant Social Network&#39;s API
		* @var string
		*/
		public $LongTermAccessToken;
		
		/**
		* This is the Short Term Token Expiry datetime which is available from the Social Access Token you received from the relevant Social Network&#39;s API
		* @var \DateTime
		*/
		public $ShortTermAccessTokenExpiry;
		
		/**
		* This is the Long Term Token Expiry datetime which is available from the Social Access Token you received from the relevant Social Network&#39;s API
		* @var \DateTime
		*/
		public $LongTermAccessTokenExpiry;
		
		/**
		* This is the Secret which is attached to the Social Network&#39;s Developer&#39;s Account. This would have previously been needed to access the relevant Social Network&#39;s API
		* @var string
		*/
		public $Secret;
		
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
				if(array_key_exists("SocialId", $object)) $this->SocialId = $object["SocialId"];
				if(array_key_exists("Type", $object)) $this->Type = $object["Type"];
				if(array_key_exists("ShortTermAccessToken", $object)) $this->ShortTermAccessToken = $object["ShortTermAccessToken"];
				if(array_key_exists("LongTermAccessToken", $object)) $this->LongTermAccessToken = $object["LongTermAccessToken"];
				if(array_key_exists("ShortTermAccessTokenExpiry", $object)) $this->ShortTermAccessTokenExpiry = $object["ShortTermAccessTokenExpiry"];
				if(array_key_exists("LongTermAccessTokenExpiry", $object)) $this->LongTermAccessTokenExpiry = $object["LongTermAccessTokenExpiry"];
				if(array_key_exists("Secret", $object)) $this->Secret = $object["Secret"];
				if(array_key_exists("Timestamp", $object)) $this->Timestamp = $object["Timestamp"];

						}
		}
	}
}

