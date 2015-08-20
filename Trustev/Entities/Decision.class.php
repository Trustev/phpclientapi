<?php
/**
 * Created by PhpStorm.
 * User: stepan.fryd@gmail.com
 * Date: 5. 6. 2015
 * Time: 12:48
 */

namespace Trustev\Entities;


class DecisionBase
{

	/**
	 * @var string
	 */
	public $Id;

	/**
	 * @var number
	 */
	public $Version;

	/**
	 * @var string
	 */
	public $SessionId;

	/**
	 * @var \DateTime
	 */
	public $Timestamp;

	/**
	 * @var string
	 */
	public $Type;

	/**
	 * @var DecisionResultEnum
	 */
	public $Result;

	/**
	 * @var number
	 */
	public $Score;

	/**
	 * @var number
	 */
	public $Confidence;

	/**
	 * @var string
	 */
	public $Comment;
	
}