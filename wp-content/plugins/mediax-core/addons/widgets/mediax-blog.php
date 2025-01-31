<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Utils;
/**
 *
 * Blog Post Widget .
 *
 */
class mediax_Blog extends Widget_Base {

	public function get_name() {
		return 'mediaxblog';
	}
	public function get_title() {
		return __( 'Blog Post', 'mediax' );
	}
	public function get_icon() {
		return 'th-icon';
    }
	public function get_categories() {
		return [ 'mediax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'blog_post_section',
			[
				'label' => __( 'Blog Post', 'mediax' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        mediax_select_field( $this, 'layout_style', 'Layout Style',['Style One', 'Style Two', 'Style Three', 'Style Four', 'Style Five', 'Style Six','Style Seven','Style Eight'] );

        mediax_general_fields($this, 'title', 'Title', 'TEXT', 'Title', ['8'] );

        $this->add_control(
			'blog_post_count',
			[
				'label' 	=> __( 'No of Post to show', 'mediax' ),
                'type' 		=> Controls_Manager::NUMBER,
                'min'       => 1,
                'max'       => count( get_posts( array('post_type' => 'post', 'post_status' => 'publish', 'fields' => 'ids', 'posts_per_page' => '-1') ) ),
                'default'  	=> __( '4', 'mediax' )
			]
        );

        mediax_general_fields( $this, 'title_count', 'Title Length', 'TEXT2', '6');
        mediax_general_fields( $this, 'excerpt_count', 'Excerpt Length', 'TEXT', '14', ['3']);

        $this->add_control(
			'blog_post_order',
			[
				'label' 	=> __( 'Order', 'mediax' ),
                'type' 		=> Controls_Manager::SELECT,
                'options'   => [
                    'ASC'   	=> __('ASC','mediax'),
                    'DESC'   	=> __('DESC','mediax'),
                ],
                'default'  	=> 'DESC'
			]
        );

        $this->add_control(
			'blog_post_order_by',
			[
				'label' 	=> __( 'Order By', 'mediax' ),
                'type' 		=> Controls_Manager::SELECT,
                'options'   => [
                    'ID'    	=> __( 'ID', 'mediax' ),
                    'author'    => __( 'Author', 'mediax' ),
                    'title'    	=> __( 'Title', 'mediax' ),
                    'date'    	=> __( 'Date', 'mediax' ),
                    'rand'    	=> __( 'Random', 'mediax' ),
                ],
                'default'  	=> 'ID'
			]
        );

        $this->add_control(
			'exclude_cats',
			[
				'label' 		=> __( 'Exclude Categories', 'mediax' ),
                'type' 			=> Controls_Manager::SELECT2,
                'multiple' 		=> true,
				'options' 		=> $this->mediax_get_categories(),
			]
        );

        $this->add_control(
			'exclude_tags',
			[
				'label' 		=> __( 'Exclude Tags', 'mediax' ),
                'type' 			=> Controls_Manager::SELECT2,
                'multiple' 		=> true,
				'options' 		=> $this->mediax_get_tags(),
			]
        );

        $this->add_control(
			'exclude_post_id',
			[
				'label'         => __( 'Exclude Post', 'mediax' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
				'options'       => $this->mediax_post_id(),
			]
        );

        mediax_general_fields( $this, 'button_text', 'Read More Text', 'TEXTAREA2', 'Read More' );

        $this->end_controls_section();

		//---------------------------------------
			//Style Section Start
		//---------------------------------------

		//-------Title Style-------
		mediax_common2_style_fields( $this, 'title', 'Title', '{{WRAPPER}} .box-title', '', 'color', '--theme-color' );
		//------Button Style-------
		mediax_button_style_fields( $this, '10', 'Button Styling', '{{WRAPPER}} .th-btn' );


    }

    public function mediax_get_categories() {
        $cats = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => true,
        ));

        $cat = [];

        foreach( $cats as $singlecat ) {
            $cat[$singlecat->term_id] = __($singlecat->name,'mediax');
        }

        return $cat;
    }

    public function mediax_get_tags() {
        $tags = get_terms(array(
            'taxonomy' => 'post_tag',
            'hide_empty' => true,
        ));

        $tag = [];

        foreach( $tags as $singletag ) {
            $tag[$singletag->term_id] = __($singletag->name,'mediax');
        }

        return $tag;
    }

    // Get Specific Post
    public function mediax_post_id(){
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => -1,
        );

        $mediax_post = new WP_Query( $args );

        $postarray = [];

        while( $mediax_post->have_posts() ){
            $mediax_post->the_post();
            $postarray[get_the_Id()] = get_the_title();
        }
        wp_reset_postdata();
        return $postarray;
    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        $exclude_post = $settings['exclude_post_id'];

        if( !empty( $settings['exclude_cats'] ) && empty( $settings['exclude_tags'] ) && empty( $settings['exclude_post_id'] ) ) {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true,
                'category__not_in'      => $settings['exclude_cats']
            );
        } elseif( !empty( $settings['exclude_cats'] ) && !empty( $settings['exclude_tags'] ) && empty( $settings['exclude_post_id'] ) ) {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true,
                'category__not_in'      => $settings['exclude_cats'],
                'tag__not_in'           => $settings['exclude_tags']
            );
        }elseif( !empty( $settings['exclude_cats'] ) && !empty( $settings['exclude_tags'] ) && !empty( $settings['exclude_post_id'] ) ) {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true,
                'category__not_in'      => $settings['exclude_cats'],
                'tag__not_in'           => $settings['exclude_tags'],
                'post__not_in'          => $exclude_post
            );
        } elseif( !empty( $settings['exclude_cats'] ) && empty( $settings['exclude_tags'] ) && !empty( $settings['exclude_post_id'] ) ) {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true,
                'category__not_in'      => $settings['exclude_cats'],
                'post__not_in'          => $exclude_post
            );
        } elseif( empty( $settings['exclude_cats'] ) && !empty( $settings['exclude_tags'] ) && !empty( $settings['exclude_post_id'] ) ) {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true,
                'tag__not_in'           => $settings['exclude_tags'],
                'post__not_in'          => $exclude_post
            );
        } elseif( empty( $settings['exclude_cats'] ) && !empty( $settings['exclude_tags'] ) && empty( $settings['exclude_post_id'] ) ) {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true,
                'tag__not_in'           => $settings['exclude_tags'],
            );
        } elseif( empty( $settings['exclude_cats'] ) && empty( $settings['exclude_tags'] ) && !empty( $settings['exclude_post_id'] ) ) {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true,
                'post__not_in'          => $exclude_post
            );
        } else {
            $args = array(
                'post_type'             => 'post',
                'posts_per_page'        => esc_attr( $settings['blog_post_count'] ),
                'order'                 => esc_attr( $settings['blog_post_order'] ),
                'orderby'               => esc_attr( $settings['blog_post_order_by'] ),
                'ignore_sticky_posts'   => true
            );
        }

    $blogpost = new WP_Query( $args );

		if( $settings['layout_style'] == '1' ){
            echo '<div class="slider-area">';
                echo '<div class="swiper th-slider has-shadow" id="blogSlider1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
                    echo '<div class="swiper-wrapper">';
                        while( $blogpost->have_posts() ){
                            $blogpost->the_post(); 
                            $categories = get_the_category();
                            echo '<div class="swiper-slide">';
                                echo '<div class="blog-card">';
                                    echo '<div class="blog-img">';
                                        the_post_thumbnail( 'mediax_392X225' );
                                    echo '</div>';
                                    echo '<div class="blog-content">';
                                        echo '<div class="blog-meta">';
                                            echo '<a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'"><i class="far fa-user"></i>'.esc_html__('By ', 'mediax') . esc_html( ucwords( get_the_author() ) ).'</a>';
                                            echo '<a href="'.esc_url( mediax_blog_date_permalink() ).'"><i class="far fa-calendar"></i>'.esc_html( get_the_date( 'd F Y' ) ).'</a>';
                                        echo '</div>';
                                        echo '<h3 class="box-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h3>';
                                        if(!empty($settings['button_text'])){
                                            echo '<a href="'.esc_url( get_permalink() ).'" class="th-btn btn-sm">'.wp_kses_post($settings['button_text']).'</a>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        wp_reset_postdata();
                    echo '</div>';
                echo '</div>';
                echo '<button data-slider-prev="#blogSlider1" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
                echo '<button data-slider-next="#blogSlider1" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
            echo '</div>';

		}elseif( $settings['layout_style'] == '2' ){
            echo '<div class="row gy-4">';
                while( $blogpost->have_posts() ){
                    $blogpost->the_post(); 
                    $categories = get_the_category();
                    echo '<div class="col-xl-4 col-md-6">';
                        echo '<div class="blog-box">';
                            echo '<div class="blog-img">';
                                the_post_thumbnail( 'mediax_332X190' );
                            echo '</div>';
                            echo '<div class="blog-content">';
                                echo '<div class="blog-meta">';
                                    echo '<a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'"><i class="far fa-user"></i>'.esc_html__('By ', 'mediax') . esc_html( ucwords( get_the_author() ) ).'</a>';
                                    echo '<a href="'.esc_url( mediax_blog_date_permalink() ).'"><i class="far fa-calendar"></i>'.esc_html( get_the_date( 'd F Y' ) ).'</a>';
                                echo '</div>';
                                echo '<h3 class="box-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h3>';
                                if(!empty($settings['button_text'])){
                                    echo '<a href="'.esc_url( get_permalink() ).'" class="th-btn btn-sm">'.wp_kses_post($settings['button_text']).'</a>';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
                wp_reset_postdata();
            echo '</div>';

        }elseif( $settings['layout_style'] == '3' ){
            echo '<div class="slider-area">';
                echo '<div class="swiper th-slider has-shadow" id="blogSlider1" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
                    echo '<div class="swiper-wrapper">';
                        while( $blogpost->have_posts() ){
                            $blogpost->the_post(); 
                            $categories = get_the_category();
                            echo '<div class="swiper-slide">';
                                echo '<div class="blog-box">';
                                    echo '<div class="blog-img">';
                                        the_post_thumbnail( 'mediax_392X225' );
                                    echo '</div>';
                                    echo '<div class="blog-content">';
                                        echo '<div class="blog-meta">';
                                            echo '<a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'"><i class="far fa-user"></i>'.esc_html__('By ', 'mediax') . esc_html( ucwords( get_the_author() ) ).'</a>';
                                            echo '<a href="'.esc_url( mediax_blog_date_permalink() ).'"><i class="far fa-calendar"></i>'.esc_html( get_the_date( 'd F Y' ) ).'</a>';
                                        echo '</div>';
                                        echo '<h3 class="box-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h3>';
                                        if(!empty($settings['button_text'])){
                                            echo '<a href="'.esc_url( get_permalink() ).'" class="th-btn btn-sm">'.wp_kses_post($settings['button_text']).'</a>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        wp_reset_postdata();
                    echo '</div>';
                echo '</div>';
                echo ' <button data-slider-prev="#blogSlider1" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
                echo '<button data-slider-next="#blogSlider1" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
            echo '</div>';

        }elseif( $settings['layout_style'] == '4' ){
            echo '<div class="slider-area">';
                echo '<div class="swiper th-slider has-shadow" id="blogSlider4" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
                    echo '<div class="swiper-wrapper">';
                        while( $blogpost->have_posts() ){
                            $blogpost->the_post(); 
                            $categories = get_the_category();
                        
                            echo '<div class="swiper-slide">';
                                echo '<div class="blog-box">';
                                    echo '<div class="blog-img">';
                                        the_post_thumbnail( 'mediax_392X225' );
                                    echo '</div>';
                                    echo '<div class="blog-content">';
                                        echo '<div class="blog-meta has-bg">';
                                            echo '<a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'"><i class="far fa-user"></i>'.esc_html__('By ', 'mediax') . esc_html( ucwords( get_the_author() ) ).'</a>';
                                            echo '<a href="'.esc_url( mediax_blog_date_permalink() ).'"><i class="far fa-calendar"></i>'.esc_html( get_the_date( 'd F Y' ) ).'</a>';
                                        echo '</div>';
                                        echo '<h3 class="box-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h3>';
                                        if(!empty($settings['button_text'])){
                                            echo '<a href="'.esc_url( get_permalink() ).'" class="th-btn btn-sm">'.wp_kses_post($settings['button_text']).'</a>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        wp_reset_postdata();
                        
                    echo '</div>';
                echo '</div>';
                echo '<button data-slider-prev="#blogSlider4" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
                echo '<button data-slider-next="#blogSlider4" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
            echo '</div>';
        }elseif( $settings['layout_style'] == '5' ){
            echo '<div class="slider-area">';
                echo '<div class="swiper th-slider has-shadow" id="blogSlider4" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
                    echo '<div class="swiper-wrapper">';
                        while( $blogpost->have_posts() ){
                            $blogpost->the_post(); 
                            $categories = get_the_category();
                            echo '<div class="swiper-slide">';
                                echo '<div class="blog-grid">';
                                    echo '<div class="blog-img">';
                                        the_post_thumbnail( 'mediax_392X225' );
                                    echo '</div>';
                                    echo '<a class="blog-date" href="'.esc_url( mediax_blog_date_permalink() ).'">'.esc_html( get_the_date( 'd F Y' ) ).'</a>';
                                    echo '<div class="blog-content">';
                                        echo '<h3 class="box-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h3>';
                                        if(!empty($settings['button_text'])){
                                            echo '<a href="'.esc_url( get_permalink() ).'" class="th-btn btn-sm style2">'.wp_kses_post($settings['button_text']).'</a>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        wp_reset_postdata();
                    echo '</div>';
                echo '</div>';
                echo '<button data-slider-prev="#blogSlider4" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>';
                echo '<button data-slider-next="#blogSlider4" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>';
            echo '</div>';
        }elseif($settings['layout_style'] == '6'){
            echo '<div class="row gy-4">';
                while( $blogpost->have_posts() ){
                    $blogpost->the_post(); 
                    $categories = get_the_category();
                    echo '<div class="col-lg-6">';
                        echo '<div class="blog-grid style2">';
                            echo '<div class="blog-img">';
                                the_post_thumbnail( 'mediax_600X321' );
                                echo '<a class="blog-date2" href="blog.html">'.esc_html( get_the_date( 'd F' ) ).'<span class="year">'.esc_html( get_the_date( 'Y' ) ).'</span></a>';
                            echo '</div>';
                            echo '<div class="blog-content">';
                                echo '<h3 class="box-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h3>';
                                if(!empty($settings['button_text'])){
                                    echo '<a href="'.esc_url( get_permalink() ).'" class="th-btn btn-sm style2">'.wp_kses_post($settings['button_text']).'</a>';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
                wp_reset_postdata();
            echo '</div>';
        }elseif($settings['layout_style'] == '7'){
            echo '<div class="slider-area">';
                echo '<div class="swiper th-slider has-shadow" id="blogSlider8" data-slider-options=\'{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}\'>';
                    echo '<div class="swiper-wrapper">';

                        while( $blogpost->have_posts() ){
                        $blogpost->the_post(); 
                        $categories = get_the_category();
                            echo '<div class="swiper-slide">';
                                echo '<div class="blog-box2">';
                                    echo '<div class="blog-img">';
                                        the_post_thumbnail( 'mediax_401X256' );
                                    echo '</div>';
                                    echo '<div class="blog-content">';
                                        echo '<div class="blog-meta">';
                                            echo '<a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'"><i class="fal fa-user"></i>'.esc_html__('By ', 'mediax') . esc_html( ucwords( get_the_author() ) ).'</a>';
                                            echo '<a href="'.esc_url( mediax_blog_date_permalink() ).'"><i class="fal fa-calendar"></i>'.esc_html( get_the_date( 'd F Y' ) ).'</a>';
                                        echo '</div>';
                                        echo '<h3 class="box-title"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h3>';
                                        if(!empty($settings['button_text'])){
                                            echo '<a href="'.esc_url( get_permalink() ).'" class="th-btn style7 btn-sm">'.wp_kses_post($settings['button_text']).'</a>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        wp_reset_postdata();    
                    echo '</div>';
                echo '</div>';
                echo '<button data-slider-prev="#blogSlider8" class="slider-arrow style2 slider-prev"><i class="far fa-arrow-left"></i></button>';
                echo '<button data-slider-next="#blogSlider8" class="slider-arrow style2 slider-next"><i class="far fa-arrow-right"></i></button>';
            echo '</div>';
        }else{
            echo '<div class="widget footer-widget">';
                echo '<h3 class="widget_title">Recent Posts</h3>';
                echo '<div class="recent-post-wrap">';
                    while( $blogpost->have_posts() ){
                    $blogpost->the_post(); 
                    $categories = get_the_category();
                        echo '<div class="recent-post">';
                            echo '<div class="media-img">';
                            echo '<a href="'.esc_url( get_permalink() ).'">';
                               the_post_thumbnail( 'mediax_85X85' );
                            echo '</a>';
                            echo '</div>';
                            echo '<div class="media-body">';
                                echo '<h4 class="post-title"><a class="text-inherit" href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title( ), $settings['title_count'], '' ) ).'</a></h4>';
                                echo '<div class="recent-post-meta">';
                                    echo '<a href="'.esc_url( get_permalink() ).'"><i class="fal fa-calendar"></i>'.esc_html( get_the_date( 'd F Y' ) ).'</a>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                    wp_reset_postdata();   
                echo '</div>';
            echo '</div>';
        }
	}
}