<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Background;
/**
 * 
 * Newsletter Widget .
 *
 */
class Mediax_Newsletter extends Widget_Base {

	public function get_name() {
		return 'mediaxnewsletter';
	}
	public function get_title() {
		return __( 'Newsletter', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}
	
	protected function register_controls() {

		$this->start_controls_section(
			'layout_section',
			[
				'label'     => __( 'Newsletter Style', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One','Style Two'] );

		mediax_general_fields( $this, 'title', 'Title', 'TEXT', 'Sign Up For Newsletter', ['1', '2'] );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA2', '', '1' );

		mediax_general_fields( $this, 'newsletter_placeholder', 'Placeholder', 'TEXT', 'Enter your Email' );
		mediax_general_fields( $this, 'newsletter_button', 'Subscribe Button', 'TEXT', '<i class="fa-solid fa-paper-plane"></i>' );
		mediax_general_fields( $this, 'checkbox_label', 'Checkbox Label', 'TEXT', 'I agree with the terms & conditions', '1' );

		mediax_general_fields( $this, 'di', 'DIVIDER', 'DIVIDER', '', '1' );
		mediax_media_fields( $this, 'image', 'Choose Image', ['1'] );
		mediax_url_fields( $this, 'button_url', 'Button URL', [ '1' ] );
		mediax_media_fields( $this, 'image2', 'Choose Image 2', ['1'] );
		mediax_url_fields( $this, 'button_url2', 'Button URL 2', [ '1' ] );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------
		//-------Title Style-------
		mediax_common_style_fields($this, 'title', 'Title', '{{WRAPPER}} .title', ['1', '3']);
		//-------Description Style-------
		mediax_common_style_fields($this, 'desc', 'Description', '{{WRAPPER}} .footer-text', ['1']);
		mediax_common_style_fields($this, 'desc2', 'Checkbox Label', '{{WRAPPER}} .info', ['1']);

	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="widget footer-widget">';
				if($settings['title']){
					echo '<h3 class="widget_title title">'.wp_kses_post($settings['title']).'</h3>';
				}
				echo '<div class="newsletter-widget">';
					if(!empty( $settings['desc'] )){
						echo '<p class="footer-text">'.wp_kses_post($settings['desc']).'</p>';
					}
					echo '<form action="#" class="newsletter-form">';
						echo '<input class="form-control" type="email" placeholder="'.esc_attr( $settings['newsletter_placeholder'] ).'">';
						echo '<button type="submit" class="simple-icon">'.wp_kses_post( $settings['newsletter_button'] ).'</button>';
					echo '</form>';
					if($settings['checkbox_label']){
						echo '<div class="form-group">';
							echo ' <input type="checkbox" id="checkbox" name="checkbox">';
							echo '<label for="checkbox">'.wp_kses_post($settings['checkbox_label']).'</label>';
						echo '</div>';
					}
					echo '<div class="btn-group">';
						if(!empty($settings['image']['url'])){
							echo '<div class="img-btn">';
								echo '<a href="'.esc_url( $settings['button_url']['url'] ).'">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $settings['image']['url'] ),
									));
								echo '</a>';
							echo '</div>';
						}
						if(!empty($settings['image2']['url'])){
							echo '<div class="img-btn">';
								echo '<a href="'.esc_url( $settings['button_url2']['url'] ).'">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $settings['image2']['url'] ),
									));
								echo '</a>';
							echo '</div>';
						}
					echo '</div>';
					
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			
			echo '<div class="newsletter-wrap">';
                echo '<div class="newsletter-content">';
                    echo '<h2 class="sec-title">'.wp_kses_post($settings['title']).'</h2>';
                echo '</div>';
                echo '<form class="newsletter-form">';
                    echo '<div class="form-group">';
                        echo '<input class="form-control" type="email" placeholder="'.wp_kses_post( $settings['newsletter_placeholder'] ).'">';
                    echo '</div>';
                    echo '<button type="submit" class="th-btn style7 shadow-1">'.wp_kses_post( $settings['newsletter_button'] ).'</button>';
                echo '</form>';
            echo '</div>';

		}
	

	}
}
						