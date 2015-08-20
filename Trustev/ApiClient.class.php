<?php

namespace Trustev {
	use Trustev\Exceptions\ApiCallException as ApiCallException;
	use Trustev\Exceptions\TrustevGeneralException as TrustevGeneralException;


	class ApiClient
	{
		
		/**
		 * @var null|string
		 */
		private static $userName;
		/**
		 * @var null|string
		 */
		private static $password;
		/**
		 * @var null|string
		 */
		private static $secret;
		/**
		 * @var null|string
		 */
		private static $baseUrl;
		/**
		 * @var null|Entities\Token
		 */
		private static $token;
		/**
		 * @var null|bool
		 */
		private static $initialized = false;


		/**
		 * Initialize the Trustev API by passing in your UserName, Secret and Password.
		 * If you do not have this information, please contact our Integration Team - integrate@trustev.com
		 * @param $userName
		 * @param $password
		 * @param $secret
		 * @throws TrustevGeneralException
		 */
		public static function SetUp($userName, $password, $secret)
		{
			if(empty($userName) || empty($password) || empty($secret)){
				throw new TrustevGeneralException("You have not set your TrustevClient credentials correctly. You need to set these by calling the SetUp method on the TrustevClient Class providing your UserName, Password and Secret as the paramters before you can access the TrustevClient API");
			}
			self::initialize("setup");
			self::$baseUrl = "https://app.trustev.com/api/v2.0";
			self::$userName = $userName;
			self::$password = $password;
			self::$secret = $secret;
			self::Authenticate();
			return ;
		}
		
		private static function initialize($type = null)
		{
			if (self::$initialized)
			{
				return;
			}

			if($type != "setup"){
				throw new TrustevGeneralException("You must SetUp the ApiClient before any other API operation.");
			}

			self::$initialized = true;
		}
		
		/**
		 * Returns the Token
		 * @return Entities\Token
		 */
		private static function GetToken()
		{
			self::initialize();
			return ApiClient::$token;
		}

		/**
		* GetTokenRequest
		* @param $timestamp
		* @return array
		*/
		private static function GetTokenRequest($timeStamp)
		{
			return (object)array(
				"UserName" => self::$userName,
				"Timestamp" => $timeStamp,
				"PasswordHash" => hash("sha256", hash("sha256", $timeStamp . "." . self::$password) . "." . self::$secret),
				"UserNameHash" => hash("sha256", hash("sha256", $timeStamp . "." . self::$userName) . "." . self::$secret)
			);
		}

		/**
		 * @return null
		 */
		private static function Authenticate()
		{
			//this is calling the GetTokenRequest, which returns an array of the values
			$authReq = self::GetTokenRequest(self::GetTimeStamp());
			//setting the Token value in the Entities\Token, after calling the CallAPI request that send the HTTP request
			self::$token = new Entities\Token(self::CallApi("/token", Entities\HttpMethodType::$Post, $authReq));
			return ;
		}

		/**
		 * This function gets the current timestamp in the correct format
		 * @return string
		 */
		public static function GetTimeStamp()
		{
			return gmdate("Y-m-d\TH:i:s.000", time()) . "Z";
		}

