<?php

/**
 * EJT Auto Load
 */
if ( ! class_exists( 'EJT_Autoload' ) ) {
  /**
   * Generic autoloader for classes named in WordPress coding style.
   */
  class ETC_Autoload {

    private $dir = '';

    public function __construct( $dir = '' ) {

      if ( ! empty( $dir ) ) {

        $this->dir = $dir;
      }

      spl_autoload_register( array( $this, 'spl_autoload_register' ) );

    }

    public function spl_autoload_register( $class_name ) {

      $class_path = $this->dir . '/class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';

      if ( file_exists( $class_path ) ){

        include $class_path;

      }

    }

  }
}
