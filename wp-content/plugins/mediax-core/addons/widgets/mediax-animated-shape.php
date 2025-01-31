<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
/**
 *
 * Image Widget .
 *
 */
class mediax_Animated_Shape extends Widget_Base {

	public function get_name() {
		return 'mediaxshapeimage';
	}
	public function get_title() {
		return __( 'Animated Image', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'image_section',
			[
				'label' 	=> __( 'Image', 'mediax' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'image',
			[
				'label' 		=> __( 'Choose Image', 'mediax' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'effect_style',
			[
				'label' 		=> esc_html__( 'Add Styling Attributes', 'mediax' ),
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
					'jump'  			=> esc_html__( 'Jumping Effect', 'mediax' ),
					'jump-reverse'  	=> esc_html__( 'Jumping Reverse Effect', 'mediax' ),
					'movingX'  			=> esc_html__( 'Moving Effect', 'mediax' ),
					'movingTopRight'  			=> esc_html__( 'Moving Top Right Effect', 'mediax' ),
					'movingBottomLeft'  			=> esc_html__( 'Moving Bottom Left Effect', 'mediax' ),
					'moving-reverse'	=> esc_html__( 'Moving Reverse Effect', 'mediax' ),
					'rotate-x'			=> esc_html__( 'Rotate Effect', 'mediax' ),
					'spin'			=> esc_html__( 'Spin Effect', 'mediax' ),
					'spin-slow'			=> esc_html__( 'Spin Slow Effect', 'mediax' ),
					'ripple-animation'			=> esc_html__( 'Ripple Animation Effect', 'mediax' ),
					''			=> esc_html__( 'No Effect', 'mediax' ),
				],
				'default' => [ 'jump'],
			]
		);

		$this->add_control(
			'from_top',
			[
				'label' 		=> __( 'Top', 'mediax' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

		$this->add_control(
			'from_left',
			[
				'label' 		=> __( 'Left', 'mediax' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> '%',
				'range' 		=> [
					'%' 			=> [
						'min' 			=> 0,
						'max' 			=> 100,
					],
				],
			]
		);

		$this->add_control(
			'from_right',
			[
				'label' 		=> __( 'Right', 'mediax' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> '%',
				'range' 		=> [
					'%' 			=> [
						'min' 			=> 0,
						'max' 			=> 100,
					],
				],
			]
		);

		$this->add_control(
			'from_bottom',
			[
				'label' 		=> __( 'Bottom', 'mediax' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> '%',
				'range' 		=> [
					'%' 			=> [
						'min' 			=> 0,
						'max' 			=> 100,
					],
				],
			]
		);

		$this->add_control(
			'responsive_style',
			[
				'label' 		=> esc_html__( 'Responsive Styling', 'mediax' ),
				'type' 			=> \Elementor\Controls_Manager::SELECT2,
				'multiple' 		=> true,
				'options' 		=> [
					'd-xxl-block'  		=> esc_html__( 'Hide From Extra large Device', 'mediax' ),
					'd-xl-block'  		=> esc_html__( 'Hide From large Device', 'mediax' ),
					'd-lg-block'  		=> esc_html__( 'Hide From Tablet', 'mediax' ),
					'd-md-block'  		=> esc_html__( 'Hide From Mobile', 'mediax' ),
					'd-sm-block'  		=> esc_html__( 'D SM Block', 'mediax' ),
					'd-none'  			=> esc_html__( 'Display None', 'mediax' ),
					' '  				=> esc_html__( 'Default', 'mediax' ),
				],
			]
		);

		$this->add_control(
			'image_class', [
				'label' 		=> __( 'Image Class Name', 'mediax' ),
				'description' 		=> __( 'Class name for image size control', 'mediax' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'rows' 			=> 2,
				'label_block' 	=> true,
			]
        );

        $this->end_controls_section();
	}

	protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper','class','shape-mockup');
        $this->add_render_attribute('wrapper','class', $settings['image_class']);
        $this->add_render_attribute('wrapper','class', $settings['effect_style']);
        $this->add_render_attribute('wrapper','class', $settings['responsive_style']);

        if($settings['from_bottom']['size']){
	        $this->add_render_attribute( 'wrapper', 'data-bottom', $settings['from_bottom']['size'] .'%' );
	    }
	    if($settings['from_top']['size']){
	        $this->add_render_attribute( 'wrapper', 'data-top', $settings['from_top']['size'] .'%' );
	    }
	    if($settings['from_right']['size']){
	        $this->add_render_attribute( 'wrapper', 'data-right', $settings['from_right']['size'] .'%' );
	    }
	    if($settings['from_left']['size']){
	        $this->add_render_attribute( 'wrapper', 'data-left', $settings['from_left']['size'] .'%' );
	    }

        
            echo '<!-- Image -->';
                echo '<div '.$this->get_render_attribute_string('wrapper').'>';
                	if( !empty( $settings['image']['id'] ) ) {
						echo '<img src="'.esc_url( $settings['image']['url']).'" alt="'.esc_html( get_bloginfo('name') ).'" >';
					
					}else{
			        	echo '<div class="dna-ani">';
			                echo '<span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>';
			            echo '</div>';
			        }
                echo '</div>';
            echo '<!-- End Image -->';
        
		
	}
}