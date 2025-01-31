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
 * Team Info Widget
 *
 */
class mediax_Team_info extends Widget_Base{

	public function get_name() {
		return 'mediaxteaminfo';
	}
	public function get_title() {
		return esc_html__( 'Team Member Info', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'team_member_content',
			[
				'label'		=> esc_html__( 'Member Info','mediax' ),
				'tab'		=> Controls_Manager::TAB_CONTENT,
			]
		);

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One'] );

		mediax_media_fields( $this, 'image', 'Choose Image' );
		mediax_general_fields($this, 'name', 'Member Name', 'TEXT', 'Jonson Anderson');
		mediax_general_fields($this, 'designation', 'Designation', 'TEXT', 'Designation');
		mediax_general_fields($this, 'desc', 'Description', 'TEXTAREA', ''); 

		//Info lists
		mediax_general_fields($this, 'title', 'Info Title', 'TEXT', 'Personal Information');
		$fields_to_include = [ 'title' => ['Icon'], 'desc' => ['Content'] ];
		mediax_repeater_fields( $this, 'info_lists', 'Info Lists', $fields_to_include );

		mediax_social_fields($this, 'social_icon_list', 'Social Media');

		$this->end_controls_section();


        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Name Style-------
		mediax_common_style_fields( $this, 'name', 'Name', '{{WRAPPER}} .name' );
		//-------Designation Style-------
		mediax_common_style_fields( $this, 'designation', 'Designation', '{{WRAPPER}} .box-desig' );
		//-------Description Style-------
		mediax_common_style_fields( $this, 'desc', 'Description', '{{WRAPPER}} .box-text' );
		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .title' );


	}

	protected function render() {

	$settings = $this->get_settings_for_display(); 

		if( $settings['layout_style'] == '1' ){
			echo '<div class="team-sticky">';
				echo '<div class="about-box mb-40">';
					if(!empty($settings['image']['url'])){
						echo '<div class="box-img">';
							echo mediax_img_tag( array(
								'url'   => esc_url( $settings['image']['url'] ),
							));
						echo '</div>';
					}
					echo '<div class="box-content">';
						if(!empty($settings['name'])){
							echo '<h3 class="box-title name">'.esc_html($settings['name']).'</h3>';
						}
						if(!empty($settings['designation'])){
							echo '<p class="box-desig">'.esc_html($settings['designation']).'</p>';
						}
						if(!empty($settings['desc'])){
							echo '<p class="box-text">'.wp_kses_post($settings['desc']).'</p>';
						}
					echo '</div>';
				echo '</div>';
				echo '<div class="about-box">';
					echo '<div class="box-content">';
						if(!empty($settings['title'])){
							echo '<h3 class="box-title title">'.esc_html($settings['title']).'</h3>';
						}
						foreach( $settings['info_lists'] as $data ){
							echo '<p class="box-link">';
								echo '<span class="icon-btn">'.wp_kses_post($data['icon']).'</span>';
								echo wp_kses_post($data['content']);
							echo '</p>';
						}
						echo '<div class="th-social">';
							foreach( $settings['social_icon_list'] as $social_icon ){
								$social_target    = $social_icon['icon_link']['is_external'] ? ' target="_blank"' : '';
								$social_nofollow  = $social_icon['icon_link']['nofollow'] ? ' rel="nofollow"' : '';

								echo '<a '.wp_kses_post( $social_target.$social_nofollow ).' href="'.esc_url( $social_icon['icon_link']['url'] ).'">';

								\Elementor\Icons_Manager::render_icon( $social_icon['social_icon'], [ 'aria-hidden' => 'true' ] );

								echo '</a> ';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}
		
		
	}
}