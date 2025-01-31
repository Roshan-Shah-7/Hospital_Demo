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
    '2_content_section',
    [
        'label' 	=> __( 'Header', 'mediax' ),
        'tab' 		=> Controls_Manager::TAB_CONTENT,
        'condition'		=> [ 
            'layout_style'  => ['2','3','5'],
        ],
    ]
);
    $this->add_control(
        '2_show_top_bar',
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
        '2_topbar_phone_icon',
        [
            'label' 		=> __( 'Phone Icon', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 		=> '<i class="fa-solid fa-phone"></i>',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        '2_topbar_phone_label',
        [
            'label' 		=> __( 'Phone Label', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 		=> 'Phone:',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        '2_topbar_phone',
        [
            'label' 	=> __( 'Phone Number', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( '+163-654-3569', 'mediax' ),
            'label_block' => true,
            'separator'		=> 'after',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'], 
            ],
        ]
    );
    $this->add_control(
        '2_topbar_email_icon',
        [
            'label' 		=> __( 'Email Icon', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 		=> '<i class="fa-solid fa-envelope"></i>',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        '2_topbar_email_label',
        [
            'label' 		=> __( 'Email Label', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 		=> 'Email:',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        '2_topbar_email',
        [
            'label' 	=> __( 'Email Address', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( 'info@mediax.com', 'mediax' ),
            'label_block' => true,
            'separator'		=> 'after',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );

    $this->add_control(
        '2_show_lang_btn',
        [
            'label' 		=> __( 'Show Language?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        '2_show_whishlist_btn',
        [
            'label'         => __( 'Show Wishlist Button?', 'mediax' ),
            'type'          => Controls_Manager::SWITCHER,
            'label_on'      => __( 'Show', 'mediax' ),
            'label_off'     => __( 'Hide', 'mediax' ),
            'return_value'  => 'yes',
            'default'       => 'yes',
        ]
    );

    //Social 
    $this->add_control(
        '2_show_social',
        [
            'label' 		=> __( 'Show Social?', 'mediax' ),
            'type' 			=> Controls_Manager::SWITCHER,
            'label_on' 		=> __( 'Show', 'mediax' ),
            'label_off' 	=> __( 'Hide', 'mediax' ),
            'return_value' 	=> 'yes',
            'default' 		=> 'yes',
            'separator'		=> 'before',
            'condition'		=> [ 
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );
    $this->add_control(
        '2_social_text',
        [
            'label' 	=> __( 'Social Text', 'mediax' ),
            'type' 		=> Controls_Manager::TEXT,
            'default' 	=> __( 'Follow Us On:', 'mediax' ),
            'label_block' => true,
            'condition'		=> [ 
                '2_show_social'  => 'yes',
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );

    $repeater = new Repeater();

    $repeater->add_control(
        'social_icon',
        [
            'label' 	=> __( 'Social Icon', 'mediax' ),
            'type' 		=> Controls_Manager::ICONS,
            'default' 	=> [
                'value' 	=> 'fab fa-facebook-f',
                'library' 	=> 'solid',
            ],
        ]
    );

    $repeater->add_control(
        'icon_link',
        [
            'label' 		=> __( 'Link', 'mediax' ),
            'type' 			=> Controls_Manager::URL,
            'placeholder' 	=> __( 'https://your-link.com', 'mediax' ),
            'show_external' => true,
            'default' 		=> [
                'url' 			=> '#',
                'is_external' 	=> false,
                'nofollow' 		=> true,
            ],
        ]
    );

    $this->add_control(
        '2_social_icon_list',
        [
            'label' 		=> __( 'Social Icon', 'mediax' ),
            'type' 			=> Controls_Manager::REPEATER,
            'fields' 		=> $repeater->get_controls(),
            'default' => [
                [
                    'social_icon' => ['value' => 'fab fa-facebook-f', 'library' => 'solid'],
                    'icon_link' => ['url' => 'https://www.facebook.com', 'is_external' => false, 'nofollow' => true],
                ],
                [
                    'social_icon' => ['value' => 'fab fa-twitter', 'library' => 'solid'],
                    'icon_link' => ['url' => 'https://www.twitter.com', 'is_external' => false, 'nofollow' => true],
                ],
                [
                    'social_icon' => ['value' => 'fab fa-instagram', 'library' => 'solid'],
                    'icon_link' => ['url' => 'https://www.instagram.com', 'is_external' => false, 'nofollow' => true],
                ],
                [
                    'social_icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'solid'],
                    'icon_link' => ['url' => 'https://www.linkedin.com', 'is_external' => false, 'nofollow' => true],
                ],
                [
                    'social_icon' => ['value' => 'fab fa-pinterest-p', 'library' => 'solid'],
                    'icon_link' => ['url' => 'https://pinterest.com', 'is_external' => false, 'nofollow' => true],
                ],
            ],
            'condition'		=> [ 
                '2_show_social'  => 'yes',
                '2_show_top_bar'  => ['yes'],
            ],
        ]
    );

    $this->add_control(
        '2_logo_image',

        [
            'label' 		=> __( 'Upload Logo', 'mediax' ),
            'type' 			=> Controls_Manager::MEDIA,
        ]
    );							
    $this->add_control(
        '22_logo_image',

        [
            'label' 		=> __( 'Mobile Upload Logo', 'mediax' ),
            'type' 			=> Controls_Manager::MEDIA,
            'condition'		=> [ 
            'layout_style'  => ['5'],
        ],
        ]
    );							

    $menus = $this->mediax_menu_select();

    if( !empty( $menus ) ){
        $this->add_control(
            '2_mediax_menu_select',
            [
                'label'     	=> __( 'Select Mediax Menu', 'mediax' ),
                'type'      	=> Controls_Manager::SELECT,
                'options'   	=> $menus,
                'description' 	=> sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'mediax' ), admin_url( 'nav-menus.php' ) ),
            ]
        );
    }else {
        $this->add_control(
            '2_no_menu',
            [
                'type' 				=> Controls_Manager::RAW_HTML,
                'raw' 				=> '<strong>' . __( 'There are no menus in your site.', 'mediax' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'mediax' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                'separator' 		=> 'after',
                'content_classes' 	=> 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );
    }	

    $this->add_control(
        '2_show_search_btn',
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
        '2_show_cart_btn',
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
        '2_show_offcanvas_btn',
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
        '2_button_text',
        [
            'label' 		=> __( 'Button Text', 'mediax' ),
            'type' 			=> Controls_Manager::TEXT,
            'label_block' 	=> true,
            'default' 	=> __( 'Schedule A Pickup', 'mediax' ),
        ]
    );
    $this->add_control(
        '2_button_url',
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