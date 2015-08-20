<?php
/**
 * Created by PhpStorm.
 * User: stepan.fryd@gmail.com
 * Date: 15. 5. 2015
 * Time: 14:40
 */

namespace Trustev\Exceptions;


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