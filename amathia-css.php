<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*
 * Adds CSS to the frontend.
 *
 * @since 1.0.0
 */
function amathia_css() {

	$locations = get_option('amathia_locations'); // only support these.

	if ( ! is_array( $locations ) || empty( $locations ) ) {
		return;
	}
	?>
<style type="text/css" id="amathia-css">
	/*
	 * Amathia: Accessible Dropdown Menus
	 * https://wordpress.org/plugins/amathia/
	 */

	<?php
	foreach ( $locations as $location ) {
		$element = amathia_get_container_element( $location );
		echo '
	html body ' . esc_attr( $element ) . ' li.menu-item-has-children:hover,';
	}
	echo '
	html body ' . esc_attr( $element ) . ' li.menu-item-has-children:hover {';
	?>

		box-shadow: none;
	}
	<?php
	foreach ( $locations as $location ) {
		$element = amathia_get_container_element( $location );
		echo '
	html body ' . esc_attr( $element ) . ' li.menu-item-has-children ul,
	html body ' . esc_attr( $element ) . ' li.menu-item-has-children:hover ul,';
	}
	echo '
	html body ' . esc_attr( $element ) . ' li.menu-item-has-children:hover ul {';
	?>

		display: none;
		opacity: 1;
		visibility: visible;
		transition: none;

		/* You might need this CSS for some themes.
		right: 0;
		left: 0;
		*/

	}

	html body button.amathia-navigation-toggle {
		display: inline-block;
		width: 20px;
		height: 20px;
		font-size: 22px;
		line-height: 0px;
		font-weight: bold;
		font-stretch: expanded;
		text-align: center;
		border: solid 0px transparent;
		padding: 13px 0 13px 0;
		margin: 0 8px 0 -4px;
		background-color: transparent;
		box-shadow: none;
		transform:rotate(-270deg) scale(.8, 2);
	}
	html body button.amathia-navigation-toggle:hover {
		box-shadow: none;
	}
	html body button.amathia-navigation-toggle.amathia-toggled {
		transform:rotate(-90deg) scale(.8, 2);
	}
	html body button.amathia-navigation-toggle:focus {
		outline: 1px solid #fff;
	}
</style>
	<?php
}
add_action( 'wp_footer', 'amathia_css', 1 );
