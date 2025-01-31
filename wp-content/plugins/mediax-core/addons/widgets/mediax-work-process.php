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
 * WorkProcess Widget .
 *
 */
class Mediax_WorkProcess extends Widget_Base {

	public function get_name() {
		return 'mediax-workprocess';
	}
	public function get_title() {
		return __( 'WorkProcess', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'workprocess_section',
			[
				'label' 	=> __( 'WorkProcess', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One'] ); 

		$fields_to_include = [ 'image' => ['Image One', 'Image Two', 'Image Three'],'title' => ['Title'], 'title' => ['Title','Number'], 'desc' => ['Description']];
		mediax_repeater_fields( $this, 'process_list', 'Process Lists', $fields_to_include, ['1'] );


		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------
	
	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){

			echo '<div class="process-box-wrap">';
				foreach( $settings['process_list'] as $key => $data ){
	                echo '<div class="process-box">';
	                    echo '<div class="img-wrap" data-bg-src="'.esc_url( $data['image_one']['url'] ).'">';
	                        echo '<div class="box-img" data-mask-src="'.esc_url( $data['image_two']['url'] ).'">';
	                           	echo mediax_img_tag( array(
									'url'   => esc_url( $data['image_three']['url'] ),
								));
	                            echo '<p class="box-number">'.esc_html($data['number']).'</p>';
	                        echo '</div>';
	                    echo '</div>';
	                    echo '<h3 class="box-title">'.esc_html($data['title']).'</h3>';
	                    echo '<p class="box-text">'.esc_html($data['description']).'</p>';
	                echo '</div>';
                }
            echo '</div>';

		}

	}

}