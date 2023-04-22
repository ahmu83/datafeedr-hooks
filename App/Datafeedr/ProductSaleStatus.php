<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/256-add-sale-status-filter-attribute
 * 
 */

namespace App\Datafeedr;

class ProductSaleStatus {

  function __construct() {

    add_filter( 'dfrpswc_filter_attribute_value', array($this, 'attribute_value'), 20, 6 );

  }

  function attribute_value($value, $attribute, $post, $product, $set, $action) {

    if ( $attribute !== 'pa_promotion' ) {
      return $value;
    }

    return absint( $product['onsale'] ?? 0 ) ? 'Yes' : 'No';

  }


}



