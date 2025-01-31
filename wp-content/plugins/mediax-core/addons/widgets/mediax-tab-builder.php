<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
/**
 *
 * Tab Builder Widget .
 *
 */
class mediax_Tab_Builder extends Widget_Base {

	public function get_name() {
		return 'mediaxtabbuilder';
	}
	public function get_title() {
		return __( 'Tab Builder', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
    public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'tab_builder_section',
			[
				'label' 	=> __( 'Tab Builder', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style', ['Style One'] );


		$repeater = new Repeater();

		mediax_general_fields( $repeater, 'tab_builder_text', 'Tab Builder Title', 'TEXTAREA', 'Tab Title' );

		$repeater->add_control(
			'icon',

			[
				'label' 		=> __( 'Tab Icon', 'laun' ),
				'type' 			=> Controls_Manager::MEDIA,
			]
		);
		$repeater->add_control(
			'mediax_tab_builder_option',
			[
				'label'     => __( 'Tab Name', 'mediax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->mediax_tab_builder_choose_option(),
				'default'	=> ''
			]
		);

		$this->add_control(
			'tab_builder_repeater',
			[
				'label' 		=> __( 'Tab', 'mediax' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'tab_builder_text'    => __( 'Residential Pool Services', 'mediax' ),
					],
					
				],
				'title_field' 	=> '{{{ tab_builder_text }}}',
			]
		);

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

    }

	public function mediax_tab_builder_choose_option(){

		$mediax_post_query = new WP_Query( array(
			'post_type'				=> 'mediax_tab_builder',
			'posts_per_page'	    => -1,
		) );

		$mediax_tab_builder_title = array();
		$mediax_tab_builder_title[''] = __( 'Select a Tab','Foodelio');

		while( $mediax_post_query->have_posts() ) {
			$mediax_post_query->the_post();
			$mediax_tab_builder_title[ get_the_ID() ] =  get_the_title();
		}
		wp_reset_postdata();

		return $mediax_tab_builder_title;

	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['layout_style'] == '1' ){
			echo '<div class="choose-tab-area">';

				echo '<div class="choose-tab">';
					echo ' <div class="nav indicator-active" role="tablist">';
						$x = 0;
						foreach( $settings['tab_builder_repeater'] as $data ){
							$x++;
							$active = $x == '1' ? 'active':'';
							echo ' <button class="tab-btn '.$active.'" id="nav-one-tab'.esc_attr($x).'" data-bs-toggle="tab" data-bs-target="#nav-'.esc_attr($x).'" type="button" role="tab" aria-controls="nav-'.esc_attr($x).'" aria-selected="false"><span class="icon"><img src="'.esc_url($data['icon']['url']).'" alt="'.esc_attr__('Icon','mediax').'"></span> '.esc_html( $data['tab_builder_text'] ).'</button>';
						}
					echo '</div>';
				echo '</div>';

				echo '<div class="tab-content why-tab-content">';
					$x = 0;
					foreach( $settings['tab_builder_repeater'] as $data ){
						$x++;
						$active = $x == '1' ? 'active show':'';
						echo '<div class="tab-pane fade '.$active.'" id="nav-'.esc_attr($x).'" role="tabpanel" aria-labelledby="nav-one-tab'.esc_attr($x).'">';
							$elementor = \Elementor\Plugin::instance();
							if( ! empty( $data['mediax_tab_builder_option'] ) ){
								echo $elementor->frontend->get_builder_content_for_display( $data['mediax_tab_builder_option'] );
							}
						echo '</div>';
					}
				echo '</div>';

			echo '</div>';

		}
		

      
	}
}