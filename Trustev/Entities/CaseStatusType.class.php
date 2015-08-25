<?php
namespace Trustev\Entities {

/**
  * These types are the various Status codes used to indicate the Status of a Case.
 */
class CaseStatusTypeEnum {
    /**
     * Order Completed
     */
    public static $Completed = 0;

    /**
     * Order Rejected due to Fraud
     */
    public static $RejectedFraud = 1;

    /**
     * Order Rejected due to Card Authentication Failure
     */
    public static $RejectedAuthFailure = 2;

    /**
     * Order Rejected due to suspect Fraud
     */
    public static $RejectedSuspicious = 3;

    /**
     * Order Cancelled
     */
    public static $Cancelled = 4;

    /**
     * Return of funds to customer due to Fraud
     */
    public static $ChargebackFraud = 5;

    /**
     * Return of funds to customer for other reasons
     */
    public static $ChargebackOther = 6;

    /**
     * Customer refunded
     */
    public static $Refunded = 7;

    /**
     * Order has been placed on system
     */
    public static $Placed = 8;

    /**
     * Order is under review, no decision made yet
     */
    public static $OnHoldReview = 9;

}
}
