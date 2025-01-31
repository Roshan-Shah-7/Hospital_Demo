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
class mediax_Banner4 extends Widget_Base {

	public function get_name() {
		return 'mediaxbanner4';
	}
	public function get_title() {
		return __( 'Banner / Hero v4', 'mediax' );
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

		mediax_select_field( $this, 'layout_style', 'Layout Style', ['Style One', 'Style Two'] );

		mediax_media_fields( $this, 'bg', 'Choose Background', ['1','2'] );
		mediax_media_fields( $this, 'bg2', 'Choose Background2', ['1','2'] );
		mediax_media_fields( $this, 'image', 'Choose Image', ['1'] );

		mediax_general_fields( $this, 'heading', 'Heading', 'TEXTAREA', 'We Clean, You Shine' );
		mediax_general_fields( $this, 'title', 'Title', 'TEXT', 'Title' );
		mediax_general_fields( $this, 'title2', 'Title 2', 'TEXT', 'Title 2' );


		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', '', ['2'] );
		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXT', 'Discover More' );
		mediax_url_fields( $this, 'button_url', 'Button URL' );
        mediax_general_fields( $this, 'button_text2', 'Button Text 2', 'TEXT', 'Contact Us' );
		mediax_url_fields( $this, 'button_url2', 'Button URL 2' );
		
		
		mediax_switcher_fields( $this, 'show_shape', 'Show All Shape?', ['2'] );


		$repeater = new Repeater();

		mediax_media_fields($repeater, 'image', 'Choose Image');
		
		mediax_general_fields($repeater, 'title', 'Title', 'TEXTAREA', 'Quality Mediaxdry Every Thread');
		

		$this->add_control(
			'features',
			[
				'label' 		=> __( 'Features', 'mediax' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'title' 	=> __( 'Quality Mediaxdry Every Thread', 'mediax' ),
					],
				],
				'condition'	=> [
					'layout_style' => ['1']
				]
			]
		);
		mediax_general_fields( $this, 'shortcode', 'Shortcode', 'TEXTAREA', '' );



		

