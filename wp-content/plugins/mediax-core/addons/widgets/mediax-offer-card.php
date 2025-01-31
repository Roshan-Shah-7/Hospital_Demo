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
 * Offer Card Widget .
 *
 */
class Mediax_Offer_Card extends Widget_Base {

	public function get_name() {
		return 'mediaxoffercard';
	}
	public function get_title() {
		return __( 'Offer Card', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {


		$this->start_controls_section(
			'offer_card_section',
			[
				'label'		 	=> __( 'Offer Card', 'mediax' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
				
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two'] );

		// Layout Style 1
		$fields_to_include = [ 'image' => ['Choose Image'], 'title' => ['Subtitle', 'Title'], 'desc' => ['Description'], 'btn' => ['Button Text'], 'url' => ['Button URL'] ];
		mediax_repeater_fields( $this, 'offer_card', 'Offer Card', $fields_to_include, [ '1' ] );

		mediax_media_fields( $this, 'image', 'Choose Image', ['2'] );
		mediax_general_fields( $this, 'subtitle', 'Subtitle', 'TEXTAREA2', 'Subtitle', ['2'] );
		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Title', ['2'] );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', 'Description', ['2'] );
		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXT', 'Button Text', [ '2' ] );
		mediax_url_fields( $this, 'button_url', 'Button URL', [ '2' ] );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'subtitle', 'Subtitle', '{{WRAPPER}} .sub' );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title' );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .desc' );
		//------Button Style-------
		mediax_button_style_fields( $this, '10', 'Button Styling', '{{WRAPPER}} .th_btn' );

	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
            echo '<div class="row gy-30 justify-content-center">';
            foreach( $settings['offer_card'] as $key => $data ){
				if($key==0){
					$active = 'style4';
				}elseif($key==1){
					$active = 'style2';
				}else{
					$active = '';
				}
                echo '<div class="col-xl-4 col-md-6">';
                    echo '<div class="offer-card mega-hover" data-bg-src="'.esc_url($data['choose_image']['url']).'">';
                        if(!empty($data['subtitle'])){
                            echo '<span class="h6 box-subtitle sub">'.wp_kses_post($data['subtitle']).'</span>';
                        }
                        if(!empty($data['title'])){
                            echo '<h3 class="box-title title">'.wp_kses_post($data['title']).'</h3>';
                        }
                        if(!empty($data['description'])){
                            echo '<p class="price desc">'.wp_kses_post($data['description']).'</p>';
                        }
                        if(!empty($data['button_text'])){
                            echo '<a href="'.esc_url( $data['button_url']['url'] ).'" class="th-btn btn-sm '.esc_attr($active).' th_btn">'.wp_kses_post($data['button_text']).'</a>';
                        }
                    echo '</div>';
                echo '</div>';
            }
            echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="offer-grid mega-hover text-center text-xl-start" data-bg-src="'.esc_url($settings['image']['url']).'">';
				if(!empty($settings['subtitle'])){
					echo '<span class="h6 box-subtitle sub">'.wp_kses_post($settings['subtitle']).'</span>';
				}
				if(!empty($settings['desc'])){
					echo '<p class="price desc">'.wp_kses_post($settings['desc']).'</p>';
				}
				if(!empty($settings['title'])){
					echo '<h3 class="box-title title">'.wp_kses_post($settings['title']).'</h3>';
				}
				if(!empty($settings['button_text'])){
					echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn btn-sm style7 th_btn">'.wp_kses_post($settings['button_text']).'</a>';
				}
			echo '</div>';

		}
		

	}

}