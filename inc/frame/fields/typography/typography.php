<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Typography
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_typography extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();

    $defaults_value = array(
      'family'  => 'Arial',
      'variant' => 'regular',
      'font'    => 'websafe',
    );

    $default_variants = apply_filters( 'cs_websafe_fonts_variants', array(
      'regular',
      'italic',
      '700',
      '700italic',
      'inherit'
    ));

    $websafe_fonts = apply_filters( 'cs_websafe_fonts', array(
      'Arial',
      'Arial Black',
      'Comic Sans MS',
      'Impact',
      'Lucida Sans Unicode',
      'Tahoma',
      'Trebuchet MS',
      'Verdana',
      'Courier New',
      'Lucida Console',
      'Georgia, serif',
      'Palatino Linotype',
      'Times New Roman'
    ));

    $value         = wp_parse_args( $this->element_value(), $defaults_value );
    $family_value  = $value['family'];
    $variant_value = $value['variant'];
    $is_variant    = ( isset( $this->field['variant'] ) && $this->field['variant'] === false ) ? false : true;
    $is_chosen     = ( isset( $this->field['chosen'] ) && $this->field['chosen'] === false ) ? '' : 'chosen ';
    $google_json   = cs_get_google_fonts();
    $chosen_rtl    = ( is_rtl() && ! empty( $is_chosen ) ) ? 'chosen-rtl ' : '';

    if( is_object( $google_json ) ) {

      $googlefonts = array();

      foreach ( $google_json->items as $key => $font ) {
        $googlefonts[$font->family] = $font->variants;
      }

      $is_google = ( array_key_exists( $family_value, $googlefonts ) ) ? true : false;

      echo '<label class="cs-typography-family">';
      echo '<select name="'. $this->element_name( '[family]' ) .'" class="'. $is_chosen . $chosen_rtl .'cs-typo-family" data-atts="family"'. $this->element_attributes() .'>';

      do_action( 'cs_typography_family', $family_value, $this );

      echo '<optgroup label="'. esc_html__( '网络安全字体', 'cs-framework' ) .'">';
      foreach ( $websafe_fonts as $websafe_value ) {
        echo '<option value="'. $websafe_value .'" data-variants="'. implode( '|', $default_variants ) .'" data-type="websafe"'. selected( $websafe_value, $family_value, true ) .'>'. $websafe_value .'</option>';
      }
      echo '</optgroup>';

      echo '<optgroup label="'. esc_html__( '谷歌字体', 'cs-framework' ) .'">';
      foreach ( $googlefonts as $google_key => $google_value ) {
        echo '<option value="'. $google_key .'" data-variants="'. implode( '|', $google_value ) .'" data-type="google"'. selected( $google_key, $family_value, true ) .'>'. $google_key .'</option>';
      }
      echo '</optgroup>';

      echo '</select>';
      echo '</label>';

      if( ! empty( $is_variant ) ) {

        $variants = ( $is_google ) ? $googlefonts[$family_value] : $default_variants;
        $variants = ( $value['font'] === 'google' || $value['font'] === 'websafe' ) ? $variants : array( 'regular' );

        echo '<label class="cs-typography-variant">';
        echo '<select name="'. $this->element_name( '[variant]' ) .'" class="'. $is_chosen . $chosen_rtl .'cs-typo-variant" data-atts="variant">';
        foreach ( $variants as $variant ) {
          echo '<option value="'. $variant .'"'. $this->checked( $variant_value, $variant, 'selected' ) .'>'. $variant .'</option>';
        }
        echo '</select>';
        echo '</label>';

      }

      echo '<input type="text" name="'. $this->element_name( '[font]' ) .'" class="cs-typo-font hidden" data-atts="font" value="'. $value['font'] .'" />';

    } else {

      echo esc_html__( '错误！不能加载json文件', 'cs-framework' );

    }

    echo $this->element_after();

  }

}
