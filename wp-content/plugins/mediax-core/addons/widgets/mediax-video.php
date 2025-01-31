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
 * Video Widget .
 *
 */
class mediax_Video extends Widget_Base {

	public function get_name() {
		return 'mediaxvideo';
	}
	public function get_title() {
		return __( 'Video Box', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'video_section',
			[
				'label' 	=> __( 'video Box', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', [ 'Style One', 'Style Two', 'Style Three','Style Four' ] ); 

		mediax_media_fields( $this, 'image', 'Choose Image' );
		mediax_url_fields( $this, 'video_url', 'Video URL' );
		mediax_general_fields( $this, 'desc', 'Description', 'TEXTAREA', '', ['2','4'] );
		mediax_general_fields( $this, 'content1', 'Content 1', 'TEXTAREA3', '', '2' );
		mediax_general_fields( $this, 'content2', 'Content 2', 'TEXTAREA3', '', '2' );

		$this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------
	
	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="th-video">';
				echo mediax_img_tag( array(
					'url'   => esc_url( $settings['image']['url'] ),
				));
				if(!empty($settings['video_url']['url'])){
					echo '<a href="'.esc_url( $settings['video_url']['url'] ).'" class="play-btn popup-video"><i class="fas fa-play"></i></a>';
				}
			echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="about-video-wrap">';
				if(!empty($settings['image']['url'])){
					echo '<div class="th-video about-video">';
						echo mediax_img_tag( array(
							'url'   => esc_url( $settings['image']['url'] ),
						));
						if(!empty($settings['video_url']['url'])){
							echo '<a href="'.esc_url( $settings['video_url']['url'] ).'" class="play-btn popup-video"><i class="fas fa-play"></i></a>';
						}
					echo '</div>';
				}
				echo '<div class="box-content">';
					if(!empty( $settings['desc'] )){
						echo '<p class="box-text">'.wp_kses_post($settings['desc']).'</p>';
					}
					echo '<div class="about-contact-wrap">';
						if(!empty( $settings['content1'] )){
							echo '<div class="about-contact">';
								echo wp_kses_post($settings['content1']);
							echo '</div>';
						}
						if(!empty( $settings['content2'] )){
							echo '<div class="about-contact">';
								echo wp_kses_post($settings['content2']);
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}elseif( $settings['layout_style'] == '4' ){

			echo '<div class="row gy-4 align-items-center">';
				if(!empty($settings['image']['url'])){
	                echo '<div class="col-md-5">';
	                    echo '<div class="video-box2">';
	                        echo mediax_img_tag( array(
								'url'   => esc_url( $settings['image']['url'] ),
							));
							if(!empty($settings['video_url']['url'])){
	                        	echo '<a href="'.esc_url( $settings['video_url']['url'] ).'" class="play-btn popup-video"><i class="fa-sharp fa-solid fa-play"></i></a>';
	                        }
	                    echo '</div>';
	                echo '</div>';
                }
                echo '<div class="col-md-7">';
                    echo '<p class="mb-n2">'.wp_kses_post($settings['desc']).'</p>';
                echo '</div>';
            echo '</div>';

		}else{
			echo '<div class="th-video why-video1">';
                echo '<img class="w-100" src="'.esc_url( $settings['image']['url'] ).'" alt="video">';
                echo '<a href="'.esc_url( $settings['video_url']['url'] ).'" class="play-btn popup-video"><i class="fas fa-play"></i></a>';
            echo '</div>';
		}


	}

}