<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Box_Shadow;
/**
 *
 * Faq Widget .
 *
 */
class mediax_Faq extends Widget_Base {

	public function get_name() {
		return 'mediaxfaq';
	}
	public function get_title() {
		return __( 'Faq', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'faq_section',
			[
				'label'		 	=> __( 'Faq', 'mediax' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',[ 'Style One','Style Two' ] );

		mediax_general_fields($this, 'faq_id', 'Faq ID', 'TEXT', '1' );

        $repeater = new Repeater();

		mediax_general_fields($repeater, 'faq_question', 'Faq Question', 'TEXTAREA', 'What Services Do You Offer?');
		mediax_general_fields($repeater, 'faq_answer', 'Faq Answer', 'WYSIWYG', 'We specialize in providing top-notch pool service and maintenance');

		$this->add_control(
			'faq_repeater',
			[
				'label' 		=> __( 'Faq Lists', 'mediax' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'faq_question'    => __( 'What Services Do You Offer?', 'mediax' ),
					],

				],
			]
		);

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//--------------------------------------- 

		//------Menu Bar Style-------
        $this->start_controls_section(
			'faq_styling',
			[
				'label'     => __( 'Faq Styling', 'mediax' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );

		
		// mediax_general_fields( $this, 'hr3', 'Background Style', 'HEADING', '' );
		// mediax_color_fields( $this, 'bg_color2', 'Background', 'background-color', '{{WRAPPER}} .accordion-card' );
		// mediax_color_fields( $this, 'bg_color22', 'Active Background', 'background-color', '{{WRAPPER}} .accordion-card.active' );

		mediax_general_fields( $this, 'hr', 'Question Style', 'HEADING', '' );
		mediax_color_fields( $this, 'title_color', 'Color', 'color', '{{WRAPPER}} .accordion-button' );
		mediax_typography_fields( $this, 'title_font', 'Trpography', '{{WRAPPER}} .accordion-button' );
		mediax_general_fields( $this, 'hr2', 'Answer Style', 'HEADING', '' );
		mediax_color_fields( $this, 'contnet_color', 'Color', 'color', '{{WRAPPER}} .accordion-body' );
		mediax_typography_fields( $this, 'contnet_font', 'Trpography', '{{WRAPPER}} .accordion-body' );

		$this->end_controls_section();


	}

	protected function render() {

	$settings = $this->get_settings_for_display();

	
		if($settings['layout_style'] == '1'){
			$style = '';
			$wrper_style = '';
		}elseif($settings['layout_style'] == '2'){
			$style = 'style2';
			$wrper_style = 'accordion-area3';
		}
		echo '<div class="accordion '.esc_attr( $wrper_style ).'" id="faqAccordion'.esc_attr($settings['faq_id']).'">';
				$x = 0;
				foreach( $settings['faq_repeater'] as $single_data ){
					$unique_id = uniqid();
					$x++;
					if( $x == '1' ){
						$ariaexpanded 	= 'true';
						$class 			= 'show';
						$collesed 		= '';
						$is_active 		= 'active';
					}else{
						$ariaexpanded 	= 'false';
						$class 			= '';
						$collesed 		= 'collapsed';
						$is_active 		= '';
					}

				echo '<div class="accordion-card '.esc_attr( $is_active . ' ' . $style ).'">';
					echo '<div class="accordion-header" id="collapse-item-'.esc_attr( $unique_id ).'">';
						echo '<button class="accordion-button '.esc_attr( $collesed ).'" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-'.esc_attr( $unique_id ).'" aria-expanded="'.esc_attr( $ariaexpanded ).'" aria-controls="collapse-'.esc_attr( $unique_id ).'">'.wp_kses_post($single_data['faq_question']).'</button>';
					echo '</div>';

					echo '<div id="collapse-'.esc_attr( $unique_id ).'" class="accordion-collapse collapse '.esc_attr( $class ).'" aria-labelledby="collapse-item-'.esc_attr( $unique_id ).'" data-bs-parent="#faqAccordion'.esc_attr($settings['faq_id']).'">';
						echo '<div class="accordion-body">';
							echo wp_kses_post($single_data['faq_answer']);
						echo '</div>';
					echo '</div>';
				echo '</div>';
				}
		echo '</div>';
	}
}