<?php
/**
 * https://gist.github.com/EricBusch/fbe9f7164ec0d4a85d70d0f430581e9a
 * 
 */

namespace App\Datafeedr;

class CountryAttribute {

  function __construct() {

    add_filter( 'dfrpswc_filter_attribute_value', 'attribute_value', 20, 6 );

  }

  function attribute_value( $value, $attribute, $post, $product, $set, $action ) {

    $ai = new Dfrpswc_Attribute_Importer( 'country', $value, $attribute, $product );

    $ai->add_field( [ "source", "merchant" ], "country", 'United States' );

    $ai->add_term( "Australia", [ "AU" ] );
    $ai->add_term( "Austria", [ "AT" ] );
    $ai->add_term( "Belgium", [ "BE" ] );
    $ai->add_term( "Brazil", [ "BR" ] );
    $ai->add_term( "Brazil", [ "BR" ] );
    $ai->add_term( "Canada", [ "CA" ] );
    $ai->add_term( "Denmark", [ "DK" ] );
    $ai->add_term( "Finland", [ "FI" ] );
    $ai->add_term( "France", [ "FR" ] );
    $ai->add_term( "Germany", [ "DE" ] );
    $ai->add_term( "Ireland", [ "IE" ] );
    $ai->add_term( "Italy", [ "IT" ] );
    $ai->add_term( "India", [ "IN" ] );
    $ai->add_term( "Netherlands", [ "NL" ] );
    $ai->add_term( "New Zealand", [ "NZ" ] );
    $ai->add_term( "Norway", [ "NO" ] );
    $ai->add_term( "Poland", [ "PL" ] );
    $ai->add_term( "Portugal", [ "PT" ] );
    $ai->add_term( "Spain", [ "ES" ] );
    $ai->add_term( "Sweden", [ "SE" ] );
    $ai->add_term( "Switzerland", [ "CH" ] );
    $ai->add_term( "United Kingdom", [ "UK", "GB" ] );
    $ai->add_term( "United States", [ "US", "USA" ] );

    return $ai->result();

  }

}



