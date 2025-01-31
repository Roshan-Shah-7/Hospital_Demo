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
 * features Widget .
 *
 */
class Mediax_Features extends Widget_Base {

	public function get_name() {
		return 'mediaxfeatures';
	}
	public function get_title() {
		return __( 'Features', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'arrow_section',
			[
				'label'     => __( 'Features', 'mediax' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five', 'Style Six', 'Style Seven', 'Style Eight','Style Nine', 'Style Ten', 'Style Eleven', 'Style Tweleve','Style Thirteen', 'Style Fourteen' ] );

		mediax_media_fields( $this, 'image', 'Choose Shape', ['5'] );
		mediax_general_fields( $this, 'title', 'Title', 'TEXTAREA2', 'Working Hour', [ '8' ] );

		// Layout Style 1
		$fields_to_include = [ 'image' => ['Choose Icon'], 'title' => ['Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'feature_lists', 'Features List', $fields_to_include, [ '1', '4', '5', '9','10','11','12','13' ] );

		// Layout Style 2
		$fields_to_include2 = [ 'title' => ['Icon'], 'desc' => ['List'] ];
		mediax_repeater_fields( $this, 'feature_lists_2', 'Features List', $fields_to_include2, [ '2' ] );

		// Layout Style 3
		$fields_to_include3 = [ 'title' => ['Number', 'Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'feature_lists_3', 'Features List', $fields_to_include3, [ '3' ] );

		// Layout Style 6
		$fields_to_include4 = [ 'title' => ['Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'feature_lists_4', 'Features List', $fields_to_include4, [ '6' ] );

		// Layout Style 7
		$fields_to_include5 = [ 'image' => ['Choose Image'], 'title' => [ 'Number', 'Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'feature_lists_5', 'Features List', $fields_to_include5, [ '7' ] );

		// Layout Style 8
		$fields_to_include6 = [ 'title' => ['Title'], 'desc' => ['Content'] ];
		mediax_repeater_fields( $this, 'working_lists', 'Working Lists', $fields_to_include6, [ '8' ] );

		// Layout Style 14
		$fields_to_include7 = [ 'title' => ['Title'], 'desc' => ['Content'] ];
		mediax_repeater_fields( $this, 'feature_lists_6', 'Features Lists', $fields_to_include7, [ '14' ] );


		$this->add_control(
			'counter',
			[
				'label' 	=> __( 'Counterup', 'mediax' ),
                'type' 		=> Controls_Manager::WYSIWYG,
                'default'  	=> __( 'Our Principles', 'mediax' ),
                'condition' => [
					'layout_style' => ['9']
				]
			]
        );
		
        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------	

		//-------List Item Style-------
		mediax_common_style_fields( $this, 'list_item', 'List Item', '{{WRAPPER}} .checklist.style2 li', ['2'] );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .box-title', [ '1', '3', '4', '5','9','10','11','13' ] );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .box-text', [ '1', '3', '4', '5', '9','10','11','13' ] );


	}

	protected function render() {

    $settings = $this->get_settings_for_display(); 

		if( $settings['layout_style'] == '1' ){
			echo '<div class="feature-list-wrap">';
				foreach( $settings['feature_lists'] as $data ){
					echo '<div class="feature-list">';
						if(!empty($data['choose_icon']['url'])){
							echo '<div class="box-icon">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['choose_icon']['url'] ),
								));
							echo '</div>';
						}
						echo '<div class="media-body">';
							if(!empty($data['title'])){
								echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="feature-list-line"></div>';

				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="mt-n1">';
				echo '<div class="checklist style2 list-two-column">';
					echo '<ul>';
						foreach( $settings['feature_lists_2'] as $data ){
							echo '<li>'.wp_kses_post( $data['icon'] . $data['list'] ).'</li>';
						}
					echo '</ul>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="choose-feature-wrap">';
				foreach( $settings['feature_lists_3'] as $data ){
					echo '<div class="choose-feature">';
						if(!empty($data['number'])){
							echo '<div class="box-number">'.wp_kses_post($data['number']).'</div>';
						}
						echo '<div class="media-body">';
							if(!empty($data['title'])){
								echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '4' ){
			echo '<div class="feature-box-wrap">';
				foreach( $settings['feature_lists'] as $data ){
					echo '<div class="feature-box">';
						if(!empty($data['choose_icon']['url'])){
							echo '<div class="box-icon">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['choose_icon']['url'] ),
								));
							echo '</div>';
						}
						echo '<div class="media-body">';
							if(!empty($data['title'])){
								echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '5' ){
			echo '<div class="row gy-4">';
				foreach( $settings['feature_lists'] as $data ){
					echo '<div class="col-xl-3 col-sm-6">';
						echo '<div class="why-feature" data-bg-src="'.esc_url( $settings['image']['url'] ).'">';
							if(!empty($data['choose_icon']['url'])){
								echo '<div class="box-icon">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
								echo '</div>';
							}
							if(!empty($data['title'])){
								echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '6' ){
			echo '<div class="case-box-wrap">';
				foreach( $settings['feature_lists_4'] as $data ){
					echo '<div class="case-box">';
						if(!empty($data['title'])){
							echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
						}
						if(!empty($data['description'])){
							echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
						}
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '7' ){
			echo '<div class="achieve-box-wrap">';
				foreach( $settings['feature_lists_5'] as $key => $data ){
					$active = ($key==1) ? 'item-active':'';
					echo '<div class="achieve-box hover-item '.esc_attr($active).'">';
						if(!empty($data['choose_image']['url'])){
							echo '<div class="box-img">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['choose_image']['url'] ),
								));
							echo '</div>';
						}
						if(!empty($data['number'])){
							echo '<div class="box-year">'.wp_kses_post($data['number']).'</div>';
						}
						echo '<div class="media-body">';
							if(!empty($data['title'])){
								echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '8' ){
			echo '<div class="tab-schedule">';
				if(!empty($settings['title'])){
					echo '<h3 class="widget_title">'.esc_html($settings['title']).'</h3>';
				}
				foreach( $settings['working_lists'] as $data ){
					echo '<p class="box-text">'.esc_html($data['title']).'<span>'.esc_html($data['content']).'</span></p>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '9' ){
			echo '<div class="feature-and-counter">';
                echo '<div class="about-feature-wrap">';

                	foreach( $settings['feature_lists'] as $data ){
	                    echo '<div class="about-feature">';
	                        if(!empty($data['choose_icon']['url'])){
								echo '<div class="box-icon">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
								echo '</div>';
							}
	                        echo '<div class="media-body">';
	                            if(!empty($data['title'])){
									echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
								}
	                            if(!empty($data['description'])){
									echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
								}
	                        echo '</div>';
	                    echo '</div>';
	                }
                    

                echo '</div>';
                echo '<div class="about-counter">';
                	if( !empty( $settings['counter'] ) ) {
	                    echo wp_kses_post( $settings['counter'] );
	                }
                echo '</div>';
            echo '</div>';
		}elseif( $settings['layout_style'] == '10' ){
			echo '<div class="eye-feature-wrap">';
				$x = 0;
                foreach( $settings['feature_lists'] as $data ){     
                	$x++;
                    $k = str_pad($x, 2, '0', STR_PAD_LEFT); 
                      	
	                echo '<div class="eye-feature">';
	                    echo '<div class="icon-wrap">';
	                        if(!empty($data['choose_icon']['url'])){
								echo '<div class="box-icon">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
								echo '</div>';
							}
	                        echo '<div class="box-number">'.esc_html( $k ).'</div>';
	                    echo '</div>';
	                    if(!empty($data['title'])){
							echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
						}
	                    if(!empty($data['description'])){
							echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
						}
	                echo '</div>';
	            }
            echo '</div>';
		}elseif( $settings['layout_style'] == '11' ){
			echo '<div class="row gy-4 justify-content-center">';

                $x = 0;
                foreach( $settings['feature_lists'] as $data ){  
                	$x++;
                	if( $x == 1 ){
                		$color = '#D4FEEC';
                	}elseif( $x == 2 ){
                		$color = '#F5F8FD';
                	}else{
                		$color = '#E0F1FE';
                	}
	                echo '<div class="col-lg-4 col-md-6">';
	                    echo '<div class="feature-card" data-bg-color="'.esc_attr( $color ).'">';
	                        echo '<div class="title-wrap">';
	                            if(!empty($data['choose_icon']['url'])){
									echo '<div class="box-icon">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $data['choose_icon']['url'] ),
										));
									echo '</div>';
								}
	                            if(!empty($data['title'])){
									echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
								}
	                        echo '</div>';
	                        if(!empty($data['description'])){
								echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
							}
	                    echo '</div>';
	                echo '</div>';
	            }

            echo '</div>';
		}elseif( $settings['layout_style'] == '12' ){
			foreach( $settings['feature_lists'] as $data ){  
				echo '<div class="why-box">';
	                if(!empty($data['choose_icon']['url'])){
						echo '<div class="box-icon">';
							echo mediax_img_tag( array(
								'url'   => esc_url( $data['choose_icon']['url'] ),
							));
						echo '</div>';
					}
	                echo '<div class="media-body">';
	                    if(!empty($data['title'])){
							echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
						}
	                    if(!empty($data['description'])){
							echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
						}
	                echo '</div>';
	            echo '</div>';
	        }
		}elseif( $settings['layout_style'] == '14' ){

			echo '<div class="row gy-4 justify-content-center">';
				foreach( $settings['feature_lists_6'] as $data ){
	                echo '<div class="col-md-6">';
	                    echo '<div class="feature-card2">';
	                        echo '<h3 class="box-title">'.esc_html($data['title']).'</h3>';
	                        echo '<p class="box-text">'.esc_html($data['content']).'</p>';
	                    echo '</div>';
	                echo '</div>';
	            }    
            echo '</div>';

		}else{
			echo '<div class="feature-list-wrap style2">';
				foreach( $settings['feature_lists'] as $data ){
					echo '<div class="feature-list">';
						if(!empty($data['choose_icon']['url'])){
							echo '<div class="box-icon">';
								echo mediax_img_tag( array(
									'url'   => esc_url( $data['choose_icon']['url'] ),
								));
							echo '</div>';
						}
						echo '<div class="media-body">';
							if(!empty($data['title'])){
								echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
							}
							if(!empty($data['description'])){
								echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="feature-list-line"></div>';

				}
			echo '</div>';
		}


			
	}
}