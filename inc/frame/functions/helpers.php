<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Add framework element
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_add_element' ) ) {
  function cs_add_element( $field = array(), $value = '', $unique = '' ) {

    $output     = '';
    $depend     = '';
    $sub        = ( isset( $field['sub'] ) ) ? 'sub-': '';
    $unique     = ( isset( $unique ) ) ? $unique : '';
    $languages  = cs_language_defaults();
    $class      = 'CSFramework_Option_' . $field['type'];
    $wrap_class = ( isset( $field['wrap_class'] ) ) ? ' ' . $field['wrap_class'] : '';
    $el_class   = ( isset( $field['title'] ) ) ? sanitize_title( $field['title'] ) : 'no-title';
    $hidden     = ( isset( $field['show_only_language'] ) && ( $field['show_only_language'] != $languages['current'] ) ) ? ' hidden' : '';
    $is_pseudo  = ( isset( $field['pseudo'] ) ) ? ' cs-pseudo-field' : '';

    if ( isset( $field['dependency'] ) ) {
      $hidden  = ' hidden';
      $depend .= ' data-'. $sub .'controller="'. $field['dependency'][0] .'"';
      $depend .= ' data-'. $sub .'condition="'. $field['dependency'][1] .'"';
      $depend .= ' data-'. $sub .'value="'. $field['dependency'][2] .'"';
    }

    $output .= '<div class="cs-element cs-element-'. $el_class .' cs-field-'. $field['type'] . $is_pseudo . $wrap_class . $hidden .'"'. $depend .'>';

    if( isset( $field['title'] ) ) {
      $field_desc = ( isset( $field['desc'] ) ) ? '<p class="cs-text-desc">'. $field['desc'] .'</p>' : '';
      $output .= '<div class="cs-title"><h4>' . $field['title'] . '</h4>'. $field_desc .'</div>';
    }

    $output .= ( isset( $field['title'] ) ) ? '<div class="cs-fieldset">' : '';

    $value   = ( !isset( $value ) && isset( $field['default'] ) ) ? $field['default'] : $value;
    $value   = ( isset( $field['value'] ) ) ? $field['value'] : $value;

    if( class_exists( $class ) ) {
      ob_start();
      $element = new $class( $field, $value, $unique );
      $element->output();
      $output .= ob_get_clean();
    } else {
      $output .= '<p>'. esc_html__( '此字段不可用！', 'cs-framework' ) .'</p>';
    }

    $output .= ( isset( $field['title'] ) ) ? '</div>' : '';
    $output .= '<div class="clear"></div>';
    $output .= '</div>';

    return $output;

  }
}

/**
 *
 * Encode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_encode_string' ) ) {
  function cs_encode_string( $string ) {
    return serialize( $string );
  }
}

/**
 *
 * Decode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_decode_string' ) ) {
  function cs_decode_string( $string ) {
    return unserialize( $string );
  }
}

/**
 *
 * Get google font from json file
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_get_google_fonts' ) ) {
  function cs_get_google_fonts() {

    global $cs_google_fonts;

    if( ! empty( $cs_google_fonts ) ) {

      return $cs_google_fonts;

    } else {

      ob_start();
      cs_locate_template( 'fields/typography/google-fonts.json' );
      $json = ob_get_clean();

      $cs_google_fonts = json_decode( $json );

      return $cs_google_fonts;
    }

  }
}

/**
 *
 * Get icon fonts from json file
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_get_icon_fonts' ) ) {
  function cs_get_icon_fonts( $file ) {

    ob_start();
    cs_locate_template( $file );
    $json = ob_get_clean();

    return json_decode( $json );

  }
}

/**
 *
 * Array search key & value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_array_search' ) ) {
  function cs_array_search( $array, $key, $value ) {

    $results = array();

    if ( is_array( $array ) ) {
      if ( isset( $array[$key] ) && $array[$key] == $value ) {
        $results[] = $array;
      }

      foreach ( $array as $sub_array ) {
        $results = array_merge( $results, cs_array_search( $sub_array, $key, $value ) );
      }

    }

    return $results;

  }
}

/**
 *
 * Getting POST Var
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_get_var' ) ) {
  function cs_get_var( $var, $default = '' ) {

    if( isset( $_POST[$var] ) ) {
      return $_POST[$var];
    }

    if( isset( $_GET[$var] ) ) {
      return $_GET[$var];
    }

    return $default;

  }
}

/**
 *
 * Getting POST Vars
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_get_vars' ) ) {
  function cs_get_vars( $var, $depth, $default = '' ) {

    if( isset( $_POST[$var][$depth] ) ) {
      return $_POST[$var][$depth];
    }

    if( isset( $_GET[$var][$depth] ) ) {
      return $_GET[$var][$depth];
    }

    return $default;

  }
}

/**
 *
 * Load options fields
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_load_option_fields' ) ) {
  function cs_load_option_fields() {

    $located_fields = array();

    foreach ( glob( CS_DIR .'/fields/*/*.php' ) as $cs_field ) {
      $located_fields[] = basename( $cs_field );
      cs_locate_template( str_replace(  CS_DIR, '', $cs_field ) );
    }

    $override_name = apply_filters( 'cs_framework_override', 'cs-framework-override' );
    $override_dir  = get_template_directory() .'/'. $override_name .'/fields';

    if( is_dir( $override_dir ) ) {

      foreach ( glob( $override_dir .'/*/*.php' ) as $override_field ) {

        if( ! in_array( basename( $override_field ), $located_fields ) ) {

          cs_locate_template( str_replace( $override_dir, '/fields', $override_field ) );

        }

      }

    }

    do_action( 'cs_load_option_fields' );

  }
}
