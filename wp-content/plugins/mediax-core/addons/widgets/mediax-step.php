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
 * Step Widget .
 *
 */
class mediax_Step extends Widget_Base {

	public function get_name() {
		return 'mediaxstep';
	}
	public function get_title() {
		return __( 'Step/Process', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		 $this->start_controls_section(
			'section_title_section',
			[
				'label'		 	=> __( 'Steps', 'mediax' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One','Style Two' ] );

		mediax_media_fields( $this, 'shape', 'Choose Shape', [ '2' ] );
		mediax_media_fields( $this, 'shape2', 'Choose Shape 2', [ '2' ] );

		$fields_to_include = [ 'image' => ['Choose Icon'], 'title' => ['Number', 'Title'], 'desc' => ['Description'] ];
		mediax_repeater_fields( $this, 'process_list', 'Process Lists', $fields_to_include, ['1', '2'] );


        $this->end_controls_section();


        //---------------------------------------
			//Style Section Start
		//---------------------------------------
		
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title' );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .desc' );

	}

	protected function render() {

	$settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="process-card-wrap">';
				foreach( $settings['process_list'] as $key => $data ){
					echo '<div class="process-card">';
						echo '<div class="box-img">';
							if(!empty($data['choose_icon']['url'])){
								echo '<div class="img">';
									echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
								echo '</div>';
							}
							if(!empty($data['number'])){
								echo '<p class="box-number">'.esc_html($data['number']).'</p>';
							}
						echo '</div>';
						if(!empty($data['title'])){
							echo '<h3 class="box-title title">'.esc_html($data['title']).'</h3>';
						}
						if(!empty($data['description'])){
							echo '<p class="box-text desc">'.esc_html($data['description']).'</p>';
						}
					echo '</div>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="process-box-wrap">';
				$x = 0;
				foreach( $settings['process_list'] as $data ){
					$x++;
                    $k = str_pad($x, 2, '0', STR_PAD_LEFT); 
	                echo '<div class="process-box">';
	                	if(!empty($data['choose_icon']['url'])){
		                    echo '<div class="img-wrap" data-bg-src="'.esc_url( $settings['shape']['url'] ).'">';
		                        echo '<div class="box-img" data-mask-src="'.esc_url( $settings['shape2']['url'] ).'">';
		                            echo mediax_img_tag( array(
										'url'   => esc_url( $data['choose_icon']['url'] ),
									));
		                            echo '<p class="box-number">'.esc_html( $k ).'</p>';
		                        echo '</div>';
		                    echo '</div>';
		                }
	                    if(!empty($data['title'])){
							echo '<h3 class="box-title">'.esc_html($data['title']).'</h3>';
						}
	                    if(!empty($data['description'])){
							echo '<p class="box-text">'.esc_html($data['description']).'</p>';
						}
	                echo '</div>';
	            }
                
            echo '</div>';
		}
	

	}

}