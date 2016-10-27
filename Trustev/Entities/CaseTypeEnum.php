<?php
namespace Trustev\Entities;

/*
* The Trustev Decision Result field.
*/
interface CaseTypeEnum
{

	/**
	 * A Default CaseType
	 * @var int
	 */
	const  Default = 0;

	/**
	 * A Login CaseType
	 * @var int
	 */
	const  AccountLogin = 1;

	/**
	 * An Account Creation CaseType
	 * @var int
	 */
	const AccountCreation = 2;

	/**
	 * A Application CaseType
	 * @var int
	 */
	const Application = 3;
}