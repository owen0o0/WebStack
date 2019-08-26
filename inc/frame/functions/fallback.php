<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * A fallback for get term meta
 * get_term_meta added since WP 4.4
 *
 * @since 1.0.2
 * @version 1.0.0
 *
 */
if( ! function_exists( 'get_term_meta' ) ) {
  function get_term_meta( $term_id, $key = '', $single = false ) {

    $terms = get_option( 'cs_term_'. $key );

    return ( ! empty( $terms[$term_id] ) ) ? $terms[$term_id] : false;

  }
}

/**
 *
 * A fallback for add term meta
 * add_term_meta added since WP 4.4
 *
 * @since 1.0.2
 * @version 1.0.0
 *
 */
if( ! function_exists( 'add_term_meta' ) ) {
  function add_term_meta( $term_id, $meta_key = '', $meta_value, $unique = false ) {

    return update_term_meta( $term_id, $meta_key, $meta_value, $unique );

  }
}

/**
 *
 * A fallback for update term meta
 * update_term_meta added since WP 4.4
 *
 * @since 1.0.2
 * @version 1.0.0
 *
 */
if( ! function_exists( 'update_term_meta' ) ) {
  function update_term_meta( $term_id, $meta_key, $meta_value, $prev_value = '' ) {

    if ( ! empty( $term_id ) || ! empty( $meta_key ) || ! empty( $meta_value ) ) {

      $terms = get_option( 'cs_term_'. $meta_key );

      $terms[$term_id] = $meta_value;

      update_option( 'cs_term_'. $meta_key, $terms );

    }

  }
}

/**
 *
 * A fallback for delete term meta
 * delete_term_meta added since WP 4.4
 *
 * @since 1.0.2
 * @version 1.0.0
 *
 */
if( ! function_exists( 'delete_term_meta' ) ) {
  function delete_term_meta( $term_id, $meta_key, $meta_value = '', $delete_all = false ) {

    if ( ! empty( $term_id ) || ! empty( $meta_key ) ) {

      $terms = get_option( 'cs_term_'. $meta_key );

      unset( $terms[$term_id] );

      update_option( 'cs_term_'. $meta_key, $terms );

    }

  }
}
