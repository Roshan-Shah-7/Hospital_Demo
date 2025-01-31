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
 * Contact Form Widget .
 *
 */
class mediax_Contact_Form extends Widget_Base {

	public function get_name() {
		return 'mediaxcontactform';
	}
	public function get_title() {
		return __( 'Contact Form', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
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
			'contact_form_section',
			[
				'label' 	=> __( 'Contact Form', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five' ] );

		mediax_general_fields( $this, 'subtitle', 'Subtitle', 'TEXTAREA2', 'Subtitle', ['3'] );
		mediax_general_fields( $this, 'sec_title', 'Title', 'TEXTAREA2', 'Title', ['3'] );
		mediax_general_fields( $this, 'sec_title2', 'Title 2', 'TEXTAREA2', 'Subtitle', ['3'] );
		mediax_general_fields( $this, 'sec_desc', 'Description', 'TEXTAREA', 'Description', ['3'] );

		mediax_general_fields( $this, 'form_title', 'Form Title', 'TEXTAREA2', 'Book An Appointment' );
		mediax_media_fields( $this, 'image1', 'Choose Image', [ '2', '4' ] );
		mediax_media_fields( $this, 'image2', 'Choose Image', [ '2' ] );

		$this->add_control(
            'mediax_select_contact_form',
            [
                'label'   => esc_html__( 'Select Form', 'mediax' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->get_as_contact_form(),
            ]
        );

		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Working Hour', [ '2' ] );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', '', [ '2' ]  );
		// Layout Style 2
		$fields_to_include = [ 'title' => ['Title'], 'desc' => ['Content'] ];
		mediax_repeater_fields( $this, 'working_lists', 'Working Lists', $fields_to_include, [ '2' ] );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------General Style-------
		$this->start_controls_section(
			'general_styling',
			[
				'label'     => __( 'Form General', 'mediax' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition'		=> [ 
					'layout_style' => ['2', '3', '4']
				],
			]
		);

		mediax_color_fields( $this, 'bg', 'Background', 'background', '{{WRAPPER}} .bg' );  
		mediax_dimensions_fields( $this, 'padding', 'Padding', 'padding', '{{WRAPPER}} .bg' ); 

		$this->end_controls_section();

		$this->start_controls_section(
			'general_styling2',
			[
				'label'     => __( 'Schedule General', 'mediax' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition'		=> [ 
					'layout_style' => ['2']
				],
			]
		);

		mediax_color_fields( $this, 'bg2', 'Schedule Background', 'background', '{{WRAPPER}} .bg2:after', ['2'] );  
		mediax_dimensions_fields( $this, 'padding2', 'Schedule Padding', 'padding', '{{WRAPPER}} .bg2', ['2'] ); 

		$this->end_controls_section();

		
		mediax_common_style_fields( $this, 'secsubtitle', 'Section Subtitle', '{{WRAPPER}} .sub-title2', ['3']);
		mediax_common_style_fields( $this, 'sectitle', 'Section Title', '{{WRAPPER}} .sec-title', ['3']);
		mediax_common_style_fields( $this, 'sectitle2', 'Section Title 2', '{{WRAPPER}} .sec-heading', ['3']);
		mediax_common_style_fields( $this, 'secdesc', 'Section Description', '{{WRAPPER}} .sec-text', ['3']);

		//-------Form Title Style-------
		mediax_common_style_fields( $this, 'form_title', 'Form Title', '{{WRAPPER}} .title' );
		//------Button Style-------
		mediax_button_style_fields( $this, '10', 'Button Styling', '{{WRAPPER}} .th-btn' );

		mediax_common_style_fields( $this, 'title', 'Schedule Title', '{{WRAPPER}} .box-title', ['2']);
		mediax_common_style_fields( $this, 'desc', 'Schedule Description', '{{WRAPPER}} .box-text', ['2']);
		mediax_common_style_fields( $this, 'desc2', 'Schedule Lists', '{{WRAPPER}} .box-timing', ['2']);
		

	}

	protected function render() {

	    $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="faq-form">';
				if(!empty($settings['form_title'])){
					echo '<h3 class="sec-title mb-30 text-center title">'.esc_html($settings['form_title']).'</h3>';
				}
				if( !empty($settings['mediax_select_contact_form']) ){
					echo do_shortcode( '[contact-form-7  id="'.$settings['mediax_select_contact_form'].'"]' ); 
				}else{
					echo '<div class="alert alert-warning"><p class="m-0">' . __('Please Select contact form.', 'mediax' ). '</p></div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="appointment-row">';
                echo '<div class="schedule-box bg2">';
                    echo '<div class="shape"></div>';
					if(!empty($settings['title'])){
						echo '<h3 class="box-title">'.esc_html($settings['title']).'</h3>';
					}
					if(!empty($settings['desc'])){
						echo '<p class="box-text">'.esc_html($settings['desc']).'</p>';
					}
					foreach( $settings['working_lists'] as $data ){
						echo '<p class="box-timing">'.esc_html($data['title']).'<span>'.esc_html($data['content']).'</span></p>';
					}
                echo '</div>';
                echo '<div class="form-wrap bg">';
                    echo '<div class="img-box4">';
						if(!empty($settings['image1']['url'])){
							echo '<div class="img1">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $settings['image1']['url'] ),
								));
							echo '</div>';
						}
						if(!empty($settings['image2']['url'])){
							echo '<div class="img2">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $settings['image2']['url'] ),
								));
							echo '</div>';
						}
                    echo '</div>';
                    echo '<div class="appointment-form">';
						if(!empty($settings['form_title'])){
							echo '<h4 class="form-title title">'.esc_html($settings['form_title']).'</h4>';
						}
						if( !empty($settings['mediax_select_contact_form']) ){
							echo do_shortcode( '[contact-form-7  id="'.$settings['mediax_select_contact_form'].'"]' ); 
						}else{
							echo '<div class="alert alert-warning"><p class="m-0">' . __('Please Select contact form.', 'mediax' ). '</p></div>';
						}
                    echo '</div>';
                echo '</div>';
            echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="row justify-content-center text-center">';
				echo '<div class="col-xl-9">';
					echo '<div class="title-area">';
						if(!empty($settings['subtitle'])){
							echo '<span class="sub-title2">'.wp_kses_post($settings['subtitle']).'</span>';
						}
						if(!empty($settings['sec_title'])){
							echo '<h2 class="sec-title mb-0">'.wp_kses_post($settings['sec_title']).'</h2>';
						}
						if(!empty($settings['sec_title2'])){
							echo '<h3 class="sec-heading">'.wp_kses_post($settings['sec_title2']).'</h3>';
						}
						if(!empty($settings['sec_desc'])){
							echo '<p class="sec-text">'.wp_kses_post($settings['sec_desc']).'</p>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="appointment-form2 bg">';
				if(!empty($settings['form_title'])){
					echo '<h4 class="form-title title">'.esc_html($settings['form_title']).'</h4>';
				}
				if( !empty($settings['mediax_select_contact_form']) ){
					echo do_shortcode( '[contact-form-7  id="'.$settings['mediax_select_contact_form'].'"]' ); 
				}else{
					echo '<div class="alert alert-warning"><p class="m-0">' . __('Please Select contact form.', 'mediax' ). '</p></div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '4' ){
			echo '<div class="contact-form ajax-contact bg" data-bg-src="'.esc_url( $settings['image1']['url'] ).'">';
				echo '<div class="input-wrap">';
					if(!empty($settings['form_title'])){
						echo '<h2 class="sec-title title">'.esc_html($settings['form_title']).'</h2>';
					}
					if( !empty($settings['mediax_select_contact_form']) ){
						echo do_shortcode( '[contact-form-7  id="'.$settings['mediax_select_contact_form'].'"]' ); 
					}else{
						echo '<div class="alert alert-warning"><p class="m-0">' . __('Please Select contact form.', 'mediax' ). '</p></div>';
					}
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '5' ){
			echo '<div class="team-contact-form">';
				if(!empty($settings['form_title'])){
					echo '<h4 class="form-title title">'.esc_html($settings['form_title']).'</h4>';
				}
				if( !empty($settings['mediax_select_contact_form']) ){
					echo do_shortcode( '[contact-form-7  id="'.$settings['mediax_select_contact_form'].'"]' ); 
				}else{
					echo '<div class="alert alert-warning"><p class="m-0">' . __('Please Select contact form.', 'mediax' ). '</p></div>';
				}
			echo '</div>';
		}


	}

}