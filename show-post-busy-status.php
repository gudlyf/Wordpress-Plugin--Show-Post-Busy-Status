<?php
/*
Plugin Name: Show Post Busy Status
Plugin URI: http://www.gudlyf.com/2008/10/24/wordpress-plugin-show-post-busy-status/
Description: Adds a new column to the post management list that lists the busy status of a post when another user is editing that post. Saves editors from entering a post when the author isn't finished editing it yet.
Author: Keith McDuffee
Version: 1.1
Author URI: http://www.gudlyf.com
*/

/*
Copyright (C) 2008 Keith McDuffee, gudlyf.com (keith AT gudlyf DOT com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Avoid name collisions.
 */
if(!class_exists('KWM_Add_Busy_Status')) {

	class KWM_Add_Busy_Status {
		
		/**
		 * Constructor.
		 */
		function KWM_Add_Busy_Status() { }
		
		/**
		 * Adds busy status near post title if busy.
		 */

		function busy_column($defaults) {
			$defaults['busy'] = __('Busy?');
			return $defaults;
		}

		function busy_custom_column($column_name, $post_id) {
			global $wpdb;
			if( $column_name == 'busy' ) {
				if( $last = wp_check_post_lock( $post_id ) ) {
					$last_user = get_userdata( $last );
                        		$last_user_name = $last_user ? $last_user->display_name : __('Somebody');
					_e('<a href="#" title="');
					echo "Being edited by: " . wp_specialchars( $last_user_name );
					_e('"><font style="weight:bold;color:red;">Yes</font></a><br/>');
				} else {
					_e(' ');
				}
			}
		}

	} //end class

} // end if

/**
 * Insert action and filter hooks here
 */
add_filter('manage_posts_columns', array('KWM_Add_Busy_Status', 'busy_column'));
add_action('manage_posts_custom_column',  array('KWM_Add_Busy_Status', 'busy_custom_column'), 10, 2);
	
?>
