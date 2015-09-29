<?php

namespace Trustev\Entities {


    class Token
    {

        /**
         * Indicates when the API Token will expire
         * @var string
         */
        public $ExpireAt;

        /**
         * The API Token required in the request header
         * @var string
         */
        public $APIToken;

        /**
         * The Credential Type of the API Token - Live/Token
         * @var number
         */
        public $CredentialType;

        /**
         * @param Object $token 
         */
        public function __construct($token)
        {
            $this->ExpireAt = $token->ExpireAt;
            $this->APIToken = $token->APIToken;
            $this->CredentialType = $token->CredentialType;
        }

        /**
         * @return \DateTime|null
         */
        public function GetExpiration() {
            if($this->ExpireAt!=null) {
                return new \DateTime($this->ExpireAt);
            }

            return null;
        }

        /**
         * @return bool
         */
        public function IsExpired(){
            $now = new \DateTime();
            $diffTime = ($now->diff(new \DateTime($this->ExpireAt)));
            $diffValue = floatval($diffTime->format("%i") . "." . $diffTime->format("%s"));

            if (is_null($this->ExpireAt)) {
                return false;    
            }
            if($diffValue > 25.0){
                return true;
            }
            
            return false;
        }
    }
}
