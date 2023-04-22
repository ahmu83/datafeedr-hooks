<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/223-display-extra-product-data-in-loop-and-on-single-product-pages
 * 
 */

namespace App\Datafeedr;

class DisplayExtraProductFields {

  function __construct() {

    if ( !function_exists('dfrps_get_product_field') ) return;

    add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'before_shop_loop_item_title'), 20 );

    add_action( 'woocommerce_before_add_to_cart_button', array($this, 'before_add_to_cart_button'), 20 );

  }

  function before_shop_loop_item_title() {

    global $product;

    /**
    * Display the product's color if available.
    */
    if ( $color = dfrps_get_product_field( $product->get_id(), 'color' ) ) {
      printf( '<div class="field-color">Color: %s</div>', esc_html( $color ) );
    }

    /**
    * Display the product's material if available.
    */
    if ( $material = dfrps_get_product_field( $product->get_id(), 'material' ) ) {
      printf( '<div class="field-material">Material: %s</div>', esc_html( $material ) );
    }

    /**
    * Display the product's condition if available.
    */
    if ( $condition = dfrps_get_product_field( $product->get_id(), 'condition' ) ) {
      printf( '<div class="field-condition">Condition: %s</div>', esc_html( $condition ) );
    }

    /**
    * Display the product's brand attribute if available.
    */
    if ( $brand = $product->get_attribute( 'brand' ) ) {
      printf( '<div class="field-brand">Brand: %s</div>', esc_html( $brand ) );
    }

    /**
    * Display the product's merchant attribute if available.
    */
    if ( $merchant = $product->get_attribute( 'merchant' ) ) {
      printf( '<div class="field-merchant">Merchant: %s</div>', esc_html( $merchant ) );
    }

    /**
    * Display the product's network attribute if available.
    */
    if ( $network = $product->get_attribute( 'network' ) ) {
      printf( '<div class="field-network">Network: %s</div>', esc_html( $network ) );
    }

  }

  function before_add_to_cart_button() {

    global $product;

    /**
    * Display the product's color if available.
    */
    if ( $color = dfrps_get_product_field( $product->get_id(), 'color' ) ) {
      printf( '<div class="field-color">Color: %s</div>', esc_html( $color ) );
    }

    /**
    * Display the product's material if available.
    */
    if ( $material = dfrps_get_product_field( $product->get_id(), 'material' ) ) {
      printf( '<div class="field-material">Material: %s</div>', esc_html( $material ) );
    }

    /**
    * Display the product's condition if available.
    */
    if ( $condition = dfrps_get_product_field( $product->get_id(), 'condition' ) ) {
      printf( '<div class="field-condition">Condition: %s</div>', esc_html( $condition ) );
    }

    /**
    * Display the product's brand attribute if available.
    */
    if ( $brand = $product->get_attribute( 'brand' ) ) {
      printf( '<div class="field-brand">Brand: %s</div>', esc_html( $brand ) );
    }

    /**
    * Display the product's merchant attribute if available.
    */
    if ( $merchant = $product->get_attribute( 'merchant' ) ) {
      printf( '<div class="field-merchant">Merchant: %s</div>', esc_html( $merchant ) );
    }

    /**
    * Display the product's network attribute if available.
    */
    if ( $network = $product->get_attribute( 'network' ) ) {
      printf( '<div class="field-network">Network: %s</div>', esc_html( $network ) );
    }

  }


}



