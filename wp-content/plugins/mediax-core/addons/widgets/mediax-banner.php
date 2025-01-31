<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
/**
 *
 * Banner Widget.
 *
 */
class mediax_Banner extends Widget_Base {

	public function get_name() {
		return 'mediaxbanner';
	}
	public function get_title() {
		return __( 'Banner Slider', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'banner_section',
			[
				'label' 	=> __( 'Banner', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One' ] );

		mediax_media_fields( $this, 'bg', 'Choose Image', ['1'] );

        $repeater = new Repeater();

		mediax_media_fields($repeater, 'image', 'Choose Image');
		mediax_media_fields($repeater, 'image2', 'Thumb Image');
		mediax_general_fields($repeater, 'subtitle', 'Subtitle', 'TEXT', 'We Clean, You Shine');
		mediax_general_fields($repeater, 'title', 'Title', 'TEXTAREA', 'Quality Mediaxdry Every Thread');
		mediax_general_fields($repeater, 'title2', 'Title 2', 'TEXTAREA', 'Quality Mediaxdry Every Thread');
		mediax_general_fields($repeater, 'desc', 'Description', 'TEXTAREA', '');
		mediax_general_fields($repeater, 'button_text', 'Button Text', 'TEXT', 'Discover More');
		mediax_url_fields($repeater, 'button_url', 'Button URL');

		$this->add_control(
			'banner_slides',
			[
				'label' 		=> __( 'Banners', 'mediax' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'subtitle' 	=> __( 'We Clean, You Shine', 'mediax' ),
						'title' 	=> __( 'Quality Mediaxdry Every Thread', 'mediax' ),
					],
				],
				'condition'	=> [
					'layout_style' => ['1']
				]
			]
		);

		$this->end_controls_section();


        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields($this, 'subtitle', 'Subtitle', '{{WRAPPER}} .sub-title', '','--theme-color2');
		//-------Title Style-------
		mediax_common_style_fields($this, 'title', 'Title', '{{WRAPPER}} .hero-title');
		mediax_common_style_fields($this, 'title2', 'Title 2', '{{WRAPPER}} .hero-heading');
		//-------Description Style-------
		mediax_common_style_fields($this, 'desc', 'Description', '{{WRAPPER}} .hero-text');
		//------Button Style-------
		mediax_button_style_fields($this, '10', 'Button Styling', '{{WRAPPER}} .th_btn');
		//------Button 2 Style-------
		// mediax_button_style_fields($this, '11', 'Button 2 Styling', '{{WRAPPER}} .th_btn2');


    }

	protected function render() {

    $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="th-hero-wrapper hero-1" id="hero" data-bg-src="'.esc_url($settings['bg']['url']).'">';
				echo '<div class="swiper th-slider" id="heroSlide1" data-slider-options=\'{"effect":"fade","autoHeight":true}\'>';
					echo '<div class="swiper-wrapper">';
						foreach( $settings['banner_slides'] as $key => $data ){
							echo '<div class="swiper-slide">';
								echo '<div class="hero-inner">';
									echo '<div class="container">';
										echo '<div class="hero-style1">';
											if(!empty($data['subtitle'])){
												echo '<span class="hero-subtitle" data-ani="slideinup" data-ani-delay="0.2s">'.wp_kses_post($data['subtitle']).'</span>';
											}
											if(!empty($data['title'])){
												echo '<h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.3s">'.wp_kses_post($data['title']).'</h1>';
											}
											if(!empty($data['title2'])){
												echo '<h2 class="hero-heading" data-ani="slideinup" data-ani-delay="0.4s">'.wp_kses_post($data['title2']).'</h2>';
											}
											if(!empty($data['desc'])){
												echo '<p class="hero-text" data-ani="slideinup" data-ani-delay="0.6s">'.wp_kses_post($data['desc']).'</p>';
											}
											if(!empty($data['button_text'])){
												echo '<a href="'.esc_url( $data['button_url']['url'] ).'" class="th-btn th_btn style4"  data-ani="slideinup" data-ani-delay="0.6s">'.wp_kses_post($data['button_text']).'</a>';
											}
										echo '</div>';
									echo '</div>';
									if(!empty( esc_url( $data['image']['url'] ))){
										echo '<div class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">';
											echo mediax_img_tag( array(
												'url'   => esc_url( $data['image']['url'] ),
											)); 
										echo '</div>';
									}
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';

				echo '<div class="hero-thumb-wrap">';
					echo '<div class="hero-thumb" data-slider-tab="#heroSlide1">';
						foreach( $settings['banner_slides'] as $key => $data ){
							$active = ($key == 0) ? 'active':'';
							echo '<div class="tab-btn  '.esc_attr($active).'">';
							if( $data['image2']['url'] ){
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['image2']['url'] ),
								));
							}else{
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['image']['url'] ),
								));
							}
								
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
		

		}

		
	}

}