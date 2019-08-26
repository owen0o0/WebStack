<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Text sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_sanitize_text' ) ) {
  function cs_sanitize_text( $value, $field ) {
    return wp_filter_nohtml_kses( $value );
  }
  add_filter( 'cs_sanitize_text', 'cs_sanitize_text', 10, 2 );
}

/**
 *
 * Textarea sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_sanitize_textarea' ) ) {
  function cs_sanitize_textarea( $value ) {

    global $allowedposttags;
    return wp_kses( $value, $allowedposttags );

  }
  add_filter( 'cs_sanitize_textarea', 'cs_sanitize_textarea' );
}

/**
 *
 * Checkbox sanitize
 * Do not touch, or think twice.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_sanitize_checkbox' ) ) {
  function cs_sanitize_checkbox( $value ) {

    if( ! empty( $value ) && $value == 1 ) {
      $value = true;
    }

    if( empty( $value ) ) {
      $value = false;
    }

    return $value;

  }
  add_filter( 'cs_sanitize_checkbox', 'cs_sanitize_checkbox' );
  add_filter( 'cs_sanitize_switcher', 'cs_sanitize_checkbox' );
}

/**
 *
 * Image select sanitize
 * Do not touch, or think twice.
 *
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_sanitize_image_select' ) ) {
  function cs_sanitize_image_select( $value ) {

    if( isset( $value ) && is_array( $value ) ) {
      if( count( $value ) ) {
        $value = $value;
      } else {
        $value = $value[0];
      }
    } else if ( empty( $value ) ) {
      $value = '';
    }

    return $value;

  }
  add_filter( 'cs_sanitize_image_select', 'cs_sanitize_image_select' );
}

/**
 *
 * Group sanitize
 * Do not touch, or think twice.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_sanitize_group' ) ) {
  function cs_sanitize_group( $value ) {
    return ( empty( $value ) ) ? '' : $value;
  }
  add_filter( 'cs_sanitize_group', 'cs_sanitize_group' );
}

/**
 *
 * Title sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_sanitize_title' ) ) {
  function cs_sanitize_title( $value ) {
    return sanitize_title( $value );
  }
  add_filter( 'cs_sanitize_title', 'cs_sanitize_title' );
}

/**
 *
 * Text clean
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_sanitize_clean' ) ) {
  function cs_sanitize_clean( $value ) {
    return $value;
  }
  add_filter( 'cs_sanitize_clean', 'cs_sanitize_clean', 10, 2 );
}
