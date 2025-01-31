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
    'content_section',
    [
        'label' 	=> __( 'Header', 'mediax' ),
        'tab' 		=> Controls_Manager::TAB_CONTENT,
        'condition'		=> [ 
            'layout_style'  => ['1'],
        ],
    ]
);
    $this->add_control(
        'show_top_bar',
        [
            'label' 		=> __( 'Show Top Bar?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );
    $this->add_control(
        'show_search_btn',
        [
            'label' 		=> __( 'Show Search Button?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );
    $this->add_control(
        'search_placeholder_text',
        [
            'label' 	=> __( 'Placeholder Text', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( 'Search Here...', 'mediax' ),
            'label_block' => true,
            'condition'		=> [ 
                'show_top_bar'  => ['yes'],
                'show_search_btn'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        'topbar_phone_icon',
        [
            'label' 		=> __( 'Phone Icon', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 		=> '<i class="fa-solid fa-phone"></i>',
            'condition'		=> [ 
                'show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        'topbar_phone_label',
        [
            'label' 	=> __( 'Phone Label', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( 'Phone:', 'mediax' ),
            'label_block' => true,
            'condition'		=> [ 
                'show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        'topbar_phone',
        [
            'label' 	=> __( 'Phone Number', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( '+163-654-3569', 'mediax' ),
            'label_block' => true,
            'separator'		=> 'after',
            'condition'		=> [ 
                'show_top_bar'  => ['yes'], 
            ],
        ]
    );

    $this->add_control(
        'topbar_office_icon',
        [
            'label' 		=> __( 'Office Iocn', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 		=> '<i class="fa-solid fa-clock"></i>',
            'condition'		=> [ 
                'show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        'topbar_office_label',
        [
            'label' 	=> __( 'Office Label', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( 'Opening Hours:', 'mediax' ),
            'label_block' => true,
            'condition'		=> [ 
                'show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        'topbar_office',
        [
            'label' 	=> __( 'Office', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( '27/7 Hours Open' ),
            'label_block' => true,
            'separator'		=> 'after',
            'condition'		=> [ 
                'show_top_bar'  => ['yes'],
            ],
        ]
    );

    $this->add_control(
        'logo_image',

        [
            'label' 		=> __( 'Upload Black Logo', 'mediax' ),
            'type' 			=> Controls_Manager::MEDIA,
        ]
    );				
    $this->add_control(
        'logo_image2',

        [
            'label' 		=> __( 'Upload White Logo', 'mediax' ),
            'type' 			=> Controls_Manager::MEDIA,
        ]
    );				

    $menus = $this->mediax_menu_select();

    if( !empty( $menus ) ){
        $this->add_control(
            'mediax_menu_select',
            [
                'label'     	=> __( 'Select Mediax Menu', 'mediax' ),
                'type'      	=> Controls_Manager::SELECT,
                'options'   	=> $menus,
                'description' 	=> sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'mediax' ), admin_url( 'nav-menus.php' ) ),
            ]
        );
    }else {
        $this->add_control(
            'no_menu',
            [
                'type' 				=> Controls_Manager::RAW_HTML,
                'raw' 				=> '<strong>' . __( 'There are no menus in your site.', 'mediax' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'mediax' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                'separator' 		=> 'after',
                'content_classes' 	=> 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );
    }	

    $this->add_control(
        'show_lang_btn',
        [
            'label' 		=> __( 'Show Language?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );
    $this->add_control(
        'show_cart_btn',
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
        'show_whishlist_btn',
        [
            'label' 		=> __( 'Show Wishlist Button?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );
    $this->add_control(
        'show_offcanvas_btn',
        [
            'label' 		=> __( 'Show Offcanvas Button?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
        ]
    );


$this->end_controls_section();