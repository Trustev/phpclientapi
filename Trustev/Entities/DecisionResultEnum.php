<?php
namespace Trustev\Entities;

/*
* The Trustev Decision Result field.
*/
interface DecisionResultEnum
{

	/**
	 * This result should not be returned to you. It means that an error has occurred and a Trustev Decision has not been made on your Trustev Case. 
	 * @var int
	 */
	const Unknown = 0;

	/**
	 * This result indicates that the Trustev Case shows no signs for suspicion and the 'transaction' should be accepted.
	 * @var int
	 */
	///
	const Pass = 1;

	/**
	 * This result indicates that the Trustev Case contains elements for suspicion which should be reviewed before a final decision is made.
	 * @var int
	 */
	const Flag = 2;

	/**
	 * This result indicates that the Trustev Case contains a number of fraudulent features and the 'transaction' should be rejected.
	 * @var int
	 */
	const Fail = 3;
}