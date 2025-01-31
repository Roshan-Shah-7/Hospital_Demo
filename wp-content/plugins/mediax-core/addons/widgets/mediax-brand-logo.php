<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Border;
/**
 *
 * Brand Logo Widget .
 *
 */
class mediax_Brand_Logo extends Widget_Base {

	public function get_name() {
		return 'mediaxbrandlogo';
	}
	public function get_title() {
		return __( 'Brand Logo', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'client_logo_section',
			[
				'label' 	=> __( 'Brand Logo', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One', 'Style Two', 'Style Three','Style Four','Style Five', ] );

		mediax_media_fields( $this, 'shape', 'Choose Bg Shape', [ '2','4' ] );

		$fields_to_include = [ 'image' => ['Brand Logo'] ];
		mediax_repeater_fields( $this, 'logos', 'Brand Logos', $fields_to_include );

        $this->end_controls_section();

		//---------------------------------------
			//Style Section Start
		//---------------------------------------


	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="brand-sec1">';
				echo '<div class="container th-container">';
					echo '<div class="swiper th-slider" id="brandSlider1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":2},"420":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"},"1400":{"slidesPerView":"8"}}}\'>';
						echo '<div class="swiper-wrapper">';
							foreach( $settings['logos'] as $data ){
								echo '<div class="swiper-slide">';
									echo '<div class="brand-box">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $data['brand_logo']['url'] ),
										) );
									echo '</div>';
								echo '</div>';
							}
						echo '</div>';
		
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="bg-theme2 bg-top-right"  data-bg-src="'.esc_url( $settings['shape']['url'] ).'" >';
				echo '<div class="container th-container py-5">';
					echo '<div class="swiper th-slider" id="brandSlider2" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":2},"420":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"},"1400":{"slidesPerView":"8"}}}\'>';
						echo '<div class="swiper-wrapper">';
							foreach( $settings['logos'] as $data ){
								echo '<div class="swiper-slide">';
									echo '<div class="brand-box">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $data['brand_logo']['url'] ),
										) );
									echo '</div>';
								echo '</div>';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="swiper th-slider" id="brandSlider3" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":2},"420":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"},"1400":{"slidesPerView":"8"}}}\'>';
				echo '<div class="swiper-wrapper">';
					foreach( $settings['logos'] as $data ){
						echo '<div class="swiper-slide">';
							echo '<div class="brand-card">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['brand_logo']['url'] ),
								) );
							echo '</div>';
						echo '</div>';
					}	
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '4' ){
			echo '<div class="brand-box-wrap" data-bg-src="'.esc_url( $settings['shape']['url'] ).'">';
                echo '<div class="swiper th-slider" id="brandSlider2" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":2},"420":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"4"},"1200":{"slidesPerView":"5"},"1400":{"slidesPerView":"5"}}}\'>';
                    echo '<div class="swiper-wrapper">';
                        foreach( $settings['logos'] as $data ){
							echo '<div class="swiper-slide">';
								echo '<div class="brand-box">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['brand_logo']['url'] ),
									) );
								echo '</div>';
							echo '</div>';
						}
                    echo '</div>';
                echo '</div>';
            echo '</div>';
		}else{
			echo '<div class="brand-sec5">';
		        echo '<div class="container th-container">';
		            echo '<div class="swiper th-slider" id="brandSlider2" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":2},"420":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"},"1400":{"slidesPerView":"8"}}}\'>';
		                echo '<div class="swiper-wrapper">';
							foreach( $settings['logos'] as $data ){
			                    echo '<div class="swiper-slide">';
			                        echo '<div class="brand-box">';
			                            echo mediax_img_tag( array(
											'url'   => esc_url( $data['brand_logo']['url'] ),
										) );
			                        echo '</div>';
			                    echo '</div>';
		                   	}
		                echo '</div>';

		            echo '</div>';
		        echo '</div>';
		    echo '</div>';
		}
	}
}