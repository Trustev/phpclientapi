<?php
namespace Trustev\Entities {

/**
  * These types are the various Status codes used to indicate the Status of a Case.
 */
interface CaseStatusTypeEnum {
    /**
     * Order Completed
     */
    const Completed = 0;

    /**
     * Order Rejected due to Fraud
     */
    const RejectedFraud = 1;

    /**
     * Order Rejected due to Card Authentication Failure
     */
    const RejectedAuthFailure = 2;

    /**
     * Order Rejected due to suspect Fraud
     */
    const RejectedSuspicious = 3;

    /**
     * Order Cancelled
     */
    const Cancelled = 4;

    /**
     * Return of funds to customer due to Fraud
     */
    const ChargebackFraud = 5;

    /**
     * Return of funds to customer for other reasons
     */
    const ChargebackOther = 6;

    /**
     * Customer refunded
     */
    const Refunded = 7;

    /**
     * Order has been placed on system
     */
    const Placed = 8;

    /**
     * Order is under review, no decision made yet
     */
    const OnHoldReview = 9;

    }
}