		$this->end_controls_section();


        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		// mediax_common_style_fields( $this, 'subtitle', 'Subtitle', '{{WRAPPER}} .sub', ['1'],'--theme-color' );
		// mediax_common_style_fields( $this, 'subtitle2', 'Subtitle', '{{WRAPPER}} .hero-tags .tag', ['2'],'--white-color' );
		// //-------Title Style-------
		// mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title' );
		// //-------Description Style-------
		// mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .desc' );
		// //------Button Style-------
		// mediax_button_style_fields( $this, '10', 'Button Styling', '{{WRAPPER}} .th_btn' );
		// //------Button 2 Style-------
		// mediax_button_style_fields( $this, '11', 'Button 2 Styling', '{{WRAPPER}} .th_btn2' );
  //       //-------Form Title Style-------
		// mediax_common_style_fields( $this, 'form_title', 'Form Title', '{{WRAPPER}} .form-title', ['2']);


    }

	protected function render() {

    $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="th-hero-wrapper hero-7" id="hero">';
		        echo '<div class="swiper th-slider" id="heroSlide7" data-slider-options=\'{"effect":"fade","autoHeight":true}\'>';
		            echo '<div class="swiper-wrapper">';
		                echo '<div class="swiper-slide">';
		                    echo '<div class="hero-inner">';
		                        echo '<div class="shape-mockup jump shape-1" data-top="12%" data-left="5%"><img src="'.esc_url($settings['bg']['url']).'" alt="shape"></div>';
		                        echo '<div class="th-hero-bg" data-bg-src="'.esc_url($settings['bg2']['url']).'"></div>';
		                        echo '<div class="container">';
		                            echo '<div class="hero-style7">';
		                                echo '<span class="sub-title4" data-ani="slideinup" data-ani-delay="0.2s"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="shape">'.wp_kses_post($settings['heading']).'</span>';
		                                echo '<h1 class="hero-title">';
		                                	if(!empty($settings['title'])){
			                                    echo '<span class="title1" data-ani="slideinup" data-ani-delay="0.3s">'.wp_kses_post($settings['title']).'</span>';
			                                }
			                                if(!empty($settings['title2'])){
			                                    echo '<span class="title2" data-ani="slideinup" data-ani-delay="0.4s">'.wp_kses_post($settings['title2']).'</span>';
			                                }
		                                echo '</h1>';
		                                echo '<div class="hero-feature-wrap" data-ani="slideinup" data-ani-delay="0.5s">';

		                                	foreach( $settings['features'] as $data ){
			                                    echo '<div class="hero-feature">';
			                                        echo '<div class="box-icon">';
			                                            echo '<img src="'.esc_url($data['image']['url']).'" alt="icon">';
			                                        echo '</div>';
			                                        if(!empty($data['title'])){
				                                        echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
				                                    }
			                                    echo '</div>';
			                                }
		                                    

		                                echo '</div>';
		                                echo '<div class="btn-group justify-content-center" data-ani="slideinup" data-ani-delay="0.6s">';
		                                	if(!empty($settings['button_text'])){
			                                    echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn shadow-1">'.wp_kses_post($settings['button_text']).'</a>';
			                                }
			                                if(!empty($settings['button_text2'])){
			                                    echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn style2 shadow-1">'.wp_kses_post($settings['button_text2']).'</a>';
			                                }
		                                echo '</div>';
		                            echo '</div>';
		                        echo '</div>';
		                        echo '<div class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">';
		                            echo '<img src="'.esc_url($settings['image']['url']).'" alt="Image">';
		                        echo '</div>';
		                    echo '</div>';
		                echo '</div>';
		            echo '</div>';
		        echo '</div>';
		        if(!empty($settings['shortcode'])){
			        echo '<div class="hero-appointment-wrap">';
			            echo '<div class="container">';
			                
			            	echo do_shortcode($settings['shortcode'] );
			                
			            echo '</div>';
			        echo '</div>';
			    }
		    echo '</div>';
		}elseif( $settings['layout_style'] == '2' ){

			echo '<div class="th-hero-wrapper hero-5 hero-8" id="hero">';
		        echo '<div class="swiper th-slider" id="heroSlide58" data-slider-options=\'{"effect":"fade","autoHeight":true}\'>';
		            echo '<div class="swiper-wrapper">';
		                echo '<div class="swiper-slide">';
		                    echo '<div class="hero-inner">';
		                        echo '<div class="shape-mockup dna-shape" data-bottom="2%" data-left="42%">';
		                            echo '<div class="dna-ani">';
		                                echo '<span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>';
		                            echo '</div>';
		                        echo '</div>';
		                        if($settings['show_shape'] == 'yes'){
			                        echo '<div class="shape-mockup jump shape-1" data-top="12%" data-left="5%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_8_1.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup moving shape-2" data-top="12%" data-left="40%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_8_2.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup moving shape-3" data-top="18%" data-right="6%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_8_3.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup jump shape-4" data-bottom="8%" data-left="4%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_8_4.svg" alt="shape"></div>';
			                    }
		                        echo '<div class="th-hero-bg" data-bg-src="'.esc_url($settings['bg']['url']).'"></div>';
		                        echo '<div class="container">';
		                            echo '<div class="hero-style5 hero-style8">';
		                                echo '<span class="sub-title4" data-ani="slideinup" data-ani-delay="0.2s"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="shape">'.wp_kses_post($settings['heading']).'</span>';
		                                echo '<h1 class="hero-title">';
		                                	if(!empty($settings['title'])){
			                                    echo '<span class="title1" data-ani="slideinup" data-ani-delay="0.3s">'.wp_kses_post($settings['title']).'</span>';
			                                }
			                                if(!empty($settings['title2'])){
			                                    echo '<span class="title2" data-ani="slideinup" data-ani-delay="0.4s">'.wp_kses_post($settings['title2']).'</span>';
			                                }
		                                echo '</h1>';
		                                if(!empty($settings['desc'])){
			                                echo '<p class="hero-text" data-ani="slideinup" data-ani-delay="0.5s">'.wp_kses_post($settings['desc']).'</p>';
			                            }
		                                echo '<div class="btn-group justify-content-center" data-ani="slideinup" data-ani-delay="0.6s">';
		                                	if(!empty($settings['button_text'])){
			                                    echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn style4 shadow-1">'.wp_kses_post($settings['button_text']).'</a>';
			                                }
			                                if(!empty($settings['button_text2'])){
			                                    echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn shadow-1">'.wp_kses_post($settings['button_text2']).'</a>';
			                                }
		                                echo '</div>';
		                            echo '</div>';
		                        echo '</div>';
		                        echo '<div class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">';
		                            echo '<img src="'.esc_url($settings['bg2']['url']).'" alt="Image">';
		                        echo '</div>';
		                    echo '</div>';
		                echo '</div>';
		            echo '</div>';
		        echo '</div>';
		    echo '</div>';
		}

		
	}

}