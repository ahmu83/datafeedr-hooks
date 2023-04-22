<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/20-add-color-as-a-product-attribute
 * 
 * https://datafeedrapi.helpscoutdocs.com/article/221-import-attribute-for-a-product
 *
 * 
 */

namespace App\Datafeedr;

class ColorAttribute {

  function __construct() {

    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value'), 20, 6 );
    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value2'), 20, 6 );

  }

  function attribute_value2( $value, $attribute, $post, $product, $set, $action ) {

    $ai = new Dfrpswc_Attribute_Importer( 'color', $value, $attribute, $product );

    // $ai->add_field( [ 'color' ] );
    // $ai->add_field( [ 'color' ], 'color' );
    $ai->add_field( [ 'description.tags' ], 'color' );

    $ai->add_term( 'Black', [ 'ebony', 'onyx', 'obsidian' ] );
    $ai->add_term( 'Blue', [ 'navy', 'indigo', 'azure', 'periwinkle', 'lavender', 'cobalt' ] );
    $ai->add_term( 'Brown', [ 'caramel' ] );
    $ai->add_term( 'Green', [ 'lime', 'moss', 'mint', 'pine', 'chartreuse', 'sage', 'olive' ] );
    $ai->add_term( 'Grey', [ 'gray', 'silver', 'charcoal' ] );
    $ai->add_term( 'Pink', [ 'rose', 'fuchsia', 'rouge', 'salmon', 'coral', 'magenta' ] );
    $ai->add_term( 'Purple', [ 'mauve', 'violet', 'lavender', 'beetroot', 'burgundy', 'mulberry' ] );
    $ai->add_term( 'Red', [ 'cherry', 'rose', 'ruby', 'crimson', 'scarlet', 'garnet' ] );
    $ai->add_term( 'Tan', [ 'beige', 'camel', 'khaki' ] );
    $ai->add_term( 'White', [ 'pearl', 'alabaster', 'ivory', 'cream', 'egg shell', 'eggshell' ] );
    $ai->add_term( 'Yellow', [ 'lemon' ] );

    return $ai->result();

  }

  function attribute_value( $value, $attribute, $post, $product, $set, $action ) {

    if ( $attribute !== 'pa_color' ) {
      return $value;
    }

    if ( isset( $product['color'] ) ) {
      return $this->get_color( $product['color'] );
    }

    return $value;

  }

  function get_color( $field, $default = '' ) {

    $map = [];

    // ++++++++++ Begin Editing Here ++++++++++

    // Use 'Red' as attribute name if product color is 'cherry' or 'rose' or 'ruby' or 'crimson' or 'scarlet'.
    $map['Red'] = [ 'cherry', 'rose', 'ruby', 'crimson', 'scarlet' ];

    // Use 'Blue' as attribute name if product color is 'navy' or 'indigo' or 'azure' or 'periwinkle' or 'lavender'.
    $map['Blue'] = [ 'navy', 'indigo', 'azure', 'periwinkle', 'lavender' ];

    // Use 'Green' as attribute name if product color is 'lime' or 'moss' or 'mint' or 'pine' or 'spring bud'.
    $map['Green'] = [ 'lime', 'moss', 'mint', 'pine', 'spring bud' ];

    // Add 'White' as attribute if product color is 'pale stone'.
    $map['White'] = [ 'pale stone' ];

    // Add 'Brown' as attribute if product color is 'khaki' or 'Caramel' or 'beige'.
    $map['Brown'] = [ 'khaki', 'Caramel', 'beige' ];

    // Add 'Grey' as attribute if product color is 'dark shadow' or 'gray' or 'silver' or 'silver/grey'.
    $map['Grey'] = [ 'dark shadow', 'gray', 'silver', 'silver/grey' ];

    // Add 'Purple' as attribute if product color is 'beetroot' or 'burgundy' or 'poisonberry' or 'mulberry'.
    $map['Purple'] = [ 'beetroot', 'burgundy', 'poisonberry', 'mulberry' ];

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



