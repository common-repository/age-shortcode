<?php
/*
Plugin Name: Age Shortcode
Plugin URI: http://www.tobi-mobile.de/plugins/age-shortcode
Description: This plugin adds the shortcode <b>[age]</b>. About this shortcode the age of the author is given. <em>Importantly, registered in the profile, a date of birth.</em>
Version: 1.2.1
Author: Tobias Kraft
Author URI: http://www.tobi-mobile.de
Domain Path: /languages/
License: GPL2


	LICENSE
	============================================================================
	Copyright 2013  Tobias Kraft  (email : info@tobi-mobile.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	============================================================================
	

	PlugIn Schutz innerhalb Wordpress */

if ( !function_exists('add_action') ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

/* 	PlugIn Klasse */
if ( !class_exists( 'BirtdayShort' ) ) {

	define( "ASDOMAIN", "age_short" );
	
	class BirthdayShort {
	
		// Constructor
		function BirthdayShort() {
			add_action( 'init', array(&$this, 'text_domain'), 10 );
			add_filter( 'user_contactmethods', array(&$this, 'modify_user_contact_methods'), 11 );
			add_shortcode( 'age', array(&$this, 'getAlter'), 12 );
		
		}
		
		function text_domain() {
			
			load_plugin_textdomain( ASDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		// Geburtstagsfeld hinzufügen
		function modify_user_contact_methods( $user_contact ) {
		
			$user_contact['birthday'] = __( 'Geburtstag <em>(Bsp. 01.02.1970)</em>', ASDOMAIN );
			return $user_contact;
		
		}
		
		// Alter berrechnen
		function getAlter(){
		
			$author_birth = get_the_author_meta( 'birthday' );
			$age = explode( ".", $author_birth );
			$alter = date( "Y", time() )-$age[2];
			if ( date("m",time()) < $age[1] || date("d",time()) < $age[0] )
			$alter--;
			return $alter;
		}
	}
	
	//Klasse erstellen
	function as_start() {
	
		new BirthdayShort();
	
	}
	
	add_action( 'plugins_loaded', 'as_start' );
}
?>