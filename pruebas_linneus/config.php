<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------
$config =array(
		"base_url" => "http://dspcommunity.com/citroen/pruebas_linneus/hybridauth/index.php", 
		"providers" => array ( 

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "735102986325-epg2d63vp4ogouikuiea1nk97u2fgmlf.apps.googleusercontent.com", "secret" => "3tOjU2ZbW0PTMyu3XRtMJ4Fk" ), 
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "325668877613094", "secret" => "8205c8020578c4e1a2ff0aabd92cb351" ),
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "1EG3w6AhvUVV58NadLANWdGRD", "secret" => "pw2DOJ5vFINy3QNK2lVq8rUA2WqAd29LyNWg1fwEG3TkcnXMPk" ) 
			),
		),
		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,
		"debug_file" => "",
	);
