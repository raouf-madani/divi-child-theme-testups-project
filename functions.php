<?php
/* To inherit the css style from the parent theme*/
function my_theme_enqueue_styles() { 
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );




/*This function changes the text of the "procceed to checkout button" in the cart page */
/*function woocommerce_button_proceed_to_checkout() {
    $checkout_url = WC()->cart->get_checkout_url();
?>
<a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward"><?php _e( 'Go To Step -1-', 'woocommerce' ); ?></a>
<?php
}*/

/*This function redirects user to the account page while proceeding to checkout 
in case if the user doesn't have any account or the user tries to put the url(https://certifymyproduct.com/step-1-checkout) of this page while he isn't a member in our website'*/
function ace_redirect_pre_checkout() {
    if ( ! function_exists( 'wc' ) ) return;
    $account_page_id = 15;
    if ( ! is_user_logged_in() && is_checkout() ) {
        wp_safe_redirect( get_permalink( $account_page_id ) );
        die;
    } 
    else if(! is_user_logged_in() && is_page(412)){
        wp_safe_redirect( get_permalink( $account_page_id ) );
        die;
    }
}
add_action( 'template_redirect', 'ace_redirect_pre_checkout' );



/*This function changes the url of the "procceed to checkout button" in the cart page*/
add_filter( 'woocommerce_get_checkout_url', 'new_url', 30 );

function new_url($url) {
    
    if(is_user_logged_in()){
    $url = "https://certifymyproduct.com/step-1-checkout/";
    }
    return $url;
}

/*
Change Place Order button text on checkout page in woocommerce
*/
add_filter('woocommerce_order_button_text','change_place_order_button_text',1);
function change_place_order_button_text($orderButtonText) {

    $orderButtonText = 'Pay Now';

    return $orderButtonText;
}


/*This function redirects the user after submitting his form information to the checkout page*/
add_action( 'wp_footer', 'redirect_cf7' );

function redirect_cf7() {
    ?>
    <script type="text/javascript">
        document.addEventListener( 'wpcf7mailsent', function( event ) {
            if ( '414' == event.detail.contactFormId ) {
                location = 'https://certifymyproduct.com/checkout/';
            }
        }, false );
    </script>
        <?php
}


/* Change WooCommerce "Related products" text to "Related Products"*/

add_filter('gettext', 'change_relatedpr_text', 10, 3);
add_filter('ngettext', 'change_relatedpr_text', 10, 3);

function change_relatedpr_text($newText, $text, $domain)
{
    if ($text === 'Related products' && $domain === 'woocommerce') {
        $newText = esc_html__('Related Products', $domain);
    }
    return $newText;
}


/*This function hide the two sections in my account page when the user is not logging-in*/
add_action( 'wp_footer', 'myAccountContentAfterLoggingIn' );

function myAccountContentAfterLoggingIn() {
    if(!is_user_logged_in() && is_page(15)){

?>
<script type="text/javascript">
    document.querySelector( '#firstSection').style.display= 'none';
    document.querySelector( '#secondSection').style.display= 'none';
</script>
<?php
    }
}

/*This function hide the button "CREATE ACCOUNT" & the text ", or create an account"  in my about-us page when the user is logging-in*/
add_action( 'wp_footer', 'hideButtonCreateAccount' );

function hideButtonCreateAccount() {
    if(is_user_logged_in()){

?>
<script type="text/javascript">
    document.querySelector( '#createaccountbutton').style.display= 'none';
    document.querySelector( '#createaccounttext').style.display= 'none';
    
</script>
<?php
    }
}

/*product Information (step-1-checkout PAGE)(Hide & Show fields)*/
add_action( 'wp_footer', 'productInformation' );

function productInformation() {
    
?>
<script type="text/javascript">
    
    var additionalfield= document.getElementById('additionalfield');
    var additionalfield1= document.getElementById('additionalfield1');
    var additionalfield2= document.getElementById('additionalfield2');
    var additionalfield3= document.getElementById('additionalfield3');
    var additionalfield4= document.getElementById('additionalfield4');
    var additionalfield5= document.getElementById('additionalfield5');
    var emailField= document.querySelector('.emailAdditionalField');
    additionalfield.style.display = "none";
    additionalfield1.style.display = "none";
    additionalfield2.style.display = "none";
    additionalfield3.style.display = "none";
    additionalfield4.style.display = "none";
    additionalfield5.style.display = "none";
    emailField.style.display = "none";
    
     
    document.getElementById('selectfirstradio').addEventListener('click', displayAllFields);
    function displayAllFields() {
        
    
        /*Get the value of the first radio button*/
        var radioValue = document.querySelector('input[name="radio-926"]:checked').value;
        
        if(radioValue == "Yes"){
            additionalfield.style.display = 'block';
            additionalfield1.style.display = 'block';
            additionalfield2.style.display = 'block';
            additionalfield3.style.display = 'block';
            additionalfield4.style.display = 'block';
            
            
            additionalfield4.addEventListener('click', displayFile);
            function displayFile() {
                
            
                /*Get the value of the second radio button*/
                var secondRadioValue = document.querySelector('input[name="radio-927"]:checked').value;
                if(secondRadioValue == "Yes"){
                    additionalfield5.style.display = 'block';
                }
                else{
                    additionalfield5.style.display = 'none';
                }
            }
            
        
        }
        else{
            additionalfield.style.display = 'none';
            additionalfield1.style.display = 'none';
            additionalfield2.style.display = 'none';
            additionalfield3.style.display = 'none';
            additionalfield4.style.display = 'none';
            additionalfield5.style.display = 'none';
        }
    }
</script>
<?php
    }



/* Fix the compatibility between native date picker of contact form 7 and safari browser*/
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );


/* This function change the "total" text in the cart page*/
add_filter('gettext', 'changeTotalText', 20, 3);
function changeTotalText( $translated_text, $untranslated_text, $domain ) {

    if( is_page(13) ) {
        if( $untranslated_text == 'Total' )
            $translated_text = __( 'Total (incl. VAT)','theme_slug_domain' );
    }
    return $translated_text;
}








