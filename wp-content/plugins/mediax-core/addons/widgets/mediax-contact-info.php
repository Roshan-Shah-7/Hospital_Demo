
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
 * Contact Info Widget .
 *
 */
class Mediax_Contact_Info extends Widget_Base {

	public function get_name() {
		return 'mediaxcontactinfo';
	}
	public function get_title() {
		return __( 'Contact Info', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() { 

		$this->start_controls_section(
			'title_section',
			[
				'label' 	=> __( 'Contact Info', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five', 'Style Six' ] );

		mediax_media_fields( $this, 'logo', 'Choose Logo', ['2'] );  

		mediax_general_fields($this, 'title', 'Title', 'TEXT', 'Contact Us', ['1', '3','6'] );
		mediax_general_fields($this, 'desc', 'Description', 'TEXTAREA2', '', ['1', '2','6']);

		mediax_general_fields( $this, 'address_icon', 'Address Icon', 'TEXT', '<i class="fas fa-map-marker-alt"></i>', ['1', '2', '3'] );
		mediax_general_fields( $this, 'address', 'Address Name', 'TEXTAREA', 'anta Rosa CA 95404, United States', ['1', '2', '3'] );

		mediax_general_fields( $this, 'phone_icon', 'Phone Icon', 'TEXT', '<i class="fa-solid fa-phone"></i>', ['1', '2', '3'] );
		mediax_general_fields( $this, 'phone', 'Phone Number', 'TEXT', '+(163)-2654-3654', ['1', '2', '3'] );

		mediax_general_fields( $this, 'email_icon', 'Email Icon', 'TEXT', '<i class="fas fa-envelope"></i>', ['1', '2'] );
		mediax_general_fields( $this, 'email', 'Email Address', 'TEXT', 'help24/7@Mediax.com', ['1', '2'] );

		mediax_general_fields( $this, 'heading', 'Heading', 'HEADING', '2nd Branches', ['3'] );
		mediax_general_fields( $this, 'title2', 'Title', 'TEXT', 'Contact Us', ['3'] );
		mediax_general_fields( $this, 'address2', 'Address Name', 'TEXTAREA', 'anta Rosa CA 95404, United States', ['3'] );
		mediax_general_fields( $this, 'phone2', 'Phone Number', 'TEXT', '+(163)-2654-3654', ['3'] );

		//Social List
		mediax_social_fields($this, 'social_icon_list', 'Social List', ['1']); 

		// Layout Style 4
		$fields_to_include = [ 'title' => [ 'Title', 'Address Icon', 'Address', 'Email Icon', 'Email', 'Phone Icon', 'Phone', 'Office Icon', 'Office Label', 'Office Time', 'Office Time2' ] ];
		mediax_repeater_fields( $this, 'contact_lists', 'Contact Info List', $fields_to_include, [ '4' ] );

		// Layout Style 5
		$fields_to_include = [ 'title' => [ 'Title', 'Icon', 'Subtitle'] ];
		mediax_repeater_fields( $this, 'contact_list_2', 'Contact Info List', $fields_to_include, [ '5','6' ] );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title,{{WRAPPER}} .box-title a,{{WRAPPER}} .sec-title ', ['1', '3', '4','5','6'] );
		mediax_common_style_fields( $this, 'subtitle', 'SubTitle', '{{WRAPPER}} .box-text,{{WRAPPER}} .text-theme', ['5','6'] );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .footer-text', ['1'] );
		mediax_common_style_fields( $this, 'label', 'Label', '{{WRAPPER}} .desc', ['2'] );

		
	}

	protected function render() {

        $settings = $this->get_settings_for_display();

			
		if( $settings['layout_style'] == '1' ){
			$email = $settings['email'] ? $settings['email'] : '';
			$phone = $settings['phone'] ? $settings['phone'] : '';
             
			$email      = is_email( $email );
	
			$replace        = array(' ','-',' - ');
			$replace_phone        = array(' ','-',' - ', '(', ')');
			$with           = array('','','');
	
			$emailurl       = str_replace( $replace, $with, $email );
			$phoneurl       = str_replace( $replace_phone, $with, $phone );		

			echo '<div class="widget footer-widget">';
				if($settings['title']){
					echo '<h3 class="widget_title title">'.wp_kses_post($settings['title']).'</h3>';
				}
				echo '<div class="th-widget-contact">';
					if(!empty( $settings['desc'] )){
						echo '<p class="footer-text">'.wp_kses_post($settings['desc']).'</p>';
					}
					if(!empty( $settings['address'] )){
						echo '<p class="footer-info">';
							if(!empty( $settings['address_icon'] )){
								echo wp_kses_post($settings['address_icon']);
							}
							echo wp_kses_post($settings['address']);
						echo '</p>';
					}
					if(!empty( $email )){
						echo '<p class="footer-info">';
							if(!empty( $settings['email_icon'] )){
								echo wp_kses_post($settings['email_icon']);
							}
							echo '<a href="'.esc_attr('mailto:' . $emailurl).'" class="info-box_link">'.esc_html($email).'</a>';
						echo '</p>';
					}
					if(!empty( $phone )){
						echo '<p class="footer-info">';
							if(!empty( $settings['phone_icon'] )){
								echo wp_kses_post($settings['phone_icon']);
							}
							echo '<a href="'.esc_attr('tel:' . $phoneurl).'" class="info-box_link">'.esc_html($phone).'</a>';
						echo '</p>';
					}
					echo '<div class="th-social">';
						foreach( $settings['social_icon_list'] as $social_icon ){
							$social_target    = $social_icon['icon_link']['is_external'] ? ' target="_blank"' : '';
							$social_nofollow  = $social_icon['icon_link']['nofollow'] ? ' rel="nofollow"' : '';

							echo '<a '.wp_kses_post( $social_target.$social_nofollow ).' href="'.esc_url( $social_icon['icon_link']['url'] ).'">';

							\Elementor\Icons_Manager::render_icon( $social_icon['social_icon'], [ 'aria-hidden' => 'true' ] );

							echo '</a> ';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			$email = $settings['email'] ? $settings['email'] : '';
			$phone = $settings['phone'] ? $settings['phone'] : '';
             
			$email      = is_email( $email );
			$replace        = array(' ','-',' - ');
			$replace_phone        = array(' ','-',' - ', '(', ')');
			$with           = array('','','');
	
			$emailurl       = str_replace( $replace, $with, $email );
			$phoneurl       = str_replace( $replace_phone, $with, $phone );	
				
			echo '<div class="widget footer-widget">';
				echo '<div class="th-widget-about">';
						if(!empty($settings['logo']['url'])){
							echo '<div class="about-logo">';
								echo '<a href="'.esc_url( home_url('/') ).'">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $settings['logo']['url'] ),
									));
								echo '</a>';
							echo '</div>';
						}
						if(!empty( $settings['desc'] )){
							echo '<p class="footer-text desc">'.wp_kses_post($settings['desc']).'</p>';
						}
						if(!empty( $settings['address'] )){
							echo '<p class="footer-info">';
								if(!empty( $settings['address_icon'] )){
									echo wp_kses_post($settings['address_icon']);
								}
								echo wp_kses_post($settings['address']);
							echo '</p>';
						}
						if(!empty( $email )){
							echo '<p class="footer-info">';
								if(!empty( $settings['email_icon'] )){
									echo wp_kses_post($settings['email_icon']);
								}
								echo '<a href="'.esc_attr('mailto:' . $emailurl).'" class="info-box_link">'.esc_html($email).'</a>';
							echo '</p>';
						}
						if(!empty( $phone )){
							echo '<p class="footer-info">';
								if(!empty( $settings['phone_icon'] )){
									echo wp_kses_post($settings['phone_icon']);
								}
								echo '<a href="'.esc_attr('tel:' . $phoneurl).'" class="info-box_link">'.esc_html($phone).'</a>';
							echo '</p>';
						}
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			$phone = $settings['phone'] ? $settings['phone'] : '';
			$phone2 = $settings['phone2'] ? $settings['phone2'] : '';
             
			$replace_phone        = array(' ','-',' - ', '(', ')');
			$with           = array('','','');

			$phoneurl       = str_replace( $replace_phone, $with, $phone );	
			$phoneurl2       = str_replace( $replace_phone, $with, $phone2 );

			echo '<div class="widget footer-widget">';
				echo '<div class="th-widget-location">';
					echo '<div class="location-box">';
						if($settings['title']){
							echo '<h3 class="box-title title">'.wp_kses_post($settings['title']).'</h3>';
						}
						if(!empty( $settings['address'] )){
							echo '<p class="footer-info">';
								echo wp_kses_post($settings['address_icon']);
								echo wp_kses_post($settings['address']);
							echo '</p>';
						}
						if(!empty( $phone )){
							echo '<p class="footer-info">';
								echo wp_kses_post($settings['phone_icon']);
								echo '<a href="'.esc_attr('tel:' . $phoneurl).'" class="info-box_link">'.esc_html($phone).'</a>';
							echo '</p>';
						}
					echo '</div>';
					echo '<div class="location-box">';
						if($settings['title2']){
							echo '<h3 class="box-title title">'.wp_kses_post($settings['title2']).'</h3>';
						}
						if(!empty( $settings['address2'] )){
							echo '<p class="footer-info">';
								echo wp_kses_post($settings['address_icon']);
								echo wp_kses_post($settings['address2']);
							echo '</p>';
						}
						if(!empty( $phone2 )){
							echo '<p class="footer-info">';
								echo wp_kses_post($settings['phone_icon']);
								echo '<a href="'.esc_attr('tel:' . $phoneurl2).'" class="info-box_link">'.esc_html($phone2).'</a>';
							echo '</p>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '4' ){
			echo '<div class="row gy-4">';
				foreach( $settings['contact_lists'] as $key => $data ){
					$active = ($key == 1) ? 'active':'';
					$email = $data['email'] ? $data['email'] : '';
					$phone = $data['phone'] ? $data['phone'] : '';
					 
					$email      = is_email( $email );
					$replace        = array(' ','-',' - ');
					$replace_phone        = array(' ','-',' - ', '(', ')');
					$with           = array('','','');
			
					$emailurl       = str_replace( $replace, $with, $email );
					$phoneurl       = str_replace( $replace_phone, $with, $phone );	

					echo '<div class="col-xl-4 col-md-6">';
						echo '<div class="location-card '.esc_attr($active).'">';
							if(!empty($data['title'])){
								echo '<h3 class="box-title title">'.wp_kses_post($data['title']).'</h3>';
							}
							if(!empty( $data['address'] )){
								echo '<p class="footer-info">';
									echo wp_kses_post($data['address_icon']);
									echo wp_kses_post($data['address']);
								echo '</p>';
							}
							if(!empty( $email )){
								echo '<p class="footer-info">';
									if(!empty( $data['email_icon'] )){
										echo wp_kses_post($data['email_icon']);
									}
									echo '<a href="'.esc_attr('mailto:' . $emailurl).'" class="info-box_link">'.esc_html($email).'</a>';
								echo '</p>';
							}
							if(!empty( $phone )){
								echo '<p class="footer-info">';
									if(!empty( $data['phone_icon'] )){
										echo wp_kses_post($data['phone_icon']);
									}
									echo '<a href="'.esc_attr('tel:' . $phoneurl).'" class="info-box_link">'.esc_html($phone).'</a>';
								echo '</p>';
							}
						echo '</div>';
						echo '<div class="contact-feature">';
							if(!empty( $data['office_icon'] )){
								echo '<div  class="box-icon">'.wp_kses_post($data['office_icon']).'</div>';
							}
							echo '<div class="media-body">';
								if(!empty($data['office_label'])){
									echo '<h3 class="box-title">'.wp_kses_post($data['office_label']).'</h3>';
								}
								if(!empty($data['office_time'])){
									echo '<p class="box-text">'.wp_kses_post($data['office_time']).'</p>';
								}
								if(!empty($data['office_time2'])){
									echo '<p class="box-schedule">'.wp_kses_post($data['office_time2']).'</p>';
								}
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '5' ){

			echo '<div class="feature-contact-wrap mt-40">';

				foreach( $settings['contact_list_2'] as $key => $data ){
	                echo '<div class="contact-info">';
	                    if(!empty( $data['subtitle'] )){
							echo '<p class="box-text">';
								echo wp_kses_post($data['subtitle']);
							echo '</p>';
						}
	                    echo '<h3 class="box-title">';
	                    
	
							if(!empty($data['icon'])){
								echo '<i class="'.$data['icon'].'"></i>';
							}
	                        
							if(!empty($data['title'])){
								echo wp_kses_post($data['title']);
							}
	                    echo '</h3>';
	                echo '</div>';
                }

            echo '</div>';

		}else{
            if(!empty( $settings['title'] )){
				echo '<h2 class="sec-title mb-md-4 mb-2">'.wp_kses_post($settings['desc']).'</h2>';
			}

			if(!empty( $settings['desc'] )){
				echo '<h4 class="text-theme fw-semibold mb-30">'.wp_kses_post($settings['desc']).'</h4>';
			}

            foreach( $settings['contact_list_2'] as $key => $data ){
	            echo '<div class="cta-call">';
	                echo '<div class="box-icon">';
	                    echo '<i class="'.wp_kses_post($data['icon']).'"></i>';
	                echo '</div>';
	                echo '<div class="media-body">';
	                    echo '<p class="box-text">'.wp_kses_post($data['title']).'</p>';
                    	echo '<h3 class="box-title">'.wp_kses_post($data['subtitle']).'</h3>';
	                echo '</div>';
	            echo '</div>';
            }

		}
       

	}

}
