<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;

$this->start_controls_section(
    '3_content_section',
    [
        'label' 	=> __( 'Header', 'mediax' ),
        'tab' 		=> Controls_Manager::TAB_CONTENT,
        'condition'		=> [ 
            'layout_style'  => ['4','6'],
        ],
    ]
    );

    $this->add_control(
        '3_logo_image',

        [
            'label' 		=> __( 'Upload Logo', 'mediax' ),
            'type' 			=> Controls_Manager::MEDIA,
        ]
    );

     $this->add_control(
        '3_logo_bg',

        [
            'label'         => __( 'Logo Bg', 'mediax' ),
            'type'          => Controls_Manager::MEDIA,
        ]
    );  							

    $menus = $this->mediax_menu_select();

    if( !empty( $menus ) ){
        $this->add_control(
            '3_mediax_menu_select',
            [
                'label'     	=> __( 'Select Mediax Menu', 'mediax' ),
                'type'      	=> Controls_Manager::SELECT,
                'options'   	=> $menus,
                'description' 	=> sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'mediax' ), admin_url( 'nav-menus.php' ) ),
            ]
        );
    }else {
        $this->add_control(
            '3_no_menu',
            [
                'type' 				=> Controls_Manager::RAW_HTML,
                'raw' 				=> '<strong>' . __( 'There are no menus in your site.', 'mediax' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'mediax' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                'separator' 		=> 'after',
                'content_classes' 	=> 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );
    }	

    $this->add_control(
        '3_show_search_btn',
        [
            'label' 		=> __( 'Show Search?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );
    $this->add_control(
        '3_show_cart_btn',
        [
            'label' 		=> __( 'Show Cart Button?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );
    $this->add_control(
        '3_show_offcanvas_btn',
        [
            'label' 		=> __( 'Show Offcanvas Button?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );
    $this->add_control(
        '3_button_text',
        [
            'label' 		=> __( 'Button Text', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 	=> __( 'Schedule A Pickup', 'mediax' ),
        ]
    );
    $this->add_control(
        '3_button_url',
        [
            'label' 		=> esc_html__( 'Button Link', 'mediax' ),
            'type' 			=> Controls_Manager::URL,
            'placeholder' 	=> esc_html__( 'https://your-link.com', 'mediax' ),
            'show_external' => true,
            'default' 		=> [
                'url' 			=> '#',
                'is_external' 	=> false,
                'nofollow' 		=> false,
            ],
        ]
    );

$this->end_controls_section();