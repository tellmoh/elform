<?php
/**
 * @since   1.0.0
 *
 * @package Elementor Form Builder
 */

namespace Elform;

defined( 'ABSPATH' ) || exit;

use Elementor\Widget_Base;
use Elementor\Icons_Manager;

abstract class FormBase extends WidgetBase {

	protected function input( array $params ) {

		$placeholder    = $params['placeholder'] ? 'placeholder=' . $params['placeholder'] . '' : '';
		$value          = $params['value'] ? 'value=' . $params['value'] . '' : '';
		$required       = $params['required'] ? 'required' : '';
		$id             = $params['id'] ? 'id=' . $params['id'] . '' : '';
		$class          = $params['class'] ? $params['class'] : '';
		$multiple_files = $params['multiple_files'] ? 'multiple' : '';
		$file_types     = $params['file_types'] ? 'accept=' . $params['file_types'] . '' : '';
		$name           = $params['name'] ? $params['name'] : '';
		$type           = $params['type'] ? $params['type'] : '';
		$label          = $params['label'] ? $params['label'] : '';
		$is_mark        = $params['is_mark'] ? $params['is_mark'] : '';
		$is_label       = $params['is_label'] ? $params['is_label'] : '';

		if ( $is_label ) {
			$this->label( $label );
		}

		if ( $required && $is_mark ) {
			$this->mark();
		}
		?>
			<input
				name="<?php echo esc_attr( $name ); ?>"
				type="<?php echo esc_attr( $type ); ?>"
				class="<?php echo esc_attr( $class ); ?> elform-style-field"
		<?php echo esc_attr( $placeholder ); ?>
		<?php echo esc_attr( $value ); ?>
		<?php echo esc_attr( $required ); ?>
		<?php echo esc_attr( $id ); ?>
		<?php echo esc_attr( $multiple_files ); ?>
		<?php echo esc_attr( $file_types ); ?>
			>
		<?php
	}

	protected function textarea( array $params ) {

		$placeholder = $params['placeholder'] ? 'placeholder=' . $params['placeholder'] . '' : '';
		$required    = $params['required'] ? 'required' : '';
		$id          = $params['id'] ? 'id=' . $params['id'] . '' : '';
		$class       = $params['class'] ? $params['class'] : '';
		$name        = $params['name'] ? $params['name'] : '';
		$label       = $params['label'] ? $params['label'] : '';
		$rows        = $params['rows'] ? $params['rows'] : '';
		$is_mark     = $params['is_mark'] ? $params['is_mark'] : '';
		$is_label    = $params['is_label'] ? $params['is_label'] : '';

		if ( $is_label ) {
			$this->label( $label );
		}

		if ( $required && $is_mark ) {
			$this->mark();
		}
		?>
			<textarea
				name="<?php echo esc_attr( $name ); ?>"
				class="<?php echo esc_attr( $class ); ?> elform-style-field"
				rows="<?php echo esc_attr( $rows ); ?>"
		<?php echo esc_attr( $placeholder ); ?>
		<?php echo esc_attr( $id ); ?>
		<?php echo esc_attr( $required ); ?>
			></textarea>
		<?php
	}

	protected function multi( array $params ) {

		$options  = $params['options'] ? $params['options'] : array();
		$required = $params['required'] ? 'required' : '';
		$name     = $params['name'] ? $params['name'] : '';
		$type     = $params['type'] ? $params['type'] : '';
		$label    = $params['label'] ? $params['label'] : '';
		$is_mark  = $params['is_mark'] ? $params['is_mark'] : '';
		$is_label = $params['is_label'] ? $params['is_label'] : '';

		if ( is_string( $options ) ) {
			$items = explode( ' ', $options );
		}

		if ( $is_label ) {
			$this->label( $label );
		}

		if ( $required && $is_mark ) {
			$this->mark();
		}

		if ( isset( $items ) ) {
			?>
				<div class="elform-multi-fields">
			<?php
			if ( $type === 'select' ) {
				?>
							<select name="<?php echo esc_attr( $name ); ?>">
				<?php
			}

			if ( $type === 'radio' ) {
				?>
							<div class="elform-radio-warp">
				<?php
			}

			if ( $type === 'checkbox' ) {
				?>
							<div class="elform-checkbox-warp">
				<?php
			}

			?>
			<?php
			foreach ( $items as $item ) {
				if ( $type === 'radio' ) {
					?>
								<input type="radio" name="<?php esc_attr_e( $name ); ?>" value="<?php esc_attr_e( $item ); ?>">
								<span><?php esc_attr_e( $item ); ?></span>
						 <?php
				}

				if ( $type === 'checkbox' ) {
					?>
								<span><?php esc_attr_e( $item ); ?></span>
								<input type="checkbox" name="<?php esc_attr_e( $name ); ?>" value="<?php esc_attr_e( $item ); ?>">
						<?php
				}

				if ( $type === 'select' ) {
					?>
								<option value="<?php esc_attr_e( $item ); ?>"><?php esc_attr_e( $item ); ?></option>
					  <?php
				}
			}
			?>
			<?php
			if ( $type === 'select' ) {
				?>
							</select>
				<?php
			}

			if ( $type === 'radio' ) {
				?>
							</div>
				<?php
			}

			if ( $type === 'checkbox' ) {
				?>
							</div>
				<?php
			}
			?>
				</div>
			<?php
		}
	}

	protected function html( string $html, string $label, string $is_label ) {

		if ( $is_label ) {
			$this->label( $label );
		}

		?>
			<div class="elform-field-html">
		<?php

		if ( $html ) {
			echo wp_kses_post( do_shortcode( $html ) );
		}

		?>
			</div>
		<?php
	}

	protected function hidden( string $value, string $name, string $id ) {

		$id    = $id ? 'id=' . $id . '' : '';
		$value = $value ? 'value=' . $value . '' : '';
		$name  = $name ? 'name=' . $name . '' : '';

		?>
			<input
				type="hidden"
		<?php echo esc_attr( $id ); ?>
		<?php echo esc_attr( $value ); ?>
		<?php echo esc_attr( $name ); ?>
			>
		<?php
	}

	protected function reCAPTCHA( string $site_key ) {
		if ( $site_key ) {
			?>
				<script src="https://www.google.com/recaptcha/api.js" async defer></script>
				<div class="g-recaptcha" data-sitekey="<?php echo esc_attr( $site_key ); ?>"></div>
			<?php
		}
	}

	protected function button(
		string $text,
		array $icon,
		string $position,
		string $id
	) {
		$id = $id ? 'id=' . $id . '' : '';

		?>
			<div class="elform-form-button-wrap" <?php echo esc_attr( $id ); ?>>
				<button class="elform-form-button" type="submit">
					<?php if ( $position === 'left' ) : ?>
						<?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
					<?php endif; ?>
					<?php esc_html_e( $text ); ?>
					<?php if ( $position === 'right' ) : ?>
						<?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
					<?php endif; ?>
				</button>
			</div>
		<?php
	}

	public function label( string $label ) {

		if ( $label ) {
			?>
				<label><?php echo esc_attr( $label ); ?></label>
			<?php
		}
	}

	public function mark() {
		?>
			<span style="color: red; ">*</span>
		<?php
	}
}
