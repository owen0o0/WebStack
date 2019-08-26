<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Get icons from admin ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_get_icons' ) ) {
  function cs_get_icons() {

    do_action( 'cs_add_icons_before' );

    $jsons = apply_filters( 'cs_add_icons_json', glob( CS_DIR . '/fields/icon/*.json' ) );

    if( ! empty( $jsons ) ) {

      foreach ( $jsons as $path ) {

        $object = cs_get_icon_fonts( 'fields/icon/'. basename( $path ) );

        if( is_object( $object ) ) {

          echo ( count( $jsons ) >= 2 ) ? '<h4 class="cs-icon-title">'. $object->name .'</h4>' : '';

          foreach ( $object->icons as $icon ) {
            echo '<a class="cs-icon-tooltip" data-cs-icon="'. $icon .'" data-title="'. $icon .'"><span class="cs-icon cs-selector"><i class="'. $icon .'"></i></span></a>';
          }

        } else {
          echo '<h4 class="cs-icon-title">'. esc_html__( '错误！不能加载json文件', 'cs-framework' ) .'</h4>';
        }

      }

    }

    do_action( 'cs_add_icons' );
    do_action( 'cs_add_icons_after' );

    die();
  }
  add_action( 'wp_ajax_cs-get-icons', 'cs_get_icons' );
}

/**
 *
 * Export options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_export_options' ) ) {
  function cs_export_options() {

    header('Content-Type: plain/text');
    header('Content-disposition: attachment; filename=backup-options-'. gmdate( 'd-m-Y' ) .'.txt');
    header('Content-Transfer-Encoding: binary');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo cs_encode_string( get_option( CS_OPTION ) );

    die();
  }
  add_action( 'wp_ajax_cs-export-options', 'cs_export_options' );
}

/**
 *
 * Set icons for wp dialog
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_set_icons' ) ) {
  function cs_set_icons() {

    echo '<div id="cs-icon-dialog" class="cs-dialog" title="'. esc_html__( '添加Icon', 'cs-framework' ) .'">';
    echo '<div class="cs-dialog-header cs-text-center"><input type="text" placeholder="'. esc_html__( '查找Icon...', 'cs-framework' ) .'" class="cs-icon-search" /></div>';
    echo '<div class="cs-dialog-load"><div class="cs-icon-loading">'. esc_html__( '加载...', 'cs-framework' ) .'</div></div>';
    echo '</div>';

  }
  add_action( 'admin_footer', 'cs_set_icons' );
  add_action( 'customize_controls_print_footer_scripts', 'cs_set_icons' );
}
