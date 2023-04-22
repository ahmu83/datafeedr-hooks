<?php
/**
 * https://gist.github.com/EricBusch/fbe9f7164ec0d4a85d70d0f430581e9a
 * 
 */

namespace App\Datafeedr;

class MaterialAttribute {

  function __construct() {

    add_filter( 'dfrpswc_filter_attribute_value', 'attribute_value', 20, 6 );

  }

  function attribute_value( $value, $attribute, $post, $product, $set, $action ) {

    $ai = new Dfrpswc_Attribute_Importer( 'material', $value, $attribute, $product );

    $ai->add_field( [ "description.name.material" ], "material" );

    $ai->add_term( "Bamboo" );
    $ai->add_term( "Denim", [ "jean", "jeans" ] );
    $ai->add_term( "Flannel" );
    $ai->add_term( "Fur" );
    $ai->add_term( "Glass" );
    $ai->add_term( "Leather", [ "cowhide" ] );
    $ai->add_term( "Metal", [ "copper", "steel", "iron", "aluminum" ] );
    $ai->add_term( "Nylon" );
    $ai->add_term( "Plastic" );
    $ai->add_term( "Polyester" );
    $ai->add_term( "Rayon" );
    $ai->add_term( "Spandex" );
    $ai->add_term( "Wood" );

    return $ai->result();

  }

}



