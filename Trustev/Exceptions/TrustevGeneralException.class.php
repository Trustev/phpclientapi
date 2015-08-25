<?php
namespace Trustev\Exceptions;

/*
* This is a general TrustevClient Exception, inspect the message for more details.
*/
class TrustevGeneralException extends \Exception {

    /**
     * @param string $message
     * @param null $code
     * @param null $exception
     */
    public function __construct($message, $code = null, $exception = null ) {
        parent::__construct($message, $code, $exception);
    }
}