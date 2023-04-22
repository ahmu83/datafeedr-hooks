<?php
/**
 * https://datafeedrapi.helpscoutdocs.com/article/204-import-additional-product-images-as-gallery-images
 * 
 */

namespace App\Datafeedr;

class ImportAdditionalProductImagesAsGallery {

  function __construct() {

    add_action( 'dfrpswc_post_save_product', array($this, 'save_product') );

    add_action( 'dfrapi_as_mycode_import_product_gallery_image', array($this, 'product_gallery_image'), 10, 2 );

  }

  function save_product( Dfrpswc_Product_Update_Handler $updater ) {

    /**
     * Modify this array and add the product fields that have alternate images
     * that you want imported into a product's gallery.
     */
    $image_fields = [
      'alternateimage',
      'alternateimagetwo',
      'alternateimagethree',
      'alternateimagefour',
    ];

    /** STOP EDITING HERE **/

    if ( ! function_exists( 'dfrapi_schedule_single_action' ) ) {
      return;
    }

    foreach ( $image_fields as $image_field ) {
      $post_id = $updater->wc_product->get_id();

      dfrapi_schedule_single_action(
         date( 'U' ),
         'mycode_import_product_gallery_image',
         compact( 'post_id', 'image_field' ),
         'dfrpswc'
      );
    }

  }

  function product_gallery_image( int $post_id, string $image_field ) {

    $wc_product = wc_get_product( $post_id );

    if ( ! is_a( $wc_product, WC_Product::class ) ) {
      return;
    }

    $dfr_product = dfrps_product( $wc_product->get_id() );

    if ( empty( $dfr_product ) ) {
      return;
    }

    if ( ! isset( $dfr_product[ $image_field ] ) ) {
      return;
    }

    if ( ! dfrapi_starts_with( $dfr_product[ $image_field ], [ 'http', '//' ] ) ) {
      return;
    }

    $gallery_meta_key = '_product_image_gallery';

    $gallery_ids = get_post_meta( $wc_product->get_id(), $gallery_meta_key, true );
    $gallery_ids = array_map( 'absint', array_filter( explode( ',', $gallery_ids ) ) );

    $image_check_meta_key = '_mycode_product_image_gallery_' . $image_field;

    if ( dfrps_image_import_attempted( $wc_product->get_id(), $image_check_meta_key ) ) {
      return;
    }

    $image_data = dfrapi_image_data( $dfr_product[ $image_field ] );

    $image_data->set_title( $wc_product->get_name() );
    $image_data->set_filename( $wc_product->get_name() );
    $image_data->set_description( $wc_product->get_name() );
    $image_data->set_caption( $wc_product->get_name() );
    $image_data->set_alternative_text( $wc_product->get_name() );
    $image_data->set_author_id( dfrpswc_get_post_author_of_product_set_for_product( $wc_product->get_id() ) );
    $image_data->set_post_parent_id( $wc_product->get_id() );
    $image_data->set_post_thumbnail( false );

    $uploader = dfrapi_image_uploader( $image_data );

    $attachment_id = $uploader->upload();

    update_post_meta( $wc_product->get_id(), $image_check_meta_key, 0 );

    if ( ! is_wp_error( $attachment_id ) ) {
      $gallery_ids[] = $attachment_id;
      update_post_meta( $wc_product->get_id(), $gallery_meta_key, implode( ',', $gallery_ids ) );
      update_post_meta( $attachment_id, '_owner_datafeedr', 'mycode' );
    }

  }


}



