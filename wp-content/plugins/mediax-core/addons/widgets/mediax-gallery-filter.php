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
 * Gallery Filter Widget .
 *
 */
class Mediax_Gallery_Filter extends Widget_Base {

	public function get_name() {
		return 'mediaxgalleryfilter';
	}
	public function get_title() {
		return __( 'Gallery Filter', 'mediax' );
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
				'label'     => __( 'Gallery Filter', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One'] );

		// Layout Style 1
		$fields_to_include = [ 'image' => ['Choose Image'], 'title' => ['Subtitle', 'Title'] ];
		mediax_repeater_fields( $this, 'gallery_list', 'Gallery Lists', $fields_to_include );

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields($this, 'subtitle', 'Subtitle', '{{WRAPPER}} .gallery-text' );
		//-------Title Style-------
		mediax_common_style_fields($this, 'title', 'Title', '{{WRAPPER}} .box-title');

	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
            echo '<div class="row gallery-row filter-active">';
			foreach( $settings['gallery_list'] as $data ){
                echo '<div class="col-md-6 col-xl-auto filter-item cat1 cat2 cat5 cat4 cat3">';
                    echo '<div class="gallery-card wow fadeInUp">';
                        echo '<div class="gallery-img">';
							echo mediax_img_tag( array(
								'url'   => esc_url( $data['choose_image']['url'] ), 
							));
                        echo '</div>';
                        echo '<div class="gallery-content">';
							if(!empty($data['subtitle'])){
								echo '<span class="gallery-text">'.wp_kses_post($data['subtitle']).'</span>';
							}
							if(!empty($data['title'])){
								echo '<h4 class="box-title">'.wp_kses_post($data['title']).'</h4>';
							}
                            echo '<a href="'.esc_url( $data['choose_image']['url'] ).'" class="icon-btn popup-image">
                                <i class="fa-solid fa-plus"></i></a>';
                        echo '</div>';
                   echo ' </div>';
                echo '</div>';
			}
            echo '</div>';

		}


	}

}