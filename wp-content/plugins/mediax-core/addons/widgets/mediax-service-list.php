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
 * Service Lists Widget .
 *
 */
class mediax_Service_List extends Widget_Base {

	public function get_name() {
		return 'mediaxservicelist';
	}
	public function get_title() {
		return __( 'Service Lists', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		 $this->start_controls_section(
			'service_section',
			[
				'label'     => __( 'Service Lists', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One'] );

		mediax_general_fields($this, 'title', 'Title', 'TEXTAREA2', 'All Services');

		// Layout Style 1
		$fields_to_include = [ 'title' => ['Title'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'service_list', 'Service Lists', $fields_to_include );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .widget_title' );


	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="widget widget_categories">';
				if($settings['title']){
					echo '<h3 class="widget_title">'.wp_kses_post($settings['title']).'</h3>';
				}
				echo '<ul>';
					foreach( $settings['service_list'] as $data ){
						if(!empty($data['title'])){
							echo '<li>';
								echo '<a href="'.esc_url( $data['url']['url'] ).'">'.wp_kses_post($data['title']).'</a>';
							echo '</li>';
						}
					}
				echo '</ul>';
			echo '</div>';

		}
	

	}

}