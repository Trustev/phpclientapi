<?php
namespace Trustev\Entities {

/**
  * The accepted Payment Types for the Payment object
 */
class PaymentTypeEnum {
    /**
     * None Payment Type
     */
    public static $None = 0;

    /**
     * Credit Card Payment
     */
    public static $CreditCard = 1;

    /**
     * Debit Card Payment
     */
    public static $DebitCard = 2;

    /**
     * Direct Debit Payment
     */
    public static $DirectDebit = 3;

    /**
     * PayPal Payment
     */
    public static $PayPal = 4;

    /**
     * BitCoin Payment
     */
    public static $Bitcoin = 5;

}
}
