<?php
/**
 * Created by PhpStorm.
 * User: stepan.fryd@gmail.com
 * Date: 5. 6. 2015
 * Time: 12:50
 */

namespace Trustev\Entities;

class DecisionResultEnum
{

	/**
	 * This result should not be returned to you. It means that an error has occurred and a Trustev Decision has not been
	 *  made on your Trustev Case. Please contact support@trustev.com should this occur. Please provide the Case Number and
	 *  Case Id when sending this request.
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
	 * This result indicates that the Trustev Case contains elements for suspicion which should be reviewed before a final
	 *  decision is made.
	 * @var int
	 */
	public static $Flag = 2;

	/**
	 * This result indicates that the Trustev Case contains a number of fraudulent features and the 'transaction' should be
	 * rejected.
	 * @var int
	 */
	public static $Fail = 3;
}