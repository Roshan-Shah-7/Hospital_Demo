<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;  

// Color field
// mediax_color_fields($th, $id, $label, $property, $selector, $condition = null);
if (!function_exists('mediax_color_fields')) {
    function mediax_color_fields($th, $id, $label, $property, $selector, $condition = null) {
        $control_args = [
            'label'      => __( $label, 'mediax' ),
            'type'       => Controls_Manager::COLOR,
            'selectors'  => [
                $selector => $property . ': {{VALUE}};',
            ],
        ];

        if (!empty($condition)) {
            $control_args['condition'] = [
                'layout_style' => $condition,
            ];
        }

        $th->add_control($id, $control_args);
    }
}

// Typography field
// mediax_typography_fields($th, $id, $label, $selector, $condition = null);
if (!function_exists('mediax_typography_fields')) {
    function mediax_typography_fields($th, $id, $label, $selector, $condition = null) {
        $control_args = [
            'name' 		=> $id,
            'label'      => __( $label, 'mediax' ),
            'selector' 	=>  $selector,
        ];

        if (!empty($condition)) {
            $control_args['condition'] = [
                'layout_style' => $condition,
            ];
        }

        $th->add_group_control(Group_Control_Typography::get_type(), $control_args);
    }
}

// Dimensions field - margin, padding, border-radious
// mediax_dimensions_fields($th, $id, $label, $property, $selector, $condition = null);
if (!function_exists('mediax_dimensions_fields')) {
    function mediax_dimensions_fields($th, $id, $label, $property, $selector, $condition = null) {
        $control_args = [
            'label'      => __( $label, 'mediax' ),
            'type' 			=> Controls_Manager::DIMENSIONS,
            'size_units' 	=> [ 'px', '%', 'em' ],
            'selectors' 	=> [
                $selector => $property . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ];

        if (!empty($condition)) {
            $control_args['condition'] = [
                'layout_style' => $condition,
            ];
        }

        $th->add_responsive_control($id, $control_args);
    }
}

// Common Style fields - Color, Typography, Margin & padding
// mediax_common_style_fields($th, $id, $label, $selector, $condition = null, $p = 'color');
if (!function_exists('mediax_common_style_fields')) {
    function mediax_common_style_fields($th, $id, $label, $selector, $condition = null, $p = 'color') {
       
        $control_args = [
            'label'      => __( $label, 'mediax' ),
            'tab' 		=> Controls_Manager::TAB_STYLE,
        ];
        if (!empty($condition)) {
            $control_args['condition'] = [
                'layout_style' => $condition,
            ];
        }
        $th->start_controls_section($id.'title_style_section', $control_args);

		$th->add_control(
			$id.'color',
			[
				'label' 	=> __( 'Color', 'mediax' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors'  => [
					$selector => $p . ': {{VALUE}}',
				],
			]
        );

		$th->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> $id.'typography',
				'label' 	=> __( 'Typography', 'mediax' ),
				'selector' 	=> $selector
			]
		);

		$th->add_responsive_control(
			$id.'margin',
			[
				'label' 		=> __( 'Margin', 'mediax' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$th->add_responsive_control(
			$id.'padding',
			[
				'label' 		=> __( 'Padding', 'mediax' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$th->end_controls_section();

    }
}

// Common2 Style fields - Color, Hover Color, Typography, Margin & padding
// mediax_common2_style_fields($th, $id, $label, $selector, $condition = null, $p = 'color', $p2 = 'color')
if (!function_exists('mediax_common2_style_fields')) {
    function mediax_common2_style_fields($th, $id, $label, $selector, $condition = null, $p = 'color', $p2 = 'color') {
       
        $control_args = [
            'label'      => __( $label, 'mediax' ),
            'tab' 		=> Controls_Manager::TAB_STYLE,
        ];
        if (!empty($condition)) {
            $control_args['condition'] = [
                'layout_style' => $condition,
            ];
        }
        $th->start_controls_section($id.'title_style_section', $control_args);

		$th->add_control(
			$id.'color',
			[
				'label' 	=> __( 'Color', 'mediax' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors'  => [
					$selector => $p . ': {{VALUE}}',
				],
			]
        );

		$th->add_control(
			$id.'hover_color',
			[
				'label' 	=> __( 'Hover Color', 'mediax' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors'  => [
					$selector . ':hover' => $p2 . ': {{VALUE}}',
				],
			]
        );

		$th->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> $id.'typography',
				'label' 	=> __( 'Typography', 'mediax' ),
				'selector' 	=> $selector
			]
		);

		$th->add_responsive_control(
			$id.'margin',
			[
				'label' 		=> __( 'Margin', 'mediax' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$th->add_responsive_control(
			$id.'padding',
			[
				'label' 		=> __( 'Padding', 'mediax' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$th->end_controls_section();

    }
}



// Button Style field
// mediax_button_style_fields($th, $id, $label, $selector, $condition = null)
if (!function_exists('mediax_button_style_fields')) {
    function mediax_button_style_fields($th, $id, $label, $selector, $condition = null) {
       
        $control_args = [
            'label'      => __( $label, 'mediax' ),
            'tab' 		=> Controls_Manager::TAB_STYLE,
        ];
        if (!empty($condition)) {
            $control_args['condition'] = [
                'layout_style' => $condition,
            ];
        }

        $th->start_controls_section($id.'button_style_section', $control_args);

		$th->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> $id.'button_typography',
				'label' 	=> __( 'Typography', 'mediax' ),
				'selector' 	=> $selector
			]
		);

		$th->add_control(
			$id.'button_color',
			[
				'label' 		=> __( 'Color', 'mediax' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					$selector => 'color: {{VALUE}}',
				],
			]
		);

		$th->add_control(
			$id.'button_bg',
			[
				'label' 		=> __( 'Background Color', 'mediax' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					$selector => '--theme-color:{{VALUE}}',
				],
			]
		);
		$th->add_control(
			$id.'button_bg2',
			[
				'label' 		=> __( 'Background Color 2', 'mediax' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					$selector => '--color2:{{VALUE}}',
				],
			]
		);
		$th->add_control(
			$id.'button_bg3',
			[
				'label' 		=> __( 'Background Color 3', 'mediax' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					$selector => '--color3:{{VALUE}}',
				],
			]
		);
		$th->add_control(
			$id.'button_bg4',
			[
				'label' 		=> __( 'Background Color 4', 'mediax' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					$selector => '--color4:{{VALUE}}',
				],
			]
		);

		$th->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => $id.'border',
				'selector' => $selector
			]
		);
		$th->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => $id.'box_shadow',
				'selector' => $selector,
			]
		);

		$th->add_responsive_control(
			$id.'button_margin',
			[
				'label' 		=> __( 'Margin', 'mediax' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$th->add_responsive_control(
			$id.'button_padding',
			[
				'label' 		=> __( 'Padding', 'mediax' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$th->add_responsive_control(
			$id.'button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'mediax' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$th->end_controls_section();

    }
}
