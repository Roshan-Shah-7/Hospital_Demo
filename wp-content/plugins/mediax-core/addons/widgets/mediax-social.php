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
 * Social Widget .
 *
 */
class Mediax_Social extends Widget_Base { 

	public function get_name() {
		return 'mediaxsocial';
	}
	public function get_title() {
		return __( 'Social', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		 $this->start_controls_section(
			'social_section',
			[
				'label'     => __( 'Social', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One','Style Two'] );
		
		//Social List
		mediax_social_fields($this, 'social_icon_list', 'Social List', ['1']);

		
		$fields_to_include = [ 'title' => ['Icon'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'social_list_two', 'Social List', $fields_to_include, ['2'] );


        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------


	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="th-social">';
				foreach( $settings['social_icon_list'] as $social_icon ){
					$social_target    = $social_icon['icon_link']['is_external'] ? ' target="_blank"' : '';
					$social_nofollow  = $social_icon['icon_link']['nofollow'] ? ' rel="nofollow"' : '';

					echo '<a '.wp_kses_post( $social_target.$social_nofollow ).' href="'.esc_url( $social_icon['icon_link']['url'] ).'">';

					\Elementor\Icons_Manager::render_icon( $social_icon['social_icon'], [ 'aria-hidden' => 'true' ] );

					echo '</a> ';
				}
			echo '</div>';
		}elseif($settings['layout_style'] == '2'){
			echo '<div class="th-social">';
				foreach( $settings['social_list_two'] as $social_icon ){
                	echo '<a href="'.esc_url( $social_icon['url']['url'] ).'"><i class="'.esc_attr($social_icon['icon']).'"></i></a>';
                }	
            echo '</div>';
		}


	}

}