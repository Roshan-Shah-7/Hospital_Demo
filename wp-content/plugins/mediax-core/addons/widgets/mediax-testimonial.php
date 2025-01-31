<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
/**
 *
 * Testimonial Slider Widget .
 *
 */
class mediax_Testimonial extends Widget_Base{

	public function get_name() {
		return 'mediaxtestimonialslider';
	}
	public function get_title() {
		return __( 'Testimonials', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'testimonial_slider_section',
			[
				'label' 	=> __( 'Testimonial Slider', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five', 'Style Six', 'Style Seven','Style Eight'] );

		mediax_media_fields( $this, 'quote_image', 'Quote Icon', ['1', '2', '3', '4','5','6','8'] );
		mediax_media_fields( $this, 'thumb_image', 'Thumb Icon', ['5'] );
		mediax_general_fields( $this, 'section_sub', 'Subtitle', 'TEXT', 'Subtitle', ['3','5','6'] );
		mediax_general_fields( $this, 'section_title', 'Title', 'TEXTAREA', 'Title Here', ['3','5','6','8'] );
		mediax_general_fields( $this, 'section_desc', 'Description', 'TEXTAREA', 'Description Here', ['6','8'] );

		mediax_general_fields( $this, 'p_button_text', 'Button Text', 'TEXT', 'VIEW ALL PRODUCT', ['6'] );
		mediax_url_fields( $this, 'p_button_url', 'Button URL', ['6'] );

		$repeater = new Repeater(); 

		mediax_media_fields( $repeater, 'client_image', 'Client Image' );
		mediax_general_fields( $repeater, 'client_name', 'Client Name', 'TEXT', 'Alex Michel' );
		mediax_general_fields( $repeater, 'client_desig', 'Client Designation', 'TEXT', 'Ui/Ux Designer' );
		mediax_general_fields( $repeater, 'client_feedback', 'Client Feedback', 'TEXTAREA', 'Our knowledgeable technicians are happy to provide tips' );

		mediax_select_field( $repeater, 'client_rating', 'Client Rating', [ 'One Star', 'Two Star', 'Three Star', 'Four Star', 'Five Star' ] );

		$this->add_control(
			'slides',
			[
				'label' 		=> __( 'Slides', 'mediax' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'client_image'	=> Utils::get_placeholder_image_src(),
					],
				],
				'title_field' 	=> '{{{ client_name }}}',
			]
		);

		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'subtitle', 'Subtitle', '{{WRAPPER}} .sub-title', ['3'],'--theme-color' );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .sec-title', ['3'] );
		//-------Name Style-------
		mediax_common_style_fields( $this, 'name', 'Name', '{{WRAPPER}} .name' );
		//-------Designation Style-------
		mediax_common_style_fields( $this, 'designation', 'Designation', '{{WRAPPER}} .desig' );
		//-------Feedback Style-------
		mediax_common_style_fields( $this, 'feedback', 'Feedback', '{{WRAPPER}} .text' );
		
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="swiper has-shadow th-slider" id="testiSlide1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"2"}}}\'>';
				echo '<div class="swiper-wrapper">';
					foreach( $settings['slides'] as $data ){
						echo '<div class="swiper-slide">';
							echo '<div class="testi-card">';
								echo '<div class="box-review">';
									if( $data['client_rating'] == '1' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}elseif( $data['client_rating'] == '2' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}elseif( $data['client_rating'] == '3' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}elseif( $data['client_rating'] == '4' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}else{
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
									}
								echo '</div>';
								if(!empty($settings['quote_image']['url'])){
									echo '<div class="box-quote">';
										echo mediax_img_tag( array(
											'url'	=> esc_url( $settings['quote_image']['url'] ), 
										) ); 
									echo '</div>';
								}
								if(!empty($data['client_feedback'])){
									echo '<p class="box-text text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
								}
								echo '<div class="box-profile">';
									echo '<div class="box-img">';
										echo mediax_img_tag( array(
											'url'	=> esc_url( $data['client_image']['url'] ),
										) );
									echo '</div>';
									echo '<div class="box-content">';
										if(!empty($data['client_name'])){
											echo '<h3 class="box-title name">'.wp_kses_post( $data['client_name'] ).'</h3>';
										}
										if(!empty($data['client_desig'])){
											echo '<span class="box-desig desig">'.wp_kses_post( $data['client_desig'] ).'</span>';
										}
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="swiper has-shadow th-slider" id="testiSlide1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"2"}}}\'>';
				echo '<div class="swiper-wrapper">';
					foreach( $settings['slides'] as $data ){
						echo '<div class="swiper-slide">';
							echo '<div class="testi-card bg-smoke">';
								echo '<div class="box-review">';
									if( $data['client_rating'] == '1' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}elseif( $data['client_rating'] == '2' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}elseif( $data['client_rating'] == '3' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}elseif( $data['client_rating'] == '4' ){
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-regular fa-star"></i>';
									}else{
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
										echo '<i class="fa-solid fa-star"></i>';
									}
								echo '</div>';
								if(!empty($settings['quote_image']['url'])){
									echo '<div class="box-quote">';
										echo mediax_img_tag( array(
											'url'	=> esc_url( $settings['quote_image']['url'] ), 
										) ); 
									echo '</div>';
								}
								if(!empty($data['client_feedback'])){
									echo '<p class="box-text text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
								}
								echo '<div class="box-profile">';
									echo '<div class="box-img">';
										echo mediax_img_tag( array(
											'url'	=> esc_url( $data['client_image']['url'] ),
										) );
									echo '</div>';
									echo '<div class="box-content">';
										if(!empty($data['client_name'])){
											echo '<h3 class="box-title name">'.wp_kses_post( $data['client_name'] ).'</h3>';
										}
										if(!empty($data['client_desig'])){
											echo '<span class="box-desig desig">'.wp_kses_post( $data['client_desig'] ).'</span>';
										}
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
				echo '<div class="slider-pagination"></div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="row g-0">';
				echo '<div class="col-lg-5 order-2 order-lg-0">';
					echo '<div class="testi-box-img">';
						echo '<div class="swiper th-slider testi-box-thumb" id="testiSlideImg" data-slider-options=\'{"effect":"fade","spaceBetween":0}\'>';
							echo '<div class="swiper-wrapper">';
								foreach( $settings['slides'] as $data ){
									echo '<div class="swiper-slide">';
										echo mediax_img_tag( array(
											'url'	=> esc_url( $data['client_image']['url'] ),
										) );
									echo '</div>';
								}
							echo '</div>';
						echo '</div>';
						echo '<button data-slider-prev="#testiSlide2" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-7">';
					echo '<div class="title-area text-center">';
						if(!empty($settings['section_sub'])){
							echo '<span class="sub-title"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="'.esc_attr__('Shape', 'mediax').'">'.wp_kses_post($settings['section_sub']).'</span>';
						}
						if(!empty($settings['section_title'])){
							echo '<h2 class="sec-title">'.wp_kses_post($settings['section_title']).'</h2>';
						}
					echo '</div>';
					echo '<div class="testi-box-slide">';
						echo '<div class="swiper th-slider" id="testiSlide2" data-slider-options=\'{"effect":"slide","thumbs":{"swiper":".testi-box-thumb"}}\'>';
							echo '<div class="swiper-wrapper">';
								foreach( $settings['slides'] as $data ){
									echo '<div class="swiper-slide">';
										echo '<div class="testi-box"> ';
										echo '<div class="box-review">';
											if( $data['client_rating'] == '1' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '2' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '3' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '4' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}else{
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
											}
										echo '</div>';
											if(!empty($data['client_feedback'])){
												echo '<p class="box-text text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
											}
											if(!empty($data['client_name'])){
												echo '<h3 class="box-title name">'.wp_kses_post( $data['client_name'] ).'</h3>';
											}
											if(!empty($data['client_desig'])){
												echo '<span class="box-desig desig">'.wp_kses_post( $data['client_desig'] ).'</span>';
											}
										echo '</div>';
									echo '</div>';
								}
							echo '</div>';
						echo '</div>';
						if(!empty($settings['quote_image']['url'])){
							echo '<div class="testi-box-quote">';
								echo mediax_img_tag( array(
									'url'	=> esc_url( $settings['quote_image']['url'] ), 
								) ); 
							echo '</div>';
						}
						echo '<button data-slider-next="#testiSlide2" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '4' ){
			echo '<div class="container th-container4">';
	            echo '<div class="testi-block-area">';
	                echo '<div class="swiper th-slider has-shadow" dir="rtl" id="testiSlide1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1500":{"slidesPerView":"2.6"}}}\'>';
	                    echo '<div class="swiper-wrapper">';

	                        foreach( $settings['slides'] as $data ){
		                        echo '<div class="swiper-slide">';
		                            echo '<div class="testi-block" dir="ltr">';
		                                if(!empty($settings['quote_image']['url'])){
											echo '<div class="box-quote">';
												echo mediax_img_tag( array(
													'url'	=> esc_url( $settings['quote_image']['url'] ), 
												) ); 
											echo '</div>';
										}
										if(!empty($data['client_feedback'])){
											echo '<p class="box-text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
										}
										if(!empty($data['client_name'])){
											echo '<h3 class="box-title name">'.wp_kses_post( $data['client_name'] ).'</h3>';
										}
										if(!empty($data['client_desig'])){
											echo '<p class="box-desig desig">'.wp_kses_post( $data['client_desig'] ).'</p>';
										}
		                                echo '<div class="box-review">';
		                                    if( $data['client_rating'] == '1' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '2' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '3' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '4' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}else{
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
											}
		                                echo '</div>';
		                                echo '<div class="box-img">';
		                                    echo mediax_img_tag( array(
												'url'	=> esc_url( $data['client_image']['url'] ),
											) );
		                                echo '</div>';
		                            echo '</div>';
		                        echo '</div>';
		                    }
	                    echo '</div>';
	                echo '</div>';
	                echo '<div class="icon-box">';
	                    echo '<button data-slider-prev="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>';
	                    echo '<button data-slider-next="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>';
	                echo '</div>';
	            echo '</div>';
	        echo '</div>';
		}elseif( $settings['layout_style'] == '5' ){
			echo '<div class="testi-element-area">';
	            echo '<div class="row flex-row-reverse">';
	                echo '<div class="col-xl-7 align-self-center">';
	                    echo '<div class="title-area text-center text-xl-start">';
	                        if(!empty($settings['section_sub'])){
								echo '<span class="sub-title"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="'.esc_attr__('Shape', 'mediax').'">'.wp_kses_post($settings['section_sub']).'</span>';
							}
							if(!empty($settings['section_title'])){
								echo '<h2 class="sec-title text-white">'.wp_kses_post($settings['section_title']).'</h2>';
							}
	                    echo '</div>';
	                    echo '<div class="swiper th-slider has-shadow" id="testiSlide1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"1.3"},"1500":{"slidesPerView":"1.8"}}}\'>';
	                        echo '<div class="swiper-wrapper">';

			                    foreach( $settings['slides'] as $data ){
				                    echo '<div class="swiper-slide">';
				                        echo '<div class="testi-element">';
				                            echo '<div class="box-profile">';
				                                echo '<div class="box-img">';
				                                    echo mediax_img_tag( array(
														'url'	=> esc_url( $data['client_image']['url'] ),
													) );
				                                echo '</div>';
				                                echo '<div class="media-body">';
				                                    if(!empty($data['client_name'])){
														echo '<h3 class="box-title name">'.wp_kses_post( $data['client_name'] ).'</h3>';
													}
													if(!empty($data['client_desig'])){
														echo '<p class="box-desig desig">'.wp_kses_post( $data['client_desig'] ).'</p>';
													}

				                                echo '</div>';
				                            echo '</div>';
				                            echo '<div class="box-content">';
				                                if(!empty($settings['quote_image']['url'])){
													echo '<div class="box-quote">';
														echo mediax_img_tag( array(
															'url'	=> esc_url( $settings['quote_image']['url'] ), 
														) ); 
													echo '</div>';
												}
				                                echo '<div class="box-review">';
				                                    if( $data['client_rating'] == '1' ){
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
													}elseif( $data['client_rating'] == '2' ){
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
													}elseif( $data['client_rating'] == '3' ){
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
													}elseif( $data['client_rating'] == '4' ){
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-regular fa-star"></i>';
													}else{
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
														echo '<i class="fa-solid fa-star"></i>';
													}
				                                echo '</div>';
				                                if(!empty($data['client_feedback'])){
													echo '<p class="box-text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
												}
				                            echo '</div>';
				                        echo '</div>';
				                    echo '</div>';
				                }
			                echo '</div>';
	                    echo '</div>';
	                echo '</div>';
	                echo '<div class="col-xl-5 mt-40 mt-xl-0">';
	                    if(!empty($settings['thumb_image']['url'])){
		                    echo '<div class="rounded-20">';
		                        echo '<img src="'.esc_url( $settings['thumb_image']['url'] ).'" alt="image" class="w-100">';
		                    echo '</div>';
		                }
	                echo '</div>';
	            echo '</div>';
	        echo '</div>';
		}elseif( $settings['layout_style'] == '6' ){
			echo '<div class="container">';
	            echo '<div class="row">';
	                echo '<div class="col-xl-6 text-center text-xl-start">';
	                    echo '<div class="pe-xxl-5 mb-40 mb-xl-0">';
	                        echo '<div class="title-area mb-32">';

	                            echo '<span class="sub-title4"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="shape">'.wp_kses_post($settings['section_sub']).'</span>';
	                            if(!empty($settings['section_title'])){
									echo '<h2 class="sec-title text-white">'.wp_kses_post($settings['section_title']).'</h2>';
								}
								if(!empty($settings['section_desc'])){
		                            echo '<p class="sec-text text-white">'.wp_kses_post($settings['section_desc']).'</p>';
		                        }
	                        echo '</div>';
	                        echo '<div class="btn-group justify-content-center">';
	                        	if(!empty($settings['p_button_text'])){
		                            echo '<a href="'.esc_url( $settings['p_button_url']['url'] ).'" class="th-btn style4 shadow-1">'.wp_kses_post($settings['p_button_text']).'</a>';
		                        }
	                            echo '<div class="icon-box">';
	                                echo '<button data-slider-prev="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>';
	                                echo '<button data-slider-next="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>';
	                            echo '</div>';
	                        echo '</div>';
	                    echo '</div>';
	                echo '</div>';
	                echo '<div class="col-xl-6">';
	                    echo '<div class="swiper th-slider has-shadow" id="testiSlide1" data-slider-options=\'{}\'>';
	                        echo '<div class="swiper-wrapper">';

	                            foreach( $settings['slides'] as $data ){
		                            echo '<div class="swiper-slide">';
		                                echo '<div class="testi-block" dir="ltr">';
		                                    if(!empty($settings['quote_image']['url'])){
												echo '<div class="box-quote">';
													echo mediax_img_tag( array(
														'url'	=> esc_url( $settings['quote_image']['url'] ), 
													) ); 
												echo '</div>';
											}
		                                    if(!empty($data['client_feedback'])){
												echo '<p class="box-text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
											}
		                                    if(!empty($data['client_name'])){
												echo '<h3 class="box-title name">'.wp_kses_post( $data['client_name'] ).'</h3>';
											}
		                                    if(!empty($data['client_desig'])){
												echo '<p class="box-desig desig">'.wp_kses_post( $data['client_desig'] ).'</p>';
											}
		                                    echo '<div class="box-review">';
		                                    	if( $data['client_rating'] == '1' ){
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
												}elseif( $data['client_rating'] == '2' ){
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
												}elseif( $data['client_rating'] == '3' ){
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
												}elseif( $data['client_rating'] == '4' ){
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-regular fa-star"></i>';
												}else{
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
													echo '<i class="fa-solid fa-star"></i>';
												}
		                                    echo '</div>';
		                                    echo '<div class="box-img">';
		                                        echo mediax_img_tag( array(
													'url'	=> esc_url( $data['client_image']['url'] ),
												) );
		                                    echo '</div>';
		                                echo '</div>';
		                            echo '</div>';
		                        }
	                            

	                        echo '</div>';
	                    echo '</div>';
	                echo '</div>';
	            echo '</div>';
	        echo '</div>';
		}elseif( $settings['layout_style'] == '7' ){
			echo '<div class="testi-area7">';
                echo '<div class="swiper th-slider thumb-slider1 slider-tab" thumbsSlider="" id="thumb-slider1" data-slider-options=\'{"loop":true,"centeredSlides":true,"spaceBetween":50,"slideToClickedSlide":true,"watchSlidesVisibility":true,"watchSlidesProgress":true,"centeredSlidesBounds":true,"breakpoints":{"0":{"slidesPerView":3},"576":{"slidesPerView":"5"}}}\'>';
                    echo '<div class="swiper-wrapper">';

                        foreach( $settings['slides'] as $data ){
	                        echo '<div class="swiper-slide">';
	                            echo '<div class="tab-btn">';
	                                echo mediax_img_tag( array(
										'url'	=> esc_url( $data['client_image']['url'] ),
									) );
	                            echo '</div>';
	                        echo '</div>';
	                    }
                        

                    echo '</div>';
                echo '</div>';
                echo '<div class="slider-area">';
                    echo '<div class="swiper th-slider has-shadow tab-view" id="testiSlide7" data-slider-options=\'{"effect":"slide","thumbs":{"swiper":".thumb-slider1"}}\'>';
                        echo '<div class="swiper-wrapper">';


                        	foreach( $settings['slides'] as $data ){
	                            echo '<div class="swiper-slide">';
	                                echo '<div class="testi-style7">';
	                                    if(!empty($data['client_name'])){
											echo '<h3 class="box-title name">'.wp_kses_post( $data['client_name'] ).'</h3>';
										}
	                                    if(!empty($data['client_desig'])){
											echo '<p class="box-desig desig">'.wp_kses_post( $data['client_desig'] ).'</p>';
										}
	                                    if(!empty($data['client_feedback'])){
											echo '<p class="box-text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
										}
	                                    echo '<div class="box-review">';
	                                        if( $data['client_rating'] == '1' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '2' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '3' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '4' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}else{
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
											}
	                                    echo '</div>';
	                                echo '</div>';
	                            echo '</div>';
	                        }
                        echo '</div>';
                    echo '</div>';
                    echo '<button data-slider-prev="#thumb-slider1, #testiSlide7" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
                    echo '<button data-slider-next="#thumb-slider1, #testiSlide7" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
                echo '</div>';
            echo '</div>';
		}else{
		echo '<section class="space">';
	        echo '<div class="container">';
	            echo '<div class="title-area text-center">';
					if(!empty($settings['section_desc'])){
                        echo '<span class="sub-title5 justify-content-center">'.wp_kses_post($settings['section_desc']).'</span>';
                    }
                    if(!empty($settings['section_title'])){
						echo '<h2 class="sec-title">'.wp_kses_post($settings['section_title']).'</h2>';
					}
	            echo '</div>';
				echo '<div class="swiper th-slider" id="testiSlide1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"2"}}}\'>';
	                echo '<div class="swiper-wrapper">';
	                	foreach( $settings['slides'] as $data ){
		                    echo '<div class="swiper-slide">';
		                        echo '<div class="testi-card bg-smoke">';
		                            echo '<div class="box-review">';
	                                 		if( $data['client_rating'] == '1' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '2' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '3' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}elseif( $data['client_rating'] == '4' ){
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-regular fa-star"></i>';
											}else{
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
												echo '<i class="fa-solid fa-star"></i>';
											}
		                            echo '</div>';
		                            if(!empty($settings['quote_image']['url'])){
										echo '<div class="box-quote">';
											echo mediax_img_tag( array(
												'url'	=> esc_url( $settings['quote_image']['url'] ), 
											) ); 
										echo '</div>';
									}
	                        		if(!empty($data['client_feedback'])){
										echo '<p class="box-text">'.wp_kses_post( $data['client_feedback'] ).'</p>';
									}
		                            echo '<div class="box-profile">';
		                                echo '<div class="box-img">';
	                               			echo mediax_img_tag( array(
												'url'	=> esc_url( $data['client_image']['url'] ),
											) );
		                                echo '</div>';
		                                echo '<div class="box-content">';

		                                    if(!empty($data['client_name'])){
												echo '<h3 class="box-title">'.wp_kses_post( $data['client_name'] ).'</h3>';
											}
		                                    if(!empty($data['client_desig'])){
												echo '<span class="box-desig">'.wp_kses_post( $data['client_desig'] ).'</span>';
											}
		                                    
		                                echo '</div>';
		                            echo '</div>';
		                        echo '</div>';
		                    echo '</div>';
	                   	}
	                	echo '</div>';
	                echo '<div class="slider-pagination"></div>';
	            echo '</div>';
		 	echo '</div>';
    	echo '</section>';
		}
	}

}