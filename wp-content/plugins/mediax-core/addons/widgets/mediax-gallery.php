<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
/**
 *
 * Gallery Widget .
 *
 */
class Mediax_Gallery extends Widget_Base {

	public function get_name() {
		return 'mediaxgallery';
	}
	public function get_title() {
		return __( 'Gallery', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'counter_section',
			[
				'label' 	=> __( 'Gallery', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        ); 

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two','Style Three'] );

		// Layout Style 1
		$fields_to_include = [ 'image' => ['Choose Image'], 'title' => ['Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'gallery_lists', 'Gallery List', $fields_to_include, [ '1','2'] );

		mediax_general_fields( $this, 'section_subtitle', 'Subtitle', 'TEXT', 'Subtitle', ['3'] );
		mediax_general_fields( $this, 'section_title', 'Title', 'TEXTAREA', 'Title Here', ['3'] );

		// Layout Style 1
		$fields_to_include_two = [ 'image' => ['Choose Image','Shape Image'], 'title' => ['Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'gallery_list_two', 'Gallery List', $fields_to_include_two, [ '3' ] );

		// $this->add_control(
		// 	'gallery',
		// 	[
		// 		'label' => esc_html__( 'Add Gallery Slider', 'mediax' ),
		// 		'type' => \Elementor\Controls_Manager::GALLERY,
		// 		'default' => [],
		// 	]
		// );

		$this->end_controls_section();

		//---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Title Style-------
		mediax_common_style_fields($this, 'title', 'Section Title', '{{WRAPPER}} .sec-title', ['3']);
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Section Subtitle', '{{WRAPPER}} .sub-title5', [ '3' ] );

		//-------Title Style-------
		mediax_common_style_fields($this, 'content title', 'Title', '{{WRAPPER}} .box-title', ['1','3']);
		//-------Description Style-------
		mediax_common_style_fields( $this, 'content desc', 'Description', '{{WRAPPER}} .box-text', [ '1' ,'3'] );


	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="overflow-hidden">';
				echo '<div class="row g-0 masonary-active">';
				foreach( $settings['gallery_lists'] as $data ){
					echo '<div class="filter-item col-xxl-auto col-lg-6">';
						echo '<div class="gallery-card">';
							echo '<div class="box-img">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['choose_image']['url'] ),
								));
								echo '<div class="shape">
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
								</div>';
							echo '</div>';
							echo '<div class="box-content">';
								echo '<a href="'.esc_url( $data['choose_image']['url'] ).'" class="icon-btn style2 popup-image"><i class="far fa-plus"></i></a>';
								if(!empty($data['title'])){
									echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
								}
								if(!empty($data['description'])){
									echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
								}
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
				echo '</div>';
			echo '</div>';
		}elseif($settings['layout_style'] == '2'){

			echo '<div class="row gy-4 masonary-active gallery-row2">';

                foreach( $settings['gallery_lists'] as $data ){
	                echo '<div class="filter-item col-xl-auto col-md-6">';
	                    echo '<div class="gallery-card style2">';
	                        echo '<div class="box-img">';
	                            echo mediax_img_tag( array(
									'url'   => esc_url( $data['choose_image']['url'] ),
								));
	                            echo '<div class="shape">';
	                                echo '<div class="dot"></div>';
	                                echo '<div class="dot"></div>';
	                                echo '<div class="dot"></div>';
	                                echo '<div class="dot"></div>';
	                            echo '</div>';
	                        echo '</div>';
	                        echo '<div class="box-content">';
	                            echo '<a href="'.esc_url( $data['choose_image']['url'] ).'" class="icon-btn style2 popup-image"><i class="far fa-eye"></i></a>';
	                            if(!empty($data['title'])){
									echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
								}
	                            if(!empty($data['description'])){
									echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
								}
	                        echo '</div>';
	                    echo '</div>';
	                echo '</div>';
	            }
            echo '</div>';
		}else{


    echo '<div class="overflow-hidden space-top gallery-sec3">';
        echo '<div class="container">';
            echo '<div class="row justify-content-lg-between justify-content-center align-items-end">';
                echo '<div class="col-lg">';
                    echo '<div class="title-area">';
                        if(!empty($settings['section_subtitle'])){
							echo '<span class="sub-title5 after-none">'.wp_kses_post($settings['section_subtitle']).'</span>';
						}
						if(!empty($settings['section_title'])){
							echo '<h2 class="sec-title">'.wp_kses_post($settings['section_title']).'</span>';
						}
                    echo '</div>';
                echo '</div>';
                echo '<div class="col-lg-auto d-none d-lg-block">';
                    echo '<div class="sec-btn">';
                        echo '<div class="icon-box">';
                            echo '<button data-slider-prev="#gallerySlider3" class="slider-arrow style2 default"><i class="far fa-arrow-left"></i></button>';
                            echo '<button data-slider-next="#gallerySlider3" class="slider-arrow style2 default"><i class="far fa-arrow-right"></i></button>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<div class="container-fluid">';
            echo '<div class="slider-area gallery-slider3">';
                echo '<div class="swiper th-slider has-shadow" id="gallerySlider3" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1300":{"slidesPerView":"3"},"1500":{"slidesPerView":"4"}}}\'>';
                    echo '<div class="swiper-wrapper">';

						foreach( $settings['gallery_list_two'] as $data ){
	                        echo '<div class="swiper-slide">';
	                            echo '<div class="gallery-card style3">';
	                                echo '<div class="box-img">';
	                                    echo mediax_img_tag( array(
											'url'   => esc_url( $data['choose_image']['url'] ),
										));
	                                echo '</div>';
	                                echo '<div class="box-content">';
	                                    echo '<div class="bg-shape">';
	                                        echo mediax_img_tag( array(
												'url'   => esc_url( $data['shape_image']['url'] ),
											));
	                                    echo '</div>';

			                            if(!empty($data['description'])){
											echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
										}
										if(!empty($data['title'])){
											echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
										}
	                                    echo '<a href="'.esc_url( $data['choose_image']['url'] ).'" class="icon-btn style2 popup-image"><i class="far fa-arrow-right"></i></a>';
	                                echo '</div>';
	                            echo '</div>';
	                        echo '</div>';
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
   	echo '</div>';

		}
	}
}