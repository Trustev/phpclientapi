<?php
namespace Trustev\Entities {

/**
  * The accepted Payment Types for the Payment object
 */
interface PaymentTypeEnum {
    /**
     * None Payment Type
     */
    const None = 0;

    /**
     * Credit Card Payment
     */
    const CreditCard = 1;

    /**
     * Debit Card Payment
     */
    const DebitCard = 2;

    /**
     * Direct Debit Payment
     */
    const DirectDebit = 3;

    /**
     * PayPal Payment
     */
    const PayPal = 4;

    /**
     * BitCoin Payment
     */
    const Bitcoin = 5;

}
}
