<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*
 * Filters the sorted list of menu item objects before generating the menu's HTML.
 * It will feed the list of toplevel menu-items to amathia_get_nav_items().
 * It does not change anything in the data that is filtered.
 *
 * @since 1.0.0
 *
 * @param array    $sorted_menu_items The menu items, sorted by each menu item's menu order.
 * @param stdClass $args              An object containing wp_nav_menu() arguments.
 * @return array   $sorted_menu_items The menu items, unchanged.
 */
function amathia_wp_nav_menu_objects( $sorted_menu_items, $args ) {

	$location = $args->theme_location;
	$container = $args->container;
	$container_class = $args->container_class;
	if ( strlen( $container_class ) > 0 ) {
		$element = $container . '.' . $container_class;
	} else {
		$element = 'ul.' . $args->menu_class;
	}
	$locations = get_nav_menu_locations();
	$locations_settings = get_option('amathia_locations');

	amathia_get_container_element( $location, $element );

	if ( strlen( $location ) > 0 && is_array( $locations ) && is_array( $locations_settings ) ) {
		if ( in_array( $location, $locations_settings ) ) {
			$nav_items = array();
			foreach ( $sorted_menu_items as $item ) {
				if ( (int) $item->menu_item_parent === 0 ) {
					if ( isset( $item->classes ) && ! empty( $item->classes ) ) {
						foreach ( $item->classes as $class ) {
							// I suppose we can trust this class, no need to run expensive PHP code.
							if ( $class === 'menu-item-has-children' ) {
								$nav_items[] = $item->ID;
							}
						}
					}
				}
			}
			amathia_get_nav_items( $location, $nav_items );
		}
	}

	return $sorted_menu_items;

}
add_filter( 'wp_nav_menu_objects', 'amathia_wp_nav_menu_objects', 99, 2 );



/*
 * Filters the HTML list content for navigation menus and add a button to toplevel menu-items.
 *
 * @since 1.0.0
 *
 * @see wp_nav_menu()
 *
 * @param string   $items The HTML list content for the menu items.
 * @param stdClass $args  An object containing wp_nav_menu() arguments.
 * @return string  $items The HTML list content for the menu items.
 */
function amathia_wp_nav_menu_items( $items, $args ) {

	$location = $args->theme_location;
	$button = amathia_get_button( $location );
	$nav_items = amathia_get_nav_items( $location );

	if ( isset( $nav_items ) && ! empty( $nav_items ) ) {
		foreach ( $nav_items as $nav_item ) {
			$pattern = '#(<li.+id=["|\']menu-item-' . esc_attr( $nav_item ) . '(.*)[^>]+>)(.+)(</a>)#msiU';
			$replacement = "$0 $button"; // $0 is the matched pattern.
			$items = preg_replace($pattern, $replacement, $items);
		}
	}

	return $items;

}
add_filter( 'wp_nav_menu_items', 'amathia_wp_nav_menu_items', 10, 2 );


/*
 * Set/Get IDs of the toplevel nav-items with children.
 *
 * @param  string $location theme location defined by theme.
 * @param  array  $nav_items list of IDs of nav-items.
 * @return array  (updated) list of IDs of nav-items.
 *
 * @since 1.0.0
 */
function amathia_get_nav_items( $location, $nav_items = array() ) {

	static $items;

	if ( empty( $items ) ) {
		$items = array();
	}

	if ( strlen( $location ) === 0 ) {
		return array();
	}

	if ( ! isset( $items["$location"] ) || empty( $items["$location"] ) ) {
		$items["$location"] = array();
	}

	if ( isset( $nav_items ) && ! empty( $nav_items ) ) {
		$items["$location"] = $nav_items;
	}

	return $items["$location"];

}


/*
 * Set/Get class of the container element of the nav-menu as defined in the $args of the nav-menu.
 * Can be in the format of div.primary-menu.
 *
 * @param  string $location theme location defined by theme.
 * @param  string $element  element of the nav-menu container.
 * @return string $element  element of the nav-menu container.
 *
 * @since 1.0.0
 */
function amathia_get_container_element( $location, $element = '' ) {

	static $locations;

	if ( ! isset( $locations ) ) {
		$locations = array();
	}

	if ( ! isset( $locations["$location"] ) ) {
		$locations["$location"] = '';
	}

	if ( strlen( $element ) > 0 ) {
		$locations["$location"] = $element;
	}

	return $locations["$location"];

}


/*
 * Get HTML for the menu button that will get added after the toplevel ul.
 *
 * @param  string $location theme location defined by theme.
 * @return string html for the button.
 *
 * @since 1.0.0
 */
function amathia_get_button( $location ) {

	$html = '
		<button class="amathia-navigation-toggle amathia-navigation-' . esc_attr( $location ) . '-toggle" aria-expanded="false" aria-controls="nav-submenu-content">
			><span class="screen-reader-text">' . esc_html__('Toggle submenu', 'amathia' ) . '</span>
		</button>';

	$html = apply_filters( 'amathia_get_button', $html );
	return $html;

}


/*
 * Enqueue CSS and JavaScript.
 *
 * @since 1.0.0
 */
function amathia_enqueue() {

	wp_register_script( 'amathia_frontend_js', plugins_url('amathia-frontend.js', __FILE__), 'jquery', AMATHIA_VER, true );
	wp_enqueue_script('amathia_frontend_js');

}
add_action( 'wp_enqueue_scripts', 'amathia_enqueue' );