		/**
		 * This function is used to parse the header responses
		 * @param $headers
		 * @return array $head
		 */
		private static function parseHeaders($headers)
		{
			$head = array();
			foreach ($headers as $k => $v) {
				$t = explode(':', $v, 2);
				if (isset($t[1]))
					$head[trim($t[0])] = trim($t[1]);
				else {
					$head[] = $v;
					if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out))
						$head["ReponseCode"] = intval($out[1]);
				}
			}
			return $head;
		}


		/**
		 * Encodes to Json and removes null values
		 * @param $val
		 * @return string
		 */
		private static function costumJsonEncode($val){
			return preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($val));
		}


		/**
		 * This function sends up the HTTP request to the API
		 * @param $url string
		 * @param $method string
		 * @param $data Object
		 * @return Object
		 * @throws \Exception
		 */
		private function CallApi($url, $method, $data = null)
		{
			//combining the baseURL with the url from the request
			$fullUrl = self::$baseUrl . $url;

			//Setting the content-type in the headers
			$headers = array();
			$headers[] = "Content-type: application/json";

			//if there's a token available, set the X-Authorization header with the UserName and APIToken
			if (self::$token != null) {
				$headers[] = "X-Authorization: " . sprintf("%s %s", self::$userName, self::$token->APIToken);
			}

			$http = array(
				"method" => $method,
				"header" => $headers,
				"ignore_errors" => true
			);

			//if there is a request message available, set the content with a json encoded version of the message
			if ($data != null) {
				$http["content"] = self::costumJsonEncode($data);
			}

			//adding the http array to a stream
			$context = stream_context_create(
				array("http" => $http)
			);

			//opening the URL, with reading and binary mode, incuding the http array
			$fp = @fopen($fullUrl, "rb", false, $context);

			//if it does not open the URL, throw an exception with the php error message that was returned.
			if (!$fp) {
				$php_error_msg = print_r(error_get_last(), true);
				throw new \Exception("Trustev RPC error: $php_error_msg");
			}
			// returns the response from the stream
			$response = @stream_get_contents($fp);
			// closing the stream
			@fclose($fp);

			//parsing the response header
			$responseHeader = self::parseHeaders($http_response_header);
			//decoding the response message
			$retVal = json_decode($response);

			//if the responsecode is 400
			if ($responseHeader["ReponseCode"] >= 400) {

				//getting the response message from the http response codes
				$message = Entities\HttpResponseCodes::GetResponse($responseHeader["ReponseCode"]);
				if ($retVal != null && $retVal->Message != null) {
					$message = $retVal->Message;
				}

				//throwing an API Exception
				throw new ApiCallException($message, $response, $retVal);
			}

			return $retVal;
		}


		/**
		 * This function gets the request action for the relevant request
		 * @param $function string Function name
		 * @param null|mixed $args Url parameters
		 * @param null|object $data Data for submit
		 * @return null|object
		 * @throws TrustevGeneralException
		 */
		private static function GetAction($function, $args = null, $data = null)
		{
			// this is setting the action for the function request
			$action = RestActions::GetInstance()->GetRestAction($function);

			// re-authenticate if session is expired
			if (self::$token->IsExpired()){
				self::Authenticate();
			}

			try {
				//call the specified URL, setting the HTTP request method including any data if provided
				//an exception is returned if this fails
				return (object)self::CallApi(vsprintf($action->Url, $args), $action->Method, $data);
			} catch (\Exception $ex) {
				throw new TrustevGeneralException("Exception while executing " . $function , null, $ex);
			}
		}

		/**
		 * Create a new Trustev Case
		 * @param $case Entities\CaseBase
		 * @return Entities\CaseBase
		 * @throws TrustevGeneralException
		 */
		public static function PostCase($case)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, null, $case);
		}

		/**
		 * Update a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @return Entities\CaseBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateCase($case, $caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $case);
		}

		/**
		 * Retrieve a previously created Trustev Case
		 * @param $caseId string
		 * @return Entities\CaseBase
		 * @throws TrustevGeneralException
		 */
		public static function GetCase($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Retrieve a Trustev Decision on a Trustev Case
		 * @param $case Entities\CaseBase
		 * @return Entities\DecisionBase
		 * @throws TrustevGeneralException
		 */
		public static function GetDecision($caseId)
		{
			self::initialize();

			if($caseId instanceof Entities\CaseBase){
				$caseId = $caseId->Id;
			}
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Create a Customer in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $customer Entities\CustomerBase
		 * @return Entities\CustomerBase
		 * @throws TrustevGeneralException
		 */
		public static function PostCustomer($caseId, $customer)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $customer);
		}

		/**
		 * Update a Customer in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $customer Entities\CustomerBase
		 * @return Entities\CustomerBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateCustomer($caseId, $customer)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $customer);
		}

		/**
		 * Retrieve a Customer from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @return Entities\CustomerBase
		 * @throws TrustevGeneralException
		 */
		public static function GetCustomer($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Create a new Transaction in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $transaction Entities\TransactionBase
		 * @return Entities\TransactionBase
		 * @throws TrustevGeneralException
		 */
		public static function PostTransaction($caseId, $transaction)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transaction);
		}

		/**
		 * Update an entire Transaction object in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $transaction Entities\TransactionBase
		 * @return Entities\TransactionBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateTransaction($caseId, $transaction)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transaction);
		}

		/**
		* Retrieve a Transaction object from a previously created Trustev Case
		* @param $case Entities\CaseBase
		* @return Entities\TransactionBase
		*/
		public static function GetTransaction($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Add a Status to a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $status Entities\CaseStatusBase
		 * @return Entities\CaseStatusBase | null
		 * @throws TrustevGeneralException
		 */
		public static function PostCaseStatus($caseId, $caseStatus)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $caseStatus);
		}

		/**
		 * Retrieve a specific Status from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $statusId string
		 * @return Object
		 * @throws TrustevGeneralException
		 */
		public static function GetCaseStatus($caseId, $caseStatusId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $caseStatusId));
		}

		/**
		 * Retrieve all the Status information from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @return Entities\CaseStatusBase[]
		 * @throws TrustevGeneralException
		 */
		public static function GetCaseStatuses($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Add a new Customer Address to a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $addresss Entities\AddressBase
		 * @return null|Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function PostCustomerAddress($caseId, $customerAddress)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $customerAddress);
		}

		/**
		 * Update a Customer Address in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $address Entities\AddressBase
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateCustomerAddress($caseId, $customerAddress, $customerAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $customerAddressId), $customerAddress);
		}

		/**
		 * Retrieve a specific Customer Address from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $addressId string
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function GetCustomerAddress($caseId, $customerAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $customerAddressId));
		}

		/**
		 * Retrieve all Customer Addresses from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @return Entities\AddressBase[]
		 * @throws TrustevGeneralException
		 */
		public static function GetCustomerAddresses($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Add a new Customer Email to a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $email Entities\EmailBase
		 * @return Entities\EmailBase
		 * @throws TrustevGeneralException
		 */
		public static function PostEmail($caseId, $email)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $email);
		}

		/**
		 * Update a Customer Email in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $email Entities\EmailBase
		 * @return Entities\EmailBase | null
		 * @throws TrustevGeneralException
		 */
		public static function UpdateEmail($caseId, $email, $emailId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $emailId), $email);
		}

		/**
		 * Retrieve a specific Customer Email detail from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $emailId string
		 * @return Entities\EmailBase | null
		 * @throws TrustevGeneralException
		 */
		public static function GetEmail($caseId, $emailId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $emailId));
		}

		/**
		 * Retrieve all Customer Emails from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @return Entities\EmailBase[] | null
		 * @throws TrustevGeneralException
		 */
		public static function GetEmails($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Add a new Payment to a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $payment Entities\PaymentBase
		 * @return Entities\PaymentBase
		 * @throws TrustevGeneralException
		 */
		public static function PostPayment($caseId, $payment)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $payment);
		}

		/**
		 * Update a Payment in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $payment Entities\PaymentBase
		 * @return Object PaymentBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdatePayment($caseId, $payment, $paymentId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $paymentId), $payment);
		}

		/**
		 * Retrieve details on a specific Payment from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $paymentId string
		 * @return Entities\PaymentBase
		 * @throws TrustevGeneralException
		 */
		public static function GetPayment($caseId, $paymentId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $paymentId));
		}

		/**
		* Retrieve all Payment details from a previously created Trustev Case
		* @param $case Entities\CaseBase
		*/
		public static function GetPayments($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Add Social Account details to a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $account Entities\SocialAccountBase
		 * @return Entities\SocialAccountBase
		 * @throws TrustevGeneralException
		 */
		public static function PostSocialAccount($caseId, $socialAccount)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $socialAccount);
		}

		/**
		* Update a specific Social Account in a previously created Trustev Case
		*/
		public static function UpdateSocialAccount($caseId, $socialAccount, $socialAccountId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $socialAccountId), $socialAccount);
		}

		/**
		 * Retrieve a specific Social Account from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $accountId string
		 * @return Entities\SocialAccountBase
		 * @throws TrustevGeneralException
		 */
		public static function GetSocialAccount($caseId, $socialAccountId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $socialAccountId));
		}

		/**
		 * Retrieve all Social Account information from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @return null|Entities\SocialAccountBase[]
		 * @throws TrustevGeneralException
		 */
		public static function GetSocialAccounts($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Add a new Address to the Transaction object in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $address Entities\AddressBase
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function PostTransactionAddress($caseId, $transactionAddress)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transactionAddress);
		}

		/**
		 * Update a specific Address in the Transaction object of a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $address Entities\AddressBAse
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateTransactionAddress($caseId, $transactionAddress, $transactionAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionAddressId), $transactionAddress);
		}

		/**
		 * Retrieve a specific Address of a Transaction from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $addressId string
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function GetTransactionAddress($caseId, $transactionAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionAddressId));
		}

		/**
		* Retrieve all Address information in the Transaction from a previously created Trustev Case
		* @param $case Entities\CaseBase
		*/
		public static function GetTransactionAddresses($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Add a new Transaction Item to a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $item Entities\TransactionItemBase
		 * @return Entities\TransactionItemBase
		 * @throws TrustevGeneralException
		 */
		public static function PostTransactionItem($caseId, $transactionItem)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transactionItem);
		}

		/**
		 * Update a Transaction Item in a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $item Entities\TransactionItemBase
		 * @return Entities\TransactionItemBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateTransactionItem($caseId, $transactionItem, $transactionItemId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionItemId), $transactionItem);
		}

		/**
		 * Retrieve a specific Transaction Item from a previously created Trustev Case
		 * @param $case Entities\CaseBase
		 * @param $itemId string
		 * @return Entities\TransactionItemBase
		 * @throws TrustevGeneralException
		 */
		public static function GetTransactionItem($caseId, $transactionItemId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionItemId));
		}

		/**
		* Retrieve all Transaction Items from a previously created Trustev Case
		* @param $case Entities\CaseBase
		*/
		public static function GetTransactionItems($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}
	}
}
