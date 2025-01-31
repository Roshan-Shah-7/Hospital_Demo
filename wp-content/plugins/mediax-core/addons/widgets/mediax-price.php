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
 * Price Widget .
 *
 */
class Mediax_Price extends Widget_Base {

	public function get_name() {
		return 'mediaxprice';
	}
	public function get_title() {
		return __( 'Price Box', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'price_section',
			[
				'label' 	=> __( 'Price Box', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', ['Style One'] );

		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Title', ['1'] );
		mediax_general_fields( $this, 'lists', 'Lists', 'TEXTAREA3', 'Description', ['1'] );

		//Style 1
		$fields_to_include = [ 'title' => ['Title'], 'desc' => ['Price', 'Features'], 'btn' => ['Button Text'], 'url' => ['Button URL'] ];
		mediax_repeater_fields( $this, 'price_list', 'Price Lists', $fields_to_include, ['1'] );

		//Style 2
		$fields_to_include2 = [ 'image' => ['Icon'], 'title' => ['Title', 'Description'], 'desc' => ['Price', 'Features'], 'btn' => ['Button Text'], 'url' => ['Button URL'] ];
		mediax_repeater_fields( $this, 'price_list_2', 'Price Lists', $fields_to_include2, ['2'] );

		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title' );
		mediax_common_style_fields( $this, 'title2', 'Plan Title', '{{WRAPPER}} .price-card .box-title' );
		//-------Price Style-------
		mediax_common_style_fields( $this, 'price', 'Price', '{{WRAPPER}} .price' );
		//-------Price Style-------
		mediax_common_style_fields( $this, 'description', 'Lists', '{{WRAPPER}} .price-card .checklist li' );
		//------Button Style-------
		mediax_button_style_fields( $this, '11', 'Button Styling', '{{WRAPPER}} .th_btn' );

	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="row gx-10">';
				echo '<div class="col-xl-3 d-none d-xl-block">';
					echo '<div class="price-card price-card-list">';
						if(!empty($settings['title'])){
							echo '<h3 class="box-title title">'.esc_html($settings['title']).'</h3>';
						}
						echo '<div class="box-content">';
							if(!empty($settings['lists'])){
								echo '<div class="checklist">';
									echo wp_kses_post($settings['lists']);
								echo '</div>';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-xl-9">';
					echo '<div class="row gx-0 justify-content-center price-card-wrap">';
						foreach( $settings['price_list'] as $key => $data ){
							$active = ($key == 1) ? 'active':'';
							echo '<div class="col-md-4">';
								echo '<div class="price-card '.esc_attr($active).'">';
									if(!empty($data['title'])){
										echo '<h3 class="box-title">'.esc_html($data['title']).'</h3>';
									}
									if(!empty($data['price'])){
										echo '<h4 class="box-price price">'.wp_kses_post($data['price']).'</h4>';
									}
									echo '<div class="box-content">';
										if(!empty($data['features'])){
											echo '<div class="checklist">';
												echo wp_kses_post($data['features']);
											echo '</div>';
										}
										if(!empty($data['button_text'])){
											echo '<a href="'.esc_url( $data['button_url']['url'] ).'" class="th-btn btn-sm th_btn">'.wp_kses_post($data['button_text']).'</a>';
										}
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			
		}


	}

}