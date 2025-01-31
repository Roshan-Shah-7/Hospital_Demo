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
 * CTA Widget .
 *
 */
class mediax_Cta extends Widget_Base {

	public function get_name() {
		return 'mediaxcta';
	}
	public function get_title() {
		return __( 'CTA', 'mediax' );
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
				'label'		 	=> __( 'CTA', 'mediax' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
				
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One', 'Style Two', 'Style Three', 'Style Four' ] );

		mediax_media_fields( $this, 'image', 'Choose Image', ['1', '2', '3','4'] );
		mediax_general_fields( $this, 'subtitle', 'Subtitle', 'TEXTAREA2', '', ['1'] );
		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', '', ['1', '2', '3','4'] );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', '', ['1', '2','4'] );

		$this->add_control(
			'date', [
				'label' 		=> __( 'Offer End Date With Time', 'mediax' ),
				'type' 			=> Controls_Manager::DATE_TIME,
				'label_block' 	=> true,
				'condition'	=> [
					'layout_style' => ['1'],
				]
			]
		);
		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXT', 'Button Text', [ '1','2', '3','4' ] );
		mediax_general_fields( $this, 'button_class', 'Button Extra Class', 'TEXT', '', [ '2','4' ] );
		mediax_url_fields( $this, 'button_url', 'Button URL', [ '1','2', '3','4' ] );

		mediax_general_fields( $this, 'heading', 'Cta 2', 'HEADING', '', ['1'] );

		mediax_media_fields( $this, 'image2', 'Choose Image', ['1'] );
		mediax_general_fields( $this, 'subtitle2', 'Subtitle', 'TEXTAREA2', '', ['1'] );
		mediax_general_fields( $this, 'title2', 'Title', 'TEXTAREA2', '', ['1'] );
		mediax_general_fields( $this, 'desc2', 'Description', 'TEXTAREA', '', ['1'] );
		mediax_general_fields( $this, 'button_text2', 'Button Text', 'TEXT', 'Button Text', [ '1' ] );
		mediax_url_fields( $this, 'button_url2', 'Button URL', [ '1' ] );
			
        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'subtitle', 'Subtitle', '{{WRAPPER}} .sub', ['1'] );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title', ['1', '2', '3','4'] );
		//-------Desc Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .desc', ['1', '2','4'] );
		//------Button Style-------
		mediax_button_style_fields( $this, '10', 'Button Styling', '{{WRAPPER}} .th_btn', ['1', '2', '3','4'] );

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'subtitle2', 'Subtitle 2', '{{WRAPPER}} .sub2', ['1'] );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title2', 'Title 2', '{{WRAPPER}} .title2', ['1'] );
		//-------Desc Style-------
		mediax_common_style_fields( $this, 'desc2', 'Description 2', '{{WRAPPER}} .desc2', ['1'] );
		//------Button 2 Style-------
		mediax_button_style_fields( $this, '11', 'Button 2 Styling', '{{WRAPPER}} .th_btn2', ['1'] );



	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			$offer_date_end = $settings['date'];
			$replace 	= array('-');
			$with 		= array('/');

			$date 	= str_replace( $replace, $with, $offer_date_end );

			echo '<div class="container-fluid px-xl-0 z-index-common">';
				echo '<div class="row gy-30">';
					echo '<div class="col-xl-8">';
						echo '<div class="offer-block mega-hover" data-bg-src="'.esc_url($settings['image']['url']).'">';
							if($settings['subtitle']){
								echo '<span class="h6 box-subtitle sub">'.wp_kses_post($settings['subtitle']).'</span>';
							}
							if($settings['title']){
								echo '<h2 class="sec-title title">'.wp_kses_post($settings['title']).'</h2>';
							}
							if($settings['desc']){
								echo '<p class="box-text desc">'.wp_kses_post($settings['desc']).'</p>';
							}
							if(!empty($settings['button_text'])){
								echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn th_btn">'.wp_kses_post($settings['button_text']).'</a>';
							}
							echo '<ul class="counter-list countdown-style1" data-offer-date="'.esc_attr($date).'">';
								echo '<li>';
									echo '<div>';
										echo '<div class="day count-number">00</div>';
										echo '<span class="count-name">Days</span>';
									echo '</div>';
								echo '</li>';
								echo '<li>';
									echo '<div>';
										echo '<div class="hour count-number">00</div>';
										echo '<span class="count-name">Hours</span>';
									echo '</div>';
								echo '</li>';
								echo '<li>';
									echo '<div>';
										echo '<div class="minute count-number">00</div>';
										echo '<span class="count-name">Minutes</span>';
									echo '</div>';
								echo '</li>';
								echo '<li>';
									echo '<div>';
										echo '<div class="seconds count-number">00</div>';
										echo '<span class="count-name">Seconds</span>';
									echo '</div>';
								echo '</li>';
							echo '</ul>';
						echo '</div>';
					echo '</div>';

					echo '<div class="col-xl-4">';
						echo '<div class="offer-block2 mega-hover" data-bg-src="'.esc_url($settings['image2']['url']).'">';
							if($settings['subtitle2']){
								echo '<span class="h6 box-subtitle sub2">'.wp_kses_post($settings['subtitle2']).'</span>';
							}
							if($settings['title2']){
								echo '<h2 class="sec-title title2">'.wp_kses_post($settings['title2']).'</h2>';
							}
							if($settings['desc2']){
								echo '<p class="box-text desc2">'.wp_kses_post($settings['desc2']).'</p>';
							}
							if(!empty($settings['button_text2'])){
								echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn style4 th_btn2">'.wp_kses_post($settings['button_text2']).'</a>';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="offer-box mega-hover" data-bg-src="'.esc_url($settings['image']['url']).'">';
				if($settings['title']){
					echo '<h3 class="box-title title">'.wp_kses_post($settings['title']).'</h3>';
				}
				if($settings['desc']){
					echo '<span class="h6 box-subtitle desc">'.wp_kses_post($settings['desc']).'</span>';
				}
				if(!empty($settings['button_text'])){
					echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn btn-sm '.esc_attr($settings['button_class']).' th_btn">'.wp_kses_post($settings['button_text']).'</a>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="cta-sec5 mega-hover" data-bg-src="'.esc_url($settings['image']['url']).'">';
				if($settings['title']){
					echo '<h2 class="sec-title mb-35 title">'.wp_kses_post($settings['title']).'</h2>';
				}
				if(!empty($settings['button_text'])){
					echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn style4 shadow-1 th_btn">'.wp_kses_post($settings['button_text']).'</a>';
				}
			echo '</div>';

		}else{
			echo '<div class="offer-element mega-hover" data-bg-src="'.esc_url($settings['image']['url']).'">';
				if($settings['title']){
	                echo '<span class="h6 box-subtitle">'.wp_kses_post($settings['title']).'</span>';
	            }
	            if($settings['desc']){
	                echo '<h3 class="box-title">'.wp_kses_post($settings['desc']).'</h3>';
	            }
	            if(!empty($settings['button_text'])){
	                echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn style4">'.wp_kses_post($settings['button_text']).'</a>';
	            }
            echo '</div>';
		}
		

	}

}