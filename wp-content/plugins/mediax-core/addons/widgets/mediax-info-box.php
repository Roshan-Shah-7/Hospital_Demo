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
 * Info Box Widget .
 *
 */
class mediax_Info_Box extends Widget_Base {

	public function get_name() {
		return 'mediaxinfobox';
	}
	public function get_title() {
		return __( 'Info Box', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		 $this->start_controls_section(
			'section_title_section',
			[
				'label'		 	=> __( 'Info Box', 'mediax' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
				
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', ['Style One'] );

		// Layout Style 1
		$fields_to_include = [ 'title' => ['Title'], 'desc' => ['Content'] ];
		mediax_repeater_fields( $this, 'working_lists', 'Working Lists', $fields_to_include, [ '1' ] );

        $this->end_controls_section();


        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		mediax_common_style_fields( $this, 'desc2', 'Schedule Lists', '{{WRAPPER}} .box-text', ['1']);
		

	}

	protected function render() {

        $settings = $this->get_settings_for_display();

			if( $settings['layout_style'] == '1' ){
				echo '<div class="tab-schedule">';
					foreach( $settings['working_lists'] as $data ){
						echo '<p class="box-text">'.esc_html($data['title']).'<span>'.esc_html($data['content']).'</span></p>';
					}
				echo '</div>';
				
			}

	}

}