<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Email validate
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_validate_email' ) ) {
  function cs_validate_email( $value, $field ) {

    if ( ! sanitize_email( $value ) ) {
      return esc_html__( '请填写有效的邮箱地址！', 'cs-framework' );
    }

  }
  add_filter( 'cs_validate_email', 'cs_validate_email', 10, 2 );
}

/**
 *
 * Numeric validate
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_validate_numeric' ) ) {
  function cs_validate_numeric( $value, $field ) {

    if ( ! is_numeric( $value ) ) {
      return esc_html__( '请写一个数字！', 'cs-framework' );
    }

  }
  add_filter( 'cs_validate_numeric', 'cs_validate_numeric', 10, 2 );
}

/**
 *
 * Required validate
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_validate_required' ) ) {
  function cs_validate_required( $value ) {
    if ( empty( $value ) ) {
      return esc_html__( '致命错误！ 这是必填项！', 'cs-framework' );
    }
  }
  add_filter( 'cs_validate_required', 'cs_validate_required' );
}
