<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
/**
 *
 * Product Filter Widget
 *
 */
class Mediax_Product_Filter extends Widget_Base{

	public function get_name() {
		return 'mediaxproductfilter';
	}
	public function get_title() {
		return esc_html__( 'Product Filter', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'product_filter_section',
			[
				'label'		=> esc_html__( 'Product Filter','mediax' ),
				'tab'		=> Controls_Manager::TAB_CONTENT,
			]
		);

		mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One' ] );

		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Our Top Medicine' );
		mediax_general_fields( $this, 'all', 'All Product Title', 'TEXTAREA2', 'All Products' );
 
		$this->add_control(
			'product_count',
			[
				'label' 		=> __( 'Product Count', 'mediax' ),
				'type' 			=> Controls_Manager::NUMBER,
				'min' 			=> 1,
				'max' 			=> 50,
				'step' 			=> 1,
				'default' 		=> 6,
			]
		);

        $this->add_control(
			'product_cats',
			[
				'label' 		=> __( 'Product Categories', 'mediax' ),
                'type' 			=> Controls_Manager::SELECT2,
                'multiple' 		=> true,
                'label_block'   => true,
                'options' 		=> $this->product_cats_get(), 
			]
        );

		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'title', 'Section Title', '{{WRAPPER}} .sec-title' );
		//------Button Style-------
		mediax_button_style_fields( $this, '12', 'Tab Styling', '{{WRAPPER}} .th_btn' );
		//-------Product Title Style-------
		mediax_common2_style_fields( $this, 'title2', 'Product Title', '{{WRAPPER}} .product-title a' );
		mediax_common2_style_fields( $this, 'category', 'Product Category', '{{WRAPPER}} .product-category' );
        mediax_common_style_fields( $this, 'price', 'Product Price', '{{WRAPPER}} .price' );

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

        

        $args = array(
            "post_type" 		=> "product",
            "posts_per_page"    => esc_attr( $settings['product_count'] )
        );

        $args['order'] 		= 'ASC';
        $args['orderby'] 	= 'title';

        if( ! empty( $settings['product_cats'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $settings['product_cats'],
                ),
            );
        }

        $prods = new WP_Query( $args );

		if( $settings['layout_style'] == '1' ){
            echo '<div class="row justify-content-lg-between justify-content-center align-items-center">';
                if(!empty($settings['title'])){
                    echo '<div class="col-lg-auto">';
                        echo '<h3 class="sec-title text-center">'.esc_html($settings['title']).'</h3>';
                    echo '</div>';
                }
                echo '<div class="col-lg-auto">';
                    echo '<div class="filter-menu filter-menu-active">';
                        if(!empty($settings['all'])){
                            echo '<button data-filter="*" class="th-btn th_btn2 active" type="button">'.esc_html($settings['all']).'</button>';
                        }

                        $product_cats = $settings['product_cats'];
                        foreach ($product_cats as $name) {
                            $button_text = esc_html(str_replace('-', ' ', $name));
                            echo '<button data-filter=".' . esc_attr($name) . '" class="th-btn th_btn" type="button">' . $button_text . '</button>';
                        }
                        
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            
            echo '<div class="row gy-40 filter-active">';
            while( $prods->have_posts() ) { 
                $prods->the_post();

                global $product;
                $product_categories = get_the_terms( get_the_ID(), 'product_cat' );
                $category_slugs = array();

                $first_category_name = $product_categories[0]->name;
                $first_category_url = get_term_link( $product_categories[0] );

                if ($product_categories) {
                    foreach ($product_categories as $product_category) {
                        $category_slugs[] = $product_category->slug;
                    }
                }

                    echo '<div class="col-xl-3 col-lg-4 col-sm-6 filter-item '. esc_attr(implode(' ', $category_slugs)) .'">';
                        echo '<div class="th-product product-grid">';
                            echo '<div class="product-img">';
                                if( has_post_thumbnail() ){
                                        the_post_thumbnail( 'mediax-shop-product-list' );
                                    echo '<div class="actions">';
                                        // Quick View Button
                                        if( class_exists( 'WPCleverWoosq' ) ){
                                            echo do_shortcode('[woosq]');
                                        }
                                        // Cart Button
                                        woocommerce_template_loop_add_to_cart();
                                        // Wishlist Button
                                        if (class_exists('WPCleverWoosw')) {
                                            echo do_shortcode('[woosw]');
                                        }
                                    echo '</div>';
                                    if( $product->is_type('simple') || $product->is_type('external') || $product->is_type('grouped') ) {

                                        $regular_price  = get_post_meta( $product->get_id(), '_regular_price', true ); 
                                        $sale_price     = get_post_meta( $product->get_id(), '_sale_price', true );
                                        if( !empty($sale_price) ) {
                                            if( $regular_price > $sale_price ){
                                                echo '<span class="product-tag">'.esc_html__('Sale', 'mediax').'</span>';
                                            }
                                        }
                                    }
                                }
                            echo '</div>';
                           echo ' <div class="product-content">';
                                echo '<a href="'.esc_url( $first_category_url).'" class="product-category">'.esc_html( $first_category_name).'</a>';
                                echo '<h3 class="product-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( get_the_title() ).'</a></h3>';
                                echo woocommerce_template_loop_price();
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                } wp_reset_postdata();
            echo '</div>';

		}

		
	}
}