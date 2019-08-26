<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_backup extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();

    echo '<textarea name="'. $this->unique .'[import]"'. $this->element_class() . $this->element_attributes() .'></textarea>';
    submit_button( esc_html__( '导入备份', 'cs-framework' ), 'primary cs-import-backup', 'backup', false );
    echo '<small>( '. esc_html__( '复制粘贴您的备份字符串到这里', 'cs-framework' ).' )</small>';

    echo '<hr />';

    echo '<textarea name="_nonce"'. $this->element_class() . $this->element_attributes() .' disabled="disabled">'. cs_encode_string( get_option( $this->unique ) ) .'</textarea>';
    echo '<a href="'. admin_url( 'admin-ajax.php?action=cs-export-options' ) .'" class="button button-primary" target="_blank">'. esc_html__( '导出下载备份', 'cs-framework' ) .'</a>';
    echo '<small>-( '. esc_html__( '或者', 'cs-framework' ) .' )-</small>';
    submit_button( esc_html__( '重置所有选项', 'cs-framework' ), 'cs-warning-primary cs-reset-confirm', $this->unique . '[resetall]', false );
    echo '<small class="cs-text-warning">'. esc_html__( '确认重置所有选项', 'cs-framework' ) .'</small>';

    echo $this->element_after();

  }

}
