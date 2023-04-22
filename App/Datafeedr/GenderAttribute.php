<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/155-add-gender-as-product-attribute
 * 
 * https://datafeedrapi.helpscoutdocs.com/article/221-import-attribute-for-a-product
 *
 * 
 */

namespace App\Datafeedr;

class GenderAttribute {

  function __construct() {

    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value'), 20, 6 );
    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value2'), 20, 6 );
    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value3'), 20, 6 );

  }

  function attribute_value3( $value, $attribute, $post, $product, $set, $action ) {

    $ai = new Dfrpswc_Attribute_Importer( 'age-group', $value, $attribute, $product );

    $ai->add_field( [ 'gender.name.description.category' ], 'gender', 'All Ages' );

    $ai->add_term( 'Girls', [ 'girl' ], [ 'womens', 'woman', 'women' ] );
    $ai->add_term( 'Boys', [ 'boy' ], [ 'mens', 'man', 'men' ] );
    $ai->add_term( 'Womens', [ 'female', 'womens', 'woman', 'women' ], [ 'girl', 'girls', 'child', 'children', 'kids', 'kid' ] );
    $ai->add_term( 'Mens', [ 'male', 'mens', 'man', 'men' ], [ 'boy', 'boys', 'child', 'children', 'kids', 'kid' ] );

    return $ai->result();

  }

  function attribute_value2( $value, $attribute, $post, $product, $set, $action ) {

    $ai = new Dfrpswc_Attribute_Importer( 'gender', $value, $attribute, $product );

    $ai->add_field( [ 'gender' ], 'gender', 'Unisex' );

    $ai->add_term( 'Womens', [ 'female', 'womens', 'woman', 'women' ] );
    $ai->add_term( 'Mens', [ 'male', 'mens', 'man', 'men' ] );

    return $ai->result();

  }

  function attribute_value( $value, $attribute, $post, $product, $set, $action ) {

    if ( $attribute !== 'pa_gender' ) {
      return $value;
    }

    if ( isset( $product['gender'] ) ) {
      return $this->get_gender( $product['gender'], $product['gender'] );
    }

    // if ( isset( $product['extratexttwo'] ) ) {
      // return $this->get_gender( $product['extratexttwo'] );
    // }

    if ( isset( $product['name'] ) ) {
      return $this->get_gender( $product['name'] );
    }

    return $value;

  }

  function get_gender( $field, $default = '' ) {

    $map = [];

    // ++++++++++ Begin Editing Here ++++++++++

    // Use 'Mens' as attribute name if product gender is 'men' or 'mens' or 'male' or 'males' or 'man' or 'mans'.
    $map['Mens'] = [ 'men', 'mens', 'male', 'males', 'man', 'mans' ];

    // Use 'Womens' as attribute name if product gender is 'women' or 'woman' or 'womens' or 'womans' or 'female' or 'females'.
    $map['Womens'] = [ 'women', 'woman', 'womens', 'womans', 'female', 'females' ];

    // Use 'Unisex' as attribute name if product gender is 'unisex' or 'uni-sex'.
    $map['Unisex'] = [ 'unisex', 'uni-sex' ];

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



