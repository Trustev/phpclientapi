<?php
namespace Trustev\Entities {

/**
  * 
 */
class CaseStatusTypeEnum {
    /**
     * 
     */
    public static $Completed = 0;

    /**
     * 
     */
    public static $RejectedFraud = 1;

    /**
     * 
     */
    public static $RejectedAuthFailure = 2;

    /**
     * 
     */
    public static $RejectedSuspicious = 3;

    /**
     * 
     */
    public static $Cancelled = 4;

    /**
     * 
     */
    public static $ChargebackFraud = 5;

    /**
     * 
     */
    public static $ChargebackOther = 6;

    /**
     * 
     */
    public static $Refunded = 7;

    /**
     * 
     */
    public static $Placed = 8;

    /**
     * 
     */
    public static $OnHoldReview = 9;

}
}
