<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
/**
 *
 * Image Widget .
 *
 */
class Mediax_Image extends Widget_Base {

	public function get_name() {
		return 'mediaximage';
	}
	public function get_title() {
		return __( 'Image', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'image_section',
			[
				'label' 	=> __( 'Image', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five', 'Style Six', 'Style Seven', 'Style Eight', 'Style Nine','Style Ten','Style Eleven' ] );

		mediax_media_fields( $this, 'image1', 'Choose Image' );
		mediax_general_fields( $this, 'class', 'Class', 'TEXTAREA', '', [ '8' ] );


		mediax_media_fields( $this, 'image2', 'Choose Image2',[ '4','5','6','7','9','10' ] );
		mediax_media_fields( $this, 'image3', 'Choose Image3',[ '4','10' ] );
		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Title', [ '1','10' ] );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', 'Description', [ '1','4','6','7','10' ] );
		mediax_general_fields( $this, 'icon', 'Phone Icon', 'TEXTAREA2', '', [ '1' ] );
		mediax_general_fields( $this, 'phone', 'Phone Number', 'TEXTAREA2', '', [ '1' ] );

		mediax_general_fields( $this, 'number', 'Number', 'TEXTAREA2', 'Number', ['10'] );
		mediax_general_fields( $this, 'operator', 'Operator', 'TEXTAREA2', 'Operator', ['10'] );


       $this->end_controls_section();

      	//---------------------------------------
			//Style Section Start
		//---------------------------------------


       	mediax_common_style_fields( $this, 'number', 'Number', '{{WRAPPER}} .box-number', [ '10'] );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'operator', 'Operator', '{{WRAPPER}} .box-title', [ '10'] );

	}

	protected function render() {

        $settings = $this->get_settings_for_display();
       
		if( $settings['layout_style'] == '1' ){
			$phone = $settings['phone'] ? $settings['phone'] : '';
			$replace_phone        = array(' ','-',' - ', '(', ')');
			$with           = array('','','');
			$phoneurl       = str_replace( $replace_phone, $with, $phone );	

			echo '<div class="img-box1">';
				if(!empty($settings['image1']['url'])){
					echo '<div class="img1">';
						echo mediax_img_tag( array(
							'url'   => esc_url( $settings['image1']['url'] ),
						));
					echo '</div>';
				}
				echo '<div class="about-info">';
					if(!empty($settings['title'])){
						echo '<h3 class="box-title">'.esc_html($settings['title']).'</h3>';
					}
					if(!empty($settings['desc'])){
						echo '<p class="box-text">'.wp_kses_post($settings['desc']).'</p>';
					}
					if(!empty($settings['star'])){
						echo '<div class="box-review">'.wp_kses_post($settings['star']).' </div>';
					}
					if(!empty($phone)){
						echo '<a href="'.esc_attr('tel:' . $phoneurl).'" class="box-link">'.wp_kses_post( $settings['icon'] . $phone).'</a>';
					}
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			if(!empty($settings['image1']['url'])){
				echo '<div class="img-box2">';
					echo mediax_img_tag( array(
						'url'   => esc_url( $settings['image1']['url'] ),
					));
				echo '</div>';
			}

		}elseif( $settings['layout_style'] == '3' ){
			if(!empty($settings['image1']['url'])){
				echo '<div class="ps-xxl-4">';
					echo '<div class="faq-img1">';
						echo mediax_img_tag( array(
							'url'   => esc_url( $settings['image1']['url'] ),
						));
					echo '</div>';
				echo '</div>';
			}

		}elseif( $settings['layout_style'] == '4' ){
			echo '<div class="img-box6">';
				if(!empty($settings['image1']['url'])){
	                echo '<div class="img1">';
	                    echo mediax_img_tag( array(
							'url'   => esc_url( $settings['image1']['url'] ),
						));
	                echo '</div>';
	            }
	            if(!empty($settings['image3']['url'])){
	                echo '<div class="img2" data-mask-src="'.esc_url( $settings['image2']['url'] ).'">';
	                    echo '<img data-mask-src="'.esc_url( $settings['image2']['url'] ).'" src="'.esc_url( $settings['image3']['url'] ).'" alt="About">';
	                echo '</div>';
	            }
                echo '<div class="project-counter">';
	                if(!empty( $settings['desc'] )){
	                	echo wp_kses_post( $settings['desc'] );
	                }  
                echo '</div>';
            echo '</div>';
		}elseif( $settings['layout_style'] == '5' ){
			echo '<div class="comparison-img-wrap">';
                echo '<div class="comparison-img">';
                	if(!empty($settings['image1']['url'])){
	                    echo '<div class="img background-img" data-bg-src="'.esc_url( $settings['image1']['url'] ).'"></div>';
	                }
	                if(!empty($settings['image2']['url'])){
	                    echo '<div class="img foreground-img" data-bg-src="'.esc_url( $settings['image2']['url'] ).'"></div>';
	                }
                    echo '<input type="range" min="1" max="100" value="50" class="compslider" name="compslider" id="compslider">';
                    echo '<div class="slider-button" style="left: calc(50% - 28px);"></div>';
                echo '</div>';
            echo '</div>';
		}elseif( $settings['layout_style'] == '6' ){
			echo '<div class="img-box7">';
				if(!empty($settings['image1']['url'])){
	                echo '<div class="img1">';
	                    echo '<img data-mask-src="'.esc_url( $settings['image1']['url'] ).'" src="'.esc_url( $settings['image2']['url'] ).'" alt="About">';
	                echo '</div>';
	            }
                echo '<div class="about-counter">';
                    if(!empty( $settings['desc'] )){
	                	echo wp_kses_post( $settings['desc'] );
	                } 
                echo '</div>';
            echo '</div>';
		}elseif( $settings['layout_style'] == '7' ){
			echo '<div class="img-box7 style2">';
                echo '<div class="img1">';
                    echo '<img data-mask-src="'.esc_url( $settings['image1']['url'] ).'" src="'.esc_url( $settings['image2']['url'] ).'" alt="About">';
                echo '</div>';
                echo '<div class="about-counter">';
                    if(!empty( $settings['desc'] )){
	                	echo wp_kses_post( $settings['desc'] );
	                } 
                echo '</div>';
            echo '</div>';
		}elseif( $settings['layout_style'] == '8' ){
			$class = $settings['class'] ? $settings['class'] : 'img1';

			echo '<div class="'.esc_attr( $class ).'">';
				if(!empty($settings['image1']['url'])){
	                echo mediax_img_tag( array(
						'url'   => esc_url( $settings['image1']['url'] ),
					));
	            }
            echo '</div>';
		}elseif( $settings['layout_style'] == '9' ){
			echo '<div class="comparison-dental">';
                echo '<div class="comparison-img">';
                	if(!empty($settings['image1']['url'])){
	                    echo '<div class="img background-img" data-bg-src="'.esc_url( $settings['image1']['url'] ).'"></div>';
	                }
	                if(!empty($settings['image2']['url'])){
	                    echo '<div class="img foreground-img" data-bg-src="'.esc_url( $settings['image2']['url'] ).'"></div>';
	                }
                    echo '<input type="range" min="1" max="100" value="50" class="compslider" name="compslider" id="compslider">';
                    echo '<div class="slider-button" style="left: calc(50% - 28px);"></div>';
                echo '</div>';
            echo '</div>';
		}elseif( $settings['layout_style'] == '10' ){

            echo '<div class="img-box10">';
             	echo '<div class="img1">';
                   if(!empty($settings['image1']['url'])){
		                echo mediax_img_tag( array(
							'url'   => esc_url( $settings['image1']['url'] ),
						));
		            }
                echo '</div>';
                echo '<div class="img2" data-mask-src="'.esc_url( $settings['image2']['url'] ).'">';
                    echo '<img data-mask-src="'.esc_url( $settings['image2']['url'] ).'" src="'.esc_url( $settings['image3']['url'] ).'" alt="About">';
                echo '</div>';
                echo '<div class="project-counter">';
                    echo '<h3 class="box-number"><span class="counter-number">'.wp_kses_post( $settings['number'] ).'</span>'.wp_kses_post( $settings['operator'] ).'</h3>';
                    echo '<h4 class="box-title">'.wp_kses_post( $settings['title'] ).'</h4>';
                echo '</div>';
            echo '</div>';
		}else{
			echo '<div class="why-img8">';
                if(!empty($settings['image1']['url'])){
	                echo mediax_img_tag( array(
						'url'   => esc_url( $settings['image1']['url'] ),
					));
	            }
            echo '</div>';
		}
	}

}