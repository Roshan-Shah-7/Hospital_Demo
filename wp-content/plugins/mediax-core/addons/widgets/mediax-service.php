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
 * Service Widget .
 *
 */
class mediax_Service extends Widget_Base {

	public function get_name() {
		return 'mediaxservice';
	}
	public function get_title() {
		return __( 'Services', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		 $this->start_controls_section(
			'service_section',
			[
				'label'     => __( 'Services', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One', 'Style Two', 'Style Three','Style Four','Style Five','Style Six','Style Seven' ] );

		mediax_switcher_fields( $this, 'top_show', 'Heading & Button Show?', ['2'] );
		mediax_general_fields( $this, 'section_sub', 'Subtitle', 'TEXTAREA2', 'Our Services', [ '2','7'] );
		mediax_general_fields( $this, 'section_title', 'Title', 'TEXTAREA2', 'Best Dental Service for you', [ '2','7' ] );
		mediax_general_fields( $this, 'bac_title', 'Background Title', 'TEXTAREA2', 'Background Title', [ '2','7' ] );
		mediax_media_fields( $this, 'shape', 'Choose Shape', [ '1','4','5' ] );


		$fields_to_include = [ 'image' => ['Choose Image', 'Choose Icon'], 'title' => ['Title'], 'desc' => ['Description'], 'btn' => ['Button Text'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'service_list', 'Service Lists', $fields_to_include, ['1', '3', '6'] );


		$fields_to_include5 = [ 'image' => ['Choose Image', 'Choose Icon'], 'title' => ['Title'], 'content' => ['Description'],  'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'service_list5', 'Service Lists', $fields_to_include5, ['5'] );




		$fields_to_include2 = [ 'image' => ['Choose Icon'], 'title' => ['Title'], 'desc' => ['Description', 'Lists'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'service_list_2', 'Service Lists', $fields_to_include2, ['2'] );


		$fields_to_include3 = [ 'image' => ['Choose Image', 'Choose Icon'], 'title' => ['Title', 'Dr Name'], 'desc' => ['Description'], 'btn' => ['Button Text'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'service_list4', 'Service Lists', $fields_to_include3, ['4'] );

		$fields_to_include7 = [ 'image' => ['Choose Image', 'Choose Icon'], 'title' => ['Title'], 'desc' => ['Description'], 'btn' => ['Button Text'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'service_list7', 'Service Lists', $fields_to_include7, ['7'] );

		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', '', [ '1', '2' ] );
		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXT', 'Button Text', [ '1', '2' ] );
		mediax_url_fields( $this, 'button_url', 'Button URL', [ '1', '2' ] );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------
		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'subtitle2', 'Section Subtitle', '{{WRAPPER}} .sub-title', ['2'],'--theme-color' );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title2', 'Section Title', '{{WRAPPER}} .sec-title', ['2'] );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title' );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .desc' );
		//------Button Style-------
		mediax_button_style_fields( $this, '10', 'Button Styling', '{{WRAPPER}} .th_btn', ['1'] );


	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="row gy-4 justify-content-center">';
				foreach( $settings['service_list'] as $data ){
					echo '<div class="col-xl-3 col-lg-4 col-sm-6">';
						echo '<div class="service-card" data-bg-src="'.esc_url( $data['choose_image']['url'] ).'">';
							if(!empty($settings['shape']['url'])){
								echo '<div class="box-shape">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $settings['shape']['url'] ),
									));
								echo '</div>';
							}
							if(!empty($data['choose_icon']['url'])){
								echo '<div class="box-icon">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
								echo '</div>';
							}
							if(!empty($data['title'])){
								echo '<h3 class="box-title title"><a href="'.esc_url( $data['url']['url'] ).'">'.esc_html($data['title']).'</a></h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text desc">'.esc_html($data['description']).'</p>';
							}
							if(!empty($data['button_text'])){
								echo '<a href="'.esc_url( $data['url']['url'] ).'" class="th-btn btn-sm style2 theme-color th_btn">'.wp_kses_post($data['button_text']).'</a>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			if(!empty($settings['button_text'])){
				echo '<div class="mt-5 pt-2">';
					echo '<p class="round-text"><span class="text">'.esc_html($settings['title']).' <a href="'.esc_url( $settings['button_url']['url'] ).'" class="line-btn">'.wp_kses_post($settings['button_text']).'</a></span></p>';
				echo '</div>';
			}

		}elseif( $settings['layout_style'] == '2' ){
			if(!empty($settings['top_show'])){
				echo '<div class="row justify-content-lg-between justify-content-center align-items-end">';
					echo '<div class="col-lg">';
						echo '<div class="title-area text-center text-lg-start">';
							if(!empty($settings['section_sub'])){
								echo '<span class="sub-title"><img src="'.MEDIAX_ASSETS.'img/title_icon.svg" alt="'.esc_attr__('Shape', 'mediax').'">'.wp_kses_post($settings['section_sub']).'</span>';
							}
							if(!empty($settings['section_title'])){
								echo '<h2 class="sec-title">'.wp_kses_post($settings['section_title']).'</h2>';
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="col-lg-auto d-none d-lg-block">';
						echo '<div class="sec-btn">';
							echo '<div class="icon-box">';
								echo '<button class="slider-arrow service-prev default"><i class="far fa-arrow-left"></i></button>';
								echo '<button class="slider-arrow service-next default"><i class="far fa-arrow-right"></i></button>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
			echo '<div class="service-list-area">';
				foreach( $settings['service_list_2'] as $key => $data ){
					$active = ($key == 2) ? 'active':'';
					echo '<div class="service-list-wrap '.esc_attr($active).'">';
						echo '<div class="service-list">';
							if(!empty($data['choose_icon']['url'])){
								echo '<div class="box-icon">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
								echo '</div>';
							}
							echo '<div class="content-wrap">';
								if(!empty($data['title'])){
									echo '<div class="box-title-wrap">';
										echo '<h3 class="box-title title">'.esc_html($data['title']).'</h3>';
									echo '</div>';
								}
								echo '<div class="box-content">';
									if(!empty($data['title'])){
										echo '<h3 class="box-title title"><a href="'.esc_url( $data['url']['url'] ).'">'.esc_html($data['title']).'</a></h3>';
									}
									if(!empty($data['description'])){
										echo '<p class="box-text desc">'.esc_html($data['description']).'</p>';
									}
									if(!empty($data['lists'])){
										echo '<div class="checklist">'.wp_kses_post($data['lists']).'</div>';
									}
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			if(!empty($settings['button_text'])){
				echo '<div class="mt-5 pt-2">';
					echo '<p class="round-bg-text">'.esc_html($settings['title']).' <a href="'.esc_url( $settings['button_url']['url'] ).'" class="line-btn">'.wp_kses_post($settings['button_text']).'</a></p>';
				echo '</div>';
			}

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="row gy-4 justify-content-center">';
				foreach( $settings['service_list'] as $data ){
					echo '<div class="col-xl-3 col-lg-4 col-sm-6">';
						echo '<div class="service-card" data-bg-src="'.esc_url( $data['choose_image']['url'] ).'">';
							if(!empty($settings['shape']['url'])){
								echo '<div class="box-shape">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $settings['shape']['url'] ),
									));
								echo '</div>';
							}
							if(!empty($data['choose_icon']['url'])){
								echo '<div class="box-icon">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
								echo '</div>';
							}
							if(!empty($data['title'])){
								echo '<h3 class="box-title title"><a href="'.esc_url( $data['url']['url'] ).'">'.esc_html($data['title']).'</a></h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text desc">'.esc_html($data['description']).'</p>';
							}
							if(!empty($data['button_text'])){
								echo '<a href="'.esc_url( $data['url']['url'] ).'" class="th-btn btn-sm style2 theme-color th_btn">'.wp_kses_post($data['button_text']).'</a>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			
		}elseif( $settings['layout_style'] == '4' ){
			echo '<div class="slider-area">';
                echo '<div class="swiper th-slider has-shadow" id="serviceSlider3" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
                    echo '<div class="swiper-wrapper">';

                        foreach( $settings['service_list4'] as $data ){
	                        echo '<div class="swiper-slide">';
	                            echo '<div class="service-grid">';
	                                if(!empty($settings['shape']['url'])){
										echo '<div class="box-shape">';
											echo mediax_img_tag( array(
												'url'   => esc_url( $settings['shape']['url'] ),
											));
										echo '</div>';
									}
	                                echo '<div class="box-img">';
	                                    echo '<div class="img">';
	                                        echo '<img class="w-100" src="'.esc_url( $data['choose_image']['url'] ).'" alt="Icon">';
	                                    echo '</div>';
	                                    if(!empty($data['choose_icon']['url'])){
											echo '<div class="box-icon">';
												echo mediax_img_tag( array(
													'url'   => esc_url( $data['choose_icon']['url'] ),
												));
											echo '</div>';
										}
	                                echo '</div>';
	                                echo '<div class="box-content">';
	                                	if(!empty($data['dr_name'])){
		                                    echo '<p class="box-doctor">'.esc_html($data['dr_name']).'</p>';
		                                }
	                                    if(!empty($data['title'])){
											echo '<h3 class="box-title"><a href="'.esc_url( $data['url']['url'] ).'">'.esc_html($data['title']).'</a></h3>';
										}
	                                    if(!empty($data['description'])){
											echo '<p class="box-text desc">'.esc_html($data['description']).'</p>';
										}
										if(!empty($data['button_text'])){
		                                    echo '<a href="'.esc_url( $data['url']['url'] ).'" class="th-btn btn-sm style2">'.wp_kses_post($data['button_text']).'</a>';
		                                }
	                                echo '</div>';
	                            echo '</div>';
	                        echo '</div>';
	                    }
                        

                    echo '</div>';
                echo '</div>';
                echo '<button data-slider-prev="#serviceSlider3" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
                echo '<button data-slider-next="#serviceSlider3" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
            echo '</div>';
		}elseif( $settings['layout_style'] == '5' ){
			echo '<div class="nav service-block-tab" id="service-block-tab" role="tablist">';
				$x = 0;
				foreach( $settings['service_list5'] as $data ){
					$x++;

					$active_class = $x == 1 ? 'active' : '';

	                echo '<button class="tab-btn '.esc_attr( $active_class ).'" id="nav-'.esc_attr( $x ).'-tab" data-bs-toggle="tab" data-bs-target="#nav-'.esc_attr( $x ).'" type="button" role="tab" aria-controls="nav-'.esc_attr( $x ).'" aria-selected="true">';
	                    if(!empty($data['choose_icon']['url'])){
							echo '<div class="box-icon">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['choose_icon']['url'] ),
								));
							echo '</div>';
						}
						if(!empty( $data['title'] )){
		                    echo $data['title'];
		                }
	                echo '</button>';
	            }
                

            echo '</div>';
            echo '<div class="tab-content">';
                $x = 0;
				foreach( $settings['service_list5'] as $data ){
					$x++;

					$active_class = $x == 1 ? 'show active' : '';
	                echo '<!-- Single item -->';
	                echo '<div class="tab-pane fade '.esc_attr( $active_class ).'" id="nav-'.esc_attr( $x ).'" role="tabpanel" aria-labelledby="nav-'.esc_attr( $x ).'-tab">';
	                    echo '<div class="service-block" data-bg-src="'.esc_url( $settings['shape']['url'] ).'">';
	                    	if(!empty($data['choose_image']['url'])){
		                        echo '<div class="box-img">';
		                            echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_image']['url'] ),
									));
		                        echo '</div>';
		                    }
	                        echo '<div class="box-content">';
	                        	if(!empty( $data['title'] )){
		                            echo '<h3 class="box-title title"><a href="'.esc_url( $data['url']['url'] ).'">'.esc_html($data['title']).'</a></h3>';
		                        }
	                            
		                        if(!empty( $data['description'] )){
				                    echo wp_kses_post( $data['description'] );
				                }

	                        echo '</div>';
	                    echo '</div>';
	                echo '</div>';
	            }
            echo '</div>';
		}elseif( $settings['layout_style'] == '6' ){
			echo '<div class="slider-area">';
	            echo '<div class="swiper th-slider has-shadow" id="serviceSlider4" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
	                echo '<div class="swiper-wrapper">';

	                    foreach( $settings['service_list'] as $data ){
		                    echo '<div class="swiper-slide">';
		                        echo '<div class="service-element">';
		                            if(!empty($data['choose_icon']['url'])){
										echo '<div class="box-icon">';
											echo mediax_img_tag( array(
												'url'   => esc_url( $data['choose_icon']['url'] ),
											));
										echo '</div>';
									}
		                            if(!empty($data['title'])){
										echo '<h3 class="box-title title"><a href="'.esc_url( $data['url']['url'] ).'">'.esc_html($data['title']).'</a></h3>';
									}
		                            if(!empty($data['description'])){
										echo '<p class="box-text desc">'.esc_html($data['description']).'</p>';
									}
									if(!empty($data['button_text'])){
			                            echo '<a href="'.esc_url( $data['url']['url'] ).'" class="th-btn btn-sm style2">'.wp_kses_post($data['button_text']).'</a>';
			                        }
		                        echo '</div>';
		                    echo '</div>';
		                }
	                    
	                echo '</div>';
	            echo '</div>';
	            echo '<button data-slider-prev="#serviceSlider4" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
	            echo '<button data-slider-next="#serviceSlider4" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
	        echo '</div>';

		}elseif( $settings['layout_style'] == '7' ){

			echo '<section class="space bg-smoke radius-100">';
		        echo '<div class="container">';
		            echo '<div class="row justify-content-center">';
		                echo '<div class="col-lg-8">';
		                    echo '<div class="title-area text-center">';
		                        echo '<span class="shadow-title">'.wp_kses_post($settings['bac_title']).'</span>';
		                        echo '<span class="sub-title5 justify-content-center">'.wp_kses_post($settings['section_sub']).'</span>';
		                        echo '<h2 class="sec-title">'.wp_kses_post($settings['section_title']).'</h2>';
		                    echo '</div>';
		                echo '</div>';
		            echo '</div>';
		            echo '<div class="slider-area">';
		                echo '<div class="swiper th-slider has-shadow" id="serviceSlider6" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
		                    echo '<div class="swiper-wrapper">';

 								foreach( $settings['service_list7'] as $data ){
			                        echo '<div class="swiper-slide">';
			                            echo '<div class="service-card2">';
			                                if(!empty($data['choose_image']['url'])){
						                        echo '<div class="service-card-bg-shape" data-mask-src="'.esc_url( $data['choose_image']['url'] ).'"></div>';
						                    }
			                                echo '<div class="box-icon">';
				                                  echo mediax_img_tag( array(
													'url'   => esc_url( $data['choose_icon']['url'] ),
												));
			                                echo '</div>';

			                                if(!empty($data['title'])){
												echo '<h3 class="box-title"><a href="'.esc_url( $data['url']['url'] ).'">'.esc_html($data['title']).'</a></h3>';
											}

											if(!empty($data['description'])){
												echo '<p class="box-text">'.esc_html($data['description']).'.</p>';
											}

											if(!empty($data['button_text'])){
					                            echo '<a href="'.esc_url( $data['url']['url'] ).'" class="th-btn btn-sm style7">'.wp_kses_post($data['button_text']).'</a>';
					                        }
			                            
			                           echo '</div>';
			                        echo '</div>';
		                       }

		                    echo '</div>';
		                echo '</div>';
		                echo '<button data-slider-prev="#serviceSlider6" class="slider-arrow style2 slider-prev"><i class="far fa-arrow-left"></i></button>';
		                echo '<button data-slider-next="#serviceSlider6" class="slider-arrow style2 slider-next"><i class="far fa-arrow-right"></i></button>';
		            echo '</div>';
		        echo '</div>';
		    echo '</section>';

		}
	}

}