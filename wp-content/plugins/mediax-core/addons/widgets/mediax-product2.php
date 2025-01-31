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
 * Product Widget
 *
 */
class Mediax_Product2 extends Widget_Base{

	public function get_name() {
		return 'mediaxeproduct2';
	}
	public function get_title() {
		return esc_html__( 'Product', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'product_content',
			[
				'label'		=> esc_html__( 'Product With Cta','mediax' ),
				'tab'		=> Controls_Manager::TAB_CONTENT,
			]
		);

		mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One' ] );
 
		$this->add_control(
			'product_count',
			[
				'label' 		=> __( 'Product Count', 'mediax' ),
				'type' 			=> Controls_Manager::NUMBER,
				'min' 			=> 1,
				'max' 			=> 50,
				'step' 			=> 1,
				'default' 		=> 4,
			]
		);

		mediax_general_fields( $this, 'product_col', 'Product Column', 'TEXT', 'col-md-6', '1' );

        $this->add_control(
			'show_product_by',
			[
				'label'         => __( 'Product By', 'mediax' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => '1',
				'options'       => [
					'1'            => __( 'Categories', 'mediax' ),
					'2'            => __( 'On Sale', 'mediax' ),
					'3'            => __( 'Best Sale', 'mediax' ),
					'4'            => __( 'Top Rated', 'mediax' ),
				],
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
				'condition'		=> [
					'show_product_by' => ['1']
				],
			]
        );

		$this->add_control(
			'product_style',
			[
				'label'         => __( 'Product Layout Style', 'mediax' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'grid',
				'options'       => [
					'grid'            => __( 'Grid View', 'mediax' ),
					'list'            => __( 'List View', 'mediax' ),
				],
			]
		);

		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

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
        "post_type"         => "product",
        "posts_per_page"    => esc_attr( $settings['product_count'] ),
        'order'             => 'ASC',
        'orderby'           => 'title',
    );
    
    if( ! empty( $settings['product_cats'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $settings['product_cats'],
            ),
        );
    }
    
    if ( $settings['show_product_by'] == '2' ) {
        $args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => '_sale_price',
                'value' => '',
                'compare' => '!='
            ),
            array(
                'key' => '_sale_price',
                'value' => '0',
                'compare' => '>'
            )
        );
    }
    
    if ( $settings['show_product_by'] == '3' ) {
        $args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'desc';
        $args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => 'total_sales',
                'compare' => 'EXISTS', // Checks if the meta key exists
            ),
            array(
                'key' => 'total_sales',
                'value' => '0',
                'compare' => '>',
                'type' => 'NUMERIC', // Considers the value as numeric for comparison
            ),
        );
    }
    
    if ($settings['show_product_by'] == '4') {
        $args = array(
            "post_type"      => "product",
            "posts_per_page" => esc_attr($settings['product_count']),
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => '_wc_average_rating',
                    'compare' => 'EXISTS', // Ensures the meta key exists
                ),
                array(
                    'relation' => 'OR',
                    array(
                        'key'     => '_wc_review_count',
                        'value'   => '1',
                        'compare' => '>', // Excludes products with a review count of zero
                        'type'    => 'NUMERIC',
                    ),
                    array(
                        'key'     => '_wc_review_count',
                        'compare' => 'NOT EXISTS', // Considers products without review count meta
                    ),
                ),
            ),
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        );
    }
    
    
    
    

    $prods = new WP_Query( $args );

		if( $settings['layout_style'] == '1' ){
            echo '<div class="row gy-4">';
                while( $prods->have_posts() ) {
                    $prods->the_post();
                    global $product;
                    $product_categories = get_the_terms( get_the_ID(), 'product_cat' );
                    $first_category_name = $product_categories[0]->name;
                    $first_category_url = get_term_link( $product_categories[0] );

                    echo '<div class="'.esc_attr($settings['product_col']).'">';
                        if ( $settings['product_style'] == 'list' ) {
                            wc_get_template( 'product-list-style.php' );
                        } else {
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
                        }
                    echo '</div>';
                }
            echo '</div>';

		}

		
	}
}