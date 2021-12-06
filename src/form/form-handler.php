<?php
/**
 * @since   1.0.0
 *
 * @package Elementor Form Builder
 */

namespace Elform;

defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;
use Elementor\Utils;

/**
 * Class FormHandler
 */
class FormHandler {

	private static $instance = null;

	private $to;

	private $subject;

	private $from;

	private $name;

	private $message;

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new FormHandler();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since  1.0.0
	 *
	 * @access private
	 */
	private function hooks() {
		add_action( 'wp_ajax_elementor_form_builder_form_ajax', array( $this, 'elementor_form_builder_form_ajax' ) );
		add_action( 'wp_ajax_nopriv_elementor_form_builder_form_ajax', array( $this, 'elementor_form_builder_form_ajax' ) );
	}

	/**
	 * Form data.
	 *
	 * @since  1.0.0
	 *
	 * @access private
	 */
	private function form_data( string $to, string $subject, string $from, string $name ) {
		$this->to      = $to;
		$this->subject = $subject;
		$this->from    = $from;
		$this->name    = $name;
	}

	/**
	 * Send email.
	 *
	 * @since  1.0.0
	 *
	 * @access private
	 */
	private function send_email() {
		$headers = 'From: ' . $this->name . ' <' . $this->from . '>';

		return wp_mail( $this->to, $this->subject, $this->message, $headers );
	}

	/**
	 * Form ajax.
	 *
	 * @since  1.0.0
	 *
	 * @access public
	 */
	public function elementor_form_builder_form_ajax() {

		check_ajax_referer( 'elementor_form_builder_form', 'nonce' );

		$data    = sanitize_text_field( $_POST['data'] );
		$post_id = sanitize_text_field( $_POST['post_id'] );
		$el_id   = sanitize_text_field( $_POST['el_id'] );

		if ( $data ) {
			$document = Plugin::$instance->documents->get( $post_id );

			if ( $document ) {
				$form        = Utils::find_element_recursive( $document->get_elements_data(), $el_id );
				$settings    = $form['settings'];
				$redirect    = isset( $settings['redirect'] ) ? true : false;
				$redirect_to = isset( $settings['redirect_url'] ) ? $settings['redirect_url'] : '';
				$to          = isset( $settings['email_to'] ) ? $settings['email_to'] : '';
				$subject     = isset( $settings['email_subject'] ) ? $settings['email_subject'] : '';
				$from        = isset( $settings['email_from'] ) ? $settings['email_from'] : '';
				$name        = isset( $settings['email_name'] ) ? $settings['email_name'] : '';

				$args = array(
					'redirect'        => $redirect,
					'redirect_to'     => $redirect_to,
					'error_message'   => $settings['error_message'],
					'success_message' => $settings['success_message'],
				);

				$this->message = $data;
				$this->form_data( $to, $subject, $from, $name );

				$send = $this->send_email();

				if ( is_wp_error( $send ) ) {
					wp_send_json_error( $args, 500 );
				} else {
					wp_send_json_success( $args, 200 );
				}
			}
		}

		wp_die();
	}
}

FormHandler::instance();
