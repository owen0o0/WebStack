<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Framework Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework extends CSFramework_Abstract {

  /**
   *
   * option database/data name
   * @access public
   * @var string
   *
   */
  public $unique = CS_OPTION;

  /**
   *
   * settings
   * @access public
   * @var array
   *
   */
  public $settings = array();

  /**
   *
   * options tab
   * @access public
   * @var array
   *
   */
  public $options = array();

  /**
   *
   * options section
   * @access public
   * @var array
   *
   */
  public $sections = array();

  /**
   *
   * options store
   * @access public
   * @var array
   *
   */
  public $get_option = array();

  /**
   *
   * instance
   * @access private
   * @var class
   *
   */
  private static $instance = null;

  // run framework construct
  public function __construct( $settings, $options ) {

    $this->settings = apply_filters( 'cs_framework_settings', $settings );
    $this->options  = apply_filters( 'cs_framework_options', $options );

    if( ! empty( $this->options ) ) {

      $this->sections   = $this->get_sections();
      $this->get_option = get_option( CS_OPTION );
      $this->addAction( 'admin_init', 'settings_api' );
      $this->addAction( 'admin_menu', 'admin_menu' );

    }

  }

  // instance
  public static function instance( $settings = array(), $options = array() ) {
    if ( is_null( self::$instance ) && CS_ACTIVE_FRAMEWORK ) {
      self::$instance = new self( $settings, $options );
    }
    return self::$instance;
  }

  // get sections
  public function get_sections() {

    $sections = array();

    foreach ( $this->options as $key => $value ) {

      if( isset( $value['sections'] ) ) {

        foreach ( $value['sections'] as $section ) {

          if( isset( $section['fields'] ) ) {
            $sections[] = $section;
          }

        }

      } else {

        if( isset( $value['fields'] ) ) {
          $sections[] = $value;
        }

      }

    }

    return $sections;

  }

  // wp settings api
  public function settings_api() {

    $defaults = array();

    foreach( $this->sections as $section ) {

      register_setting( $this->unique .'_group', $this->unique, array( &$this,'validate_save' ) );

      if( isset( $section['fields'] ) ) {

        add_settings_section( $section['name'] .'_section', $section['title'], '', $section['name'] .'_section_group' );

        foreach( $section['fields'] as $field_key => $field ) {

          add_settings_field( $field_key .'_field', '', array( &$this, 'field_callback' ), $section['name'] .'_section_group', $section['name'] .'_section', $field );

          // set default option if isset
          if( isset( $field['default'] ) ) {
            $defaults[$field['id']] = $field['default'];
            if( ! empty( $this->get_option ) && ! isset( $this->get_option[$field['id']] ) ) {
              $this->get_option[$field['id']] = $field['default'];
            }
          }

        }
      }

    }

    // set default variable if empty options and not empty defaults
    if( empty( $this->get_option )  && ! empty( $defaults ) ) {
      update_option( $this->unique, $defaults );
      $this->get_option = $defaults;
    }

  }

  // section fields validate in save
  public function validate_save( $request ) {

    $add_errors = array();
    $section_id = cs_get_var( 'cs_section_id' );

    // ignore nonce requests
    if( isset( $request['_nonce'] ) ) { unset( $request['_nonce'] ); }

    // import
    if ( isset( $request['import'] ) && ! empty( $request['import'] ) ) {
      $decode_string = cs_decode_string( $request['import'] );
      if( is_array( $decode_string ) ) {
        return $decode_string;
      }
      $add_errors[] = $this->add_settings_error( esc_html__( '成功导入备份选项。', 'cs-framework' ), 'updated' );
    }

    // reset all options
    if ( isset( $request['resetall'] ) ) {
      $add_errors[] = $this->add_settings_error( esc_html__( '默认选项恢复。', 'cs-framework' ), 'updated' );
      return;
    }

    // reset only section
    if ( isset( $request['reset'] ) && ! empty( $section_id ) ) {
      foreach ( $this->sections as $value ) {
        if( $value['name'] == $section_id ) {
          foreach ( $value['fields'] as $field ) {
            if( isset( $field['id'] ) ) {
              if( isset( $field['default'] ) ) {
                $request[$field['id']] = $field['default'];
              } else {
                unset( $request[$field['id']] );
              }
            }
          }
        }
      }
      $add_errors[] = $this->add_settings_error( esc_html__( '当前节点已恢复到默认选项。', 'cs-framework' ), 'updated' );
    }

    // option sanitize and validate
    foreach( $this->sections as $section ) {
      if( isset( $section['fields'] ) ) {
        foreach( $section['fields'] as $field ) {

          // ignore santize and validate if element multilangual
          if ( isset( $field['type'] ) && ! isset( $field['multilang'] ) && isset( $field['id'] ) ) {

            // sanitize options
            $request_value = isset( $request[$field['id']] ) ? $request[$field['id']] : '';
            $sanitize_type = $field['type'];

            if( isset( $field['sanitize'] ) ) {
              $sanitize_type = ( $field['sanitize'] !== false ) ? $field['sanitize'] : false;
            }

            if( $sanitize_type !== false && has_filter( 'cs_sanitize_'. $sanitize_type ) ) {
              $request[$field['id']] = apply_filters( 'cs_sanitize_' . $sanitize_type, $request_value, $field, $section['fields'] );
            }

            // validate options
            if ( isset( $field['validate'] ) && has_filter( 'cs_validate_'. $field['validate'] ) ) {

              $validate = apply_filters( 'cs_validate_' . $field['validate'], $request_value, $field, $section['fields'] );

              if( ! empty( $validate ) ) {
                $add_errors[] = $this->add_settings_error( $validate, 'error', $field['id'] );
                $request[$field['id']] = ( isset( $this->get_option[$field['id']] ) ) ? $this->get_option[$field['id']] : '';
              }

            }

          }

          if( ! isset( $field['id'] ) || empty( $request[$field['id']] ) ) {
            continue;
          }

        }
      }
    }

    $request = apply_filters( 'cs_validate_save', $request );

    do_action( 'cs_validate_save_after', $request );

    // set transient
    $transient_time = ( cs_language_defaults() !== false ) ? 30 : 10;
    set_transient( 'cs-framework-transient', array( 'errors' => $add_errors, 'section_id' => $section_id ), $transient_time );

    return $request;
  }

  // field callback classes
  public function field_callback( $field ) {
    $value = ( isset( $field['id'] ) && isset( $this->get_option[$field['id']] ) ) ? $this->get_option[$field['id']] : '';
    echo cs_add_element( $field, $value, $this->unique );
  }

  // settings sections
  public function do_settings_sections( $page ) {

    global $wp_settings_sections, $wp_settings_fields;

    if ( ! isset( $wp_settings_sections[$page] ) ){
      return;
    }

    foreach ( $wp_settings_sections[$page] as $section ) {

      if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) ){
        continue;
      }

      do_settings_fields( $page, $section['id'] );

    }

  }

  public function add_settings_error( $message, $type = 'error', $id = 'global' ) {
    return array( 'setting' => 'cs-errors', 'code' => $id, 'message' => $message, 'type' => $type );
  }

  // adding option page
    public function admin_menu() {

      $defaults = array(
        'menu_parent'     => '',
        'menu_title'      => '',
        'menu_type'       => '',
        'menu_slug'       => '',
        'menu_icon'       => '',
        'menu_capability' => 'manage_options',
        'menu_position'   => null,
      );

      $args = wp_parse_args( $this->settings, $defaults );

      switch ( $args['menu_type'] ) {

        case 'submenu':
          add_submenu_page( $args['menu_parent'], $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ) );
        break;

        case 'dashboard':
          add_dashboard_page( $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ), $args['menu_icon'], $args['menu_position'] );
        break;

        case 'management':
          add_management_page( $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ), $args['menu_icon'], $args['menu_position'] );
        break;

        case 'plugins':
          add_plugins_page( $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ), $args['menu_icon'], $args['menu_position'] );
        break;

        case 'theme':
          add_theme_page( $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ), $args['menu_icon'], $args['menu_position'] );
        break;

        case 'options':
          add_options_page( $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ), $args['menu_icon'], $args['menu_position'] );
        break;

        default:
          add_menu_page( $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ), $args['menu_icon'], $args['menu_position'] );
        break;

      }

    }


  // option page html output
  public function admin_page() {

    $transient  = get_transient( 'cs-framework-transient' );
    $has_nav    = ( count( $this->options ) <= 1 ) ? ' cs-show-all' : '';
    $section_id = ( ! empty( $transient['section_id'] ) ) ? $transient['section_id'] : $this->sections[0]['name'];
    $section_id = cs_get_var( 'cs-section', $section_id );

    echo '<div class="cs-framework cs-option-framework">';

      echo '<form method="post" action="options.php" enctype="multipart/form-data" id="csframework_form">';
      echo '<input type="hidden" class="cs-reset" name="cs_section_id" value="'. $section_id .'" />';

      if( $this->settings['ajax_save'] !== true && ! empty( $transient['errors'] ) ) {

        global $cs_errors;

        $cs_errors = $transient['errors'];

        if ( ! empty( $cs_errors ) ) {
          foreach ( $cs_errors as $error ) {
            if( in_array( $error['setting'], array( 'general', 'cs-errors' ) ) ) {
              echo '<div class="cs-settings-error '. $error['type'] .'">';
              echo '<p><strong>'. $error['message'] .'</strong></p>';
              echo '</div>';
            }
          }
        }

      }

      settings_fields( $this->unique. '_group' );

      echo '<div class="csf-header csf-sticky-header">';
      echo '<div class="csf-header-inner">';
      echo '<h1>'. $this->settings['framework_title'] .'</h1>';
      echo '<fieldset>';

      echo ( $this->settings['ajax_save'] ) ? '<span id="cs-save-ajax">'. esc_html__( '设置已保存', 'cs-framework' ) .'</span>' : '';

      submit_button( esc_html__( '保存', 'cs-framework' ), 'primary cs-save', 'save', false, array( 'data-save' => esc_html__( '保存...', 'cs-framework' ) ) );
      submit_button( esc_html__( '恢复', 'cs-framework' ), 'secondary cs-restore cs-reset-confirm', $this->unique .'[reset]', false );

      if( $this->settings['show_reset_all'] ) {
        submit_button( esc_html__( '重置所有选项', 'cs-framework' ), 'secondary cs-restore cs-warning-primary cs-reset-confirm', $this->unique .'[resetall]', false );
      }

      echo '</fieldset>';
      echo ( empty( $has_nav ) ) ? '<a href="#" class="cs-expand-all"><i class="fa fa-eye-slash"></i> '. esc_html__( '显示所有选项', 'cs-framework' ) .'</a>' : '';
      echo '<div class="clear"></div>';
      echo '</div>';
      echo '</div>'; // end .cs-header

      echo '<div class="cs-body'. $has_nav .'">';

        echo '<div class="cs-nav">';

          echo '<ul>';
          foreach ( $this->options as $key => $tab ) {

            if( ( isset( $tab['sections'] ) ) ) {

              $tab_active   = cs_array_search( $tab['sections'], 'name', $section_id );
              $active_style = ( ! empty( $tab_active ) ) ? ' style="display: block;"' : '';
              $active_list  = ( ! empty( $tab_active ) ) ? ' cs-tab-active' : '';
              $tab_icon     = ( ! empty( $tab['icon'] ) ) ? '<i class="cs-icon '. $tab['icon'] .'"></i>' : '';

              echo '<li class="cs-sub'. $active_list .'">';

                echo '<a href="#" class="cs-arrow">'. $tab_icon . $tab['title'] .'</a>';

                echo '<ul'. $active_style .'>';
                foreach ( $tab['sections'] as $tab_section ) {

                  $active_tab = ( $section_id == $tab_section['name'] ) ? ' class="cs-section-active"' : '';
                  $icon = ( ! empty( $tab_section['icon'] ) ) ? '<i class="cs-icon '. $tab_section['icon'] .'"></i>' : '';

                  echo '<li><a href="#"'. $active_tab .' data-section="'. $tab_section['name'] .'">'. $icon . $tab_section['title'] .'</a></li>';

                }
                echo '</ul>';

              echo '</li>';

            } else {

              $icon = ( ! empty( $tab['icon'] ) ) ? '<i class="cs-icon '. $tab['icon'] .'"></i>' : '';

              if( isset( $tab['fields'] ) ) {

                $active_list = ( $section_id == $tab['name'] ) ? ' class="cs-section-active"' : '';
                echo '<li><a href="#"'. $active_list .' data-section="'. $tab['name'] .'">'. $icon . $tab['title'] .'</a></li>';

              } else {

                echo '<li><div class="cs-seperator">'. $icon . $tab['title'] .'</div></li>';

              }

            }

          }
          echo '</ul>';

        echo '</div>'; // end .cs-nav

        echo '<div class="cs-content">';

          echo '<div class="cs-sections">';

          foreach( $this->sections as $section ) {

            if( isset( $section['fields'] ) ) {

              $active_content = ( $section_id == $section['name'] ) ? ' style="display: block;"' : '';
              echo '<div id="cs-tab-'. $section['name'] .'" class="cs-section"'. $active_content .'>';
              echo ( isset( $section['title'] ) && empty( $has_nav ) ) ? '<div class="cs-section-title"><h3>'. $section['title'] .'</h3></div>' : '';
              $this->do_settings_sections( $section['name'] . '_section_group' );
              echo '</div>';

            }

          }

          echo '</div>'; // end .cs-sections

          echo '<div class="clear"></div>';

        echo '</div>'; // end .cs-content

        echo '<div class="cs-nav-background"></div>';

      echo '</div>'; // end .cs-body

      echo '<footer class="cs-footer">';
      echo '<div class="cs-block-left">'.esc_html__('运行在', 'cs-framework' ).'： WordPress '. get_bloginfo('version') .' / PHP '. PHP_VERSION .'</div>';
      echo '<div class="cs-block-right">&copy; 2019 Theme By <a href="https://www.iowen.cn" target="_blank" style="color: #888;text-decoration: none;"> 一为</a></div>';
      echo '<div class="clear"></div>';
      echo '</footer>'; // end .cs-footer

      echo '</form>'; // end form

      echo '<div class="clear"></div>';

    echo '</div>'; // end .cs-framework

  }

}
