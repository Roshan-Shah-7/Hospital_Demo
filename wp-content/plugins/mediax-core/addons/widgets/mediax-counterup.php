<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
/**
 *
 * Counter Up Widget .
 *
 */
class mediax_Counterup extends Widget_Base {

	public function get_name() {
		return 'mediaxcounterup';
	}
	public function get_title() {
		return __( 'Counter Up', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'counter_section',
			[
				'label' 	=> __( 'Counter Up', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two', 'Style Three'] ); 

		$repeater = new Repeater();

		$fields_to_include = [ 'title' => ['Number', 'After Prefix'], 'desc' => ['Description'], ];
		mediax_repeater_fields( $this, 'counter_lists', 'Counter List', $fields_to_include, ['1', '2', '3'] );

		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------General Style-------
		$this->start_controls_section(
			'general_styling',
			[
				'label'     => __( 'General Style', 'mediax' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition'		=> [ 
					'layout_style' => ['1', '3']
				],
			]
		);

		mediax_color_fields( $this, 'bg', 'Background', 'background', '{{WRAPPER}} .bg' );  
		mediax_dimensions_fields( $this, 'padding', 'Padding', 'padding', '{{WRAPPER}} .bg' ); 
		mediax_dimensions_fields( $this, 'border-radius', 'Border Radius', 'border-radius', '{{WRAPPER}} .bg' ); 

		$this->end_controls_section();

		//-------Number Style-------
		mediax_common_style_fields($this, 'number', 'Number', '{{WRAPPER}} .box-number');
		mediax_common_style_fields($this, 'number2', 'Prefix', '{{WRAPPER}} .plus');
		//-------Title Style-------
		mediax_common_style_fields($this, 'title', 'Title', '{{WRAPPER}} .box-text');
		

	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="counter-card-wrap bg">';
				foreach( $settings['counter_lists'] as $data ){
					echo '<div class="counter-card">';
						if(!empty($data['number'])){
							echo '<h2 class="box-number">';
								echo '<span class="number"><span class="counter-number">'.wp_kses_post( $data['number'] ).'</span></span>';
								echo '<span class="plus">'.wp_kses_post( $data['after_prefix'] ).'</span>';
							echo '</h2>';
						}
						if(!empty($data['description'])){
							echo '<p class="box-text">'.wp_kses_post( $data['description'] ).'</p>';
						}
					echo '</div>';
					echo '<div class="divider"></div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="counter-grid-wrap">';
				foreach( $settings['counter_lists'] as $data ){
					echo '<div class="counter-grid">';
						if(!empty($data['number'])){
							echo '<h2 class="box-number">';
								echo '<span class="number"><span class="counter-number">'.wp_kses_post( $data['number'] ).'</span></span>';
								echo '<span class="plus">'.wp_kses_post( $data['after_prefix'] ).'</span>';
							echo '</h2>';
						}
						if(!empty($data['description'])){
							echo '<p class="box-text">'.wp_kses_post( $data['description'] ).'</p>';
						}
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="counter-card-wrap bg">';
				foreach( $settings['counter_lists'] as $data ){
					echo '<div class="counter-card">';
						if(!empty($data['number'])){
							echo '<h2 class="box-number">';
								echo '<span class="number"><span class="counter-number">'.wp_kses_post( $data['number'] ).'</span></span>';
								echo '<span class="plus">'.wp_kses_post( $data['after_prefix'] ).'</span>';
							echo '</h2>';
						}
						if(!empty($data['description'])){
							echo '<p class="box-text">'.wp_kses_post( $data['description'] ).'</p>';
						}
					echo '</div>';
					echo '<div class="divider"></div>';
				}
			echo '</div>';
		}

	
	}

}