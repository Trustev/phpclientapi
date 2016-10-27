<?php
namespace Trustev {

	/*
	* The RestAction class sets the relevant URI, and HTTP method type.
	*/
	class RestActions
	{
		private $_actions;

		private static $_instance;
		
		/**
		 * @return RestActions
		 */
		public static function GetInstance() 	{
			if(self::$_instance==null) {
				self::$_instance = new RestActions();
			}

			return self::$_instance;
		}

		private function __construct() {
			$this->_actions = array(
				"PostCase" => new Entities\RestAction("/case", Entities\HttpMethodType::$Post),
				"GetCase" => new Entities\RestAction("/case/%s", Entities\HttpMethodType::$Get),
				"UpdateCase" => new Entities\RestAction("/case/%s", Entities\HttpMethodType::$Put),
				"GetDecision" => new Entities\RestAction("/decision/%s", Entities\HttpMethodType::$Get),
				"PostEmail" => new Entities\RestAction("/case/%s/customer/email", Entities\HttpMethodType::$Post),
				"UpdateEmail" => new Entities\RestAction("/case/%s/customer/email/%s", Entities\HttpMethodType::$Put),
				"GetEmail" => new Entities\RestAction("/case/%s/customer/email/%s", Entities\HttpMethodType::$Get),
				"GetEmails" => new Entities\RestAction("/case/%s/customer/email", Entities\HttpMethodType::$Get),
				"PostCustomer" => new Entities\RestAction("/case/%s/customer", Entities\HttpMethodType::$Post),
				"UpdateCustomer" => new Entities\RestAction("/case/%s/customer", Entities\HttpMethodType::$Put),
				"GetCustomer" => new Entities\RestAction("/case/%s/customer", Entities\HttpMethodType::$Get),
				"PostTransactionItem" => new Entities\RestAction("/case/%s/transaction/item", Entities\HttpMethodType::$Post),
				"UpdateTransactionItem" => new Entities\RestAction("/case/%s/transaction/item/%s", Entities\HttpMethodType::$Put),
				"GetTransactionItem" => new Entities\RestAction("/case/%s/transaction/item/%s", Entities\HttpMethodType::$Get),
				"GetTransactionItems" => new Entities\RestAction("/case/%s/transaction/item", Entities\HttpMethodType::$Get),
				"PostCustomerAddress" => new Entities\RestAction("/case/%s/customer/address", Entities\HttpMethodType::$Post),
				"UpdateCustomerAddress" => new Entities\RestAction("/case/%s/customer/address/%s", Entities\HttpMethodType::$Put),
				"GetCustomerAddress" => new Entities\RestAction("/case/%s/customer/address/%s", Entities\HttpMethodType::$Get),
				"GetCustomerAddresses" => new Entities\RestAction("/case/%s/customer/address", Entities\HttpMethodType::$Get),
				"PostTransaction" => new Entities\RestAction("/case/%s/transaction", Entities\HttpMethodType::$Post),
				"UpdateTransaction" => new Entities\RestAction("/case/%s/transaction", Entities\HttpMethodType::$Put),
				"GetTransaction" => new Entities\RestAction("/case/%s/transaction", Entities\HttpMethodType::$Get),
				"PostPayment" => new Entities\RestAction("/case/%s/payment", Entities\HttpMethodType::$Post),
				"UpdatePayment" => new Entities\RestAction("/case/%s/payment/%s", Entities\HttpMethodType::$Put),
				"GetPayments" => new Entities\RestAction("/case/%s/payment", Entities\HttpMethodType::$Get),
				"GetPayment" => new Entities\RestAction("/case/%s/payment/%s", Entities\HttpMethodType::$Get),
				"PostTransactionAddress" => new Entities\RestAction("/case/%s/transaction/address", Entities\HttpMethodType::$Post),
				"UpdateTransactionAddress" => new Entities\RestAction("/case/%s/transaction/address/%s", Entities\HttpMethodType::$Put),
				"GetTransactionAddress" => new Entities\RestAction("/case/%s/transaction/address/%s", Entities\HttpMethodType::$Get),
				"GetTransactionAddresses" => new Entities\RestAction("/case/%s/transaction/address", Entities\HttpMethodType::$Get),
				"PostCaseStatus" => new Entities\RestAction("/case/%s/status", Entities\HttpMethodType::$Post),
				"GetCaseStatus" => new Entities\RestAction("/case/%s/status/%s", Entities\HttpMethodType::$Get),
				"GetCaseStatuses" => new Entities\RestAction("/case/%s/status", Entities\HttpMethodType::$Get),
				"GetDetailedDecision" => new Entities\RestAction("/detaileddecision/%s", Entities\HttpMethodType::$Get)
			);
		}

		/**
		 * @param string $action Action name
		 * @return Entities\RestAction
		 * @throws TrustevGeneralException
		 */
		public function GetRestAction($action) {
			if(!array_key_exists($action, $this->_actions)) {
				throw new TrustevGeneralException(sprintf("Specified action %s doesn't exists in provided action list", $action));
			}

			return $this->_actions[$action];
		}
	}
}
