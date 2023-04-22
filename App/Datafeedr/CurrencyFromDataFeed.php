<?php

namespace App\Datafeedr;

class CurrencyFromDataFeed {

  function __construct() {

    add_filter( 'woocommerce_currency_symbol', array($this, 'currency_symbol'), 10, 2 );

  }

  function currency_symbol( $currency_symbol, $currency ) {

    global $product;

    if ( ! is_object( $product ) || ! isset( $product ) ) {
      return $currency_symbol;
    }

    $fields = get_post_meta( $product->get_id(), '_dfrps_product', true );

    if ( empty( $fields ) ) {
      return $currency_symbol;
    }

    if ( ! isset( $fields['currency'] ) ) {
      return $currency_symbol;
    }

    $currency_symbol = dfrapi_currency_code_to_sign( $fields['currency'] );

    return $currency_symbol;

  }

}



