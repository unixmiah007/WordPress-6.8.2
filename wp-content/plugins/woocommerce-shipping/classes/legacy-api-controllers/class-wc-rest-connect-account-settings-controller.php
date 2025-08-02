<?php
namespace Automattic\WCShipping\LegacyAPIControllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Automattic\WCShipping\Connect\WC_Connect_API_Client;
use Automattic\WCShipping\Connect\WC_Connect_Service_Settings_Store;
use Automattic\WCShipping\Connect\WC_Connect_Account_Settings;
use Automattic\WCShipping\Connect\WC_Connect_Logger;
use Automattic\WCShipping\Connect\WC_Connect_Payment_Methods_Store;
use WP_REST_Response;
use WP_Error;

class WC_REST_Connect_Account_Settings_Controller extends WC_REST_Connect_Base_Controller {

	protected $rest_base = 'connect/account/settings';

	/*
	* @var WC_Connect_Payment_Methods_Store
	*/
	protected $payment_methods_store;

	/**
	 * @var WC_Connect_Account_Settings
	 */
	protected $account_settings;

	public function __construct( WC_Connect_API_Client $api_client, WC_Connect_Service_Settings_Store $settings_store, WC_Connect_Logger $logger, WC_Connect_Payment_Methods_Store $payment_methods_store ) {
		parent::__construct( $api_client, $settings_store, $logger );
		$this->payment_methods_store = $payment_methods_store;

		$this->account_settings = new WC_Connect_Account_Settings(
			$settings_store,
			$payment_methods_store
		);
	}

	public function get() {
		return new WP_REST_Response(
			array_merge(
				array( 'success' => true ),
				$this->account_settings->get()
			),
			200
		);
	}

	public function post( $request ) {
		$settings = $request->get_json_params();

		if ( ! $this->settings_store->can_user_manage_payment_methods() ) {
			// Ignore the user-provided payment method ID if they don't have permission to change it
			$old_settings                           = $this->settings_store->get_account_settings();
			$settings['selected_payment_method_id'] = $old_settings['selected_payment_method_id'];
		}

		$result = $this->settings_store->update_account_settings( $settings );

		if ( is_wp_error( $result ) ) {
			$error = new WP_Error(
				'save_failed',
				sprintf(
					// translators: %s: error message
					__( 'Unable to update settings. %s', 'woocommerce-shipping' ),
					$result->get_error_message()
				),
				array_merge(
					array( 'status' => 400 ),
					$result->get_error_data()
				)
			);
			$this->logger->log( $error, __CLASS__ );
			return $error;
		}

		return new WP_REST_Response( array( 'success' => true ), 200 );
	}
}
