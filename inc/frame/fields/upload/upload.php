<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Upload
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_upload extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();

    if( isset( $this->field['settings'] ) ) { extract( $this->field['settings'] ); }

    $upload_type  = ( isset( $upload_type  ) ) ? $upload_type  : 'image';
    $button_title = ( isset( $button_title ) ) ? $button_title : esc_html__( '上传', 'cs-framework' );
    $frame_title  = ( isset( $frame_title  ) ) ? $frame_title  : esc_html__( '上传', 'cs-framework' );
    $insert_title = ( isset( $insert_title ) ) ? $insert_title : esc_html__( '使用图像', 'cs-framework' );

    $value = $this->element_value();
    $hidden  = ( empty( $value ) ) ? ' hidden' : '';

    echo '<input type="text" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class() . $this->element_attributes() .'/>';
    echo '<div class="cs-image-preview'. $hidden .'"><div class="cs-preview"><i class="fa fa-times cs-remove"></i><img src="'. $value .'" alt="preview" /></div></div>';
    echo '<a href="#" class="button cs-add" data-frame-title="'. $frame_title .'" data-upload-type="'. $upload_type .'" data-insert-title="'. $insert_title .'">'. $button_title .'</a>';

    echo $this->element_after();

  }
}
