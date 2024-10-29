<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*
 * Adds an option page to Settings.
 */
function amathia_options() {
	add_options_page( esc_html__('Amathia', 'amathia'), esc_html__('Amathia', 'amathia'), 'manage_options', 'amathia.php', 'amathia_options_page');
}
add_action( 'admin_menu', 'amathia_options', 11 );


function amathia_options_page() {

	$locations = get_nav_menu_locations();
	?>
	<div class="wrap amathia">
		<h1><?php esc_html_e( 'Amathia Settings for Accessible Dropdown Menus', 'amathia' ); ?></h1>
	<?php
	if ( isset( $_POST['amathia_options_page'] ) ) {
		if ( ! current_user_can('manage_options') ) {
			die( esc_html__('Cheatin&#8217; uh?', 'amathia' ));
		}

		/* Check Nonce */
		$verified = false;
		if ( isset($_POST['amathia_options_nonce']) ) {
			$verified = wp_verify_nonce( $_POST['amathia_options_nonce'], 'amathia_options_nonce' );
		}
		if ( $verified == false ) {
			// Nonce is invalid.
			echo '<div id="message" class="error fade notice is-dismissible"><p>' . esc_html__('The Nonce did not validate. Please try again.', 'amathia') . '</p></div>';
		} else {
			if ( isset($_POST['amathia_locations']) ) {
				$postdata = $_POST['amathia_locations'];
				$amathia_locations = array();
				foreach ( $locations as $location => $id ) {
					$location = sanitize_text_field( $location );
					$id = sanitize_text_field( $id );
					$postdata["$location"] = sanitize_text_field( $postdata["$location"] );
					// We don't store $postdata, only the locations from the theme.
					if ( isset($postdata["$location"]) && $postdata["$location"] === 'on' ) {
						$amathia_locations[] = $location;
					}
				}
				update_option( 'amathia_locations', $amathia_locations );
				echo '<div id="message" class="updated fade notice is-dismissible"><p>' . esc_html__('Settings updated successfully.', 'amathia') . '</p></div>';
			} else {
				update_option( 'amathia_locations', '' );
				echo '<div id="message" class="updated fade notice is-dismissible"><p>' . esc_html__('Settings updated successfully.', 'amathia') . '</p></div>';
			}
		}
	}
	?>

		<div id="poststuff" class="metabox-holder">

			<p><?php esc_html_e( 'Menu Locations', 'amathia' ); ?></p>
			<form name="amathia_options_page" action="#" method="POST">
			<?php
			/* Nonce */
			$nonce = wp_create_nonce( 'amathia_options_nonce' );
			echo '
				<input type="hidden" id="amathia_options_nonce" name="amathia_options_nonce" value="' . esc_attr( $nonce ) . '" />';

			$locations_settings = get_option('amathia_locations');
			if ( is_array( $locations ) ) {
				foreach ( $locations as $location => $id ) {
					$on = '';
					if ( is_array( $locations_settings ) && in_array( $location, $locations_settings ) ) {
						$on = 'checked="checked"';
					} ?>
					<label>
						<input type="checkbox" <?php echo $on; ?> name="amathia_locations[<?php echo esc_attr( $location ); ?>]" class="amathia-locations" />
						<?php echo esc_html( $location ); ?>
					</label><br />
					<?php
				}
			}
			?><br />

				<span class="setting-description">
					<?php
					esc_html_e('These are the menu locations that are part of your theme. You will probably have a navigation menu set for some locations.', 'amathia');
					echo '<br />';
					esc_html_e('You can select for which locations you want the Amathia buttons added.', 'amathia');
					?>
				</span><br /><br />

				<input type="hidden" class="form" value="amathia_options_page" name="amathia_options_page" />
				<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save', 'amathia' ); ?>"/>
			</form><br /><br />

			<h2 class="widget-top"><?php esc_html_e('Support.', 'amathia'); ?></h2>
			<p><?php
				$support = '<a href="https://wordpress.org/support/plugin/amathia" target="_blank">';
				/* translators: %1$s and %2$s is a link */
				echo sprintf( esc_html__( 'If you have a problem or a feature request, please post it on the %1$ssupport forum at wordpress.org%2$s.', 'amathia' ), $support, '</a>' ); ?>
				<?php esc_html_e('I will do my best to respond as soon as possible.', 'amathia'); ?><br />
				<?php esc_html_e('If you send me an email, I will not reply. Please use the support forum.', 'amathia'); ?><br /><br />
				<?php esc_html_e('Please be aware that this plugin will not fit in with the styling of every theme, often it will require additional CSS styling. It is not possible for me to provide free support in writing your CSS, I expect it will be too much work to do for free.', 'amathia'); ?>
			</p>

			<h2 class="widget-top"><?php esc_html_e('Translations.', 'amathia'); ?></h2>
			<p><?php
				$link = '<a href="https://translate.wordpress.org/projects/wp-plugins/amathia" target="_blank">';
				/* translators: %1$s and %2$s is a link */
				echo sprintf( esc_html__( 'Translations can be added very easily through %1$sGlotPress%2$s.', 'amathia' ), $link, '</a>' ); echo '<br />';
				/* translators: %1$s and %2$s is a link */
				echo sprintf( esc_html__( 'You can start translating strings there for your locale. They need to be validated though, so if there is no validator yet, and you want to apply for being validator (PTE), please post it on the %1$ssupport forum%2$s.', 'amathia' ), $support, '</a>' ); echo '<br />';
				$make = '<a href="https://make.wordpress.org/polyglots/" target="_blank">';
				/* translators: %1$s and %2$s is a link */
				echo sprintf( esc_html__( 'I will make a request on %1$smake/polyglots%2$s to have you added as validator for this plugin/locale.', 'amathia' ), $make, '</a>' ); ?>
			</p>

			<h2 class="widget-top"><?php esc_html_e('Review this plugin.', 'amathia'); ?></h2>
			<p><?php
				$review = '<a href="https://wordpress.org/support/view/plugin-reviews/amathia?rate=5#postform" target="_blank">';
				/* translators: %1$s and %2$s is a link */
				echo sprintf( esc_html__( 'If this plugin has any value to you, then please leave a review at %1$sthe plugin page%2$s at wordpress.org.', 'amathia' ), $review, '</a>' ); ?>
			</p>

		</div>
	</div>
	<?php
}


/*
 * Register Settings.
 */
function amathia_register_settings() {
	//                                      option_name                    sanitize       default value
	register_setting( 'amathia_options',    'amathia_locations',           'array'  ); // serialized array, but initially empty
}
add_action( 'admin_init', 'amathia_register_settings' );


/*
 * Add Settings link to the main plugin page.
 */
function amathia_links( $links, $file ) {
	if ( $file === plugin_basename( __DIR__ . '/amathia.php' ) ) {
		$links[] = '<a href="' . esc_attr( admin_url( 'options-general.php?page=amathia.php' ) ) . '">' . esc_html__( 'Settings', 'amathia' ) . '</a>';
	}
	return $links;
}
add_filter( 'plugin_action_links', 'amathia_links', 10, 2 );
