<?php
/**
 * StoreNoticeTypes class.
 *
 * Class to define the types of store notices.
 *
 * @package Automattic/WCShipping
 */

namespace Automattic\WCShipping\Checkout;

defined( 'ABSPATH' ) || exit;

/**
 * Class StoreNoticeTypes
 */
class StoreNoticeTypes {

	/**
	 * The notice type for a success.
	 */
	const SUCCESS = 'success';

	/**
	 * The notice type for an error.
	 */
	const ERROR = 'error';

	/**
	 * The notice type for an info.
	 */
	const INFO = 'info';

	/**
	 * The notice type for a warning.
	 */
	const WARNING = 'warning';
}
