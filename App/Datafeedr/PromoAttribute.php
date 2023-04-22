<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/38-add-a-custom-attribute-for-a-product#code1
 * 
 */

namespace App\Datafeedr;

class PromoAttribute {

  function __construct() {

    add_filter( 'dfrpswc_product_attributes', array($this, 'attribute_label'), 20, 5 );
    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value'), 30, 6 );

  }

  function attribute_label( $attributes, $post, $product, $set, $action ) {

    // The label for the product field.
    $label = 'Special Promotion';

    // The product field to import.
    $field = 'promo';

    if ( 'update' == $action ) {
      return $attributes;
    }

    $sanitized_label = sanitize_title( $label );

    if ( ! isset( $product[ $field ] ) ) {
      return $attributes;
    }

    if ( isset( $attributes[ $sanitized_label ] ) ) {
      return $attributes;
    }

    if ( ! is_array( $attributes ) && empty( $attributes ) ) {
      $attributes = [];
    }

    $attributes[ $sanitized_label ]['name'] = $label;

    return $attributes;
  }

  function attribute_value( $value, $attribute, $post, $product, $set, $action ) {

    // The label for the product field.
    $label = 'Special Promotion';

    // The product field to import.
    $field = 'promo';

    if ( 'update' == $action ) {
      return $value;
    }

    if ( ! isset( $product[ $field ] ) ) {
      return $value;
    }

    if ( $attribute == $label ) {
      return $product[ $field ];
    }

    return $value;
  }

}



