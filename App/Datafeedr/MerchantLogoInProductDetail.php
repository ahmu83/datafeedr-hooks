<?php

namespace App\Datafeedr;

class MerchantLogoInProductDetail {

  function __construct() {

    if ( !function_exists('dfrpswc_is_dfrpswc_product') ) return;

    add_filter( 'woocommerce_external_add_to_cart', array($this, 'add_to_cart'), 20 );

  }

  function add_to_cart() {

    global $product;

    if ( ! dfrpswc_is_dfrpswc_product( $product->get_id() ) ) {
      return;
    }

    $postmeta    = get_post_meta( $product->get_id(), '_dfrps_product', true );
    $title       = esc_attr( $postmeta['merchant'] ?? '' );
    $merchant    = esc_html( $postmeta['merchant'] ?? '' );
    $merchant_id = absint( $postmeta['merchant_id'] ?? 0 );
    $url         = esc_url( sprintf( 'https://images.datafeedr.com/m/%d.jpg', $merchant_id ) );

    printf( '<object data="%s" type="image/jpeg" title="%s">%s</object>', $url, $title, $merchant );

  }

}



