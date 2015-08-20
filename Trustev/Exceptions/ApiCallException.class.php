<?php
/**
 * Created by PhpStorm.
 * User: stepan.fryd@gmail.com
 * Date: 18. 5. 2015
 * Time: 16:01
 */

namespace Trustev\Exceptions {


	class ApiCallException extends \Exception
	{
		/**
		 * @var null|object API error response in JSON object and has been deserialized
		 */
		public $ApiResponseObject;

		/**
		 * @var null|string API error response in any text
		 */
		public $ApiResponseText;

		/**
		 * @param string $message
		 * @param null $responseText
		 * @param null $responseObject
		 * @param null $code
		 * @param null $exception
		 */
		public function __construct($message, $responseText = null, $responseObject = null, $code = null, $exception = null ) {
			parent::__construct($message, $code, $exception);
			$this->ApiResponseText = $responseText;
			$this->ApiResponseObject = $responseObject;
		}
	}
}