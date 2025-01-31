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
 * Team Widget .
 *
 */
class mediax_Team extends Widget_Base {

	public function get_name() {
		return 'mediaxteam';
	}
	public function get_title() {
		return __( 'Team', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'team_section',
			[
				'label'     => __( 'Team Content', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five', 'Style Six','Style Seven'] );

		mediax_general_fields( $this, 'arrow_id', 'Arrow ID', 'TEXT', 'teamSlider2', ['2'] );

		$fields_to_include = [ 'image' => ['Team Image'], 'title' => ['Name', 'Designation'], 'url' => ['Profile URL', 'Facebook URL', 'Twitter URL', 'Linkedin URL', 'Instagram URL'] ];
		mediax_repeater_fields( $this, 'team_lists', 'Member Lists', $fields_to_include );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Name Style-------
		mediax_common_style_fields($this, 'name', 'Name', '{{WRAPPER}} .box-title');
		//-------Designation Style-------
		mediax_common_style_fields($this, 'desc', 'Designation', '{{WRAPPER}} .team-desig,{{WRAPPER}} .box-text');


	}

	protected function render() {

        $settings = $this->get_settings_for_display();

			if( $settings['layout_style'] == '1' ){
				echo '<div class="swiper th-slider has-shadow" id="teamSlider1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}\'>';
					echo '<div class="swiper-wrapper">';
						foreach( $settings['team_lists'] as $data ){
							$target = $data['profile_url']['is_external'] ? ' target="_blank"' : '';
							$nofollow = $data['profile_url']['nofollow'] ? ' rel="nofollow"' : '';

							$f_target = $data['facebook_url']['is_external'] ? ' target="_blank"' : '';
							$f_nofollow = $data['facebook_url']['nofollow'] ? ' rel="nofollow"' : '';
							$t_target = $data['twitter_url']['is_external'] ? ' target="_blank"' : '';
							$t_nofollow = $data['twitter_url']['nofollow'] ? ' rel="nofollow"' : '';
							$l_target = $data['linkedin_url']['is_external'] ? ' target="_blank"' : '';
							$l_nofollow = $data['linkedin_url']['nofollow'] ? ' rel="nofollow"' : '';
							$i_target = $data['instagram_url']['is_external'] ? ' target="_blank"' : '';
							$i_nofollow = $data['instagram_url']['nofollow'] ? ' rel="nofollow"' : '';

							echo '<div class="swiper-slide">';
								echo '<div class="th-team team-card">';
									echo '<div class="box-img">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $data['team_image']['url']  ),
										));
										echo '<div class="th-social">';
											if( ! empty( $data['facebook_url']['url']) ){
												echo '<a '.wp_kses_post( $f_nofollow.$f_target ).' href="'.esc_url( $data['facebook_url']['url'] ).'"><i class="fab fa-facebook-f"></i></a>';
											}
											if( ! empty( $data['twitter_url']['url']) ){
												echo '<a '.wp_kses_post( $t_nofollow.$t_target ).' href="'.esc_url( $data['twitter_url']['url'] ).'"><i class="fab fa-twitter"></i></a>';
											}
											if( ! empty( $data['linkedin_url']['url']) ){
												echo '<a '.wp_kses_post( $l_nofollow.$l_target ).' href="'.esc_url( $data['linkedin_url']['url'] ).'"><i class="fab fa-linkedin-in"></i></a>';
											}
											if( ! empty( $data['instagram_url']['url']) ){
												echo '<a '.wp_kses_post( $i_nofollow.$i_target ).' href="'.esc_url( $data['instagram_url']['url'] ).'"><i class="fab fa-instagram"></i></a>';
											}
										echo '</div>';
									echo '</div>';
									if($data['name']){
										echo '<h3 class="box-title"><a href="'.esc_url( $data['profile_url']['url'] ).'">'.esc_html($data['name']).'</a></h3>';
									}
									if($data['designation']){
										echo '<span class="team-desig">'.esc_html($data['designation']).'</span>';
									}
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';

			}elseif( $settings['layout_style'] == '2' ){
				echo '<div class="swiper th-slider has-shadow" id="'.esc_attr($settings['arrow_id']).'" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}}}\'>';
					echo '<div class="swiper-wrapper">';
						foreach( $settings['team_lists'] as $data ){
							$target = $data['profile_url']['is_external'] ? ' target="_blank"' : '';
							$nofollow = $data['profile_url']['nofollow'] ? ' rel="nofollow"' : '';

							$f_target = $data['facebook_url']['is_external'] ? ' target="_blank"' : '';
							$f_nofollow = $data['facebook_url']['nofollow'] ? ' rel="nofollow"' : '';
							$t_target = $data['twitter_url']['is_external'] ? ' target="_blank"' : '';
							$t_nofollow = $data['twitter_url']['nofollow'] ? ' rel="nofollow"' : '';
							$l_target = $data['linkedin_url']['is_external'] ? ' target="_blank"' : '';
							$l_nofollow = $data['linkedin_url']['nofollow'] ? ' rel="nofollow"' : '';
							$i_target = $data['instagram_url']['is_external'] ? ' target="_blank"' : '';
							$i_nofollow = $data['instagram_url']['nofollow'] ? ' rel="nofollow"' : '';

							echo '<div class="swiper-slide">';
								echo '<div class="th-team team-box">';
									echo '<div class="box-img">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $data['team_image']['url']  ),
										));
										echo '<div class="th-social">';
											if( ! empty( $data['facebook_url']['url']) ){
												echo '<a '.wp_kses_post( $f_nofollow.$f_target ).' href="'.esc_url( $data['facebook_url']['url'] ).'"><i class="fab fa-facebook-f"></i></a>';
											}
											if( ! empty( $data['twitter_url']['url']) ){
												echo '<a '.wp_kses_post( $t_nofollow.$t_target ).' href="'.esc_url( $data['twitter_url']['url'] ).'"><i class="fab fa-twitter"></i></a>';
											}
											if( ! empty( $data['linkedin_url']['url']) ){
												echo '<a '.wp_kses_post( $l_nofollow.$l_target ).' href="'.esc_url( $data['linkedin_url']['url'] ).'"><i class="fab fa-linkedin-in"></i></a>';
											}
											if( ! empty( $data['instagram_url']['url']) ){
												echo '<a '.wp_kses_post( $i_nofollow.$i_target ).' href="'.esc_url( $data['instagram_url']['url'] ).'"><i class="fab fa-instagram"></i></a>';
											}
										echo '</div>';
									echo '</div>';
									if($data['name']){
										echo '<h3 class="box-title"><a href="'.esc_url( $data['profile_url']['url'] ).'">'.esc_html($data['name']).'</a></h3>';
									}
									if($data['designation']){
										echo '<span class="team-desig">'.esc_html($data['designation']).'</span>';
									}
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';

			}elseif( $settings['layout_style'] == '3' ){
				echo '<div class="row gy-40 justify-content-center">';
						foreach( $settings['team_lists'] as $data ){
							$target = $data['profile_url']['is_external'] ? ' target="_blank"' : '';
							$nofollow = $data['profile_url']['nofollow'] ? ' rel="nofollow"' : '';

							$f_target = $data['facebook_url']['is_external'] ? ' target="_blank"' : '';
							$f_nofollow = $data['facebook_url']['nofollow'] ? ' rel="nofollow"' : '';
							$t_target = $data['twitter_url']['is_external'] ? ' target="_blank"' : '';
							$t_nofollow = $data['twitter_url']['nofollow'] ? ' rel="nofollow"' : '';
							$l_target = $data['linkedin_url']['is_external'] ? ' target="_blank"' : '';
							$l_nofollow = $data['linkedin_url']['nofollow'] ? ' rel="nofollow"' : '';
							$i_target = $data['instagram_url']['is_external'] ? ' target="_blank"' : '';
							$i_nofollow = $data['instagram_url']['nofollow'] ? ' rel="nofollow"' : '';

							echo '<div class="col-xl-3 col-lg-4 col-sm-6">';
								echo '<div class="th-team team-card">';
									echo '<div class="box-img">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $data['team_image']['url']  ),
										));
										echo '<div class="th-social">';
											if( ! empty( $data['facebook_url']['url']) ){
												echo '<a '.wp_kses_post( $f_nofollow.$f_target ).' href="'.esc_url( $data['facebook_url']['url'] ).'"><i class="fab fa-facebook-f"></i></a>';
											}
											if( ! empty( $data['twitter_url']['url']) ){
												echo '<a '.wp_kses_post( $t_nofollow.$t_target ).' href="'.esc_url( $data['twitter_url']['url'] ).'"><i class="fab fa-twitter"></i></a>';
											}
											if( ! empty( $data['linkedin_url']['url']) ){
												echo '<a '.wp_kses_post( $l_nofollow.$l_target ).' href="'.esc_url( $data['linkedin_url']['url'] ).'"><i class="fab fa-linkedin-in"></i></a>';
											}
											if( ! empty( $data['instagram_url']['url']) ){
												echo '<a '.wp_kses_post( $i_nofollow.$i_target ).' href="'.esc_url( $data['instagram_url']['url'] ).'"><i class="fab fa-instagram"></i></a>';
											}
										echo '</div>';
									echo '</div>';
									if($data['name']){
										echo '<h3 class="box-title"><a href="'.esc_url( $data['profile_url']['url'] ).'">'.esc_html($data['name']).'</a></h3>';
									}
									if($data['designation']){
										echo '<span class="team-desig">'.esc_html($data['designation']).'</span>';
									}
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';

			}elseif( $settings['layout_style'] == '4' ){
				echo '<div class="slider-area">';
	                echo '<div class="swiper th-slider has-shadow" id="teamSlider3" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}\'>';
	                    echo '<div class="swiper-wrapper">';
	                    	foreach( $settings['team_lists'] as $data ){
								$target = $data['profile_url']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $data['profile_url']['nofollow'] ? ' rel="nofollow"' : '';

								$f_target = $data['facebook_url']['is_external'] ? ' target="_blank"' : '';
								$f_nofollow = $data['facebook_url']['nofollow'] ? ' rel="nofollow"' : '';
								$t_target = $data['twitter_url']['is_external'] ? ' target="_blank"' : '';
								$t_nofollow = $data['twitter_url']['nofollow'] ? ' rel="nofollow"' : '';
								$l_target = $data['linkedin_url']['is_external'] ? ' target="_blank"' : '';
								$l_nofollow = $data['linkedin_url']['nofollow'] ? ' rel="nofollow"' : '';
								$i_target = $data['instagram_url']['is_external'] ? ' target="_blank"' : '';
								$i_nofollow = $data['instagram_url']['nofollow'] ? ' rel="nofollow"' : '';
	                    	
		                        echo '<!-- Single Item -->';
		                        echo '<div class="swiper-slide">';
		                            echo '<div class="th-team team-grid">';
		                                echo '<div class="box-img">';
		                                    echo mediax_img_tag( array(
												'url'   => esc_url( $data['team_image']['url']  ),
											));
		                                    echo '<div class="team-social">';
		                                        echo '<div class="th-social">';
		                                            if( ! empty( $data['facebook_url']['url']) ){
														echo '<a '.wp_kses_post( $f_nofollow.$f_target ).' href="'.esc_url( $data['facebook_url']['url'] ).'"><i class="fab fa-facebook-f"></i></a>';
													}
													if( ! empty( $data['twitter_url']['url']) ){
														echo '<a '.wp_kses_post( $t_nofollow.$t_target ).' href="'.esc_url( $data['twitter_url']['url'] ).'"><i class="fab fa-twitter"></i></a>';
													}
													if( ! empty( $data['linkedin_url']['url']) ){
														echo '<a '.wp_kses_post( $l_nofollow.$l_target ).' href="'.esc_url( $data['linkedin_url']['url'] ).'"><i class="fab fa-linkedin-in"></i></a>';
													}
													if( ! empty( $data['instagram_url']['url']) ){
														echo '<a '.wp_kses_post( $i_nofollow.$i_target ).' href="'.esc_url( $data['instagram_url']['url'] ).'"><i class="fab fa-instagram"></i></a>';
													}
		                                        echo '</div>';
		                                        echo '<button class="icon-btn"><i class="fa-solid fa-link"></i></button>';
		                                    echo '</div>';
		                                echo '</div>';
		                                echo '<div class="box-content">';
		                                	if($data['name']){
												echo '<h3 class="box-title"><a href="'.esc_url( $data['profile_url']['url'] ).'">'.esc_html($data['name']).'</a></h3>';
											}
											if($data['designation']){
												echo '<p class="box-text">'.esc_html($data['designation']).'</p>';
											}
		                                echo '</div>';
		                            echo '</div>';
		                        echo '</div>';
		                    }
	                    echo '</div>';
	                echo '</div>';
	                echo '<button data-slider-prev="#teamSlider3" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
	                echo '<button data-slider-next="#teamSlider3" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
	            echo '</div>';
			}elseif( $settings['layout_style'] == '5' ){
				echo '<div class="slider-area">';
	                echo '<div class="swiper th-slider has-shadow" id="teamSlider4" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
	                    echo '<div class="swiper-wrapper">';

	                        foreach( $settings['team_lists'] as $data ){
								$target = $data['profile_url']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $data['profile_url']['nofollow'] ? ' rel="nofollow"' : '';

								$f_target = $data['facebook_url']['is_external'] ? ' target="_blank"' : '';
								$f_nofollow = $data['facebook_url']['nofollow'] ? ' rel="nofollow"' : '';
								$t_target = $data['twitter_url']['is_external'] ? ' target="_blank"' : '';
								$t_nofollow = $data['twitter_url']['nofollow'] ? ' rel="nofollow"' : '';
								$l_target = $data['linkedin_url']['is_external'] ? ' target="_blank"' : '';
								$l_nofollow = $data['linkedin_url']['nofollow'] ? ' rel="nofollow"' : '';
								$i_target = $data['instagram_url']['is_external'] ? ' target="_blank"' : '';
								$i_nofollow = $data['instagram_url']['nofollow'] ? ' rel="nofollow"' : '';
		                        echo '<!-- Single Item -->';
		                        echo '<div class="swiper-slide">';
		                            echo '<div class="th-team team-block">';
		                                echo '<div class="box-img">';
		                                    echo mediax_img_tag( array(
												'url'   => esc_url( $data['team_image']['url']  ),
											));
		                                echo '</div>';
		                                echo '<div class="team-social">';
		                                    echo '<div class="social-links">';
		                                        if( ! empty( $data['facebook_url']['url']) ){
													echo '<a '.wp_kses_post( $f_nofollow.$f_target ).' href="'.esc_url( $data['facebook_url']['url'] ).'"><i class="fab fa-facebook-f"></i></a>';
												}
												if( ! empty( $data['twitter_url']['url']) ){
													echo '<a '.wp_kses_post( $t_nofollow.$t_target ).' href="'.esc_url( $data['twitter_url']['url'] ).'"><i class="fab fa-twitter"></i></a>';
												}
												if( ! empty( $data['linkedin_url']['url']) ){
													echo '<a '.wp_kses_post( $l_nofollow.$l_target ).' href="'.esc_url( $data['linkedin_url']['url'] ).'"><i class="fab fa-linkedin-in"></i></a>';
												}
												if( ! empty( $data['instagram_url']['url']) ){
													echo '<a '.wp_kses_post( $i_nofollow.$i_target ).' href="'.esc_url( $data['instagram_url']['url'] ).'"><i class="fab fa-instagram"></i></a>';
												}
		                                    echo '</div>';
		                                    echo '<button class="icon-btn"><i class="fas fa-link"></i></button>';
		                                echo '</div>';
		                                echo '<div class="box-content">';
		                                    if($data['name']){
												echo '<h3 class="box-title"><a href="'.esc_url( $data['profile_url']['url'] ).'">'.esc_html($data['name']).'</a></h3>';
											}
											if($data['designation']){
												echo '<p class="box-text">'.esc_html($data['designation']).'</p>';
											}
		                                echo '</div>';
		                            echo '</div>';
		                        echo '</div>';
		                    }

	                        
	                    echo '</div>';
	                echo '</div>';
	                echo '<button data-slider-prev="#teamSlider4" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
	                echo '<button data-slider-next="#teamSlider4" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
	            echo '</div>';
			}elseif( $settings['layout_style'] == '6' ){
				echo '<div class="slider-area">';
	                echo '<div class="swiper th-slider has-shadow" id="teamSlider5" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}}}\'>';
	                    echo '<div class="swiper-wrapper">';
	                    	foreach( $settings['team_lists'] as $data ){
								$target = $data['profile_url']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $data['profile_url']['nofollow'] ? ' rel="nofollow"' : '';

								$f_target = $data['facebook_url']['is_external'] ? ' target="_blank"' : '';
								$f_nofollow = $data['facebook_url']['nofollow'] ? ' rel="nofollow"' : '';
								$t_target = $data['twitter_url']['is_external'] ? ' target="_blank"' : '';
								$t_nofollow = $data['twitter_url']['nofollow'] ? ' rel="nofollow"' : '';
								$l_target = $data['linkedin_url']['is_external'] ? ' target="_blank"' : '';
								$l_nofollow = $data['linkedin_url']['nofollow'] ? ' rel="nofollow"' : '';
								$i_target = $data['instagram_url']['is_external'] ? ' target="_blank"' : '';
								$i_nofollow = $data['instagram_url']['nofollow'] ? ' rel="nofollow"' : '';
	                        
		                        echo '<!-- Single Item -->';
		                        echo '<div class="swiper-slide">';
		                            echo '<div class="th-team team-member">';
		                                echo '<div class="box-img">';
		                                    echo mediax_img_tag( array(
												'url'   => esc_url( $data['team_image']['url']  ),
											));
		                                echo '</div>';
		                                echo '<div class="box-content">';
		                                    if($data['name']){
												echo '<h3 class="box-title"><a href="'.esc_url( $data['profile_url']['url'] ).'">'.esc_html($data['name']).'</a></h3>';
											}
		                                    if($data['designation']){
												echo '<p class="box-text">'.esc_html($data['designation']).'</p>';
											}
		                                    echo '<div class="th-social">';
		                                        if( ! empty( $data['facebook_url']['url']) ){
													echo '<a '.wp_kses_post( $f_nofollow.$f_target ).' href="'.esc_url( $data['facebook_url']['url'] ).'"><i class="fab fa-facebook-f"></i></a>';
												}
												if( ! empty( $data['twitter_url']['url']) ){
													echo '<a '.wp_kses_post( $t_nofollow.$t_target ).' href="'.esc_url( $data['twitter_url']['url'] ).'"><i class="fab fa-twitter"></i></a>';
												}
												if( ! empty( $data['linkedin_url']['url']) ){
													echo '<a '.wp_kses_post( $l_nofollow.$l_target ).' href="'.esc_url( $data['linkedin_url']['url'] ).'"><i class="fab fa-linkedin-in"></i></a>';
												}
												if( ! empty( $data['instagram_url']['url']) ){
													echo '<a '.wp_kses_post( $i_nofollow.$i_target ).' href="'.esc_url( $data['instagram_url']['url'] ).'"><i class="fab fa-instagram"></i></a>';
												}
		                                    echo '</div>';
		                                echo '</div>';
		                            echo '</div>';
		                        echo '</div>';
		                    }
	                    echo '</div>';
	                echo '</div>';
	                echo '<button data-slider-prev="#teamSlider5" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
	                echo '<button data-slider-next="#teamSlider5" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
	            echo '</div>';
	        }elseif( $settings['layout_style'] == '7' ){

	        	echo '<div class="slider-area">';
	                echo '<div class="swiper th-slider has-shadow" id="teamSlider4" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
	                    echo '<div class="swiper-wrapper">';

							foreach( $settings['team_lists'] as $data ){
								$target = $data['profile_url']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $data['profile_url']['nofollow'] ? ' rel="nofollow"' : '';

								$f_target = $data['facebook_url']['is_external'] ? ' target="_blank"' : '';
								$f_nofollow = $data['facebook_url']['nofollow'] ? ' rel="nofollow"' : '';
								$t_target = $data['twitter_url']['is_external'] ? ' target="_blank"' : '';
								$t_nofollow = $data['twitter_url']['nofollow'] ? ' rel="nofollow"' : '';
								$l_target = $data['linkedin_url']['is_external'] ? ' target="_blank"' : '';
								$l_nofollow = $data['linkedin_url']['nofollow'] ? ' rel="nofollow"' : '';
								$i_target = $data['instagram_url']['is_external'] ? ' target="_blank"' : '';
								$i_nofollow = $data['instagram_url']['nofollow'] ? ' rel="nofollow"' : '';

	                        echo '<div class="swiper-slide">';
	                            echo '<div class="th-team team-block">';
	                                echo '<div class="box-img">';
                                 		echo mediax_img_tag( array(
											'url'   => esc_url( $data['team_image']['url']  ),
										));
	                                echo '</div>';
	                                echo '<div class="team-social">';
	                                    echo '<div class="social-links">';
	                                         	if( ! empty( $data['facebook_url']['url']) ){
													echo '<a '.wp_kses_post( $f_nofollow.$f_target ).' href="'.esc_url( $data['facebook_url']['url'] ).'"><i class="fab fa-facebook-f"></i></a>';
												}
												if( ! empty( $data['twitter_url']['url']) ){
													echo '<a '.wp_kses_post( $t_nofollow.$t_target ).' href="'.esc_url( $data['twitter_url']['url'] ).'"><i class="fab fa-twitter"></i></a>';
												}
												if( ! empty( $data['linkedin_url']['url']) ){
													echo '<a '.wp_kses_post( $l_nofollow.$l_target ).' href="'.esc_url( $data['linkedin_url']['url'] ).'"><i class="fab fa-linkedin-in"></i></a>';
												}
												if( ! empty( $data['instagram_url']['url']) ){
													echo '<a '.wp_kses_post( $i_nofollow.$i_target ).' href="'.esc_url( $data['instagram_url']['url'] ).'"><i class="fab fa-instagram"></i></a>';
												}
	                                    echo '</div>';
	                                    echo '<button class="icon-btn"><i class="fas fa-link"></i></button>';
	                                echo '</div>';
	                                echo '<div class="box-content">';
	                                    if($data['name']){
											echo '<h3 class="box-title bg-black"><a href="'.esc_url( $data['profile_url']['url'] ).'">'.esc_html($data['name']).'</a></h3>';
										}
	                                    if($data['designation']){
											echo '<p class="box-text">'.esc_html($data['designation']).'</p>';
										}
	                                echo '</div>';
	                            echo '</div>';
	                        echo '</div>';
	                    }    
	                       
	                    echo '</div>';
	                echo '</div>';
	                echo '<button data-slider-prev="#teamSlider4" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
	                echo '<button data-slider-next="#teamSlider4" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
	            echo '</div>';

			}
	
			
	}
}