<?php
/**
 * @since   1.0.0
 *
 * @package Elementor Form Builder
 */

namespace Elform;

defined( 'ABSPATH' ) || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

abstract class WidgetBase extends Widget_Base {

	protected function typography( string $name, string $selector ) {
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => $name,
				'label'    => __( 'Typography', 'elform' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => $selector,
			)
		);
	}

	protected function color( string $name, string $selector ) {
		$this->add_control(
			$name,
			array(
				'label'     => __( 'Color', 'elform' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'selectors' => array(
					$selector => 'color: {{VALUE}}',
				),
			)
		);
	}

	protected function padding( string $name, string $selector ) {
		$this->add_responsive_control(
			$name,
			array(
				'label'      => __( 'Padding', 'elform' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
	}

	protected function margin( string $name, string $selector ) {
		$this->add_responsive_control(
			$name,
			array(
				'label'      => __( 'Margin', 'elform' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
	}

	protected function border( string $name, string $selector ) {
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => $name,
				'label'    => __( 'Border', 'elform' ),
				'selector' => $selector,
			)
		);
	}

	protected function background( string $name, string $selector ) {
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => $name,
				'label'    => __( 'Background', 'elform' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => $selector,
			)
		);
	}
}
