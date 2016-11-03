<?php
namespace Trustev;

/*
* The Trustev Settings.
*/
interface Settings
{

	/**
	 * API Username ---- REQUIRED ----
	 * @var string
	 */
	const Username = '';

	/**
	 * API Password ---- REQUIRED ----
	 * @var string
	 */
	const Password = '';

	/**
	 * API Secret ---- REQUIRED ----
	 * @var string
	 */
	const Secret = '';

	/**
	 * API Address for the United States
	 * @var string
	 */
	const URL_US = 'https://app.trustev.com/api/v2.0';

	/**
	 * API Address for Europe
	 * @var string
	 */
	const URL_EU = 'https://app-eu.trustev.com/api/v2.0';
}