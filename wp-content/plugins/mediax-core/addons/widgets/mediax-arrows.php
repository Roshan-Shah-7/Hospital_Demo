<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Repeater;
/**
 *
 * Arrows Widget .
 *
 */
class mediax_Arrows extends Widget_Base {

	public function get_name() {
		return 'mediaxarrows';
	}
	public function get_title() {
		return __( 'Slider Arrow', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'arrow_section',
			[
				'label'     => __( 'Slider Arrows', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One'] );

		mediax_general_fields($this, 'arrow_id', 'Arrow ID or Class', 'TEXT', '#teamSlider2');
		mediax_general_fields($this, 'arrow_extra_class', 'Arrow Extra Class', 'TEXT', '');

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------


	}

	protected function render() {

    $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="sec-btn '.esc_attr($settings['arrow_extra_class']).'">';
				echo '<div class="icon-box">';
					echo '<button data-slider-prev="'.esc_attr($settings['arrow_id']).'" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>';
					echo '<button data-slider-next="'.esc_attr($settings['arrow_id']).'" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>';
				echo '</div>';
			echo '</div>';
		}
			
	}
}