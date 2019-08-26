<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Wysiwyg
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_Wysiwyg extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();

    $defaults = array(
      'textarea_rows' => 10,
      'textarea_name' => $this->element_name()
    );

    $settings    = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
    $settings    = wp_parse_args( $settings, $defaults );

    $field_id    = ( ! empty( $this->field['id'] ) ) ? $this->field['id'] : '';
    $field_value = $this->element_value();

    wp_editor( $field_value, $field_id, $settings );

    echo $this->element_after();

  }

}
