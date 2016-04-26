<?php

namespace Trustev {
	use Trustev\Exceptions\ApiCallException as ApiCallException;
	use Trustev\Exceptions\TrustevGeneralException as TrustevGeneralException;

	/*
	* The ApiClient has all the methods required to communicate with the Trustev Platform.
	*/
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
		 * Initialize the Trustev class by passing in your UserName, Secret and Password.
		 * If you do not have this information, please contact our Integration Team - integrate@trustev.com
		 * @param string $userName Your ApiClient UserName
		 * @param string $password Your ApiClient Password
		 * @param string $secret Your ApiClient Secret
		 * @throws TrustevGeneralException
		 */
		public static function SetUp($userName, $password, $secret)
		{
			if(empty($userName) || empty($password) || empty($secret)){
				throw new TrustevGeneralException("You have not set your ApiClient credentials correctly. You need to set these by calling the SetUp method on the ApiClient Class providing your UserName, Password and Secret as the paramters before you can communicate with the Trustev API");
			}
			self::initialize("setup");
			self::$baseUrl = "https://app.trustev.com/api/v2.0";
			self::$userName = $userName;
			self::$password = $password;
			self::$secret = $secret;

			return ;
		}

		/**
		 * Post your Case to the TrustevClient Api
		 * @param Entities\CaseBase $case Your Case which you want to POST
		 * @return Entities\CaseBase The Case, along with the Case Id that the TrustevClient API have assigned it.
		 * @throws TrustevGeneralException
		 */
		public static function PostCase($case)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, null, $case);
		}

		/**
		 * Update your Case with the case Id, provided with the new Case object
		 * @param Entities\CaseBase $case Your Case which you want to PUT and update the existing Case with.
		 * @param string $caseId The Case Id of the Case you want to update. The TrustevClient API will have assigned this Id and returned it in the response Case from the PostCase Method
		 * @return Entities\CaseBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateCase($case, $caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $case);
		}

		/**
		 * Get the Case with the Id caseId
		 * @param string $caseId The Case Id of the Case you want to get. The TrustevClient API will have assigned this Id and returned it in the response Case from the PostCase Method
		 * @return Entities\CaseBase
		 * @throws TrustevGeneralException
		 */
		public static function GetCase($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Get a Decision on a Case with Id caseId.
		 * @param string $caseId The Id of a Case which you have already posted to the TrustevClient API. 
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
		 * Post your Customer to an existing Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\CustomerBase $customer Your Customer which you want to post
		 * @return Entities\CustomerBase
		 * @throws TrustevGeneralException
		 */
		public static function PostCustomer($caseId, $customer)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $customer);
		}

		/**
		 * Update the Customer on a Case which already contains a Customer
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\CustomerBase $customer Your Customer which you want to Put and update the existing Customer with.
		 * @return Entities\CustomerBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateCustomer($caseId, $customer)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $customer);
		}

		/**
		 * Get the Customer attached to the Case
		 * @param string $caseId The Case Id of the the Case with the Customer you want to get
		 * @return Entities\CustomerBase
		 * @throws TrustevGeneralException
		 */
		public static function GetCustomer($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your Transaction to an existing Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\TransactionBase $transaction Your Transaction which you want to post
		 * @return Entities\TransactionBase
		 * @throws TrustevGeneralException
		 */
		public static function PostTransaction($caseId, $transaction)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transaction);
		}

		/**
		 * Update the Transaction on a Case which already contains a Transaction
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\TransactionBase $transaction Your Transaction which you want to Put and update the existing Transaction with
		 * @return Entities\TransactionBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateTransaction($caseId, $transaction)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transaction);
		}

		/**
		* Get the Transaction attached to the Case
		* @param string $caseId The Case Id of the the Case with the Transaction you want to get
		* @return Entities\TransactionBase
		* @throws TrustevGeneralException
		*/
		public static function GetTransaction($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your CaseStatus to an existing Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\CaseStatusBase $caseStatus Your CaseStatus which you want to post
		 * @return Entities\CaseStatusBase | null
		 * @throws TrustevGeneralException
		 */
		public static function PostCaseStatus($caseId, $caseStatus)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $caseStatus);
		}

		/**
		 * Get a specific Status from a Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param string $caseStatusId The Id of the CaseStatus you want to get
		 * @return Entities\CaseStatusBase | null
		 * @throws TrustevGeneralException
		 */
		public static function GetCaseStatus($caseId, $caseStatusId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $caseStatusId));
		}

		/**
		 * Get all the Statuses from a Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @return Entities\CaseStatusBase[]
		 * @throws TrustevGeneralException
		 */
		public static function GetCaseStatuses($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your CustomerAddress to an existing Customer on an existing Case
		 * @param string $caseId The Case Id of a Case with the Customer  which you have already posted
		 * @param Entities\AddressBase $customerAddress Your CustomerAddress which you want to post
		 * @return null|Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function PostCustomerAddress($caseId, $customerAddress)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $customerAddress);
		}

		/**
		 * Update a specific CustomerAddress on a Case which already contains a CustomerAddress
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\AddressBase $customerAddress The CustomerAddress you want to update the existing CustomerAddress to
		 * @param string $customerAddressId The Id of the CustomerAddress you want to update
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateCustomerAddress($caseId, $customerAddress, $customerAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $customerAddressId), $customerAddress);
		}

		/**
		 * Get a specific CustomerAddress from a Case
		 * @param string $caseId The Case Id of a Case with the Customer which you have already posted
		 * @param string $customerAddressId The Id of the CustomerAddress you want to get
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function GetCustomerAddress($caseId, $customerAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $customerAddressId));
		}

		/**
		 * Get all the Addresses from a Customer on a Case
		 * @param string $caseId The Case Id of a Case with the Customer  which you have already posted
		 * @return Entities\AddressBase[]
		 * @throws TrustevGeneralException
		 */
		public static function GetCustomerAddresses($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your Email to an existing Customer on an existing Case
		 * @param string $caseId The Case Id of a Case with the Customer which you have already posted
		 * @param Entities\EmailBase $email Your Email which you want to post
		 * @return Entities\EmailBase
		 * @throws TrustevGeneralException
		 */
		public static function PostEmail($caseId, $email)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $email);
		}

		/**
		 * Update a specific Email on a Case which already contains a Email
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\EmailBase $email The Email you want to update the existing Email to
		 * @param string $emailId The Id of the Email you want to update
		 * @return Entities\EmailBase | null
		 * @throws TrustevGeneralException
		 */
		public static function UpdateEmail($caseId, $email, $emailId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $emailId), $email);
		}

		/**
		 * Get a specific Email from a Case
		 * @param string $caseId The Case Id of a Case with the Customer which you have already posted
		 * @param string $emailId The Id of the Email you want to get
		 * @return Entities\EmailBase | null
		 * @throws TrustevGeneralException
		 */
		public static function GetEmail($caseId, $emailId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $emailId));
		}

		/**
		 * Get all the Emails from a Case
		 * @param string $caseId The Case Id of a Case with the Customer which you have already posted
		 * @return Entities\EmailBase[] | null
		 * @throws TrustevGeneralException
		 */
		public static function GetEmails($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your Payment to an existing Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\PaymentBase $payment Your Payment which you want to post
		 * @return Entities\PaymentBase
		 * @throws TrustevGeneralException
		 */
		public static function PostPayment($caseId, $payment)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $payment);
		}

		/**
		 * Update a specific Payment on a Case which already contains a Payment
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\PaymentBase $payment The Payment you want to update the existing Payment to
		 * @param string $paymentId The Id of the Payment you want to update
		 * @return Object PaymentBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdatePayment($caseId, $payment, $paymentId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $paymentId), $payment);
		}

		/**
		 * Get a specific Payment from a Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param string $paymentId The Id of the Payment you want to get
		 * @return Entities\PaymentBase
		 * @throws TrustevGeneralException
		 */
		public static function GetPayment($caseId, $paymentId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $paymentId));
		}

		/**
		* Get all the Payments from a Case
		* @param string $caseId The Case Id of a Case which you have already posted
		* @return Entities\PaymentBase
		* @throws TrustevGeneralException
		*/
		public static function GetPayments($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your SocialAccount to an existing Customer on an existing Case
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\SocialAccountBase $socialAccount Your SocialAccount which you want to post
		 * @return Entities\SocialAccountBase
		 * @throws TrustevGeneralException
		 */
		public static function PostSocialAccount($caseId, $socialAccount)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $socialAccount);
		}

		/**
		* Update a specific SocialAccount on a Case which already contains a SocialAccount
		* @param string $caseId The Case Id of a Case which you have already posted
		* @param Entities\SocialAccountBase $socialAccount The SocialAccount you want to update the existing SocialAccount to
		* @param string $socialAccountId The id of the SocialAccount you want to update
		* @return Entities\SocialAccountBase
		* @throws TrustevGeneralException
		*/
		public static function UpdateSocialAccount($caseId, $socialAccount, $socialAccountId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $socialAccountId), $socialAccount);
		}

		/**
		 * Get a specific SocialAccount from a Case
		 * @param string $caseId The Case Id of a Case with the Customer Social Account which you have already posted
		 * @param string $socialAccountId The Id of the SocialAccount you want to get
		 * @return Entities\SocialAccountBase
		 * @throws TrustevGeneralException
		 */
		public static function GetSocialAccount($caseId, $socialAccountId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $socialAccountId));
		}

		/**
		 * Get all the SocialAccounts from a Customer on a Case
		 * @param string $caseId The Case Id of a Case with the Customer which you have already posted
		 * @return null|Entities\SocialAccountBase[]
		 * @throws TrustevGeneralException
		 */
		public static function GetSocialAccounts($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your TransactionAddress to an existing Transaction on an existing Case
		 * @param string $caseId The Case Id of a Case with the Transaction which you have already posted
		 * @param Entities\AddressBase $transactionAddress Your TransactionAddress which you want to post
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function PostTransactionAddress($caseId, $transactionAddress)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transactionAddress);
		}

		/**
		 * Update a specific TransactionAddress on a Case which already contains a TransactionAddress
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\AddressBase $transactionAddress The TransactionAddress you want to update the existing TransactionAddress to
		 * @param string $transactionAddressId The Id of the TransactionAddress you want to update
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateTransactionAddress($caseId, $transactionAddress, $transactionAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionAddressId), $transactionAddress);
		}

		/**
		 * Get a specific TransactionAddress from a Case
		 * @param string $caseId The Case Id of a Case with the Customer which you have already posted
		 * @param string $transactionAddressId The Id of the TransactionAddress you want to get
		 * @return Entities\AddressBase
		 * @throws TrustevGeneralException
		 */
		public static function GetTransactionAddress($caseId, $transactionAddressId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionAddressId));
		}

		/**
		* Get all the Addresses from a Transaction on a Case
		* @param string $caseId The Case Id of a Case with the Transaction which you have already posted
		* @return Entities\AddressBase[] | null
		* @throws TrustevGeneralException
		*/
		public static function GetTransactionAddresses($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}

		/**
		 * Post your TransactionItem to an existing Transaction on an existing Case
		 * @param string $caseId The Case Id of a Case with the Transaction which you have already posted
		 * @param Entities\TransactionItemBase $transactionItem Your TransactionItem which you want to post
		 * @return Entities\TransactionItemBase
		 * @throws TrustevGeneralException
		 */
		public static function PostTransactionItem($caseId, $transactionItem)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId), $transactionItem);
		}

		/**
		 * Update a specific TransactionItem on a Case which already contains a TransactionItem
		 * @param string $caseId The Case Id of a Case which you have already posted
		 * @param Entities\TransactionItemBase $transactionItem The TransactionAddress you want to update the existing TransactionItem to
		 * @param string $transactionItemId The id of the TransactionItem you want to update
		 * @return Entities\TransactionItemBase
		 * @throws TrustevGeneralException
		 */
		public static function UpdateTransactionItem($caseId, $transactionItem, $transactionItemId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionItemId), $transactionItem);
		}

		/**
		 * Get a specific TransactionItem from a Case
		 * @param string $caseId The Case Id of a Case with the Transaction which you have already posted
		 * @param string $transactionItemId The Id of the TransactionItem you want to get
		 * @return Entities\TransactionItemBase
		 * @throws TrustevGeneralException
		 */
		public static function GetTransactionItem($caseId, $transactionItemId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId, $transactionItemId));
		}

		/**
		* Get all the TransactionItems from a Transaction on a Case
		* @param string $caseId The Case Id of a Case with the Transaction which you have already posted
		* @return Entities\TransactionItemBase[] | null
		* @throws TrustevGeneralException
		*/
		public static function GetTransactionItems($caseId)
		{
			self::initialize();
			return self::GetAction(__FUNCTION__, array($caseId));
		}
		
		/**
		 * Get a Detailed Decision on a Case with Id caseId.
		 * @param string $caseId The Id of a Case which you have already posted to the TrustevClient API. 
		 * @return Entities\DecisionBase
		 * @throws TrustevGeneralException
		 */
		public static function GetDetailedDecision($caseId)
		{
			self::initialize();

			if($caseId instanceof Entities\CaseBase){
				$caseId = $caseId->Id;
			}
			return self::GetAction(__FUNCTION__, array($caseId));
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
			//this is calling the GetTokenRequest, which returns the Token request message
			$authReq = self::GetTokenRequest(self::GetTimeStamp());
			// Issuing the POST Token request
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
		 * This method performs the Http Request to the TrustevClient API
		 * @param string $url The HttpMethod Uri
		 * @param string $method The Http Method
		 * @param Object $data The Object
		 * @return Object
		 * @throws \Exception
		 */
		private static function CallApi($url, $method, $data = null)
		{
			$fullUrl = self::$baseUrl . $url;

			$headers = array();
			$headers[] = "Content-type: application/json";

			if (self::$token != null) {
				$headers[] = "X-Authorization: " . sprintf("%s %s", self::$userName, self::$token->APIToken);
			}

			$http = array(
				"method" => $method,
				"header" => $headers,
				"ignore_errors" => true
			);

			if ($data != null) {
				$http["content"] = self::costumJsonEncode($data);
			}

			$context = stream_context_create(
				array("http" => $http)
			);

			$fp = @fopen($fullUrl, "rb", false, $context);

			if (!$fp) {
				$php_error_msg = print_r(error_get_last(), true);
				throw new \Exception("Trustev RPC error: $php_error_msg");
			}

			$response = @stream_get_contents($fp);

			@fclose($fp);


			$responseHeader = self::parseHeaders($http_response_header);

			$retVal = json_decode($response);


			if ($responseHeader["ReponseCode"] >= 400) {

				$message = Entities\HttpResponseCodes::GetResponse($responseHeader["ReponseCode"]);
				if ($retVal != null && $retVal->Message != null) {
					$message = $retVal->Message;
				}

				throw new ApiCallException($message, $response, $retVal);
			}

			return $retVal;
		}


		/**
		 * This function gets the request action for the relevant request
		 * @param string $function Function name
		 * @param null|mixed $args Url parameters
		 * @param null|object $data Data for submit
		 * @return null|object
		 * @throws TrustevGeneralException
		 */
		private static function GetAction($function, $args = null, $data = null)
		{
			$action = RestActions::GetInstance()->GetRestAction($function);

			if (is_null(self::$token)) {
				self::Authenticate();
			}
			elseif (self::$token->IsExpired()){
				self::Authenticate();
			}

			try {
				return (object)self::CallApi(vsprintf($action->Url, $args), $action->Method, $data);
			} catch (\Exception $ex) {
				throw new TrustevGeneralException("Exception while executing " . $function , null, $ex);
			}
		}


	}
}
