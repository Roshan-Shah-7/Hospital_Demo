<?php
/**
 * @Packge     : Mediax
 * @Version    : 1.0
 * @Author     : Themeholy
 * @Author URI : https://themeforest.net/user/themeholy
 *
 */


// Blocking direct access
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

function mediax_core_essential_scripts( ) {
    wp_enqueue_script('mediax-ajax',MEDIAX_PLUGDIRURI.'assets/js/mediax.ajax.js',array( 'jquery' ),'1.0',true);
    wp_localize_script(
    'mediax-ajax',
    'mediaxajax',
        array(
            'action_url' => admin_url( 'admin-ajax.php' ),
            'nonce'	     => wp_create_nonce( 'mediax-nonce' ),
        )
    );
}

add_action('wp_enqueue_scripts','mediax_core_essential_scripts');


// mediax Section subscribe ajax callback function
add_action( 'wp_ajax_mediax_subscribe_ajax', 'mediax_subscribe_ajax' );
add_action( 'wp_ajax_nopriv_mediax_subscribe_ajax', 'mediax_subscribe_ajax' );

function mediax_subscribe_ajax( ){
  $apiKey = mediax_opt('mediax_subscribe_apikey');
  $listid = mediax_opt('mediax_subscribe_listid');
   if( ! wp_verify_nonce($_POST['security'], 'mediax-nonce') ) {
    echo '<div class="alert alert-danger mt-2" role="alert">'.esc_html__('You are not allowed.', 'mediax').'</div>';
   }else{
       if( !empty( $apiKey ) && !empty( $listid )  ){
           $MailChimp = new DrewM\MailChimp\MailChimp( $apiKey );

           $result = $MailChimp->post("lists/{$listid}/members",[
               'email_address'    => esc_attr( $_POST['sectsubscribe_email'] ),
               'status'           => 'subscribed',
           ]);

           if ($MailChimp->success()) {
               if( $result['status'] == 'subscribed' ){
                   echo '<div class="alert alert-success mt-2" role="alert">'.esc_html__('Thank you, you have been added to our mailing list.', 'mediax').'</div>';
               }
           }elseif( $result['status'] == '400' ) {
               echo '<div class="alert alert-danger mt-2" role="alert">'.esc_html__('This Email address is already exists.', 'mediax').'</div>';
           }else{
               echo '<div class="alert alert-danger mt-2" role="alert">'.esc_html__('Sorry something went wrong.', 'mediax').'</div>';
           }
        }else{
           echo '<div class="alert alert-danger mt-2" role="alert">'.esc_html__('Apikey Or Listid Missing.', 'mediax').'</div>';
        }
   }

   wp_die();

}

add_action('wp_ajax_mediax_addtocart_notification','mediax_addtocart_notification');
add_action('wp_ajax_nopriv_mediax_addtocart_notification','mediax_addtocart_notification');
function mediax_addtocart_notification(){

    $_product = wc_get_product($_POST['prodid']);
    $response = [
        'img_url'   => esc_url( wp_get_attachment_image_src( $_product->get_image_id(),array('60','60'))[0] ),
        'title'     => wp_kses_post( $_product->get_title() )
    ];
    echo json_encode($response);

    wp_die();
}