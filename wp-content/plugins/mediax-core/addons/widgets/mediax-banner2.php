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
class mediax_Banner2 extends Widget_Base {

	public function get_name() {
		return 'mediaxbanner2';
	}
	public function get_title() {
		return __( 'Banner / Hero', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax_header_elements' ];
	}

    public function get_as_contact_form(){
        if ( ! class_exists( 'WPCF7' ) ) {
            return;
        }
        $as_cfa         = array();
        $as_cf_args     = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $as_forms       = get_posts( $as_cf_args );
        $as_cfa         = ['0' => esc_html__( 'Select Form', 'mediax' ) ];
        if( $as_forms ){
            foreach ( $as_forms as $as_form ){
                $as_cfa[$as_form->ID] = $as_form->post_title;
            }
        }else{
            $as_cfa[ esc_html__( 'No contact form found', 'mediax' ) ] = 0;
        }
        return $as_cfa;
    }

	protected function register_controls() {

		$this->start_controls_section(
			'banner_section',
			[
				'label' 	=> __( 'Banner', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', ['Style One', 'Style Two','Style Three'] );

		mediax_media_fields( $this, 'bg', 'Choose Background', ['1', '2','3'] );
		mediax_media_fields( $this, 'image', 'Choose Image', ['1','3'] );
		mediax_general_fields( $this, 'subtitle', 'Subtitle', 'TEXT', 'We Clean, You Shine' );
		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA', 'Quality Mediaxdry Every Thread' );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', '' );
		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXT', 'Discover More' );
		mediax_url_fields( $this, 'button_url', 'Button URL' );
        mediax_general_fields( $this, 'button_text2', 'Button Text 2', 'TEXT', 'Contact Us' );
		mediax_url_fields( $this, 'button_url2', 'Button URL 2' );
		
		mediax_general_fields( $this, 'form_title', 'Form Title', 'TEXTAREA', 'Book An Appointment', ['2'] );
        $this->add_control(
            'mediax_select_contact_form',
            [
                'label'    => esc_html__( 'Select Form', 'mediax' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => '0',
                'options'  => $this->get_as_contact_form(),
                'condition'     => ['layout_style' =>  ['1','2']],
            ]
        );

		mediax_switcher_fields( $this, 'show_shape', 'Show All Shape?', ['1'] );

		$this->end_controls_section();


        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'subtitle', 'Subtitle', '{{WRAPPER}} .sub,{{WRAPPER}} .sub-title', ['1','3'],'--theme-color' );
		mediax_common_style_fields( $this, 'subtitle2', 'Subtitle', '{{WRAPPER}} .hero-tags .tag', ['2'],'--white-color' );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title,{{WRAPPER}} .hero-title' );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .desc,{{WRAPPER}} .text-title' );
		//------Button Style-------
		mediax_button_style_fields( $this, '10', 'Button Styling', '{{WRAPPER}} .th_btn,{{WRAPPER}} .th-btn.style7' );
		//------Button 2 Style-------
		mediax_button_style_fields( $this, '11', 'Button 2 Styling', '{{WRAPPER}} .th_btn2,{{WRAPPER}} .th-btn.style8' );
        //-------Form Title Style-------
		mediax_common_style_fields( $this, 'form_title', 'Form Title', '{{WRAPPER}} .form-title', ['2']);


    }

	protected function render() {

    $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="th-hero-wrapper hero-2" id="hero" data-bg-src="'.esc_url($settings['bg']['url']).'">';
                echo '<div class="hero-inner">';
                    echo '<div class="container">';
                        echo '<div class="hero-style2">';
                            if(!empty($settings['subtitle'])){
                                echo '<span class="sub-title sub"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="'.esc_attr__('Shape', 'mediax').'">'.wp_kses_post($settings['subtitle']).'</span>';
                            }
                            if(!empty($settings['title'])){
                                echo '<h1 class="hero-title2 title">'.wp_kses_post($settings['title']).'</h1>';
                            }
                            if(!empty($settings['desc'])){
                                echo '<p class="hero-text desc">'.wp_kses_post($settings['desc']).'</p>';
                            }
                            echo '<div class="btn-group justify-content-center">';
                                if(!empty($settings['button_text'])){
                                    echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn th_btn">'.wp_kses_post($settings['button_text']).'</a>';
                                }
                                if(!empty($settings['button_text2'])){
                                    echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn style4 th_btn2">'.wp_kses_post($settings['button_text2']).'</a>';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    if(!empty($settings['image']['url'])){
                        echo '<div class="hero-img">';
                            echo mediax_img_tag( array(
                                'url'   => esc_url( $settings['image']['url'] ),
                            ));
                        echo '</div>';
                    }
                    if($settings['show_shape'] == 'yes'){
                        echo '<div class="hero-shape1">';
                            echo '<img src="'.MEDIAX_ASSETS.'img/hero_shape_2_1.svg" alt="shape">';
                        echo '</div>';
                        echo '<div class="hero-shape2">';
                            echo '<img src="'.MEDIAX_ASSETS.'img/hero_shape_2_2.svg" alt="shape">';
                        echo '</div>';
                        echo '<div class="hero-shape3">';
                            echo '<img src="'.MEDIAX_ASSETS.'img/hero_shape_2_3.svg" alt="shape">';
                        echo '</div>';
                        echo '<div class="hero-shape4">';
                            echo '<img src="'.MEDIAX_ASSETS.'img/hero_shape_2_4.svg" alt="shape">';
                        echo '</div>';
                        echo '<div class="hero-shape5">';
                            echo '<img src="'.MEDIAX_ASSETS.'img/hero_shape_2_5.svg" alt="shape">';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
            echo '<div class="th-hero-wrapper hero-3" id="hero" data-bg-src="'.esc_url($settings['bg']['url']).'">';
                echo '<div class="hero-inner">';
                    echo '<div class="container">';
                        echo '<div class="hero-style3">';
                            if(!empty($settings['subtitle'])){
                                echo '<div class="hero-tags">'.wp_kses_post($settings['subtitle']).'</div>';
                            }
                            if(!empty($settings['title'])){
                                echo '<h1 class="hero-title2 title">'.wp_kses_post($settings['title']).'</h1>';
                            }
                            if(!empty($settings['desc'])){
                                echo '<p class="hero-text desc">'.wp_kses_post($settings['desc']).'</p>';
                            }
                            echo '<div class="btn-group justify-content-center">';
                                if(!empty($settings['button_text'])){
                                    echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn shadow-1 th_btn">'.wp_kses_post($settings['button_text']).'</a>';
                                }
                                if(!empty($settings['button_text2'])){
                                    echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn style2 shadow-1 th_btn2">'.wp_kses_post($settings['button_text2']).'</a>';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="hero-form-wrap">';
                    if(!empty($settings['form_title'])){
                        echo '<h2 class="form-title">'.wp_kses_post($settings['form_title']).'</h2>';
                    }
                    echo '<div class="hero-form">';
                        if( !empty($settings['mediax_select_contact_form']) ){
                            echo do_shortcode( '[contact-form-7  id="'.$settings['mediax_select_contact_form'].'"]' ); 
                        }else{
                            echo '<div class="alert alert-warning"><p class="m-0">' . __('Please Select contact form.', 'mediax' ). '</p></div>';
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
        
        echo '<div class="th-hero-wrapper hero-9">';
            echo '<div class="swiper th-slider" id="heroSlide9" data-slider-options=\'{"effect":"fade","autoHeight":true}\'>';
                echo '<div class="swiper-wrapper">';
                    echo '<div class="swiper-slide">';
                        echo '<div class="hero-inner">';
                            echo '<div class="th-hero-bg" data-bg-src="'.esc_url($settings['bg']['url']).'">';
                            echo '</div>';
                            if(!empty($settings['image']['url'])){
                                echo '<div class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">';
                                    echo mediax_img_tag( array(
                                        'url'   => esc_url( $settings['image']['url'] ),
                                    ));
                                echo '</div>';
                            }
                            echo '<div class="container">';
                                echo '<div class="hero-style9">';
                                    echo '<span class="sub-title" data-ani="slideinup" data-ani-delay="0.2s"></span>';
                                    if(!empty($settings['subtitle'])){
                                        echo '<span class="sub-title" data-ani="slideinup" data-ani-delay="0.2s">'.wp_kses_post($settings['subtitle']).'</span>';
                                    }
                                    if(!empty($settings['title'])){
                                        echo '<h1 class="hero-title">'.wp_kses_post($settings['title']).'</h1>';
                                    }
                                    echo '<p class="hero-text fw-medium text-title" data-ani="slideinup" data-ani-delay="0.5s">'.wp_kses_post($settings['desc']).'</p>';
                                    echo '<div class="btn-group justify-content-center" data-ani="slideinup" data-ani-delay="0.6s">';
                                        if(!empty($settings['button_text'])){
                                        echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn style7">'.wp_kses_post($settings['button_text']).'</a>';
                                        }
                                        if(!empty($settings['button_text2'])){
                                            echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'" class="th-btn style8">'.wp_kses_post($settings['button_text2']).'</a>';
                                        }

                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        }

		
	}

}