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
class Mediax_Features_V2 extends Widget_Base {

	public function get_name() {
		return 'mediaxfeaturesv2';
	}
	public function get_title() {
		return __( 'Features v2', 'mediax' );
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

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One','Style Two','Style Three','Style Four' ] );


		// Layout Style 1
		$fields_to_include = [ 'image' => ['Choose Icon'], 'title' => ['Title', 'Number'], 'desc' => ['Description'], 'url' => ['URL'] ];
		mediax_repeater_fields( $this, 'feature_lists', 'Features List', $fields_to_include, [ '1','2' ] );

		$fields_to_include_2 = [ 'title' => ['Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'feature_lists_two', 'Features List', $fields_to_include_2, [ '3' ] );

		$fields_to_include_3 = ['title' => ['Title', 'Number'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'feature_lists_three', 'Features List', $fields_to_include_3, [ '4' ] );

		
		
        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------	

		//-------List Item Style-------
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .box-title', [ '1','2','3'] );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .box-text', [ '1','2','3'] );


	}

	protected function render() {

    $settings = $this->get_settings_for_display(); 

		if( $settings['layout_style'] == '1' ){
			foreach( $settings['feature_lists'] as $data ){
				echo '<div class="choose-box">';
	                if(!empty($data['choose_icon']['url'])){
						echo '<div class="box-icon">';
							echo mediax_img_tag( array(
								'url'   => esc_url( $data['choose_icon']['url'] ),
							));
						echo '</div>';
					}
	                echo '<div class="box-content">';
	                    if(!empty($data['title'])){
							echo '<h3 class="box-title">'.wp_kses_post($data['title']).'</h3>';
						}
	                    if(!empty($data['description'])){
							echo '<p class="box-text">'.wp_kses_post($data['description']).'</p>';
						}
						if(!empty($data['number'])){
		                    echo '<div class="progress">';
		                        echo '<div class="progress-bar" style="width: '.esc_attr( $data['number'] ).'%;">';
		                            echo '<div class="progress-value">'.esc_html( $data['number'] ).'%</div>';
		                        echo '</div>';
		                    echo '</div>';
		                }
	                echo '</div>';
	                echo '<div class="box-btn">';
	                    echo '<a href="'.esc_url( $data['url']['url'] ).'"><i class="far fa-arrow-up-right"></i></a>';
	                echo '</div>';
	            echo '</div>';
	        }
		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="why-card-wrap justify-content-start">';

                foreach( $settings['feature_lists'] as $data ){        
	                echo '<div class="why-card">';
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
		}elseif( $settings['layout_style'] == '3' ){

			echo '<div class="row gy-4">';

		 		foreach( $settings['feature_lists_two'] as $data ){
					echo '<div class="col-md-6">';
		                echo '<div class="about-feature2">';
		                    echo '<div class="box-icon">';
		                       	if(!empty($data['icon']['url'])){
									echo '<div class="box-icon">';
										echo mediax_img_tag( array(
											'url'   => esc_url( $data['icon']['url'] ),
										));
									echo '</div>';
								}
		                    echo '</div>';
		                    echo '<div class="media-body">';
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
            echo '<div class="choose-feature-wrap style2">';
				foreach( $settings['feature_lists_three'] as $data ){
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
		}	
	}
}