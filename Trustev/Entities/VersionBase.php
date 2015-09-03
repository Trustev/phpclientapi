<?php
namespace Trustev\Entities {


	class VersionBase {
				
		/**
		* 
		* @var integer
		*/
		public $Major;
		
		/**
		* 
		* @var integer
		*/
		public $Minor;
		
		/**
		* 
		* @var integer
		*/
		public $Build;
		
		/**
		* 
		* @var integer
		*/
		public $Revision;
		
		/**
		* 
		* @var integer
		*/
		public $MajorRevision;
		
		/**
		* 
		* @var integer
		*/
		public $MinorRevision;

		/**
		* @param $object null|array
		*/
		public function __construct($object = null) {
			if($object!=null)			{
				if(array_key_exists("Major", $object)) $this->Major = $object["Major"];
				if(array_key_exists("Minor", $object)) $this->Minor = $object["Minor"];
				if(array_key_exists("Build", $object)) $this->Build = $object["Build"];
				if(array_key_exists("Revision", $object)) $this->Revision = $object["Revision"];
				if(array_key_exists("MajorRevision", $object)) $this->MajorRevision = $object["MajorRevision"];
				if(array_key_exists("MinorRevision", $object)) $this->MinorRevision = $object["MinorRevision"];
			}
		}
	}
}

