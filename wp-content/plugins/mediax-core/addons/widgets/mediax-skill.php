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
 * Skill Widget .
 *
 */
class mediax_Skill extends Widget_Base {

	public function get_name() {
		return 'mediaxskill';
	}
	public function get_title() {
		return __( 'Skill Bar', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

        $this->start_controls_section(
                'skill_bar_section',
                    [
                        'label' 	=> __( 'Skill Bar', 'mediax' ),
                        'tab' 		=> Controls_Manager::TAB_CONTENT,
                    ]
        );

        mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two'] );


        $repeater = new Repeater();

        mediax_general_fields($repeater, 'skill_title', 'Title', 'TEXT', 'Equipment Installation');
        mediax_general_fields($repeater, 'skill_num', 'Number', 'TEXT', '90');

        $this->add_control(
            'skill_lists',
            [
                'label' 		=> __( 'Skill Lists', 'mediax' ),
                'type' 			=> Controls_Manager::REPEATER,
                'fields' 		=> $repeater->get_controls(),
                'default' 		=> [
                        [
                            'skill_title' 		=> __( 'Title', 'mediax' ),
                        ],
                ],
            ]
        );

        $this->end_controls_section();

    //---------------------------------------
        //Style Section Start
    //---------------------------------------

    //-------Title/Number Style-------
    mediax_common_style_fields($this, 'title', 'Title', '{{WRAPPER}} .skill-feature_title');
    mediax_common_style_fields($this, 'title2', 'Number', '{{WRAPPER}} .progress-value');


	}

	protected function render() {

    $settings = $this->get_settings_for_display();

        if( $settings['layout_style'] == '1' ){
            foreach( $settings['skill_lists'] as $data ){
                echo '<div class="skill-feature">';
                    if(!empty($data['skill_title'])){
                        echo '<h5 class="skill-feature_title">'.esc_html($data['skill_title']).'</h5>';
                    }
                    echo '<div class="progress">';
                        echo '<div class="progress-value">'.esc_attr($data['skill_num']).'%</div>';
                        echo '<div class="progress-bar" style="width: '.esc_attr($data['skill_num']).'%;">';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }

        }elseif( $settings['layout_style'] == '2' ){
            foreach( $settings['skill_lists'] as $data ){
                echo '<div class="skill-feature">';
                    if(!empty($data['skill_title'])){
                        echo '<h5 class="skill-feature_title">'.esc_html($data['skill_title']).'</h5>';
                    }
                    echo '<div class="progress">';
                        echo '<div class="progress-value">'.esc_attr($data['skill_num']).'%</div>';
                        echo '<div class="progress-bar  bg-theme2" style="width: '.esc_attr($data['skill_num']).'%;">';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }

        }


	}

}