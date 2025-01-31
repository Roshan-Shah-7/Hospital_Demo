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
class mediax_Banner3 extends Widget_Base {

	public function get_name() {
		return 'mediaxbanner3';
	}
	public function get_title() {
		return __( 'Banner / Hero v2', 'mediax' );
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

		mediax_select_field( $this, 'layout_style', 'Layout Style', ['Style One', 'Style Two', 'Style Three'] );

		mediax_media_fields( $this, 'bg', 'Choose Background', ['1','2','3'] );
		mediax_media_fields( $this, 'bg2', 'Choose Background2', ['1','2','3'] );
		mediax_media_fields( $this, 'image', 'Choose Image', ['1','3'] );

		mediax_general_fields( $this, 'heading', 'Heading', 'TEXTAREA', 'We Clean, You Shine' );
		mediax_general_fields( $this, 'title', 'Title', 'TEXT', 'Title' );
		mediax_general_fields( $this, 'title2', 'Title 2', 'TEXT', 'Title 2' );


		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', '', ['2'] );
		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXT', 'Discover More' );
		mediax_url_fields( $this, 'button_url', 'Button URL' );
        mediax_general_fields( $this, 'button_text2', 'Button Text 2', 'TEXT', 'Contact Us' );
		mediax_url_fields( $this, 'button_url2', 'Button URL 2' );
		
		
		mediax_switcher_fields( $this, 'show_shape', 'Show All Shape?', ['1','2'] );



		$this->add_control(
	        '2_social_text',
	        [
	            'label' 	=> __( 'Social Text', 'mediax' ),
	            'type' 		=> Controls_Manager::TEXT,
	            'default' 	=> __( 'Follow Us On:', 'mediax' ),
	            'label_block' => true,
	            'condition'		=> [ 
	                'layout_style'  => ['2'],
	            ],
	        ]
	    );

	    $repeater = new Repeater();

	    $repeater->add_control(
	        'social_icon',
	        [
	            'label' 	=> __( 'Social Icon', 'mediax' ),
	            'type' 		=> Controls_Manager::ICONS,
	            'default' 	=> [
	                'value' 	=> 'fab fa-facebook-f',
	                'library' 	=> 'solid',
	            ],
	        ]
	    );

	    $repeater->add_control(
	        'icon_link',
	        [
	            'label' 		=> __( 'Link', 'mediax' ),
	            'type' 			=> Controls_Manager::URL,
	            'placeholder' 	=> __( 'https://your-link.com', 'mediax' ),
	            'show_external' => true,
	            'default' 		=> [
	                'url' 			=> '#',
	                'is_external' 	=> false,
	                'nofollow' 		=> true,
	            ],
	        ]
	    );

	    $this->add_control(
	        '2_social_icon_list',
	        [
	            'label' 		=> __( 'Social Icon', 'mediax' ),
	            'type' 			=> Controls_Manager::REPEATER,
	            'fields' 		=> $repeater->get_controls(),
	            'default' => [
	                [
	                    'social_icon' => ['value' => 'fab fa-facebook-f', 'library' => 'solid'],
	                    'icon_link' => ['url' => 'https://www.facebook.com', 'is_external' => false, 'nofollow' => true],
	                ],
	                [
	                    'social_icon' => ['value' => 'fab fa-twitter', 'library' => 'solid'],
	                    'icon_link' => ['url' => 'https://www.twitter.com', 'is_external' => false, 'nofollow' => true],
	                ],
	                [
	                    'social_icon' => ['value' => 'fab fa-instagram', 'library' => 'solid'],
	                    'icon_link' => ['url' => 'https://www.instagram.com', 'is_external' => false, 'nofollow' => true],
	                ],
	                [
	                    'social_icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'solid'],
	                    'icon_link' => ['url' => 'https://www.linkedin.com', 'is_external' => false, 'nofollow' => true],
	                ],
	                [
	                    'social_icon' => ['value' => 'fab fa-pinterest-p', 'library' => 'solid'],
	                    'icon_link' => ['url' => 'https://pinterest.com', 'is_external' => false, 'nofollow' => true],
	                ],
	            ],
	            'condition'		=> [ 
	                'layout_style'  => ['2'],
	            ],
	        ]
	    );

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
			echo '<div class="th-hero-wrapper hero-6" id="hero">';
		        echo '<div class="swiper th-slider" id="heroSlide6" data-slider-options=\'{"effect":"fade","autoHeight":true}\'>';
		            echo '<div class="swiper-wrapper">';
		                echo '<div class="swiper-slide">';
		                    echo '<div class="hero-inner">';
		                        echo '<div class="th-hero-bg" data-bg-src="'.esc_url($settings['bg']['url']).'">';
		                            echo '<img src="'.esc_url($settings['bg2']['url']).'" alt="overlay">';
		                        echo '</div>';
		                        echo '<div class="container">';
		                            echo '<div class="hero-style6">';
		                                echo '<span class="sub-title" data-ani="slideinup" data-ani-delay="0.2s"><img src="'.MEDIAX_ASSETS.'img/title_icon_white.svg" alt="shape">'.wp_kses_post($settings['heading']).'</span>';
		                                echo '<h1 class="hero-title">';
		                                	if(!empty($settings['title'])){
			                                    echo '<span class="title1" data-ani="slideinup" data-ani-delay="0.3s">'.wp_kses_post($settings['title']).'</span>';
			                                }
			                                if(!empty($settings['title2'])){
			                                    echo '<span class="title2" data-ani="slideinup" data-ani-delay="0.4s">'.wp_kses_post($settings['title2']).'</span>';
			                                }
		                                echo '</h1>';
		                                echo '<div class="hero-search" data-ani="slideinup" data-ani-delay="0.5s">';
		                                    echo '<form class="search-form">';
		                                        echo '<input type="text" placeholder="Enter Keyword">';
		                                        echo '<button type="submit"><i class="far fa-search"></i></button>';
		                                    echo '</form>';
		                                echo '</div>';
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
		                            echo '<img src="'.esc_url($settings['image']['url']).'" alt="Image">';
		                        echo '</div>';
		                        if($settings['show_shape'] == 'yes'){
			                        echo '<div class="sperm-1">';
			                            echo '<img src="'.MEDIAX_ASSETS.'img/sperm_1.svg" alt="icon">';
			                        echo '</div>';
			                        echo '<div class="sperm-2">';
			                            echo '<img src="'.MEDIAX_ASSETS.'img/sperm_2.svg" alt="icon">';
			                        echo '</div>';
			                        echo '<div class="sperm-3">';
			                            echo '<img src="'.MEDIAX_ASSETS.'img/sperm_3.svg" alt="icon">';
			                        echo '</div>';
			                    }
		                    echo '</div>';

		                echo '</div>';
		            echo '</div>';
		        echo '</div>';
		    echo '</div>';


		}elseif( $settings['layout_style'] == '2' ){
			 echo '<div class="th-hero-wrapper hero-5" id="hero">';
		        echo '<div class="swiper th-slider" id="heroSlide5" data-slider-options=\'{"effect":"fade","autoHeight":true}\'>';
		            echo '<div class="swiper-wrapper">';
		                echo '<div class="swiper-slide">';
		                    echo '<div class="hero-inner">';
		                        echo '<div class="shape-mockup dna-shape" data-bottom="8%" data-left="44%">';
		                            echo '<div class="dna-ani">';
		                                echo '<span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>';
		                            echo '</div>';
		                       	echo ' </div>';
		                       	if($settings['show_shape'] == 'yes'){
			                        echo '<div class="shape-mockup shape-1" data-bottom="0%" data-left="0%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_5_1.png" alt="shape"></div>';
			                        echo '<div class="shape-mockup jump shape-2" data-top="18%" data-left="44%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_5_2.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup moving shape-3" data-top="20%" data-right="20%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_5_3.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup jump shape-4" data-bottom="36%" data-right="4%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_5_4.svg" alt="shape"></div>';
			                    }

		                        echo '<div class="th-hero-bg" data-bg-src="'.esc_url($settings['bg']['url']).'"></div>';
		                        echo '<div class="container">';
		                            echo '<div class="hero-style5">';
		                                echo '<span class="sub-title4" data-ani="slideinup" data-ani-delay="0.2s"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="shape">Little Steps, Big Strides</span>';
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
		        echo '<div class="hero-social">';
		            echo '<div class="box-shape"></div>';
		            if(!empty($settings['2_social_text'])){
						echo '<span class="social-title">'.esc_html($settings['2_social_text']).'</span>';
					}
					echo ' <div class="th-social">';
						foreach( $settings['2_social_icon_list'] as $social_icon ){
							$social_target    = $social_icon['icon_link']['is_external'] ? ' target="_blank"' : '';
							$social_nofollow  = $social_icon['icon_link']['nofollow'] ? ' rel="nofollow"' : '';

							echo '<a '.wp_kses_post( $social_target.$social_nofollow ).' href="'.esc_url( $social_icon['icon_link']['url'] ).'">';

							\Elementor\Icons_Manager::render_icon( $social_icon['social_icon'], [ 'aria-hidden' => 'true' ] );

							echo '</a> ';
						} 
					echo '</div>';
		        echo '</div>';
		    echo '</div>';
		}else{
			echo '<div class="th-hero-wrapper hero-4" id="hero">';
		        echo '<div class="swiper th-slider" id="heroSlide4" data-slider-options=\'{"effect":"fade","autoHeight":true}\'>';
		            echo '<div class="swiper-wrapper">';
		                echo '<div class="swiper-slide">';
		                    echo '<div class="hero-inner">';
		                    	if($settings['show_shape'] == 'yes'){
			                        echo '<div class="shape-mockup spin shape-1" data-top="18%" data-left="6%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_4_1.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup jump shape-2" data-top="18%" data-left="46%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_4_2.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup spin shape-3" data-top="18%" data-right="6%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_4_3.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup jump-reverse shape-4" data-bottom="18%" data-left="6%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_4_4.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup spin shape-5" data-bottom="18%" data-left="46%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_4_5.svg" alt="shape"></div>';
			                        echo '<div class="shape-mockup jump shape-6" data-bottom="18%" data-right="6%"><img src="'.MEDIAX_ASSETS.'img/hero_shape_4_6.svg" alt="shape"></div>';
			                    }



		                        echo '<div class="th-hero-bg" data-bg-src="'.esc_url($settings['bg']['url']).'"></div>';
		                        echo '<div class="container">';
		                            echo '<div class="hero-style4">';
		                                echo '<span class="sub-title3" data-ani="slideinup" data-ani-delay="0.2s">'.wp_kses_post($settings['heading']).'</span>';
		                                echo '<h1 class="hero-title">';
		                                    echo '<span class="title1" data-ani="slideinup" data-ani-delay="0.3s">'.wp_kses_post($settings['title']).'</span>';
		                                    echo '<span class="title2" data-ani="slideinup" data-ani-delay="0.4s">'.wp_kses_post($settings['title2']).'</span>';
		                                echo '</h1>';
		                                echo '<div class="btn-group justify-content-center" data-ani="slideinup" data-ani-delay="0.5s">';
		                                	if(!empty($settings['button_text'])){
			                                    echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="hero-btn">'.wp_kses_post($settings['button_text']).'</a>';
			                                }
		                                    echo '<div class="hero-avaters">';
		                                        echo '<div class="img">';
		                                            echo '<img src="'.esc_url($settings['image']['url']).'" alt="avaters">';
		                                        echo '</div>';
		                                        echo '15k+ Happy Patient';
		                                    echo '</div>';
		                                echo '</div>';
		                                if(!empty($settings['button_text2'])){
			                                echo '<div data-ani="slideinup" data-ani-delay="0.6s">';
			                                    echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn style4">'.wp_kses_post($settings['button_text2']).'</a>';
			                               echo ' </div>';
			                           }
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