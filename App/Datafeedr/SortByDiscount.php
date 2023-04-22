<?php

namespace App\Datafeedr;

class SortByDiscount {

  function __construct() {

    add_filter( 'woocommerce_get_catalog_ordering_args', array($this, 'catalog_ordering_args') );

    add_filter( 'woocommerce_default_catalog_orderby_options', array($this, 'catalog_orderby_options') );

  }

  function catalog_ordering_args( $args ) {

    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'discount' == $orderby_value ) {
      $args['orderby']  = 'meta_value_num';
      $args['order']    = 'DESC';
      $args['meta_key']   = '_dfrps_salediscount';
    }
    return $args;

  }

  function catalog_orderby_options( $orderby ) {

    $sortby['discount']   = 'Sort by discount';
    return $sortby;

  }




}



