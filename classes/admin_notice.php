<?php
/**
  * Admin Notice
  *
  * @since      1.0.0
  * @package    ckexample
  * @subpackage ckexample/classes
  * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if ( ! class_exists('ckexample_core') ) {
	return;
}

class ckexample_admin_notice {

	/**
	 * CSS Class name.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $class    The CSS Class For The Notice ( error | warning | success | info ).
	 */
	private $class;

	/**
	 * Notice Title.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $title    The Title For The Notice.
	 */
	private $title;

	/**
	 * Notice Title.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $message   HTML Message String.
	 */
	private $message;

	/**
	 * Dismissable Bool.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $dismissable   Adds Dismissable Class.
	 */
	private $dismissable;

	// Define Variables and Add Admin Notice Action
	function __construct( $class, $title, $message, $dismissable = false ) {
		$this->class       = $class;
		$this->title       = $title;
		$this->message     = $message;
		$this->dismissable = $dismissable;
		add_action( 'admin_notices', [ $this, 'render' ] );
	}

	function render() {
		$dismissableClass = $this->dismissable ? 'is-dismissible' : '';
		printf( '<div class="notice notice-%s %s"><p><strong>%s:</strong> %s</p></div>', $this->class, $dismissableClass, $this->title, $this->message );
	}
}
