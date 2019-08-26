<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Number
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_number extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {
    $min = $max = '';
    echo $this->element_before();
    if( isset( $this->field['min'] ) ) {
      $min  = ' min="'.$this->field['min'].'" ';
    }
    if( isset( $this->field['max'] ) ) {
      $max  = ' max="'.$this->field['max'].'" ';
    }
    $unit = ( isset( $this->field['unit'] ) ) ? '<em>'. $this->field['unit'] .'</em>' : '';
    echo '<input type="number" name="'. $this->element_name() .'" '.$min.$max.' value="'. $this->element_value().'"'. $this->element_class() . $this->element_attributes() .'/>'. $unit;
    echo $this->element_after();

  }

}
