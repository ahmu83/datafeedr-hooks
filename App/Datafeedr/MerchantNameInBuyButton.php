<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/174-add-merchant-name-to-buy-button
 * 
 */

namespace App\Datafeedr;

class MerchantNameInBuyButton {

  function __construct() {

    if ( !function_exists('dfrpswc_is_dfrpswc_product') ) return;

    add_filter( 'woocommerce_product_add_to_cart_text', array($this, 'add_to_cart_text'), 20, 2 );
    add_filter( 'woocommerce_product_single_add_to_cart_text', array($this, 'add_to_cart_text'), 20, 2 );

  }

  function add_to_cart_text( $button_text, $product ) {

    if ( $product->get_type() != 'external' ) {
      return $button_text;
    }

    if ( ! dfrpswc_is_dfrpswc_product( $product->get_id() ) ) {
      return $button_text;
    }

    // Remove the following line to display merchant names in buttons on category pages and shop front page.
    if ( ! is_product() ) {
      return $button_text;
    }

    $meta          = get_post_meta( $product->get_id(), '_dfrps_product', true );
    $merchant_name = esc_html( $meta['merchant'] );

    // This is the text that will appear on the button. $name is equal to the merchant's name.
    $button_text = "Buy from $merchant_name";

    return $button_text;

  }

}



