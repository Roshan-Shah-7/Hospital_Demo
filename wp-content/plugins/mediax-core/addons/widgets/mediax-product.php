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
class Mediax_Product extends Widget_Base{

	public function get_name() {
		return 'mediaxeproduct';
	}
	public function get_title() {
		return esc_html__( 'Product With Cta', 'mediax' );
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

		mediax_switcher_fields( $this, 'cta_show', 'Cta Show?' );
		mediax_switcher_fields( $this, 'cta_side_show', 'Cta Right Side Show?' );
		mediax_switcher_fields( $this, 'top_show', 'Heading & Button Show?' );
		mediax_general_fields( $this, 'p_title', 'Title', 'TEXTAREA2', 'Our Top Medicine' );
		mediax_general_fields( $this, 'p_button_text', 'Button Text', 'TEXT', 'VIEW ALL PRODUCT' );
		mediax_url_fields( $this, 'p_button_url', 'Button URL' );

		mediax_general_fields( $this, 'divider', 'DIVIDER', 'DIVIDER', '', '1' );
 
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

		mediax_general_fields( $this, 'product_col', 'Product Column', 'TEXT', 'col-lg-4 col-sm-6', '1' );

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

		$this->start_controls_section(
			'cta_content',
			[
				'label'		=> esc_html__( 'Cta','mediax' ),
				'tab'		=> Controls_Manager::TAB_CONTENT,
			]
		);

		mediax_media_fields( $this, 'image', 'Choose Image', ['1'] );
		mediax_general_fields( $this, 'subtitle', 'Subtitle', 'TEXTAREA2', 'Subtitle', ['1'] );
		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Title', ['1'] );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', 'Description', ['1'] );
		mediax_general_fields( $this, 'button_text', 'Button Text', 'TEXT', 'Button Text', [ '1' ] );
		mediax_url_fields( $this, 'button_url', 'Button URL', [ '1' ] );

		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'title', 'Section Title', '{{WRAPPER}} .sec-title' ); 
		//------Button Style-------
		mediax_button_style_fields( $this, '12', 'Button Styling', '{{WRAPPER}} .th_btn2' );

		//-------Product Title Style-------
		mediax_common2_style_fields( $this, 'title2', 'Product Title', '{{WRAPPER}} .product-title a' );
		mediax_common2_style_fields( $this, 'category', 'Product Category', '{{WRAPPER}} .product-category' );
        mediax_common_style_fields( $this, 'price', 'Product Price', '{{WRAPPER}} .price' );

		//-------Subtitle Style-------
		mediax_common_style_fields( $this, 'subtitle', 'Cta Subtitle', '{{WRAPPER}} .sub' );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title3', 'Cta Title', '{{WRAPPER}} .title' );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Cta Description', '{{WRAPPER}} .desc' );
		//------Button Style-------
		mediax_button_style_fields( $this, '13', 'Cta Button Styling', '{{WRAPPER}} .th_btn' );

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
			echo '<div class="row">';
				if(!empty($settings['product_col'])){
					$product_col = $settings['product_col'];
				}else{
					$product_col = 'col-lg-4 col-sm-6';
				}
				
				if(!empty($settings['cta_show'])){
					$col = 'col-xl-9';
				}else{
					$col = 'col-xl-12';
				}
				if( !empty($settings['cta_show']) && empty($settings['cta_side_show']) ){
					echo '<div class="col-xl-3 mb-40 mb-xl-0">';
						echo '<div class="offer-grid mega-hover text-center text-xl-start" data-bg-src="'.esc_url($settings['image']['url']).'">';
							if(!empty($settings['subtitle'])){
								echo '<span class="h6 box-subtitle sub">'.wp_kses_post($settings['subtitle']).'</span>';
							}
							if(!empty($settings['desc'])){
								echo '<p class="price desc">'.wp_kses_post($settings['desc']).'</p>';
							}
							if(!empty($settings['title'])){
								echo '<h3 class="box-title title">'.wp_kses_post($settings['title']).'</h3>';
							}
							if(!empty($settings['button_text'])){
								echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn btn-sm style4 th_btn">'.wp_kses_post($settings['button_text']).'</a>';
							}
						echo '</div>';
					echo '</div>';
				}

				echo '<div class="'.esc_attr($col).'">';
					if(!empty($settings['top_show'])){
						echo '<div class="row justify-content-md-between justify-content-center align-items-center">';
							if(!empty($settings['p_title'])){
								echo '<div class="col-md">';
									echo '<h3 class="sec-title has-line">'.wp_kses_post($settings['p_title']).'</h3>';
								echo '</div>';
							}
							if(!empty($settings['p_button_text'])){
								echo '<div class="col-md-auto mt-n3 mt-md-0">';
									echo '<div class="sec-btn">';
										echo '<a href="'.esc_url( $settings['p_button_url']['url'] ).'" class="th-btn style-smoke th_btn2">'.wp_kses_post($settings['p_button_text']).'</a>';
									echo '</div>';
								echo '</div>';
							}
						echo '</div>';
					}
					echo '<div class="row gy-40">';
						while( $prods->have_posts() ) { 
							$prods->the_post();
							global $product;
							$product_categories = get_the_terms( get_the_ID(), 'product_cat' );
               				$first_category_name = $product_categories[0]->name;
                			$first_category_url = get_term_link( $product_categories[0] );

							echo '<div class="'.esc_attr($product_col).'">'; 
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
				echo '</div>';

				if( !empty($settings['cta_show']) && !empty($settings['cta_side_show']) ){
					echo '<div class="col-xl-3 mt-40 mt-xl-0">';
						echo '<div class="offer-grid mega-hover text-center text-xl-start" data-bg-src="'.esc_url($settings['image']['url']).'">';
							if(!empty($settings['subtitle'])){
								echo '<span class="h6 box-subtitle sub">'.wp_kses_post($settings['subtitle']).'</span>';
							}
							if(!empty($settings['desc'])){
								echo '<p class="price desc">'.wp_kses_post($settings['desc']).'</p>';
							}
							if(!empty($settings['title'])){
								echo '<h3 class="box-title title">'.wp_kses_post($settings['title']).'</h3>';
							}
							if(!empty($settings['button_text'])){
								echo '<a href="'.esc_url( $settings['button_url']['url'] ).'" class="th-btn btn-sm style4 th_btn">'.wp_kses_post($settings['button_text']).'</a>';
							}
						echo '</div>';
					echo '</div>';
				}

			echo '</div>';

		}

		
	}
}