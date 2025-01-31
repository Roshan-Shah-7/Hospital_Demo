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
 * Step Widget .
 *
 */
class Mediax_Sliding_Text extends Widget_Base {

	public function get_name() {
		return 'mediaxsliding';
	}
	public function get_title() {
		return __( 'Sliding Text', 'mediax' );
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
				'label'		 	=> __( 'Sliding Content', 'mediax' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
        );

		 mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One'] );


		$fields_to_include = [ 'title' => ['Title'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'sliding_list', 'Sliding Text Lists', $fields_to_include, ['1'] );

        $this->end_controls_section();


        //---------------------------------------
			//Style Section Start
		//---------------------------------------
		
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title' );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .desc' );

	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="space overflow-hidden">';
		        echo '<div class="container-fluid p-0">';
		            echo '<div class="swiper th-slider marquee-slider1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":"auto"}},"autoplay":{"delay":0,"disableOnInteraction":false},"noSwiping":"true","speed":10000,"spaceBetween":40}\'>';
			            echo '<div class="swiper-wrapper">';
		                	foreach( $settings['sliding_list'] as $key => $data ){
			                    echo '<div class="swiper-slide">';
			                        echo '<div class="marquee-card">';
			                            echo '<a target="_blank" href="'.$data['url']['url'].'">'.esc_html($data['title']).'</a>';
			                            echo '<span class="star-icon">';
			                                echo '<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
			                                    <path d="M23.5039 5.484L25 1.44077L26.4961 5.48401C29.5853 13.8324 36.1676 20.4147 44.516 23.5039L48.5592 25L44.516 26.4961C36.1676 29.5853 29.5853 36.1676 26.4961 44.516L25 48.5592L23.5039 44.516C20.4147 36.1676 13.8324 29.5853 5.484 26.4961L1.44077 25L5.48401 23.5039C13.8324 20.4147 20.4147 13.8324 23.5039 5.484Z" stroke="currentColor" />
			                                </svg>';
			                            echo '</span>';
			                       	echo '</div>';
			                    echo '</div>';
			                }
			            echo '</div>';    
		            echo '</div>';
		        echo '</div>';
		    echo '</div>';  
		}
	

	}

}