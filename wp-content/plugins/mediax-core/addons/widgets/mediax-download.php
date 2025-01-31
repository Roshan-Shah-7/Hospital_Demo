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
 * Download Widget . 
 *
 */
class Mediax_Download extends Widget_Base {

	public function get_name() {
		return 'mediaxdownload';
	}
	public function get_title() {
		return __( 'Download', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'download_section',
			[
				'label' 	=> __( 'Download', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One'] );    

		mediax_general_fields($this, 'title', 'Title', 'TEXTAREA2', 'Download' );

		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXTAREA2', 'Button Text' );
		mediax_url_fields( $this, 'button_url', 'Button URL' );
		mediax_general_fields( $this, 'button_text2', 'Button Text 2', 'TEXTAREA2', 'Button Text' );
		mediax_url_fields( $this, 'button_url2', 'Button URL 2' );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .widget_title' );
       	//------Button Style-------
		mediax_button_style_fields($this, '10', 'Button Styling', '{{WRAPPER}} .th_btn');
		//------Button 2 Style-------
		mediax_button_style_fields($this, '11', 'Button 2 Styling', '{{WRAPPER}} .th_btn2');

	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="widget widget_download">';
				if($settings['title']){
					echo '<h4 class="widget_title">'.wp_kses_post($settings['title']).'</h4>';
				}
				echo '<div class="download-widget-wrap">';
					if(!empty($settings['button_text'])){
						echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn th_btn rounded-10">'.wp_kses_post( $settings['button_text'] ).'</a>';
					}
					if(!empty($settings['button_text2'])){
						echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn th_btn2 style4 rounded-10">'.wp_kses_post( $settings['button_text2'] ).'</a>';
					}
				echo '</div>';
			echo '</div>';

		}


	}

}