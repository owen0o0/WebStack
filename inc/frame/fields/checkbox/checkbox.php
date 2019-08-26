<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Checkbox
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_checkbox extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();

    if( isset( $this->field['options'] ) ) {

      $options  = $this->field['options'];
      $options  = ( is_array( $options ) ) ? $options : array_filter( $this->element_data( $options ) );

      if( ! empty( $options ) ) {

        echo '<ul'. $this->element_class() .'>';
        foreach ( $options as $key => $value ) {
          echo '<li><label><input type="checkbox" name="'. $this->element_name( '[]' ) .'" value="'. $key .'"'. $this->element_attributes( $key ) . $this->checked( $this->element_value(), $key ) .'/> '.$value.'</label></li>';
        }
        echo '</ul>';
      }

    } else {
      $label = ( isset( $this->field['label'] ) ) ? $this->field['label'] : '';
      echo '<label><input type="checkbox" name="'. $this->element_name() .'" value="1"'. $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) .'/> '. $label .'</label>';
    }

    echo $this->element_after();

  }

}
