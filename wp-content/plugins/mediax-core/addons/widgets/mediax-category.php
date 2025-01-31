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
 * Category Widget .
 *
 */
class Mediax_Category extends Widget_Base {

	public function get_name() {
		return 'mediaxcategory';
	}
	public function get_title() {
		return __( 'Category', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'categroy_section',
			[
				'label'     => __( 'Category', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

        mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One' ] );

        mediax_switcher_fields( $this, 'top_show', 'Heading & Arrow Show?' );
        mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Shop by Category' );

		$repeater = new Repeater();

		$repeater->add_control(
			'product_cats',
			[
				'label' 		=> __( 'Product Categories', 'mediax' ),
                'type' 			=> Controls_Manager::SELECT,
                'multiple' 		=> true,
                'label_block'   => true,
                'options' 		=> $this->product_cats_get(),
			]
        );
		// mediax_media_fields($repeater, 'icon', 'Use Custom Icon ?');
		$repeater->add_control(
			'icon',
			[
				'label'     => esc_html__('Use Custom Icon ?', 'mediax'),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'Description' => esc_html__('If you want to use custom image for the category select here. Otherwise it will get the default image of the category', 'mediax'),
			]
		);
		$this->add_control(
			'category_list',
			[
				'label' 		=> __( 'Category', 'mediax' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
			]
		);

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------	

		//-------Title Style-------
		mediax_common_style_fields($this, 'title', 'Title', '{{WRAPPER}} .sec-title');
		//-------Product Title Style-------
		mediax_common2_style_fields( $this, 'title2', 'Category Name', '{{WRAPPER}} .box-title a' );


	}

	protected function product_cats_get() {
        $terms = get_terms( array( 'taxonomy' => 'product_cat' ) );
        $term_array = array();
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $term_array[$term->slug] = $term->name;
            }
        }
        return $term_array;
    }

	protected function render() {

        $settings = $this->get_settings_for_display();

		if ( $settings['layout_style'] == '1' ) {
            if(!empty($settings['top_show'])){
                echo '<div class="row justify-content-md-between justify-content-center align-items-center">';
                    if(!empty($settings['title'])){
                        echo '<div class="col-md-auto">';
                            echo '<h3 class="sec-title text-center">'.esc_html($settings['title']).'</h3>';
                        echo '</div>';
                    }
                    echo '<div class="col-md-auto mt-n3 mt-md-0">';
                        echo '<div class="sec-btn">';
                            echo '<div class="icon-box">';
                                echo '<button data-slider-prev="#catSlide1" class="slider-arrow icon-sm default"><i class="far fa-arrow-left"></i></button>';
                                echo '<button data-slider-next="#catSlide1" class="slider-arrow icon-sm default"><i class="far fa-arrow-right"></i></button>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }

            echo '<div class="swiper th-slider" id="catSlide1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"400":{"slidesPerView":"2"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"}}}\'>';
                echo '<div class="swiper-wrapper">';
                foreach ($settings['category_list'] as $data) {
                    $category_slug = $data['product_cats'];
                    $category = get_term_by('slug', $category_slug, 'product_cat');
                    $category_url = get_term_link($category);
                
                    if (!is_wp_error($category) && !empty($category)) {
                    echo '<div class="swiper-slide">';
                        echo '<div class="category-card">';
                            echo '<div class="box-icon">';
                                if (!empty($data['icon']['url'])) {
                                    echo mediax_img_tag(array(
                                        'url' => esc_url($data['icon']['url']),
                                    ));
                                } else {
                                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                    $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
                                    echo mediax_img_tag(array(
                                        'url' => esc_url($thumbnail_url),
                                        'class' => 'original-icon',
                                    ));
                                }
                            echo '</div>';
                            echo '<h3 class="box-title"><a href="'. esc_url($category_url) . '">'. esc_html($category->name) .'</a></h3>';
                        echo '</div>';
                    echo '</div>';
                    }
                }

                echo '</div>';
           echo ' </div>';

		} elseif ( $settings['layout_style'] == '2' ) {
		

		}


	}
}