

/*
 * Disable hovers for submenu, we use the button now.
 */
jQuery(document).ready(function($) {

	jQuery('button.amathia-navigation-toggle').each( function( index, button ) {
		var ul = jQuery(this).closest('ul');
		var li = jQuery(this).closest('li');
		jQuery( 'ul.sub-menu', ul ).css( 'display', 'none' );
		jQuery( 'ul.sub-menu', ul ).css( 'opacity', '1' );
		jQuery( 'ul.sub-menu', ul ).css( 'visibility', 'visible' );
		jQuery( 'li:hover ul.sub-menu', ul ).css( 'display', 'none' );

		var color = jQuery( 'a', li ).css( 'color' );
		jQuery(this).css( 'color', color );
	});

});


/*
 * Provide a button and submenu that can be toggled.
 */
jQuery(document).ready(function($) {

	jQuery('button.amathia-navigation-toggle').on('click', function() {

		var was_toggled = false;
		var ul = jQuery(this).closest('ul');
		var listitem = jQuery(this).parent();
		if ( jQuery( this ).hasClass('amathia-toggled') ) {
			was_toggled = true;
		}

		// reset all submenus.
		jQuery( 'ul.sub-menu', ul ).css( 'display', 'none' );
		jQuery( 'button.amathia-navigation-toggle', ul ).removeClass('amathia-toggled');

		if ( was_toggled == false ) {
			jQuery( this ).addClass('amathia-toggled'); // gebruik icon-chevron-up.png.
			jQuery( 'ul.sub-menu', listitem ).fadeIn( 300 ); // maak submenu zichtbaar.
			jQuery( 'ul.sub-menu', listitem ).css( 'display', 'block' );
		}

		return false;

	});

});
