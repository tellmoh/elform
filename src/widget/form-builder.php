<?php
namespace Elform\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elform\FormBase;

/**
 * Elementor Form Builder Widget.
 *
 * @since 1.0.0
 */
class FormBuilder extends FormBase {
	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'elform';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elementor Form Builder', 'elform' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'elform' );
	}

	/**
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {
		return array( 'elform' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_fields',
			array(
				'label' => __( 'Form Fields', 'elform' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'field_type',
			array(
				'label'   => __( 'Type', 'elform' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'Text',
				'options' => array(
					'Text'      => __( 'Text', 'elform' ),
					'Email'     => __( 'Email', 'elform' ),
					'Textarea'  => __( 'Textarea', 'elform' ),
					'URL'       => __( 'URL', 'elform' ),
					'Tel'       => __( 'Tel', 'elform' ),
					'Radio'     => __( 'Radio', 'elform' ),
					'Select'    => __( 'Select', 'elform' ),
					'Checkbox'  => __( 'Checkbox', 'elform' ),
					'Number'    => __( 'Number', 'elform' ),
					'Date'      => __( 'Date', 'elform' ),
					'Time'      => __( 'Time', 'elform' ),
					'File'      => __( 'File', 'elform' ),
					'Password'  => __( 'Password', 'elform' ),
					'HTML'      => __( 'HTML', 'elform' ),
					'Hidden'    => __( 'Hidden', 'elform' ),
					'reCAPTCHA' => __( 'reCAPTCHA', 'elform' ),
				),
			)
		);

		$repeater->add_control(
			'rows',
			array(
				'label'      => __( 'Rows', 'elform' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 4,
				'conditions' => array(
					'terms' => array(
						array(
							'name'  => 'field_type',
							'value' => 'Textarea',
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_options',
			array(
				'label'       => __( 'Options', 'elform' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Enter each option with space.', 'elform' ),
				'placeholder' => __( 'one two three', 'elform' ),
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => 'in',
							'value'    => array(
								'Select',
								'Checkbox',
								'Radio',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'file_types',
			array(
				'label'       => __( 'Allowed File Types', 'elform' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( '.pdf,.jpg,.txt', 'elform' ),
				'conditions'  => array(
					'terms' => array(
						array(
							'name'  => 'field_type',
							'value' => 'File',
						),
					),
				),
			)
		);

		$repeater->add_control(
			'multiple_files',
			array(
				'label'        => __( 'Multiple Files', 'elform' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'multiple_files',
				'conditions'   => array(
					'terms' => array(
						array(
							'name'  => 'field_type',
							'value' => 'File',
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_html',
			array(
				'label'      => __( 'HTML', 'elform' ),
				'type'       => Controls_Manager::TEXTAREA,
				'conditions' => array(
					'terms' => array(
						array(
							'name'  => 'field_type',
							'value' => 'HTML',
						),
					),
				),
			)
		);

		$repeater->add_control(
			'type_hr',
			array(
				'type'       => Controls_Manager::DIVIDER,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'reCAPTCHA',
								'Hidden',
								'HTML',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_label',
			array(
				'label'      => __( 'Label', 'elform' ),
				'type'       => Controls_Manager::TEXT,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'Hidden',
								'reCAPTCHA',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'site_key',
			array(
				'label'      => __( 'Site Key', 'elform' ),
				'type'       => Controls_Manager::TEXT,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => 'in',
							'value'    => array(
								'reCAPTCHA',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_placeholder',
			array(
				'label'      => __( 'Placeholder', 'elform' ),
				'type'       => Controls_Manager::TEXT,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'reCAPTCHA',
								'Hidden',
								'HTML',
								'Radio',
								'Checkbox',
								'Select',
								'Date',
								'Time',
								'File',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_default_value',
			array(
				'label'      => __( 'Default value', 'elform' ),
				'type'       => Controls_Manager::TEXT,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => 'in',
							'value'    => array(
								'Text',
								'Email',
								'URL',
								'Tel',
								'Number',
								'Hidden',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_name',
			array(
				'label'       => __( 'Name', 'elform' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Name is required. It is used to send the data to your email.', 'elform' ),
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'reCAPTCHA',
								'HTML',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'width_hr',
			array(
				'type'       => Controls_Manager::DIVIDER,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'reCAPTCHA',
								'Hidden',
							),
						),
					),
				),
			)
		);

		$repeater->add_responsive_control(
			'field_width',
			array(
				'label'      => __( 'Column Width', 'elform' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => '100',
				'options'    => array(
					'20'  => __( '20%', 'elform' ),
					'25'  => __( '25%', 'elform' ),
					'33'  => __( '33%', 'elform' ),
					'40'  => __( '40%', 'elform' ),
					'50'  => __( '50%', 'elform' ),
					'60'  => __( '60%', 'elform' ),
					'66'  => __( '66%', 'elform' ),
					'75'  => __( '75%', 'elform' ),
					'80'  => __( '80%', 'elform' ),
					'100' => __( '100%', 'elform' ),
				),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'Hidden',
								'reCAPTCHA',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'required_hr',
			array(
				'type'       => Controls_Manager::DIVIDER,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'Checkbox',
								'reCAPTCHA',
								'Hidden',
								'HTML',
								'Radio',
								'Checkbox',
								'Select',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_required',
			array(
				'label'        => __( 'Required', 'elform' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'elform' ),
				'label_off'    => __( 'No', 'elform' ),
				'return_value' => 'yes',
				'conditions'   => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'Checkbox',
								'reCAPTCHA',
								'Hidden',
								'HTML',
								'Radio',
								'Checkbox',
								'Select',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'class_hr',
			array(
				'type'       => Controls_Manager::DIVIDER,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'reCAPTCHA',
								'Hidden',
								'HTML',
								'Radio',
								'Checkbox',
								'Select',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_class',
			array(
				'label'      => __( 'Custom Class', 'elform' ),
				'type'       => Controls_Manager::TEXT,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'reCAPTCHA',
								'Hidden',
								'HTML',
								'Radio',
								'Checkbox',
								'Select',
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'field_id',
			array(
				'label'      => __( 'Custom ID', 'elform' ),
				'type'       => Controls_Manager::TEXT,
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'field_type',
							'operator' => '!in',
							'value'    => array(
								'HTML',
								'Radio',
								'Checkbox',
								'Select',
								'reCAPTCHA',
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'fields',
			array(
				'label'       => __( 'Fields', 'elform' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'field_type'  => 'Text',
						'field_name'  => 'name',
						'field_label' => 'Name',
					),
					array(
						'field_type'  => 'Email',
						'field_name'  => 'email',
						'field_label' => 'Email',
					),
					array(
						'field_type'  => 'Textarea',
						'field_name'  => 'msg',
						'field_label' => 'Message',
					),
				),
				'title_field' => '{{{ field_type }}}',
			)
		);

		$this->add_control(
			'list_hr',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'show_label',
			array(
				'label'        => __( 'Label', 'elform' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Show', 'elform' ),
				'label_off'    => __( 'Hide', 'elform' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_required_mark',
			array(
				'label'        => __( 'Required Mark', 'elform' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'elform' ),
				'label_off'    => __( 'Hide', 'elform' ),
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			array(
				'label' => __( 'Button', 'elform' ),
			)
		);

		$this->add_control(
			'button_text_align',
			array(
				'label'     => __( 'Alignment', 'elform' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'elform' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'elform' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'elform' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .elform-form-button-wrap' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => __( 'Text', 'elform' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Send',
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label'   => __( 'Icon', 'elform' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'button_icon_position',
			array(
				'label'   => __( 'Icon Position', 'elform' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'  => array(
						'title' => __( 'Left', 'elform' ),
						'icon'  => 'fa fa-align-left',
					),
					'right' => array(
						'title' => __( 'Right', 'elform' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default' => 'left',
				'toggle'  => true,
			)
		);

		$this->add_control(
			'button_id',
			array(
				'label' => __( 'Button ID', 'elform' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_messages',
			array(
				'label' => __( 'Messages', 'elform' ),
			)
		);

		$this->add_control(
			'success_message',
			array(
				'label'   => __( 'Success Message', 'elform' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Your message has been sent', 'elform' ),
				'rows'    => 5,
			)
		);

		$this->add_control(
			'error_message',
			array(
				'label'   => __( 'Error Message', 'elform' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Can\'t send the email', 'elform' ),
				'rows'    => 5,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_redirect',
			array(
				'label' => __( 'Redirect', 'elform' ),
			)
		);

		$this->add_control(
			'redirect',
			array(
				'label'        => __( 'Redirect to another URL', 'elform' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'elform' ),
				'label_off'    => __( 'No', 'elform' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'redirect_url',
			array(
				'label'       => __( 'Redirect To', 'elform' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'https://your-link.com', 'elform' ),
				'condition'   => array(
					'redirect' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_email',
			array(
				'label' => __( 'Email', 'elform' ),
			)
		);

		$this->add_control(
			'email_to',
			array(
				'label' => __( 'To', 'elform' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'email_subject',
			array(
				'label' => __( 'Subject', 'elform' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'subject_hr',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'email_from',
			array(
				'label' => __( 'From Email', 'elform' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'email_name',
			array(
				'label' => __( 'From Name', 'elform' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_style',
			array(
				'label' => __( 'Fields', 'elform' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$field_selector = '{{WRAPPER}} .elform-style-field';

		$this->typography( 'field_typography', $field_selector );
		$this->color( 'field_color', $field_selector );
		$this->padding( 'field_padding', $field_selector );
		$this->margin( 'field_margin', $field_selector );
		$this->border( 'field_border', $field_selector );
		$this->background( 'field_background', $field_selector );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => __( 'Button', 'elform' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$btn_selector = '{{WRAPPER}} .elform-form-button';

		$this->typography( 'btn_typography', $btn_selector );
		$this->color( 'btn_color', $btn_selector );
		$this->padding( 'btn_padding', $btn_selector );
		$this->margin( 'btn_margin', $btn_selector );
		$this->border( 'btn_border', $btn_selector );
		$this->background( 'btn_background', $btn_selector );

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$fields   = $settings['fields'];
		?>

		<form class="elform-form" method="post" data-post_id="<?php echo esc_attr( get_the_ID() ); ?>" data-el_id="<?php echo esc_attr( $this->get_id() ); ?>">
		<?php
		if ( $fields ) {
			foreach ( $fields as $field ) {
				$width  = $field['field_width'] ? $field['field_width'] : '';
				$params = array(
					'type'           => $field['field_type'] ? strtolower( $field['field_type'] ) : '',
					'label'          => $field['field_label'] ? $field['field_label'] : '',
					'placeholder'    => $field['field_placeholder'] ? $field['field_placeholder'] : '',
					'value'          => $field['field_default_value'] ? $field['field_default_value'] : '',
					'name'           => $field['field_name'] ? $field['field_name'] : '',
					'width'          => $field['field_width'] ? $field['field_width'] : '',
					'required'       => $field['field_required'] ? $field['field_required'] : '',
					'id'             => $field['field_id'] ? $field['field_id'] : '',
					'class'          => $field['field_class'] ? $field['field_class'] : '',
					'rows'           => $field['rows'] ? $field['rows'] : '',
					'options'        => $field['field_options'] ? $field['field_options'] : '',
					'multiple_files' => $field['multiple_files'] ? $field['multiple_files'] : '',
					'file_types'     => $field['file_types'] ? $field['file_types'] : '',
					'html'           => $field['field_html'] ? $field['field_html'] : '',
					'is_label'       => $settings['show_label'] ? true : false,
					'is_mark'        => $settings['show_required_mark'] ? true : false,
				);

				echo '<div class="elform-fields elementor-repeater-item-' . esc_attr( $field['_id'] ) . ' efb-field-width-' . esc_attr( $width ) . '">';

				switch ( $field['field_type'] ) {
					case 'Text':
					case 'URL':
					case 'Tel':
					case 'Number':
					case 'Date':
					case 'Time':
					case 'File':
					case 'Password':
					case 'Email': {
						$this->input( $params );
						break;
					}

					case 'Textarea': {
						$this->textarea( $params );
						break;
					}

					case 'Select':
					case 'Checkbox':
					case 'Radio': {
						$this->multi( $params );
						break;
					}

					case 'HTML': {
						$this->html( $params['html'], $params['label'], $params['is_label'] );
						break;
					}

					case 'Hidden': {
						$this->hidden( $params['value'], $params['name'], $params['id'], );
						break;
					}

					case 'reCAPTCHA': {
						$this->reCAPTCHA( $field['site_key'] );

						break;
					}

					default:
						break;
				}

				echo '</div>';
			}
		}

		$this->button(
			$settings['button_text'],
			$settings['button_icon'],
			$settings['button_icon_position'],
			$settings['button_id']
		);
		?>

		</form>
		<div class="elform-form-msg"></div>
		<?php
	}
}
