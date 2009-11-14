<?php
/*
Plugin Name: Nasza Klasa - Wizytówka
Plugin URI: http://www.poradnik-webmastera.com/projekty/nasza_klasa_wizytowka/
Description: Wyświetla wizytówkę z serwisu Nasza-Klasa.pl.
Author: Daniel Frużyński
Version: 1.0.4
Author URI: http://www.poradnik-webmastera.com/
Text Domain: nasza-klasa
*/

/*  Copyright 2009  Daniel Frużyński  (email : daniel [A-T] poradnik-webmastera.com)

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


if ( !class_exists( 'NaszaKlasaWizytowka' ) ) {
	class NaszaKlasaWizytowka {
		// Constructor
		function NaszaKlasaWizytowka() {
			// Initialize plugin
			add_action( 'init', array( &$this, 'init' ) );
			
			// Widgets initialization
			add_action( 'widgets_init', array( &$this, 'widgets_init' ) );
		}
		
		// Plugin initialization
		function init() {
		}
		
		// Widgets initialization
		function widgets_init() {
			$widget_ops = array(
				'classname' => 'widget_nk', 
				'description' => 'Wyświetla wizytówkę z serwisu Nasza-Klasa.pl'
			);
			wp_register_sidebar_widget( 'naszaklasa', 'Nasza Klasa', 
				array( &$this, 'widget_nk' ), $widget_ops );
			wp_register_widget_control( 'naszaklasa', 'Nasza Klasa', 
				array( &$this, 'widget_nk_control' ) );
		}
		
		function widget_nk( $args ) {
			extract( $args );
			$options = get_option('widget_nasza_klasa');
			$title = apply_filters('widget_title', $options['title']);
			if ( empty($title) )
				$title = '&nbsp;';
			if ( empty($link) )
				$link = '';
			echo $before_widget . $before_title . $title . $after_title;
			echo '<div id="nasza_klasa_wrap">';
			echo '<script width="180" id="nk_card" type="text/javascript" charset="UTF-8" src="';
			echo str_replace( '/card/', '/card/js/', $options['link'] );
			echo '"></script>';
			echo '<div style="text-align:center">W wyświetlaniu wizytówki pomaga serwis <a href="http://www.poradnik-webmastera.com/">Poradnik Webmastera</a>.</div>';
			echo '</div>';
			echo $after_widget;
		}
		
		function widget_nk_control() {
			$options = $newoptions = get_option('widget_nasza_klasa');
			if ( isset($_POST['nk-submit']) ) {
				$newoptions['title'] = strip_tags(stripslashes($_POST['nk-title']));
				$newoptions['link'] = strip_tags(stripslashes($_POST['nk-link']));
			}
			if ( $options != $newoptions ) {
				$options = $newoptions;
				update_option('widget_nasza_klasa', $options);
			}
			$title = empty( $options['title'] ) ? '&nbsp;' : attribute_escape($options['title']);
			$link = empty( $options['link'] ) ? '' : attribute_escape($options['link']);
		?>
		<p><label for="nk-title"><?php _e('Title:'); ?> <input class="widefat" id="nk-title" name="nk-title" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="nk-link">Link do wizytówki (znajdziesz go <a href="http://nasza-klasa.pl/profile/card/edit">na tej stronie</a>) : <input class="widefat" id="nk-link" name="nk-link" type="text" value="<?php echo $link; ?>" /></label></p>
		<input type="hidden" id="nk-submit" name="nk-submit" value="1" />
		<?php
		}
	}
	
	$wp_nasza_klasa_wizytowka = new NaszaKlasaWizytowka();
}

?>
