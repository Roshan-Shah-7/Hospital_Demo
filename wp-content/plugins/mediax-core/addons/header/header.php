<?php

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
/**
 *
 * Header Widget . 
 *
 */
class Mediax_Header extends Widget_Base {

	public function get_name() {
		return 'mediaxheader';
	}
	public function get_title() {
		return __( 'Header', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'layout_section',
			[
				'label' 	=> __( 'Header', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five','Style Six' ] );

		$this->end_controls_section();

		include mediax_get_elementor_option('header-options.php');
		include mediax_get_elementor_option('header-2-options.php');
		include mediax_get_elementor_option('header-3-options.php');


		//---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------General Style-------
		 $this->start_controls_section(
			'general_styling',
			[
				'label'     => __( 'Background Styling', 'mediax' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );

		mediax_color_fields( $this, 'topbar_bg', 'Topbar BG', 'background', '{{WRAPPER}} .menu-top', ['1'] );
		mediax_color_fields( $this, 'topbar_bg22', 'Topbar BG', 'background', '{{WRAPPER}} .header-top', ['2'] );
		mediax_color_fields( $this, 'topbar_bg2', 'Topbar BG 2', 'background', '{{WRAPPER}} .info-card-wrap:before', ['1'] );
		mediax_color_fields( $this, 'logo_bg', 'Logo BG', 'background', '{{WRAPPER}} .header-logo', ['2'] );      
		mediax_color_fields( $this, 'menu_bg', 'Menu BG', 'background', '{{WRAPPER}} .menu-area' );      

		$this->end_controls_section();

		//------Menu Bar Style-------
        $this->start_controls_section(
			'menubar_styling2',
			[
				'label'     => __( 'Menu Styling', 'mediax' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );

		mediax_color_fields( $this, 'menu_color', 'Color', 'color', '{{WRAPPER}} .main-menu>ul>li>a', ['2'] );
		mediax_color_fields( $this, 'menu_color7', 'Color', '--white-color', '{{WRAPPER}} .main-menu>ul>li>a', ['1'] );
		mediax_color_fields( $this, 'menu_color6', 'Hover Color', 'color', '{{WRAPPER}} .main-menu>ul>li>a:hover', ['2'] );
		mediax_color_fields( $this, 'menu_color2', 'Hover Color', '--theme-color', '{{WRAPPER}} .main-menu>ul>li>a:hover', ['1'] );
		mediax_color_fields( $this, 'menu_color3', 'Dropdown Color', 'color', '{{WRAPPER}} .main-menu ul.sub-menu li a' );
		mediax_color_fields( $this, 'menu_color4', 'Dropdown Hover Color', 'color', '{{WRAPPER}} .main-menu ul.sub-menu li a:hover' );
		mediax_color_fields( $this, 'menu_color5', 'Menu Icon Color', 'color', '{{WRAPPER}} .main-menu ul.sub-menu li a:before, {{WRAPPER}} .main-menu ul li.menu-item-has-children > a:after' );

		mediax_typography_fields( $this, 'menu_font', 'Menu Trpography', '{{WRAPPER}} .main-menu>ul>li>a, {{WRAPPER}} .main-menu ul.sub-menu li a' );

		mediax_dimensions_fields( $this, 'menu_margin', 'Menu Margin', 'margin', '{{WRAPPER}} .main-menu>ul>li>a' );
		mediax_dimensions_fields( $this, 'menu_padding', 'Menu Padding', 'padding', '{{WRAPPER}} .main-menu>ul>li>a' );

		$this->end_controls_section();

		//------Button Style-------
		mediax_button_style_fields( $this, '12', 'Button Styling', '{{WRAPPER}} .th_btn', ['2'] );

    }



    public function mediax_menu_select(){
	    $mediax_menu = wp_get_nav_menus();
	    $menu_array  = array();
		$menu_array[''] = __( 'Select A Menu', 'mediax' );
	    foreach( $mediax_menu as $menu ){
	        $menu_array[ $menu->slug ] = $menu->name;
	    }
	    return $menu_array;
	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		global $woocommerce;

        //Menu by menu select
        $mediax_avaiable_menu   = $this->mediax_menu_select();
		if( ! $mediax_avaiable_menu ){
			return;
		}
		$args = [
			'menu' 			=> $settings['mediax_menu_select'],
			'menu_class' 	=> 'mediax-menu',
			'container' 	=> '',
		];

		$args2 = [
			'menu' 			=> $settings['2_mediax_menu_select'],
			'menu_class' 	=> 'mediax-menu',
			'container' 	=> '',
		];
		$args3 = [
			'menu' 			=> $settings['3_mediax_menu_select'],
			'menu_class' 	=> 'mediax-menu',
			'container' 	=> '',
		];

		//Mobile menu, Offcanvas, Search
        echo mediax_mobile_menu();

		echo mediax_header_cart_offcanvas();
		if( !empty( $settings['show_cart_btn']) || !empty( $settings['2_show_cart_btn']) ){
		}

		echo mediax_header_offcanvas();
		
		if( !empty( $settings['2_show_search_btn']) ){
			echo mediax_search_box();
		}

		// Header sub-menu icon and sticky header
		if( class_exists( 'ReduxFramework' ) ){ 
			if(mediax_opt('mediax_header_sticky')){
                $sticky = '';
            }else{
                $sticky = '-no';
            }

			if(mediax_opt('mediax_menu_icon')){
				$menu_icon = '';
			}else{
				$menu_icon = 'hide-icon';
			}
		}

		if( class_exists( 'woocommerce' ) ){
    		global $woocommerce;
            if( ! empty( $woocommerce->cart->cart_contents_count ) ){
              $cart_count = $woocommerce->cart->cart_contents_count;
            }else{
              $cart_count = "0";
            } 
    	}

		if( $settings['layout_style'] == '1' ){ 
			$phone = $settings['topbar_phone'] ? $settings['topbar_phone'] : '';     
			$replace_phone  = array(' ','-',' - ', '(', ')');
			$with           = array('','','');
			$phoneurl       = str_replace( $replace_phone, $with, $phone );	

			echo '<div class="th-header header-layout2">';
				if(!empty($settings['show_top_bar'])){
					echo '<div class="menu-top">';
						echo '<div class="container">';
							echo '<div class="row justify-content-center justify-content-lg-between align-items-center gy-2">';
								if(!empty($settings['logo_image']['url'])){
									echo '<div class="col-auto d-none d-lg-block">';
										echo '<div class="header-logo">';
											echo '<a href="'.esc_url( home_url( '/' ) ).'">';
												echo mediax_img_tag( array(
													'url'   => esc_url( $settings['logo_image']['url']  ),
												));
											echo '</a>';
										echo '</div>';
									echo '</div>';
								} 
								if(!empty( $settings['show_search_btn'])){
									echo '<div class="col-auto">';
										echo '<form  method="get" action="'.esc_url( home_url( '/' ) ).'" class="search-form">';
											echo '<input value="'.esc_html( get_search_query() ).'" name="s"  type="text" placeholder="'.esc_attr( $settings['search_placeholder_text'] ).'">';
											echo '<button type="submit"><i class="far fa-search"></i></button>';
										echo '</form>';
									echo '</div>';
								}
								echo '<div class="col-auto d-none d-lg-block">';
									echo '<div class="info-card-wrap">';
										if(!empty($phone)){
											echo '<div class="info-card">';
												echo '<div class="box-icon">'.wp_kses_post( $settings['topbar_phone_icon'] ).'</div>';
												echo '<div class="box-content">';
													echo '<p class="box-text">'.esc_html( $settings['topbar_phone_label'] ).'</p>';
													echo '<h4 class="box-title"><a href="'.esc_attr('tel:' . $phoneurl).'">'.esc_html($phone).'</a></h4>';
												echo '</div>';
											echo '</div>';
										}
										if(!empty($settings['topbar_office'])){
											echo '<div class="info-card">';
												echo '<div class="box-icon">'.wp_kses_post( $settings['topbar_office_icon'] ).'</div>';
												echo '<div class="box-content">';
													echo '<p class="box-text">'.esc_html( $settings['topbar_office_label'] ).'</p>';
													echo '<h4 class="box-title">'.esc_html($settings['topbar_office']).'</h4>';
												echo '</div>';
											echo '</div>';
										}
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
				echo '<div class="sticky-wrapper'.esc_attr($sticky).'">';
					echo '<div class="menu-area">';
						echo '<div class="container">';
							echo '<div class="row align-items-center justify-content-between">';
								echo '<div class="col-auto d-none d-lg-inline-block">';
									echo '<nav class="main-menu menu-style1 '.esc_attr($menu_icon).'">';
										if( ! empty( $settings['mediax_menu_select'] ) ){
											wp_nav_menu( $args );
										}
									echo '</nav>';
								echo '</div>';
								if(!empty($settings['logo_image']['url'])){
									echo '<div class="col-auto d-inline-block d-lg-none">';
										echo '<div class="header-logo">';
											echo '<a href="'.esc_url( home_url( '/' ) ).'">';
												echo mediax_img_tag( array(
													'url'   => esc_url( $settings['logo_image2']['url']  ),
												));
											echo '</a>';
										echo '</div>';
									echo '</div>';
								}
								echo '<div class="col-auto ms-auto">';
									echo '<div class="header-button">';
										if(!empty( $settings['show_lang_btn'])){
											echo '<div class="dropdown-link d-none d-lg-inline-block">';
												echo '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-light fa-globe"></i> '.esc_html__('Language', 'mediax').'</a>';
												echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">';
													echo '<li>';
														echo do_shortcode('[gtranslate]');
													echo '</li>';
												echo '</ul>';
											echo '</div>';
										}
										if(!empty( $settings['show_cart_btn'])){
											echo '<button type="button" class="icon-btn sideMenuCart">';
												echo '<span class="badge cart_badge">'.esc_html($cart_count).'</span>';
												echo '<i class="fal fa-cart-shopping"></i>';
											echo '</button>';
										}
										if(!empty( $settings['show_whishlist_btn'])){
											if( class_exists( 'TInvWL_Admin_TInvWL' ) ){
												echo do_shortcode('[ti_wishlist_products_counter]');
											}
										}
										if(!empty( $settings['show_offcanvas_btn'])){
											echo '<button type="button" class="icon-btn sideMenuInfo d-none d-lg-inline-block"><i class="fal fa-bars"></i></button>';
										}
										echo ' <button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			$email = $settings['2_topbar_email'] ? $settings['2_topbar_email'] : '';   
			$phone = $settings['2_topbar_phone'] ? $settings['2_topbar_phone'] : '';     
	
			$email = is_email( $email );
	
			$replace        = array(' ','-',' - ');
			$replace_phone  = array(' ','-',' - ', '(', ')');
			$with           = array('','','');
	
			$emailurl       = str_replace( $replace, $with, $email );
			$phoneurl       = str_replace( $replace_phone, $with, $phone );	

			echo '<div class="th-header header-layout3">';
				if(!empty($settings['2_show_top_bar'])){
					echo '<div class="header-top">';
						echo '<div class="container-fluid">';
							echo '<div class="row justify-content-center justify-content-lg-between align-items-center gy-2">';
								echo '<div class="col-auto d-none d-lg-block">';
									echo '<div class="header-links">';
										echo '<ul>';
											if(!empty($phone )){
												echo '<li class="d-none d-sm-inline-block"><span class="icon-btn">'.wp_kses_post( $settings['2_topbar_phone_icon'] ).'</span><b>'.esc_html( $settings['2_topbar_phone_label'] ).' </b><a href="'.esc_attr( 'tel:'.$phoneurl ).'">'.esc_html($phone).'</a></li>';
											}
											if(!empty($email )){
												echo '<li class="d-none d-xxl-inline-block"><span class="icon-btn">'.wp_kses_post( $settings['2_topbar_email_icon'] ).'</span><b>'.esc_html( $settings['2_topbar_email_label'] ).' </b><a href="'.esc_attr( 'mailto:'.$email ).'">'.esc_html($email).'</a></li>';
											}
										echo '</ul>';
									echo '</div>';
								echo '</div>';
								echo '<div class="col-auto">';
									echo '<div class="header-links">';
										echo '<ul>';
											if(!empty( $settings['2_show_lang_btn'])){
												echo '<li class="d-none d-md-inline-block">';
													echo '<div class="dropdown-link">';
														echo '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-light fa-globe"></i> '.esc_html__('Language', 'mediax').'</a>';
														echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">';
															echo '<li>';
																echo do_shortcode('[gtranslate]');
															echo '</li>';
														echo '</ul>';
													echo '</div>';
												echo '</li>';
											}
											if( ! empty( $settings['2_social_icon_list'] ) ){
												echo '<li>';
													echo '<div class="social-links">';
														if(!empty($settings['2_social_text'])){
															echo '<span class="social-title">'.esc_html($settings['2_social_text']).'</span>';
														}
														foreach( $settings['2_social_icon_list'] as $social_icon ){
															$social_target    = $social_icon['icon_link']['is_external'] ? ' target="_blank"' : '';
															$social_nofollow  = $social_icon['icon_link']['nofollow'] ? ' rel="nofollow"' : '';

															echo '<a '.wp_kses_post( $social_target.$social_nofollow ).' href="'.esc_url( $social_icon['icon_link']['url'] ).'">';

															\Elementor\Icons_Manager::render_icon( $social_icon['social_icon'], [ 'aria-hidden' => 'true' ] );

															echo '</a> ';
														} 
													echo '</div>';
												echo '</li>';
											}
										echo '</ul>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}

				echo '<div class="sticky-wrapper'.esc_attr($sticky).'">';
					echo '<!-- Main Menu Area -->';
					echo '<div class="menu-area">';
						echo '<div class="container-fluid">';
							echo '<div class="row align-items-center justify-content-between">';
								if(!empty($settings['2_logo_image']['url'])){
									echo '<div class="col-auto">';
										echo '<div class="header-logo">';
											echo '<div class="logo-bg"></div>';
											echo '<a href="'.esc_url( home_url( '/' ) ).'">';
												echo mediax_img_tag( array(
													'url'   => esc_url( $settings['2_logo_image']['url']  ),
												));
											echo '</a>';
										echo '</div>';
									echo '</div>';
								}
								echo '<div class="col-auto me-xl-auto d-none d-lg-inline-block">';
									echo '<nav class="main-menu d-none d-lg-inline-block '.esc_attr($menu_icon).'">';
										if( ! empty( $settings['2_mediax_menu_select'] ) ){
											wp_nav_menu( $args2 );
										}
									echo '</nav>';
								echo '</div>';
								echo '<div class="col-auto">';
									echo '<div class="header-button">';
										if( $settings['2_show_search_btn'] == 'yes' ){
											echo '<button type="button" class="icon-btn searchBoxToggler d-none d-xl-inline-block"><i class="far fa-search"></i></button>';
										}
										if(!empty( $settings['2_show_cart_btn'])){
											echo '<button type="button" class="icon-btn sideMenuCart">';
												echo '<span class="badge cart_badge">'.esc_html($cart_count).'</span>';
												echo '<i class="fal fa-cart-shopping"></i>';
											echo '</button>';
										}
										if(!empty($settings['2_button_text'])){
											echo '<a href="'.esc_url( $settings['2_button_url']['url'] ).'" class="th-btn style4 th_btn">'.esc_html($settings['2_button_text']).'</a>'; 
										}
										if(!empty( $settings['2_show_offcanvas_btn'])){
											echo ' <button type="button" class="icon-btn sideMenuInfo d-none d-xl-inline-block"><i class="far fa-bars"></i></button>';
										}
										echo '<button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			$email = $settings['2_topbar_email'] ? $settings['2_topbar_email'] : '';   
			$phone = $settings['2_topbar_phone'] ? $settings['2_topbar_phone'] : '';     
	
			$email = is_email( $email );
	
			$replace        = array(' ','-',' - ');
			$replace_phone  = array(' ','-',' - ', '(', ')');
			$with           = array('','','');
	
			$emailurl       = str_replace( $replace, $with, $email );
			$phoneurl       = str_replace( $replace_phone, $with, $phone );	
			echo '<header class="th-header header-layout1 header-layout6">';
				if(!empty($settings['2_show_top_bar'])){
			        echo '<div class="header-top">';
			            echo '<div class="container">';
			                echo '<div class="row justify-content-center justify-content-lg-between align-items-center gy-2">';
			                    echo '<div class="col-auto d-none d-lg-block">';
			                        echo '<div class="header-links">';
			                            echo '<ul>';
			                                if(!empty($phone )){
												echo '<li class="d-none d-sm-inline-block"><span class="icon-btn">'.wp_kses_post( $settings['2_topbar_phone_icon'] ).'</span><b>'.esc_html( $settings['2_topbar_phone_label'] ).' </b><a href="'.esc_attr( 'tel:'.$phoneurl ).'">'.esc_html($phone).'</a></li>';
											}
											if(!empty($email )){
												echo '<li class="d-none d-xxl-inline-block"><span class="icon-btn">'.wp_kses_post( $settings['2_topbar_email_icon'] ).'</span><b>'.esc_html( $settings['2_topbar_email_label'] ).' </b><a href="'.esc_attr( 'mailto:'.$email ).'">'.esc_html($email).'</a></li>';
											}
			                            echo '</ul>';
			                        echo '</div>';
			                    echo '</div>';
			                    echo '<div class="col-auto">';
			                        echo '<div class="header-links">';
			                            echo '<ul>';
			                               if(!empty( $settings['2_show_lang_btn'])){
												echo '<li class="d-none d-md-inline-block">';
													echo '<div class="dropdown-link">';
														echo '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-light fa-globe"></i> '.esc_html__('Language', 'mediax').'</a>';
														echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">';
															echo '<li>';
																echo do_shortcode('[gtranslate]');
															echo '</li>';
														echo '</ul>';
													echo '</div>';
												echo '</li>';
											}
			                                echo '<li>';
			                                    echo '<div class="social-links">';
													if(!empty($settings['2_social_text'])){
														echo '<span class="social-title">'.esc_html($settings['2_social_text']).'</span>';
													}
													foreach( $settings['2_social_icon_list'] as $social_icon ){
														$social_target    = $social_icon['icon_link']['is_external'] ? ' target="_blank"' : '';
														$social_nofollow  = $social_icon['icon_link']['nofollow'] ? ' rel="nofollow"' : '';

														echo '<a '.wp_kses_post( $social_target.$social_nofollow ).' href="'.esc_url( $social_icon['icon_link']['url'] ).'">';

														\Elementor\Icons_Manager::render_icon( $social_icon['social_icon'], [ 'aria-hidden' => 'true' ] );

														echo '</a> ';
													} 
												echo '</div>';
			                                echo '</li>';
			                            echo '</ul>';
			                        echo '</div>';
			                    echo '</div>';
			                echo '</div>';
			            echo '</div>';
			        echo '</div>';
			    }
		        echo '<div class="sticky-wrapper'.esc_attr($sticky).'">';
		            echo '<!-- Main Menu Area -->';
		            echo '<div class="menu-area">';
		                echo '<div class="container">';
		                    echo '<div class="row align-items-center justify-content-between">';
		                        echo '<div class="col-auto">';
		                            if(!empty($settings['2_logo_image']['url'])){
										echo '<div class="header-logo">';
											echo '<a href="'.esc_url( home_url( '/' ) ).'">';
												echo mediax_img_tag( array(
													'url'   => esc_url( $settings['2_logo_image']['url']  ),
												));
											echo '</a>';
										echo '</div>';
									}
		                        echo '</div>';
		                        echo '<div class="col-auto d-none d-lg-inline-block">';
		                            echo '<nav class="main-menu d-none d-lg-inline-block '.esc_attr($menu_icon).'">';
		                                if( ! empty( $settings['2_mediax_menu_select'] ) ){
											wp_nav_menu( $args2 );
										}
		                            echo '</nav>';
		                        echo '</div>';
		                        echo '<div class="col-auto">';
		                            echo '<div class="header-button">';
		                            	if(!empty( $settings['2_show_offcanvas_btn'])){
			                                echo '<button type="button" class="icon-btn sideMenuInfo d-none d-xl-inline-block"><i class="far fa-bars"></i></button>';
			                            }
		                                if(!empty( $settings['2_show_cart_btn'])){
											echo '<button type="button" class="icon-btn sideMenuCart">';
												echo '<span class="badge cart_badge">'.esc_html($cart_count).'</span>';
												echo '<i class="fal fa-cart-shopping"></i>';
											echo '</button>';
										}
										if(!empty($settings['2_button_text'])){
											echo '<a href="'.esc_url( $settings['2_button_url']['url'] ).'" class="th-btn shadow-1">'.esc_html($settings['2_button_text']).'</a>'; 
										}
										echo '<button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>';
		                            echo '</div>';
		                        echo '</div>';
		                    echo '</div>';
		                echo '</div>';
		            echo '</div>';
		        echo '</div>';
		    echo '</header>';
			
		}elseif( $settings['layout_style'] == '4' ){
			echo '<header class="th-header header-layout1 header-layout5">';
				echo '<div class="sticky-wrapper'.esc_attr($sticky).'">';
		            echo '<!-- Main Menu Area -->';
		            echo '<div class="menu-area">';
		                echo '<div class="container">';
		                    echo '<div class="row align-items-center justify-content-between">';
		                        echo '<div class="col-auto">';
		                             if(!empty($settings['3_logo_image']['url'])){
											echo '<div class="header-logo">';
												echo '<a href="'.esc_url( home_url( '/' ) ).'">';
													echo mediax_img_tag( array(
														'url'   => esc_url( $settings['3_logo_image']['url']  ),
													));
												echo '</a>';
											echo '</div>';
										}
		                        echo '</div>';
		                        echo '<div class="col-auto d-none d-lg-inline-block">';
		                            echo '<nav class="main-menu d-none d-lg-inline-block '.esc_attr($menu_icon).'">';
		                                if( ! empty( $settings['3_mediax_menu_select'] ) ){
											wp_nav_menu( $args3 );
										}
		                            echo '</nav>';
		                        echo '</div>';
		                        echo '<div class="col-auto">';
		                            echo '<div class="header-button">';

		                            	if( $settings['3_show_search_btn'] == 'yes' ){
			                                echo '<button type="button" class="icon-btn searchBoxToggler d-none d-xl-inline-block"><i class="far fa-search"></i></button>';
			                            }
		                                if(!empty( $settings['3_show_cart_btn'])){
											echo '<button type="button" class="icon-btn sideMenuCart">';
												echo '<span class="badge cart_badge">'.esc_html($cart_count).'</span>';
												echo '<i class="fal fa-cart-shopping"></i>';
											echo '</button>';
										}
										if(!empty( $settings['2_show_offcanvas_btn'])){
			                                echo '<button type="button" class="icon-btn sideMenuInfo d-none d-xl-inline-block"><i class="far fa-bars"></i></button>';
			                            }
		                                if(!empty($settings['3_button_text'])){
											echo '<a href="'.esc_url( $settings['3_button_url']['url'] ).'" class="th-btn">'.esc_html($settings['3_button_text']).'</a>'; 
										}
		                                echo '<button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>';
		                            echo '</div>';
		                        echo '</div>';
		                    echo '</div>';
		                echo '</div>';
		            echo '</div>';
		        echo '</div>';
		    echo '</header>';

		}elseif( $settings['layout_style'] == '5' ){
			$email = $settings['2_topbar_email'] ? $settings['2_topbar_email'] : '';   
			$phone = $settings['2_topbar_phone'] ? $settings['2_topbar_phone'] : '';     
	
			$email = is_email( $email );
	
			$replace        = array(' ','-',' - ');
			$replace_phone  = array(' ','-',' - ', '(', ')');
			$with           = array('','','');
	
			$emailurl       = str_replace( $replace, $with, $email );
			$phoneurl       = str_replace( $replace_phone, $with, $phone );	
			echo '<header class="th-header header-layout7">';
		        echo '<div class="menu-top">';
		            echo '<div class="container">';
		                echo '<div class="row justify-content-center justify-content-lg-between align-items-center gy-2">';
		                    echo '<div class="col-auto d-none d-lg-block">';
		                        echo '<div class="header-logo">';
		                            echo '<a href="'.esc_url( home_url( '/' ) ).'">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $settings['2_logo_image']['url']  ),
										));
									echo '</a>';
		                        echo '</div>';
		                    echo '</div>';
		                    echo '<div class="col-auto d-none d-lg-block ms-auto me-4 pe-2">';
		                        echo '<div class="header-links">';
		                            echo '<ul>';
		                            	if(!empty($phone )){
											echo '<li class="d-none d-sm-inline-block"><span class="icon-btn me-2">'.wp_kses_post( $settings['2_topbar_phone_icon'] ).'</span><b>'.esc_html( $settings['2_topbar_phone_label'] ).' </b><a href="'.esc_attr( 'tel:'.$phoneurl ).'">'.esc_html($phone).'</a></li>';
										}
										if(!empty($email )){
											echo '<li class="d-none d-xxl-inline-block"><span class="icon-btn me-2">'.wp_kses_post( $settings['2_topbar_email_icon'] ).'</span><b>'.esc_html( $settings['2_topbar_email_label'] ).' </b><a href="'.esc_attr( 'mailto:'.$email ).'">'.esc_html($email).'</a></li>';
										}
		                            echo '</ul>';
		                        echo '</div>';
		                    echo '</div>';
		                    if(!empty($settings['2_button_text'])){
			                    echo '<div class="col-auto d-none d-lg-block">';
			                        echo '<a href="'.esc_url( $settings['2_button_url']['url'] ).'" class="th-btn">'.esc_html($settings['2_button_text']).'</a>';
			                    echo '</div>';
			                }
		                echo '</div>';
		            echo '</div>';
		        echo '</div>';
		        echo '<div class="sticky-wrapper'.esc_attr($sticky).'">';
		            echo '<div class="container">';
		                echo '<div class="menu-area">';
		                    echo '<div class="row align-items-center justify-content-between">';
		                        echo '<div class="col-auto d-none d-lg-inline-block">';
		                            echo '<nav class="main-menu menu-style1 '.esc_attr($menu_icon).'">';
		                                if( ! empty( $settings['2_mediax_menu_select'] ) ){
											wp_nav_menu( $args2 );
										}
		                                
		                            echo '</nav>';
		                        echo '</div>';
		                        echo '<div class="col-auto d-inline-block d-lg-none">';
		                            echo '<div class="header-logo">';
		                                echo '<a href="'.esc_url( home_url( '/' ) ).'">';
											echo mediax_img_tag( array(
												'url'   => esc_url( $settings['3_logo_image']['url']  ),
											));
										echo '</a>';
		                            echo '</div>';
		                        echo '</div>';
		                        echo '<div class="col-auto ms-auto">';
		                            echo '<div class="header-button">';
		                                if(!empty( $settings['2_show_cart_btn'])){
											echo '<button type="button" class="icon-btn sideMenuCart">';
												echo '<span class="badge cart_badge">'.esc_html($cart_count).'</span>';
												echo '<i class="fal fa-cart-shopping"></i>';
											echo '</button>';
										}
		                                if(!empty( $settings['2_show_whishlist_btn'])){
											if( class_exists( 'TInvWL_Admin_TInvWL' ) ){
												echo do_shortcode('[ti_wishlist_products_counter]');
											}
										}
										if(!empty( $settings['2_show_offcanvas_btn'])){
			                                echo '<button type="button" class="icon-btn sideMenuInfo d-none d-lg-inline-block"><i class="fal fa-bars"></i></button>';
			                            }
		                                echo '<button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>';
		                            echo '</div>';
		                        echo '</div>';
		                    echo '</div>';
		                echo '</div>';
		            echo '</div>';
		        echo '</div>';
		    echo '</header>';

		}else{
			echo '<header class="th-header header-layout1">';
				echo '<div class="sticky-wrapper'.esc_attr($sticky).'">';
					echo '<div class="menu-area">';
						echo '<div class="container">';
							echo '<div class="row align-items-center justify-content-between">';
								echo '<div class="col-auto">';
									echo '<div class="header-logo">';
										if(!empty($settings['3_logo_image']['url'])){
											echo '<div class="logo-bg" data-bg-src="'.esc_url( $settings['3_logo_bg']['url']  ).'"></div>';
											echo '<a href="'.esc_url( home_url( '/' ) ).'">';
												echo mediax_img_tag( array(
													'url'   => esc_url( $settings['3_logo_image']['url']  ),
												));
											echo '</a>';
										}
									echo '</div>';
								echo '</div>';
								echo '<div class="col-auto d-none d-lg-inline-block">';
									echo '<nav class="main-menu d-none d-lg-inline-block '.esc_attr($menu_icon).'">';
										if( ! empty( $settings['3_mediax_menu_select'] ) ){
											wp_nav_menu( $args3 );
										}
									echo '</nav>';
								echo '</div>';
								echo '<div class="col-auto">';
									echo '<div class="header-button">';
										if( $settings['3_show_search_btn'] == 'yes' ){
											echo '<button type="button" class="icon-btn searchBoxToggler d-none d-xl-inline-block"><i class="far fa-search"></i></button>';
										}
										if( $settings['3_show_search_btn'] == 'yes' ){
											echo '<button type="button" class="icon-btn sideMenuCart">
											<span class="badge">'.esc_html($cart_count).'</span>
											<i class="far fa-cart-shopping"></i>
											</button>';
										}
										if(!empty($settings['3_button_text'])){
											echo '<a href="'.esc_url( $settings['3_button_url']['url'] ).'" class="th-btn style7">'.esc_html($settings['3_button_text']).'</a>'; 
										}
										if(!empty( $settings['3_show_offcanvas_btn'])){
											echo '<button type="button" class="icon-btn sideMenuInfo d-none d-xl-inline-block"><i class="far fa-bars"></i></button>';
											echo '<button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>';
										}
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
				echo '</div>';
				echo '</div>';
			echo '</header>';

		}


	}
}