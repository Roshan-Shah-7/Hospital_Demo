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
 * Menu Select Widget .
 *
 */
class Mediax_Menu extends Widget_Base {

	public function get_name() {
		return 'mediaxmenuselect';
	}
	public function get_title() {
		return __( 'Menu Select', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		 $this->start_controls_section(
			'section_title_section',
			[
				'label'		 	=> __( 'Navigation Menu', 'mediax' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
        );

		mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two', 'Style Three'] );

		mediax_general_fields( $this, 'title', 'Title', 'TEXT', 'Title', ['3'] );

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

        $this->end_controls_section();

        //---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Title Style-------
		mediax_common_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .widget_title', ['3'] );


	}

    public function mediax_menu_select(){ 
	    $mediax_menu = wp_get_nav_menus();
	    $menu_array  = array();
		$menu_array[''] = __( 'Select A Menu', 'mediax' );
	    foreach( $mediax_menu as $menu ){
	        $menu_array[ $menu->slug ] = $menu->name;
	    }
	    return $menu_array;
	}

	protected function render() {

	$settings = $this->get_settings_for_display();

        //Menu by menu select
        $mediax_avaiable_menu   = $this->mediax_menu_select();

        if( ! $mediax_avaiable_menu ){
            return;
        }
		if( $settings['layout_style'] == '3' ){
			$args = [
				'menu' 		=> $settings['mediax_menu_select'],
				'menu_class' 	=> 'menu style2',
				'container' 	=> '',
			];
		}else{
			$args = [
				'menu' 		=> $settings['mediax_menu_select'],
				'menu_class' 	=> 'menu',
				'container' 	=> '',
			];
		}

		if( $settings['layout_style'] == '1' ){
			if( ! empty( $settings['mediax_menu_select'] ) ){
                wp_nav_menu( $args );
            } 

		}elseif( $settings['layout_style'] == '2' ){
			echo '<div class="footer-links">';
				if( ! empty( $settings['mediax_menu_select'] ) ){
					wp_nav_menu( $args );
				} 
			echo '</div>';

		}elseif( $settings['layout_style'] == '3' ){
			echo '<div class="widget widget_nav_menu footer-widget">';
				if( !empty($settings['title']) ){
					echo '<h3 class="widget_title">'.esc_html($settings['title']).'</h3>';
				}
				echo '<div class="menu-all-pages-container">';
						if( ! empty( $settings['mediax_menu_select'] ) ){
							wp_nav_menu( $args );
						} 
				echo '</div>';
            echo '</div>';
		}


	}

}