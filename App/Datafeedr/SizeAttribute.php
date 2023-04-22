<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/51-add-size-as-a-product-attribute
 * 
 */

namespace App\Datafeedr;

class SizeAttribute {

  function __construct() {

    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value'), 20, 6 );

  }

  function attribute_value( $value, $attribute, $post, $product, $set, $action ) {

    if ( $attribute !== 'pa_size' ) {
      return $value;
    }

    if ( isset( $product['size'] ) ) {
      return $this->get_size( $product['size'], $product['size'] );
    }

    // if ( isset( $product['custom1'] ) ) {
      // return $this->get_size( $product['custom1'], $product['custom1'] );
    // }

    if ( isset( $product['name'] ) ) {
      return $this->get_size( $product['name'] );
    }

    return $value;

  }

  function get_size( $field, $default = '' ) {

    $map = [];

    // ++++++++++ Begin Editing Here ++++++++++

    // Small, Medium, Large Sizes
    $map['XXXS']   = [ 'xxx small' ];
    $map['XXS']    = [ 'xx small' ];
    $map['XS']     = [ 'x small' ];
    $map['Small']  = [ 'sm', 's' ];
    $map['Medium'] = [ 'md', 'med', 'm' ];
    $map['Large']  = [ 'lg', 'l' ];
    $map['XL']     = [ 'extra large', 'x large' ];
    $map['XXL']    = [ 'xx large' ];
    $map['XXXL']   = [ 'xxx large' ];

    // European Shoe Sizes
    $map['34']   = [ '34', 'UK 2' ];
    $map['34.5'] = [ '34.5', 'UK 2' ];
    $map['35']   = [ '35', 'UK 2.5' ];
    $map['35.5'] = [ '35.5', 'UK 3' ];
    $map['36']   = [ '36', 'UK 3.5' ];
    $map['36.5'] = [ '36.5', 'UK 3.5' ];
    $map['37']   = [ '37', 'UK 4' ];
    $map['37.5'] = [ '37.5', 'UK 4.5' ];
    $map['38']   = [ '38', 'UK 5' ];
    $map['38.5'] = [ '38.5', 'UK 5.5' ];
    $map['39']   = [ '39', 'UK 6' ];
    $map['39.5'] = [ '39.5', 'UK 6.5' ];
    $map['40']   = [ '40', 'UK 7' ];
    $map['40.5'] = [ '40.5', 'UK 7' ];
    $map['41']   = [ '41', 'UK 7.5' ];
    $map['41.5'] = [ '41.5', 'UK 7.5' ];
    $map['42']   = [ '42', 'UK 8' ];
    $map['42.5'] = [ '42.5', 'UK 8.5' ];
    $map['43']   = [ '43', 'UK 9' ];
    $map['43.5'] = [ '43.5', 'UK 9' ];
    $map['44']   = [ '44', 'UK 9.5' ];
    $map['44.5'] = [ '44.5', 'UK 10' ];
    $map['45']   = [ '45', 'UK 10.5' ];
    $map['45.5'] = [ '45.5', 'UK 10.5' ];
    $map['46']   = [ '46', 'UK 11' ];
    $map['46.5'] = [ '46.5', 'UK 11.5' ];
    $map['47']   = [ '47', 'UK 12' ];

    // ++++++++++ Stop Editing Here ++++++++++

    $terms = [];

    foreach ( $map as $key => $keywords ) {

      if ( preg_match( '/\b' . preg_quote( $key, '/' ) . '\b/iu', $field ) ) {
        $terms[] = $key;
      }

      foreach ( $keywords as $keyword ) {
        if ( preg_match( '/\b' . preg_quote( $keyword, '/' ) . '\b/iu', $field ) ) {
          $terms[] = $key;
        }
      }
    }

    if ( ! empty( $terms ) ) {
      return implode( WC_DELIMITER, array_unique( $terms ) );
    }

    return $default;

  }



}



