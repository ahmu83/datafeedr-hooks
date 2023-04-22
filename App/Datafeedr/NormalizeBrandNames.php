<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/156-normalize-brand-names
 */

namespace App\Datafeedr;

class NormalizeBrandNames {

  function __construct() {

    add_filter( 'dfrpswc_filter_attribute_value', 'attribute_value', 20, 6 );

  }

  function attribute_value( $value, $attribute, $post, $product, $set, $action ) {

    $ai = new Dfrpswc_Attribute_Importer( 'brand', $value, $attribute, $product );

    $ai->add_field( [ 'brand' ] );

    $ai->add_term( "Aerobie", [ "Aerobie, Inc." ] );
    $ai->add_term( "Black Diamond", [ "Black Diamond Equipment", "Black Diamond Inc" ] );
    $ai->add_term( "CAMP USA", [ "camp", "camp usa - cassin" ] );
    $ai->add_term( "Crucial Coffee", [ "crucial brands", "crucial-coffee" ] );

    return $ai->result();

  }


}



