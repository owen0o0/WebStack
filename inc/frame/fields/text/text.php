<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Text
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_text extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output(){

    echo $this->element_before();
    echo '<input type="'. $this->element_type() .'" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class() . $this->element_attributes() .'/>';
    echo $this->element_after();

  }

}
