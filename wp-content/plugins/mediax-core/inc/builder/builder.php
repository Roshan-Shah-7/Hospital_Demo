<?php
    /**
     * Class For Builder
     */
    class MediaxBuilder{

        function __construct(){
            // register admin menus
        	add_action( 'admin_menu', [$this, 'register_settings_menus'] );

            // Custom Footer Builder With Post Type
			add_action( 'init',[ $this,'post_type' ],0 );

 		    add_action( 'elementor/frontend/after_enqueue_scripts', [ $this,'widget_scripts'] );

			add_filter( 'single_template', [ $this, 'load_canvas_template' ] );

            add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ $this,'mediax_add_elementor_page_settings_controls' ],10,2 );

		}

		public function widget_scripts( ) {
			wp_enqueue_script( 'mediax-core',MEDIAX_PLUGDIRURI.'assets/js/mediax-core.js',array( 'jquery' ),'1.0',true );
		}


        public function mediax_add_elementor_page_settings_controls( \Elementor\Core\DocumentTypes\Page $page ){

			$page->start_controls_section(
                'mediax_header_option',
                [
                    'label'     => __( 'Header Option', 'mediax' ),
                    'tab'       => \Elementor\Controls_Manager::TAB_SETTINGS,
                ]
            );


            $page->add_control(
                'mediax_header_style',
                [
                    'label'     => __( 'Header Option', 'mediax' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => [
    					'prebuilt'             => __( 'Pre Built', 'mediax' ),
    					'header_builder'       => __( 'Header Builder', 'mediax' ),
    				],
                    'default'   => 'prebuilt',
                ]
			);

            $page->add_control(
                'mediax_header_builder_option',
                [
                    'label'     => __( 'Header Name', 'mediax' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => $this->mediax_header_choose_option(),
                    'condition' => [ 'mediax_header_style' => 'header_builder'],
                    'default'	=> ''
                ]
            );

            $page->end_controls_section();

            $page->start_controls_section(
                'mediax_footer_option',
                [
                    'label'     => __( 'Footer Option', 'mediax' ),
                    'tab'       => \Elementor\Controls_Manager::TAB_SETTINGS,
                ]
            );
            $page->add_control(
    			'mediax_footer_choice',
    			[
    				'label'         => __( 'Enable Footer?', 'mediax' ),
    				'type'          => \Elementor\Controls_Manager::SWITCHER,
    				'label_on'      => __( 'Yes', 'mediax' ),
    				'label_off'     => __( 'No', 'mediax' ),
    				'return_value'  => 'yes',
    				'default'       => 'yes',
    			]
    		);
            $page->add_control(
                'mediax_footer_style',
                [
                    'label'     => __( 'Footer Style', 'mediax' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => [
    					'prebuilt'             => __( 'Pre Built', 'mediax' ),
    					'footer_builder'       => __( 'Footer Builder', 'mediax' ),
    				],
                    'default'   => 'prebuilt',
                    'condition' => [ 'mediax_footer_choice' => 'yes' ],
                ]
            );
            $page->add_control(
                'mediax_footer_builder_option',
                [
                    'label'     => __( 'Footer Name', 'mediax' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => $this->mediax_footer_build_choose_option(),
                    'condition' => [ 'mediax_footer_style' => 'footer_builder','mediax_footer_choice' => 'yes' ],
                    'default'	=> ''
                ]
            );

			$page->end_controls_section();

        }

		public function register_settings_menus(){
			add_menu_page(
				esc_html__( 'Mediax Builder', 'mediax' ),
            	esc_html__( 'Mediax Builder', 'mediax' ),
				'manage_options',
				'mediax',
				[$this,'register_settings_contents__settings'],
				'dashicons-admin-site',
				2
			);

			add_submenu_page('mediax', esc_html__('Footer Builder', 'mediax'), esc_html__('Footer Builder', 'mediax'), 'manage_options', 'edit.php?post_type=mediax_footerbuild');
			add_submenu_page('mediax', esc_html__('Header Builder', 'mediax'), esc_html__('Header Builder', 'mediax'), 'manage_options', 'edit.php?post_type=mediax_header');
			add_submenu_page('mediax', esc_html__('Tab Builder', 'mediax'), esc_html__('Tab Builder', 'mediax'), 'manage_options', 'edit.php?post_type=mediax_tab_builder');
		}

		// Callback Function
		public function register_settings_contents__settings(){
            echo '<h2>';
			    echo esc_html__( 'Welcome To Header And Footer Builder Of This Theme','mediax' );
            echo '</h2>';
		}

		public function post_type() {

			$labels = array(
				'name'               => __( 'Footer', 'mediax' ),
				'singular_name'      => __( 'Footer', 'mediax' ),
				'menu_name'          => __( 'Mediax Footer Builder', 'mediax' ),
				'name_admin_bar'     => __( 'Footer', 'mediax' ),
				'add_new'            => __( 'Add New', 'mediax' ),
				'add_new_item'       => __( 'Add New Footer', 'mediax' ),
				'new_item'           => __( 'New Footer', 'mediax' ),
				'edit_item'          => __( 'Edit Footer', 'mediax' ),
				'view_item'          => __( 'View Footer', 'mediax' ),
				'all_items'          => __( 'All Footer', 'mediax' ),
				'search_items'       => __( 'Search Footer', 'mediax' ),
				'parent_item_colon'  => __( 'Parent Footer:', 'mediax' ),
				'not_found'          => __( 'No Footer found.', 'mediax' ),
				'not_found_in_trash' => __( 'No Footer found in Trash.', 'mediax' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'elementor' ),
			);

			register_post_type( 'mediax_footerbuild', $args );

			$labels = array(
				'name'               => __( 'Header', 'mediax' ),
				'singular_name'      => __( 'Header', 'mediax' ),
				'menu_name'          => __( 'Mediax Header Builder', 'mediax' ),
				'name_admin_bar'     => __( 'Header', 'mediax' ),
				'add_new'            => __( 'Add New', 'mediax' ),
				'add_new_item'       => __( 'Add New Header', 'mediax' ),
				'new_item'           => __( 'New Header', 'mediax' ),
				'edit_item'          => __( 'Edit Header', 'mediax' ),
				'view_item'          => __( 'View Header', 'mediax' ),
				'all_items'          => __( 'All Header', 'mediax' ),
				'search_items'       => __( 'Search Header', 'mediax' ),
				'parent_item_colon'  => __( 'Parent Header:', 'mediax' ),
				'not_found'          => __( 'No Header found.', 'mediax' ),
				'not_found_in_trash' => __( 'No Header found in Trash.', 'mediax' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'elementor' ),
			);

			register_post_type( 'mediax_header', $args );

			$labels = array(
				'name'               => __( 'Tab Builder', 'mediax' ),
				'singular_name'      => __( 'Tab Builder', 'mediax' ),
				'menu_name'          => __( 'Gesund Tab Builder', 'mediax' ),
				'name_admin_bar'     => __( 'Tab Builder', 'mediax' ),
				'add_new'            => __( 'Add New', 'mediax' ),
				'add_new_item'       => __( 'Add New Tab Builder', 'mediax' ),
				'new_item'           => __( 'New Tab Builder', 'mediax' ),
				'edit_item'          => __( 'Edit Tab Builder', 'mediax' ),
				'view_item'          => __( 'View Tab Builder', 'mediax' ),
				'all_items'          => __( 'All Tab Builder', 'mediax' ),
				'search_items'       => __( 'Search Tab Builder', 'mediax' ),
				'parent_item_colon'  => __( 'Parent Tab Builder:', 'mediax' ),
				'not_found'          => __( 'No Tab Builder found.', 'mediax' ),
				'not_found_in_trash' => __( 'No Tab Builder found in Trash.', 'mediax' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'elementor' ),
			);

			register_post_type( 'mediax_tab_builder', $args );
		}

		function load_canvas_template( $single_template ) {

			global $post;

			if ( 'mediax_footerbuild' == $post->post_type || 'mediax_header' == $post->post_type || 'mediax_tab_build' == $post->post_type ) {

				$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

				if ( file_exists( $elementor_2_0_canvas ) ) {
					return $elementor_2_0_canvas;
				} else {
					return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
				}
			}

			return $single_template;
		}

        public function mediax_footer_build_choose_option(){

			$mediax_post_query = new WP_Query( array(
				'post_type'			=> 'mediax_footerbuild',
				'posts_per_page'	    => -1,
			) );

			$mediax_builder_post_title = array();
			$mediax_builder_post_title[''] = __('Select a Footer','mediax');

			while( $mediax_post_query->have_posts() ) {
				$mediax_post_query->the_post();
				$mediax_builder_post_title[ get_the_ID() ] =  get_the_title();
			}
			wp_reset_postdata();

			return $mediax_builder_post_title;

		}

		public function mediax_header_choose_option(){

			$mediax_post_query = new WP_Query( array(
				'post_type'			=> 'mediax_header',
				'posts_per_page'	    => -1,
			) );

			$mediax_builder_post_title = array();
			$mediax_builder_post_title[''] = __('Select a Header','mediax');

			while( $mediax_post_query->have_posts() ) {
				$mediax_post_query->the_post();
				$mediax_builder_post_title[ get_the_ID() ] =  get_the_title();
			}
			wp_reset_postdata();

			return $mediax_builder_post_title;

        }

    }

    $builder_execute = new MediaxBuilder();