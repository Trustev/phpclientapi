<?php
namespace Trustev\Entities;

/*
* The Trustev Decision Result field.
*/
class DecisionResultEnum
{

	/**
	 * This result should not be returned to you. It means that an error has occurred and a Trustev Decision has not been made on your Trustev Case. 
	 * @var int
	 */
	public static $Unknown = 0;

	/**
	 * This result indicates that the Trustev Case shows no signs for suspicion and the 'transaction' should be accepted.
	 * @var int
	 */
	///
	public static $Pass = 1;

	/**
	 * This result indicates that the Trustev Case contains elements for suspicion which should be reviewed before a final decision is made.
	 * @var int
	 */
	public static $Flag = 2;

	/**
	 * This result indicates that the Trustev Case contains a number of fraudulent features and the 'transaction' should be rejected.
	 * @var int
	 */
	public static $Fail = 3;
}