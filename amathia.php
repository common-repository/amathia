<?php
/*
Plugin Name: Amathia: Accessible Dropdown Menus
Plugin URI: https://wordpress.org/plugins/amathia/
Description: Amathia makes dropdown menus accessible. It adds a button to each dropdown menu, which can be easily clicked to open the submenu.
Version: 1.0.2
Author: Marcel Pol
Author URI: https://timelord.nl
License: GPLv2 or later
Text Domain: amathia
Domain Path: /lang/


Copyright 2020 - 2024  Marcel Pol  (marcel@timelord.nl)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// Plugin Version
define('AMATHIA_VER', '1.0.2');


/*
 * Todo List:
 *
 * - Support more themes.
 *
 */


/*
 * Definitions
 */
define('AMATHIA_FOLDER', plugin_basename( __DIR__ ));
define('AMATHIA_DIR', WP_PLUGIN_DIR . '/' . AMATHIA_FOLDER);
define('AMATHIA_URL', plugins_url( '/', __FILE__ ));


// Functions for the frontend.
require_once AMATHIA_DIR . '/amathia-css.php';
require_once AMATHIA_DIR . '/amathia-nav-menu.php';

// Functions and pages for the backend.
if ( is_admin() ) {
	require_once AMATHIA_DIR . '/amathia-admin-settings.php';
}
