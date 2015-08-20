<?php
/**
 * Created by PhpStorm.
 * User: stepan.fryd@gmail.com
 * Date: 15. 5. 2015
 * Time: 12:42
 */

namespace Trustev\Entities {


    class Token
    {

        /**
         * @var string
         */
        public $ExpireAt;

        /**
         * @var string
         */
        public $APIToken;

        /**
         * @var number
         */
        public $CredentialType;

        /**
         * @param $token Object
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

            if( $now > $this->ExpireAt){
                return true;
            }
            return false;
        }
    }
}